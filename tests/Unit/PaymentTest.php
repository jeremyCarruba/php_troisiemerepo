<?php

namespace Tests\Unit;

use App\Mail\PaymentMade;
use App\Mail\PaymentMadeAuthor;
use Tests\TestCase;
use App\Models\Donation;
use App\Models\Project;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

class PaymentTest extends TestCase
{

    use \Illuminate\Foundation\Testing\DatabaseMigrations;
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testIfAssociatedToDonation()
    {
        $donation = Donation::factory()->create();
        $payment = Payment::factory()->create(['donation_id' => $donation->id]);
        $this->assertInstanceOf(Donation::class, $payment->donation);
    }

    public function testIfDonationCanHaveMultiplePayments(){
        $donation = Donation::factory()->create(['amount' => 100000]);
        $payment = Payment::factory()->create(['donation_id' => $donation->id, 'amount' => 100]);

        foreach($donation->payments as $payment){
            $this->assertInstanceOf(Payment::class, $payment);
        }
    }

    public function testIfPaymentCantTopDonation(){
        $donation = Donation::factory()->create(['amount' => 100]);
        $payment = Payment::factory()->create(['donation_id' => $donation->id, 'amount' => 105]);
        $this->assertEmpty($donation->payments);

        $payment1 = Payment::factory()->create(['donation_id' => $donation->id, 'amount' => 89]);

        foreach($donation->payments as $payment){
            $this->assertInstanceOf(Payment::class, $donation->payments);
        }
    }

    public function testPayingADonationAlreadyPaid(){
        $donation = Donation::factory()->create(['status' => 1]);
        $payment = Payment::factory()->create(['donation_id' => $donation->id, 'amount' => 30]);
        $this->assertEmpty($donation->payments);
    }

    public function testMailSent(){
        Mail::fake();
        $author = User::factory()->create();
        $payer = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $author->id]);
        $donation = Donation::factory()->create(['user_id' => $payer->id, 'project_id' => $project->id]);
        $payment = [
            'donation_id' => $donation->id,
            'amount' => 30,
        ];
        $reponse = $this->actingAs($payer)
                    ->post('/paiement', $payment);

        Mail::assertSent(PaymentMade::class, function ($mail) use ($payer) {
            return $mail->hasTo($payer->email);
        });

        Mail::assertSent(PaymentMadeAuthor::class, function ($mail) use ($author) {
            return $mail->hasTo($author->email);
        });
    }
}

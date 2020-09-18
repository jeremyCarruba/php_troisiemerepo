<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Donation;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
}

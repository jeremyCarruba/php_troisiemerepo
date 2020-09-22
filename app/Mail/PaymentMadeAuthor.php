<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Payment;

class PaymentMadeAuthor extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
       $this->payment = $payment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $totalCollected = 0;
        foreach($this->payment->donation->project->donations as $donation){
            $totalCollected = $totalCollected + $donation->amountPaid;
        }
        return $this->from('monculsurlacommode@gmail.com')->view('mailAuthor')
            ->with(['totalCollected' => $totalCollected]);
    }
}

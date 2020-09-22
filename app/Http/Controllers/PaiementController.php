<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Donation;
use App\Mail\PaymentMade;
use App\Mail\PaymentMadeAuthor;
use Illuminate\Support\Facades\Mail;

class PaiementController extends Controller
{
    public function index(){
        return view('payment');
    }

    public function store(Request $request)
    {
        $thisDonation=Donation::find($request['donation_id']);
        $leftToPay = $thisDonation->amount - $thisDonation->amountPaid;
        if($thisDonation->status !== 1 && $request['amount']<=$leftToPay){
            $payment = Payment::create([
                'donation_id' => $request['donation_id'],
                'amount' => $request['amount'],
            ]);
            $payer = $payment->donation->user;
            $author = $payment->donation->project->user;
            var_dump($payer->email, $author->email);
            Mail::to($payer)
                ->send(new PaymentMade($payment));
            Mail::to($author)
                ->send(new PaymentMadeAuthor($payment));
            return redirect('/project');
        } else {
            abort(401);
        }
    }
}

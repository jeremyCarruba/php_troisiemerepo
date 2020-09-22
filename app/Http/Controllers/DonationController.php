<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Donation;
use App\Support\DonationFee;



class DonationController extends Controller
{
    public function store(Request $request)
    {
        if(Auth::check()) {
            $donationFee = new DonationFee($request['amount'], 10);

            $donation = Donation::create([
                'amount' => $donationFee->getAmountCollected(),
                'project_id' => $request['project_id'],
                'user_id' => Auth::id(),
            ]);
            return response()
            ->view('/donation-create', ['donation' => $donation, 'summary' => $donationFee->getSummary()], 201);
        } else {
            abort(401);
        }

    }
}

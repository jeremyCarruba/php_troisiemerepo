<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Donation;



class DonationController extends Controller
{
    public function store(Request $request)
    {
        if(Auth::check()) {
            $donation = Donation::create([
                'amount' => $request['amount'],
                'project_id' => $request['project_id'],
                'user_id' => Auth::id(),
            ]);
            return view('/donation-create', ['donation' => $donation]);
        } else {
            abort(401);
        }

    }
}

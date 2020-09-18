<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public function __construct(array $attributes)
    {
    var_dump($attributes);
    $thisDonation = Donation::find($attributes["donation_id"]);
    $leftToPay = $thisDonation->amount - $thisDonation->amountPaid;
        if($attributes['amount']< $leftToPay){
            parent::__construct($attributes);
        }
    }


    public function donation() {
        return $this->belongsTo(Donation::class, 'donation_id');
    }
}

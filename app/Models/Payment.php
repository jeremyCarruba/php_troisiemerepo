<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $thisDonation = Donation::find($model->donation_id);
            if($thisDonation->status ==1){
                echo 'deleting event';
                return false;
            }

            $leftToPay = ($thisDonation->amount) - ($thisDonation->amountPaid);
            if($model->amount > $leftToPay){
                echo 'deleting event';
                return false;
            }

            if($model->amount == $leftToPay){
                $thisDonation->status == 1;
            }
            $thisDonation->amountPaid = $thisDonation->amountPaid + $model->amount;
            $thisDonation->save();
        });
    }


    public function donation() {
        return $this->belongsTo(Donation::class, 'donation_id');
    }
}

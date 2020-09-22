<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_id',
        'amount'
    ];

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

            $thisDonation->amountPaid = $thisDonation->amountPaid + $model->amount;
            if($thisDonation->amountPaid == $thisDonation->amount){
                $thisDonation->status = 1;
            }
            $thisDonation->save();
        });
    }


    public function donation() {
        return $this->belongsTo(Donation::class, 'donation_id');
    }
}

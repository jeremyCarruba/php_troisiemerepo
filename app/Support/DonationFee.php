<?php

namespace App\Support;

use Exception;

class DonationFee
{

    private $donation;
    private $commissionPercentage;
    const FIXEDFEE = 50;

    public function __construct(int $donation, int $commissionPercentage)
    {
        if($donation >= 100) {
            if($commissionPercentage <= 30 && $commissionPercentage > 0) {
                $this->donation = $donation;
                $this->commissionPercentage = $commissionPercentage;
            } else {
                throw new Exception('La commission doit être comprise entre 0 et 30 pourcents');
            }
        } else {
            throw new Exception('La donation doit être supérieur à 1euro');
        }
    }

    public function getCommissionAmount()
    {
        return $this->donation * ($this->commissionPercentage/100);
    }

    public function getFixedAndCommissionFeeAmount()
    {
        $amountForSite = $this->donation * ($this->commissionPercentage/100) + self::FIXEDFEE;
        if($amountForSite > 500) {
            $amountForSite = 500;
        }
        return $amountForSite;
    }

    public function getAmountCollected()
    {
        return $this->donation-$this->getFixedAndCommissionFeeAmount();
    }

    public function getSummary() {
        $summary = [
            'donation' => $this->donation,
            'fixedFee' => self::FIXEDFEE,
            'commission' => $this->getCommissionAmount(),
            'fixedAndCommission' => $this->getFixedAndCommissionFeeAmount(),
            'amountCollected' => $this->getAmountCollected()
        ];

        return $summary;
    }
}

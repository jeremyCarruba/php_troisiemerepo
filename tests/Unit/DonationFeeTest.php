<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Support\DonationFee;
use Exception;


class DonationFeeTest extends TestCase
{

    public function testCommissionAmountIs10CentsFormDonationOf100CentsAndCommissionOf10Percent()
    {
        // Etant donné une donation de 100 et commission de 10%
        $donationFees = new \App\Support\DonationFee(100, 10);

        // Lorsque qu'on appel la méthode getCommissionAmount()
        $actual = $donationFees->getCommissionAmount();

        // Alors la Valeur de la commission doit être de 10
        $expected = 10;
        $this->assertEquals($expected, $actual);
    }

    public function testCommissionAmountIs20CentsFormDonationOf200CentsAndCommissionOf10Percent()
    {
        // Etant donné une donation de 100 et commission de 10%
        $donationFees = new \App\Support\DonationFee(200, 10);

        // Lorsque qu'on appel la méthode getCommissionAmount()
        $actual = $donationFees->getCommissionAmount();

        // Alors la Valeur de la commission doit être de 20
        $expected = 20;
        $this->assertEquals($expected, $actual);
    }

    public function testAmountRecievedForCommision10Donation100()
    {

        $donationFees = new DonationFee(100,10);
        $actual = $donationFees->getAmountCollected();
        $expected = 40;

        $this->assertEquals($expected, $actual);
    }

    public function testAmountRecievedForCommision20Donation200()
    {
        $donationFees = new DonationFee(200,20);
        $actual = $donationFees->getAmountCollected();
        $expected = 110;

        $this->assertEquals($expected, $actual);
    }

    public function testCommissionTooHigh(){
            $this->expectException(Exception::class);
            $donationFees = new DonationFee(200, 35);       
    }

    public function testCommissionTooLow(){
            $this->expectException(Exception::class);
            $donationFees = new DonationFee(200, -20);       
    }

    public function testDonationTooLow(){
            $this->expectException(Exception::class);
            $donationFees = new DonationFee(80, 10); 
    }

    public function testCommissionAndFeeAmountCommission10Donation100 (){
        $donationFees = new DonationFee(100,10);
        $actual = $donationFees->getFixedAndCommissionFeeAmount();
        $expected = 60;

        $this->assertEquals($expected, $actual);
    }

    public function testCommissionAndFeeAmountCommission20Donation200 (){
        $donationFees = new DonationFee(200,20);
        $actual = $donationFees->getFixedAndCommissionFeeAmount();
        $expected = 90;
        
        $this->assertEquals($expected, $actual);
    }

    public function testIfAmountForSiteIsSuperiorTo500(){
        $donationFees = new DonationFee(50000,30);
        $actual = $donationFees->getFixedAndCommissionFeeAmount();
        $expected = 500;

        $this->assertEquals($expected, $actual);
    }

    public function testSummary(){
        $donationFees = new DonationFee(100,10);
        $actual = $donationFees->getSummary();
        $expected= [
            'donation' => 100,
            'fixedFee' => 50,
            'commission' => 10,
            'fixedAndCommission' => 60,
            'amountCollected' => 40
        ];

        $this->assertEquals($expected, $actual);
    }
}

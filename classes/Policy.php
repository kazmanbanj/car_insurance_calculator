<?php

class Policy {
    private $carValue, $taxPercent, $installment, $basePrice;

    public function __construct($carValue, $taxPercent, $installment, $basePrice)
    {
        $this->carValue = $carValue;
        $this->taxPercent = $taxPercent;
        $this->installment = $installment;
        $this->basePrice = $basePrice;
    }

    public function carInsuredValue()
    {
        return str_replace(',', '', number_format($this->carValue, 2));
    }

    public function basePremium()
    {        
        return str_replace(',', '', number_format(($this->carValue * $this->basePrice / 100), 2));
    }

    public function commission()
    {
        return str_replace(',', '', number_format(($this->basePremium() * 0.17), 2));
    }

    public function tax()
    {
        return str_replace(',', '', number_format(($this->basePremium() * $this->taxPercent / 100), 2));
    }

    public function installmentBasePremium()
    {
        return str_replace(',', '', number_format(($this->basePremium() / $this->installment), 2));
    }

    public function installmentCommission()
    {
        return str_replace(',', '', number_format(($this->commission() / $this->installment), 2));
    }

    public function installmentTax()
    {
        return str_replace(',', '', number_format(($this->tax() / $this->installment), 2));
    }

    public function calculateTotalCost()
    {
        return str_replace(',', '', number_format(($this->basePremium() + $this->commission() + $this->tax()), 2));
    }

    public function calculateTotalInstallment()
    {
        return str_replace(',', '', number_format(($this->installmentBasePremium() + $this->installmentCommission() + $this->installmentTax()), 2));
    }
}
?>
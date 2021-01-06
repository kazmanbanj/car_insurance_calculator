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

    // getting the car value and formatting to 2 decimal places
    public function carInsuredValue()
    {
        return str_replace(',', '', number_format($this->carValue, 2));
    }

    // getting the base premium value
    public function basePremium()
    {        
        return str_replace(',', '', number_format(($this->carValue * $this->basePrice / 100), 2));
    }

    // getting the commission value
    public function commission()
    {
        return str_replace(',', '', number_format(($this->basePremium() * 0.17), 2));
    }

    // getting the tax value
    public function tax()
    {
        return str_replace(',', '', number_format(($this->basePremium() * $this->taxPercent / 100), 2));
    }

    // getting the installment base premium
    public function installmentBasePremium()
    {
        return str_replace(',', '', number_format(($this->basePremium() / $this->installment), 2));
    }

    // getting the installment commission
    public function installmentCommission()
    {
        return str_replace(',', '', number_format(($this->commission() / $this->installment), 2));
    }

    // getting the installment tax
    public function installmentTax()
    {
        return str_replace(',', '', number_format(($this->tax() / $this->installment), 2));
    }

    // obtaining the total policy cost
    public function CalculateTotalCost()
    {
        // Total cost of the policy (exluding car value)
        return str_replace(',', '', number_format(($this->basePremium() + $this->commission() + $this->tax()), 2));
    }

    // obtaining the total installment cost
    public function CalculateTotalInstallment()
    {
        // Total cost of the installmental payment
        return str_replace(',', '', number_format(($this->installmentBasePremium() + $this->installmentCommission() + $this->installmentTax()), 2));
    }
}
?>
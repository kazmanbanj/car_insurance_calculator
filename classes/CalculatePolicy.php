<?php

class CalculatePolicy {
    private $carValue, $taxPercent, $installment, $basePercent;

    public function __construct($carValue, $taxPercent, $installment, $basePercent)
    {
        $this->carValue = $carValue;
        $this->taxPercent = $taxPercent;
        $this->installment = $installment;
        $this->basePercent = $basePercent;
    }

    // getting the base percentage
    public function basePercent()
    {
        return $this->basePercent;
    }

    // getting the car value and formatting to 2 decimal places
    public function carInsuredValue()
    {
        return str_replace(',', '', number_format($this->carValue, 2));
    }

    // getting the base premium value
    public function basePremium()
    {        
        $carValue = $this->carValue * $this->basePercent / 100;        
        return str_replace(',', '', number_format($carValue, 2));
    }

    // getting the commission value
    public function commission()
    {
        $calcCommission = $this->basePremium() * 0.17;
        return str_replace(',', '', number_format($calcCommission, 2));
    }

    // getting the tax value
    public function tax()
    {
        $calcTax = $this->basePremium() * $this->taxPercent / 100;
        return str_replace(',', '', number_format($calcTax, 2));
    }

    // getting the installment base premium
    public function installBasePremium()
    {
        return str_replace(',', '', number_format(($this->basePremium() / $this->installment), 2));
    }

    // getting the installment commission
    public function installCommission()
    {
        return str_replace(',', '', number_format(($this->commission() / $this->installment), 2));
    }

    // getting the installment tax
    public function installTax()
    {
        return str_replace(',', '', number_format(($this->tax() / $this->installment), 2));
    }

    // obtaining the total policy cost
    public function totalCost()
    {
        // Total cost of the policy (exluding car value)
        $total = $this->basePremium() + $this->commission() + $this->tax();
        return str_replace(',', '', number_format($total, 2));
    }

    // obtaining the total installment cost
    public function totalInstall()
    {
        // Total cost of the installmental payment
        $total = $this->installBasePremium() + $this->installCommission() + $this->installTax();
        return str_replace(',', '', number_format($total, 2));
    }
}
?>
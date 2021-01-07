<?php

function error($msg)
{
    $response = array("status" => "400", "message" => $msg);
    return json_encode($response);
}

function validates($carValue, $taxPercent, $installment)
{
        if ($carValue == '' || $taxPercent == '' || $installment == '') {
            die(error('<b>Please, all fields are required.</b>'));
        }
        
        if ($carValue < 10000 || $carValue > 1000000) {
            die(error('<b>Please, car value must be between the range of 10,000 NGN and 1,000,000 NGN.</b>'));
        }
    
        if ($taxPercent < 0 || $taxPercent > 100) {
            die(error('<b>Please, tax percent must be between the range of 0 and 100.</b>'));
        }
    
        if ($installment < 1 || $installment > 12) {
            die(error('<b>Please, installment payment must be between the range of 1 ad 12.</b>'));
        }
}

function prepareData($carPolicy, $taxPercent, $installment, $basePrice)
{
    return array (
        "installment" => $installment,
        "car_value" => $carPolicy->carInsuredValue(),
        "base_price" => $basePrice,
        "base_premium" => $carPolicy->basePremium(),
        "installment_base_premium" => $carPolicy->installmentBasePremium(),
        "commission" => $carPolicy->commission(),
        "installment_commission" => $carPolicy->installmentCommission(),
        "tax_percent" => $taxPercent,
        "tax" => $carPolicy->tax(),
        "installment_tax" => $carPolicy->installmentTax(),
        "total_cost" => $carPolicy->calculateTotalCost(),
        "total_installment" => $carPolicy->calculateTotalInstallment()
    );
}

?>
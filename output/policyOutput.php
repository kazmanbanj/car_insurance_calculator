<?php
    include '../classes/Policy.php';
    include '../lib/helpers.php';

    $carValue = $_POST['carValue'];
    $taxPercent = $_POST['taxPercent'];
    $installment = $_POST['installment'];
    $basePrice = $_POST['basePrice'];

    validates($carValue, $taxPercent, $installment);

    $carPolicy = new Policy($carValue, $taxPercent, $installment, $basePrice);

    $data = prepareData($carPolicy, $taxPercent, $installment, $basePrice);
    
    $response = array("status" => "200", "message" => $data);

    echo json_encode($response);

?>
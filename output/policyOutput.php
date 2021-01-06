<?php
    // including the calculator logic in PHP built using OOP
    include '../classes/Policy.php';
    
    // declaring an error function to display a validation error message to the user if any
    function error($msg)
    {
        $response = array("success" => false, "message" => $msg);
        // encoding to json format.
        return json_encode($response);
    }

    // accessing the user input (gotten from script.js)
    $carValue = $_POST['carValue'];
    $taxPercent = $_POST['taxPercent'];
    $installment = $_POST['installment'];
    $specificDate = $_POST['specificDate'];

    // setting the Base price of policy when it is 11% or 13%. (13% is used every Friday 15-20 O’clock (user time))
    if ($specificDate >= 'Friday 15:00:00' && $specificDate <= 'Friday 20:00:00') {
        $basePrice = 13;
    }
    else {
        $basePrice = 11;
    }

    // form validation process (checking for any error from the user input)
    if ($carValue == '' || $taxPercent == '' || $installment == '') {
        // this will stop the whole process and display the error message set below
        die(error('<b>Please, fill the empty field.</b>'));
    }
    
    if ($carValue < 10000) {
        die(error('<b>Please, car value must be greater than or equal to 10,000 NGN.</b>'));
    }

    if ($carValue > 1000000) {
        die(error('<b>Please, car value must be less than or equal to 1,000,000 NGN.</b>'));
    }

    if ($taxPercent < 0) {
        die(error('<b>Please, tax percent must be greater than or equal to 0.</b>'));
    }

    if ($taxPercent > 100) {
        die(error('<b>Please, tax percent must be less than or equal to 100.</b>'));
    }

    if ($installment < 1) {
        die(error('<b>Please, installment payment must be greater than or equal to 1.</b>'));
    }

    if ($installment > 12) {
        die(error('<b>Please, installment payment must be less than or equal to 12.</b>'));
    }

    // instantiating the CalculatePolicy class as an object
    $calculate = new Policy($carValue, $taxPercent, $installment, $basePrice);

    // displaying result to the user     
    $message = "
            <h3><u>Output</u></h3>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Policy</th>";
                        // looping through the number of installment payments the user entered
                        for($count=1; $count <= $installment; $count+=1) {
                            $message .= '<th>'.$count.' instalment</th>';                         
                        };
                        // end of looping
                        
    $message .= "
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Value </td>
                        <td>". $calculate->carInsuredValue() . "</td>";
                        // looping through the number of installment payments the user entered
                        for($count=1; $count <= $installment; $count+=1) {
                            $message .= '<td></td>';                         
                        };  
                        // end of looping                  
                    
    $message .= "
                    </tr>
                    <tr>
                        <td>Base premium (". $basePrice. "%)</td>
                        <td>". $calculate->basePremium(). "</td>";
                        // looping through the number of installment payments the user entered
                        for($count=1; $count <= $installment; $count+=1) {
                            $message .= '<td>'.$calculate->installmentBasePremium().'</td>';                         
                        };
                        // end of looping
                    
    $message .= "
                    </tr>
                    <tr>
                        <td>Commission (17%)</td>
                        <td>". $calculate->commission(). "</td>";
                        // looping through the number of installment payments the user entered
                        for($count=1; $count <= $installment; $count+=1) {
                            $message .= '<td>'.$calculate->installmentCommission().'</td>';                         
                        };
                        // end of looping
                    
    $message .= "
                    </tr>
                    <tr>
                        <td>Tax (". $taxPercent. "%)</td>
                        <td>". $calculate->tax(). "</td>";
                        // looping through the number of installment payments the user entered
                        for($count=1; $count <= $installment; $count+=1) {
                            $message .= '<td>'.$calculate->installmentTax().'</td>';                         
                        };
                        // end of looping
                    
    $message .= "
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total cost</th>
                        <th>". $calculate->CalculateTotalCost() ."</th>";
                        // looping through the number of installment payments the user entered
                        for($count=1; $count <= $installment; $count+=1) {
                            $message .= '<td>'.$calculate->CalculateTotalInstallment().'</td>';                         
                        };
                        // end of looping
                        
    $message .= "
                    </tr>
                </tfoot>
            </table>
        ";

    // on success of the data above, the response is interpreted into php array
    $response = array();

    // passing the message variable
    $response["success"] = true;
    $response["message"] = $message;

    // echoing out the encoded response in JSON representation
    echo json_encode($response);

?>
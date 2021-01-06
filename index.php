<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Car Insurance Calculator</title>
    <link rel="stylesheet" href="./resources/style.css">
</head>

<body>
    <h2>Car Insurance Calculator</h2>
    <u>
        <h3>This simple car insurance calculator will output price of the policy.</h3>
    </u>
    
    <!-- user input form field -->
    <form id="policy_form">
        <fieldset>
            <legend><b>Car Insurance Calculator:</b></legend>
            <div>
                <label for="car_value">Estimated Car Value (10,000 - 1,000,000 NGN):</label>
                <input type="number" name="car_value" id="car_value" min="10000" max="1000000" value="10000">
            </div>
            <br>
            <div>
                <label for="tax_percent">Tax Percentage (0 - 100%):</label>
                <input type="number" name="tax_percent" id="tax_percent" min="0" max="100" value="0">
            </div>
            <br>
            <div>
                <label for="installment">Number of Installmental Payments (1 - 12):</label>
                <select name="installment" id="installment">
                    <option value="1" selected>1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </div>
            <br>
            <input type="submit" value="Calculate" id="calculateBtn" />
        </fieldset>
    </form>

    <!-- loading spinner -->
    <div class="loader"></div>

    <!-- Result display -->
    <div id="policyResult"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./resources/script.js"></script>
</body>

</html>
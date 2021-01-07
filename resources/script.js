$(document).ready(function () {
    $("#policy_form").submit(function (e) { 
        e.preventDefault();

        // show loading spinner when processing request
        $(".loader").show();

        // assigning the user input to a variable
        var carValue = $("#car_value").val();
        var taxPercent = $("#tax_percent").val();
        var installment = $("#installment").val();
        var basePrice = 11;

        // accessing the user time
        var d = new Date();
        var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
        var day = days[d.getDay()];
        var hours = d.getHours();
        var minutes = d.getMinutes();
        var seconds = d.getSeconds();

        // where base price is 13% every Friday 15-20 O’clock (user time)
        var specificDate = day + ' ' + hours + ':' + minutes + ':' + seconds;
        if (specificDate >= 'Friday 15:00:00' && specificDate <= 'Friday 20:00:00') {
            basePrice = 13;
        };
        
        // sending an ajax post request to a local server (policyOutput.php) to process the user input
        $.post("./output/policyOutput.php",
            {
                carValue: carValue,
                taxPercent: taxPercent,
                installment: installment,
                basePrice: basePrice
            },
            function(response){
                // hide loading spinner when processing completed
                $(".loader").hide();

                // setting the html content for display
                var data = JSON.parse(response);
                if (data.status == "200") {
                    // looping through the number of installment for installment columns
                    var i = 1;
                    var len = data.message.installment;
                    var installment = "";
                    for (; i <= len; i++) {
                        installment += '<th>' + i +  ' installment</th>';
                    }

                    // looping through the number of installment for value
                    var i = 1;
                    var len = data.message.installment;
                    var empty = "";
                    for (; i <= len; i++) {
                        empty += '<td></td>';
                    }

                    // looping through the number of installment for installment base premium
                    var i = 1;
                    var len = data.message.installment;
                    var installment_base_premium = "";
                    for (; i <= len; i++) {
                        installment_base_premium += '<td>' + data.message.installment_base_premium + '</td>';
                    }

                    // looping through the number of installment for installment commission
                    var i = 1;
                    var len = data.message.installment;
                    var installment_commission = "";
                    for (; i <= len; i++) {
                        installment_commission += '<td>' + data.message.installment_commission + '</td>';
                    }

                    // looping through the number of installment for installment tax
                    var i = 1;
                    var len = data.message.installment;
                    var installment_tax = "";
                    for (; i <= len; i++) {
                        installment_tax += '<td>' + data.message.installment_tax + '</td>';
                    }

                    // looping through the number of installment for total installment
                    var i = 1;
                    var len = data.message.installment;
                    var total_installment = "";
                    for (; i <= len; i++) {
                        total_installment += '<th>' + data.message.total_installment + '</th>';
                    }

                    // setting the policy html template to display
                    var policyHtmlTemplate = `\
                        <h3><u>Output</u></h3>\
                        <table>\
                            <thead>\
                                <tr>\
                                    <th></th>\
                                    <th>Policy</th>\
                                    ${installment}\
                                </tr>\
                            </thead>\
                            <tbody>\
                                <tr>\
                                    <td>Value </td>\
                                    <td>${data.message.car_value}</td>\
                                    ${empty}\
                                </tr>\
                                <tr>\
                                    <td>Base premium (${data.message.base_price}%)</td>\
                                    <td>${data.message.base_premium}</td>\
                                    ${installment_base_premium}\
                                </tr>\
                                <tr>\
                                    <td>Commission (17%)</td>\
                                    <td>${data.message.commission}</td>\
                                    ${installment_commission}\
                                </tr>\
                                <tr>\
                                    <td>Tax (${data.message.tax_percent}%)</td>\
                                    <td>${data.message.tax}</td>\
                                    ${installment_tax}\
                                </tr>\
                            </tbody>\
                            <tfoot>\
                                <tr>\
                                    <th>Total cost</th>\
                                    <th>${data.message.total_cost}</th>\
                                    ${total_installment}\
                                </tr>\
                            </tfoot>\
                        </table>\
                    `;

                    // on success
                    $("#policyResult").html(policyHtmlTemplate);

                    // setting the input values back to default after completing process
                    $("#car_value").val(10000);
                    $("#tax_percent").val(0);
                    $("#installment").val(1);
                } 
                else if (data.status == "400") {
                    // on fail
                    $("#policyResult").html('failed: ' + error);
                }                                
            }
        );
    })    
})
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

                // setting the html content of the selected element for display
                var data = JSON.parse(response);

                try {
                    if (data.status == "200") {
                    // displaying result to the user
                    var policyHtmlTemplate = `\
                            <h3><u>Output</u></h3>\
                            <table>\
                                <thead>\
                                    <tr>\
                                        <th></th>\
                                        <th>Policy</th>\
                                        <th>${data.message.installment} installment</th>\
                                    </tr>\
                                </thead>\
                                <tbody>\
                                    <tr>\
                                        <td>Value </td>\
                                        <td> ${data.message.car_value} </td>\
                                        <td></td>\
                                    </tr>\
                                    <tr>\
                                        <td>Base premium (${data.message.base_price}%)</td>\
                                        <td>${data.message.base_premium}</td>\
                                        <td>${data.message.installment_base_premium}</td>\
                                    </tr>\
                                    <tr>\
                                        <td>Commission (17%)</td>\
                                        <td>${data.message.commission}</td>\
                                        <td>${data.message.installment_commission}</td>\
                                    </tr>\
                                    <tr>\
                                        <td>Tax (${data.message.tax_percent}%)</td>\
                                        <td>${data.message.tax}</td>\
                                        <td>${data.message.installment_tax}</td>\
                                    </tr>\
                                </tbody>\
                                <tfoot>\
                                    <tr>\
                                        <th>Total cost</th>\
                                        <th>${data.message.total_cost}</th>\
                                        <td>${data.message.total_installment}</td>\
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
                } catch(err) {
                    if (data.status == "400") {
                        // on fail
                        $("#policyResult").html(err.message);
                    }
                }                
            }
        );
    })
    
})
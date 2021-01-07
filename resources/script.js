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

        // setting the Base price to 13%. (13% is used every Friday 15-20 O’clock (user time))
        if (specificDate >= 'Friday 15:00:00' && specificDate <= 'Friday 20:00:00') {
            basePrice = 13;
        };
        
        // sending an ajax post request to a local server (policyOutput.php) to process the user input
        $.post("./output/policyOutput.php",
            {
                // accessing the user input from above
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

                if (!data.message) {
                    // on fail
                    $("#policyResult").html('failed:' + error);
                } else {
                    // on success of the data above, the response is interpreted into JSON representation
                    $("#policyResult").html(data.message);

                    // setting the input values back to default after completing process
                    $("#car_value").val(10000);
                    $("#tax_percent").val(0);
                    $("#installment").val(1);
                }                
            }
        );
    })
    
})
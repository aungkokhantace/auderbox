$().ready(function() {
    // validation for customer-entry
//discount
    $("#discount").validate({
        rules: {
            name: "required",
            from_date: {
                required: true,
                number: true
            },
            to_date: {
                required: true,
                email: true
            },
            amount: "required"

        },
        messages: {
            name: "Member Name is required",
            from_date: {
                required: "Phone is required",
                number: "Phone Number should be number only"
            },

            to_date: "Please enter a valid email address",
            amount: "Birthday is required",

        }
    });



});


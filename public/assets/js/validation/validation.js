$().ready(function() {
    // validation for customer-entry
    $("#customer-entry").validate({
        rules: {
            name: "required",
            phone: {
                required: true,
                number: true
            },
            email: {
                required: true,
                email: true
            },
            birthday: "required",
            food:"required"
        },
        messages: {
            name: "Member Name is required",
            phone: {
                required: "Phone is required",
                number: "Phone Number should be number only"
            },
            email: "Please enter a valid email address",
            birthday: "Birthday is required",
            food: "Favourite Item is required"
        }
    });



});


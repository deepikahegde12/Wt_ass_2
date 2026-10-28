
$(document).ready(function () {

    // Display the current year
    $("#year").text(new Date().getFullYear());

    // Set the maximum date of birth to today
    $("#dob").attr("max", new Date().toISOString().split("T")[0]);

    // Validate the form before sending it to PHP
    $("#registrationForm").on("submit", function (event) {
        const phone = $("#phone").val().trim();
        const name = $("#name").val().trim();
        const address = $("#address").val().trim();

        $("#message").text("");

        if (name === "" || address === "") {
            event.preventDefault();
            $("#message").text("Please fill in all required fields.");
            return;
        }

        if (!/^[0-9]{10}$/.test(phone)) {
            event.preventDefault();
            $("#message").text(
                "Please enter a valid 10-digit phone number."
            );
            return;
        }

        if (!$("#declaration").is(":checked")) {
            event.preventDefault();
            $("#message").text(
                "Please confirm the declaration before submitting."
            );
        }
    });

    // Clear validation messages when the form is reset
    $("#registrationForm").on("reset", function () {
        $("#message").text("");
    });

});

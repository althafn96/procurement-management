jQuery(document).ready(function () {
    var _buttonSpinnerClasses = "spinner spinner-right spinner-white pr-15";
    var btn = $(".create-btn");

    $("body").on("click", ".create-btn, .back-btn", function () {
        $(this)
            .prop("disabled", true)
            .html("Please wait")
            .addClass(_buttonSpinnerClasses);
    });
});

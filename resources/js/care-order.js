window.$(document).ready(function () {
    window.$("#use-hotel").change(function () {
        if (window.$(this).is(":checked")) {
            window.$("#hotel-service-show").fadeIn();
        } else {
            window.$("#from_datetime").val("mm/dd/yyyy --:-- --");
            window.$("#to_datetime").val("mm/dd/yyyy --:-- --");

            window.$("#hotel-service-show").fadeOut();
        }
    });
});

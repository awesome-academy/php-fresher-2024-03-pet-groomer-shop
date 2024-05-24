const careOrder = {
    setOrderStatus: function (orderStatusID, statusID) {
        // eslint-disable-next-line no-undef
        $.ajax({
            method: "PATCH",
            url: "/care-order-manage/" + orderStatusID,
            data: {
                order_status: statusID,
            },
            success: function () {
                window.location.reload();
            },
            error: function () {
                window.location.reload();
            },
        });
    },
};

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

    window.$(".order_status_select").on("change", function () {
        const statusID = window.$(this).val();
        const orderStatusID = window.$(this).attr("name").split("_").splice(-1);
        careOrder.setOrderStatus(orderStatusID, statusID);
    });
});

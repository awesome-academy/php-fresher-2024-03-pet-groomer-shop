const careOrderHistory = {
    cancelOrder: function (careOrderID) {
        // eslint-disable-next-line no-undef
        Swal.fire({
            title: window.trans("alert.cancel_title"),
            text: window.trans("alert.cancel_content"),
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: window.trans("alert.cancel"),
        }).then((result) => {
            if (result.isConfirmed) {
                const url = "/customer/care-order-history/" + careOrderID;
                // eslint-disable-next-line no-undef
                $.ajax({
                    method: "PATCH",
                    url: url,
                    success: function () {
                        window
                            .$("#order_status_" + careOrderID)
                            .text("CANCELLED")
                            .removeClass()
                            .addClass("text-red-500");
                    },
                });
            }
        });
    },
};

window.$(document).ready(function () {
    window.$(document).on("click", ".care-order-cancel", function () {
        careOrderHistory.cancelOrder(window.$(this).data("id"));
    });
});

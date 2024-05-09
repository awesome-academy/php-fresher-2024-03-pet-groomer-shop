const coupon = {
    delete: function (id) {
        // eslint-disable-next-line no-undef
        Swal.fire({
            title: window.trans("alert.delete_title"),
            text: window.trans("alert.delete_content"),
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: window.trans("alert.cancel"),
        }).then((result) => {
            const url = "/coupon/" + id;
            if (result.isConfirmed) {
                // eslint-disable-next-line no-undef
                $.ajax({
                    method: "DELETE",
                    url: url,
                    success: function () {
                        window.location.reload();
                    },
                    error: function () {
                        window.location.reload();
                    },
                });
            }
        });
    },
};

window.coupon = coupon;

window.$(document).ready(function () {
    window.$(document).on("click", ".delete-coupon-btn", function () {
        coupon.delete(window.$(this).data("id"));
    });
});

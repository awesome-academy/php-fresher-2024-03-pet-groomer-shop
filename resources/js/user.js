const user = {
    delete: function (id) {
        // eslint-disable-next-line no-undef
        Swal.fire({
            title: window.trans("alert.delete_title"),
            text: window.trans("alert.delete_content"),
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: window.trans("alert.cancel"),
        }).then((result) => {
            if (result.isConfirmed) {
                const url = "user/" + id;
                // eslint-disable-next-line no-undef
                $.ajax({
                    method: "DELETE",
                    url: url,
                    success: function () {
                        window.location.reload();
                    },
                });
            }
        });
    },
};

window.user = user;

window.$(document).ready(function () {
    window.$(document).on("click", ".delete-user-btn", function () {
        user.delete(window.$(this).data("id"));
    });
});

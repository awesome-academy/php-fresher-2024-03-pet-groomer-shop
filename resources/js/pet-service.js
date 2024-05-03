const petService = {
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
                const url = "/pet-service/" + id;
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

window.petService = petService;

window.$(document).ready(function () {
    window.$(document).on("click", ".delete-pet-service-btn", function () {
        petService.delete(window.$(this).data("id"));
    });
});

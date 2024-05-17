const pet = {
    delete: function (id, userID) {
        // eslint-disable-next-line no-undef
        Swal.fire({
            title: window.trans("alert.delete_title"),
            text: window.trans("alert.delete_content"),
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: window.trans("alert.cancel"),
        }).then((result) => {
            if (result.isConfirmed) {
                const url = "/pet/" + id + "/delete/" + userID;
                // eslint-disable-next-line no-undef
                $.ajax({
                    method: "DELETE",
                    url: url,
                    success: function () {
                        window.location.reload();
                    },
                    error: function (error) {
                        console.error(error);
                    },
                });
            }
        });
    },

    deleteCustomer: function (userID, petID) {
        // eslint-disable-next-line no-undef
        Swal.fire({
            title: window.trans("alert.delete_title"),
            text: window.trans("alert.delete_content"),
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: window.trans("alert.cancel"),
        }).then((result) => {
            if (result.isConfirmed) {
                const url = "/customer/customer/" + userID + "/pet/" + petID;
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

window.pet = pet;

window.$(document).ready(function () {
    window.$(document).on("click", ".delete-pet-btn", function () {
        pet.delete(window.$(this).data("id"));
    });

    window.$(document).on("click", ".delete-customer-pet-btn", function () {
        pet.deleteCustomer(
            window.$(this).data("user-id"),
            window.$(this).data("pet-id")
        );
    });
});

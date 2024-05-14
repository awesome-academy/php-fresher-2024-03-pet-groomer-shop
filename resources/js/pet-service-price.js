const petServicePrice = {
    delete: function (petServiceID, petServicePriceID) {
        // eslint-disable-next-line no-undef
        Swal.fire({
            title: window.trans("alert.delete_title"),
            text: window.trans("alert.delete_content"),
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: window.trans("alert.cancel"),
        }).then((result) => {
            if (result.isConfirmed) {
                const url =
                    "/pet-service/" +
                    petServiceID +
                    "/pet-service-price/" +
                    petServicePriceID;
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
};

window.petServicePrice = petServicePrice;

window.$(document).ready(function () {
    window.$(document).on("click", ".delete-pet-service-price-btn", function () {
        const petServiceID = window.$(this).data("pet-service-id");
        const petServicePriceID = window.$(this).data("id");
        petServicePrice.delete(petServiceID, petServicePriceID);
    });
});

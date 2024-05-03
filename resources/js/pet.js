window.pet = {
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
                // eslint-disable-next-line no-undef
                $.ajax({
                    method: "DELETE",
                    url: ` / pet / ${id} / delete / ${userID}`,
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

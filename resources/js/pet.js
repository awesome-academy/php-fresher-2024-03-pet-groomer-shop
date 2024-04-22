window.pet = {
    delete: function (id, userID) {
        // eslint-disable-next-line no-undef
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                // eslint-disable-next-line no-undef
                $.ajax({
                    method: "DELETE",
                    url: ` / pet / ${id} / delete / ${userID}`,
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

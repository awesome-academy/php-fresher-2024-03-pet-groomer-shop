const image = {
    handleFileSelect: function (event, dataID) {
        const file = event.target.files[0];
        const preview = window.$("#review-image" + dataID);
        if (file) {
            preview.css("display", "block");
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.attr("src", e.target.result);
            };
            reader.readAsDataURL(file);
        } else {
            preview.css("display", "none");
        }
    },
};

window.$(document).ready(function () {
    window.$(".user_avatar").on("change", function (event) {
        const dataID = window.$(this).data("id") ?? "";
        image.handleFileSelect(event, dataID);
    });

    window.$(".pet_avatar").on("change", function (event) {
        const dataID = window.$(this).data("id") ?? "";
        image.handleFileSelect(event, dataID);
    });
});

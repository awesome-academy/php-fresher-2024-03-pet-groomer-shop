new window.Pusher(process.env.MIX_PUSHER_APP_KEY, {
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
});

// var channel = pusher.subscribe("payment-created");
// channel.bind("payment-notify", function (data) {
//     alert("New payment created: ");
// });

window.Echo.private(`App.Models.User.${window.userID}`).notification(() => {
    notification.getNotification();
});

const notification = {
    getNotification: function () {
        window.$.ajax({
            method: "GET",
            url: "/customer/notification/unread",
            success: function (data) {
                const hasNotifyIcon = window.$("#has-notification-icon");
                const notifyIcon = window.$("#notification-icon");
                if (data.length > 0) {
                    hasNotifyIcon.show();
                    notifyIcon.hide();
                } else {
                    hasNotifyIcon.hide();
                    notifyIcon.show();
                }
                window.$("#notify-list").empty();
                window.$.each(data, function (index, notification) {
                    window.$("#notify-list").append(
                        `
                        <div class="flex justify-between items-center gap-5">
                           <div>
                              ${notification.data.message} Order ID: ${notification.data.order_id}
                           </div>
                           <div data-id="${notification.id}" class="text-danger-500 cursor-pointer markAsRead">
                              x
                           </div>
                        </div>
                        `
                    );
                });
            },
        });
    },

    markAsRead: function (id) {
        window.$.ajax({
            method: "POST",
            url: "/customer/notification/mark-as-read/" + id,
            success: function (data) {
                if (data) {
                    notification.getNotification();
                }
            },
        });
    },
};

window.$(document).ready(function () {
    notification.getNotification();
    window.$(document).on("click", ".markAsRead", function () {
        const dataID = window.$(this).data("id") ?? "";
        notification.markAsRead(dataID);
    });
});

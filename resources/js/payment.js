const payment = {
    couponPrice: 0,
    originTotalPrice: 0,
    totalPrice: 0,
    petID: null,
    getCoupon: function (couponCode) {
        window.$.ajax({
            method: "GET",
            url: "/customer/payment/coupon",
            data: { coupon_code: couponCode },
            success: function (data) {
                payment.setCouponPrice(true);
                payment.displayCoupon(data);
                if (data.coupon_code) {
                    payment.couponPrice = Number(data.coupon_price);
                    payment.setCouponPrice(false);
                }
            },
        });
    },
    displayCoupon: function (message) {
        window.$("html, body").animate({ scrollTop: 0 }, "slow");

        const couponText = window.$("#coupon_text");
        if (message === "expired" || message === "not_found") {
            const text = window.trans("coupon.expired");
            if (message === "expired") {
                couponText.text(text).addClass("text-red-500");
                return;
            }
            couponText
                .text(window.trans("coupon.no_coupon"))
                .addClass("text-red-500");
            return;
        }
        if (message === "max_limit") {
            couponText
                .text(window.trans("coupon.max_limit"))
                .addClass("text-red-500");
            return;
        }
        if (message.errors) {
            couponText.text(message.errors).addClass("text-red-500");
            return;
        }

        couponText
            .text(window.trans("coupon.apply_success"))
            .removeClass()
            .addClass("text-green-500");
    },
    setCouponPrice(reset) {
        if (reset) {
            window.$("#coupon_price").text(0);
            payment.setTotalPrice(payment.originTotalPrice);
            return;
        }

        window
            .$("#coupon_price")
            .text(payment.couponPrice.toLocaleString("de-DE"));
        payment.setTotalPrice(payment.originTotalPrice - payment.couponPrice);
    },
    setTotalPrice(price) {
        window.$("#totalPrice").text(price.toLocaleString("de-DE"));
        payment.totalPrice = price;
    },
    pay: function (data) {
        const passData = `${data}&total_price=${payment.totalPrice}&coupon_price=${payment.couponPrice}`;
        window.$.ajax({
            method: "POST",
            data: passData,
            success: function (data) {
                if (data.status !== 200) {
                    payment.displayCoupon(data);
                    return;
                }
                window.location.href = data.url;
            },
        });
    },
};

window.payment = payment;

window.$(document).ready(function () {
    payment.petID = Number(window.location.pathname.split("/")[3]);
    window.$(document).on("change", "#coupon_code", function () {
        const couponCode = window.$("#coupon_code").val();
        payment.getCoupon(couponCode);
    });
    payment.originTotalPrice = Number(window.$("#totalPriceOriginal").val());
    payment.totalPrice = Number(window.$("#totalPriceOriginal").val());

    window.$("#payment-form").on("submit", function (event) {
        event.preventDefault();
        payment.pay(window.$(this).serialize());
    });
});

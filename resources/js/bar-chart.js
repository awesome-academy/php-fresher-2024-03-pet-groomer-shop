import Chart from "chart.js/auto";

window.$(document).ready(function () {
    window.$.ajax({
        url: "/dashboard/monthly-revenue",
        method: "GET",
        success: function (response) {
            var labels = response.map(function (data) {
                return data.month;
            });

            var data = response.map(function (data) {
                return data.total_revenue;
            });

            var ctx = window.$("#monthlyRevenueChart").get(0).getContext("2d");

            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: window.trans("chart.total_revenue"),
                            data: data,
                            backgroundColor: "rgba(54, 162, 235, 0.2)",
                            borderColor: "rgba(54, 162, 235, 1)",
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                    plugins: {
                        legend: {
                            position: "top",
                        },
                        title: {
                            display: true,
                            text: window.trans("chart.bar_title"),
                        },
                    },
                },
            });
        },
    });
});

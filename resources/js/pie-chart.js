import Chart from "chart.js/auto";

window.$(document).ready(function () {
    window.$.ajax({
        url: "/dashboard/show-pet-service-usage",
        method: "GET",
        success: function (response) {
            var labels = response.map(function (data) {
                return data.pet_service_name;
            });

            var data = response.map(function (data) {
                return data.usage_count;
            });

            var ctx = window.$("#serviceUsageChart").get(0).getContext("2d");

            new Chart(ctx, {
                type: "pie",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: window.trans("chart.service_usage"),
                            data: data,
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.2)",
                                "rgba(54, 162, 235, 0.2)",
                                "rgba(255, 206, 86, 0.2)",
                                "rgba(75, 192, 192, 0.2)",
                                "rgba(153, 102, 255, 0.2)",
                                "rgba(255, 159, 64, 0.2)",
                            ],
                            borderColor: [
                                "rgba(255, 99, 132, 1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(255, 159, 64, 1)",
                            ],
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: "top",
                        },
                        title: {
                            display: true,
                            text: window.trans("chart.pie_title"),
                        },
                    },
                },
            });
        },
    });
});

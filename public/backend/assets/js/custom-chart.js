(function ($) {
    "use strict";

    /*Sale statistics Chart*/
    // if ($("#myChart").length) {
    //     var ctx = document.getElementById("myChart").getContext("2d");
    //     var chart = new Chart(ctx, {
    //         type: "line",
    //         data: {
    //             labels: [
    //                 "Jan",
    //                 "Feb",
    //                 "Mar",
    //                 "Apr",
    //                 "May",
    //                 "Jun",
    //                 "Jul",
    //                 "Aug",
    //                 "Sep",
    //                 "Oct",
    //                 "Nov",
    //                 "Dec",
    //             ],
    //             datasets: [
    //                 {
    //                     label: "Sales",
    //                     tension: 0.3,
    //                     fill: true,
    //                     backgroundColor: "rgba(44, 120, 220, 0.2)",
    //                     borderColor: "rgba(44, 120, 220)",
    //                     data: chartData.sales,
    //                 },
    //                 {
    //                     label: "New Customers", // Changed from "New Users"
    //                     tension: 0.3,
    //                     fill: true,
    //                     backgroundColor: "rgba(4, 209, 130, 0.2)",
    //                     borderColor: "rgb(4, 209, 130)",
    //                     data: chartData.customers, // Changed from chartData.users
    //                 },
    //                 {
    //                     label: "New Products",
    //                     tension: 0.3,
    //                     fill: true,
    //                     backgroundColor: "rgba(380, 200, 230, 0.2)",
    //                     borderColor: "rgb(380, 200, 230)",
    //                     data: chartData.products,
    //                 },
    //             ],
    //         },
    //         options: {
    //             plugins: {
    //                 legend: {
    //                     labels: {
    //                         usePointStyle: true,
    //                     },
    //                 },
    //                 tooltip: {
    //                     callbacks: {
    //                         label: function (context) {
    //                             let label = context.dataset.label || "";
    //                             if (label.includes("Sales")) {
    //                                 return (
    //                                     label +
    //                                     ": " +
    //                                     context.parsed.y.toFixed(2)
    //                                 );
    //                             }
    //                             return label + ": " + context.parsed.y;
    //                         },
    //                     },
    //                 },
    //             },
    //             scales: {
    //                 y: {
    //                     beginAtZero: true,
    //                     ticks: {
    //                         callback: function (value) {
    //                             if (
    //                                 this.scale.id === "y" &&
    //                                 this.scale._labelItems[0].label.includes(
    //                                     "Sales"
    //                                 )
    //                             ) {
    //                                 return "PKR " + value.toFixed(2);
    //                             }
    //                             return value;
    //                         },
    //                     },
    //                 },
    //             },
    //         },
    //     });
    // }
    /*Sale statistics Chart*/
    if ($("#myChart2").length) {
        var ctx = document.getElementById("myChart2");
        var myChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["900", "1200", "1400", "1600"],
                datasets: [
                    {
                        label: "US",
                        backgroundColor: "#5897fb",
                        barThickness: 10,
                        data: [233, 321, 783, 900],
                    },
                    {
                        label: "Europe",
                        backgroundColor: "#7bcf86",
                        barThickness: 10,
                        data: [408, 547, 675, 734],
                    },
                    {
                        label: "Asian",
                        backgroundColor: "#ff9076",
                        barThickness: 10,
                        data: [208, 447, 575, 634],
                    },
                    {
                        label: "Africa",
                        backgroundColor: "#d595e5",
                        barThickness: 10,
                        data: [123, 345, 122, 302],
                    },
                ],
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            usePointStyle: true,
                        },
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    } //end if
})(jQuery);




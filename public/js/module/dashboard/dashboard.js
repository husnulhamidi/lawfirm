"use strict";

// Function to update chart data based on selected date range
function updateChartData(startDate, endDate) {
    return $.ajax({
        url: "dashboard/get_transaksi_penjualan",
        type: "GET",
        data: {
            start_date: startDate,
            end_date: endDate,
        },
    }).then(function (response) {
        // Update chart
        var categories = response.categories;
        var seriesData = response.series;

        Highcharts.chart('grafik-trx-penjualan', {
            chart: {
                type: 'column',
                height: '300'
            },
            title: {
                text: 'Grafik Transaksi Penjualan',
                align: 'center'
            },
            xAxis: {
                categories: categories, // Categories received from Laravel
                crosshair: true,
                accessibility: {
                    description: ''
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Terjual'
                }
            },
            tooltip: {
                valueSuffix: ''
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    color: '#4bb7e4' // Set the color of the bars
                },
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.0f} ',
                    }
                }
            },
            series: seriesData, // Series data received from Laravel
            credits: {
                enabled: false // Disable credits
            },
        });

        return response;
    });
}

// Function to update dashboard with data from the server
function updateDashboard(startDate, endDate) {
    return $.ajax({
        url: "dashboard/data",
        type: "GET",
        data: {
            start_date: startDate,
            end_date: endDate,
        },
    }).then(function (data) {
        $(".count_kode_transaksi").text(data.countKodeTransaksi);
        $(".total_qty").text(data.totalQty);
        $(".total_trx").text(data.formattedTotalTrx);
        $(".laba_penjualan").text(data.total_laba);
        $(".nilai_beli").text(data.hargaBarang);
        $(".total_utang_show").text(data.total_utang);
        $(".nilai_total_cash_show").text(data.total_cash);
        $(".nilai_total_transfer_show").text(data.total_transfer);

        $(".bayar_hutang_tunai_show").text(data.bayar_utang_cash);
        $(".bayar_hutang_tf_show").text(data.bayar_utang_tf);
        $(".retur_barang_show").text(data.retur);

        $(".total_biaya_service_show").text(data.total_biaya_service);
        $(".total_service_show").text(data.total_service);

        return data;
    });
}

function fetchLatestTransactions(startDate, endDate) {
    return $.ajax({
        url: "/dashboard/latest_transactions", // Update the URL as per your route
        type: "GET",
        data: {
            start_date: startDate,
            end_date: endDate,
        },
    }).then(function (data) {
        // Clear existing content
        $(".foreach_10_trx").empty();

        // Iterate through each transaction and append to the container
        data.forEach(function (transaction, index) {
            var transactionHtml = '<div class="d-flex flex-stack">';
            transactionHtml +=
                '<span class="text-primary fw-semibold fs-6 me-2">' +
                (index + 1) +
                ". " +
                transaction.barang.nama_barang +
                " | " +
                transaction.created_at +
                "</span>";
            transactionHtml += "</div>";

            $(".foreach_10_trx").append(transactionHtml);
        });
    });
}

function grafikProdukTerlaris(startDate, endDate) {
    return $.ajax({
        url: "dashboard/get_produk_terlaris",
        type: "GET",
        data: {
            start_date: startDate,
            end_date: endDate,
        },
    }).then(function (response) {
        // Prepare data for Highcharts
        var data = response.map(function (item) {
            return {
                name: item.product_name,
                y: item.total_quantity,
            };
        });

        // Render Highcharts pie chart
        Highcharts.chart("grafik-produk-terlaris", {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: "pie",
                height: "50%",
            },
            title: {
                text: "Grafik 10 Produk Terlaris",
                align: "center",
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: "pointer",
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return '<span style="font-size: 1.2em"><b>' + toTitleCase(this.point.name) + '</b></span><br>' +
                                '<span style="opacity: 0.6">' + this.y + '</span>';
                        },
                        connectorColor: "rgba(128,128,128,0.5)",
                    },
                },
            },
            series: [
                {
                    name: "Qty Terjual",
                    data: data,
                },
            ],
            credits: {
                enabled: false // Disable credits
            },
        });
    });
}

function grafikProdukTidakTerlaris(startDate, endDate) {
    return $.ajax({
        url: "dashboard/get_produk_tidaklaris",
        type: "GET",
        data: {
            start_date: startDate,
            end_date: endDate,
        },
    }).then(function (response) {
        // Prepare data for Highcharts
        var data = response.map(function (item) {
            return {
                name: item.product_name,
                y: item.total_quantity,
            };
        });

        // Render Highcharts pie chart
        Highcharts.chart("grafik-produk-tidaklaris", {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: "pie",
                height: "50%",
            },
            title: {
                text: "Grafik 5 Produk Kurang Laku",
                align: "center",
            },
            // tooltip: {
            //     pointFormat: "{series.name}: <b>{point.y)</b>",
            // },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: "pointer",
                    dataLabels: {
                        enabled: true,
                        format:
                            '<span style="font-size: 1.2em"><b>{point.name}</b></span><br>' +
                            '<span style="opacity: 0.6">{point.y}</span>',
                        connectorColor: "rgba(128,128,128,0.5)",
                    },
                },
            },
            series: [
                {
                    name: "Qty Terjual",
                    data: data,
                },
            ],
            credits: {
                enabled: false // Disable credits
            },
        });
    });
}


function grafikNominalTransaksiSebulan(startDate, endDate){

    return $.ajax({
        url: "dashboard/get_nominal_transaksi",
        type: "GET",
        data: {
            start_date: startDate,
            end_date: endDate,
        },
    }).then(function (response) {

        var categories = [];
        var nominal = [];
        var total_qty = [];

        response.forEach(function(item) {
            categories.push(item.tanggal);
            nominal.push(item.total);
            total_qty.push(item.total_qty);
        });

        Highcharts.chart('grafik-trx-nominal-sebulan', {
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: 'Grafik Jumlah Pendapatan Penjualan perhari'
            },
            xAxis: {
                categories: categories,
                accessibility: {
                    description: 'Months of the year'
                }
            },
            yAxis: [{ // Primary yAxis
                labels: {
                    format: 'Rp.{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: 'Total Nominal Penjualan',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'Jumlah Barang Terjual',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            // yAxis: {
            //     title: {
            //         text: 'Total Nominal Penjualan'
            //     },
            //     labels: {
            //         format: '{value}'
            //     }
            // },
            tooltip: {
                crosshairs: true,
                shared: true
            },
            plotOptions: {
                spline: {
                    marker: {
                        radius: 4,
                        lineColor: '#666666',
                        lineWidth: 1
                    }
                }
            },
            legend: {
                align: 'left',
                x: 80,
                verticalAlign: 'top',
                y: 60,
                floating: true,
                backgroundColor:
                    Highcharts.defaultOptions.legend.backgroundColor || // theme
                    'rgba(255,255,255,0.25)'
            },
            series: [
                {
                    //showInLegend: false ,
                    name: 'Jumlah brg terjual',
                    color:'#0aa0b8',
                    type: 'column',
                    yAxis: 1,
                    data: total_qty,
                
                },
                {
                    name: 'Jumlah Omzet',
                    type: 'spline',
                    marker: {
                        symbol: 'square'
                    },
                    data: nominal,
                    //showInLegend: false 
                   
                }
            ],
            credits: {
                enabled: false // Disable credits
            },
        });

    });
    
}
function toTitleCase(str) {
    return str.toLowerCase().split(' ').map(function(word) {
        return word.charAt(0).toUpperCase() + word.slice(1);
    }).join(' ');
}

jQuery(document).ready(function () {

    $(".start_date_show").text(start_date);
    $(".end_date_show").text(end_date);
    // var currentDate = new Date();
    // var currentDateString =
    //     currentDate.getFullYear() +
    //     "-" +
    //     ("0" + (currentDate.getMonth() + 1)).slice(-2) +
    //     "-" +
    //     ("0" + currentDate.getDate()).slice(-2);

    var yesterday = moment().subtract(1, "days");

    Highcharts.setOptions({
        colors: ["#76d86b", "#4bb7e4", "#f6c811", "#ff6232"],
        navigation: {
            buttonOptions: {
                symbolSize: 12,
                symbolStrokeWidth: 1,
                enabled: true, // change to false to hide
            },
        },
        xAxis: {
            labels: {
                style: {
                    color: "#000",
                    letterSpacing: "2px",
                    textTransform: "uppercase",
                    fontSize: "10px",
                },
            },
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    allowOverlap: true,
                    padding: 0,
                    enabled: true,
                    format: '{point.y:.0f} ',
                },
            },
        },
        yAxis: {
            labels: {
                style: {
                    color: "#000",
                    fontWeight: "1000",
                    fontSize: "8px",
                },
            },
            title: {
                style: {
                    color: "#000",
                    fontSize: "12px",
                },  
            },
            gridLineColor: "#dadce2",
        },
    });
    
    // Create gradients for colors
    Highcharts.setOptions({
        colors: Highcharts.getOptions().colors.map(function(color) {
            return {
                radialGradient: {
                    cx: 0.5,
                    cy: 0.3,
                    r: 0.7,
                },
                stops: [
                    [0, color],
                    [1, Highcharts.color(color).brighten(-0.3).get("rgb")], // darken
                ],
            };
        }),
    });
    

    $("#filter_date_range").daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: "Clear",
        },
        startDate: yesterday,
        endDate: yesterday,
    });

    // Handle date range change
    $("#filter_date_range").on("apply.daterangepicker", function (ev, picker) {
        var startDate = picker.startDate.format("YYYY-MM-DD");
        var endDate = picker.endDate.format("YYYY-MM-DD");
        $(this).val(startDate + " - " + endDate);

        $(".start_date_show").text(startDate);
        $(".end_date_show").text(endDate);
        
        // Update chart data and dashboard asynchronously
        updateChartData(startDate, endDate)
            .then(function (response) {
                // Update dashboard asynchronously
                updateDashboard(startDate, endDate);
                fetchLatestTransactions(startDate, endDate);
                grafikProdukTerlaris(startDate, endDate);
                grafikProdukTidakTerlaris(startDate, endDate);
                grafikNominalTransaksiSebulan(startDate, endDate);
            })
            .catch(function (error) {
                console.error("Error updating chart:", error);
            });
    });

    // Handle date range clear
    $("#filter_date_range").on("cancel.daterangepicker", function (ev, picker) {
        $(this).val("");
        // Clear chart data or handle as needed
    });

    // Initial chart load with yesterday's date
    var startDate = start_date;
    var endDate = end_date;
    updateChartData(startDate, endDate)
        .then(function (response) {
            // Update dashboard asynchronously
            updateDashboard(startDate, endDate);
            fetchLatestTransactions(startDate, endDate);
            grafikProdukTerlaris(startDate, endDate);
            grafikProdukTidakTerlaris(startDate, endDate);
            grafikNominalTransaksiSebulan(startDate, endDate);
        })
        .catch(function (error) {
            console.error("Error updating chart:", error);
        });

    

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var table = $("#tbl_barang");

    table.DataTable({
        pageLength: 25,
        processing: true,
        serverSide: true,
        ajax: {
            url: "dashboard/getDataBarang",
            type: "GET",
            data: function (d) {},
        },
        columns: [
            {
                data: "id",
                width: "50px",
                className: "text-center",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            {
                data: "barcode",
                className: "text-center",
                render: function (data) {
                    return "<button type='button' class='btn btn-success btn-xs'>"+data+"</button>";
                    // // Create a canvas element as a container for the barcode
                    // var canvas = document.createElement("canvas");

                    // // Draw the barcode on the canvas using JsBarcode
                    // JsBarcode(canvas, data, { format: "CODE128" });

                    // // Convert canvas to data URL and use it as the source for an image tag
                    // var img = document.createElement("img");
                    // img.src = canvas.toDataURL("image/png");
                    // img.style.maxWidth = "100px"; // Adjust this value to your desired maximum width

                    // return img.outerHTML;
                },
            },

            { data: "nama_barang" },
            { data: "stok_barang" },
        ],
        searching: false, // Disable search
        scrollX: false, // Disable horizontal scroll
        scrollY: false, // Disable vertical scroll
        bLengthChange: false, // Disable page length selector
    });
});

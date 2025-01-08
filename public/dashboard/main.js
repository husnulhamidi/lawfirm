

  Highcharts.setOptions({
    colors: ['#E9EF47','#6ABF64','#76d86b',  '#f6c811', '#ff6232'],
    navigation: {
        buttonOptions: {
            symbolSize: 12,
            symbolStrokeWidth: 1,
            enabled: true //change to false to hide
        }
    },
    xAxis: {
        labels: {
            style: {
                color: '#000',
                letterSpacing: '2px',
                textTransform: 'uppercase',
                fontSize: '10px',
            }
        },
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                allowOverlap: true,
                padding: 0,
                style:{
                  fontSize:'10px',
                  fontWeight:'normal',
                }
            }
        },
    },
    yAxis: {
        labels: {
            style: {
                color: '#000',
                //fontWeight: '1000',
                fontSize: '8px'
            },
        },
        title: {
            style: {
                color: '#000',
                fontSize: '12px'
            }
        },
        gridLineColor: '#dadce2'
    }
});
  

function chartBatubaraJamali(type) {
  return $.ajax({
      url: "/dashboard/batubara",
      type: "GET",
      data: {
          type: type,
          area:"Jamali"
      },
  }).then(function (response) {

       // Inisialisasi grafik Highcharts di dalam tag <script>
        Highcharts.chart("chart-container", {
          credits: {
            enabled: false,
          },
          chart: {
            type: "column", // Jenis grafik (kolom)
            marginTop: 50, // Jarak atas grafik dari bagian atas halaman
          },
          title: {
            text: "BATUBARA - JAMALI", // Judul grafik
          },
        
          xAxis: {
            categories: response.categories, // Label sumbu x
            title: {
              text: null, // Menghapus label sumbu x
            },
          },
          
          yAxis: { // Primary yAxis
              min: 0,
              title: {
                  text: 'Juta ton',
                  align: 'high'
              },

              labels: {
                  overflow: 'justify'
              },
              gridLineColor: '#d8dade',
          },

          plotOptions: {
              series: {
                  dataLabels: {
                      enabled: true,
                      format: '{point.y:.2f} ',
                      rotation: 270,
                      allowOverlap: true,
                  }
              }
          },

          tooltip: {
              headerFormat: '<table><tr><td colspan="2"><h3>{point.key}</h3></td></tr>',
              pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                  '<td style="padding:0"><b>{point.y:.2f} </b></td></tr>',
              footerFormat: '</table>',
              shared: true,
              useHTML: true
          },
          series: [
            {
              name: "Ren", // Nama seri data
              data: response.rencana, // Nilai data
            },
            {
              name: "Real", // Nama seri data
              data: response.realisasi, // Nilai data
            },
          ],
          
          legend:false,
          // legend: {
          //     verticalAlign: 'top',
          //     itemStyle: {
          //         fontSize: '10px',
          //     },
          //     x: 0,
          //     y: -20,
          // }
        });
    });
  }
  
  function chartBatubaraSumkal(type) {
    return $.ajax({
        url: "/dashboard/batubara",
        type: "GET",
        data: {
            type: type,
            area:"Sumkal"
        },
    }).then(function (response) {
  Highcharts.chart("chart-container-2", {
    credits: {
      enabled: false,
    },
    chart: {
      type: "column", // Jenis grafik (kolom)
      marginTop: 50, // Jarak atas grafik dari bagian atas halaman
    },
    title: {
      text: "BATUBARA - SUMKAL", // Judul grafik
    },
    xAxis: {
      categories: response.categories, // Label sumbu x
      title: {
        text: null, // Menghapus label sumbu x
      },
    },
    yAxis: { // Primary yAxis
        min: 0,
        title: {
            text: 'Juta ton',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        },
        gridLineColor: '#d8dade',
    },

    plotOptions: {
        series: {
            dataLabels: {
                enabled: true,
                format: '{point.y:.2f} ',
                rotation: 270,
                allowOverlap: true,
            }
        }
    },

    tooltip: {
        headerFormat: '<table><tr><td colspan="2"><h3>{point.key}</h3></td></tr>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.2f} </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },

    series: [
      {
        name: "Ren", // Nama seri data
        data: response.rencana, // Nilai data
      },
      {
        name: "Real", // Nama seri data
        data: response.realisasi, // Nilai data
      },
    ],
    legend:false,
  });
});
}

function chartBatubaraSulmapa(type) {
  return $.ajax({
      url: "/dashboard/batubara",
      type: "GET",
      data: {
          type: type,
          area:"Sulmapa"
      },
  }).then(function (response) {
  Highcharts.chart("chart-container-3", {
    credits: {
      enabled: false,
    },
    chart: {
      type: "column", // Jenis grafik (kolom)
      marginTop: 50, // Jarak atas grafik dari bagian atas halaman
    },
    title: {
      text: "BATUBARA - SULMAPA", // Judul grafik
    },
    xAxis: {
      categories: response.categories, // Label sumbu x
      title: {
        text: null, // Menghapus label sumbu x
      },
    },
    yAxis: { // Primary yAxis
        min: 0,
        title: {
            text: 'Juta ton',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        },
        gridLineColor: '#d8dade',
    },

    plotOptions: {
        series: {
            dataLabels: {
                enabled: true,
                format: '{point.y:.3f} ',
                rotation: 270,
                allowOverlap: true,
            }
        }
    },

    tooltip: {
        headerFormat: '<table><tr><td colspan="2"><h3>{point.key}</h3></td></tr>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.3f} </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },

    series: [
      {
        name: "Ren", // Nama seri data
        data: response.rencana, // Nilai data
      },
      {
        name: "Real", // Nama seri data
        data: response.realisasi, // Nilai data
      },
    ],
    legend:false,
  });
});
}

function chartBiomasa(type) {
  return $.ajax({
      url: "/dashboard/biomasa",
      type: "GET",
      data: {
          type: type,
          area:"Biomasa"
      },
  }).then(function (response) {
  Highcharts.chart("chart-container-4", {
    credits: {
      enabled: false,
    },
    chart: {
      type: "column", // Jenis grafik (kolom)
      marginTop: 50, // Jarak atas grafik dari bagian atas halaman
    },
    title: {
      text: "BIOMASA", // Judul grafik
    },
    xAxis: {
      categories: response.categories, // Label sumbu x
      title: {
        text: null, // Menghapus label sumbu x
      },
    },
    yAxis: { // Primary yAxis
      min: 0,
      title: {
          text: 'Juta ton',
          align: 'high'
      },
      labels: {
          overflow: 'justify'
      },
      gridLineColor: '#d8dade',
   },
    plotOptions: {
        series: {
            dataLabels: {
                enabled: true,
                format: '{point.y:.3f} ',
                rotation: 270,
                allowOverlap: true,
            }
        }
    },

    tooltip: {
        headerFormat: '<table><tr><td colspan="2"><h3>{point.key}</h3></td></tr>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.3f} </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    series: [
      {
        name: "Ren", // Nama seri data
        data: response.rencana, // Nilai data
      },
      {
        name: "Real", // Nama seri data
        data: response.realisasi, // Nilai data
      },
    ],
    legend:false,
  });
});
}
  
function chartGaspipa(type) {
  return $.ajax({
      url: "/dashboard/gaspipa",
      type: "GET",
      data: {
          type: type,
          area:"Gaspipa"
      },
  }).then(function (response) {
  Highcharts.chart("chart-container-5", {
    credits: {
      enabled: false,
    },
    chart: {
      type: "column", // Jenis grafik (kolom)
      marginTop: 50, // Jarak atas grafik dari bagian atas halaman
    },
    title: {
      text: "GAS PIPA", // Judul grafik
    },
    xAxis: {
      categories: response.categories, // Label sumbu x
      title: {
        text: null, // Menghapus label sumbu x
      },
    },
    yAxis: { // Primary yAxis
        min: 0,
        title: {
            text: 'TBTU',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        },
        gridLineColor: '#d8dade',
    },
    plotOptions: {
      series: {
          dataLabels: {
              enabled: true,
              format: '{point.y:.1f} ',
              rotation: 270,
              allowOverlap: true
          }
      }
  },

  tooltip: {
      headerFormat: '<table><tr><td colspan="2"><h3>{point.key}</h3></td></tr>',
      pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
          '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
      footerFormat: '</table>',
      shared: true,
      useHTML: true
  },
    series: [
      {
        name: "Ren", // Nama seri data
        data: response.rencana, // Nilai data
      },
      {
        name: "Real", // Nama seri data
        data: response.realisasi, // Nilai data
      },
    ],
    legend:false,
  });
});
}
  
function chartLng(type) {
  return $.ajax({
      url: "/dashboard/lng",
      type: "GET",
      data: {
          type: type,
          area:"Lng"
      },
  }).then(function (response) {
  Highcharts.chart("chart-container-6", {
    credits: {
      enabled: false,
    },
    chart: {
      type: "column", // Jenis grafik (kolom)
      marginTop: 50, // Jarak atas grafik dari bagian atas halaman
    },
    title: {
      text: "LNG", // Judul grafik
    },
    xAxis: {
      categories: response.categories, // Label sumbu x
      title: {
        text: null, // Menghapus label sumbu x
      },
    },
    yAxis: { // Primary yAxis
        min: 0,
        title: {
            text: 'TBTU',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        },
        gridLineColor: '#d8dade',
    },
    plotOptions: {
      series: {
          dataLabels: {
              enabled: true,
              format: '{point.y:.1f} ',
              rotation: 270,
              allowOverlap: true,
          }
      }
  },

  tooltip: {
      headerFormat: '<table><tr><td colspan="2"><h3>{point.key}</h3></td></tr>',
      pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
          '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
      footerFormat: '</table>',
      shared: true,
      useHTML: true
  },
    series: [
      {
        name: "Ren", // Nama seri data
        data: response.rencana, // Nilai data
      },
      {
        name: "Real", // Nama seri data
        data: response.realisasi, // Nilai data
      },
    ],
    legend:false,
  });
});
}

function chartBbm(type) {
  return $.ajax({
      url: "/dashboard/bbm",
      type: "GET",
      data: {
          type: type,
          area:"Bbm"
      },
  }).then(function (response) {
  
  Highcharts.chart("chart-container-7", {
    credits: {
      enabled: false,
    },
    chart: {
      type: "column", // Jenis grafik (kolom)
      marginTop: 50, // Jarak atas grafik dari bagian atas halaman
    },
    title: {
      text: "BBM", // Judul grafik
    },
    xAxis: {
      categories: response.categories, // Label sumbu x
      title: {
        text: null, // Menghapus label sumbu x
      },
    },
    yAxis: { // Primary yAxis
        min: 0,
        title: {
            text: 'Kilo Liter',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        },
        gridLineColor: '#d8dade',
    },
    plotOptions: {
      series: {
          dataLabels: {
              enabled: true,
              format: '{point.y:.1f} ',
              rotation: 270,
              allowOverlap: true,
          }
      }
  },

  tooltip: {
      headerFormat: '<table><tr><td colspan="2"><h3>{point.key}</h3></td></tr>',
      pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
          '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
      footerFormat: '</table>',
      shared: true,
      useHTML: true
  },
    series: [
      {
        name: "Ren", // Nama seri data
        data: response.rencana, // Nilai data
      },
      {
        name: "Real", // Nama seri data
        data: response.realisasi, // Nilai data
      },
    ],
    legend:false,
  });
});
}


  chartBatubaraJamali(type);
  chartBatubaraSumkal(type);
  chartBatubaraSulmapa(type);
  chartBiomasa(type);
  chartGaspipa(type);
  chartLng(type);
  chartBbm(type);

  setTimeout(function(){
    window.location.reload(1);
 }, 3600000);

  
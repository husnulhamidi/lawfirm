var namaBulan = [
    "Mar",
    "Apr",
    "Mei",
    "Jun",
    "Jul"
  ];
  
  var dataRen = [100, 100, 100, 100, 100];
  var dataReal = [80, 90, 70, 0, 0];

  Highcharts.setOptions({
    colors: ['#F5F520','#4bb7e4','#76d86b',  '#f6c811', '#ff6232'],
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
            }
        }
    },
    yAxis: {
        labels: {
            style: {
                color: '#000',
                fontWeight: '1000',
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
            categories: namaBulan, // Label sumbu x
            title: {
              text: null, // Menghapus label sumbu x
            },
          },
          
          yAxis: { // Primary yAxis
              min: 0,
              title: {
                  text: 'Kilo ton',
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
                      format: '{point.y:.0f} ',
                      //rotation: 270,
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
              data: dataRen, // Nilai data
              color: {
                  linearGradient: [0, 400, 0, 0],
                  stops: [
                      [0.1, '#ff5d5d'],
                      [0.325, '#ff9d33']
                  ]
              },
              tooltip: {
                  valueSuffix: 'T'
              },
              marker: {
                  lineWidth: 2,
                  lineColor: Highcharts.getOptions().colors[1],
                  fillColor: 'white'
              }
            },
            {
              name: "Real", // Nama seri data
              data: dataReal, // Nilai data
              color: {
                  linearGradient: [0, 400, 0, 0],
                  stops: [
                      [0.1, '#169aed'],
                      [0.9, '#8cd0fb'],
                  ]
              },
              tooltip: {
                  valueSuffix: 'T'
              },
              marker: {
                  lineWidth: 2,
                  lineColor: Highcharts.getOptions().colors[1],
                  fillColor: 'white'
              }
            },
          ],
        
          legend: {
              verticalAlign: 'top',
              itemStyle: {
                  fontSize: '10px',
              },
              x: 0,
              y: -20,
          }
        });

  
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
      categories: namaBulan, // Label sumbu x
      title: {
        text: null, // Menghapus label sumbu x
      },
    },
    yAxis: { // Primary yAxis
        min: 0,
        title: {
            text: 'Kilo ton',
            align: 'high'
        },
        max: 100,
        labels: {
            overflow: 'justify'
        },
        gridLineColor: '#d8dade',
    },

    plotOptions: {
        series: {
            dataLabels: {
                enabled: true,
                format: '{point.y:.0f} ',
                rotation: 270,
                allowOverlap: true,
            }
        }
    },

    series: [
      {
        name: "Ren", // Nama seri data
        data: dataRen, // Nilai data
      },
      {
        name: "Real", // Nama seri data
        data: dataReal, // Nilai data
      },
    ],
    legend: {
        verticalAlign: 'top',
        itemStyle: {
            fontSize: '10px',
        },
        x: 0,
        y: -20,
    }
  });
  
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
      categories: namaBulan, // Label sumbu x
      title: {
        text: null, // Menghapus label sumbu x
      },
    },
    yAxis: { // Primary yAxis
        min: 0,
        title: {
            text: 'Kilo ton',
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
                format: '{point.y:.0f} ',
                rotation: 270,
                allowOverlap: true,
            }
        }
    },

    series: [
      {
        name: "Ren", // Nama seri data
        data: dataRen, // Nilai data
      },
      {
        name: "Real", // Nama seri data
        data: dataReal, // Nilai data
      },
    ],
    legend: {
        verticalAlign: 'top',
        itemStyle: {
            fontSize: '10px',
        },
        x: 0,
        y: -20,
    }
  });
  
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
      categories: namaBulan, // Label sumbu x
      title: {
        text: null, // Menghapus label sumbu x
      },
    },
    yAxis: { // Primary yAxis
      min: 0,
      title: {
          text: 'Kilo ton',
          align: 'high'
      },
      labels: {
          overflow: 'justify'
      },
      gridLineColor: '#d8dade',
   },
    series: [
      {
        name: "Ren", // Nama seri data
        data: dataRen, // Nilai data
      },
      {
        name: "Real", // Nama seri data
        data: dataReal, // Nilai data
      },
    ],
    legend: {
        verticalAlign: 'top',
        itemStyle: {
            fontSize: '10px',
        },
        x: 0,
        y: -20,
    }
  });
  
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
      categories: namaBulan, // Label sumbu x
      title: {
        text: null, // Menghapus label sumbu x
      },
    },
    yAxis: { // Primary yAxis
        min: 0,
        title: {
            text: 'MBTU',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        },
        gridLineColor: '#d8dade',
    },
    series: [
      {
        name: "Ren", // Nama seri data
        data: dataRen, // Nilai data
      },
      {
        name: "Real", // Nama seri data
        data: dataReal, // Nilai data
      },
    ],
    legend: {
        verticalAlign: 'top',
        itemStyle: {
            fontSize: '10px',
        },
        x: 0,
        y: -20,
    }
  });
  
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
      categories: namaBulan, // Label sumbu x
      title: {
        text: null, // Menghapus label sumbu x
      },
    },
    yAxis: { // Primary yAxis
        min: 0,
        title: {
            text: 'MBTU',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        },
        gridLineColor: '#d8dade',
    },
    series: [
      {
        name: "Ren", // Nama seri data
        data: dataRen, // Nilai data
      },
      {
        name: "Real", // Nama seri data
        data: dataReal, // Nilai data
      },
    ],
    legend: {
        verticalAlign: 'top',
        itemStyle: {
            fontSize: '10px',
        },
        x: 0,
        y: -20,
    }
  });
  
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
      categories: namaBulan, // Label sumbu x
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
    series: [
      {
        name: "Ren", // Nama seri data
        data: dataRen, // Nilai data
      },
      {
        name: "Real", // Nama seri data
        data: dataReal, // Nilai data
      },
    ],
    legend: {
        verticalAlign: 'top',
        itemStyle: {
            fontSize: '10px',
        },
        x: 0,
        y: -20,
    }
  });

  


Highcharts.setOptions({
    colors: ['#C70039', '#FFC300', '#2fcea3'],
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

async function chartBatubaraJamali(num){
    loader(1);
    let type = $('input[name="filter_type"]:checked').val();
    const response = await fetch("/dashboard/batubara", {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Token' :$('meta[name="csrf-token"]').attr('content')+$('meta[name="csrf-token"]').attr('content'),
        },
        body: JSON.stringify({
            num:num,
            type:type,
            ctr:jml,
            date:$("#filter_date").val(),
            month:$("#filter_month").val()
        })
    });

    let responseJson = await response.json();

    if(responseJson.success){

        if(type=='daily'){
            $("#date_jamali").html(tanggalIndoName(responseJson.date));
        }else{
            $("#date_jamali").html(MonthIndoName(responseJson.date));
        }
        
        $("#total_jamali").html(responseJson.total);
        $("#total_jamali_right").html(responseJson.total);
        
        $("#kritis_jamali").html(responseJson.total_kritis);
        $("#siaga_jamali").html(responseJson.total_siaga);
        $("#normal_jamali").html(responseJson.total_normal);

        // Inisialisasi grafik Highcharts di dalam tag <script>
        Highcharts.chart('chart-jamali', {
            chart: {
                type: 'bar',
                height: 700,
                marginTop: 50,
                events: {
                    load() {
                      let chart = this,
                        tickLength = chart.xAxis[0].tickPositions.length;
              
                      chart.series.forEach(s => {
                        s.points.forEach(p => {
                          //get last points
                          if (p.y <10) {
                            p.update({
                                color: {
                                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                    stops: [
                                       
                                        [0, '#C70039'],
                                        [1, '#900C3F'],
                                    ]
                                },
                            })
                          }
                          if(p.y >=10 && p.y <=15){
                            p.update({
                                color: {
                                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                    stops: [
                                        [0, '#ff9d33'],
                                        [1, '#ff5d5d']
                                    ]
                                },
                            })
                          }
                        })
                      })
                    }
                  }
            },
            title: "HOP BATUBARA JAMALI",
            subtitle: false,
            xAxis: {
                categories: responseJson.categories, 
                title: {
                    text: null
                },
                shared: true,
                useHTML: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: '',
                    align: 'high'
                },
                //max: 100,
                labels: {
                    overflow: 'justify'
                },
                gridLineColor: '#d8dade',
                plotLines: [{
                    color: '#d1e9e1',
                    width: 4,
                    value: 15,
                    label: {
                        rotation: 0,
                        x: -1,
                        y: -20,
                        style: {
                            color: '#7abc88',
                            fontWeight: 700
                        },
                        useHTML: true,
                        text: '<span>Normal</span><br />(>15)',
                    }

                }, 
                {
                    color: '#ffe4c0',
                    width: 4,
                    //value: 42.1,
                    value: 10,
                    label: {
                        rotation: 0,
                        x: -6,
                        y: -20,
                        style: {
                            color: '#FFC300',
                            fontWeight: 700
                        },
                        useHTML: true,
                        text: '<span>Siaga</span><br />(10-15)',
                    },
                },
                {
                    color: '#ffe4c0',
                    width: 4,
                    //value: 42.1,
                    value: 9.9,
                    label: {
                        rotation: 0,
                        x: -50,
                        y: -20,
                        style: {
                            color: '#C70039',
                            fontWeight: 700
                        },
                        useHTML: true,
                        text: '<span>Kritis</span><br />(<10)',
                    },
                }
                ]
            },
            tooltip: {
                headerFormat: '<table><tr><th colspan="2"><h3>{point.key}</h3></th></tr>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">HOP </td> <td>: &nbsp;<b>{point.y:2f}</td></tr>' +
                    '<tr><td style="color:{series.color};padding:0">Date </td><td>: &nbsp;<b>{point.date}</td></tr>'+
                    '<tr><td style="color:{series.color};padding:0">Status </td><td>: &nbsp;<b>{point.status}</td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true,
                style: {
                    zIndex: 999,
                },
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.2f}',
                    },
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function(e) {
                                // console.log(this.category)
                                $('#modalForm').modal('show');
                            }
                        }
                    },
                },

                bar: {
                    dataLabels: {
                        enabled: true,
                        color: '#000',
                    }
                }
            },
            credits: {
                enabled: false
            },
            legend:{ enabled:false },
            series: [{
                name: 'HOP ',
                color: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#b0df3e'],
                        [1, '#2fcea3']
                    ]
                },
                //groupPadding: 1,
                pointWidth: 7,
                data: responseJson.data,
            }]
        });

        //--//
    }else{
        Swal.fire({
            title: "Error!",
            text: "Refresh dan coba kembali. Jika masih error, silahkan hubungi Administrator.",
            icon: "danger",
            buttonsStyling: false,
            confirmButtonText: "Ok",
            customClass: {
                confirmButton: "btn btn-danger"
            }
        });
    }
}

function chartBatubaraJamalix(type) {
    loader(1);
  return $.ajax({
      url: "/dashboard/batubara",
      type: "POST",
      data: {
          type: type,
          ctr:jml,
          date:$("#filter_date").val()
      },
  }).then(function (response) {
        $("#date_jamali").html(tanggalIndoName(response.date));
        $("#total_jamali").html(response.total);
        $("#total_jamali_right").html(response.total);
        
        $("#kritis_jamali").html(response.total_kritis);
        $("#siaga_jamali").html(response.total_siaga);
        $("#normal_jamali").html(response.total_normal);
        //loader(2);
        
       // Inisialisasi grafik Highcharts di dalam tag <script>
        Highcharts.chart('chart-jamali', {
            chart: {
                type: 'bar',
                height: 700,
                marginTop: 50,
                events: {
                    load() {
                      let chart = this,
                        tickLength = chart.xAxis[0].tickPositions.length;
              
                      chart.series.forEach(s => {
                        s.points.forEach(p => {
                          //get last points
                          if (p.y <10) {
                            p.update({
                                color: {
                                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                    stops: [
                                       
                                        [0, '#C70039'],
                                        [1, '#900C3F'],
                                    ]
                                },
                            })
                          }
                          if(p.y >=10 && p.y <=15){
                            p.update({
                                color: {
                                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                    stops: [
                                        [0, '#ff9d33'],
                                        [1, '#ff5d5d']
                                    ]
                                },
                            })
                          }
                        })
                      })
                    }
                  }
            },
            title: "HOP BATUBARA JAMALI",
            subtitle: false,
            xAxis: {
                categories: response.categories, 
                title: {
                    text: null
                },
                shared: true,
                useHTML: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: '',
                    align: 'high'
                },
                //max: 100,
                labels: {
                    overflow: 'justify'
                },
                gridLineColor: '#d8dade',
                plotLines: [{
                    color: '#d1e9e1',
                    width: 4,
                    value: 15,
                    label: {
                        rotation: 0,
                        x: -1,
                        y: -20,
                        style: {
                            color: '#7abc88',
                            fontWeight: 700
                        },
                        useHTML: true,
                        text: '<span>Normal</span><br />(>15)',
                    }

                }, 
                {
                    color: '#ffe4c0',
                    width: 4,
                    //value: 42.1,
                    value: 10,
                    label: {
                        rotation: 0,
                        x: -6,
                        y: -20,
                        style: {
                            color: '#FFC300',
                            fontWeight: 700
                        },
                        useHTML: true,
                        text: '<span>Siaga</span><br />(10-15)',
                    },
                },
                {
                    color: '#ffe4c0',
                    width: 4,
                    //value: 42.1,
                    value: 9.9,
                    label: {
                        rotation: 0,
                        x: -50,
                        y: -20,
                        style: {
                            color: '#C70039',
                            fontWeight: 700
                        },
                        useHTML: true,
                        text: '<span>Kritis</span><br />(<10)',
                    },
                }
                ]
            },
            tooltip: {
                headerFormat: '<table><tr><th colspan="2"><h3>{point.key}</h3></th></tr>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">HOP </td> <td>: &nbsp;<b>{point.y:2f}</td></tr>' +
                    '<tr><td style="color:{series.color};padding:0">Date </td><td>: &nbsp;<b>{point.date}</td></tr>'+
                    '<tr><td style="color:{series.color};padding:0">Status </td><td>: &nbsp;<b>{point.status}</td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true,
                style: {
                    zIndex: 999,
                },
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.2f}',
                    },
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function(e) {
                                // console.log(this.category)
                                $('#modalForm').modal('show');
                            }
                        }
                    },
                },

                bar: {
                    dataLabels: {
                        enabled: true,
                        color: '#000',
                    }
                }
            },
            credits: {
                enabled: false
            },
            legend:{ enabled:false },
            series: [{
                name: 'HOP ',
                color: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#b0df3e'],
                        [1, '#2fcea3']
                    ]
                },
                //groupPadding: 1,
                pointWidth: 7,
                data: response.data,
            }]
        });
    });
  }

  async function chartBatubaraSumkal(num){
    let type = $('input[name="filter_type"]:checked').val();
    const response = await fetch("/dashboard/batubara", {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Token' :$('meta[name="csrf-token"]').attr('content')+$('meta[name="csrf-token"]').attr('content'),
        },
        body: JSON.stringify({
            num:num,
            type:type,
            ctr:skl,
            date:$("#filter_date").val(),
            month:$("#filter_month").val()
        })
    });

    let responseJson = await response.json();

    if(responseJson.success){

        if(type=='daily'){
            $("#date_sumkal").html(tanggalIndoName(responseJson.date));
        }else{
            $("#date_sumkal").html(MonthIndoName(responseJson.date));
        }
       
        $("#total_sumkal").html(responseJson.total);
        $("#total_sumkal_right").html(responseJson.total);
        
        $("#kritis_sumkal").html(responseJson.total_kritis);
        $("#siaga_sumkal").html(responseJson.total_siaga);
        $("#normal_sumkal").html(responseJson.total_normal);

        Highcharts.chart('chart-sumkal', {
            chart: {
                type: 'bar',
                height: 700,
                marginTop: 50,
                events: {
                    load() {
                      let chart = this,
                        tickLength = chart.xAxis[0].tickPositions.length;
              
                      chart.series.forEach(s => {
                        s.points.forEach(p => {
                          //get last points
                          if (p.y <10) {
                            p.update({
                                color: {
                                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                    stops: [
                                       
                                        [0, '#C70039'],
                                        [1, '#900C3F'],
                                    ]
                                },
                            })
                          }
                          if(p.y >=10 && p.y <=15){
                            p.update({
                                color: {
                                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                    stops: [
                                        [0, '#ff9d33'],
                                        [1, '#ff5d5d']
                                    ]
                                },
                            })
                          }
                        })
                      })
                    }
                  }
            },
            title: "HOP BATUBARA SUMKAL",
            subtitle: false,
            xAxis: {
                categories: responseJson.categories, 
                title: {
                    text: null
                },
                shared: true,
                useHTML: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: '',
                    align: 'high'
                },
                //max: 100,
                labels: {
                    overflow: 'justify'
                },
                gridLineColor: '#d8dade',
                plotLines: [{
                    color: '#d1e9e1',
                    width: 4,
                    value: 15,
                    label: {
                        rotation: 0,
                        //x: -12,
                        x: 10,
                        y: -20,
                        style: {
                            color: '#7abc88',
                            fontWeight: 700
                        },
                        useHTML: true,
                        text: '<span>Normal</span><br />(>15)',
                    }

                }, 
                {
                    color: '#ffe4c0',
                    width: 4,
                    //value: 42.1,
                    value: 10,
                    label: {
                        rotation: 0,
                        //x: -15,
                        x: -6,
                        y: -20,
                        style: {
                            color: '#FFC300',
                            fontWeight: 700
                        },
                        useHTML: true,
                        text: '<span>Siaga</span><br />(10-15)',
                    },
                },
                {
                    color: '#ffe4c0',
                    width: 4,
                    //value: 42.1,
                    value: 9.9,
                    label: {
                        rotation: 0,
                        //x: -60,
                        x: -50,
                        y: -20,
                        style: {
                            color: '#C70039',
                            fontWeight: 700
                        },
                        useHTML: true,
                        text: '<span>Kritis</span><br />(<10)',
                    },
                }
                ]
            },
            tooltip: {
                headerFormat: '<table><tr><th colspan="2"><h3>{point.key}</h3></th></tr>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">HOP </td> <td>: &nbsp;<b>{point.y:2f}</td></tr>' +
                    '<tr><td style="color:{series.color};padding:0">Date </td><td>: &nbsp;<b>{point.date}</td></tr>'+
                    '<tr><td style="color:{series.color};padding:0">Status </td><td>: &nbsp;<b>{point.status}</td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true,
                style: {
                    zIndex: 999,
                },
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.2f}',
                    },
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function(e) {
                                // console.log(this.category)
                                $('#modalForm').modal('show');
                            }
                        }
                    },
                },

                bar: {
                    dataLabels: {
                        enabled: true,
                        color: '#000',
                    }
                }
            },
            credits: {
                enabled: false
            },
            legend:{ enabled:false },
            series: [{
                name: 'HOP ',
                color: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#b0df3e'],
                        [1, '#2fcea3']
                    ]
                },
                //groupPadding: 1,
                pointWidth: 7,
                data: responseJson.data,
            }]
        });
        

        //--//
    }else{
        Swal.fire({
            title: "Error!",
            text: "Refresh dan coba kembali. Jika masih error, silahkan hubungi Administrator.",
            icon: "danger",
            buttonsStyling: false,
            confirmButtonText: "Ok",
            customClass: {
                confirmButton: "btn btn-danger"
            }
        });
    }
}

async function chartBatubaraSulmapa(num){
    let type = $('input[name="filter_type"]:checked').val();
    const response = await fetch("/dashboard/batubara", {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Token' :$('meta[name="csrf-token"]').attr('content')+$('meta[name="csrf-token"]').attr('content'),
        },
        body: JSON.stringify({
            num:num,
            type:type,
            ctr:sulma,
            date:$("#filter_date").val(),
            month:$("#filter_month").val()
        })
    });

    let responseJson = await response.json();

    if(responseJson.success){
        if(type=='daily'){
            $("#date_sulmapana").html(tanggalIndoName(responseJson.date));
        }else{
            $("#date_sulmapana").html(MonthIndoName(responseJson.date));
        }
        
        $("#total_sulmapana").html(responseJson.total);
        $("#total_sulmapana_right").html(responseJson.total);
        
        $("#kritis_sulmapana").html(responseJson.total_kritis);
        $("#siaga_sulmapana").html(responseJson.total_siaga);
        $("#normal_sulmapana").html(responseJson.total_normal);

        Highcharts.chart('chart-sulmapana', {
            chart: {
                type: 'bar',
                height: 700,
                marginTop: 50,
                events: {
                    load() {
                      let chart = this,
                        tickLength = chart.xAxis[0].tickPositions.length;
              
                      chart.series.forEach(s => {
                        s.points.forEach(p => {
                          //get last points
                          if (p.y <10) {
                            p.update({
                                color: {
                                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                    stops: [
                                       
                                        [0, '#C70039'],
                                        [1, '#900C3F'],
                                    ]
                                },
                            })
                          }
                          if(p.y >=10 && p.y <=15){
                            p.update({
                                color: {
                                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                    stops: [
                                        [0, '#ff9d33'],
                                        [1, '#ff5d5d']
                                    ]
                                },
                            })
                          }
                        })
                      })
                    }
                  }
            },
            title: "HOP BATUBARA SULMAPANA",
            subtitle: false,
            xAxis: {
                categories: responseJson.categories, 
                title: {
                    text: null
                },
                shared: true,
                useHTML: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: '',
                    align: 'high'
                },
                //max: 100,
                labels: {
                    overflow: 'justify'
                },
                gridLineColor: '#d8dade',
                plotLines: [{
                    color: '#d1e9e1',
                    width: 4,
                    value: 15,
                    label: {
                        rotation: 0,
                        //x: -12,
                        x: 10,
                        y: -20,
                        style: {
                            color: '#7abc88',
                            fontWeight: 700
                        },
                        useHTML: true,
                        text: '<span>Normal</span><br />(>15)',
                    }

                }, 
                {
                    color: '#ffe4c0',
                    width: 4,
                    //value: 42.1,
                    value: 10,
                    label: {
                        rotation: 0,
                        //x: -15,
                        x: -6,
                        y: -20,
                        style: {
                            color: '#FFC300',
                            fontWeight: 700
                        },
                        useHTML: true,
                        text: '<span>Siaga</span><br />(10-15)',
                    },
                },
                {
                    color: '#ffe4c0',
                    width: 4,
                    //value: 42.1,
                    value: 9.9,
                    label: {
                        rotation: 0,
                        //x: -60,
                        x: -50,
                        y: -20,
                        style: {
                            color: '#C70039',
                            fontWeight: 700
                        },
                        useHTML: true,
                        text: '<span>Kritis</span><br />(<10)',
                    },
                }
                ]
            },
            tooltip: {
                headerFormat: '<table><tr><th colspan="2"><h3>{point.key}</h3></th></tr>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">HOP </td> <td>: &nbsp;<b>{point.y:2f}</td></tr>' +
                    '<tr><td style="color:{series.color};padding:0">Date </td><td>: &nbsp;<b>{point.date}</td></tr>'+
                    '<tr><td style="color:{series.color};padding:0">Status </td><td>: &nbsp;<b>{point.status}</td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true,
                style: {
                    zIndex: 999,
                },
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.2f}',
                    },
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function(e) {
                                // console.log(this.category)
                                $('#modalForm').modal('show');
                            }
                        }
                    },
                },

                bar: {
                    dataLabels: {
                        enabled: true,
                        color: '#000',
                    }
                }
            },
            credits: {
                enabled: false
            },
            legend:{ enabled:false },
            series: [{
                name: 'HOP ',
                color: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#b0df3e'],
                        [1, '#2fcea3']
                    ]
                },
                //groupPadding: 1,
                pointWidth: 7,
                data: responseJson.data,
            }]
        });

        //--//
    }else{
        Swal.fire({
            title: "Error!",
            text: "Refresh dan coba kembali. Jika masih error, silahkan hubungi Administrator.",
            icon: "danger",
            buttonsStyling: false,
            confirmButtonText: "Ok",
            customClass: {
                confirmButton: "btn btn-danger"
            }
        });
    }
}

async function chartDashboardStack(num){
    let type = $('input[name="filter_type"]:checked').val();
    const response = await fetch("/dashboard/batubara", {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Token' :$('meta[name="csrf-token"]').attr('content')+$('meta[name="csrf-token"]').attr('content'),
        },
        body: JSON.stringify({
            num:num,
            type:type,
            ctr:jml,
            date:$("#filter_date").val(),
            month:$("#filter_month").val()
        })
    });

    let responseJson = await response.json();

    if(responseJson.success){
        if(type=='daily'){
            $("#date_sulmapana").html(tanggalIndoName(responseJson.date));
        }else{
            $("#date_sulmapana").html(MonthIndoName(responseJson.date));
        }
        
        $("#total_sulmapana").html(responseJson.total);
        $("#total_sulmapana_right").html(responseJson.total);
        
        $("#kritis_sulmapana").html(responseJson.total_kritis);
        $("#siaga_sulmapana").html(responseJson.total_siaga);
        $("#normal_sulmapana").html(responseJson.total_normal);

        Highcharts.chart('chart-stack', {
            chart: {
                type: 'bar',
                height: 700,
                marginTop: 50,
                events: {
                    load() {
                      let chart = this,
                        tickLength = chart.xAxis[0].tickPositions.length;
              
                      chart.series.forEach(s => {
                        s.points.forEach(p => {
                          //get last points
                          if (p.y <10 && p.ket=='Hop') {
                            p.update({
                                color: {
                                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                    stops: [
                                       
                                        [0, '#C70039'],
                                        [1, '#900C3F'],
                                    ]
                                },
                            })
                          }
                          if(p.y >=10 && p.y <=15 && p.ket=='Hop'){
                            p.update({
                                color: {
                                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                    stops: [
                                        [0, '#ff9d33'],
                                        [1, '#ff5d5d']
                                    ]
                                },
                            })
                          }
                        })
                      })
                    }
                  }
            },
            title: "HOP BATUBARA JAMALI",
            subtitle: false,
            xAxis: {
                categories: responseJson.categories, 
                title: {
                    text: null
                },
                shared: true,
                useHTML: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: '',
                    align: 'high'
                },
                //max: 100,
                labels: {
                    overflow: 'justify'
                },
                gridLineColor: '#d8dade',
                plotLines: [{
                    color: '#d1e9e1',
                    width: 4,
                    value: 15,
                    label: {
                        rotation: 0,
                        //x: -12,
                        x: 10,
                        y: -20,
                        style: {
                            color: '#7abc88',
                            fontWeight: 700
                        },
                        useHTML: true,
                        text: '<span>Normal</span><br />(>15)',
                    }

                }, 
                {
                    color: '#ffe4c0',
                    width: 4,
                    //value: 42.1,
                    value: 10,
                    label: {
                        rotation: 0,
                        //x: -15,
                        x: -6,
                        y: -20,
                        style: {
                            color: '#FFC300',
                            fontWeight: 700
                        },
                        useHTML: true,
                        text: '<span>Siaga</span><br />(10-15)',
                    },
                },
                {
                    color: '#ffe4c0',
                    width: 4,
                    //value: 42.1,
                    value: 9.9,
                    label: {
                        rotation: 0,
                        //x: -60,
                        x: -50,
                        y: -20,
                        style: {
                            color: '#C70039',
                            fontWeight: 700
                        },
                        useHTML: true,
                        text: '<span>Kritis</span><br />(<10)',
                    },
                }
                ]
            },
            // tooltip: {
            //     headerFormat: '<table><tr><th colspan="2"><h3>{point.key}</h3></th></tr>',
            //     pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name} </td> <td>: &nbsp;<b>{point.y:2f}</td></tr>' +
            //         '<tr><td style="color:{series.color};padding:0">Date </td><td>: &nbsp;<b>{point.date}</td></tr>'+
            //         '<tr><td style="color:{series.color};padding:0">Status </td><td>: &nbsp;<b>{point.status}</td></tr>',
            //     footerFormat: '</table>',
            //     shared: true,
            //     useHTML: true,
            //     style: {
            //         zIndex: 999,
            //     },
            // },
            plotOptions: {
                series: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.2f}',
                    },
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function(e) {
                                // console.log(this.category)
                                $('#modalForm').modal('show');
                            }
                        }
                    },
                },

                bar: {
                    dataLabels: {
                        enabled: true,
                        color: '#000',
                    }
                }
            },
            credits: {
                enabled: false
            },
            legend:{ enabled:false },
            series: [
                {
                    name: 'Sailing ',
                    color: '#d5c80d',
                    //groupPadding: 1,
                    pointWidth: 7,
                    data: responseJson.sailing,
                },
                {
                    name: 'Apung',
                    color: '#08b3b3',
                    //groupPadding: 1,
                    pointWidth: 7,
                    data: responseJson.apung,
                },
                {
                    name: 'Normal',
                    color: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0, '#b0df3e'],
                            [1, '#2fcea3']
                        ]
                    },
                    //groupPadding: 1,
                    pointWidth: 7,
                    data: responseJson.data,
                }
            ]
        });

        //--//
    }else{
        Swal.fire({
            title: "Error!",
            text: "Refresh dan coba kembali. Jika masih error, silahkan hubungi Administrator.",
            icon: "danger",
            buttonsStyling: false,
            confirmButtonText: "Ok",
            customClass: {
                confirmButton: "btn btn-danger"
            }
        });
    }
}

function chartDashboardStack2(){
    // Data retrieved from: https://ferjedatabanken.no/statistikk
    Highcharts.chart('chart-stack2', {
        chart: {
            type: 'bar',
            marginTop: 50,
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: [
                'Suralaya 1-7', 'Suralaya 8', 'IPP Banten', 'Lontar', 'Labuan'
            ]
        },
        yAxis: {
            min: 0,
            title: {
                text: '',
                align: 'high'
            },
            //max: 100,
            labels: {
                overflow: 'justify'
            },
            gridLineColor: '#d8dade',
            plotLines: [{
                color: '#d1e9e1',
                width: 4,
                value: 15,
                label: {
                    rotation: 0,
                    //x: -12,
                    x: 10,
                    y: -20,
                    style: {
                        color: '#7abc88',
                        fontWeight: 700
                    },
                    useHTML: true,
                    text: '<span>Normal</span><br />(>15)',
                }

            }, 
            {
                color: '#ffe4c0',
                width: 4,
                //value: 42.1,
                value: 10,
                label: {
                    rotation: 0,
                    //x: -15,
                    x: -6,
                    y: -20,
                    style: {
                        color: '#FFC300',
                        fontWeight: 700
                    },
                    useHTML: true,
                    text: '<span>Siaga</span><br />(10-15)',
                },
            },
            {
                color: '#ffe4c0',
                width: 4,
                //value: 42.1,
                value: 9.9,
                label: {
                    rotation: 0,
                    //x: -60,
                    x: -50,
                    y: -20,
                    style: {
                        color: '#C70039',
                        fontWeight: 700
                    },
                    useHTML: true,
                    text: '<span>Kritis</span><br />(<10)',
                },
            }
            ]
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            series: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [{
            name: 'Sailing',
            color:"#d5c80d",
            data: [3.4, 3.10, 10.40, 3.9, 2.7]
        }, {
            name: 'Apung',
            color:"#99a3a4",
            data: [2.7, 4.3, 8.5, 9.3, 7.4]
        }, {
            name: 'HOP Normal',
            color:'#08b3b3',
            data: [24.7, 28, 17.5, 20.5, 18.3]
        }]
    });

}

  chartBatubaraJamali(num);
  chartBatubaraSumkal(num);
  chartBatubaraSulmapa(num);

  function tanggalIndoName(tgl=''){
    if(tgl!='' && tgl!=null && tgl!=undefined){
        var t = tgl.toString().split("-");
       

        var BulanIndo = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        var indo = t[2]+' '+BulanIndo[parseInt(t[1])-1]+' '+t[0];
    }else{
        var indo = '';
    }
    return indo;
}

function MonthIndoName(tgl=''){
    if(tgl!='' && tgl!=null && tgl!=undefined){
        var t = tgl.toString().split("-");
       

        var BulanIndo = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        var indo = BulanIndo[parseInt(t[1])-1]+' '+t[0];
    }else{
        var indo = '';
    }
    return indo;
}

function loader(show=1){
    Swal.fire({
        title: "",
        text: "sedang memuat data, harap tunggu !.",
        timer: 2000,
        didOpen: function() {
            Swal.showLoading()
        }
    })
    
    
}



jQuery(document).ready(function() {

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    chartDashboardStack(num);
    chartDashboardStack2(num);

    $('.show_date_picker').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true

    });

    $('.filter_month').datepicker({
        format: "yyyy-mm",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true

    });

    $("#show_date").html(tanggalIndoName(current_date));
    
    $("#filter_date").change(function(){
        let date =  $("#filter_date").val();
        var tanggal = tanggalIndoName(date);
        $("#show_date").html(tanggal);
        chartBatubaraJamali(2);
        chartBatubaraSumkal(2);
        chartBatubaraSulmapa(2);
        
    });

    $("#filter_month").change(function(){
        let month =  $("#filter_month").val();
        let monthname = MonthIndoName(month);
        $("#show_date").html(monthname);
        chartBatubaraJamali(2);
        chartBatubaraSumkal(2);
        chartBatubaraSulmapa(2);
        
    });

    $(".filter_type").change(function(){
        let type = $('input[name="filter_type"]:checked').val();
        if(type=='daily'){
            $('.filter_field_date').show();
            $('.filter_field_month').hide();
        }else{
            $('.filter_field_date').hide();
            $('.filter_field_month').show();
        }
        
    });
});
    
  setTimeout(function(){
    window.location.reload(1);
 }, 3600000);

  
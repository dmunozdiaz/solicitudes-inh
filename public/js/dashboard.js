var Dashboard = (function() {
  var target = document.querySelector("#kt_body");

  var blockUI = new KTBlockUI(target, {
    zIndex: 20000,
    message:
      '<div class="blockui-message"><span class="spinner-border text-primary"></span> Cargando...</div>'
  });

  var chart = {
    self: null,
    rendered: false
  };

  var chart2 = {
    self: null,
    rendered: false
  };

  var chart3 = {
    self: null,
    rendered: false
  };

  var bloqueo = function() {
    blockUI.block();

    setTimeout(function() {
      blockUI.release();
    }, 1000);
  };
  var handleDashboard = function() {
    var start = moment().subtract(6, "days");
    var end = moment();

    $("#kt_daterangepicker_6").daterangepicker(
      {
        buttonClasses: "btn",
        applyClass: "btn-primary",
        cancelClass: "btn-secondary",

        startDate: start,
        endDate: end,
        locale: {
          applyLabel: "Aplicar",
          cancelLabel: "Cancelar",
          fromLabel: "Desde",
          toLabel: "hasta",
          customRangeLabel: "Seleccionar otro periodo",
          daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
          monthNames: [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
          ],
          firstDay: 1
        },
        ranges: {
          "Últimos 7 días": [moment().subtract(6, "days"), moment()],
          "Último mes": [moment().subtract(29, "days"), moment()]
        }
      },
      function(start, end, label) {
        console.log(start);

        $("#kt_daterangepicker_6 .form-control").val(
          start.format("DD/MM/YYYY") + " / " + end.format("DD/MM/YYYY")
        );
      }
    );

    $("#periodo2").val(
      start.format("DD/MM/YYYY") + " / " + end.format("DD/MM/YYYY")
    );

    $("#kt_daterangepicker_6").on("apply.daterangepicker", function(
      ev,
      picker
    ) {
      cargarIndicadores();
    });

    $("#kt_daterangepicker_5").daterangepicker(
      {
        buttonClasses: "btn",
        applyClass: "btn-primary",
        cancelClass: "btn-secondary",

        startDate: start,
        endDate: end,
        locale: {
          applyLabel: "Aplicar",
          cancelLabel: "Cancelar",
          fromLabel: "Desde",
          toLabel: "hasta",
          customRangeLabel: "Seleccionar otro periodo",
          daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
          monthNames: [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
          ],
          firstDay: 1
        },
        ranges: {
          "Últimos 7 días": [moment().subtract(6, "days"), moment()],
          "Último mes": [moment().subtract(29, "days"), moment()]
        }
      },
      function(start, end, label) {
        console.log(start);

        $("#kt_daterangepicker_5 .form-control").val(
          start.format("DD/MM/YYYY") + " / " + end.format("DD/MM/YYYY")
        );
      }
    );
    $("#periodo1").val(
      start.format("DD/MM/YYYY") + " / " + end.format("DD/MM/YYYY")
    );

    $("#kt_daterangepicker_5").on("apply.daterangepicker", function(
      ev,
      picker
    ) {
      cargarIndicadores();
    });

    $("#direccion").select2({
      placeholder: "Seleccione una Dirección",
      language: {
        noResults: function() {
          return "No se han encontrado resultados";
        }
      }
    });

    $("#tposolicitud").select2({
      placeholder: "Seleccione un Tipo de Solicitud",
      language: {
        noResults: function() {
          return "No se han encontrado resultados";
        }
      }
    });

    $("#direccion").change(function() {
      cargarIndicadores();
    });

    $("#tposolicitud").change(function() {
      cargarIndicadores();
    });

    $("#anio").change(function() {
      cargarIndicadores();
    });

    $("#direccion").change(function() {
      cargarTiposSolicitudes();
    });

  };

  var cargarTiposSolicitudes = function() {
   
    $.ajax({
      url: "/dashboard/cargar-tipo-solicitudes",
      type: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      data: {
        direccion: $("#direccion").val(),
       
      },
      success: function success(data) {
        console.log(data);

        $('#tposolicitud').html('');
        var shtml = '<option></option>';
        $.each(data, function( index, value ) {
          shtml += ' <option value="'+value.id+'">'+value.nombresolicitud+'</option>'
        });
        $('#tposolicitud').html(shtml);
      },
      error: function error(jqXHR, textStatus, errorThrown) {
        //KTApp.unblockPage();
        console.log(errorThrown);
      }
    });
  };

  var cargarIndicadores = function() {
    bloqueo();
    $.ajax({
      url: "/dashboard/indicadores",
      type: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      data: {
        direccion: $("#direccion").val(),
        tipsolicitud: $("#tposolicitud").val(),
        anio: $("#anio").val(),
        periodo1: $("#periodo1").val().replaceAll('/','aaaa'),
        periodo2: $("#periodo2").val().replaceAll('/','aaaa')
      },
      success: function success(data) {
        // KTApp.unblockPage();
        $("#tiempomaximoenproceso").html(
          Math.round(data.tiempoMaximoEnProceso.tiempomaximoenproceso) + " días"
        );
        $("#tiempomaximorespuesta").html(
          Math.round(data.tiempoMaximoRespuesta.tiempomaximorespuesta) + " días"
        );
        $("#tiempomaximototalrespuesta").html(
          Math.round(
            data.tiempoMaximoTotalRespuesta.tiempomaximototalrespuesta
          ) + " días"
        );
        $("#tiempopromedio").html(
          Math.round(data.tiempoPromedio.tiempopromedio) + " días"
        );
        $("#tiempopromedioenproceso").html(
          Math.round(data.tiempoPromedioEnProceso.tiempopromedioenproceso) +
            " días"
        );
        $("#tiempopromediototalrespuesta").html(
          Math.round(
            data.tiempoPromedioTotalRespuesta.tiempopromediototalrespuesta
          ) + " días"
        );

        $("#iexpiraingresada").html(data.semaforo.iExpiraIngresada);
        $("#iingresadas").html(data.semaforo.iIngresadas);
        $("#iexpiraproceso").html(data.semaforo.iExpiraProceso);
        $("#iproceso").html(data.semaforo.iProceso);

        $("#total_solicitudes").html(data.semaforo.iTotal);
        $("#total_ingresadas").html(data.semaforo.iIngresadas);
        $("#total_enproceso").html(data.semaforo.iProceso);
        $("#total_terminada").html(data.semaforo.iTerminado);

        initChart([
          data.graficocantsolicitudes.ingresada.solicitudes,
          data.graficocantsolicitudes.enproceso.solicitudes,
          data.graficocantsolicitudes.terminada.solicitudes
        ]);

        initChart2(
          data.graficosolpormesingresados,
          data.graficosolpormesingresadoster
        );

        initChar3(data.graficodemandas);
      },
      error: function error(jqXHR, textStatus, errorThrown) {
        //KTApp.unblockPage();
        console.log(errorThrown);
      }
    });
  };

  var initChart = function(data) {
    var element = document.getElementById("kt_charts_widget_18_chart");

    if (!element) {
      return;
    }

    var height = parseInt(KTUtil.css(element, "height"));
    var labelColor = KTUtil.getCssVariableValue("--bs-gray-900");
    var borderColor = KTUtil.getCssVariableValue("--bs-border-dashed-color");

    if (chart.rendered == false) {
      var options = {
        series: [
          {
            name: "Solicitudes",
            data: data
          }
        ],
        chart: {
          fontFamily: "inherit",
          type: "bar",
          height: height,
          toolbar: {
            show: false
          }
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: ["28%"],
            borderRadius: 5,
            dataLabels: {
              position: "top" // top, center, bottom
            },
            startingShape: "flat"
          }
        },
        legend: {
          show: false
        },
        dataLabels: {
          enabled: true,
          offsetY: -28,
          style: {
            fontSize: "13px",
            colors: [labelColor]
          },
          formatter: function(val) {
            return val; // + "H";
          }
        },
        stroke: {
          show: true,
          width: 2,
          colors: ["transparent"]
        },
        xaxis: {
          categories: ["Ingresada", "En proceso", "Terminada"],
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          labels: {
            style: {
              colors: KTUtil.getCssVariableValue("--bs-gray-500"),
              fontSize: "13px"
            }
          },
          crosshairs: {
            fill: {
              gradient: {
                opacityFrom: 0,
                opacityTo: 0
              }
            }
          }
        },
        yaxis: {
          labels: {
            style: {
              colors: KTUtil.getCssVariableValue("--bs-gray-500"),
              fontSize: "13px"
            },
            formatter: function(val) {
              return val;
            }
          }
        },
        fill: {
          opacity: 1
        },
        states: {
          normal: {
            filter: {
              type: "none",
              value: 0
            }
          },
          hover: {
            filter: {
              type: "none",
              value: 0
            }
          },
          active: {
            allowMultipleDataPointsSelection: false,
            filter: {
              type: "none",
              value: 0
            }
          }
        },
        tooltip: {
          style: {
            fontSize: "12px"
          },
          y: {
            formatter: function(val) {
              return +val;
            }
          }
        },
        colors: [
          KTUtil.getCssVariableValue("--bs-primary"),
          KTUtil.getCssVariableValue("--bs-primary-light")
        ],
        grid: {
          borderColor: borderColor,
          strokeDashArray: 4,
          yaxis: {
            lines: {
              show: true
            }
          }
        }
      };

      chart.self = new ApexCharts(element, options);

      // Set timeout to properly get the parent elements width
      setTimeout(function() {
        chart.self.render();
        chart.rendered = true;
      }, 200);
    } else {
      chart.self.updateSeries([
        {
          data: data
        }
      ]);
    }
  };

  var initChart2 = function(ingresado, terminada) {
    var element = document.getElementById("kt_charts_widget_36");

    if (!element) {
      return;
    }

    ingresadoAux = [];
    for (var i in ingresado) {
      ingresadoAux.push(ingresado[i]);
    }

    terminadaAux = [];
    for (var i in terminada) {
      terminadaAux.push(terminada[i]);
    }

    if (chart2.rendered == false) {
      var options = {
        series: [
          {
            name: "Solicitudes Recibidas",
            data: ingresadoAux
          },
          {
            name: "Solicitudes Terminadas",
            data: terminadaAux
          }
        ],
        chart: {
          height: 350,
          type: "area",
          zoom: {
            enabled: false
          },
          toolbar: {
            show: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: "smooth"
        },
        xaxis: {
          type: "categorie",
          categories: [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
          ]
        }
      };

      chart2.self = new ApexCharts(element, options);

      setTimeout(function() {
        chart2.self.render();
        chart2.rendered = true;
      }, 200);
    } else {
      chart2.self.updateSeries([
        {
          name: "Solicitudes Recibidad",
          data: ingresadoAux
        },
        {
          name: "Solicitudes Terminadas",
          data: terminadaAux
        }
      ]);
    }
  };

  var initChar3 = function(graficodemandas) {
    var element = document.getElementById("kt_charts_widget_6");

    valores = [];
    categorias = [];

    for (var i in graficodemandas) {
      valores.push(graficodemandas[i]);
      categorias.push(graficodemandas[i].x);
    }

    if (!element) {
      return;
    }

    var labelColor = KTUtil.getCssVariableValue("--bs-gray-800");
    var borderColor = KTUtil.getCssVariableValue("--bs-border-dashed-color");
    var maxValue = 18;
    var options = {
      series: [
        {
          name: "Solicitudes",
          data: valores
        }
      ],
      chart: {
        fontFamily: "inherit",
        type: "bar",
        height: 350,
        toolbar: {
          show: false
        }
      },
      plotOptions: {
        bar: {
          borderRadius: 8,
          horizontal: true,
          distributed: true,
          barHeight: 50,
          dataLabels: {
            position: "bottom" // use 'bottom' for left and 'top' for right align(textAnchor)
          }
        }
      },
      dataLabels: {
        // Docs: https://apexcharts.com/docs/options/datalabels/
        enabled: true,
        textAnchor: "start",
        offsetX: 0,
        formatter: function(val, opts) {
          var Format = wNumb({
            //prefix: '$',
            //suffix: ',-',
            thousand: "."
          });

          return Format.to(val);
        },
        style: {
          fontSize: "14px",
          fontWeight: "600",
          align: "left"
        }
      },
      legend: {
        show: false
      },
      colors: ["#3E97FF", "#F1416C", "#50CD89", "#FFC700", "#7239EA"],
      xaxis: {
        categories: categorias,
        labels: {
          formatter: function(val) {
           
            return val;
          },
          style: {
            colors: [labelColor],
            fontSize: "14px",
            fontWeight: "600",
            align: "left"
          }
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        labels: {
          formatter: function(val, opt) {
            return val;
          },
          style: {
            colors: labelColor,
            fontSize: "14px",
            fontWeight: "600"
          },
          offsetY: 2,
          align: "left"
        }
      },
      grid: {
        borderColor: borderColor,
        xaxis: {
          lines: {
            show: true
          }
        },
        yaxis: {
          lines: {
            show: false
          }
        },
        strokeDashArray: 4
      },
      tooltip: {
        style: {
          fontSize: "12px"
        },
        custom: function({series, seriesIndex, dataPointIndex, w}) {
          var data = w.globals.initialSeries[seriesIndex].data[dataPointIndex];
          
          return '<ul>' +
          '<li><b>Price</b>: ' + data.x + '</li>' +
          '<li><b>Number</b>: ' + data.y + '</li>' +
          '<li><b>Product</b>: \'' + data.product + '\'</li>' +
          '<li><b>Info</b>: \'' + data.info + '\'</li>' +
          '<li><b>Site</b>: \'' + data.site + '\'</li>' +
          '</ul>';
        }
      }
    };

    var options = {
      chart: {
        fontFamily: "inherit",
        type: "bar",
        height: 350,
        toolbar: {
          show: false
        }
      },
      plotOptions: {
        bar: {
          borderRadius: 8,
          horizontal: true,
          distributed: true,
          barHeight: 50,
          dataLabels: {
            position: "bottom" // use 'bottom' for left and 'top' for right align(textAnchor)
          }
        }
      },
      series: [
        {
          name: "Series 1",
          data: valores
        }
      ],
      dataLabels: {
        // Docs: https://apexcharts.com/docs/options/datalabels/
        enabled: true,
        textAnchor: "start",
        offsetX: 0,
        formatter: function(val, opts) {
          var Format = wNumb({
            //prefix: '$',
            //suffix: ',-',
            thousand: "."
          });

          return Format.to(val);
        },
        style: {
          fontSize: "14px",
          fontWeight: "600",
          align: "left"
        }
      },
      legend: {
        show: false
      },
      colors: ["#3E97FF", "#F1416C", "#50CD89", "#FFC700", "#7239EA"],
      xaxis: {
        categories: categorias,
        labels: {
          formatter: function(val) {
           
            return val;
          },
          style: {
            colors: [labelColor],
            fontSize: "14px",
            fontWeight: "600",
            align: "left"
          }
        },
        axisBorder: {
          show: false
        }
      },
      grid: {
        borderColor: borderColor,
        xaxis: {
          lines: {
            show: true
          }
        },
        yaxis: {
          lines: {
            show: false
          }
        },
        strokeDashArray: 4
      },
      tooltip: {
        style: {
          fontSize: "12px"
        },
        custom: function({series, seriesIndex, dataPointIndex, w}) {
          var data = w.globals.initialSeries[seriesIndex].data[dataPointIndex];
          
          return '<ul>' +
          '<li> ' + data.nombresolicitud + '</li>' +
          '<li> Solicitudes: ' + data.y + '</li>' +
          
          '</ul>';
        }
      }
    };

    if (chart3.rendered == false) {
      chart3.self = new ApexCharts(element, options);

      // Set timeout to properly get the parent elements width
      setTimeout(function() {
        chart3.self.render();
        chart3.rendered = true;
      }, 200);
    } else {
      chart3.self.updateOptions(options);
    }
  };

  return {
    //main function to initiate the module
    init: function() {
      handleDashboard();
      // initChart(chart, [54, 42, 75]);
     // cargarTiposSolicitudes();
      cargarIndicadores();
      $.ajaxSetup({ cache: false });
    },

    clear: function() {}
  };
})();

jQuery(document).ready(function() {
  Dashboard.init();
});

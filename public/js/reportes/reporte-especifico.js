var target = document.querySelector("#kt_body");

var blockUI = new KTBlockUI(target, {
  message:
    '<div class="blockui-message"><span class="spinner-border text-primary"></span> Enviando Datos...</div>'
});

var targetEstado = document.querySelector("#div_estado");

var blockUIEstado = new KTBlockUI(targetEstado, {
  message:
    '<div class="blockui-message"><span class="spinner-border text-primary"></span> Cargando...</div>'
});

/******/ (() => { // webpackBootstrap
    var __webpack_exports__ = {};
    /*!*****************************************!*\
      !*** ./resources/js/tareas/bandejas.js ***!
      \*****************************************/
   
    
    var page = function () {
     
      var the = this;
    
      var refreshTable = function refreshTable() {
        $('#refresh-table').on('click', function () {
          _requestStatus();
        });
      };
    
      
    
      var _requestStatus = function getTareasSupervisor() {
        
        $.ajax({
          url: '/reportes/reporte-especifico/listreportes',
          type: 'GET',
          success: function success(data) {
           // KTApp.unblockPage();
            $('#tabla_reporte').DataTable({
              processing: true,
              data: data.data,
              "bPaginate": false,
              "bInfo": false,
              destroy: true,
              columnDefs: [{
                targets: 2,
                className: "truncate"
              }],
              order: [[0, 'desc']],
              createdRow: function createdRow(row) {
                var td = $(row).find(".truncate");
                td.attr("title", td.html());
              },
              columns:  [{
                data: 'id',
                className: 'text-center'
              },{
                data: 'area',
                "defaultContent": "No Selecionado",
                className: 'truncate'
              }, {
                data: "descsolicitud",
                "defaultContent": "No Selecionado",
                className: 'text-center'
              }, {
                data: "anio",
                "defaultContent": "No Selecionado",
                className: 'text-center'
              }, {
                data: "descestado",
                "defaultContent": "No Selecionado",
                className: 'text-center'
              }, {
                data: {
                  'estadoreporte': 'estadoreporte',
                  "defaultContent": "No Selecionado",
                  'id': 'id'
                },
                render: function render(data) {

                  if(data.estadoreporte == 1){
                    return `<span class="btn btn-clean btn-sm btn-icon btn-icon-ligth ms-auto curso-default" data-request-element="button">
                    <!--begin::Svg Icon | path: icons/duotone/Layout/Layout-4-blocks-2.svg-->
                    <span class="svg-icon svg-icon-2">
                        <!--begin::Svg Icon-->
                        <span class="svg-icon svg-icon-muted svg-icon-2hx animation-blink">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <circle fill="#000000" cx="5" cy="12" r="2"/>
                                    <circle fill="#000000" cx="12" cy="12" r="2"/>
                                    <circle fill="#000000" cx="19" cy="12" r="2"/>
                                </g>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </span>
                    <!--end::Svg Icon-->
                </span>`;
                  }else if(data.estadoreporte == 2){
                    return `<span class="btn btn-clean btn-sm btn-icon btn-icon-ligth ms-auto curso-default" data-request-element="button">
                    <!--begin::Svg Icon | path: icons/duotone/Layout/Layout-4-blocks-2.svg-->
                    <span class="svg-icon svg-icon-2">
                        <!--begin::Svg Icon-->
                                        <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Code/Stop.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"/>
                        <path d="M12,22 C6.4771525,22 2,17.5228475 2,12 C2,6.4771525 6.4771525,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 Z M12,20 C16.418278,20 20,16.418278 20,12 C20,7.581722 16.418278,4 12,4 C7.581722,4 4,7.581722 4,12 C4,16.418278 7.581722,20 12,20 Z M19.0710678,4.92893219 L19.0710678,4.92893219 C19.4615921,5.31945648 19.4615921,5.95262146 19.0710678,6.34314575 L6.34314575,19.0710678 C5.95262146,19.4615921 5.31945648,19.4615921 4.92893219,19.0710678 L4.92893219,19.0710678 C4.5384079,18.6805435 4.5384079,18.0473785 4.92893219,17.6568542 L17.6568542,4.92893219 C18.0473785,4.5384079 18.6805435,4.5384079 19.0710678,4.92893219 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                    </g>
                </svg><!--end::Svg Icon--></span>
                    </span>
                    <!--end::Svg Icon-->
                </span>`;

                  }else if(data.estadoreporte == 3){
                    return `<a href="/download-reporte-especial/${data.id}"  class="btn btn-clean btn-sm btn-icon btn-icon-ligth ms-auto curso-default" data-request-element="button">
                    <!--begin::Svg Icon | path: icons/duotone/Layout/Layout-4-blocks-2.svg-->
                    <span class="svg-icon svg-icon-2">
                        <!--begin::Svg Icon-->
                        
                        <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Files/Download.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <rect x="0" y="0" width="24" height="24"/>
                              <path d="M2,13 C2,12.5 2.5,12 3,12 C3.5,12 4,12.5 4,13 C4,13.3333333 4,15 4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 C2,15 2,13.3333333 2,13 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                              <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 8.000000) rotate(-180.000000) translate(-12.000000, -8.000000) " x="11" y="1" width="2" height="14" rx="1"/>
                              <path d="M7.70710678,15.7071068 C7.31658249,16.0976311 6.68341751,16.0976311 6.29289322,15.7071068 C5.90236893,15.3165825 5.90236893,14.6834175 6.29289322,14.2928932 L11.2928932,9.29289322 C11.6689749,8.91681153 12.2736364,8.90091039 12.6689647,9.25670585 L17.6689647,13.7567059 C18.0794748,14.1261649 18.1127532,14.7584547 17.7432941,15.1689647 C17.3738351,15.5794748 16.7415453,15.6127532 16.3310353,15.2432941 L12.0362375,11.3779761 L7.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000004, 12.499999) rotate(-180.000000) translate(-12.000004, -12.499999) "/>
                          </g>
                      </svg><!--end::Svg Icon--></span>
                     
                    </span>
                    <!--end::Svg Icon-->
                </a>`;
                  }
                 
                },
                className: 'text-center'
              }],
              language: {
                "sProcessing": "<span class='sr-only' style='z-index: 2000'>Espere un momento...</span>",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                  "sFirst": "Primero",
                  "sLast": "Último",
                  "sNext": "Siguiente",
                  "sPrevious": "Anterior"
                },
                "oAria": {
                  "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                  "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
              },
              searching: false
            });
          },
          error: function error(jqXHR, textStatus, errorThrown) {
           // KTApp.unblockPage();
          }
        });
      };
    
    
      var generarReporte = function filtarSupervisor() {
        $('#generar_reporte').on('click', function () {
          $("#direccion_alert").html("");
          $("#direccion").removeClass("is-invalid");
          $("#area_alert").html("");
          $("#area").removeClass("is-invalid");
          $("#anio_alert").html("");
          $("#anio").removeClass("is-invalid");
        
                  

          blockUI.block();

          $.ajax({
            url: '/reportes/reporte-especifico/generar',
            type: 'POST',
            dataType: "json",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
              area: $("#area").val(),
              proceso: $("#proceso").val(),
              descproceso: $("#proceso option:selected").text(),
              anio: $('#anio').val(),
              estado: $('#estado').val(),
              descestado: $('#estado option:selected').text()
            },
            success: function success(data) {
             blockUI.release();

             Swal.fire({
              position: "center",
              icon: "success",
              title: "¡Solicitud de reporte enviada con éxito!",
              html: "El reporte ya se está generando. Cuando esté listo, se le enviará una notificación a su email",
              showConfirmButton: true,
             
            });

            _getDataStatus();
    
             
            },
            error: function error(jqXHR, textStatus, errorThrown) {
                
                if (jqXHR.responseJSON.message == "The given data was invalid.") {
       
                  $.each(jqXHR.responseJSON.errors, function(index, value) {
                    $("#" + index + "_alert").html("");
                    $("#" + index).addClass("is-invalid");
                    $("#" + index + "_alert").append(
                      "<div data-field='tipo_documento' data-validator='notEmpty' class='fv-help-block'>" +
                        value[0] +
                        "</div>"
                    );
                    $("#" + index + "_alert").css("color", "#F64E60");
                  });
                }
                blockUI.release();
            }
          });
        });
      };
    
      var _getDataStatus = function () {

        if (the.askStatus) {
            _stopAskStatus()
        }

        // 30 segundos despues y asi sucesivamente
        the.askStatus = setInterval(_requestStatus, 15000);

        // inicio
        _requestStatus();

        if (KTUtil.hasClass(document.body, 'page-loading')) {
            KTUtil.removeClass(document.body, 'page-loading');
        }

    };

    var _stopAskStatus = function () {

        // console.log('stop');
        clearInterval(the.askStatus);
        the.askStatus = null;

    };
    
      var tabs = function tabs() {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href");
    
          if (target == '#tab_recibidas') {
            $('#filtrar_porhacer').click();
          } else if (target == '#tab_ejecutadas') {
            $('#filtrar_ejecutadas').click();
          } else if (target == '#tab_portomar') {
            $('#filtrar_supervisor').click();
          } else if (target == '#tab_supervisor') {
            $('#filtrar_portomar').click();
          }
        });
      };
    
      var modal = function modal() {
      
        $('#pm_form').on('shown.bs.modal', function (e) {
          
          var title = $(e.relatedTarget).data('title');
          var number = $(e.relatedTarget).data('number');
          var subTitle = $(e.relatedTarget).data('subtitle');
          var url = $(e.relatedTarget).data('url');
          var url_iframe = $(e.relatedTarget).data('iframe-url');
          var appuid = $(e.relatedTarget).data('appuid');
          var portomar = $(e.relatedTarget).data('portomar');
          
          $("#titleModal").html('Tarea Nº ' + number +' - '+title +'<span class="d-block text-muted font-size-sm" >'+subTitle+'</span>' );
         
          
          var url = $(e.relatedTarget).data('url');
          $.get(url, function (response) {
            
            $("#bandejaModalContent").html(response);

            if(portomar==1){  
              $('#iframe-prueba').css('display', 'none');
              $('#appuid').val(appuid);
              $('#urliframe').val(url_iframe);
              $('#tomar_solicitud').css('display', '');
            }else if (url_iframe != undefined) {
              $('#iframe-prueba').css('display', '');
              $("#iframe-prueba").attr({
                src: url_iframe,
                height: 600
              });
              $('#appuid').val('');
              $('#urliframe').val('');
              $('#tomar_solicitud').css('display', 'none');
            } else {
               $('#iframe-prueba').css('display', 'none');
                $('#appuid').val('');
                $('#urliframe').val('');
                $('#tomar_solicitud').css('display', 'none');  
            }
          }, 'html');
        });

        $('#pm_form').on('hidden.bs.modal', function (e) {
          $('#refresh-table').click();
        });
      };
      var limpiar = function cerrarModal() {
        $('#limpiar').on('click', function () {

          
          $("#area").removeClass("is-invalid");
          $("#proceso").removeClass("is-invalid");
          $("#anio").removeClass("is-invalid");
          $("#estado").removeClass("is-invalid");

         
          $('#area').val('');
          $('#proceso').val('');
          $('#anio').val('');
          $('#estado').val('');

          
          $("#area_alert").empty();
          $("#proceso_alert").empty();
          $("#anio_alert").empty();
          $("#estado_alert").empty();
        });
        
      };
    
      var cerrarModal = function cerrarModal() {
        $('#pm_form').modal('hide');
        
      };
    
      return {
        init: function init() {
         
          
          
          /*$('#proceso').change(function() {
            if(this.value == ""){
                $("#estado").html('<option value="">Seleccione un Estado</option>');
            }else{
              blockUIEstado.block();
              $.ajax({
                url: '/task-process/'+this.value,
                type: 'GET',
                success: function success(data) {
                  var html = '<option value="">Seleccione un Estado</option>';

                  $.each(data.task, function(index, value) {
                    
                      html += "<option value='" + value.TAS_UID + "'>" + value.TAS_TITLE + "</option>";
                   
                
                  }); 

                  $("#estado").html(html);
                  blockUIEstado.release();
                },
                error: function error(jqXHR, textStatus, errorThrown) {
                 // KTApp.unblockPage();
                 blockUIEstado.release();
                }
              });
                
            }
           });*/
          refreshTable();
         
         
         
          generarReporte();
          tabs();
          modal();
          limpiar();
          the.askStatus = null;

           // busca datos de las bases generadas
        _getDataStatus();
        },
        closeModal: function closeModal() {
          cerrarModal();
        }
      };
    }();
    
    $(document).ready(function () {
      $("#content").removeClass("container");
      $("#content").addClass("container-fluid");

      $('#portomar_estado, #kt_select2_1_validate').select2({
        placeholder: 'Seleccione un estado'
    });

      page.init();
    });
    var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
    var eventer = window[eventMethod];
    var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message"; // Listen to message from child window
    
    eventer(messageEvent, function (e) {
      console.log("Mensaje desde processmaker...");
      /**if (e.data !== $('#url_valida').val()) {
        return;
      }**/
    
      page.closeModal();
    }, false);
    /******/ })()
    ;
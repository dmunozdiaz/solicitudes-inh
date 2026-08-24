/******/ (() => { // webpackBootstrap
    var __webpack_exports__ = {};
    /*!*****************************************!*\
      !*** ./resources/js/tareas/bandejas.js ***!
      \*****************************************/
   
    
    var page = function () {
      var getTareasPorHacer = function getTareasPorHacer() {
       /* KTApp.blockPage({
          overlayColor: "#000",
          opacity: "0.3"
        });*/
        $.ajax({
          url: '/porhacer',
          type: 'GET',
          success: function success(data) {
            //KTApp.unblockPage();
            $('#tabla_recibidas').DataTable({
              processing: true,
              data: data.data,
              destroy: true,
              columnDefs: [{
                targets: 2,
                className: "truncate"
              }],
              createdRow: function createdRow(row) {
                var td = $(row).find(".truncate");
                td.attr("title", td.html());
              },
              columns: [{
                data: 'app_number',
                className: 'text-center'
              }, {
                data: 'tipo_solicitud',
                className: 'truncate'
              }, {
                data: "fecha",
                className: 'truncate'
              }, {
                data: "datos-solicitante",
                className: 'truncate'
              },  {
                data: "last_update",
                className: 'text-center'
              }, 
              {
                data:{
                  "del_task_due_date": "del_task_due_date",
                  "expire": "expire"
                } ,
                className: 'text-center',
                render: function render(row) {

                  if(row.expire == false){
                    return  '<span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">' +row.del_task_due_date + '</span>';
                  }

                  return '<span class="badge badge-light-danger fw-bolder fs-8 px-2 py-1 ms-2">' + row.del_task_due_date + '</span>';
                }
              },
              {
                data: "task",
                className: 'text-center'
              },
              /*{
                  data: "action",
                    render: function (data){
                      console.log(data);
                      return '\
                      <span style="overflow: visible; position: relative; width: 110px;">\
                        <a href="javascript:;" data-toggle="modal" data-target="#pm_form" data-number="'+ data.app_number + '"  data-title="'+ data.app_tas_title + '"  data-subtitle="' + data.app_pro_title + '" data-url="' + data.urlhistorial + '"  data-iframe-url="' + data.urliframe + '"  class="btn-bootstrap-modal' + data.case_id + ' m-portlet__nav-link2 btn m-btn m-btn--hover-metal m-btn--icon m-btn--icon-only m-btn--pill" title="Ver detalles"><i class="la la-edit"></i></a>\
                      \
                    ';
                  }
              }*/
              {
                data: {
                  'app_number': 'app_number',
                  'app_tas_title': 'app_tas_title',
                  'app_pro_title': 'app_pro_title',
                  'urlhistorial': 'urlhistorial',
                  'urliframe': 'urliframe',
                  'case_id': 'case_id'
                },
                render: function render(data) {
                  return '\
                          <span style="overflow: visible; position: relative; width: 110px;">\
                            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#pm_form" data-number="' + data.app_number + '"  data-title="' + data.app_tas_title + '"  data-subtitle="' + data.app_pro_title + '" data-url="' + data.urlhistorial + '"  data-iframe-url="' + data.urliframe + '"  class="btn-bootstrap-modal' + data.case_id + ' m-portlet__nav-link2 btn m-btn m-btn--hover-metal m-btn--icon m-btn--icon-only m-btn--pill" title="Ver detalles">\
                              <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Design/Edit.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                  <rect x="0" y="0" width="24" height="24"/>\
                                  <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>\
                                  <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>\
                              </g>\
                          </svg><!--end::Svg Icon--></span>\
                            </a>\
                          \
                          ';
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
              /**fnDrawCallback: function () {
                  $('[data-toggle="tooltip"]').tooltip();
                  habilitarBotonConfirmar();
              }**/
    
            });
          },
          error: function error(jqXHR, textStatus, errorThrown) {
           // KTApp.unblockPage();
          }
        });
      };
    
      var refreshTable = function refreshTable() {
        $('#refresh-table').on('click', function () {
          getTareasPorHacer();
          getTareasEjecutadas();
          getTareasPorTomar();
        });
      };
    
      var getTareasEjecutadas = function getTareasEjecutadas() {
       /* KTApp.blockPage({
          overlayColor: "#000",
          opacity: "0.3"
        });*/
        $.ajax({
          url: '/ejecutadas',
          type: 'GET',
          success: function success(data) {
           // KTApp.unblockPage();
            $('#tabla_ejecutadas').DataTable({
              processing: true,
              data: data.data,
              destroy: true,
              order: [[0, 'desc']],
              columnDefs: [{
                targets: 2,
                className: "truncate"
              }],
              createdRow: function createdRow(row) {
                var td = $(row).find(".truncate");
                td.attr("title", td.html());
              },
              columns: [{
                data: 'app_number',
                className: 'text-center'
              }, {
                data: 'app_pro_title',
                className: 'truncate'
              }, {
                data: 'datos-solicitante',
                className: 'truncate'
              }, {
                data: "usrcr_usr_firstname",
                className: 'text-center'
              }, {
                data: "app_update_date",
                className: 'text-center'
              }, {
                data: "task",
                className: 'text-center'
              }, {
                data: {
                  'app_number': 'app_number',
                  'app_tas_title': 'app_tas_title',
                  'task': 'task',
                  'urlhistorial': 'urlhistorial',
                  'urliframe': 'urliframe',
                  'case_id': 'case_id'
                },
                render: function render(data) {
                  return '\
                          <span style="overflow: visible; position: relative; width: 110px;">\
                            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#pm_form" data-number="' + data.app_number + '"  data-title="' + data.task + '"  data-subtitle="' + data.app_pro_title + '" data-url="' + data.urlhistorial + '"  class="btn-bootstrap-modal' + data.case_id + ' m-portlet__nav-link2 btn m-btn m-btn--hover-metal m-btn--icon m-btn--icon-only m-btn--pill" title="Ver detalles">\
                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Search.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                <rect x="0" y="0" width="24" height="24"/>\
                                <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>\
                                <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"/>\
                            </g>\
                        </svg><!--end::Svg Icon--></span>\</a>\
                          \
                          ';
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
    
      var getTareasPorTomar = function getTareasPorTomar() {
       /* KTApp.blockPage({
          overlayColor: "#000",
          opacity: "0.3"
        });*/

        

        $.ajax({
          url: '/portomar',
          type: 'GET',
          success: function success(data) {
           // KTApp.unblockPage();
            $('#tabla_portomar').DataTable({
              processing: true,
              data: data.data,
              destroy: true,
              columns: [{
                data: 'app_number',
                className: 'text-center'
              }, {
                data: 'app_pro_title',
                className: 'truncate'
              }, {
                data: 'app_create_date',
                className: 'text-center'
              }, {
                data: "solicitante",
                className: 'truncate'
              },  {
                data: "last_update",
                className: 'text-center'
              },{
                data:{
                  "del_task_due_date": "del_task_due_date",
                  "expire": "expire"
                } ,
                className: 'text-center',
                render: function render(row) {

                 if(row.expire == false){
                      return  '<span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">' +row.del_task_due_date + '</span>';
                    }
  
                    return '<span class="badge badge-light-danger fw-bolder fs-8 px-2 py-1 ms-2">' + row.del_task_due_date + '</span>';
                }
              }, {
                data: "task",
                className: 'text-center'
              }, {
                data: {
                  'app_number': 'app_number',
                  'app_tas_title': 'app_tas_title',
                  'app_pro_title': 'app_pro_title',
                  'urlhistorial': 'urlhistorial',
                  'urliframe': 'urliframe',
                  'case_id': 'case_id'
                },
                render: function render(row) {
                  
                  return '\
                              <span style="overflow: visible; position: relative; width: 110px;">\
                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#pm_form" data-portomar="1" data-appuid="' + row.app_uid + '" data-number="' + row.app_number + '"  data-title="' + row.app_tas_title + '"  data-subtitle="' + row.app_pro_title + '" data-url="' + row.urlhistorial + '" data-iframe-url="' + row.urliframe + '"    class="btn-bootstrap-modal' + row.case_id + ' m-portlet__nav-link2 btn m-btn m-btn--hover-metal m-btn--icon m-btn--icon-only m-btn--pill" title="Ver detalles">\
                                <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Design/Edit.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                    <rect x="0" y="0" width="24" height="24"/>\
                                    <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>\
                                    <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>\
                                </g>\
                            </svg><!--end::Svg Icon--></span>\
                                </a>\
                              \
                            ';
                }
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

      var tomarSolicitud = function tomarSolicitud(){
        $("#tomar_solicitud").click(function() {
    
          Swal.fire({
            position: "center",
            icon: "warning",
            title: "¡Confirmación!",
            html: "¿Está seguro de tomar está solicitud?",
            showConfirmButton: true,
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Confirmo",
            
          }).then(function(result) {
            if (result.value) {
              $.ajax({
                url: "/tomar-solicitud",
                type: "POST",
                dataType: "json",
                headers: {
                  "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                data: {
                  appuid: $("#appuid").val()
                },
                success: function(data) {
                  //blockUI.release();
            
                  if (data.codigo == 400) {
                    
                  } else {
                    if(data.success == true){
                      Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Esta solicitud le ha sido asignada. Ahora sólo usted puede procesarla.",
                        html: "¿Desea procesar la solicitud en este momento o procesarla después y seguir revisando solicitudes recibidas?",
                        showConfirmButton: true,
                        showCancelButton: true,
                        cancelButtonText: "Procesar después",
                        confirmButtonText: "Procesar ahora"
                      }).then(function(result2) {
                        if (result2.value) {
                          $("#iframe-prueba").attr({
                            src: $('#urliframe').val(),
                            height: 600
                          });
                          $('#iframe-prueba').css('display', '');
                          $('#appuid').val('');
                          $('#urliframe').val('');
                          $('#tomar_solicitud').css('display', 'none');
                        }else{
                          cerrarModal();
                        }
                      });
                    }else{
                      Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Ha ocurrido un error al tomar la solicitud!",
                        html:data.msg,
                        showConfirmButton: true
                      });
                    }
                   
            
                   
                  }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                 
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
            }
        });;
        });
      };
    
      var getTareasSupervisor = function getTareasSupervisor() {
        
        $.ajax({
          url: '/supervisor',
          type: 'GET',
          success: function success(data) {
           // KTApp.unblockPage();
            $('#tabla_supervisor').DataTable({
              processing: true,
              data: data.data,
              destroy: true,
              columnDefs: [{
                targets: 2,
                className: "truncate"
              }],
              createdRow: function createdRow(row) {
                var td = $(row).find(".truncate");
                td.attr("title", td.html());
              },
              columns:  [{
                data: 'app_number',
                className: 'text-center'
              }, {
                data: 'app_pro_title',
                className: 'truncate'
              }, {
                data: 'datos-solicitante',
                className: 'truncate'
              }, {
                data: "usrcr_usr_firstname",
                className: 'text-center'
              }, {
                data: "app_update_date",
                className: 'text-center'
              }, {
                data: "task",
                className: 'text-center'
              }, {
                data: {
                  'app_number': 'app_number',
                  'app_tas_title': 'app_tas_title',
                  'app_pro_title': 'app_pro_title',
                  'urlhistorial': 'urlhistorial',
                  'urliframe': 'urliframe',
                  'case_id': 'case_id'
                },
                render: function render(data) {
                  return '\
                          <span style="overflow: visible; position: relative; width: 110px;">\
                            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#pm_form" data-number="' + data.app_number + '"  data-title="' + data.app_tas_title + '"  data-subtitle="' + data.app_pro_title + '" data-url="' + data.urlhistorial + '"  class="btn-bootstrap-modal' + data.case_id + ' m-portlet__nav-link2 btn m-btn m-btn--hover-metal m-btn--icon m-btn--icon-only m-btn--pill" title="Ver detalles">\
                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Search.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                <rect x="0" y="0" width="24" height="24"/>\
                                <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>\
                                <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"/>\
                            </g>\
                        </svg><!--end::Svg Icon--></span>\
                            </a>\
                          \
                          ';
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
              searching: false,
              order: [[0, 'desc']],
            });
          },
          error: function error(jqXHR, textStatus, errorThrown) {
           // KTApp.unblockPage();
          }
        });
      };
    
      var filtarPorHacer = function filtarPorHacer() {
        $('#filtrar_porhacer').on('click', function () {
         
          $.ajax({
            url: '/porhacer',
            type: 'GET',
            data: {
             
              process: $('#porhacer_proceso').val(),
              number: $('#porhacer_numero').val(),
              nametask: $('#porhacer_estado').val(),
              datefrom: $('#porhacer_desde').val(),
              dateto: $('#porhacer_hasta').val(),
              rutsolicitante: $('#porhacer_rutsolicitante').val(),
              nombresolicitante: $('#porhacer_nombresolicitante').val()
            },
            success: function success(data) {
            //  KTApp.unblockPage();
              $('#tabla_recibidas').DataTable({
                processing: true,
                data: data.data,
                destroy: true,
                columnDefs: [{
                  targets: 2,
                  className: "truncate"
                }],
                createdRow: function createdRow(row) {
                  var td = $(row).find(".truncate");
                  td.attr("title", td.html());
                },
                columns: [{
                  data: 'app_number',
                  className: 'text-center'
                }, {
                  data: 'tipo_solicitud',
                  className: 'truncate'
                }, {
                  data: "fecha",
                  className: 'truncate'
                }, {
                  data: "datos-solicitante",
                  className: 'truncate'
                },  {
                  data: "last_update",
                  className: 'text-center'
                },{
                  data:{
                    "del_task_due_date": "del_task_due_date",
                    "expire": "expire"
                  } ,
                  className: 'text-center',
                  render: function render(row) {
  
                    if(row.expire == false){
                      return  '<span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">' +row.del_task_due_date + '</span>';
                    }
  
                    return '<span class="badge badge-light-danger fw-bolder fs-8 px-2 py-1 ms-2">' + row.del_task_due_date + '</span>';
                  }
                }, {
                  data: "task",
                  className: 'text-center'
                },
                /*{
                    data: "action",
                      render: function (data){
                        console.log(data);
                        return '\
                        <span style="overflow: visible; position: relative; width: 110px;">\
                          <a href="javascript:;" data-toggle="modal" data-target="#pm_form" data-number="'+ data.app_number + '"  data-title="'+ data.app_tas_title + '"  data-subtitle="' + data.app_pro_title + '" data-url="' + data.urlhistorial + '"  data-iframe-url="' + data.urliframe + '"  class="btn-bootstrap-modal' + data.case_id + ' m-portlet__nav-link2 btn m-btn m-btn--hover-metal m-btn--icon m-btn--icon-only m-btn--pill" title="Ver detalles"><i class="la la-edit"></i></a>\
                        \
                      ';
                    }
                }*/
                {
                  data: {
                    'app_number': 'app_number',
                    'app_tas_title': 'app_tas_title',
                    'app_pro_title': 'app_pro_title',
                    'urlhistorial': 'urlhistorial',
                    'urliframe': 'urliframe',
                    'case_id': 'case_id'
                  },
                  render: function render(data) {
                    return '\
                            <span style="overflow: visible; position: relative; width: 110px;">\
                              <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#pm_form" data-number="' + data.app_number + '"  data-title="' + data.app_tas_title + '"  data-subtitle="' + data.app_pro_title + '" data-url="' + data.urlhistorial + '"  data-iframe-url="' + data.urliframe + '"  class="btn-bootstrap-modal' + data.case_id + ' m-portlet__nav-link2 btn m-btn m-btn--hover-metal m-btn--icon m-btn--icon-only m-btn--pill" title="Ver detalles">\
                              <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Design/Edit.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                  <rect x="0" y="0" width="24" height="24"/>\
                                  <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>\
                                  <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>\
                              </g>\
                          </svg><!--end::Svg Icon--></span>\
                              </a>\
                            \
                            ';
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
              KTApp.unblockPage();
            }
          });
        });
      };
    
      var filtarEjecutadas = function filtarEjecutadas() {
        $('#filtrar_ejecutadas').on('click', function () {
         
          $.ajax({
            url: '/ejecutadas',
            type: 'GET',
            data: {
              process: $('#ejecutada_proceso').val(),
              number: $('#ejecutada_numero').val(),
              nametask: $('#ejecutada_estado').val(),
              datefrom: $('#ejecutada_desde').val(),
              dateto: $('#ejecutada_hasta').val(),
              rutsolicitante: $('#ejecutada_rutsolicitante').val(),
              nombresolicitante: $('#ejecutada_nombresolicitante').val()
            },
            success: function success(data) {
           
              $('#tabla_ejecutadas').DataTable({
                processing: true,
                data: data.data,
                destroy: true,
                order: [[0, 'desc']],
                columnDefs: [{
                  targets: 2,
                  className: "truncate"
                }],
                createdRow: function createdRow(row) {
                  var td = $(row).find(".truncate");
                  td.attr("title", td.html());
                },
                columns: [{
                  data: 'app_number',
                  className: 'text-center'
                }, {
                  data: 'app_pro_title',
                  className: 'truncate'
                }, {
                  data: 'datos-solicitante',
                  className: 'truncate'
                }, {
                  data: "usrcr_usr_firstname",
                  className: 'text-center'
                }, {
                  data: "app_update_date",
                  className: 'text-center'
                }, {
                  data: "task",
                  className: 'text-center'
                }, {
                  data: {
                    'app_number': 'app_number',
                    'app_tas_title': 'app_tas_title',
                    'task': 'task',
                    'urlhistorial': 'urlhistorial',
                    'urliframe': 'urliframe',
                    'case_id': 'case_id'
                  },
                  render: function render(data) {
                    return '\
                            <span style="overflow: visible; position: relative; width: 110px;">\
                              <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#pm_form" data-number="' + data.app_number + '"  data-title="' + data.task + '"  data-subtitle="' + data.app_pro_title + '" data-url="' + data.urlhistorial + '"  class="btn-bootstrap-modal' + data.case_id + ' m-portlet__nav-link2 btn m-btn m-btn--hover-metal m-btn--icon m-btn--icon-only m-btn--pill" title="Ver detalles">\
                              <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Search.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                  <rect x="0" y="0" width="24" height="24"/>\
                                  <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>\
                                  <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"/>\
                              </g>\
                          </svg><!--end::Svg Icon--></span>\
                              </a>\
                            \
                            ';
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
              
            }
          });
        });
      };
    
      var filtarSupervisor = function filtarSupervisor() {
        $('#filtrar_supervisor').on('click', function () {
          
          $.ajax({
            url: '/supervisor',
            type: 'GET',
            data: {
              process: $('#supervisor_proceso').val(),
              number: $('#supervisor_numero').val(),
              nametask: $('#supervisor_estado').val(),
              datefrom: $('#supervisor_desde').val(),
              dateto: $('#supervisor_hasta').val(),
              rutsolicitante: $('#supervisor_rutsolicitante').val(),
              nombresolicitante: $('#supervisor_nombresolicitante').val()
            },
            success: function success(data) {
             
              $('#tabla_supervisor').DataTable({
                processing: true,
                data: data.data,
                destroy: true,
                columns:  [{
                  data: 'app_number',
                  className: 'text-center'
                }, {
                  data: 'app_pro_title',
                  className: 'truncate'
                }, {
                  data: 'datos-solicitante',
                  className: 'truncate'
                }, {
                  data: "usrcr_usr_firstname",
                  className: 'text-center'
                }, {
                  data: "app_update_date",
                  className: 'text-center'
                }, {
                  data: "task",
                  className: 'text-center'
                }, {
                  data: {
                    'app_number': 'app_number',
                    'app_tas_title': 'app_tas_title',
                    'app_pro_title': 'app_pro_title',
                    'urlhistorial': 'urlhistorial',
                    'urliframe': 'urliframe',
                    'case_id': 'case_id'
                  },
                  render: function render(data) {
                    return '\
                            <span style="overflow: visible; position: relative; width: 110px;">\
                              <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#pm_form" data-number="' + data.app_number + '"  data-title="' + data.app_tas_title + '"  data-subtitle="' + data.app_pro_title + '" data-url="' + data.urlhistorial + '"  class="btn-bootstrap-modal' + data.case_id + ' m-portlet__nav-link2 btn m-btn m-btn--hover-metal m-btn--icon m-btn--icon-only m-btn--pill" title="Ver detalles"><span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Search.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                  <rect x="0" y="0" width="24" height="24"/>\
                                  <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>\
                                  <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"/>\
                              </g>\
                          </svg><!--end::Svg Icon--></span></a>\
                            \
                            ';
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
                searching: false,
                order: [[0, 'desc']],
              });
            },
            error: function error(jqXHR, textStatus, errorThrown) {
             
            },
            
          });
        });
      };
    
      var filtarPortomar = function filtarPortomar() {
        $('#filtrar_portomar').on('click', function () {
         console.log( $('#portomar_proceso').val());
          $.ajax({
            url: '/portomar',
            type: 'GET',
            data: {
              process: $('#portomar_proceso').val(),
              number: $('#portomar_numero').val(),
              nametask: $('#portomar_estado').val(),
              datefrom: $('#portomar_desde').val(),
              dateto: $('#portomar_hasta').val(),
              ultimamodificacion: $('#portomar_ultimamodificacion').val(),
              rutsolicitante: $('#portomar_rutsolicitante').val(),
              nombresolicitante: $('#portomar_nombresolicitante').val()
            },
            success: function success(data) {
              
              $('#tabla_portomar').DataTable({
                processing: true,
                destroy: true,
                data: data.data,
                columns: [{
                  data: 'app_number',
                  className: 'text-center'
                }, {
                  data: 'app_pro_title',
                  className: 'truncate'
                }, {
                  data: 'app_create_date',
                  className: 'text-center'
                }, {
                  data: "solicitante",
                  className: 'truncate'
                },  {
                  data: "last_update",
                  className: 'text-center'
                },{
                  data:{
                    "del_task_due_date": "del_task_due_date",
                    "expire": "expire"
                  } ,
                  className: 'text-center',
                  render: function render(row) {
  
                    if(row.expire == false){
                      return  '<span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">' +row.del_task_due_date + '</span>';
                    }
  
                    return '<span class="badge badge-light-danger fw-bolder fs-8 px-2 py-1 ms-2">' + row.del_task_due_date + '</span>';
                  }
                }, {
                  data: "task",
                  className: 'text-center'
                }, {
                  data: {
                    'app_number': 'app_number',
                    'app_tas_title': 'app_tas_title',
                    'app_pro_title': 'app_pro_title',
                    'urlhistorial': 'urlhistorial',
                    'urliframe': 'urliframe',
                    'case_id': 'case_id'
                  },
                  render: function render(row) {
                    
                    return '\
                                <span style="overflow: visible; position: relative; width: 110px;">\
                                  <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#pm_form" data-portomar="1" data-appuid="' + row.app_uid + '" data-number="' + row.app_number + '"  data-title="' + row.app_tas_title + '"  data-subtitle="' + row.app_pro_title + '" data-url="' + row.urlhistorial + '" data-iframe-url="' + row.urliframe + '"    class="btn-bootstrap-modal' + row.case_id + ' m-portlet__nav-link2 btn m-btn m-btn--hover-metal m-btn--icon m-btn--icon-only m-btn--pill" title="Ver detalles">\
                                  <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Design/Edit.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                      <rect x="0" y="0" width="24" height="24"/>\
                                      <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>\
                                      <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>\
                                  </g>\
                              </svg><!--end::Svg Icon--></span>\
                              </a>\
                                \
                              ';
                  }
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
              //KTApp.unblockPage();
            }
          });
        });
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
         
          $('#bandejaModalContent').html('');
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
          $('#bandejaModalContent').html('');
          $('#tomar_solicitud').css('display', 'none');

          if( $('#cerrarModal').val() == 1){
            $('#refresh-table').click();
            $('#cerrarModal').val(0);
          }
            
        });
      };
    
      var cerrarModal = function cerrarModal() {
        $('#cerrarModal').val(1);
        $('#pm_form').modal('hide');
        
      };
      
      var limpiar = function cerrarModal() {
        $('#limpiar_filtros_portomar').on('click', function () {

        

          $('#portomar_nombresolicitante').val('');
          $('#portomar_rutsolicitante').val('');
          $('#portomar_ultimamodificacion').val('');
          $('#portomar_hasta').val('');
          $('#portomar_desde').val('');
          $('#portomar_estado').val('');
          $('#portomar_proceso').val('');
          $('#portomar_numero').val('');

         
        });

        $('#limpiar_filtros_porhacer').on('click', function () {

          $('#porhacer_numero').val('');
          $('#porhacer_proceso').val('');
          $('#porhacer_estado').val('');
          $('#porhacer_desde').val('');
          $('#porhacer_hasta').val('');
          $('#porhacer_rutsolicitante').val('');
          $('#porhacer_nombresolicitante').val('');
        });

        $('#limpiar_filtros_ejecutadas').on('click', function () {

          $('#ejecutada_numero').val('');
          $('#ejecutada_proceso').val('');
          $('#ejecutada_estado').val('');
          $('#ejecutada_desde').val('');
          $('#ejecutada_hasta').val('');
          $('#ejecutada_rutsolicitante').val('');
          $('#ejecutada_nombresolicitante').val('');
        });

        $('#limpiar_filtros_supervisor').on('click', function () {

          $('#supervisor_numero').val('');
          $('#supervisor_proceso').val('');
          $('#supervisor_estado').val('');
          $('#supervisor_desde').val('');
          $('#supervisor_hasta').val('');
          $('#supervisor_rutsolicitante').val('');
          $('#supervisor_nombresolicitante').val('');
        });
        
      };

      return {
        init: function init() {
          getTareasPorHacer();
          refreshTable();
          getTareasEjecutadas();
          getTareasPorTomar();
          tomarSolicitud();
          getTareasSupervisor();
          filtarPorHacer();
          filtarEjecutadas();
          filtarPortomar();
          filtarSupervisor();
          limpiar();
          tabs();
          modal();
          
        },
        closeModal: function closeModal() {
          cerrarModal();
        },
        
      };
    }();
    
    $(document).ready(function () {
      $("#content").removeClass("container");
      $("#content").addClass("container-fluid");

    

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
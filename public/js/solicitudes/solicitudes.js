/******/ (() => { // webpackBootstrap
    var __webpack_exports__ = {};
    /*!********************************************!*\
      !*** ./resources/js/solicitudes/solicitudes.js ***!
      \********************************************/
    var page = function () {
      var getsolicitudes = function getsolicitudes(target, url) {
        /*KTApp.blockPage({
          overlayColor: "#000",
          opacity: "0.3"
        });*/
        console.log('cargando: /tareas/solicitudes?process=' + target);
        $.ajax({
          url: '/tareas/solicitudes?process=' + target,
          type: 'GET',
          data: {
            process: target
          },
          success: function success(data) {
           // KTApp.unblockPage();
            console.log(data);
            
            $('#tabla_solicitudes').DataTable({
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
                data: 'tipodocumento_fechadocumento',
                className: 'text-center'
              }, {
                data: 'materia',
                className: 'truncate'
              }, {
                data: 'destinatarios',
                className: 'text-center'
              }, {
                data: 'vinculada_a',
                className: 'text-center'
              }, {
                data: "usrcr_usr_firstname",
                className: 'text-center'
              }, {
                data: "app_update_date",
                className: 'text-center'
              }, {
                data: "app_tas_title",
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
                            <a href="javascript:;" data-toggle="modal" data-target="#pm_formsolicitudes" data-number="' + data.app_number + '"  data-title="' + data.app_tas_title + '"  data-subtitle="' + data.app_pro_title + '" data-url="' + data.urlhistorial + '"  data-iframe-url="' + data.urliframe + '"  class="btn-bootstrap-modal' + data.case_id + ' m-portlet__nav-link2 btn m-btn m-btn--hover-metal m-btn--icon m-btn--icon-only m-btn--pill" title="Ver detalles"><i class="la la-edit"></i></a>\
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
            //KTApp.unblockPage();
            console.log(errorThrown);
          }
        });
      };
    
      var refreshTable = function refreshTable() {
        $('#refresh-table').on('click', function () {
          console.log('Recargando tabla...');
          getsolicitudes();
        });
      };
    
      var modal = function modal() {
        $('#pm_formsolicitudes').on('shown.bs.modal', function (e) {
          var title = $(e.relatedTarget).data('title');
          var number = $(e.relatedTarget).data('number');
          var subTitle = $(e.relatedTarget).data('subtitle');
          var url = $(e.relatedTarget).data('url');
          var url_iframe = $(e.relatedTarget).data('iframe-url');
          var section = $(e.relatedTarget).data('section');
          $("#titleModal").html('Tarea Nº ' + number + ' - ' + title);
          var url = $(e.relatedTarget).data('url');
          console.log("url: " + url);
          $.get(url, function (response) {
            console.log(response);
            $("#bandejaModalContent").html(response);
            /**if (url_iframe != undefined) {
              $("#iframe-prueba").attr({
                src: url_iframe,
                height: $(this).attr('modal-iframe-height')
              });
            }**/
          }, 'html');
        });
      };
    
      var cerrarModal = function cerrarModal() {
        console.log("Cerrando modal");
        /**$('#pm_formsolicitudes').on('shown.bs.modal', function (e) {
          $("#pm_formsolicitudes").modal('hide');
        })**/
    
        $('#pm_formsolicitudes').modal('hide');
        $('#refresh-table').click();
      };
    
      return {
        init: function init() {
         
        
          modal();
          refreshTable();
        },
        cargarSolicitudes: function cargarSolicitudes() {
          getsolicitudes($('#idtabselect').val(), $('#urltabselect').val());
        },
        closeModal: function closeModal() {
          cerrarModal();
        }
      };
    }();
    
    $(document).ready(function () {
      $("#content").removeClass("container");
      $("#content").addClass("container-fluid");
      page.init();
      console.log("cargando...");
      page.cargarSolicitudes();
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
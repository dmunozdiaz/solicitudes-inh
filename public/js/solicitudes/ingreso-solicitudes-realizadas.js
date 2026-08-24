/******/ (() => { // webpackBootstrap
    var __webpack_exports__ = {};
    /*!*****************************************!*\
      !*** ./resources/js/tareas/bandejas.js ***!
      \*****************************************/
    console.log("Mis tareas js");
    
    var page = function () {
      

      var modal = function modal() {
        console.log("modal");
        $('#pm_form').on('shown.bs.modal', function (e) {
          console.log(e);
          var title = $(e.relatedTarget).data('title');
          var number = $(e.relatedTarget).data('number');
          var subTitle = $(e.relatedTarget).data('subtitle');
          var url = $(e.relatedTarget).data('url');
          var url_iframe = $(e.relatedTarget).data('iframe-url');
          var section = $(e.relatedTarget).data('section');
          $("#titleModal").html(title );
         
          
          var url = '/get-solicitude-realizada?idsolicitud='+$(e.relatedTarget).data('idsolicitud');
          $.get(url, function (response) {
            
            $("#bandejaModalContent").html(response);
    
           
          }, 'html');
        });
      };
    
      var cerrarModal = function cerrarModal() {
        $('#pm_form').modal('hide');
        $('#refresh-table').click();
      };
    
      return {
        init: function init() {
          
          modal();
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
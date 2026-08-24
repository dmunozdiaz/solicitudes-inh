var CrearCuentaFndr = function () {

    var handleCrearCuentaFndr = function () {
  
        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Redirigiando a FNDR...'
        });

        document.getElementById('crear-cuenta-fndr').submit();
  
    };
  
    
    return {
      //main function to initiate the module
      init: function () {
  
        handleCrearCuentaFndr();
      
  
        $.ajaxSetup({ cache: false });
  
      },
  
  
      clear: function () {
  
      },
  
    };
  
  }();
  
  jQuery(document).ready(function () {
    CrearCuentaFndr.init();
  });
  
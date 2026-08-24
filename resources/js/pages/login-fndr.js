var LoginFndr = function () {

    var handleLoginFndr = function () {
  
        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Redirigiando a FNDR...'
        });

        document.getElementById('login-fndr').submit();
  
    };
  
    
    return {
      //main function to initiate the module
      init: function () {
  
        handleLoginFndr();
      
  
        $.ajaxSetup({ cache: false });
  
      },
  
  
      clear: function () {
  
      },
  
    };
  
  }();
  
  jQuery(document).ready(function () {
    LoginFndr.init();
  });
  
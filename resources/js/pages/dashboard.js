var Dashboard = function () {

  var handleDashboard = function () {

   

  };

  
  return {
    //main function to initiate the module
    init: function () {

      handleDashboard();
    

      $.ajaxSetup({ cache: false });

    },


    clear: function () {

    },

  };

}();

jQuery(document).ready(function () {
  Dashboard.init();
});

/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************!*\
  !*** ./resources/js/login/login.js ***!
  \*************************************/
var Login = function () {


  var submitForm = function submitForm() {
    $('#kt_login_signin_submit').click(function () {
      var $captcha = $('#recaptcha'),
          response = grecaptcha.getResponse();

      if (response.length === 0) {
        document.getElementById("kt_login_signin_submit").disabled = true;
        $('#error-catpcha').show();
      } else {
        $('#error-catpcha').hide();
        $('#kt_login_signin_form').submit();
      }
    });
  };

  return {
    //main function to initiate the module
    init: function init() {
      
      submitForm();
      $('#error-catpcha').hide();
    }
  };
}();

jQuery(document).ready(function () {
  Login.init();
});
/******/ })()
;
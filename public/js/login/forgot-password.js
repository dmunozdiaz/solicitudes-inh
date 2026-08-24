/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************************!*\
  !*** ./resources/js/login/forgot-password.js ***!
  \***********************************************/
var ForgotPassword = function () {
  var submitForm = function submitForm() {
    $('#btn_enviar_email').click(function () {
      var $captcha = $('#recaptcha'),
          response = grecaptcha.getResponse();

      if (response.length === 0) {
        document.getElementById("btn_enviar_email").disabled = true;
        $('#error-catpcha').show();
      } else {
        $('#error-catpcha').hide();
        $('#frm-forgot-password').submit();
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
  ForgotPassword.init();
});
/******/ })()
;
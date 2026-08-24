/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************************!*\
  !*** ./resources/js/login/reset-password.js ***!
  \**********************************************/
var ResetPassword = function () {
  var formResetPassword = function formResetPassword() {
    var minlength = $("#maxlen").val();
    var minNumber = $("#minnum").val();
    var passwd = $('input[name ="password"]');
    passwd.passwordValidation({
      "minLength": minlength,
      //Minimum Length of password 
      "minNumber": minNumber,
      //Minimum number of digits characters in password
      "parent": $("#pass_validator")
    });
    $('.mostrar-pass').click(function () {
      var input = $(this).closest('.input-group').find('input');
      var icon = $(this).find('.svg-icon');

      if (input.attr('type') == 'password') {
        input.attr('type', 'text');
        icon.removeClass('svg-icon-dark-50');
        icon.addClass('svg-icon-dark');
      } else {
        input.attr('type', 'password');
        icon.addClass('svg-icon-dark-50');
        icon.removeClass('svg-icon-dark');
      }
    });
  };

  var submitForm = function submitForm() {
    $('#btn_submit').click(function () {
      var $captcha = $('#recaptcha'),
          response = grecaptcha.getResponse();

      if (response.length === 0) {
        document.getElementById("btn_submit").disabled = true;
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
      formResetPassword();
      submitForm();
    }
  };
}();

jQuery(document).ready(function () {
  ResetPassword.init();
});
/******/ })()
;
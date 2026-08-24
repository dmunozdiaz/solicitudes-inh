/**
 * Plugin para passwords Lazos
 * @param {type} $
 * @returns {undefined}
 */
(function ($) {
    $.fn.extend({
        passwordValidation: function (_options) {
            var _defaults = {
                ok: _options.ok || "/img/ok.png", //Ruta de la imagen OK
                bad: _options.error || "/img/error.png", //Ruta de la imagen ERROR
                minLength: _options.minLength || 8, //Minimum Length of password 
                minNumber: _options.minNumber || 2, //Minimum number of digits characters in password
                parent: _options.parent || "",
                id: Math.floor(Math.random() * 1000),
                submit: _options.submit
            };
            var _element = this;

            // Encuentra el boton submit del formulario
            var _button = (function () {
                if (_defaults.submit) {
                    return _defaults.submit;
                }
                var form = $(_element[0].form);

                var submit = form.find(':submit');
                return submit;
            })();

            function generateHtml() {
                var id = _defaults.id;
                var salida = '\
                    <br />\
                    <p>La contraseña debe contener:</p>\
                    <div class="container">\
                        <p><img style="width: 16px;height: 16px;" src="/img/error.png" class="c_long_' + id + '"> Longitud mínima de ' + _defaults.minLength + ' caracteres alfanuméricos.</p>\
                        <p><img style="width: 16px;height: 16px;"  src="/img/error.png" class="c_may_' + id + '"> Debe contener letras mayúsculas.</p>\
                        <p><img style="width: 16px;height: 16px;"  src="/img/error.png" class="c_min_' + id + '"> Debe contener letras minúsculas.</p>\
                        <p><img style="width: 16px;height: 16px;"  src="/img/error.png" class="c_num_' + id + '"> Debe contener al menos  ' + _defaults.minNumber + '  números.</p>\
                    </div>\
                    ';

                if (_defaults.parent !== '') {
                    (_defaults.parent).html(salida);
                } else {
                    var final = '<div id="pass_validator" class="container">' + salida + '</div>';
                    $(_element).after(final);
                }
            }

            function validar() {
                var ok = _defaults.ok;
                var bad = _defaults.bad;
                var minLength = _defaults.minLength;
                var minNumber = _defaults.minNumber;
                var error = 0;
                var el = _element;
                var btn = _button;
                var id = _defaults.id;

                // Longitud
                var reg = /^[a-zA-Z0-9ñÑ]+$/;
                if ((el.val().length >= minLength) && (reg.test(el.val()))) {
                    $(".c_long_" + id).attr('src', ok);
                } else {
                    $(".c_long_" + id).attr('src', bad);
                    error++;
                }


                // Mayusculas
                var reg = /([A-ZÑ])+/;
                if (reg.test(el.val())) {
                    $(".c_may_" + id).attr('src', ok);
                } else {
                    $(".c_may_" + id).attr('src', bad);
                    error++;
                }

                // Minusculas
                var reg = /([a-zñ])+/;
                if (reg.test(el.val())) {
                    $(".c_min_" + id).attr('src', ok);
                } else {
                    $(".c_min_" + id).attr('src', bad);
                    error++;
                }

                // Numeros
                var reg = new RegExp('((\\D*\\d){' + minNumber + ',})');
                if (el.val().match(reg)) {
                    $(".c_num_" + id).attr('src', ok);
                } else {
                    $(".c_num_" + id).attr('src', bad);
                    error++;
                }

                if (error) {
                    btn.prop("disabled", true);
                } else {
                    btn.prop("disabled", false);
                }
            }

            generateHtml();

            _element.on('keyup', function () {
                validar();
            });
        }
    });
})(jQuery);
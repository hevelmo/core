$(document).ready(function() {
	var $concessionaire, $model, $name, $lastname, $email, $phone, $message, $btnSend, form_errors, dataApi, dataRenowned, service_url;

	$concessionaire = $('#leads_concessionaire');
	$model = $('#leads_model');
	$name = $('#leads_name');
	$lastname = $('#leads_lastname');
	$email = $('#leads_email');
	$phone = $('#leads_phone');
	$message = $('#leads_message');

	$btnSend = $('.send_contact_form');
	$btnSend.removeAttr('disabled');

	$.submit_leads_form = function() {
		form_errors = 0;
		if ( !$.validate_input( $message )) {
			form_errors++;
			$message.focus();
		}
		if ( !$.validate_input( $phone )) {
			form_errors++;
			$phone.focus();
		}
		if ( !$.validate_input( $email )) {
			form_errors++;
			$email.focus();
		}
		if ( !$.validate_input( $lastname )) {
			form_errors++;
			$lastname.focus();
		}
		if ( !$.validate_input( $name )) {
			form_errors++;
			$name.focus();
		}
		/*if ( !$.validate_input( $model )) {
			form_errors++;
            //$model.change();
			$model.focusout();
		}
		if ( !$.validate_input( $concessionaire )) {
			form_errors++;
            //$concessionaire.change();
			$concessionaire.focusout();
		}*/
		if ( form_errors == 0 ) {
			$btnSend.css('cursor', 'auto').prop('disabled', true);
			$('#loader_send_icon').css('display', 'block');

            dataApi = $(domEl._form_leads).serializeFormJSON();
            console.log(dataApi);

            //if () {}
            //concesionaria
            //modelo
            dataRenowned = COR.renameArrayObjKeys([dataApi], {
                'name': 'nombre',
                'lastname': 'apellidos' ,
                'email': 'correo',
                'phone': 'telefono',
                'comment': 'mensaje',
                'news': 'newsletter'
            });
            dataRenowned['web_max'] = 'localhost/lp_suzuki/';
            dataRenowned['business_max'] = '0';
            dataRenowned['origen_type'] = '2';
            dataRenowned['campaign_max'] = 'Capaña de prueba';
            console.log(dataRenowned);

            service_url = 'http://max-app.net/api/v1/remote/action';
            $.ajax({
                cache: false,
                type: "POST",
                contentType: "application/json",
                url: service_url,
                dataType: "json",
                data: JSON.stringify(dataRenowned),
                success: function(data) {
                    console.log('enviado');
                },
                error: function(data) {
                    console.log('no enviado');
                }
            })
            .done(function() {
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
		}
	}
});
/* ------------------------------------------------------ *\
    [Methods] inputVal
\* ------------------------------------------------------ */
    var inputValMetdods = {
        isIntegerKP: function (event) {
            var key, numeros, teclado, especiales, teclado_especial, i;

            key = event.keyCode || event.which;
            teclado = String.fromCharCode(key);
            numeros = '0123456789';
            especiales = [8,9,37,38,39,40,46]; // array
            teclado_especial = false;

            for ( i in especiales ) {
                if ( key == especiales[i] ) {
                    teclado_especial = true;
                }
            }
            if ( numeros.indexOf(teclado) == -1 && !teclado_especial ) {
                return false;
            }
        },
        //http://www.lawebdelprogramador.com/foros/JavaScript/1074741-introducir_solo_numero_dos_decimales.html
        isDecimalKP: function(event) {
            var key, value;
            value = $(this).val();
            key = event.keyCode ? event.keyCode : event.which;

            // backspace
            if(key == 8) {
                return true;
            }
            // 0-9
            if(key > 47 && key < 58) {
                if(value == '') {
                    return true;
                }
                regexp = /.[0-9]{15}$/;
                return !(regexp.test(value));
            }
            // .
            if(key == 46) {
                if(value == '') {
                    return false;
                }
                regexp = /^[0-9]+$/;
                return regexp.test(value);
            }
            // other key
            return false;
        },
        roundDecimalBlur: function(event) {
            var value;
            value = $(this).val();
            value = CAMAD.roundNDecimalFormat(value, 2);
            $(this).val(value);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] validations_regexp
\* ------------------------------------------------------ */
    var validations_regexp = {
        address : new RegExp( /^[a-zá-úüñ,#0-9. -]{2,}$/i ),
        date    : new RegExp( /^(\d{4})-(\d{1,2})-(\d{1,2})$/ ),
        email   : new RegExp( /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/ ),
        name    : new RegExp( /^[a-zá-úüñ. ]{2,}$/i ),
        phone   : new RegExp( /^[0-9\s\-]{7,13}$/ )
    }
/* ------------------------------------------------------ *\
    [Methods] validation_messages
\* ------------------------------------------------------ */
    var validation_messages = {
        date            : 'Debe ser aaaa-mm-dd',
        date_tomorrow   : 'Sólo a partir de mañana',
        email           : 'Verifica tu correo',
        general         : 'Campo no válido',
        not_config      : 'Tipo desconocido',
        not_null        : 'No puede ser nulo',
        phone           : 'Verifica que tu número sea de 10 dígitos',
        required        : 'Campo requerido',
        empty           : 'Campo vacío'
    }
/* ------------------------------------------------------ *\
    [function] validate
\* ------------------------------------------------------ */
    /** 
     *
     *  Compares a value whith a rule and return a object.
     *
     *  @param  {String}    value           Value to compare.
     *  @param  {Array}     rules           Rules to validate.
     *  @param  {String}    required        Makes.
     *  @param  {String}    custom_message  Replace output message just when is not valid
     *  
     *  @retun  {Object}    Returns an object whit: "valid": boolean and "message": string
     *
    **/
        function validate(value, rules, required, custom_message) {
            var r, null_value, ii, rule;
            r = { valid: false, message: '' };
            null_value = value == undefined || value === '';
            required = required === true ? true : false;

            if ( required ) {
                if ( null_value ) {
                    r.message = validation_messages.required;
                }
            } else {
                if ( null_value ) {
                    r.valid = true;
                }
            }
            if ( !r.valid && r.message === '' ) {
                ii = rules.length;
                while ( ii-- ) {
                    rule = rules[ii];
                    switch ( rule ) {
                        case 'email':
                            if ( !validations_regexp.email.test( value ) ) {
                                r.message = validation_messages.email;
                            }
                            break;
                        case 'name':
                            if ( !validations_regexp.name.test( value ) ) {
                                r.message = validation_messages.general;
                            }
                            break;
                        case 'address':
                            if(!validations_regexp.address.exec( value)) {
                                r.message = validation_messages.general;
                            }
                            break;
                        case 'phone':
                            if(!validations_regexp.phone.exec( value)) {
                                r.message = validation_messages.phone;
                            }
                            break;
                        case 'upload':
                            if(!valid_extension_file( formulario, value)) {
                                r.message = validation_messages.upload;
                            }
                            break;
                        default:
                            r.message = validations_regexp.not_config;
                            break;
                    }
                }
                if( r.message === '' ) {
                    r.valid = true;
                }
            }
            if( custom_message && !r.valid ) {
                r.message = custom_message;
            }
            return r;
        }
/* ------------------------------------------------------ *\
    [function] validate_input
\* ------------------------------------------------------ */
    //Validates an input with data-validation-data attribute and displays or hide bubble meesage
    $.validate_input = function ($input) {
        if ($input.is('input') || $input.is('textarea') || $input.is('select')) {
            var val_data = $input.data('validation-data').split('|'),
                required = val_data.indexOf('required');
            if (required >= 0) {
                val_data.splice(required, 1);
            }
            var value = $input.val(),
                validation = validate(value, val_data, (required >= 0));
            $.error_bubble($input, !validation.valid, validation.message);
            return validation.valid;
        } else {
            var is_valid = !($input.val() === null);
            $.error_bubble($input, !is_valid, validation_messages.required);
            return is_valid;
        }
    };
/* ------------------------------------------------------ *\
    [function] error_bubble
\* ------------------------------------------------------ */
    //Display Input errors
    $.error_bubble = function ($label, show, message) {
        var $p = $label.parent().children('p.invalid-message');
        if (show) {
            if (message) {
                $p.html(message + '<span>&nbsp;</span>').stop().hide().fadeIn();
            } else {
                $p.stop().hide().fadeIn();
            }
        } else {
            $p.hide();
        }
    }
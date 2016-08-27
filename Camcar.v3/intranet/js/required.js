/* ------------------------------------------------------ *\
    [Variables] var
\* ------------------------------------------------------ */
    var element, val_campo, padre;
    var expr = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
/* ------------------------------------------------------ *\
    [Methods] inputValMetdods
\* ------------------------------------------------------ */
    var inputValMetdods = {
        isIntegerKP: function (event) {
            var key, numeros, teclado, especiales, teclado_especial, i;

            key = event.keyCode || event.which;
            teclado = String.fromCharCode(key);
            numeros = '0123456789';
            especiales = [8,9,37,38,39,40,46]; //array
            teclado_especial = false;

            for(i in especiales) {
                if(key == especiales[i]) {
                    teclado_especial = true;
                }
            }
            if(numeros.indexOf(teclado) == -1 && !teclado_especial) {
                return false;
            }
        },
        //http://www.lawebdelprogramador.com/foros/JavaScript/1074741-introducir_solo_numero_dos_decimales.html
        isDecimalKP: function(event) {
            var key, value;
            value = $(this).val();
            key = event.keyCode ? event.keyCode : event.which;

            //backspace
            if(key == 8) {
                return true;
            }
            //0-9
            if(key > 47 && key < 58) {
                if(value == '') {
                    return true;
                }
                regexp = /.[0-9]{15}$/;
                return !(regexp.test(value));
            }
            //.
            if(key == 46) {
                if(value == '') {
                    return false;
                }
                regexp = /^[0-9]+$/;
                return regexp.test(value);
            }
            //other key
            return false;
        },
        roundDecimalBlur: function(event) {
            var value;
            value = $(this).val();
            value = CAMIN.roundNDecimalFormat(value, 2);
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
        phone   : new RegExp( /^[0-9\s\-]{7,13}$/ ),
        upload  : new RegExp( /^[\w+\/]+\.\w{3}$/ )
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
        empty           : 'Campo vacío',
        upload          : 'Comprueba la extensión del archivo a subir'
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
        if ($input.is('input') || $input.is('textarea')) {
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
/* ------------------------------------------------------ *\
    [] ''
\* ------------------------------------------------------ */
    var validateMethods = {
        validate : function(value, rules, required, custom_message, formulario, archivo) {
            var r = { valid : false, message : '' },
            null_value = value == undefined || value === '' || value === $("#user_profile_pic").val(),
            ii, rule;
            required = required === true ? true: false;
            if(required) {
                if(null_value) {
                    r.message = validation_messages.required;
                }
            } else {
                if(null_value) {
                    r.valid = true;
                }
            }
            if(!r.valid && r.message === '') {
                ii = rules.length;
                while( ii--) {
                    rule = rules[ii];
                    switch( rule) {
                        case 'email':
                            if(!validations_regexp.email.test( value)) {
                                r.message = validation_messages.email;
                            }
                            break;
                        case 'name':
                            if(!validations_regexp.name.exec( value)) {
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
                if(r.message === '') {
                    r.valid = true;
                }
            }
            if(custom_message && !r.valid) {
                r.message = custom_message;
            }
            return r;
        },
        //Display Input errors
        error_bubble : function($label, show, message) {
            var $p = $label.parent().children('p.invalid-message');
            if(show) {
                if(message) {
                    $p.html( message + '<span>&nbsp;</span>' ).stop().hide().fadeIn();
                } else {
                    $p.stop().hide().fadeIn();
                }
            } else {
                $p.hide();
            }
        },
        validate_input : function(event) {
            var target, isInput, isTextarea, isInputFile;
            target = $(event.target);
            isInput = target.is('input');
            isTextarea = target.is('textarea');
            isInputFile = target.is('input[type="file"]');
            //console.log(target);
            if(isInput || isTextarea || isInputFile) {
                var valid_data, val_data, required, value, validation;
                valid_data = target.data('validation-data');
                val_data = valid_data.split('|');
                required = val_data.indexOf('required');
                if(required >= 0) {
                    val_data.splice(required, 1);
                }
                value = target.val();
                validation = validateMethods.validate( value, val_data, ( required >= 0 )  );
                validateMethods.error_bubble( target, !validation.valid, validation.message );
                return validation.valid;
            } else {
                var is_valid;
                is_valid = !( target.val() === null );
                validateMethods.error_bubble( target, !is_valid, validation_messages.required );
                return is_valid;
            }
        }
    }
/* ------------------------------------------------------ *\
    [functions] validateFieldsMethod
\* ------------------------------------------------------ */
    var validateFieldsMethod = {
        validInputEmail: function(email) {
            element = $(this);
            val_campo = element.val();
            padre = element.parent();
            if( !expr.test(val_campo) ) {
                //console.log('false');
                //console.log("error");
                validateFieldsMethod.cleanError(padre);  
                validateFieldsMethod.cleanOk(padre);
                //$(element).after("<span class='label label-danger animation-fadeIn error'><i class='fa fa-times'></i></span>");
                return false;           
            } else {
                //console.log('true');
                //console.log("ok");
                validateFieldsMethod.cleanOk(padre);
                validateFieldsMethod.cleanError(padre);  
                $(element).after("<span class='label label-success animation-fadeIn ok'><i class='fa fa-check'></i></span>");
                return true;
            }
        },
        validInput: function(campo) {
            element = $(this);
            val_campo = element.val();
            padre = element.parent();
            if( val_campo == '' ) {
                //console.log('false');
                //console.log("error");
                validateFieldsMethod.cleanError(padre);  
                validateFieldsMethod.cleanOk(padre);
                //$(element).after("<span class='label label-danger animation-fadeIn error'><i class='fa fa-times'></i></span>");
                $('button#goF').attr('disabled', true);
                return false;           
            } else {
                //console.log('true');
                //console.log("ok");
                validateFieldsMethod.cleanOk(padre);
                validateFieldsMethod.cleanError(padre);  
                $(element).after("<span class='label label-success animation-fadeIn ok'><i class='fa fa-check'></i></span>");
                $('button#goF').attr('disabled', false);
                return true;
            }
        },
        cleanError: function(padre) {
            var error;
            error = $(padre).children('.error');
            $(error).remove();
        },
        cleanOk: function(padre) {
            var ok;
            ok = $(padre).children('.ok');
            $(ok).remove();
        }
    }
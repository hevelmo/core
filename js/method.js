/* ------------------------------------------------------ *\
    [Variables] 'Zone'
\* ------------------------------------------------------ */
    var section;
    var IS_MOBILE = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    // Browser supports HTML5 multiple file?
    var multipleSupport = typeof $('<input/>')[0].multiple !== 'undefined',
        isIE = /msie/i.test( navigator.userAgent );
    // Back to Top
    var offset, offset_opacity, scroll_top_duration;
    offset = 300;
    offset_opacity = 1200;
    scroll_top_duration = 700;

    var scntDiv, i; 
    scntDiv = $('#p_scents');
    i = $('#p_scents p').size() + 1;
/* ------------------------------------------------------ *\
    [functions] Alert Custom
\* ------------------------------------------------------ */
    function resetAlert () {
        alertify.set({
            labels : {
                ok     : "OK",
                cancel : "Cancel"
            },
            delay : 5000,
            buttonReverse : false,
            buttonFocus   : "ok"
        });
    }
/* ------------------------------------------------------ *\
    [Metodos] backToTopMethod
\* ------------------------------------------------------ */
    var backToTopMethod = {
        backToTop: function(event) {
            event.preventDefault();
            $('body,html').animate({
                scrollTop: 0,
                }, scroll_top_duration
            );
        },
        windowScroll: function() {
            ( $(this).scrollTop() > offset ) ? $(domEl._back_to_top).addClass('cd-is-visible') : $(domEl._back_to_top).removeClass('cd-is-visible cd-fade-out');
            if ( $(this).scrollTop() > offset_opacity ) {
                $(domEl._back_to_top).addClass('cd-fade-out');
            }
        },
        init_window_scroll_top: function() {
            $(window).scroll(backToTopMethod.windowScroll);
        }
    }
/* ------------------------------------------------------ *\
    [Metodos] Favicon
\* ------------------------------------------------------ */
    var favicon = {
        load_favicon: function() {
            favicon.change("favicon.ico");
        },
        change: function(iconURL, optionalDocTitle) {
            if (arguments.length == 2) {
              document.title =  optionamDocTitle;
            }
            this.addLink(iconURL, "shortcur icon");
        },
        addLink: function(iconURL, relValue) {
            var link = document.createElement("link");
            link.type = "image/x-icon";
            link.rel = relValue;
            link.href = iconURL;
            this.removeLinkIfExists(relValue);
            this.docHead.appendChild(link);
        },
        removeLinkIfExists: function(relValue) {
            var links = this.docHead.getElementsByTagName("link");
            for (var i=0; i<links .length; i++) {
              var link = links[i];
              if (link.type=="image/x-icon" && link.rel==relValue) {
                this.docHead.removeChild(link);
                return; // Assuming only one match at most.
              }
            }
        },
        docHead:document.getElementsByTagName("head")[0]
    }
/* ------------------------------------------------------ *\
    [Methods] sticky_wrapper_methods
\* ------------------------------------------------------ */
    var sticky_wrapper_methods = {
        sticky_wrapper: function() {
            $('.navbar').waypoint('sticky', {
                wrapper: '<div class="sticky-wrapper" />',
                stuckClass: 'sticky'
            });
        }
    }
/* ------------------------------------------------------ *\
    [Methods] Animated
\* ------------------------------------------------------ */
    var animatedMethods = {
        animated : function () {
            $('.animated').appear(function() {
                var element, animation, animationDelay;

                element = $(this);
                animation = element.data('animation');
                animationDelay = element.data('delay');

              if(animationDelay) {
                setTimeout(function() {
                  element.addClass( animation + " visible" );
                  element.removeClass('hiding');
                  if(element.hasClass('counter')) {
                    element.find('.value').countTo();
                  }
                }, animationDelay);
              } else {
                element.addClass( animation + " visible" );
                element.removeClass('hiding');
                if(element.hasClass('counter')) {
                  element.find('.value').countTo();
                }
              }
            },{accY: -150});
        }
    }
/* ------------------------------------------------------ *\
    [Methods] Animated
\* ------------------------------------------------------ */
    var wow_animated_methods = {
        wow_animated: function() {
            /*==WOW JS==*/
            var ww = $(window).width();

            /*==WOW JS==*/
            if(ww > 480){
                wow = new WOW({
                    animateClass: 'animated',
                    offset: 0
                });
                wow.init();
            }
        }
    }
/* ------------------------------------------------------ *\
    [Metodos] mobile_menu_methods
\* ------------------------------------------------------ */
    var mobile_menu_methods = {
        mobile_menu_toggle: function(event) {
            $(this).toggleClass("opened");
            $(".toggle-menu").slideToggle();
            $(".site-header-wrapper").toggleClass("sticktr");
            $(".body").toggleClass("sticktr");
            var SHHH = $(".site-header").innerHeight();
            var NBHH = $(".navbar").innerHeight();
            var THHH = $(".top-header").innerHeight();
            $(".toggle-menu").css("top",NBHH);
            $(".header-v2 .toggle-menu").css("top",SHHH);
            $(".header-v3 .toggle-menu").css("top",SHHH + THHH);
            console.log('test');
            return false;
        },
        has_menu_toggle: function() {
            if($("#menu-toggle").hasClass("opened")){
                $(".toggle-menu").css("display","block");
            } else {
                $("#menu-toggle").css("display","none");
            }
        }
    }
/* ------------------------------------------------------ *\
    [functions] setWidthme
\* ------------------------------------------------------ */
    var setWidthMethod = {
        setWidth: function() {
            var arrayText, arrayText2;

            arrayText=Array();
            arrayText2=Array();

            $('.grid-content').each( function () {
                var firstDiv, secondDiv;

                firstDiv = $(this).find("#content-title");
                secondDiv = $(this).find("#container-paragraph");

                if( firstDiv.html().length > 115 ) {
                    arrayText.push( firstDiv.html() );

                    firstDiv.html( firstDiv.html().substr( 0,115 ) + "<i style='color: #000; font-size: 14px;'>...</i>" );

                    //$(this).append( "<h3 class='mas cortado' id='"+(arrayText.length-1)+"'>(más)</h3>" );
                }
                if( secondDiv.html().length > 220 ) {
                    arrayText2.push( secondDiv.html() );

                    secondDiv.html( secondDiv.html().substr( 0,220 ) + "<i style='color: #000; font-size: 14px;'>...</i>" );

                    //$(this).append("<h3 class='mas cortado' id='"+(arrayText2.length-1)+"'>(más)</h3>");
                }
                $(this).show();
            });
        }
    }
/* ------------------------------------------------------ *\
    [Methods] equalHeightsMethods
\* ------------------------------------------------------ */
    var equalHeightsMethods = {
        equalHeightsLoad : function() {
            var altomax = 0;
            $('.equal-height').each(function(){
                if( $(this).height() > altomax ){
                    altomax = $(this).height();
                }
            });
            $('.equal-height').height( altomax );
        }
    }
/* ------------------------------------------------------ *\
    [Methods] INPUTS RADIO, CHECKBOX
\* ------------------------------------------------------ */
    var changeInputsMethods = {
        clickChangeCheckbox : function(event) {
            if ($(".label-checkbox").length) {
                $('.label-checkbox input:checked').each(function(){
                    $(this).parent('label').addClass('checkbox-checked');
                });
            }
            if ($(this).is(':checked')) {
                $(this).parent('.label-checkbox').find(':checkbox').attr('checked', true);
                $(this).parent('.label-checkbox').addClass('checkbox-checked');
                $(this).val('on');
                $('#contact_subscription').val('Activado');
                $('#test_drive_model_subscription').val('Activado');
            } else {
                $(this).parent('label').find(':checkbox').attr('checked', false);
                $(this).parent('label').removeClass('checkbox-checked');
                $(this).val('off');
                $('#contact_subscription').val('Desactivado');
                $('#test_drive_model_subscription').val('Desactivado');
            }
        },
        clcikChangeRadio : function(event) {
            if ($(".label-radio").length) {
                $('.label-radio input:checked').each(function(){
                    //$(this).parent('label').addClass('radio-checked');
                });
            }
            if ($(this).hasClass('radio-checked')) {
                $(this).find(':radio').attr('checked', true);
                $(this).addClass("radio-checked");
            } else {
                $(".label-radio").removeClass("radio-checked");
                $(".label-radio").find(':radio').attr('checked', false);
                $(this).find(':radio').attr('checked', true);
                $(this).addClass("radio-checked");
            }
        }
    }
/* ------------------------------------------------------ *\
    [Methods] windowWidthMethod
\* ------------------------------------------------------ */
    var windowWidthMethod = {
        windowWidth: function() {
            var windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

            if (windowWidth > 900) { // Medium breakpoint
                var heroCarousels = document.querySelectorAll(".HeroCarousel");
                var carousel, yOffset, element, carouselHeight;
                var windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

                for (var i = 0; i < heroCarousels.length; i++) {
                    carousel = heroCarousels[i];
                    yOffset = 0;
                    element = carousel;

                    while (element) {
                        yOffset += (element.offsetTop - element.scrollTop + element.clientTop);
                        element = element.offsetParent;
                    }

                    carouselHeight = windowHeight - yOffset;

                    if (carouselHeight > 450) {
                        carousel.style.height = carouselHeight + "px";
                    }
                }
            }
        }
    }
/* ------------------------------------------------------ *\
    [Methods] goSectioMethod
\* ------------------------------------------------------ */
    var goSectionMethod = {
        goSection_home: function() {
        }
    }
/* ------------------------------------------------------ *\
    [Methods] addAttrForSectionMethod
\* ------------------------------------------------------ */
    var addAttrForSectionMethod = {
        addAttrForSection_home: function() {
        }
    }
/* ------------------------------------------------------ *\
    [Methods] removeAttrForSectionMethod
\* ------------------------------------------------------ */
    var removeAttrForSectionMethod = {
        removeAttrForSection_home: function() {
        }
    }
/* ------------------------------------------------------ *\
    [Methods] addStylesForSectionMethod
\* ------------------------------------------------------ */
    var addStylesForSectionMethod = {
        addStylesSection_home: function() {
        }
    }
/* ------------------------------------------------------ *\
    [Methods] cleanStylesForSectionMethod
\* ------------------------------------------------------ */
    var cleanStylesForSectionMethod = {
        cleanStylesForSection: function() {
            cleanStylesForSectionMethod.cleanStylesSection_home();
        },
        cleanStylesSection_home: function() {
        }
    }
/* ------------------------------------------------------ *\
    [Methods] viewSectionHomeMethod
\* ------------------------------------------------------ */
    var viewSectionHomeMethod = {
        addTemplatesSectionHome: function() {
        },
        recurrentSecionHome: function() {
        },
        viewSectionHome: function() {
        }
    }
/* ------------------------------------------------------ *\
    [Methods] removeRecurrentsMethod
\* ------------------------------------------------------ */
    var removeRecurrentsMethod = {
        removeRecurrents: function() {
            removeRecurrentsMethod.removeRecurrents_home();
        },
        removeRecurrents_home: function() {
        }
    }
/* ------------------------------------------------------ *\
    [Methods] inputVal
\* ------------------------------------------------------ */
    var inputValMetdods = {
        isIntegerKP: function (event) {
            return /\d/.test(String.fromCharCode(event.keyCode));
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
        upload          : 'Archivos validos: PDF, DOC, DOCX'
    }
/* ------------------------------------------------------ *\
    [Methods] validate
\* ------------------------------------------------------ */
    var validateMethods = {
        validate : function(value, rules, required, custom_message, formulario, archivo) {
            var r = { valid : false, message : '' },
            null_value = value == undefined || value === '' || value === $("#user_profile_pic").val() ,
            ii, rule;
            required = required === true ? true: false;
            if( required ){
                if( null_value ){
                    r.message = validation_messages.required;
                }
            }else{
                if( null_value ){
                    r.valid = true;
                }
            }
            if( !r.valid && r.message === '' ){
                ii = rules.length;
                while( ii-- ){
                    rule = rules[ii];
                    switch( rule ){
                        case 'email':
                            if( !validations_regexp.email.test( value ) ){
                                r.message = validation_messages.email;
                            }
                            break;
                        case 'name':
                            if( !validations_regexp.name.exec( value ) ){
                                r.message = validation_messages.general;
                            }
                            break;
                        case 'address':
                            if( !validations_regexp.address.exec( value ) ){
                                r.message = validation_messages.general;
                            }
                            break;
                        case 'phone':
                            if( !validations_regexp.phone.exec( value ) ){
                                r.message = validation_messages.phone;
                            }
                            break;
                        case 'area':
                            if(  !is_model_name( value ) ){
                                r.message = validation_messages.general;
                            }
                            break;
                        case 'upload':
                            if( !valid_extension_file( formulario, value ) ){
                                r.message = validation_messages.upload;
                                //console.log(r.message);
                            }
                            break;
                        default:
                            r.message = validations_regexp.not_config;
                            break;
                    }
                }
                if( r.message === '' ){
                    r.valid = true;
                }
            }
            if( custom_message && !r.valid ){
                r.message = custom_message;
            }
            return r;
        },
        //Display Input errors
        error_bubble : function( $label, show, message ){
            var $p = $label.parent().children('p.invalid-message');
            if( show ){
                if( message ){
                    $p.html( message + '<span>&nbsp;</span>' ).stop().hide().fadeIn();
                }else{
                    $p.stop().hide().fadeIn();
                }
            }else{
                $p.hide();
            }
        },
        validate_input : function(event) {
            var target = $(event.target);
            //console.log(target);
            if( target.is('input') || target.is('textarea') || target.is('input[type="file"]') ){
                var valid_data = target.data('validation-data');
                var val_data    = valid_data.split('|'),
                    required    = val_data.indexOf('required');
                if( required >= 0 ){
                    val_data.splice(required, 1);
                }
                var value = target.val(),
                    validation = validateMethods.validate( value, val_data, ( required >= 0 )  );
                validateMethods.error_bubble( target, !validation.valid, validation.message );
                return validation.valid;
            }else{
                var is_valid = !( target.val() === null );
                validateMethods.error_bubble( target, !is_valid, validation_messages.required );
                return is_valid;
            }
        }
    }

    var addText = {
        appendTagInput: function(event) {
            $('<p><label for="p_scnts"><input type="text" id="p_scnt" size="20" name="p_scnt_' + i +'" value="" placeholder="Input Value" /></label> <a href="#" id="remScnt">Remove</a></p>').appendTo(scntDiv);
            i++;
            return false;
        },
        removeTagInpput: function(event) {
            if( i > 2 ) {
                $(this).parents('p').remove();
                i--;
            }
            return false;
        }
    }

/* ------------------------------------------------------ *\
 [Methods] compiler_phpobjectjs_method
\* ------------------------------------------------------ */
    var compiler_phpobjectjs_method = {
        compiler_phpobjectjs_camcar_v2: function(event) {
            var btnSubmitSite, comiler_phpobjectjs_sitio, ihidden;
            compiler_phpobjectjs_sitio = '../../camcar-v2.0/sitio/phpobjectjs/';
            event.preventDefault();
            $.ajax({
                url: compiler_phpobjectjs_sitio,
                type: 'post',
                data: {ihidden: ihidden},
                beforeSend: compiler_phpobjectjs_method.funcBeforeSend
            })
            .done(compiler_phpobjectjs_method.funcDone)
            .always(compiler_phpobjectjs_method.funcAlways)
        },
        compiler_phpobjectjs_camcar_v1: function(event) {
            var btnSubmitSite, comiler_phpobjectjs_sitio, ihidden;
            compiler_phpobjectjs_sitio = '../../camcar/sitio/phpobjectjs/';
            event.preventDefault();
            $.ajax({
                url: compiler_phpobjectjs_sitio,
                type: 'post',
                data: {ihidden: ihidden},
                beforeSend: compiler_phpobjectjs_method.funcBeforeSend
            })
            .done(compiler_phpobjectjs_method.funcDone)
            .always(compiler_phpobjectjs_method.funcAlways)
        },
        funcBeforeSend: function() {
            $('#status').html('<img src="loading.gif" />');
            $('#data').html('Compilando: phpobjectjs');
        },
        funcDone: function() {
            setTimeout(function() {
                $('#data').html('<i class="icon ion-md-checkmark"></i> compilado: phpobjectjs');
            }, 3900);
        },
        funcAlways: function() {
            setTimeout(function() {
                $('#status').html('');
            }, 4700);
            setTimeout(function() {
                $('#data').html('');
            }, 7700);            
        }
    }
/* ------------------------------------------------------ *\
    [Variables] 'Zone'
\* ------------------------------------------------------ */
    var section;
    var IS_MOBILE, mediaquery;

    // Browser supports HTML5 multiple file?
    var multipleSupport, isIE;
    multipleSupport = typeof $('<input/>')[0].multiple !== 'undefined',
    isIE = /msie/i.test( navigator.userAgent )
    // Back to Top
    var offset, offset_opacity, scroll_top_duration;
    offset = 300;
    offset_opacity = 1200;
    scroll_top_duration = 700;

    //var scntDiv, i;
    //scntDiv = $('#p_scents');
    //i = $('#p_scents p').size() + 1;
    var queries, newQuery, query;
    queries = [
        '400', '480', '640', '768', '1024'
    ];

/* ------------------------------------------------------ *\
    [functions] handleOrientationChange
\* ------------------------------------------------------ */
    function handleOrientationChange(mediaquery) {
        if (mediaquery.matches) {
            // mediaquery es 768px
            //console.log('mediaquery es: ' + mq + 'px');
        } else {
            // mediaquery no es 768px
            //console.log('mediaquery no es: ' + mq + 'px');
        }
    }
/* ------------------------------------------------------ *\
    [functions] DETEC MOBILE
\* ------------------------------------------------------ */
    /* Detect Mobile Browser : http://detectmobilebrowsers.com/ */
    function detectmobile(a){
        IS_MOBILE = false;
        if(/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|meego.+mobile|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))){
            IS_MOBILE = true;
        }
        return IS_MOBILE;
    };
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
    [functions] __sizeCheck
\* ------------------------------------------------------ */
    function __sizeCheck(element) {
        var _cWidth;
        // current width
        _cWidth = element.width();
        // update text
        _cText = 'desktop screens > 1200px';
        console.log(_cText);
        // check block
        if(_cWidth < 1680) {
            _cText = 'desktop computer ' + _cWidth + 'px';
            console.log(_cText);
        }
        if(_cWidth < 1280) {
            _cText = 'desktop computer ' + _cWidth + 'px';
            console.log(_cText);
        }
        if(_cWidth < 1024) {
            _cText = 'ipad landscape ' + _cWidth + 'px';
            console.log(_cText);
        }
        if(_cWidth < 768) {
            _cText = 'ipad portrait ' + _cWidth + 'px';
            console.log(_cText);
        }
        if(_cWidth < 480) {
            _cText = 'iphone landscape ' + _cWidth + 'px';
            console.log(_cText);
        }
        if(_cWidth < 320) {
            _cText = 'iphone portrait ' + _cWidth + 'px';
            console.log(_cText);
        }
        if(_cWidth < 240) {
            _cText = 'so small phones ' + _cWidth + 'px';
            console.log(_cText);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] MATCHMEDIA
\* ------------------------------------------------------ */
    var matchMediaMethod = {
        mediaquery: function(mediaquery) {
            //handleOrientationChange(mediaquery);
        }
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
        loadTemplatesSectionHome: function() {
            COR.loadTemplate(tempsNames._content_form_leads, domEl.div_recurrent);
            set_form_leads_method.refreshForm();
        },
        recurrentSecionHome: function() {
            dataMainCompilerProjectsAttributes = [
                ['div', {'id':domEl._main_compiler_app, 'class':''}, '', 1]
            ];
            COR.appendMulti(domEl.div_recurrent, dataMainCompilerProjectsAttributes);
        },
        viewSectionHome: function() {
            //viewSectionHomeMethod.recurrentSecionHome();
            viewSectionHomeMethod.loadTemplatesSectionHome();
        }
    }
/* ------------------------------------------------------ *\
    [Methods] set_form_leads_method
\* ------------------------------------------------------ */
    var set_form_leads_method = {
        data_max_leads_api: function() {
            var dataApi, dataRenowned;
            dataApi = $(domEl._form_leads).serializeFormJSON();
            console.log('Guarda datos MAX.');
            console.log(dataApi);

            dataRenowned = COR.renameArrayObjKeys([dataApi], {
                'name': 'nombre',
                'lastname': 'apellidos' ,
                'email': 'correo',
                'phone': 'telefono',
                'comment': 'mensaje',
                'news': 'newsletter'
            });
            dataRenowned = dataRenowned[0];

            dataRenowned['web_max'] = 'localhost/lp_suzuki/';
            dataRenowned['business_max'] = '0';
            dataRenowned['origen_type'] = '2';
            dataRenowned['campaign_max'] = 'Capaña de prueba';
            console.log(dataRenowned);

            return COR.postalService('http://max-app.net/api/v1/remote/action', dataRenowned);
        },
        data_fiancing_by_model: function() {
            var data, $model, urlApi, postApi;
            data = $(domEl._form_leads).serializeFormJSON();
            console.log(data);

            $model = 'swift-sport';

            urlApi = urlsApi.getFinancingByModel + $model;
            postApi = COR.postalService(urlApi, data);
            console.log(postApi);
            return postApi;
        },
        fillingControl: function() {
            var validFieldName, dataApi, isFull, isNoEmpty;
            validFieldName = ['nombre', 'apellidos', 'correo', 'telefono', 'mensaje'];
            dataApi = $(domEl._form_leads).serializeFormJSON();
            console.log(dataApi);
        },
        refreshForm: function() {
            var $btnSend;
            $btnSend = $('.send_contact_form');

            COR.loadTemplate(tempsNames.start_site_form_leads, domEl._content_form_leads);
            $('.seleccionar').chosen();
            set_form_leads_method.set_input_hidden();

            $btnSend.removeAttr('disabled');
        },
        resetApi: function() {
            var $btnSend;
            $btnSend = $('.send_contact_form');

            COR.resetForm(domEl._form_leads);

            $('#loader_send_icon').css('display', 'none');

            $('#leads_concessionaire_chosen a.chosen-single span').text('Selecciona Concesionaria');
            $('#leads_model_chosen a.chosen-single span').text('Selecciona Modelo');
            
            $('#fieldset-radio-checkbox-yes label').removeClass('radio-checked');
            $('#fieldset-radio-checkbox-yes label input').removeAttr('checked');

            $('#fieldset-radio-checkbox-no label').addClass('radio-checked');
            $('#fieldset-radio-checkbox-no label input').attr('checked');

            $('#checkbox-news label').removeClass('checkbox-checked');
            $('#checkbox-news label input').removeAttr('checked');
            
            $btnSend.removeAttr('disabled');
        },
        keyInput: function() {
            set_form_leads_method.fillingControl();
        },
        set_input_hidden: function() {
            set_input_hidden = [
                ['input', {'id' : 'leads_image_model', 'class' : 'set_input_hidden', 'value' : 'swift-sport.png', 'name' : 'image_model', 'type' : 'hidden'}, '', 0],
                ['input', {'id' : 'leads_name_model', 'class' : 'set_input_hidden', 'value' : 'Swift Sport', 'name' : 'name_model', 'type' : 'hidden'}, '', 0]
            ];
                //['input', {'id' : 'leads_agencie', 'class' : 'set_input_hidden', 'value' : '', 'name' : 'agencie', 'type' : 'hidden'}, '', 0]
            COR.appendMulti('#funding_fields_hidden', set_input_hidden);
        },
        send_form_leads: function() {
            var $concessionaire, $model, $name, $lastname, $email, $phone, $message, $btnSend, form_errors;
            form_errors = 0;
            $concessionaire = $('#leads_concessionaire');
            $model = $('#leads_model');
            $name = $('#leads_name');
            $lastname = $('#leads_lastname');
            $email = $('#leads_email');
            $phone = $('#leads_phone');
            $message = $('#leads_message');
            $btnSend = $('.send_contact_form');

            $btnSend.removeAttr('disabled');

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

                apiPromise = set_form_leads_method.data_max_leads_api();
                apiPromise.success( function (data) {
                    console.log('guarda registro en max, promise success');
                    console.log(data);

                    sendFundingPromise = set_form_leads_method.data_fiancing_by_model();
                    sendFundingPromise.success( function (data) {
                        console.log('Entra promise success');
                        console.log(data);
                        set_form_leads_method.fillingControl();
                        set_form_leads_method.resetApi();
                    });
                    sendFundingPromise.error( function (data) {
                        console.log('Entra promise error');
                        console.log(data);
                        set_form_leads_method.resetApi();
                    });
                });
                apiPromise.error( function (data) {
                    console.log('no guarda registro en max, promise error');
                    console.log(data);
                    set_form_leads_method.resetApi();
                });
            }
        }
    }
/* ------------------------------------------------------ *\
    [Methods] changeInputsMethods
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
                $(this).val('1');
                $('#contact_subscription').val('Activado');
                $('#test_drive_model_subscription').val('Activado');
            } else {
                $(this).parent('label').find(':checkbox').attr('checked', false);
                $(this).parent('label').removeClass('checkbox-checked');
                $(this).val('0');
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

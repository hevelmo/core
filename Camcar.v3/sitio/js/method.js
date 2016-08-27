/* ------------------------------------------------------ *\
    [Variables] var
\* ------------------------------------------------------ */
    var section;
    var IS_MOBILE, isMobile, mediaquery, mediaquery320, mediaquery360, mediaquery375, mediaquery384, mediaquery400, mediaquery412, mediaquery414, mediaquery480, mediaquery600, mediaquery640,  mediaquery768,  mediaquery800, mediaquery1024,  mediaquery1200,  mediaquery1280,  mediaquery1366, mediaquery1440, mediaquery1600, mediaquery1601,
        $min_width_768;
    mediaquery320 = window.matchMedia("(max-width: 320px)"); mediaquery360 = window.matchMedia("(max-width: 360px)"); mediaquery375 = window.matchMedia("(max-width: 375px)"); mediaquery384 = window.matchMedia("(max-width: 384px)");
    mediaquery400 = window.matchMedia("(max-width: 400px)"); mediaquery412 = window.matchMedia("(max-width: 412px)"); mediaquery414 = window.matchMedia("(max-width: 414px)"); mediaquery480 = window.matchMedia("(max-width: 480px)");
    mediaquery600 = window.matchMedia("(max-width: 600px)"); mediaquery640 = window.matchMedia("(max-width: 640px)"); mediaquery768 = window.matchMedia("(max-width: 768px)"); mediaquery800 = window.matchMedia("(max-width: 800px)");
    mediaquery1024 = window.matchMedia("(max-width: 1024px)"); mediaquery1200 = window.matchMedia("(max-width: 1200px)"); mediaquery1280 = window.matchMedia("(max-width: 1280px)"); mediaquery1366 = window.matchMedia("(max-width: 1366px)");
    mediaquery1440 = window.matchMedia("(max-width: 1440px)"); mediaquery1600 = window.matchMedia("(max-width: 1600px)"); mediaquery1601 = window.matchMedia("(max-width: 1601px)");
    mediaquery = window.matchMedia("(max-width: 768px)");
    $min_width_768 = window.matchMedia("(min-width: 768px)");
    // Browser supports HTML5 multiple file?
    var multipleSupport, isIE;
    multipleSupport = typeof $('<input/>')[0].multiple !== 'undefined',
    isIE = /msie/i.test( navigator.userAgent )
    // Back to Top
    var offset, offset_opacity, scroll_top_duration;
    offset = 300;
    offset_opacity = 1200;
    scroll_top_duration = 700;
    isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };
/* ------------------------------------------------------ *\
    [functions] detectmobile
\* ------------------------------------------------------ */
    // http://jstricks.com/detect-mobile-devices-javascript-jquery/
    function detectmobile(){
        IS_MOBILE = false;
        if( isMobile.any() ){
            IS_MOBILE = true;
            //console.log(IS_MOBILE);
        } else {
            //console.log(IS_MOBILE);
        }
        return IS_MOBILE;
    };
/* ------------------------------------------------------ *\
    [functions] resetAlert
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
    [functions] loadSlider
\* ------------------------------------------------------ */
    function loadSlider() {
      $(domEl.div_recurrent +' .flexslider').flexslider({
        animation: "slide",
        controlNav: "thumbnails",
        start: function(slider) {
          $('body').removeClass('loading');
        }
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
        //console.log(_cText);
        // check block
        if(_cWidth < 1680) {
            _cText = 'desktop computer ' + _cWidth + 'px';
            $('.client-section').removeClass('closeToggle');
            //console.log(_cText);
        }
        if(_cWidth < 1280) {
            _cText = 'desktop computer ' + _cWidth + 'px';
            $('.client-section').removeClass('closeToggle');
            //console.log(_cText);
        }
        if(_cWidth < 1024) {
            _cText = 'ipad landscape ' + _cWidth + 'px';
            $('.client-section').removeClass('closeToggle');
            $('.client-section').removeClass('closeToggle');
            //console.log(_cText);
        }
        if(_cWidth < 768) {
            _cText = 'ipad portrait ' + _cWidth + 'px';
            $('.client-section').addClass('closeToggle');
            $('ul#filters > li a').removeClass('closeToggle');
            //console.log(_cText);
        }
        if(_cWidth < 480) {
            _cText = 'iphone landscape ' + _cWidth + 'px';
            $('.client-section').addClass('closeToggle');
            $('ul#filters > li a').addClass('closeToggle');
            //console.log(_cText);
        }
        if(_cWidth < 320) {
            _cText = 'iphone portrait ' + _cWidth + 'px';
            $('.client-section').addClass('closeToggle');
            $('ul#filters > li a').addClass('closeToggle');
            //console.log(_cText);
        }
        if(_cWidth < 240) {
            _cText = 'so small phones ' + _cWidth + 'px';
            $('.client-section').addClass('closeToggle');
            $('ul#filters > li a').addClass('closeToggle');
            //console.log(_cText);
        }
        $(domEl.div_recurrent).on('click', ".agencia", function() {
            $(".closeToggle").slideUp();
        });
        $(domEl.div_recurrent).on('click', ".closeToggle", function() {
            $("#options").slideUp();
        });
    }
/* ------------------------------------------------------ *\
    [functions] valid_extension_file
\* ------------------------------------------------------ */
    function valid_extension_file(formulario, archivo) {
        extensiones_permitidas = new Array('.pdf');

        mierror = "";
        success = "";
        if (!archivo) {
            //Si no tengo archivo, es que no se ha seleccionado un archivo en el formulario
            mierror = "No has seleccionado ningún archivo";
            $('.file-upload-allowed-extensions').css('display', 'block');
            $('.custom-file-upload .invalid-message').css('display', 'block');
            $('.custom-file-upload .invalid-message').html(mierror);
            $('input[type="text"]#job_opportunities_upload_file').attr('value','');
            $('input[type="text"]#job_opportunities_upload_file').val('');
        } else {
            //recupero la extensión de este nombre de archivo
            extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
            //alert (extension);
            //compruebo si la extensión está entre las permitidas
            permitida = false;
            for (var i = 0; i < extensiones_permitidas.length; i++) {
                if (extensiones_permitidas[i] == extension) {
                    permitida = true;
                    break;
                    //CAM.setHTML('div.message_type_file_ok', '');
                }
            }
            if (!permitida) {
                mierror = "Comprueba la extensión de los archivos a subir";
                //mierror = "Comprueba la extensión de los archivos a subir. \nSólo se pueden subir archivos con extensiones: " + extensiones_permitidas.join();
                $('.file-upload-allowed-extensions').css('display', 'block');
                $('.custom-file-upload .invalid-message').css('display', 'block');
                $('.custom-file-upload .invalid-message').html(mierror);
                $('input[type="text"]#job_opportunities_upload_file').attr('value','');
                $('input[type="text"]#job_opportunities_upload_file').val('');
            }else{
                //submito!
                //console.log("Todo correcto. Voy a submitir el formulario.");
                $('.file-upload-allowed-extensions').css('display', 'none');
                $('.custom-file-upload .invalid-message').css('display', 'none');
                //formulario.submit();
                return 1;
            }
        }
        //si estoy aqui es que no se ha podido submitir
        //console.log(mierror);
        return 0;
    }
/* ------------------------------------------------------ *\
    [Methods] owlCarouselMethods
\* ------------------------------------------------------ */
    var owlCarouselMethods = {
        owlCarousel : function () {
            $('.owl-carousel').each(function() {
                var carouselInstance, 
                    carouselColumns, 
                    carouselitemsDesktop, 
                    carouselitemsDesktopSmall,
                    carouselitemsTablet, 
                    carouselitemsMobile, 
                    carouselAutoplay, 
                    carouselPagination,
                    carouselArrows, 
                    carouselSingle, 
                    carouselStyle;

                carouselInstance = $(this);
                carouselColumns = carouselInstance.attr("data-columns")
                    ? carouselInstance.attr("data-columns") : "1";
                carouselitemsDesktop = carouselInstance.attr("data-items-desktop")
                    ? carouselInstance.attr("data-items-desktop") : "4";
                carouselitemsDesktopSmall = carouselInstance.attr("data-items-desktop-small")
                    ? carouselInstance.attr("data-items-desktop-small") : "3";
                carouselitemsTablet = carouselInstance.attr("data-items-tablet")
                    ? carouselInstance.attr("data-items-tablet") : "2";
                carouselitemsMobile = carouselInstance.attr("data-items-mobile")
                    ? carouselInstance.attr("data-items-mobile") : "1";
                carouselAutoplay = carouselInstance.attr("data-autoplay")
                    ? carouselInstance.attr("data-autoplay") : false;
                carouselPagination = carouselInstance.attr("data-pagination") == 'yes'
                    ? true : false;
                carouselArrows = carouselInstance.attr("data-arrows") == 'yes'
                    ? true : false;
                carouselSingle = carouselInstance.attr("data-single-item") == 'yes'
                    ? true : false;
                carouselStyle = carouselInstance.attr("data-style")
                    ? carouselInstance.attr("data-style") : "fade";

                carouselInstance.owlCarousel({
                    items: carouselColumns,
                    autoPlay : carouselAutoplay,
                    navigation : carouselArrows,
                    pagination : carouselPagination,
                    itemsDesktop : [1199, carouselitemsDesktop],
                    itemsDesktopSmall : [979, carouselitemsDesktopSmall],
                    itemsTablet : [768, carouselitemsTablet],
                    itemsMobile : [479, carouselitemsMobile],
                    singleItem : carouselSingle,
                    navigationText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
                    stopOnHover : true,
                    lazyLoad : true,
                    transitionStyle: 'carouselStyle'
                });
            });
        }
    }
/* ------------------------------------------------------ *\
    [Methods] matchMediaMethod
\* ------------------------------------------------------ */
    var matchMediaMethod = {
        mediaquery: function() {
            if (mediaquery.matches) {
                //console.log('mediaquery es min 768px');
            } else {
                //console.log('mediaquery no es min 768px');
            }
        }
    }
/* ------------------------------------------------------ *\
    [Methods] backToTopMethod
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
    [Methods] favicon
\* ------------------------------------------------------ */
    var favicon = {
        load_favicon: function() {
            favicon.change("../img/ico/camcaricon.ico");
            favicon.change("camcaricon.ico");
        },
        change: function(iconURL, optionalDocTitle) {
            if (arguments.length == 2) {
              document.title =  optionamDocTitle;
            }
            this.addLink(iconURL, "shortcut icon");
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
        },
        sticky_wrapper_action_bar: function() {
            $('.actions-bar').waypoint('sticky', {
                wrapper: '<div class="sticky-wrapper-action-bar" />',
                stuckClass: 'tsticky'
            });
        }
    }
/* ------------------------------------------------------ *\
    [Methods] mobile_menu_methods
\* ------------------------------------------------------ */
    var mobile_menu_methods = {
        mobile_menu_toggle: function(event) {
            IS_MOBILE = detectmobile(navigator.userAgent||navigator.vendor||window.opera);
            mediaquery = window.matchMedia("(max-width: 768px)");
            if ( IS_MOBILE == true ) {
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
                //console.log('open');
                return false;
            }
            if (mediaquery.matches) {
               // mediaquery es 768px
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
                //console.log('open');
                //console.log('mediaquery es 768px');
                return false;
            } else {
              // mediaquery no es 768px
              //console.log('mediaquery no es 768px');
            }
        },
        close_menu_toggle: function(event) {
            IS_MOBILE = detectmobile(navigator.userAgent||navigator.vendor||window.opera);
            mediaquery = window.matchMedia("(max-width: 768px)");
            if ( IS_MOBILE == true ) {
                $("#menu-toggle").removeClass('opened');
                $(".toggle-menu").slideToggle();
                //console.log('responsive');
            }
            if (mediaquery.matches) {
               // mediaquery es 768px
               $("#menu-toggle").removeClass('opened');
                $(".toggle-menu").slideToggle();
               //console.log('mediaquery es 768px');
            } else {
              // mediaquery no es 768px
              //console.log('mediaquery no es 768px');
            }
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
    [Methods] setWidthMethod
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
                if( secondDiv.html().length > 218 ) {
                    arrayText2.push( secondDiv.html() );

                    secondDiv.html( secondDiv.html().substr( 0,218 ) + "<i style='color: #000; font-size: 14px;'>...</i>" );

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
    [Methods] addAttrNavAgenciesMethod
\* ------------------------------------------------------ */
    var addAttrNavAgenciesMethod = {
        addAttrNav: function() {
            addAttrNavAgenciesMethod.addAttrNavAgenciesNews();
            //addAttrNavAgenciesMethod.addAttrNavAgenciesTrucks();
            addAttrNavAgenciesMethod.addAttrNavAgenciesPreowned();
        },
        addAttrNavAgenciesNews: function() {
            $('#go-agencies-news').attr({
                'data-agp_nombre':'ford-cavsa',
                'data-agp_id':'4',
                'data-index':'1'
            });
            //console.log('data agp');
        },
        /*addAttrNavAgenciesTrucks: function() {
            $('#go-agencies-trucks').attr({
                'data-agn-trucks-agencie':'eurostern',
                'data-agn-trucks-name':'Eurostern Sprinter',
                'data-agn-trucks-url':'eurostern-sprinter',
                'data-agn-trucks-id':'53'
            });
        },*/
        addAttrNavAgenciesPreowned: function() {
            $('#go-agencies-preowned').attr({
                'data-agn-preowned-name':'Premium by JLR',
                'data-agn-preowned-url':'premium-by-jlr',
                'data-agn-preowned-id':'1',
                'data-agn-preowned-maps':'1'
            });
        }
    }
/* ------------------------------------------------------ *\
    [Methods] toHtmlMethod
\* ------------------------------------------------------ */
    var toHtmlMethod = {
        toHtml: function() {
            $('.to-html').each ( function( key, value ) {
                var html, element;
                element = $(this);
                html = CAM.getHTML(element);
                html = $.trim(html);
                html = CAM.replaceAll(html, '&lt;', '<');
                html = CAM.replaceAll(html, '&gt;', '>');
                CAM.setHTML(element, html);
            });
        }
    }
/* ------------------------------------------------------ *\
    [Methods] smoothScrollMethods
\* ------------------------------------------------------ */
    var smoothScrollMethods = {
        smoothScroll : function (event) {
            if($('nav').hasClass('nav-2')) {
                $('.inner-link').smoothScroll({
                    offset: -55,
                    speed: 800
                });
            } else {
                var navHeight = $('nav').outerHeight();
                $('.inner-link').smoothScroll({
                    offset: -navHeight,
                    speed: 800
                });
            }
        }
    }
/* ------------------------------------------------------ *\
    [Methods] viewNavbarMethod
\* ------------------------------------------------------ */
    var viewNavbarMethod = {
        viewNavbar: function() {
            viewNavbarMethod.recurrentNavbar();
            viewNavbarMethod.loadTemplatesNavbar();
        },
        loadTemplatesNavbar: function() {
            CAM.loadTemplate(tempsNames.recurrent_start_site_navbar, domEl._start_site_navbar_name);
        },
        recurrentNavbar: function() {
            dataStartNavbarAttributes = [
                ['header', {'id':domEl._start_site_navbar, 'class':'navbar navigation-bar-header nav-content'}, '', 1],
            ];
            CAM.appendMulti(domEl.navbar_recurrent, dataStartNavbarAttributes);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] viewHeroSliderMethod
\* ------------------------------------------------------ */
    /*var viewHeroSliderMethod = {
        viewHeroSlider: function() {
            //viewHeroSliderMethod.recurrentHeroSlider();
            //viewHeroSliderMethod.loadTemplatesHeroSlider();
            //heroSliderMobileMethod.heroSliderMobile();
            viewHeroSliderMethod.loadTemplateScrollDown();
        },
        loadTemplatesHeroSlider: function() {
            CAM.loadTemplate(tempsNames.recurrent_about_us_start_hero_slider, domEl._start_section_hero_slider_name);
            bgImageHolderMethods.background_image_holder();
            bgImageHolderMethods.foreground_image_holder();
            heroSliderMobileMethod.showBackgroundsImages();
            heroSliderMobileMethod.sliders();
        },
        loadTemplateScrollDown: function() {
            CAM.loadTemplate(tempsNames.recurrent_start_scroll_down, domEl.scroll_down);
        },
        recurrentHeroSlider: function() {
            dataStartHeroSliderAttributes = [
                ['section', {'id':domEl._start_section_hero_slider, 'class':'hero-slider large-image about-content'}, '', 1]
            ];
            CAM.appendMulti(domEl.hero_slider_recurrent, dataStartHeroSliderAttributes);
        }
    }*/
/* ------------------------------------------------------ *\
    [Methods] heroSliderMobileMethod
\* ------------------------------------------------------ */
    var heroSliderMobileMethod = {
        heroSliderMobile: function() {
            if ( !(/Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i).test(navigator.userAgent || navigator.vendor || window.opera) ) {
                heroSliderMobileMethod.forceHeight_init();
                $(window).scroll(heroSliderMobileMethod.fixedHeaderScrolling);
                heroSliderMobileMethod.hoverBGEffect();
            }
        },
        forceHeight_init: function() {
            skrollr.init({
                forceHeight: false
            });
        },
        fixedHeaderScrolling: function() {
            if($(window).scrollTop() < $('.fixed-header').outerHeight()){
                var scroll = $(window).scrollTop();
                $('.fixed-header').css({transform: 'translateY('+scroll/1.2+'px)'});
                $('.fixed-header .container').css('opacity',(1-(scroll/400)));
            }
        },
        hoverBGEffect: function() {
            $('.hover-background').each(function(){
                var $element;
                $element = $(this);
                $element.mousemove(function( event ) {
                    $element.find('.background-image-holder').css('transform', 'translate(' + -event.pageX /18 + 'px,' + -(event.pageY-($(window).scrollTop())) /50+ 'px)');
                    $element.find('.layer-1').css('transform', 'translate(' + -event.pageX /30 + 'px,' + -event.pageY /30+ 'px)');
                    //$element.find('.layer-2').css('transform', 'translate(' + -event.pageX /20 + 'px,' + -event.pageY /20+ 'px)');
                    /*
                    $element.find('.background-image-holder').css('transform', 'translate(' + -event.pageX /18 + 'px,' + -(event.pageY-($(window).scrollTop())) /50+ 'px)');
                    $element.find('.layer-1').css('transform', 'translate(' + -event.pageX /30 + 'px,' + -event.pageY /30+ 'px)');
                    $element.find('.layer-2').css('transform', 'translate(' + -event.pageX /20 + 'px,' + -event.pageY /20+ 'px)');
                    */
                });
            });
        },
        sliders: function() {
            $('.hero-slider').flexslider({ directionNav: false });
        },
        showBackgroundsImages: function() {
            $('.background-image-holder').addClass('fadeIn');
            $('.foreground-image-holder').addClass('fadeIn');
        }
    }
/* ------------------------------------------------------ *\
    [Methods] hoverIconSocialMethod
\* ------------------------------------------------------ */
    /*var hoverIconSocialMethod = {
        hoverIconSocial: function() {
            $("a.icon-social").hover(
                function() {
                    var i = $(this).find('i');
                    if(i.hasClass("social_facebook")) {
                        $('a.icon-social').css('background', '#3b5998');
                        i.css('color','#fff');
                    } else if(i.hasClass("social_twitter")) {
                        $('a.icon-social').css('background', '#55acee');
                        i.css('color','#fff');
                    } else if(i.hasClass("social_youtube")) {
                        $('a.icon-social').css('background', '#cc181e');
                        i.css('color','#fff');
                    } else if(i.hasClass("social_instagram")) {
                        $('a.icon-social').css('background', '#125688');
                        i.css('color','#fff');
                    }
                }, function() {
                    $(this).find('i').css('color','#FFF');
                }
            );
            $("a.icon-social").attr('target','_blank');
        }
    }*/
/* ------------------------------------------------------ *\
    [Methods] viewSectionHomeMethod
\* ------------------------------------------------------ */
    var viewSectionHomeMethod = {
        viewSectionHome: function() {
            viewSectionHomeMethod.recurrentSecionHome();
            viewSectionHomeMethod.loadTemplatesBanners();
            viewSectionHomeMethod.loadTemplatesOurBrands();
            viewSectionHomeMethod.loadTemplatesGroupCounter();
            CAM.loadTemplate(tempsNames.recurrent_home_full_width_features, domEl._start_full_width_features_name);
            CAM.loadTemplate(tempsNames.recurrent_home_dealer_search_gmap, domEl._start_dealer_search_map_name);
        },
        loadTemplatesBanners: function() {
            var bannersData;
            bannersData = CAM.getInternalJSON(urlsApi.getBanners);
            CAM.loadTemplate(tempsNames.recurrent_home_hero_slide_carousel, domEl._start_hero_carousel_name, bannersData);
        },
        loadTemplatesOurBrands: function() {
            var ourBrandsData;
            ourBrandsData = CAM.getInternalJSON(urlsApi.getBrandsLogos);
            CAM.loadTemplate(tempsNames.recurrent_home_our_brands, domEl._start_large_pad_our_brands_name, ourBrandsData);
        },
        loadTemplatesGroupCounter: function() {
            var groupCounterData;
            groupCounterData = CAM.getInternalJSON(urlsApi.getGroupCounter);
            CAM.loadTemplate(tempsNames.recurrent_home_group_counter, domEl._start_large_pad_group_counter_name, groupCounterData);
        },
        recurrentSecionHome: function() {
            dataStarSiteHomeAttributes = [
                ['div', {'id':domEl._start_hero_carousel, 'class':'about-content hero-content'}, '', 1],
                ['div', {'id':domEl._start_large_pad_our_brands, 'class':'about-content'}, '', 1],
                ['div', {'id':domEl._start_large_pad_group_counter, 'class':'about-content'}, '', 1],
                ['div', {'id':domEl._start_full_width_features, 'class':'about-content'}, '', 1],
                ['div', {'id':domEl._start_dealer_search_map, 'class':'about-content'}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent, dataStarSiteHomeAttributes);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] activeLogAgenciesNewsMethod
\* ------------------------------------------------------ */
    var activeLogAgenciesNewsMethod = {
        activeLogAgenciesNews: function(agn_name) {
            $(domEl.action_new_agn).each(function() {
                var agp_nombre_element;
                agp_nombre_element = $(this).data('agp_nombre');
                if(agn_name === agp_nombre_element) {
                    $(this).children('.img-disable').addClass('active');
                }
            });
        }
    }
/* ------------------------------------------------------ *\
    [Methods] viewSectionAgenciesNewsMethod
\* ------------------------------------------------------ */
    var viewSectionAgenciesNewsMethod = {
        viewSectionAgenciesNews: function(agpid) {
            viewSectionAgenciesNewsMethod.recurrentSecionAgenciesNews();
            viewSectionAgenciesNewsMethod.loadTemplatesUtilityBarBreadcrumb();
            viewSectionAgenciesNewsMethod.loadTemplatesBodyContent();
            viewSectionAgenciesNewsMethod.loadTemplatesAgencesNewsBrands();
            viewSectionAgenciesNewsMethod.loadTemplatesAgenciesNewsCategories(agpid);
        },
        loadTemplatesUtilityBarBreadcrumb: function() {
            CAM.loadTemplate(tempsNames.recurrent_agencies_news_start_utility_bar_breadcrumb, domEl._start_utility_bar_breadcrumb_name);
        },
        loadTemplatesBodyContent: function() {
            CAM.loadTemplate(tempsNames.recurrent_agencies_news_start_large_pad_land_mark, domEl._start_agencies_news_content_body_name);
        },
        loadTemplatesAgencesNewsBrands: function() {
            var logosData;
            logosData = CAM.getInternalJSON(urlsApi.getLogosAgenciesNews);
            CAM.loadTemplate(tempsNames.recurrent_agencies_news_start_large_pad_brands, domEl._start_agencies_news_large_pad_brands_name, logosData);
        },
        loadTemplatesAgenciesNewsCategories: function(agpid) {
            var url, agnNewsData;
            agpid = +agpid;
            url = (!agpid)
                ? urlsApi.getAgenciesNews
                : urlsApi.getAgenciesNews + '/' + agpid;
            agnNewsData = CAM.getInternalJSON(url);
            CAM.loadTemplate(tempsNames.recurrent_agencies_news_start_categories, domEl._start_agencies_news_midpadding_work_name, agnNewsData);
        },
        recurrentSecionAgenciesNews: function() {
            dataStarSiteAgenciesNewsAttributes = [
                ['div', {'id':domEl._start_utility_bar_breadcrumb, 'class':'about-content', 'style':'display: none;'}, '', 1],
                ['section', {'id':domEl._start_agencies_news_content_body, 'class':'large-pad text-hero-2 agencies-news about-content'}, '', 1],
                ['section', {'id':domEl._start_agencies_news_large_pad_brands, 'class':'large-pad agencies-news about-content', 'style':'overflow: visible;'}, '', 1],
                ['section', {'id':domEl._start_agencies_news_midpadding_work, 'class':'large-pad agencies-news about-content', 'style':'overflow: visible;'}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent, dataStarSiteAgenciesNewsAttributes);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] viewSectionAgenciesNewsPrincipalMethod
\* ------------------------------------------------------ */
    var viewSectionAgenciesNewsPrincipalMethod = {
        viewSectionAgenciesNewsPrincipal: function(agn_name_agencia, agn_url, agn_id) {
            viewSectionAgenciesNewsMethod.recurrentSecionAgenciesNews();
            viewSectionAgenciesNewsPrincipalMethod.loadTemplatesUtilityBarBreadcrumb_agnPrincipal(agn_name_agencia);
            viewSectionAgenciesNewsMethod.loadTemplatesBodyContent();
            viewSectionAgenciesNewsMethod.loadTemplatesAgencesNewsBrands();
            viewSectionAgenciesNewsPrincipalMethod.recurrentSecionAgenciesNews__agnPrincipal();
        },
        loadBreadcrumbs_agnPrincipal: function(agn_name_agencia) {
            if ( section === 'agencies-news-principal' ) {
                $('#filter-agencie-news-principal').html(agn_name_agencia);
            }
        },
        loadTemplatesUtilityBarBreadcrumb_agnPrincipal: function(agn_name_agencia) {
            var agnPrincipal, url, campa_agnPrincipal, campaAgnPrincipal, campaAgnPrincipal_Id;

            url = urlsApi.getAgenciesNewsByTypeAgencie + agn_name_agencia;
            agnPrincipal = CAM.getInternalJSON(url);
            //console.log(agn_name_agencia);

            campaAgnPrincipal = agnPrincipal.campa[0].agp_agencia;
            campaAgnPrincipal_Id = agnPrincipal.campa[0].agn_agp_id;

            CAM.loadTemplate(tempsNames.recurrent_agencies_news_by_agencies_start_utility_bar_breadcrumb, domEl._start_utility_bar_breadcrumb_name, agnPrincipal);
            viewSectionAgenciesNewsPrincipalMethod.loadBreadcrumbs_agnPrincipal(campaAgnPrincipal);
            //console.log(campaAgnPrincipal);

            viewSectionAgenciesNewsMethod.loadTemplatesAgenciesNewsCategories(campaAgnPrincipal_Id);
        },
        recurrentSecionAgenciesNews__agnPrincipal: function() {
            dataStarSiteAgenciesNews_agnPrincipal_attributes = [
                ['section', {'id':domEl._start_agencies_news_video_strip, 'class':'action-strip-2 video-strip about-content'}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent, dataStarSiteAgenciesNews_agnPrincipal_attributes);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] viewSectionAgenciesNewsBySubAgencieMethod
\* ------------------------------------------------------ */
    var viewSectionAgenciesNewsBySubAgencieMethod = {
        viewSectionAgenciesNewsBySubAgencie: function(agn_name_agencia, agn_url, agn_id) {
            viewSectionAgenciesNewsMethod.recurrentSecionAgenciesNews();
            viewSectionAgenciesNewsBySubAgencieMethod.loadTemplatesUtilityBarBreadcrumb_subAgencie(agn_name_agencia, agn_url, agn_id);
            viewSectionAgenciesNewsMethod.loadTemplatesBodyContent();
            viewSectionAgenciesNewsMethod.loadTemplatesAgencesNewsBrands();
        },
        loadBreadcrumbs_subAgencie: function(agn_principal, agn_url) {
            if ( section === 'agencies-news-sub-agencie' ) {
                $('#filter-agencie-news-principal').html(agn_principal);
                $('#filter-agencie-news-principal-type').html(agn_url);
                $(domEl._start_agencies_news_midpadding_work_name).remove();
            }
        },
        loadTemplatesUtilityBarBreadcrumb_subAgencie : function (agn_principal, agn_url, agn_id) {
            var url, byAgencieNews, campaAgpAgencie, campaAgnNombre;

            url = urlsApi.getAgenciesNewsByAgencie + agn_url + '/' + agn_id;
            byAgencieNews = CAM.getInternalJSON(url);
            //console.log(url);

            campaAgpAgencie = byAgencieNews.campa[0].agpagencia;
            campaAgnNombre = byAgencieNews.campa[0].agnnombre;

            CAM.loadTemplate(tempsNames.recurrent_agencies_news_by_sub_agencies_start_utility_bar_breadcrumb, domEl._start_utility_bar_breadcrumb_name, byAgencieNews);

            viewSectionAgenciesNewsBySubAgencieMethod.loadBreadcrumbs_subAgencie(campaAgpAgencie, campaAgnNombre);
            //console.log(campaAgpAgencie, campaAgnNombre);

            viewSectionAgenciesNewsBySubAgencieMethod.recurrentSecionAgenciesNewsSubAgencie();

            CAM.loadTemplate(tempsNames.recurrent_agencies_news_start_fachada, domEl._start_agencies_news_fachada_name, byAgencieNews);
            CAM.loadTemplate(tempsNames.recurrent_agencies_news_start_address, domEl._start_agencies_news_address_name, byAgencieNews);
            CAM.loadTemplate(tempsNames.recurrent_agencies_news_start_map, domEl._start_agencies_news_map_name, byAgencieNews);

            mapAgenciesNewsSubAgencieMethod.mapAgenciesNewsSubAgencie();
            mapAgenciesNewsSubAgencieMethod.initMapAgenciesNewsSubAgencie();

            bgImageHolderMethods.appendBgImageHolder2();

            if (byAgencieNews.campa[0].logotipos.agnlogo1 === '' && byAgencieNews.campa[0].logotipos.agnlogo2 === '') {
                $('#content-section-agencies-news-address').remove();
            }
            if (byAgencieNews.campa[0].mapas.agngmapurl === '') {
                $('#content-section-agencies-news-map').remove();
                $('#map-canvas-news').remove();
            }
        },
        recurrentSecionAgenciesNewsSubAgencie: function() {
            dataStarSiteAgenciesNewsSubAgencieAttributes = [
                ['div', {'id':domEl._start_agencies_news_fachada, 'class':'about-content', 'style':'background-color: #f9f9f9;'}, '', 1],
                ['section', {'id':domEl._start_agencies_news_address, 'class':'no-data-adrress about-content', 'style':'padding: 35px 0 0 0;'}, '', 1],
                ['section', {'id':domEl._start_agencies_news_map, 'class':'about-content', 'style':'padding: 25px 5px 25px 5px;'}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent, dataStarSiteAgenciesNewsSubAgencieAttributes);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] mapAgenciesNewsSubAgencieMethod
\* ------------------------------------------------------ */
    var mapAgenciesNewsSubAgencieMethod = {
        mapAgenciesNewsSubAgencie: function() {
            var styles, mapNews, agn_latitud, agn_longitudl, agnId, agnLogo, agnName, agnAddress, agnFolder, dirNews, mapOpcNews, map, marker2, popup, location_center, main_color, saturation_value, brightness_value;

            main_color = '#2d313f';
            saturation_value = -20;
            brightness_value = 5;

            agnId = +CAM.getValue(domEl.input_hidden_mapa);
            mapNews = CAM.getInternalJSON(urlsApi.getAgenciesNewsByMap + agnId);

           agn_latitud = mapNews.campa[0].agnlatitud;
           agn_longitud = mapNews.campa[0].agnlongitud;

            location_center = new google.maps.LatLng(agn_latitud,agn_longitud);

            style = [
                { //set saturation for the labels on the map
                    elementType: "labels",
                    stylers: [ { saturation: saturation_value } ]
                },
                { //poi stands for point of interest - don't show these lables on the map
                    featureType: "poi",
                    elementType: "labels",
                    stylers: [  { visibility: "off" } ]
                },
                { //don't show highways lables on the map
                    featureType: 'road.highway',
                    elementType: 'labels',
                    stylers: [ { visibility: "off" } ]
                },
                {  //don't show local road lables on the map
                    featureType: "road.local",
                    elementType: "labels.icon",
                    stylers: [ { visibility: "off" } ]
                },
                {  //don't show arterial road lables on the map
                    featureType: "road.arterial",
                    elementType: "labels.icon",
                    stylers: [ { visibility: "off" } ]
                },
                { //don't show road lables on the map
                    featureType: "road",
                    elementType: "geometry.stroke",
                    stylers: [ { visibility: "off" } ]
                },
                { //style different elements on the map
                    featureType: "transit",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.government",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.sport_complex",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.attraction",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.business",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "transit",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "transit.station",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "landscape",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]

                },
                {
                    featureType: "road",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "road.highway",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "water",
                    elementType: "geometry",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                }
            ];

            mapOpcNews = {
                zoom: 16,
                center: new google.maps.LatLng(agn_latitud,agn_longitud),
                scrollwheel: false,
                mapTypeControlOptions: {
                    mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
                },
                styles: style
            }

            map = new google.maps.Map(document.getElementById('map-canvas-news'),mapOpcNews);

            marker2 = new google.maps.Marker({
                position: map.getCenter(),
                map: map,
                title: 'CAMCAR',
                icon: "../img/sitio/pin_camcar_2.png" //custom pin icon
            });

            dirNews = mapNews.campa[0].agnfolder;
            agnFolder = '../../img/sitio/agencias/logos';
            agnLogo = mapNews.campa[0].logo.agnlogo2;
            agnName = mapNews.campa[0].agnnombre;
            agnAddress = mapNews.campa[0].agndireccion;

            popup = new google.maps.InfoWindow({
                content:
                    '<div class="marker-info-win" style="text-align: center;">'+
                    '<div class="marker-inner-win"><span class="info-content">'+
                    '<img src="img/'+agnFolder+'/'+agnLogo+'" alt="'+agnName+'" style="margin-botton: 10px;" width="150">'+
                    '<h5 class="marker-heading" style="color:#000; padding: 0px; margin: 0px;">'+agnName+'</h5>'+
                    '<span>'+agnAddress+'</span>' +
                    '</span>'+
                    '</div></div>'
            });

            attachInfoWindowToMarker(map, marker2, popup);

            function attachInfoWindowToMarker( map, marker, infoWindow ) {
                infoWindow.open(map, marker2, popup);
            }
        },
        initMapAgenciesNewsSubAgencie: function() {
            google.maps.event.addDomListener(window, 'load', mapAgenciesNewsSubAgencieMethod.mapAgenciesNewsSubAgencie());
        }
    }
/* ------------------------------------------------------ *\
    [Methods] activeLogAgencieTrucksMethod
\* ------------------------------------------------------ */
    /*var activeLogAgencieTrucksMethod = {
        activeLogAgencieTrucks: function(agn_name) {
            $(domEl.action_truck_agn).each(function() {
                var agp_nombre_element;
                agp_nombre_element = $(this).data('agp_nombre');
                if(agn_name === agp_nombre_element) {
                    $(this).children('.img-disable').addClass('active');
                }
            });
        }
    }*/
/* ------------------------------------------------------ *\
    [Methods] viewSectionAgenciesTrucksMethod
\* ------------------------------------------------------ */
    /*var viewSectionAgenciesTrucksMethod = {
        viewSectionAgenciesTrucks: function(agpid) {
            viewSectionAgenciesTrucksMethod.recurrentSecionAgenciesTrucks();
            viewSectionAgenciesTrucksMethod.loadTemplatesUtilityBarBreadcrumb();
            viewSectionAgenciesTrucksMethod.loadTemplatesBodyContent();
            viewSectionAgenciesTrucksMethod.loadTemplatesAgencesTrucksBrands();
            viewSectionAgenciesTrucksMethod.loadTemplatesAgenciesTrucksCategories(agpid);
        },
        loadTemplatesUtilityBarBreadcrumb: function() {
            CAM.loadTemplate(tempsNames.recurrent_agencies_trucks_start_utility_bar_breadcrumb, domEl._start_utility_bar_breadcrumb_name);
        },
        loadTemplatesBodyContent: function() {
            CAM.loadTemplate(tempsNames.recurrent_agencies_trucks_start_large_pad_land_mark, domEl._start_agencies_trucks_content_body_name);
        },
        loadTemplatesAgencesTrucksBrands: function() {
            var logosData;
            logosData = CAM.getInternalJSON(urlsApi.getLogosAgenciesTrucks);
            CAM.loadTemplate(tempsNames.recurrent_agencies_trucks_start_large_pad_brands, domEl._start_agencies_trucks_large_pad_brands_name, logosData);
        },
        loadTemplatesAgenciesTrucksCategories: function(agpid) {
            var url, agnTrucksData;
            agpid = +agpid;
            url = (!agpid)
                ? urlsApi.getAgenciesTrucks
                : urlsApi.getAgenciesTrucks + '/' + agpid;
            agnTrucksData = CAM.getInternalJSON(url);
            CAM.loadTemplate(tempsNames.recurrent_agencies_trucks_start_categories, domEl._start_agencies_trucks_midpadding_work_name, agnTrucksData);
            viewSectionAgenciesTrucksMethod.gridItemMediaquery();
        },
        gridItemMediaquery: function() {
            mediaquery = window.matchMedia("(max-width: 768px)");
            if (mediaquery.matches) {
                $('.grid li.grid-item:nth-child(odd)').attr('style','');
                //console.log('mediaquery es min 768px');
            } else {
                $('.grid li.grid-item:nth-child(odd)').attr('style','margin-left: 16%;');
                //console.log('mediaquery no es min 768px');
            }
        },
        recurrentSecionAgenciesTrucks: function() {
            dataStarSiteAgenciesTrucksAttributes = [
                ['div', {'id':domEl._start_utility_bar_breadcrumb, 'class':'about-content', 'style':'display: none;'}, '', 1],
                ['section', {'id':domEl._start_agencies_trucks_content_body, 'class':'large-pad text-hero-2 agencies-trucks about-content'}, '', 1],
                ['section', {'id':domEl._start_agencies_trucks_large_pad_brands, 'class':'large-pad agencies-trucks about-content', 'style':'overflow: visible;'}, '', 1],
                ['section', {'id':domEl._start_agencies_trucks_midpadding_work, 'class':'large-pad agencies-trucks about-content', 'style':'overflow: visible;'}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent, dataStarSiteAgenciesTrucksAttributes);
        }
    }*/
/* ------------------------------------------------------ *\
    [Methods] viewSectionAgenciesTrucksPrincipalMethod
\* ------------------------------------------------------ */
    /*var viewSectionAgenciesTrucksPrincipalMethod = {
        viewSectionAgenciesTrucksPrincipal: function(agn_name_agencia, agn_url, agn_id) {
            viewSectionAgenciesTrucksMethod.recurrentSecionAgenciesTrucks();
            viewSectionAgenciesTrucksPrincipalMethod.loadTemplatesUtilityBarBreadcrumb_agnPrincipal(agn_name_agencia);
            viewSectionAgenciesTrucksMethod.loadTemplatesBodyContent();
            viewSectionAgenciesTrucksMethod.loadTemplatesAgencesTrucksBrands();
        },
        loadBreadcrumbs_agnPrincipal: function(agn_name_agencia) {
            if ( section === 'agencies-trucks-principal' ) {
                $('#filter-agencie-trucks-principal').html(agn_name_agencia);
            }
        },
        loadTemplatesUtilityBarBreadcrumb_agnPrincipal: function(agn_name_agencia) {
            var agnPrincipal, url, campa_agnPrincipal, campaAgnPrincipal, campaAgnPrincipal_Id;

            url = urlsApi.getAgenciesTrucksByTypeAgencie + agn_name_agencia;
            agnPrincipal = CAM.getInternalJSON(url);
            //console.log(agn_name_agencia);

            campaAgnPrincipal = agnPrincipal.campa[0].agp_agencia;
            campaAgnPrincipal_Id = agnPrincipal.campa[0].agn_agp_id;

            CAM.loadTemplate(tempsNames.recurrent_agencies_trucks_by_agencies_start_utility_bar_breadcrumb, domEl._start_utility_bar_breadcrumb_name, agnPrincipal);
            viewSectionAgenciesNewsPrincipalMethod.loadBreadcrumbs_agnPrincipal(campaAgnPrincipal);
            //console.log(campaAgnPrincipal);

            viewSectionAgenciesTrucksMethod.loadTemplatesAgenciesTrucksCategories(campaAgnPrincipal_Id);
        }
    }*/
/* ------------------------------------------------------ *\
    [Methods] viewSectionAgenciesTrucksBySubAgencieMethod
\* ------------------------------------------------------ */
    /*var viewSectionAgenciesTrucksBySubAgencieMethod = {
        viewSectionAgenciesTrucksBySubAgencie: function(agn_name_agencia, agn_url, agn_id) {
            viewSectionAgenciesTrucksMethod.recurrentSecionAgenciesTrucks();
            viewSectionAgenciesTrucksBySubAgencieMethod.loadTemplatesUtilityBarBreadcrumb_subAgencie(agn_name_agencia, agn_url, agn_id);
            viewSectionAgenciesTrucksMethod.loadTemplatesBodyContent();
            viewSectionAgenciesTrucksMethod.loadTemplatesAgencesTrucksBrands();
        },
        loadBreadcrumbs_subAgencie: function(agn_principal, agn_url) {
            if ( section === 'agencies-trucks-sub-agencie' ) {
                $('#filter-agencie-trucks-principal').html(agn_principal);
                $('#filter-agencie-trucks-principal-type').html(agn_url);
                $(domEl._start_agencies_trucks_midpadding_work_name).remove();
            }
        },
        loadTemplatesUtilityBarBreadcrumb_subAgencie : function (agn_principal, agn_url, agn_id) {
            var url, byAgencieTrucks, campaAgpAgencie, campaAgnNombre;

            url = urlsApi.getAgenciesTrucksByAgencie + agn_url + '/' + agn_id;
            byAgencieTrucks = CAM.getInternalJSON(url);
            //console.log(url);

            campaAgpAgencie = byAgencieTrucks.campa[0].agpagencia;
            campaAgnNombre = byAgencieTrucks.campa[0].agnnombre;

            CAM.loadTemplate(tempsNames.recurrent_agencies_trucks_by_sub_agencies_start_utility_bar_breadcrumb, domEl._start_utility_bar_breadcrumb_name, byAgencieTrucks);

            viewSectionAgenciesTrucksBySubAgencieMethod.loadBreadcrumbs_subAgencie(campaAgpAgencie, campaAgnNombre);
            //console.log(campaAgpAgencie, campaAgnNombre);

            viewSectionAgenciesTrucksBySubAgencieMethod.recurrentSecionAgenciesTrucksSubAgencie();

            CAM.loadTemplate(tempsNames.recurrent_agencies_trucks_start_fachada, domEl._start_agencies_trucks_fachada_name, byAgencieTrucks);
            CAM.loadTemplate(tempsNames.recurrent_agencies_trucks_start_address, domEl._start_agencies_trucks_address_name, byAgencieTrucks);
            CAM.loadTemplate(tempsNames.recurrent_agencies_trucks_start_map, domEl._start_agencies_trucks_map_name, byAgencieTrucks);

            mapAgenciesTrucksSubAgencieMethod.mapAgenciesTrucksSubAgencie();
            mapAgenciesTrucksSubAgencieMethod.initMapAgenciesTrucksSubAgencie();

            bgImageHolderMethods.appendBgImageHolder2();

            if (byAgencieTrucks.campa[0].logotipos.agnlogo1 === '' && byAgencieTrucks.campa[0].logotipos.agnlogo2 === '') {
                $('#content-section-agencies-trucks-address').remove();
            }
            if (byAgencieTrucks.campa[0].mapas.agngmapurl === '') {
                $('#content-section-agencies-trucks-map').remove();
                $('#map-canvas-trucks').remove();
            }
        },
        recurrentSecionAgenciesTrucksSubAgencie: function() {
            dataStarSiteAgenciesTrucksSubAgencieAttributes = [
                ['div', {'id':domEl._start_agencies_trucks_fachada, 'class':'about-content', 'style':'background-color: #f9f9f9;'}, '', 1],
                ['section', {'id':domEl._start_agencies_trucks_address, 'class':'no-data-adrress about-content', 'style':'padding: 35px 0 0 0;'}, '', 1],
                ['section', {'id':domEl._start_agencies_trucks_map, 'class':'about-content', 'style':'padding: 25px 5px 25px 5px;'}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent, dataStarSiteAgenciesTrucksSubAgencieAttributes);
        }
    }*/
/* ------------------------------------------------------ *\
    [Methods] mapAgenciesTrucksSubAgencieMethod
\* ------------------------------------------------------ */
    /*var mapAgenciesTrucksSubAgencieMethod = {
        mapAgenciesTrucksSubAgencie: function() {
            var styles, mapTrucks, agn_latitud, agn_longitudl, agnId, agnLogo, agnName, agnAddress, agnFolder, dirTrucks, mapOpcNews, map, marker2, popup, location_center, main_color, saturation_value, brightness_value;

            main_color = '#2d313f';
            saturation_value = -20;
            brightness_value = 5;

            agnId = +CAM.getValue(domEl.input_hidden_mapa);
            mapTrucks = CAM.getInternalJSON(urlsApi.getAgenciesTrucksByMap + agnId);

           agn_latitud = mapTrucks.campa[0].agnlatitud;
           agn_longitud = mapTrucks.campa[0].agnlongitud;

            location_center = new google.maps.LatLng(agn_latitud,agn_longitud);

            style = [
                { //set saturation for the labels on the map
                    elementType: "labels",
                    stylers: [ { saturation: saturation_value } ]
                },
                { //poi stands for point of interest - don't show these lables on the map
                    featureType: "poi",
                    elementType: "labels",
                    stylers: [  { visibility: "off" } ]
                },
                { //don't show highways lables on the map
                    featureType: 'road.highway',
                    elementType: 'labels',
                    stylers: [ { visibility: "off" } ]
                },
                {  //don't show local road lables on the map
                    featureType: "road.local",
                    elementType: "labels.icon",
                    stylers: [ { visibility: "off" } ]
                },
                {  //don't show arterial road lables on the map
                    featureType: "road.arterial",
                    elementType: "labels.icon",
                    stylers: [ { visibility: "off" } ]
                },
                { //don't show road lables on the map
                    featureType: "road",
                    elementType: "geometry.stroke",
                    stylers: [ { visibility: "off" } ]
                },
                { //style different elements on the map
                    featureType: "transit",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.government",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.sport_complex",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.attraction",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.business",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "transit",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "transit.station",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "landscape",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]

                },
                {
                    featureType: "road",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "road.highway",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "water",
                    elementType: "geometry",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                }
            ];

            mapOpcNews = {
                zoom: 16,
                center: new google.maps.LatLng(agn_latitud,agn_longitud),
                scrollwheel: false,
                mapTypeControlOptions: {
                    mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
                },
                styles: style
            }

            map = new google.maps.Map(document.getElementById('map-canvas-truck'),mapOpcNews);

            marker2 = new google.maps.Marker({
                position: map.getCenter(),
                map: map,
                title: 'CAMCAR',
                icon: "../img/sitio/pin_camcar_2.png" //custom pin icon
            });

            dirTrucks = mapTrucks.campa[0].agnfolder;
            agnFolder = '../../img/sitio/agencias/logos';
            agnLogo = mapTrucks.campa[0].logo.agnlogo2;
            agnName = mapTrucks.campa[0].agnnombre;
            agnAddress = mapTrucks.campa[0].agndireccion;

            popup = new google.maps.InfoWindow({
                content:
                    '<div class="marker-info-win" style="text-align: center;">'+
                    '<div class="marker-inner-win"><span class="info-content">'+
                    '<img src="img/'+agnFolder+'/'+agnLogo+'" alt="'+agnName+'" style="margin-botton: 10px;" width="150">'+
                    '<h5 class="marker-heading" style="color:#000; padding: 0px; margin: 0px;">'+agnName+'</h5>'+
                    '<span>'+agnAddress+'</span>' +
                    '</span>'+
                    '</div></div>'
            });

            attachInfoWindowToMarker(map, marker2, popup);

            function attachInfoWindowToMarker( map, marker, infoWindow ) {
                infoWindow.open(map, marker2, popup);
            }
        },
        initMapAgenciesTrucksSubAgencie: function() {
            google.maps.event.addDomListener(window, 'load', mapAgenciesTrucksSubAgencieMethod.mapAgenciesTrucksSubAgencie());
        }
    }*/
/* ------------------------------------------------------ *\
    [Methods] activeLogAgenciesPreownedMethod
\* ------------------------------------------------------ */
    var activeLogAgenciesPreownedMethod = {
        activeLogAgenciesPreowned: function(preowned_agn_url) {
            $(domEl.action_preowned_agn).each(function() {
                var preowned_agn_url_element;
                preowned_agn_url_element = $(this).data('agn-preowned-name');
                if(preowned_agn_url === preowned_agn_url_element) {
                    $(this).children('.img-disable').addClass('active');
                }
            });
        }
    }
/* ------------------------------------------------------ *\
    [Methods] viewSectionAgenciesPreownedMethod
\* ------------------------------------------------------ */
    var viewSectionAgenciesPreownedMethod = {
        viewSectionAgenciesPreowned: function() {
            viewSectionAgenciesPreownedMethod.recurrentSecionAgenciesPreowned();
            viewSectionAgenciesPreownedMethod.loadTemplatesUtilityBarBreadcrumb();
            viewSectionAgenciesPreownedMethod.loadTemplatesBodyContent();
            viewSectionAgenciesPreownedMethod.loadTemplatesSmallScreen();
            viewSectionAgenciesPreownedMethod.loadUrlsApiAgencie_pre_owned();
        },
        loadTemplatesUtilityBarBreadcrumb: function() {
            CAM.loadTemplate(tempsNames.recurrent_agencies_preowned_start_utility_bar_breadcrumb, domEl._start_utility_bar_breadcrumb_name);
        },
        loadTemplatesBodyContent: function() {
            CAM.loadTemplate(tempsNames.recurrent_agencies_preowned_start_large_pad_land_mark, domEl._start_agencies_preowned_content_body_name);
        },
        loadTemplatesSmallScreen: function() {
            CAM.loadTemplate(tempsNames.recurrent_agencies_preowned_start_large_pad_small_screen, domEl._start_agencies_preowned_small_screen_name);
            dataStarSiteSectionTabsAttributes = [
                ['div', {'id':domEl._start_agencies_preowned_section_tabs, 'class':'about-content'}, '', 1]
            ];
            CAM.appendMulti(domEl._start_agencies_preowned_small_screen_name, dataStarSiteSectionTabsAttributes);
        },
        loadUrlsApiAgencie_pre_owned : function () {
            var agnPreOwnedData;
            agnPreOwnedData = CAM.getInternalJSON(urlsApi.getAgenciesPreOwned);
            CAM.loadTemplate(tempsNames.recurrent_agencies_preowned_start_tabs_agencies, domEl._start_agencies_preowned_section_tabs_name, agnPreOwnedData);
            //console.log(agnPreOwnedData);
            dataStarSiteAgenciesPreownedByAgencieAttributes = [
                ['div', {'id':domEl._start_agencies_preowned_tab_content_by_agencie, 'class':'tab_content_agencies about-content'}, '', 1]
            ];
            CAM.appendMulti(domEl._start_agencies_preowned_section_tabs_name, dataStarSiteAgenciesPreownedByAgencieAttributes);
        },
        recurrentSecionAgenciesPreowned: function() {
            dataStarSiteAgenciesPreownedAttributes = [
                ['div', {'id':domEl._start_utility_bar_breadcrumb, 'class':'about-content', 'style':'display: none;'}, '', 1],
                ['section', {'id':domEl._start_agencies_preowned_content_body, 'class':'large-pad text-hero-2 agencies-preowned about-content'}, '', 1],
                ['section', {'id':domEl._start_agencies_preowned_small_screen, 'class':'large-pad about-content', 'style':'padding-top: 0px;'}, '', 1],
            ];
            CAM.appendMulti(domEl.div_recurrent, dataStarSiteAgenciesPreownedAttributes);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] viewSectionAgenciesPreownedByAgencieMethod
\* ------------------------------------------------------ */
    var viewSectionAgenciesPreownedByAgencieMethod = {
        viewSectionAgenciesPreownedByAgencie: function(preowned_agn_url, preowned_agn_id) {
            viewSectionAgenciesPreownedMethod.recurrentSecionAgenciesPreowned();
            viewSectionAgenciesPreownedByAgencieMethod.recurrentSecionAgenciesPreownedByAgencie();
            viewSectionAgenciesPreownedByAgencieMethod.loadTemplatesUtilityBarBreadcrumbByAgencie(preowned_agn_url, preowned_agn_id);
            viewSectionAgenciesPreownedMethod.loadTemplatesBodyContent();
            viewSectionAgenciesPreownedMethod.loadTemplatesSmallScreen();
            viewSectionAgenciesPreownedMethod.loadUrlsApiAgencie_pre_owned();
            viewSectionAgenciesPreownedByAgencieMethod.recurrentSectionAgenciesPreownedByAgencie();
            viewSectionAgenciesPreownedByAgencieMethod.loadTemplatesContainerByAgencie(preowned_agn_url, preowned_agn_id);
        },
        loadBreadcrumbsPreownedByAgencie: function(preowned_agn_url) {
            if ( section === 'agencies_preowned_by_agencie' ) {
                $('#filter-agencie-preowned-principal').html(preowned_agn_url);
            }
        },
        loadTemplatesUtilityBarBreadcrumbByAgencie: function(preowned_agn_url, preowned_agn_id) {
            var agencie, byAgencie, campaAgnNombre;

            agencie = urlsApi.getAgenciesPreOwnedByAgencie + preowned_agn_url + '/' + preowned_agn_id;
            byAgencie = CAM.getInternalJSON(agencie);
            //console.log(agencie);

            campaAgnNombre = byAgencie.campa[0].agnnombre;

            CAM.loadTemplate(tempsNames.recurrent_agencies_preowned_by_agencie_start_utility_bar_breadcreumb, domEl._start_utility_bar_breadcrumb_name, byAgencie);
            viewSectionAgenciesPreownedByAgencieMethod.loadBreadcrumbsPreownedByAgencie(campaAgnNombre);
        },
        loadTemplatesContainerByAgencie: function(preowned_agn_url, preowned_agn_id) {
            var agencie, byAgencie, campaAgnNombre;

            agencie = urlsApi.getAgenciesPreOwnedByAgencie + preowned_agn_url + '/' + preowned_agn_id;
            byAgencie = CAM.getInternalJSON(agencie);
            //console.log(byAgencie);

            CAM.loadTemplate(tempsNames.recurrent_agencies_preowned_start_fachada, domEl._start_agencies_preowned_content_fachada_name, byAgencie);
            CAM.loadTemplate(tempsNames.recurrent_agencies_preowned_start_address, domEl._start_agencies_preowned_content_address_name, byAgencie);
            CAM.loadTemplate(tempsNames.recurrent_agencies_preowned_start_map, domEl._start_agencies_preowned_content_map_name, byAgencie);
            bgImageHolderMethods.appendBgImageHolder2();

            mapAgenciePreownedByAgencieMethod.mapAgenciePreownedByAgencie();
            mapAgenciePreownedByAgencieMethod.initMapAgenciePreownedByAgencie();
        },
        recurrentSecionAgenciesPreownedByAgencie: function() {
            dataStarSiteAgenciesPreownedAttributes = [
                ['div', {'id':domEl._start_utility_bar_breadcrumb, 'class':'about-content'}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent, dataStarSiteAgenciesPreownedAttributes);
        },
        recurrentSectionAgenciesPreownedByAgencie: function() {
            byAgencyAttributes = [
                ['div', {'id':domEl._start_agencies_preowned_content_fachada, 'class':'about-content'}, '', 1],
                ['div', {'id':domEl._start_agencies_preowned_content_address, 'class':'about-content'}, '', 1],
                ['div', {'id':domEl._start_agencies_preowned_content_map, 'class':'about-content'}, '', 1]
            ];
            CAM.appendMulti(domEl._start_agencies_preowned_tab_content_by_agencie_name, byAgencyAttributes);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] mapAgenciePreownedByAgencieMethod
\* ------------------------------------------------------ */
    var mapAgenciePreownedByAgencieMethod = {
        mapAgenciePreownedByAgencie: function() {
            var styles, mapNews, agn_latitud, agn_longitudl, agnId, agnLogo, agnName, agnAddress, agnFolder, dirNews, mapOpcNews, map, marker2, popup,
                location_center, main_color, saturation_value, brightness_value;

            main_color = '#2d313f';
            saturation_value = -20;
            brightness_value = 5;

            agnId = +CAM.getValue(domEl.input_hidden_mapa);
            mapNews = CAM.getInternalJSON(urlsApi.getAgenciesPreOwnedByMap + agnId);

           agn_latitud = mapNews.campa[0].agnlatitud;
           agn_longitud = mapNews.campa[0].agnlongitud;

            location_center = new google.maps.LatLng(agn_latitud,agn_longitud);

            style = [
                { //set saturation for the labels on the map
                    elementType: "labels",
                    stylers: [ { saturation: saturation_value } ]
                },
                { //poi stands for point of interest - don't show these lables on the map
                    featureType: "poi",
                    elementType: "labels",
                    stylers: [  { visibility: "off" } ]
                },
                { //don't show highways lables on the map
                    featureType: 'road.highway',
                    elementType: 'labels',
                    stylers: [ { visibility: "off" } ]
                },
                {  //don't show local road lables on the map
                    featureType: "road.local",
                    elementType: "labels.icon",
                    stylers: [ { visibility: "off" } ]
                },
                {  //don't show arterial road lables on the map
                    featureType: "road.arterial",
                    elementType: "labels.icon",
                    stylers: [ { visibility: "off" } ]
                },
                { //don't show road lables on the map
                    featureType: "road",
                    elementType: "geometry.stroke",
                    stylers: [ { visibility: "off" } ]
                },
                { //style different elements on the map
                    featureType: "transit",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.government",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.sport_complex",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.attraction",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.business",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "transit",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "transit.station",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "landscape",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]

                },
                {
                    featureType: "road",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "road.highway",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "water",
                    elementType: "geometry",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                }
            ];

            mapOpcNews = {
                zoom: 16,
                center: new google.maps.LatLng(agn_latitud,agn_longitud),
                scrollwheel: false,
                mapTypeControlOptions: {
                    mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
                },
                styles: style
            }

            map = new google.maps.Map(document.getElementById('map-canvas'),mapOpcNews);

            marker2 = new google.maps.Marker({
                position: map.getCenter(),
                map: map,
                title: 'CAMCAR',
                icon: "../img/sitio/pin_camcar_2.png" //custom pin icon
            });

            dirNews = mapNews.campa[0].agnfolder;
            agnFolder = '../../img/sitio/agencias/logos';
            agnLogo = mapNews.campa[0].agnlogo;
            agnName = mapNews.campa[0].agnnombre;
            agnAddress = mapNews.campa[0].agndireccion;

            popup = new google.maps.InfoWindow({
                content:
                      /*'<div class="infobox"><div class="infobox-inner">'+
                      '<div class="infobox-image" style="background-image: url("http://preview.byaviators.com/theme/superlist/wp-content/uploads/2015/09/yjA2So4sRtmdLFRSkD5t_moulin-fisk.jpg");">'+
                      '<a href="#" class="inventor-favorites-btn-toggle heart" data-listing-id="627" data-ajax-url="http://preview.byaviators.com/theme/superlist/wp-admin/admin-ajax.php">'+
                      '<i class="fa fa-heart-o"></i> <span data-toggle="I Love It">Add to favorites</span>'+
                      '</a>'+
                      '<!-- /.inventor-favorites-btn-toggle -->'+
                      '</div>'+
                      '<div class="infobox-title">'+
                      '<h2><a href="http://preview.byaviators.com/theme/superlist/events/sunbathing/">Sunbathing</a></h2>'+
                      '<div class="infobox-category">'+
                      '<a href="http://preview.byaviators.com/theme/superlist/listing-category/greenpeace/">Greenpeace</a>'+
                      '</div>'+
                      '<!-- /.infobox-category -->'+
                      '</div>'+
                      '<!-- /.infobox-title-->'+
                      '<a class="close">x</a></div>'+
                      '</div>'*/
                    '<div class="marker-info-win" style="text-align: center;">'+
                    '<div class="marker-inner-win"><span class="info-content">'+
                    '<img src="img/'+agnFolder+'/'+agnLogo+'" alt="'+agnName+'" style="margin-botton: 10px;" width="150">'+
                    '<h5 class="marker-heading" style="color:#000; padding: 0px; margin: 0px;">'+agnName+'</h5>'+
                    '<span>'+agnAddress+'</span>' +
                    '</span>'+
                    '</div></div>'
            });

            attachInfoWindowToMarker(map, marker2, popup);

            function attachInfoWindowToMarker( map, marker, infoWindow ) {
                infoWindow.open(map, marker2, popup);
            }
        },
        initMapAgenciePreownedByAgencie: function() {
            google.maps.event.addDomListener(window, 'load', mapAgenciePreownedByAgencieMethod.mapAgenciePreownedByAgencie());
        }
    }
/* ------------------------------------------------------ *\
    [Methods] viewSectionInventoriesPreownedMethod
\* ------------------------------------------------------ */
    var viewSectionInventoriesPreownedMethod = {
        viewSectionInventoriesPreowned: function() {
            viewSectionInventoriesPreownedMethod.recurrentSecionInventoriesPreowned();
            viewSectionInventoriesPreownedMethod.loadTemplatesUtilityBarBreadcrumb();
            viewSectionInventoriesPreownedMethod.loadTemplatesActionBar();
            viewSectionInventoriesPreownedMethod.loadTemplatesFilterSection();
            viewSectionInventoriesPreownedMethod.loadTemplatesListingResults();
            viewSectionInventoriesPreownedMethod.prependCaret();
            viewSectionInventoriesPreownedMethod.gridItemMediaquery();
        },
        loadTemplatesUtilityBarBreadcrumb: function() {
            CAM.loadTemplate(tempsNames.recurrent_inventories_preowned_start_utility_bar_breadcreumb, domEl._start_utility_bar_breadcrumb_name);
        },
        loadTemplatesActionBar: function() {
            CAM.loadTemplate(tempsNames.recurrent_inventories_preowned_start_action_bar, domEl._start_inventories_preowned_action_bar_name);
            viewSectionInventoriesPreownedMethod.recurrentFilterSection();
        },
        loadTemplatesFilterSection: function() {
            getFilterMethod.loadFiltersSection();
            getFilterMethod.refreshFilters();
        },
        loadTemplatesListingResults: function() {
            CAM.loadTemplate(tempsNames.recurrent_inventories_preowned_listing_results, domEl._start_body_content_main_name);
            getFilterMethod.sortingGeneral();
            equalHeightsMethods.equalHeightsLoad();
        },
        prependCaret: function() {
            carretInlineAttributes = {'class': 'fa fa-caret-right'}
            CAM.prependOne('ul.inline li', 'i', carretInlineAttributes, '', 0);
        },
        gridItemMediaquery: function() {
            mediaquery = window.matchMedia("(max-width: 768px)");
            if (mediaquery.matches) {
                $('.field-filter-resp').attr('style','margin-left: -15px; margin-right: -15px;');
                //console.log('mediaquery es min 768px');
            } else {
                $('.field-filter-resp').attr('style','');
                //console.log('mediaquery no es min 768px');
            }
        },
        recurrentFilterSection: function() {
            getFilterSection = [
                ['div', {'id':domEl._start_inventories_preowned_filter_section, 'class':''}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent_start_small_screen_filters, getFilterSection);
        },
        recurrentSecionInventoriesPreowned: function() {
            dataStarSiteInventoriesPreownedAttributes = [
                ['div', {'id':domEl._start_utility_bar_breadcrumb, 'class':'about-content', 'style':'display: none;'}, '', 1],
                ['div', {'id':domEl._start_inventories_preowned_action_bar, 'class':'about-content'}, '', 1],
                ['div', {'id':domEl._start_body_content_main, 'class':'about-content'}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent, dataStarSiteInventoriesPreownedAttributes);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] getFilterMethod
\* ------------------------------------------------------ */
    var getFilterMethod = {
        loadFiltersSection: function() {
            CAM.loadTemplate(tempsNames.recurrent_inventories_preowned_start_panel_filters, domEl._start_inventories_preowned_filter_section_name);
            getFilterMethod.recurrentFieldsFilterSection();
        },
        recurrentFieldsFilterSection: function() {
            fieldsFilters = [
                ['div', {'id':domEl._start_inventories_preowned_field_filter_category, 'class':'col-md-4 field-filter-resp'}, '', 1],
                ['div', {'id':domEl._start_inventories_preowned_field_filter_brands, 'class':'col-md-4 field-filter-resp'}, '', 1],
                ['div', {'id':domEl._start_inventories_preowned_field_filter_models, 'class':'col-md-4 field-filter-resp'}, '', 1]
            ];
            CAM.appendMulti('#panel-filters-cateogories', fieldsFilters);
        },
        refreshFilters: function() {
            var filModelsData, filBrandsData, filCategoryData,
                idAgencie, idCategory, idBrand, idModel;

            idCategory = +CAM.getValue(domEl.input_current_hidden_category);
            idBrand = +CAM.getValue(domEl.input_current_hidden_marc);
            idModel = +CAM.getValue(domEl.input_current_hidden_model);
            //console.log(idCategory, idBrand, idModel);

            filCategoryData = CAM.getInternalJSON(urlsApi.getCategory);
            filBrandsData = (idCategory) ? CAM.getInternalJSON(urlsApi.getCategoryByMarc + idCategory) : {};
            //console.log(filBrandsData);

            filModelsData = (idCategory && idBrand) ? CAM.getInternalJSON(urlsApi.getCategoryModelsByCategoryByMarc + idCategory + '/' + idBrand) : {};

            CAM.loadTemplate(tempsNames.recurrent_inventories_preowned_select_filter_category, domEl._start_inventories_preowned_field_filter_category_name, filCategoryData);
            CAM.loadTemplate(tempsNames.recurrent_inventories_preowned_select_filter_brands, domEl._start_inventories_preowned_field_filter_brands_name, filBrandsData);
            CAM.loadTemplate(tempsNames.recurrent_inventories_preowned_select_filter_models, domEl._start_inventories_preowned_field_filter_models_name, filModelsData);

            $(domEl.select_fil_category).val(idCategory);
            $(domEl.select_fil_brands).val(idBrand);
            $(domEl.select_fil_models).val(idModel);

            if(idBrand === '0') {
                $(domEl.select_fil_brands).attr( "disabled", true );
                $('div.select-marca button').addClass( "disabled" );
                $('div.select-marca ul.dropdown-menu.inner.selectpicker li').addClass( "disabled" );

                $(domEl.select_fil_brands).attr( "disabled", true );
                $('div.select-modelo button').addClass( "disabled" );
                $('div.select-modelo ul.dropdown-menu.inner.selectpicker li').addClass( "disabled" );
            } else {
                $(domEl.select_fil_brands).attr( "disabled", false );
                $('div.select-marca button').removeClass( "disabled" );
                $('div.select-marca ul.dropdown-menu.inner.selectpicker li').removeClass( "disabled" );

                $(domEl.select_fil_brands).attr( "disabled", false );
                $('div.select-modelo button').removeClass( "disabled" );
                $('div.select-modelo ul.dropdown-menu.inner.selectpicker li').removeClass( "disabled" );
            }
            matchMediaMethod.mediaquery();
        },
        sortingGeneral: function() {
            var category, marca, modelo, yearStart, yearFinal, priceStart, priceFinal;

            category = +CAM.getValue(domEl.select_fil_category);
            marca = +CAM.getValue(domEl.select_fil_brands);
            modelo = +CAM.getValue(domEl.select_fil_models);

            url = urlsApi.getSeminuevosByFilter + category + '/' + marca + '/' + modelo;
            byFilters = CAM.getInternalJSON(url);
            //console.log(byFilters);
            CAM.loadTemplate(tempsNames.recurrent_inventories_preowned_views_results_list, domEl.div_recurrent_start_views_result_list, byFilters);
            $('.selectpicker').selectpicker();
        },
        fillingControl: function() {
        },
        changeCategory: function(event) {
            var getCat, getBrd, getMdo, semBrandData;
            getCat = $(domEl.select_fil_category).find(':selected').val();
            getBrd = $(domEl.select_fil_brands).find(':selected').val();
            getMdo = $(domEl.select_fil_models).find(':selected').val();

            $(domEl.input_current_hidden_category).val(getCat);
            $(domEl.input_current_hidden_marc).val(getBrd);
            $(domEl.input_current_hidden_model).val(getMdo);

            if ( section === 'inventories-preowned' ) {
                if ( getCat !== '0' || getCat !== 'Categoría' ) {
                    semBrandData = CAM.getInternalJSON(urlsApi.getCategoryByMarc + getCat);
                    CAM.loadTemplate(tempsNames.recurrent_inventories_preowned_select_filter_brands, domEl._start_inventories_preowned_field_filter_brands_name, semBrandData);

                    $(domEl.select_fil_brands).attr( "disabled", true );
                    $('div.select-marca button').addClass( "disabled" );
                    $('div.select-marca ul.dropdown-menu.inner.selectpicker li').addClass( "disabled" );

                    $(domEl.select_fil_models).attr( "disabled", true );
                    $('div.select-modelo button').addClass( "disabled" );
                    $('div.select-modelo ul.dropdown-menu.inner.selectpicker li').addClass( "disabled" );

                    getFilterMethod.refreshFilters();
                } else {
                    $(domEl.select_fil_brands).attr( "disabled", false );
                    $('div.select-marca button').removeClass( "disabled" );
                    $('div.select-marca ul.dropdown-menu.inner.selectpicker li').removeClass( "disabled" );

                    $(domEl.select_fil_models).attr( "disabled", false );
                    $('div.select-modelo button').removeClass( "disabled" );
                    $('div.select-modelo ul.dropdown-menu.inner.selectpicker li').removeClass( "disabled" );
                    //console.log(semBrandData);
                }
                getFilterMethod.sortingGeneral();
            } else {
                Finch.navigate('/seminuevos/inventarios');
            }
        },
        changeBrands: function(event) {
            var getCat, getBrd, getMdo, semModelData;
            getCat = $(domEl.select_fil_category).find(':selected').val();
            getBrd = $(domEl.select_fil_brands).find(':selected').val();
            getMdo = $(domEl.select_fil_models).find(':selected').val();

            $(domEl.input_current_hidden_marc).val(getBrd);

            if ( section === 'inventories-preowned' ) {
                if ( getBrd !== '0' || getBrd !== 'Marca' ) {
                    $(domEl.select_fil_models).attr( "disabled", true );
                    $('div.select-modelo button').addClass( "disabled" );
                    $('div.select-modelo ul.dropdown-menu.inner.selectpicker li').addClass( "disabled" );
                    getFilterMethod.refreshFilters();
                } else {
                    $(domEl.select_fil_models).attr( "disabled", false );
                    $('div.select-modelo button').removeClass( "disabled" );
                    $('div.select-modelo ul.dropdown-menu.inner.selectpicker li').removeClass( "disabled" );

                    semModelData = CAM.getInternalJSON(urlsApi.getCategoryModelsByCategoryByMarc + getCat + '/' + getBrd);
                    CAM.loadTemplate(tempsNames.recurrent_inventories_preowned_select_filter_models, domEl._start_inventories_preowned_field_filter_models_name, semModelData);
                }
                getFilterMethod.sortingGeneral();
            } else {
                Finch.navigate('/seminuevos/inventarios');
            }
        },
        changeModel: function(event) {
            var getBrd, getMdo;

            getBrd = $(domEl.select_fil_brands).find(':selected').val();
            getMdo = $(domEl.select_fil_models).find(':selected').val();

            $(domEl.input_current_hidden_model).val(getMdo);

            if ( section === 'inventories-preowned' ) {
                CAM.loadTemplate(tempsNames.recurrent_inventories_preowned_views_results_list, domEl.div_recurrent_start_views_result_list, getMdo);
                getFilterMethod.sortingGeneral();

            } else {
                Finch.navigate('/seminuevos/inventarios');
            }
        },
        /*clickGoIndex : function(event) {
            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );
            $(domEl.input_current_hidden_category).val('0');
            $(domEl.input_current_hidden_marc).val('0');
            $(domEl.input_current_hidden_model).val('0');
            getfiltersMethod.refreshFilters();
            getfiltersMethod.sortingGeneral();
            Finch.navigate('/');
            //console.log('return -> index');
        },*/
        resetForm: function () {
            CAM.resetForm("#search-sem");
        }
    }
/* ------------------------------------------------------ *\
    [Methods] viewSectionInventoriesPreownedMethod
\* ------------------------------------------------------ */
    var viewSectionInventoriesPreownedMethodDetails = {
        viewSectionInventoriesPreownedDetails: function(brandName, modelName, semId) {
            viewSectionInventoriesPreownedMethodDetails.recurrentSecionInventoriesPreownedDetails();
            viewSectionInventoriesPreownedMethodDetails.loadTemplatesUtilityBarBreadcrumb(brandName, modelName, semId);
            viewSectionInventoriesPreownedMethod.loadTemplatesActionBar();
            viewSectionInventoriesPreownedMethod.loadTemplatesFilterSection();
            viewSectionInventoriesPreownedMethod.gridItemMediaquery();
        },
        loadBreadcrumbs_inventoriesPreownedDetails: function(brand, model, year) {
            if ( section === 'inventories-preowned-details' ) {
                $('#filter-inventories-preowned-detail-brand').html(brand);
                $('#filter-inventories-preowned-detail-model').html(model);
                $('#filter-inventories-preowned-detail-year').html(year);
            }
        },
        loadTemplatesUtilityBarBreadcrumb: function(brandName, modelName, semId) {
            var semIdData, idBrand, pictureData, idPicture, byDetail,
                campaDetailBrand, campaDetailModel, campaDetailYear, campaDataSemId;

            semIdData = urlsApi.getSeminuevosById + brandName + '/' + modelName + '/' + semId;
            byDetail = CAM.getInternalJSON(semIdData);

            campaDetailBrand = byDetail.campa[0].marca;
            campaDetailModel = byDetail.campa[0].modelo;
            campaDetailYear = byDetail.campa[0].year;
            //campaDataSemId = byDetail.campa[0].id;

            pictureData = CAM.getInternalJSON(urlsApi.getPicturesById + semId);

            // COROUSEL
            idMarca = byDetail.campa[0].id_marc;
            semMarcaData = CAM.getInternalJSON(urlsApi.getCatalogoByMarc + idMarca);

            if ( byDetail.campa.length === 0 ) {
                CAM.setValue('#hidden_mapa', "");
                Finch.navigate('/');
            } else {
                CAM.setValue('#hidden_mapa', semId);
                CAM.loadTemplate(tempsNames.recurrent_inventories_preowned_details_start_utility_bar_breadcreumb, domEl._start_utility_bar_breadcrumb_name, byDetail);
                viewSectionInventoriesPreownedMethodDetails.loadBreadcrumbs_inventoriesPreownedDetails(campaDetailBrand, campaDetailModel, campaDetailYear);

                getFilterMethod.loadFiltersSection();
                getFilterMethod.refreshFilters();

                CAM.loadTemplate(tempsNames.recurrent_inventories_preowned_details_single_vehicle_details, domEl._start_body_content_main_name, byDetail);
                CAM.loadTemplate(tempsNames.recurrent_inventories_preowned_details_table_striped_specification, domEl.div_recurrent_table_specifications, byDetail);

                CAM.loadTemplate(tempsNames.recurrent_inventories_preowned_detalis_vehicle_slider_details, domEl.div_recurrent_vehicle_slider_details, pictureData);

                CAM.loadTemplate(tempsNames.recurrent_inventories_preowned_detalis_wrapper_map, domEl.div_recurrent_wrapper_map);
                mapRecurrentInventoriesPreownedDetalisMethod.mapRecurrentInventoriesPreownedDetalis();
                mapRecurrentInventoriesPreownedDetalisMethod.mapRecurrentInventoriesPreownedDetalisLoad();

                contactMethods_sem_premium_by_model.refreshForm(brandName, modelName, semId);

                CAM.loadTemplate(tempsNames.recurrent_inventories_preowned_details_carousel_vehicles, domEl.div_recurrent_corousel_vehicles, semMarcaData);
                equalHeightsMethods.equalHeightsLoad
            }
        },
        recurrentSecionInventoriesPreownedDetails: function() {
            dataStarSiteInventoriesPreownedAttributes = [
                ['div', {'id':domEl._start_utility_bar_breadcrumb, 'class':'about-content', 'style':'display: none;'}, '', 1],
                ['div', {'id':domEl._start_inventories_preowned_action_bar, 'class':'about-content'}, '', 1],
                ['div', {'id':domEl._start_body_content_main, 'class':'about-content'}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent, dataStarSiteInventoriesPreownedAttributes);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] mapRecurrentInventoriesPreownedDetalisMethod
\* ------------------------------------------------------ */
    var mapRecurrentInventoriesPreownedDetalisMethod = {
        mapRecurrentInventoriesPreownedDetalis: function(data) {
            var styles, mapaData, agn_latitud, agn_longitudl, senId, directorio, agn_folder_agencia, agn_img, agn_name, agn_address, mapOpcNews, map, marker2, popup, location_center, main_color, saturation_value, brightness_value;

            main_color = '#2d313f';
            saturation_value = -20;
            brightness_value = 5;

            senId = +CAM.getValue("#hidden_mapa");
            mapaData = CAM.getInternalJSON(urlsApi.getMapaById + senId);

            agn_latitud = mapaData.campa[0].agnlatitud;
            agn_longitud = mapaData.campa[0].agnlongitud;

            location_center = new google.maps.LatLng(mapaData.campa[0].agn_latitud,mapaData.campa[0].agn_longitud);

            style = [
                { //set saturation for the labels on the map
                    elementType: "labels",
                    stylers: [ { saturation: saturation_value } ]
                },
                { //poi stands for point of interest - don't show these lables on the map
                    featureType: "poi",
                    elementType: "labels",
                    stylers: [  { visibility: "off" } ]
                },
                { //don't show highways lables on the map
                    featureType: 'road.highway',
                    elementType: 'labels',
                    stylers: [ { visibility: "off" } ]
                },
                {  //don't show local road lables on the map
                    featureType: "road.local",
                    elementType: "labels.icon",
                    stylers: [ { visibility: "off" } ]
                },
                {  //don't show arterial road lables on the map
                    featureType: "road.arterial",
                    elementType: "labels.icon",
                    stylers: [ { visibility: "off" } ]
                },
                { //don't show road lables on the map
                    featureType: "road",
                    elementType: "geometry.stroke",
                    stylers: [ { visibility: "off" } ]
                },
                { //style different elements on the map
                    featureType: "transit",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.government",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.sport_complex",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.attraction",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.business",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "transit",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "transit.station",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "landscape",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]

                },
                {
                    featureType: "road",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "road.highway",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "water",
                    elementType: "geometry",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                }
            ];

            mapOpcNews = {
                zoom: 16,
                center: new google.maps.LatLng(mapaData.campa[0].agn_latitud,mapaData.campa[0].agn_longitud),
                scrollwheel: false,
                mapTypeControlOptions: {
                    mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
                },
                styles: style
            }

            map = new google.maps.Map(document.getElementById('map-canvas'),mapOpcNews);

            marker2 = new google.maps.Marker({
                position: map.getCenter(),
                map: map,
                title: 'CAMCAR',
                icon: "../img/sitio/pin_camcar_2.png" //custom pin icon
            });

            directorio = mapaData.campa[0].agn_folder;
            agn_folder_agencia = '../../img/sitio/agencias/logos';
            agn_img = mapaData.campa[0].agn_logo1;
            agn_name = mapaData.campa[0].agn_nombre;
            agn_address = mapaData.campa[0].agn_direccion;

            popup = new google.maps.InfoWindow({
                content:
                    '<div class="marker-info-win" style="text-align: center;">'+
                    '<div class="marker-inner-win"><span class="info-content">'+
                    '<img src="img/'+agn_folder_agencia+'/'+agn_img+'" alt="'+agn_name+'" style="margin-botton: 10px;" width="150">'+
                    '<h5 class="marker-heading" style="color:#000; padding: 0px; margin: 0px;">'+agn_name+'</h5>'+
                    '<span>'+agn_address+'</span>' +
                    '</span>'+
                    '</div></div>'
            });

            attachInfoWindowToMarker(map, marker2, popup);

            function attachInfoWindowToMarker( map, marker, infoWindow ) {
                infoWindow.open(map, marker2, popup);
            }
        },
        mapRecurrentInventoriesPreownedDetalisLoad: function(data) {
            google.maps.event.addDomListener(window, 'load', mapRecurrentInventoriesPreownedDetalisMethod.mapRecurrentInventoriesPreownedDetalis(data));
        }
    }
/* ------------------------------------------------------ *\
    [Methods] contactMethods_sem_premium_by_model
\* ------------------------------------------------------ */
    var contactMethods_sem_premium_by_model = {
        add_formContact_byModel: function() {
            var dataFormContact_byModel;

            dataFormContact_byModel = $(domEl.form_recurrent_contact_by_model_pre_owned).serializeFormJSON();
            //console.log(dataFormContact_byModel);

            return CAM.postalService(urlsApi.post_form_contact_main_by_model, dataFormContact_byModel);
        },
        fillingControl: function() {
            var validFieldsItems, dataFormContact_byModel, isFull, isNoEmpty;
            validFieldsItems = [ 'sem_premium_by_model_contact_name', 'sem_premium_by_model_contact_email', 'sem_premium_by_model_contact_phone', 'sem_premium_by_model_contact_message' ];

            dataFormContact_byModel = $(domEl.form_recurrent_contact_by_model_pre_owned).serializeFormJSON();
            //console.log(dataFormContact_byModel);

            isFull = CAM.validFormFull(dataFormContact_byModel, validFieldsItems);
            $(domEl.send_contact_by_model_pre_owned).attr('disabled', !isFull);

            isEmpty = CAM.validFormFull(dataFormContact_byModel, validFieldsItems);
            $(domEl.send_contact_by_model_pre_owned).attr('disabled', !isEmpty);

            //console.log(dataFormContact_byModel);
        },
        refreshForm: function(mrcNombre, mdoNombre, senId) {
            var semIdData;

            semIdData = CAM.getInternalJSON(urlsApi.getSeminuevosById + mrcNombre + '/' + mdoNombre + '/' + senId);

            CAM.loadTemplate(tempsNames.recurrent_inventories_preowned_details_formsem_contact_by_model, domEl.div_recurrent_form_contact_by_model, semIdData);
            $(domEl.send_contact_by_model_pre_owned).attr('disabled', true);
            //console.log(tempsNames.recurrent_inventories_preowned_details_formsem_contact_by_model, domEl.div_recurrent_form_contact_by_model);
        },
        resetForm: function() {
            CAM.resetForm(domEl.form_recurrent_contact_by_model_pre_owned);
            $(domEl.send_contact_by_model_pre_owned).attr('disabled', true);
        },
        resetLoader: function() {
            $(domEl.form_loader).css('display','none');
        },
        /*finchNavigateReturn: function() {
            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );
            Finch.navigate('/inventarios');
        },*/
        validate_fields_keyup: function() {
            contactMethods_sem_premium_by_model.fillingControl();
        },
        sendContactForm_byModel: function(event) {
            contactMethods_sem_premium_by_model.fillingControl();
            var $contact_by_model_pre_owned_name = $(domEl.input_contact_by_model_pre_owned_name),
                $contact_by_model_pre_owned_email = $(domEl.input_contact_by_model_pre_owned_email),
                $contact_by_model_pre_owned_phone = $(domEl.input_contact_by_model_pre_owned_phone),
                $contact_by_model_pre_owned_message = $(domEl.input_contact_by_model_pre_owned_message);

            var form_errors = 0;
            if( validateMethods.validate_input( $contact_by_model_pre_owned_name ) ){
                form_errors++;
                $contact_by_model_pre_owned_name.focusout();
            }
            if( validateMethods.validate_input( $contact_by_model_pre_owned_email ) ){
                form_errors++;
                $contact_by_model_pre_owned_email.change();
            }
            if( validateMethods.validate_input( $contact_by_model_pre_owned_phone ) ){
                form_errors++;
                $contact_by_model_pre_owned_phone.change();
            }
            if( validateMethods.validate_input( $contact_by_model_pre_owned_message ) ){
                form_errors++;
                $contact_by_model_pre_owned_message.change();
            }
            if( form_errors != 0 ){
                var data = {
                    contact_name : $contact_by_model_pre_owned_name,
                    contact_email : $contact_by_model_pre_owned_email,
                    contact_phone : $contact_by_model_pre_owned_phone,
                    contact_message : $contact_by_model_pre_owned_message,
                    source : 'Contacto'
                }
                var contact_by_model_pre_owned_promise = contactMethods_sem_premium_by_model.add_formContact_byModel();

                contact_by_model_pre_owned_promise.success(function ( data ) {
                    //console.log(data);
                    //ga('send', 'event', 'Contacto', news_srt, departamento, news_val + car_val );
                    setTimeout(function() {
                        //console.log('Espera');
                        setTimeout(function () {
                            $(domEl.form_wrapper).fadeOut( 300 , function(){
                                setTimeout(function () {
                                    $(domEl.form_loader).fadeIn();
                                }, 300);
                            });
                            setTimeout(function () {
                                //console.log("Correo Enviado...");
                                setTimeout(function () {
                                    $(domEl.form_wrapper).fadeOut( 300 , function(){
                                        var correo = $(domEl.input_contact_by_model_pre_owned_email).val();
                                        $(domEl.email_from).text(correo);
                                        setTimeout(function () {
                                            $(domEl.form_thanks).fadeIn();
                                            //console.log(correo);
                                        }, 1800);
                                    });
                                    setTimeout(function () {
                                        $(domEl.form_loader).fadeOut();
                                        contactMethods_sem_premium_by_model.resetForm();
                                        setTimeout(function () {
                                            $(domEl.form_wrapper).fadeIn( 300 , function(){
                                                var correo = $(domEl.input_contact_by_model_pre_owned_email).val();
                                                $(domEl.email_from).text(correo);
                                                $(domEl.form_thanks).fadeOut();
                                            });
                                        }, 3400);
                                    }, 1800);
                                }, 1800);
                            }, 1400);
                        }, 300);
                    }, 500);
                });
                contact_by_model_pre_owned_promise.error(function ( data ) {
                    //console.log(data);
                    setTimeout(function() {
                        //console.log('Espera');
                        setTimeout(function () {
                                $(domEl.form_wrapper).fadeOut( 300 , function(){
                                    setTimeout(function () {
                                        $(domEl.form_loader).fadeIn();
                                    }, 900);
                                });
                            setTimeout(function () {
                                //console.log("Correo Enviado...");
                                setTimeout(function () {
                                    $(domEl.form_wrapper).fadeOut( 300 , function(){
                                        setTimeout(function () {
                                            $(domEl.form_error).fadeIn();
                                        }, 300);
                                    });
                                    setTimeout(function () {
                                        contactMethods_sem_premium_by_model.resetForm();
                                        setTimeout(function () {
                                            $(domEl.form_wrapper).fadeIn( 300 , function(){
                                                $(domEl.form_error).fadeOut();
                                            });
                                            setTimeout(function () {
                                                contactMethods_sem_premium_by_model.resetForm();
                                            }, 1000);
                                        }, 1200);
                                    }, 800);
                                }, 900);
                            }, 400);
                        }, 800);
                    }, 500);
                });
            }
        }
    }
/* ------------------------------------------------------ *\
    [Methods] viewSectionWorkShopMethod
\* ------------------------------------------------------ */
    var viewSectionWorkShopMethod = {
        viewSectionWorkShop: function() {
            viewSectionWorkShopMethod.recurrentSecionWorkShop();
            viewSectionWorkShopMethod.loadTemplatesUtilityBarBreadcrumb();
            viewSectionWorkShopMethod.loadTemplatesWorkshopBodyContent();
            viewSectionWorkShopMethod.loadTemplatesWorkshopBrand();
            viewSectionWorkShopMethod.loadTemplatesWorkshopAgencies();
        },
        loadTemplatesUtilityBarBreadcrumb: function() {
            CAM.loadTemplate(tempsNames.recurrent_workshop_start_utility_bar_breadcrumb, domEl._start_utility_bar_breadcrumb_name);
        },
        loadTemplatesWorkshopBodyContent: function() {
            CAM.loadTemplate(tempsNames.recurrent_workshop_start_large_pad_land_mark, domEl._start_workshop_content_body_name);
        },
        loadTemplatesWorkshopBrand: function() {
            var brandsWorkshopData;

            brandsWorkshopData = CAM.getInternalJSON(urlsApi.getWorkshopBrands);

            CAM.loadTemplate(tempsNames.recurrent_workshop_start_large_pad_brand, domEl._start_workshop_content_brand_name, brandsWorkshopData);
        },
        loadTemplatesWorkshopAgencies: function() {
            var workshopData;

            workshopData = CAM.getInternalJSON(urlsApi.getWorkshop);

            CAM.loadTemplate(tempsNames.recurrent_workshop_start_image_block, domEl._start_workshop_content_agencies_name, workshopData);
        },
        recurrentSecionWorkShop: function() {
            dataStarSiteWorkShopAttributes = [
                ['div', {'id':domEl._start_utility_bar_breadcrumb, 'class':'about-content', 'style':'display: none;'}, '', 1],
                ['section', {'id':domEl._start_workshop_content_body, 'class':'large-pad agencies-workshop text-hero-2 about-content'}, '', 1],
                ['section', {'id':domEl._start_workshop_content_brand, 'class':'large-pad text-hero-2 about-content'}, '', 1],
                ['div', {'id':domEl._start_workshop_content_agencies, 'class':'about-content', 'style':'background-color: #f9f9f9; padding-top: 20px; padding-bottom: 60px;'}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent, dataStarSiteWorkShopAttributes);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] viewSectionRentalMethod
\* ------------------------------------------------------ */
    var viewSectionRentalMethod = {
        viewSectionRental: function(agnRental) {
            viewSectionRentalMethod.recurrentSecionRental();
            viewSectionRentalMethod.loadTemplatesUtilityBarBreadcrumb(agnRental);
            viewSectionRentalMethod.loadTemplatesRentalBodyContent();
            viewSectionRentalMethod.loadTemplatesRentalAgencies(agnRental);
        },
        loadBreadcrumbs_blogByPost: function(agnRental) {
            if ( section === 'rental-agencie' ) {
                $('#filter-rental-agencie').html(agnRental);
            }
        },
        loadTemplatesUtilityBarBreadcrumb: function(agnRental) {
            var rentalData, rentalUrl, campaRentalAgencie;

            rentalUrl = urlsApi.getRental + agnRental;
            rentalData = CAM.getInternalJSON(rentalUrl);

            campaRentalAgencie = rentalData.campa[0].agnBreadcrumb;

            CAM.loadTemplate(tempsNames.recurrent_rental_start_utility_bar_breadcrumb, domEl._start_utility_bar_breadcrumb_name, rentalData);
            viewSectionRentalMethod.loadBreadcrumbs_blogByPost(campaRentalAgencie);
        },
        loadTemplatesRentalBodyContent: function() {
            CAM.loadTemplate(tempsNames.recurrent_rental_start_large_pad_land_mark, domEl._start_rental_content_body_name);
        },
        loadTemplatesRentalAgencies: function(agnRental) {
            var rentalData, rentalUrl, campaRentalAgencie;

            rentalUrl = urlsApi.getRental + agnRental;
            rentalData = CAM.getInternalJSON(rentalUrl);

            CAM.loadTemplate(tempsNames.recurrent_rental_start_image_block, domEl._start_rental_content_agencies_name, rentalData);
        },
        recurrentSecionRental: function() {
            dataStarSiteRentalAttributes = [
                ['div', {'id':domEl._start_utility_bar_breadcrumb, 'class':'about-content', 'style':'display: none;'}, '', 1],
                ['section', {'id':domEl._start_rental_content_body, 'class':'large-pad text-hero-2 about-content'}, '', 1],
                ['div', {'id':domEl._start_rental_content_agencies, 'class':'about-content', 'style':'background-color: #f9f9f9; padding-top: 20px; padding-bottom: 60px;'}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent, dataStarSiteRentalAttributes);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] viewSectionBlogMethod
\* ------------------------------------------------------ */
    var viewSectionBlogMethod = {
        viewSectionBlog: function() {
            viewSectionBlogMethod.recurrentSecionBlog();
            viewSectionBlogMethod.loadTemplatesUtilityBarBreadcrumb();
            viewSectionBlogMethod.loadTemplatesGridHolderBlog();
        },
        loadTemplatesUtilityBarBreadcrumb: function() {
            CAM.loadTemplate(tempsNames.recurrent_blog_news_start_utility_bar_breadcrumb, domEl._start_utility_bar_breadcrumb_name);
        },
        loadTemplatesGridHolderBlog: function() {
            var blogSmallData;
            blogSmallData = CAM.getInternalJSON(urlsApi.getBlog);
            CAM.loadTemplate(tempsNames.recurrent_blog_news_start_grid_holder, domEl._start_body_content_main_name, blogSmallData);

            toHtmlMethod.toHtml();
        },
        recurrentSecionBlog: function() {
            dataStarSiteBlogAttributes = [
                ['div', {'id':domEl._start_utility_bar_breadcrumb, 'class':'about-content'}, '', 1],
                ['div', {'id':domEl._start_body_content_main, 'class':'main about-content', 'role':'main'}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent, dataStarSiteBlogAttributes);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] viewSectionBlogByNewsMethod
\* ------------------------------------------------------ */
    var viewSectionBlogByNewsMethod = {
        viewSectionBlogByNews: function(blogAgencieKey, blogPostkey, blogId) {
            viewSectionBlogByNewsMethod.recurrentSectionBlogByNews();
            viewSectionBlogByNewsMethod.loadTemplatesUtilityBarBreadcrumb(blogAgencieKey, blogPostkey, blogId);
            viewSectionBlogByNewsMethod.loadTemplatesSinglePost(blogAgencieKey, blogPostkey, blogId);
        },
        loadBreadcrumbs_blogByPost: function(blogAgencieKey, blogPostkey) {
            if ( section === 'blog-by-post' ) {
                $('#filter-blog-agencie').html(blogAgencieKey);
                $('#filter-blog-post').html(blogPostkey);
            }
        },
        loadTemplatesUtilityBarBreadcrumb: function(blogAgencieKey, blogPostkey, blogId) {
            var blogPostData, blogUrl, campaBlogAgencia, campaBlogPost;

            blogUrl = urlsApi.getBlogByPost + blogAgencieKey + '/' + blogPostkey + '/' + blogId;
            blogPostData = CAM.getInternalJSON(blogUrl);
            //console.log(blogId, blogAgencieKey, blogPostkey);

            campaBlogAgencia = blogPostData.campa[0].blogAgencia;
            campaBlogPost = blogPostData.campa[0].blogTitulo;

            CAM.loadTemplate(tempsNames.recurrent_blog_by_news_start_utility_bar_breadcrumb, domEl._start_utility_bar_breadcrumb_name, blogPostData);

            viewSectionBlogByNewsMethod.loadBreadcrumbs_blogByPost(campaBlogAgencia, campaBlogPost);
            //console.log(campaBlogAgencia, campaBlogPost);
        },
        loadTemplatesSinglePost: function(blogAgencieKey, blogPostkey, blogId) {
            var blogSinglePost, blogUrl;

            blogUrl = urlsApi.getBlogByPost + blogAgencieKey + '/' + blogPostkey + '/' + blogId;
            blogSinglePost = CAM.getInternalJSON(blogUrl);
            //console.log(blogId, blogAgencieKey, blogPostkey);

            CAM.loadTemplate(tempsNames.recurrent_blog_by_news_start_single_post, domEl._start_body_content_main_name, blogSinglePost);
            toHtmlMethod.toHtml();

            dataSectionBlogGaleryAttributes = [
                ['section', {'id':domEl._start_flexslider, 'class':'slider'}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent_blog_galery, dataSectionBlogGaleryAttributes);
            CAM.loadTemplate(tempsNames.recurrent_blog_by_news_start_single_post_galery, domEl._start_flexslider_name, blogSinglePost);
        },
        recurrentSectionBlogByNews: function() {
            dataStarSiteBlogByNewsAttributes = [
                ['div', {'id':domEl._start_utility_bar_breadcrumb, 'class':'about-content'}, '', 1],
                ['div', {'id':domEl._start_body_content_main, 'class':'about-content'}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent, dataStarSiteBlogByNewsAttributes);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] viewSectionAboutUsMethod
\* ------------------------------------------------------ */
    var viewSectionAboutUsMethod = {
        viewSectionAboutUs: function() {
            viewSectionAboutUsMethod.recurrentSecionAboutUs();
            viewSectionAboutUsMethod.loadTemplatesHeroSlider();
            viewSectionAboutUsMethod.loadTemplateScrollDown();
            viewSectionAboutUsMethod.loadTemplatesDuplicatableContent();
            viewSectionAboutUsMethod.loadTemplatesLargePadFeatureList();
            viewSectionAboutUsMethod.loadTemplatesLargePadLandMark();
        },
        loadTemplatesHeroSlider: function() {
            CAM.loadTemplate(tempsNames.recurrent_about_us_start_hero_slider, domEl._start_hero_carousel_name);
        },
        loadTemplateScrollDown: function() {
            CAM.loadTemplate(tempsNames.recurrent_start_scroll_down, domEl._start_scroll_down_name);
        },
        loadTemplatesUtilityBarBreadcrumb: function() {
            CAM.loadTemplate(tempsNames.recurrent_about_us_start_utility_bar_breadcrumb, domEl._start_utility_bar_breadcrumb_name);
        },
        loadTemplatesDuplicatableContent: function() {
            CAM.loadTemplate(tempsNames.recurrent_about_us_start_duplicatable_content, domEl._start_duplicatable_table_name);
        },
        loadTemplatesLargePadFeatureList: function() {
            CAM.loadTemplate(tempsNames.recurrent_about_us_start_large_pad_feature_list, domEl._start_large_pad_feature_list_name);
        },
        loadTemplatesLargePadLandMark: function() {
            CAM.loadTemplate(tempsNames.recurrent_about_us_start_large_pad, domEl._start_large_pad_land_mark_name);
        },
        recurrentSecionAboutUs: function() {
            dataStarSiteAboutUsAttributes = [
                ['section', {'id':domEl._start_hero_carousel, 'class':'hero-slider large-image fixed-header about-content'}, '', 1],
                ['div', {'id':domEl._start_scroll_down, 'class':'about-content', 'style':'position: absolute; left: 45%; right: 45%; width: 4.2%;'}, '', 1],
                ['section', {'id':domEl._start_duplicatable_table, 'class':'duplicatable-content about-content'}, '', 1],
                ['section', {'id':domEl._start_large_pad_feature_list, 'class':'action-strip-2 video-strip about-content', 'style':'background: rgb(238, 238, 238);'}, '', 1],
                ['section', {'id':domEl._start_large_pad_land_mark, 'class':'large-pad about-content'}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent, dataStarSiteAboutUsAttributes);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] viewSectionAboutUsMethod
\* ------------------------------------------------------ */
    /*
    var viewSectionAboutUsMethod = {
        viewSectionAboutUs: function() {
            viewSectionAboutUsMethod.recurrentSecionAboutUs();
            viewSectionAboutUsMethod.loadTemplatesUtilityBarBreadcrumb();
            viewSectionAboutUsMethod.loadTemplatesLArgePadLandMark();
            viewSectionAboutUsMethod.loadTemplatesLArgePadFeatureList();
            viewSectionAboutUsMethod.loadTemplatesLArgePadContactForm();
            formContactMainMethod.refreshFrom();
        },
        loadTemplatesUtilityBarBreadcrumb: function() {
            CAM.loadTemplate(tempsNames.recurrent_aboutus_start_utility_bar_breadcrumb, domEl._start_utility_bar_breadcrumb_name);
        },
        loadTemplatesLArgePadLandMark: function() {
            CAM.loadTemplate(tempsNames.recurrent_aboutus_start_large_pad_land_mark, domEl._start_large_pad_land_mark_name);
        },
        loadTemplatesLArgePadFeatureList: function() {
            CAM.loadTemplate(tempsNames.recurrent_aboutus_start_large_pad_feature_list, domEl._start_large_pad_feature_list_name);
        },
        loadTemplatesLArgePadContactForm: function() {
            CAM.loadTemplate(tempsNames.recurrent_aboutus_start_large_pad_contact_form, domEl._start_large_pad_contact_form_name);
            CAM.loadTemplate(tempsNames.recurrent_aboutus_start_contact_main, domEl._start_contact_main_name);
        },
        recurrentSecionAboutUs: function() {
            dataStarSiteAboutUsAttributes = [
                ['div', {'id':domEl._start_utility_bar_breadcrumb, 'class':'about-content', 'style':'display: none;'}, '', 1],
                ['section', {'id':domEl._start_large_pad_land_mark, 'class':'large-pad text-hero-2 about-content'}, '', 1],
                ['section', {'id':domEl._start_large_pad_feature_list, 'class':'large-pad feature-lists red-bg about-content'}, '', 1],
                ['section', {'id':domEl._start_large_pad_contact_form, 'class':'large-pad text-hero-2 about-content', 'style':'padding-botto: 0;'}, '', 1],
                ['section', {'id':domEl._start_section_separator, 'class':'section-separator about-content', 'style':'padding: 0px; height: 0px; background-color: #fff; clear: both;'}, '', 1],
                ['section', {'id':domEl._start_contact_main, 'class':'contact-2 about-content'}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent, dataStarSiteAboutUsAttributes);
        }
    }
    */
/* ------------------------------------------------------ *\
    [Methods] views_new_section_contact_method
\* ------------------------------------------------------ */
    var views_new_section_contact_method = {
        views_new_section_contact: function() {
            views_new_section_contact_method.recurrent_new_section_contact();
            views_new_section_contact_method.load_templates_new_contact();
        },
        load_templates_new_contact: function() {
            CAM.loadTemplate(tempsNames.recurrent_new_section_contact_start_large_pad, '#start-large-pad');
        },
        recurrent_new_section_contact: function() {
            data_new_section_contact = [
                ['section', {'id':'start-large-pad', 'class':'large-pad text-hero-2 about-content'}, '', 1],
            ];
            CAM.appendMulti(domEl.div_recurrent, data_new_section_contact);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] viewSectionContactMethod
\* ------------------------------------------------------ */
    var viewSectionContactMethod = {
        viewSectionContact: function() {
            viewSectionContactMethod.recurrentSecionContact();
            viewSectionContactMethod.loadTemplatesUtilityBarBreadcrumb();
            viewSectionContactMethod.loadTemplatesLArgePadContactForm();
            formContactMainMethod.refreshFrom();
        },
        loadTemplatesUtilityBarBreadcrumb: function() {
            CAM.loadTemplate(tempsNames.recurrent_contact_start_utility_bar_breadcrumb, domEl._start_utility_bar_breadcrumb_name);
        },
        loadTemplatesLArgePadContactForm: function() {
            CAM.loadTemplate(tempsNames.recurrent_contact_start_large_pad_contact_form, domEl._start_large_pad_contact_form_name);
            CAM.loadTemplate(tempsNames.recurrent_contact_start_contact_main, domEl._start_contact_main_name);
        },
        recurrentSecionContact: function() {
            dataStarSiteContactAttributes = [
                ['div', {'id':domEl._start_utility_bar_breadcrumb, 'class':'about-content', 'style':'display: none;'}, '', 1],
                ['section', {'id':domEl._start_large_pad_contact_form, 'class':'large-pad text-hero-2 about-content', 'style':'padding-botto: 0;'}, '', 1],
                ['section', {'id':domEl._start_section_separator, 'class':'section-separator about-content', 'style':'padding: 0px; height: 0px; background-color: #fff; clear: both;'}, '', 1],
                ['section', {'id':domEl._start_contact_main, 'class':'contact-2 about-content', 'style':'padding-top: 10px;'}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent, dataStarSiteContactAttributes);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] formContactMainMethod
\* ------------------------------------------------------ */
    var formContactMainMethod = {
        addData_formContactMain: function() {
            var dataFormContact, $postalService;
            dataFormContact = $(domEl.form_cam_form_contact_main).serializeFormJSON();
            //console.log(dataFormContact);
            return CAM.postalService(urlsApi.post_form_contact_main, dataFormContact);
        },
        fillingControl: function() {
            var validFieldsItems, dataFormContact, isFull, isNoEmpty;
            validFieldsItems = [ 'contact_main_name', 'contact_main_email', 'contact_main_message' ];

            dataFormContact = $(domEl.form_cam_form_contact_main).serializeFormJSON();

            isFull = CAM.validFormFull(dataFormContact, validFieldsItems);
            $(domEl.send_cam_contact_main_send).attr('disabled', !isFull);

            isEmpty = CAM.validFormFull(dataFormContact, validFieldsItems);
            $(domEl.send_cam_contact_main_send).attr('disabled', !isEmpty);

            //console.log(dataFormContact);
        },
        refreshFrom: function() {
            CAM.loadTemplate(tempsNames.recurrent_contact_start_form_contact_main, domEl.div_recurrent_form_contact);
            $(domEl.send_cam_contact_main_send).attr('disabled', true);
        },
        resetForm: function() {
            CAM.resetForm(domEl.form_cam_form_contact_main);
            $(domEl.send_cam_contact_main_send).attr('disabled', true);
        },
        resetPreLoader: function() {
            CAM.setHTML('.form-loader', '');
        },
        validate_fields_keyup: function() {
            formContactMainMethod.fillingControl();
        },
        send_contact_main: function(event) {
            formContactMainMethod.fillingControl();
            var $cam_contact_main_name, $cam_contact_main_email, $cam_contact_main_message, form_errors;
            $cam_contact_main_name = $('#cam-contact-main-email');
            $cam_contact_main_email = $('#cam-contact-main-message');
            $cam_contact_main_message = $('#cam-contact-main-name');
            form_errors = 0;
            if( validateMethods.validate_input( $cam_contact_main_name ) ){
                form_errors++;
                $cam_contact_main_name.focusout();
            }
            if( validateMethods.validate_input( $cam_contact_main_email ) ){
                form_errors++;
                $cam_contact_main_email.focusout();
            }
            if( validateMethods.validate_input( $cam_contact_main_message ) ){
                form_errors++;
                $cam_contact_main_message.focusout();
            }
            if( form_errors != 0 ){
                var data = {
                    name : $cam_contact_main_name.val(),
                    email : $cam_contact_main_email.val(),
                    message : $cam_contact_main_message.val(),
                    source : 'Contacto'
                }
                var contact_main_promise = formContactMainMethod.addData_formContactMain();
                contact_main_promise.success(function ( data ) {
                    //console.log(data);
                    //ga('send', 'event', 'Contacto', news_srt, departamento, news_val + car_val );
                    setTimeout(function() {
                        //console.log('Espera');
                        setTimeout(function () {
                            $('#form-wrapper').fadeOut( 300 , function(){
                                setTimeout(function () {
                                    $('.form-loader').fadeIn();
                                }, 300);
                            });
                            setTimeout(function () {
                                //console.log("Correo Enviado...");
                                setTimeout(function () {
                                    $('#form-wrapper').fadeOut( 300 , function(){
                                        var correo = $('#cam-contact-main-email').val();
                                        $('#email-from').text(correo);
                                        setTimeout(function () {
                                            $('.form-thanks').fadeIn();
                                        }, 1800);
                                    });
                                    setTimeout(function () {
                                        $('.form-loader').fadeOut();
                                        formContactMainMethod.resetForm();
                                        setTimeout(function () {
                                            $('#form-wrapper').fadeIn( 300 , function(){
                                                var correo = $('#cam-contact-main-email').val();
                                                $('#email-from').text(correo);
                                                $('.form-thanks').fadeOut();
                                            });
                                        }, 3400);
                                    }, 1800);
                                }, 1800);
                            }, 1400);
                        }, 300);
                    }, 500);
                });
                contact_main_promise.error(function ( data ) {
                    setTimeout(function() {
                        //console.log('Espera');
                        setTimeout(function () {
                                $('#form-wrapper').fadeOut( 300 , function(){
                                    setTimeout(function () {
                                        $('.form-loader').fadeIn();
                                    }, 1000);
                                });
                            setTimeout(function () {
                                //console.log("Correo Enviado...");
                                setTimeout(function () {
                                    $('#form-wrapper').fadeOut( 300 , function(){
                                        setTimeout(function () {
                                            $('.form-error').fadeIn();
                                        }, 1800);
                                    });
                                    setTimeout(function () {
                                        $('.form-loader').fadeOut();
                                        formContactMainMethod.resetForm();
                                        setTimeout(function () {
                                            $('#form-wrapper').fadeIn( 300 , function(){
                                                $('.form-error').fadeOut();
                                            });
                                            setTimeout(function () {
                                                formContactMainMethod.resetForm();
                                            }, 2000);
                                        }, 3400);
                                    }, 1800);
                                }, 5900);
                            }, 3400);
                        }, 1800);
                    }, 500);
                });
            }
        }
    }
/* ------------------------------------------------------ *\
    [Methods] viewSectionJobOpportunitiesMethod
\* ------------------------------------------------------ */
    var viewSectionJobOpportunitiesMethod = {
        viewSectionJobOpportunities: function() {
            viewSectionJobOpportunitiesMethod.recurrentSectionJobOpportunities();
            viewSectionJobOpportunitiesMethod.loadTemplatesLargePadJobOpportinuties();
        },
        loadTemplatesLargePadJobOpportinuties: function() {
            CAM.loadTemplate(tempsNames.recurrent_about_us_start_jop_opportunities, domEl._start_large_pad_job_opportunities_name);
        },
        loadTemplateInputFileUpload: function() {
            CAM.loadTemplate(tempsNames.recurrent_about_us_start_input_file_upload, domEl.div_recurrent_content_input_file);
        },
        recurrentSectionJobOpportunities: function() {
            dataStarSiteJobOpportunitiesAttributes = [
                ['section', {'id':domEl._start_large_pad_job_opportunities, 'class':'large-pad text-hero-2 contact-2 about-content'}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent, dataStarSiteJobOpportunitiesAttributes);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] formJobOpportunitiesMethod
\* ------------------------------------------------------ */
    var formJobOpportunitiesMethod = {
        dataFormJobOpportunities: function() {
            var dataFormJobOpportunities;
            dataFormJobOpportunities = $(domEl.form_job_opportunities).serializeFormJSON();
            //console.log(domEl.form_job_opportunities);
            return CAM.postalService(urlsApi.postJobOpportunities, dataFormJobOpportunities);
        },
        fillingControl: function() {
            var validFieldItems, dataFormJobOpportunities, isFull, isEmpty;
            validFieldsItems = [
                'job_opportunities_first_name',
                'job_opportunities_last_name',
                'job_opportunities_email',
                'job_opportunities_phone',
                'job_opportunities_message'
            ];
            dataFormJobOpportunities = $(domEl.form_job_opportunities).serializeFormJSON();
            //console.log(dataFormJobOpportunities);

            isFull = CAM.validFormFull(dataFormJobOpportunities, validFieldsItems);
            $(domEl.send_btn_job_opportunities).attr('disabled', !isFull);

            /*isEmpty = CAM.validFormFull(dataFormJobOpportunities, validFieldsItems);
            $(domEl.send_btn_job_opportunities).attr('disabled', !isFull);*/
        },
        refreshForm: function() {
            CAM.loadTemplate(tempsNames.recurrent_job_opportunities_content_form, domEl.div_recurrent_content_job_opportunities);
            viewSectionJobOpportunitiesMethod.loadTemplateInputFileUpload();
            customFileMethods.customFile();
            customFileMethods.init_customFile();
            $(domEl.send_btn_job_opportunities).attr('disabled', true);
        },
        resetForm: function() {
            CAM.resetForm(domEl.form_job_opportunities);
            $('#job_opportunities_upload_file_input').attr('value', '');
            $(domEl.send_btn_job_opportunities).attr('disabled', true);
        },
        resetLoader: function() {
            $(domEl.form_loader).css('display','none');
        },
        validateFieldsKeyup: function() {
            formJobOpportunitiesMethod.fillingControl();
        },
        sendJobOpportunities: function() {
            formJobOpportunitiesMethod.fillingControl();
            var $date, $file, $logo, $email, $phone, $message, $file_name, $last_name, $mime_type, $first_name, $file_content, $concessionaire, form_errors;
            $date           = $(domEl.input_job_opportunities_date);
            $file           = $(domEl.input_file_job_opportunities_upload_file);
            $logo           = $(domEl.input_job_opportunities_logo);
            $email          = $(domEl.input_job_opportunities_email);
            $phone          = $(domEl.input_job_opportunities_phone);
            $message        = $(domEl.input_job_opportunities_message);
            $file_name      = $(domEl.input_job_opportunities_file_name);
            $last_name      = $(domEl.input_job_opportunities_last_name);
            $mime_type      = $(domEl.input_job_opportunities_mime);
            $first_name     = $(domEl.input_job_opportunities_first_name);
            $file_content   = $(domEl.input_job_opportunities_file_content);
            $concessionaire = $(domEl.input_job_opportunities_concessionary);
            //console.log($first_name, $last_name, $email, $phone, $message, $file_name, $mime_type, $file_content);

             form_errors = 0;
             if( validateMethods.validate_input( $file ) ){
                form_errors++;
                $file.change();
            }
             if( validateMethods.validate_input( $first_name ) ){
                form_errors++;
                $first_name.focusout();
            }
            if( validateMethods.validate_input( $last_name ) ){
                form_errors++;
                $last_name.focusout();
            }
            if( validateMethods.validate_input( $email ) ){
                form_errors++;
                $email.focusout();
            }
            if( validateMethods.validate_input( $phone ) ){
                form_errors++;
                $phone.focusout();
            }
            if( validateMethods.validate_input( $message ) ){
                form_errors++;
                $message.focusout();
            }
            if ( form_errors != 0 ) {
                var data, job_opportunities_promise;
                data = {
                    date : $date.val(),
                    logo : $logo.val(),
                    email : $email.val(),
                    phone : $phone.val(),
                    message : $message.val(),
                    file_name : $file_name.val(),
                    last_name : $last_name.val(),
                    mime_type : $mime_type.val(),
                    first_name : $first_name.val(),
                    file_content : $file_content.val(),
                    concessionaire : $concessionaire.val(),
                    source : 'Bolsa de Trabajo'
                };
                //console.log(data);
                ga('send', 'event', 'Bottom', 'Bolsa de trabajo', 'Envio de CV Adjunto');
                //console.log('ga("send", "event", "Bottom", "Bolsa de trabajo", "Envio de CV Adjunto")');
                job_opportunities_promise = formJobOpportunitiesMethod.dataFormJobOpportunities();
                //console.log(job_opportunities_promise);
                job_opportunities_promise.success( function ( data ) {
                    setTimeout(function() {
                        //console.log('Espera');
                        setTimeout(function () {
                            $(domEl.form_wrapper).fadeOut( 300 , function(){
                                setTimeout(function () {
                                    $(domEl.form_loader).fadeIn();
                                }, 300);
                            });
                            setTimeout(function () {
                                //console.log("Correo Enviado...");
                                setTimeout(function () {
                                    $(domEl.form_wrapper).fadeOut( 300 , function(){
                                        var correo = $email.val();
                                        $(domEl.email_from).text(correo);
                                        setTimeout(function () {
                                            $(domEl.form_thanks).fadeIn();
                                            //console.log(correo);
                                        }, 1800);
                                    });
                                    setTimeout(function () {
                                        $(domEl.form_loader).fadeOut();
                                        formJobOpportunitiesMethod.resetForm();
                                        setTimeout(function () {
                                            $(domEl.form_wrapper).fadeIn( 300 , function(){
                                                var correo = $email.val();
                                                $(domEl.email_from).text(correo);
                                                $(domEl.form_thanks).fadeOut();
                                            });
                                        }, 3400);
                                    }, 1800);
                                }, 1800);
                            }, 1400);
                        }, 300);
                    }, 500);
                });
                job_opportunities_promise.error( function ( data ) {
                    setTimeout(function() {
                        //console.log('Espera');
                        setTimeout(function () {
                                $(domEl.form_wrapper).fadeOut( 300 , function(){
                                    setTimeout(function () {
                                        $(domEl.form_loader).fadeIn();
                                    }, 900);
                                });
                            setTimeout(function () {
                                //console.log("Correo no enviado...");
                                setTimeout(function () {
                                    $(domEl.form_wrapper).fadeOut( 300 , function(){
                                        setTimeout(function () {
                                            $(domEl.form_error).fadeIn();
                                        }, 300);
                                    });
                                    setTimeout(function () {
                                        formJobOpportunitiesMethod.resetForm();
                                        setTimeout(function () {
                                            $(domEl.form_wrapper).fadeIn( 300 , function(){
                                                $(domEl.form_error).fadeOut();
                                            });
                                            setTimeout(function () {
                                                formJobOpportunitiesMethod.resetForm();
                                            }, 1000);
                                        }, 1200);
                                    }, 800);
                                }, 900);
                            }, 400);
                        }, 800);
                    }, 500);
                });
            }
        }
    }
/* ------------------------------------------------------ *\
    [Methods] CUSTOM FILE
\* ------------------------------------------------------ */
    $.fn.customFile = function() {
        return this.each(function() {
            var $file, $wrap, $inputs, $button, $label, $icons;
            $file = $(this).addClass('custom-file-upload-hidden'); // the original file input
            $wrap = $('<div class="file-upload-wrapper">');
            $input = $('<input type="text" class="cur-hover file-upload-input file-upload-input-resp validate-required" placeholder="Ningún archivo seleccionado..." id="job_opportunities_upload_file_input" name="job_opportunities_upload_file_input" data-validation-data="required|upload" />');
            // Button that will be used in non-IE browsers
            $button = $('<button type="button" class="file-upload-button" id="job_opportunities_upload_file_button" name="job_opportunities_upload_file_button"><i class="fa fa-cloud-upload fa-lg fa-fw" style="padding-right: 35px;"></i> Adjuntar</button>');
            // Hack for IE
            $label = $('<label class="file-upload-button" for="'+ $file[0].id +'" id="job_opportunities_upload_file_label" name="job_opportunities_upload_file_label"><i class="fa fa-cloud-upload fa-lg fa-fw" style="padding-right: 35px;"></i> Adjuntar</label>');
            // Icons type-file
            $icons = $('<span class="file-upload-allowed-extensions button py4 button-transparent col-md-12 col-xs-12"><div class="file-upload-legend">Solo se pueden adjuntar archivos en pdf.</div><div class="file-upload-icons"><i class="tyf-ico-type-file-pdf fa-4x"></i></div></span>');

            // Hide by shifting to the left so we can still trigger events
            $file.css({
                position: 'absolute',
                left: '-9999px'
            });

            $wrap.insertAfter( $file )
            .append( $file, $input, ( isIE ? $label : $button ), $icons );

            // Prevent focus
            $file.attr('tabIndex', -1);
            $button.attr('tabIndex', -1);

            $button.click(function () {
                $file.focus().click(); // Open dialog
            });

            $file.change(function() {
                var files = [], fileArr, filename;
                // If multiple is supported then extract all filenames from the file array
                if ( multipleSupport ) {
                    fileArr = $file[0].files;
                    for ( var i = 0, len = fileArr.length; i < len; i++ ) {
                        files.push( fileArr[i].name );
                    }
                    filename = files.join(', ');
                    // If not supported then just take the value and remove the path to just show the filename
                } else {
                    filename = $file.val().split('\\').pop();
                }
                $input.val( filename ) // Set the value
                .attr('value', filename) // Show filename in title tootlip
                .focus(); // Regain focus
            });

            $input.on({
                blur: function() { $file.trigger('blur'); },
                keydown: function( e ) {
                    if ( e.which === 13 ) { // Enter
                    if ( !isIE ) { $file.trigger('click'); }
                    } else if ( e.which === 8 || e.which === 46 ) { // Backspace & Del
                            // inputted file path is not an image of one of the above types
                            alert("inputted file path is not an image!");
                            // On some browsers the value is read-only with this trick we remove the old input and add a clean clone with all the original events attached
                            $file.replaceWith( $file = $file.clone( true ) );
                            $file.trigger('change');
                            $input.val('');
                    } else if ( e.which === 9 ){ // TAB
                        return;
                    } else { // All other keys
                        return false;
                    }
                }
            });
        });
    };
    var customFileMethods = {
        customFile : function() {
            // Old browser fallback
            if ( !multipleSupport ) {
                $( document ).on('change', 'input.customfile', function() {
                    var $this, uniqId, $wrap, $inputs, $file;
                    $this = $(this);
                    // Create a unique ID so we can attach the label to the input
                    uniqId = 'customfile_'+ (new Date()).getTime();
                    //console.log(uniqId);
                    $wrap = $this.parent();
                    // Filter empty input
                    $inputs = $wrap.siblings().find('.file-upload-input').filter(function(){ return !this.value });
                    $file = $('<input type="file" id="'+ uniqId +'" name="'+ $this.attr('name') +'"/>');

                    // 1ms timeout so it runs after all other events that modify the value have triggered
                    setTimeout(function() {
                        // Add a new input
                        if ( $this.val() ) {
                            // Check for empty fields to prevent creating new inputs when changing files
                            if ( !$inputs.length ) {
                                $wrap.after( $file );
                                $file.customFile();
                            }
                        // Remove and reorganize inputs
                        } else {
                            $inputs.parent().remove();
                            // Move the input so it's always last on the list
                            $wrap.appendTo( $wrap.parent() );
                            $wrap.find('input').focus();
                        }
                    }, 1);
                });
            }
        },
        init_customFile : function() {
            $('input[type=file]').customFile();
        },
        handleFileSelect: function() {
            var file, fileReader, fileList, blob, getFile, reader, name, conten, type, getName, getContent, getType, j, files, output, i, f,
                day, date, month, hour;
            file = window.File;
            fileReader = window.FileReader;
            fileList = window.FileList;
            blob = window.Blob;


            if (file && fileReader && fileList && blob) {
                function handleFileSelect(evt) {
                    files = evt.target.files;

                    getFile = document.getElementById('job_opportunities_upload_file');

                    for( j=0;j<getFile.files.length;j++){reader = new FileReader();//instanciamos FileReader
                        reader.onloadend = (function(f){//creamos la función que recogerá los datos
                            return function(e){
                                //console.log(f);
                                name = f.name;
                                content = e.target.result.split(",",2)[1];//obtenemos el contenido del archivo, estará codificado en Base64
                                type = f.type;

                                getName = name;
                                getContent = content;
                                getType = type;
                                day = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
                                f = new Date();
                                month = new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                                //hour = (new Date()).getTime();

                                CAM.setValue('#job_opportunities_date', day[f.getDay()] + ", " + f.getDate() + " de " + month[f.getMonth()] + " de " + f.getFullYear()/* + ", " + hour*/);

                                //$('#params .file').html(getName);
                                CAM.setValue('#job_opportunities_file_name', getName);
                                //$('#params .mime_type').html(getType);
                                CAM.setValue('#job_opportunities_mime', getType);

                                //$('#params .file_content').html(getContent);
                                CAM.setValue('#job_opportunities_file_content', getContent);

                                //console.log(getName); console.log(getType); console.log(getContent);
                            }
                        })(getFile.files[j]);
                        reader.readAsDataURL(getFile.files[j]);//
                    }
                    /*output = [];//Creamos un arreglo para guardar todos los archivos datos en diferentes posiciones.
                    for (i = 0, f; f = files[i]; i++) {//Recorremos el objeto files para obtener los datos de cada archivo y guardarlos en el arreglo.
                        output.push('<div id="params"><div class="file"></div><div class="file_content"></div><div class="mime_type"></div></div><li><strong>',
                            f.name, '</strong> (', f.type || 'n/a', ') - ',
                            f.size, ' bytes, ultima modificacion: ',
                            f.lastModifiedDate.toLocaleDateString(), '</li>');
                        //console.log(output);
                    }*/
                    //document.getElementById('list').innerHTML = '<ul>' + output.join('') + '</ul>';//Introducimos la lista de archivos entre las etiquetas <ul></ul>
                    //console.log(output);
                }
                document.getElementById('job_opportunities_upload_file').addEventListener('change', handleFileSelect, false);//Ponemos un listener para escuchar cuando el evento Change del input file se ejecute, quiere decir cuando se de click en "Abrir"
            } else {
              //alert();
              //console.log('Tu navegador no tiene soporte para estas funciones.');
            }
        }
    }
/* ------------------------------------------------------ *\
    [Methods] uploadFileMethod
\* ------------------------------------------------------ */
    var uploadFileMethod = {
        fileLoader: function() {
            CAM.loadTemplate(tempsNames.recurrent_about_us_start_input_file_upload, domEl.div_recurrent_content_input_file);
            'use strict';
            $('input#job_board_upload_file').fileupload({
                url: '../resources/public/cv/index.php',
                dataType: 'json',
                done: uploadFileMethod.done(),
                progressall: uploadFileMethod.progressall()
            });
        },
        done: function() {
            return function (e, data) {
                var file_promise, file;
                resetAlert();
                alertify.set({
                    labels: {
                        ok: 'Aceptar',
                        cancel: 'Cancelar'
                    }
                });
                files = data.result.files;
                //console.log(files);
                alertify.success('Archivo Cargado');
            }
        },
        progressall: function() {
            return function (e, data) {
                var progress  = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width', progress + '%',
                    'background-color', '#5cb85c'
                );
            }
        }
    }
/* ------------------------------------------------------ *\
    [Methods] viewSectionPrivacyNoticeMethod
\* ------------------------------------------------------ */
    var viewSectionPrivacyNoticeMethod = {
        viewSectionPrivacyNotice: function() {
            viewSectionPrivacyNoticeMethod.recurrentSecionPrivacyNotice();
            viewSectionPrivacyNoticeMethod.loadTemplatesUtilityBarBreadcrumb();
            viewSectionPrivacyNoticeMethod.loadTemplatesPrivacyNotice();
        },
        loadTemplatesUtilityBarBreadcrumb: function() {
            CAM.loadTemplate(tempsNames.recurrent_privacy_notice_start_utility_bar_breadcreumb, domEl._start_utility_bar_breadcrumb_name);
        },
        loadTemplatesPrivacyNotice: function() {
            CAM.loadTemplate(tempsNames.recurrent_privacy_notice_start_article_wrapper, domEl._start_article_wrapper_name);
        },
        recurrentSecionPrivacyNotice: function() {
            dataStarSitePrivacyNoticeAttributes = [
                ['div', {'id':domEl._start_utility_bar_breadcrumb, 'class':'about-content'}, '', 1],
                ['div', {'id':domEl._start_body_content_main, 'class':'about-content'}, '', 1]
            ];
            CAM.appendMulti(domEl.div_recurrent, dataStarSitePrivacyNoticeAttributes);
            dataArticleWrapper = [
                ['section', {'id':domEl._start_article_wrapper, 'class':'article-wrapper'}, '', 1]
            ];
            CAM.appendMulti(domEl._start_body_content_main_name, dataArticleWrapper);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] clikGoMethods
\* ------------------------------------------------------ */
    var clikGoMethods = {
        clikGo_home: function(event) {
            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );
            ga('send', 'event', 'navigation_bar', 'Menu_Inicio', 'go_index', 'Inicio');
            //console.log("ga('send', 'event', 'navigation_bar', 'Menu_Inicio', 'go_index', 'Inicio');");
            Finch.navigate('/');
        },
        clikGo_agencies_news: function(event) {
            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );
            ga('send', 'event', 'navigation_bar', 'Menu_Agencias_Nuevos', 'go_agencies_news', 'Agencias nuevos');
            //console.log("ga('send', 'event', 'navigation_bar', 'Menu_Agencias_Nuevos', 'go_agencies_news', 'Agencias nuevos');");
            Finch.navigate('/agencias/nuevos');
        },
        clikGo_agencies_news_principal: function(event) {
            var agnPrincipal, $element;
            $element = $(this);
            agnPrincipal = $element.data('agp_nombre');
            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );

            ga('send', 'event', 'navigation_bar_and_filters', 'Menu_Agencias_Nuevos_Principal', 'go_agencies_news', 'Agencia: ' + agnPrincipal);
            //console.log("ga('send', 'event', 'navigation_bar_and_filters', 'Menu_Agencias_Nuevos_Principal', 'go_agencies_news', 'Agencia: '"+ agnPrincipal +"');");

            $(domEl.action_new_agn).children('.img-disable').removeClass('active');
            $element.children('.img-disable').addClass('active');

            Finch.navigate('/agencias/nuevos/' + agnPrincipal );
        },
        clikGo_agencies_news_sub_agencie: function(event) {
            var agpAgencie, agnNombre, url, $element;
            $element = $(this);

            agpAgencia = $element.data('agn-news-agencie');
            agnNombre = $element.data('agn-news-name');
            agnUrl = $element.data('agn-news-url');
            agnId = $element.data('agn-news-id');

            //console.log(agpAgencia, agnNombre, agnUrl, agnId);
            //console.log($element.data());
            ga('send', 'event', 'grid_item_filter', 'sub_agencies', 'go_agencies_news_sub_agencies', 'Sub Agencia: ' + agnNombre);
            //console.log("ga('send', 'event', 'grid_item_filter', 'sub_agencies', 'go_agencies_news_sub_agencies', 'Sub Agencia: '"+ agnNombre +"');");

            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );

            Finch.navigate('/agencias/nuevos/'  + agpAgencia + '/' + agnUrl + '/' + agnId );
        },/*
        clikGo_agencies_trucks: function(event) {
            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );
            Finch.navigate('/agencias/camiones');
        },
        clikGo_agencies_trucks_principal: function(event) {
            var agnPrincipal, $element;
            $element = $(this);
            agnPrincipal = $element.data('agp_nombre');
            $('body,html').animate({ scrollTop: "150" }, 999, 'easeOutExpo' );

            $(domEl.action_new_agn).children('.img-disable').removeClass('active');
            $element.children('.img-disable').addClass('active');

            Finch.navigate('/agencias/camiones/' + agnPrincipal );
        },
        clikGo_agencies_trucks_sub_agencie: function(event) {
            var agpAgencie, agnNombre, url, $element;
            $element = $(this);

            agpAgencia = $element.data('agn-trucks-agencie');
            agnNombre = $element.data('agn-trucks-name');
            agnUrl = $element.data('agn-trucks-url');
            agnId = $element.data('agn-trucks-id');

            //console.log(agpAgencia, agnNombre, agnUrl, agnId);
            //console.log($element.data());
            ga('send', 'event', 'grid_item_filter', 'sub_agencies', 'go_agencies_trucks_sub_agencies', 'Sub Agencia: ' + agnNombre);
            //console.log("ga('send', 'event', 'grid_item_filter', 'sub_agencies', 'go_agencies_trucks_sub_agencies', 'Sub Agencia: '"+ agnNombre +"');");

            $('body,html').animate({ scrollTop: "200" }, 999, 'easeOutExpo' );

            Finch.navigate('/agencias/camiones/'  + agpAgencia + '/' + agnUrl + '/' + agnId );
        },*/
        clickGo_agencies_preowned: function(event) {
            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );
            ga('send', 'event', 'navigation_bar', 'Menu_Agencias_Seminuevos', 'go_agencies_pre-owned', 'Agencias Seminuevos');
            //console.log("ga('send', 'event', 'navigation_bar', 'Menu_Agencias_Seminuevos', 'go_agencies_pre-owned', 'Agencias Seminuevos');");
            Finch.navigate('/agencias/seminuevos');
        },
        clickGo_agencies_preowned_by_agencie: function(event) {
            var $element;
            $element = $(this);
            $('body,html').animate({ scrollTop: "280" }, 999, 'easeOutExpo' );

            agnNombre = $element.data('agn-preowned-name');
            agnUrl = $element.data('agn-preowned-url');
            agnId = $element.data('agn-preowned-id');

            //console.log($element, agnNombre, agnUrl, agnId);

            $(domEl.action_preowned_agn).children('.img-disable').removeClass('active');
            $element.children('.img-disable').addClass('active');

            ga('send', 'event', 'grid_item_filter', 'sub_agencies', 'go_agencies_preo_owned_sub_agencies', 'Sub Agencia: ' + agnNombre);
            //console.log("ga('send', 'event', 'grid_item_filter', 'sub_agencies', 'go_agencies_preo_owned_sub_agencies', 'Sub Agencia: '"+ agnNombre +"');");

            //console.log(agnNombre, agnId);
            //console.log($element.data());
            Finch.navigate('/agencias/seminuevos/' + agnUrl + '/' + agnId);
        },
        clickGo_inventories_preowned: function(event){
            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );
            ga('send', 'event', 'navigation_bar', 'Menu_Seminuevos_Inventarios', 'go_inventories_preowned', 'Inventarios Seminuevos');
            //console.log("ga('send', 'event', 'navigation_bar', 'Menu_Seminuevos_Inventarios', 'go_inventories_preowned', 'Inventarios Seminuevos');");
            //Finch.navigate('/seminuevos/inventarios');
            window.location.href = 'seminuevos/inventarios';
        },
        clickGo_inventories_preowned_details: function(event) {
            var $nameBrand, $nameModel, $semId;
            var $element;
            $element = $(this);
            $nameBrand = $element.data('sem-mrc-nombre-short');
            $nameModel = $element.data('sem-mdo-nombre-short');
            $semId = $element.data('sem-id');

            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );
            ga('send', 'event', 'result_item', 'inventories_preowned_details', 'go_details_inventories_preowned', 'Modelo: ' +$nameBrand, + $nameModel);
            //console.log("ga('send', 'event', 'result_item', 'inventories_preowned_details', 'go_details_inventories_preowned', 'Modelo: '"+ $nameBrand, $nameModel +"');");

            //console.log($element);
            Finch.navigate('/seminuevos/inventarios/' + $nameBrand + '/' + $nameModel + '/' + $semId);
        },
        clickGo_workshop: function(event) {
            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );
            ga('send', 'event', 'navigation_bar', 'Menu_Talleres', 'go_workshop', 'Talleres');
            //console.log("ga('send', 'event', 'navigation_bar', 'Menu_Talleres', 'go_workshop', 'Talleres');");
            Finch.navigate('/talleres');
        },
        clickGo_rental: function(event) {
            var $agn_rental_name, $agn_rental_key, $element;

            $element = $(this);
            $agn_rental_name = $element.data('agencie-rental-name');
            $agn_rental_key = $element.data('agencie-rental-key');

            CAM.setValue('#hidden-agencie-rental-name', $agn_rental_name);
            CAM.setValue('#hidden-agencie-rental-key', $agn_rental_key);

            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );

            ga('send', 'event', 'navigation_bar', 'Menu_Rentas', 'go_rentals', 'Rentas' + $agn_rental_name);
            //console.log("ga('send', 'event', 'navigation_bar', 'Menu_Rentas', 'go_rentals', 'Rentas'" + $agn_rental_name + "');");

            Finch.navigate('/rentas/' + $agn_rental_key);
        },
        clickGo_blog: function(event) {
            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );
            $('.input-hidden').val('');

            ga('send', 'event', 'navigation_bar', 'Menu_Noticias', 'go_blog', 'Noticias');
            //console.log("ga('send', 'event', 'navigation_bar', 'Menu_Noticias', 'go_blog', 'Noticias');");

            Finch.navigate('/noticias');
        },
        clickGo_blogByNotice: function(event) {
            var $setBlog_id, $setAgencieBlog_name, $setAgencieBlog_key, $setBlog_name, $setBlog_key, $element;
            $element = $(this);

            $setBlog_id = $element.data('news-id');
            $setAgencieBlog_name = $element.data('agencie-name');
            $setAgencieBlog_key = $element.data('agencie-key');
            $setBlog_name = $element.data('new-name');
            $setBlog_key = $element.data('new-key');

            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );

            ga('send', 'event', 'grid_item_by_blog', 'blog_by_post', 'go_details_blog', 'Agencia: ' +$setAgencieBlog_name + ', Noticia: ' + $setBlog_name);
            //console.log("ga('send', 'event', 'grid_item_by_blog', 'blog_by_post', 'go_details_blog', 'Agencia: '"+ $setAgencieBlog_name + "', Noticia: '" + $setBlog_name +"');");

            CAM.setValue('#hidden-blog-id', $setBlog_id);
            CAM.setValue('#hidden-agencie-name', $setAgencieBlog_name);
            CAM.setValue('#hidden-agencie-key', $setAgencieBlog_key);
            CAM.setValue('#hidden-blog-name', $setBlog_name);
            CAM.setValue('#hidden-blog-key', $setBlog_key);

            Finch.navigate('/noticias/' + $setAgencieBlog_key + '/' + $setBlog_key + '/' + $setBlog_id);
        },
        clickGoSlider_blogByNotice: function(event) {
            var $setBlog_id, $setAgencieBlog_name, $setAgencieBlog_key, $setBlog_name, $setBlog_key, $element;
            $element = $(this);

            $setBlog_id = $element.data('news-id');
            $setAgencieBlog_name = $element.data('agencie-name');
            $setAgencieBlog_key = $element.data('agencie-key');
            $setBlog_name = $element.data('new-name');
            $setBlog_key = $element.data('new-key');

            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );

            ga('send', 'event', 'slider_item_by_blog', 'blog_by_post', 'go_slider_details_blog', 'Agencia: ' +$setAgencieBlog_name + ', Noticia: ' + $setBlog_name);
            //console.log("ga('send', 'event', 'slider_item_by_blog', 'blog_by_post', 'go_slider_details_blog', 'Agencia: '"+ $setAgencieBlog_name + "', Noticia: '" + $setBlog_name +"');");

            CAM.setValue('#hidden-blog-id', $setBlog_id);
            CAM.setValue('#hidden-agencie-name', $setAgencieBlog_name);
            CAM.setValue('#hidden-agencie-key', $setAgencieBlog_key);
            CAM.setValue('#hidden-blog-name', $setBlog_name);
            CAM.setValue('#hidden-blog-key', $setBlog_key);

            Finch.navigate('/noticias/' + $setAgencieBlog_key + '/' + $setBlog_key);
        },
        clickGo_about_us: function(event) {
            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );
            ga('send', 'event', 'navigation_bar', 'Menu_Nosotros', 'go_about_us', 'Nosotros');
            //console.log("ga('send', 'event', 'navigation_bar', 'Menu_Nosotros', 'go_about_us', 'Nosotros');");
            Finch.navigate('/nosotros');
        },
        clickGo_contact: function(event) {
            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );
            ga('send', 'event', 'navigation_bar', 'Menu_Contacto', 'go_contact', 'Contacto');
            //console.log("ga('send', 'event', 'navigation_bar', 'Menu_Contacto', 'go_contact', 'Contacto');");
            Finch.navigate('/contacto');
        },
        clickGo_info: function(event) {
            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );
            ga('send', 'event', 'button_go_contact_info', 'Button_contact_info', 'go_contact_info', 'Contacto Información');
            //console.log("ga('send', 'event', 'button_go_contact_info', 'Button_contact_info', 'go_contact_info', 'Contacto Información');");
            Finch.navigate('/informacion');
        },
        clickGo_job_opportunities: function(event) {
            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );
            ga('send', 'event', 'go_job_opportunities', 'Bolsa de Trabajo', 'go_job_opportunities', 'Bolsa de Trabajo');
            //console.log("ga('send', 'event', 'go_job_opportunities', 'Bolsa de Trabajo', 'go_pjob_opportunities', 'Bolsa de Trabajo');");
            Finch.navigate('/bolsa-de-trabajo');
        },
        clickGo_privacy_notice: function(event) {
            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo' );
            ga('send', 'event', 'go_privacy_notice', 'Aviso de Privacidad', 'go_privacy_notice', 'Aviso de Privacidad');
            //console.log("ga('send', 'event', 'go_privacy_notice', 'Aviso de Privacidad', 'go_privacy_notice', 'Aviso de Privacidad');");
            Finch.navigate('/aviso-de-privacidad');
        },
        showAgenciesTabs: function(event) {
            $(domEl.button_search_tabs).slideToggle();
        },
        showFilters: function(event) {
            $(domEl.button_search_filters).slideToggle();
        }
    }
/* ------------------------------------------------------ *\
    [Methods] video_strip_methods
\* ------------------------------------------------------ */
    var video_strip_methods = {
        video_strip_pre_video: function(event) {
            $(this).closest('.pre-video').addClass('fade-off');
            $(this).closest('.video-strip').find('.iframe-holder').addClass('show-iframe');
            var that = $(this);
            setTimeout(function(){
                that.closest('.video-strip').find('.iframe-holder').addClass('fade-on');
            },500);
        },
        video_strip_close_frame: function(event) {
            $(this).closest('.iframe-holder').removeClass('fade-on');
            var that = $(this);
            setTimeout(function(){
                that.closest('.video-strip').find('.iframe-holder').removeClass('show-iframe');
                that.closest('.video-strip').find('.pre-video').removeClass('fade-off');
            },500);
        },
        stop_video: function(event) {
            $('iframe').attr('src', $('iframe').attr('src'));
        }
    }
/* ------------------------------------------------------ *\
    [Methods] removeRecurrentsMethod
\* ------------------------------------------------------ */
    var removeRecurrentsMethod = {
        removeRecurrents: function() {
            removeRecurrentsMethod.removeRecurrent_navbar();
            removeRecurrentsMethod.removeRecurrents_home();
            removeRecurrentsMethod.removeRecurrents_agencies_news();
            removeRecurrentsMethod.removeRecurrents_agencies_trucks();
            removeRecurrentsMethod.removeRecurrents_agencies_preonwed();
            removeRecurrentsMethod.removeRecurrent_inventories_preowned();
            removeRecurrentsMethod.removeRecurrents_workshop();
            removeRecurrentsMethod.removeRecurrents_rental();
            removeRecurrentsMethod.removeRecurrents_blog();
            removeRecurrentsMethod.removeRecurrents_blog_by_news();
            removeRecurrentsMethod.removeRecurrents_about_us();
            removeRecurrentsMethod.removeRecurrents_contact();
            removeRecurrentsMethod.removeRecurrents_job_opportunities();
        },
        removeRecurrent_navbar: function() {
            $(domEl._start_site_navbar_name).remove();
            $('.sticky-wrapper').remove();
        },
        removeRecurrents_home: function() {
            $(domEl._start_hero_carousel_name).remove();
            $(domEl._start_large_pad_our_brands_name).remove();
            $(domEl._start_large_pad_group_counter_name).remove();
            $(domEl._start_full_width_features_name).remove();
            $(domEl._start_dealer_search_map_name).remove();
        },
        removeRecurrents_agencies_news: function() {
            $(domEl._start_utility_bar_breadcrumb_name).remove();
            $(domEl._start_agencies_news_content_body_name).remove();
            $(domEl._start_agencies_news_large_pad_brands_name).remove();
            $(domEl._start_agencies_news_midpadding_work_name).remove();
            $(domEl._start_agencies_news_video_strip_name).remove();
            $(domEl._start_agencies_news_fachada_name).remove();
            $(domEl._start_agencies_news_address_name).remove();
            $(domEl._start_agencies_news_map_name).remove();
        },
        removeRecurrents_agencies_trucks: function() {
            $(domEl._start_utility_bar_breadcrumb_name).remove();
            $(domEl._start_agencies_trucks_content_body_name).remove();
            $(domEl._start_agencies_trucks_large_pad_brands_name).remove();
            $(domEl._start_agencies_trucks_midpadding_work_name).remove();
            $(domEl._start_agencies_trucks_fachada_name).remove();
            $(domEl._start_agencies_trucks_address_name).remove();
            $(domEl._start_agencies_trucks_map_name).remove();
        },
        removeRecurrents_agencies_preonwed: function() {
            $(domEl._start_agencies_preowned_content_body_name).remove();
            $(domEl._start_agencies_preowned_small_screen).remove();
            $(domEl._start_agencies_preowned_small_screen_name).remove();
        },
        removeRecurrent_inventories_preowned: function() {
            $(domEl._start_inventories_preowned_action_bar_name).remove();
        },
        removeRecurrents_workshop: function() {
            $(domEl._start_workshop_content_body_name).remove();
            $(domEl._start_workshop_content_brand_name).remove();
            $(domEl._start_workshop_content_agencies_name).remove();
        },
        removeRecurrents_rental: function() {
            $(domEl._start_rental_content_body_name).remove();
            $(domEl._start_rental_content_agencies_name).remove();
        },
        removeRecurrents_blog: function() {
            $(domEl._start_utility_bar_breadcrumb_name).remove();
            $(domEl._start_body_content_main_name).remove();
        },
        removeRecurrents_blog_by_news: function() {
            $(domEl._start_utility_bar_breadcrumb_name).remove();
        },
        removeRecurrents_about_us: function() {
            $(domEl._start_section_hero_slider_name).remove();
            $(domEl._start_scroll_down_name).remove();
            $(domEl._start_duplicatable_table_name).remove();
            $(domEl._start_large_pad_feature_list_name).remove();
            $(domEl._start_large_pad_land_mark_name).remove();
        },
        removeRecurrents_contact: function() {
            $(domEl._start_large_pad_contact_form_name).remove();
            $(domEl._start_section_separator_name).remove();
            $(domEl._start_contact_main_name).remove();
            $('#start-large-pad').remove();
        },
        removeRecurrents_job_opportunities: function() {
            $(domEl._start_large_pad_job_opportunities_name).remove();
        }
    }
/* ------------------------------------------------------ *\
    [Methods] currentSectionMethod
\* ------------------------------------------------------ */
    var currentSectionMethod = {
        currentSection_home: function() {
            $('head title#head-change-section-title').html('CAMCAR Grupo Automotriz');
            $(domEl.goSection_index).addClass('current');
        },
        currentSection_agencies_news: function() {
            $('head title#head-change-section-title').html('CAMCAR Agencias Nuevos');
            $(domEl.goSection_agencies_news).addClass('current');
        },
        currentSection_agencies_trucks: function() {
            $('head title#head-change-section-title').html('CAMCAR Camiones');
            $(domEl.goSection_agencies_trucks).addClass('current');
        },
        currentSection_agencies_preowned: function() {
            $('head title#head-change-section-title').html('CAMCAR Seminuevos');
            $('#dropdown-nav-preowuned').addClass('current');
            $(domEl.goSection_agencies_preowned).addClass('current');
        },
        currentSection_inventories_preowned: function() {
            $('head title#head-change-section-title').html('CAMCAR Inventarios');
            $('#dropdown-nav-preowuned').addClass('current');
            $(domEl.goSection_inventories_preowned).addClass('current');
        },
        currentSection_workshop: function() {
            $('head title#head-change-section-title').html('CAMCAR Talleres');
            $(domEl.goSection_workshop).addClass('current');
        },
        currentSection_rental: function() {
            $('head title#head-change-section-title').html('CAMCAR Rentas');
            $(domEl.goSection_rental).addClass('current');
        },
        currentSection_blog: function() {
            $('head title#head-change-section-title').html('CAMCAR Noticias');
            $(domEl.goSection_blog).addClass('current');
        },
        currentSection_about_us: function() {
            $('head title#head-change-section-title').html('CAMCAR Nosotros');
            $(domEl.goSection_about_us).addClass('current');
            $('.sel-job-board-interest-area > button').attr('data-validation-data','required|upload');
            $('.sel-job-board-interest-area').attr('id','job_opportunities_interest_area');
            $('.sel-job-board-interest-area').attr('name','job_opportunities_interest_area');
            $('.sel-job-board-interest-area > button').addClass('sel-job-board-interest-area-btn');
            $('.sel-job-board-interest-area > div').addClass('sel-job-board-interest-area-div');
        },
        currentSection_contact: function() {
            $('head title#head-change-section-title').html('CAMCAR Contacto');
            $(domEl.goSection_about_us).addClass('current');
            $(domEl.goSection_contact).addClass('current');
        },
        currentSection_job_opportunites: function() {
            $('head title#head-change-section-title').html('CAMCAR Bolsa de trabajo');
            $(domEl.goSection_about_us).addClass('current');
            $(domEl.goSection_job_opportunities).addClass('current');
        },
        remove_currentSection: function() {
            $(domEl.goSection_index).removeClass('current');
            $(domEl.goSection_agencies_news).removeClass('current');
            $(domEl.goSection_agencies_trucks).removeClass('current');
            $(domEl.goSection_agencies_preowned).removeClass('current');
            $(domEl.goSection_inventories_preowned).removeClass('current');
            $(domEl.goSection_workshop).removeClass('current');
            $(domEl.goSection_rental).removeClass('current');
            $(domEl.goSection_blog).removeClass('current');
            $(domEl.goSection_about_us).removeClass('current');
            $(domEl.goSection_contact).removeClass('current');
            $(domEl.goSection_job_opportunities).removeClass('current');
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
                            element.find('.valor').countTo();
                        }
                    }, animationDelay);
                } else {
                    element.addClass( animation + " visible" );
                    element.removeClass('hiding');
                    if(element.hasClass('counter')) {
                        element.find('.valor').countTo();
                    }
                }
            },{accY: -150});
        }
    }
/* ------------------------------------------------------ *\
    [Methods] wow_animated_methods
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
    [Methods] bgImageHolderMethods
\* ------------------------------------------------------ */
    var bgImageHolderMethods = {
        appendBgImageHolder : function () {
            $('.background-image-holder').each(function() {
                var imgSrc, $element;
                $element = $(this);
                imgSrc= $element.children('img').attr('src');
                $element.css('background', 'url("' + imgSrc + '")');
                $element.children('img').hide();
                $element.css('background-position', '15% 65%');
            });
            $('.background-image-holder').addClass('fadeIn');
        },
        appendBgImageHolder2 : function () {
            $('.background-image-holder').each(function() {
                var imgSrc, $element;
                $element = $(this);
                imgSrc = $element.children('img').attr('src');
                $element.css('background', 'url("' + imgSrc + '")');
                $element.children('img').hide();
                $element.css('background-position', '50% 50%');
                $element.css('background-repeat', 'no-repeat');
            });
            $('.background-image-holder').addClass('fadeIn');
        },
        background_image_holder: function() {
            $('.background-image-holder').each(function(){
                var $element, ingSrc;
                $element = $(this);
                imgSrc= $element.children('img').attr('src');

                $element.css('background', 'url("' + imgSrc + '")');
                $element.children('img').hide();
                $element.css('background-position', '50% 50%');
            });
        },
        foreground_image_holder: function() {
            $('.foreground-image-holder').each(function(){
                var $element, ingSrc;
                $element = $(this);
                imgSrc= $element.children('img').attr('src');

                $element.css('background', 'url("' + imgSrc + '")');
                $element.children('img').hide();
                $element.css('background-position', '50% 50%');
            });
        }
    }
/* ------------------------------------------------------ *\
    [Methods] agentMapMethod
\* ------------------------------------------------------ */
    /*var agentMapMethod = {
        agentMap: function() {
            var mapData, agn_latitud, agn_longitudl;

            mapData = CAM.getInternalJSON(urlsApi.getAgentsMapAgencies);
            agn_latitud = mapData.campa[0].agn_latitud;
            agn_longitud = mapData.campa[0].agn_longitud;

            //console.log(mapData, agn_latitud, agn_longitud);

            var map = new GMap2($("#map").get(0));
            var burnsvilleMN = new GLatLng(agn_latitud, agn_longitud);
            map.setCenter(burnsvilleMN, 8);

            // setup 10 random points
            var bounds = map.getBounds();
            var southWest = bounds.getSouthWest();
            var northEast = bounds.getNorthEast();
            var lngSpan = northEast.lng(agn_longitud) - southWest.lng(agn_longitud);
            var latSpan = northEast.lat(agn_latitud) - southWest.lat(agn_latitud);
            var markers = [];
            for (var i = 0; i < mapData.campa.length; i++) {
                var point = new GLatLng(southWest.lat(agn_longitud) + latSpan * Math.random(),
                    southWest.lng(agn_longitud) + lngSpan * Math.random());
                marker = new GMarker(point);
                map.addOverlay(marker);
                markers[i] = marker;
            }

            $(markers).each(function(i,marker){
                $("<li />")
                    .html("Point "+i)
                    .click(function(){
                        displayPoint(marker, i);
                    })
                    .appendTo("#list");

                GEvent.addListener(marker, "click", function(){
                    displayPoint(marker, i);
                });
            });

            $("#message").appendTo(map.getPane(G_MAP_FLOAT_SHADOW_PANE));

            function displayPoint(marker, index){
                $("#message").hide();

                var moveEnd = GEvent.addListener(map, "moveend", function(){
                    var markerOffset = map.fromLatLngToDivPixel(marker.getLatLng());
                    $("#message")
                        .fadeIn()
                        .css({ top:markerOffset.y, left:markerOffset.x });

                    GEvent.removeListener(moveEnd);
                });
                map.panTo(marker.getLatLng());
            }
        }
    }*/
/* ------------------------------------------------------ *\
    [Methods] Google Maps -> agentsMap
\* ------------------------------------------------------ */
    var agentsMap = {
        AgentsMap : function () {
            var styles, mapData, agn_name, agn_address, agn_latitud, agn_longitudl,
                directorio, agn_folder_agencia, agn_img, location_center, mapOptions,
                map, markers, bounds, info_windows, main_color, saturation_value, brightness_value, content_infoWindow;

            main_color = '#2d313f';
            saturation_value = -20;
            brightness_value = 5;

            mapData = CAM.getInternalJSON(urlsApi.getAgentsMapAgencies);
            agn_latitud = mapData.campa[0].agn_latitud;
            agn_longitud = mapData.campa[0].agn_longitud;

            // Create an array of styles.
            style = [
                { //set saturation for the labels on the map
                    elementType: "labels",
                    stylers: [ { saturation: saturation_value } ]
                },
                { //poi stands for point of interest - don't show these lables on the map
                    featureType: "poi",
                    elementType: "labels",
                    stylers: [  { visibility: "off" } ]
                },
                { //don't show highways lables on the map
                    featureType: 'road.highway',
                    elementType: 'labels',
                    stylers: [ { visibility: "off" } ]
                },
                {  //don't show local road lables on the map
                    featureType: "road.local",
                    elementType: "labels.icon",
                    stylers: [ { visibility: "off" } ]
                },
                {  //don't show arterial road lables on the map
                    featureType: "road.arterial",
                    elementType: "labels.icon",
                    stylers: [ { visibility: "off" } ]
                },
                { //don't show road lables on the map
                    featureType: "road",
                    elementType: "geometry.stroke",
                    stylers: [ { visibility: "off" } ]
                },
                { //style different elements on the map
                    featureType: "transit",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.government",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.sport_complex",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.attraction",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "poi.business",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "transit",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "transit.station",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "landscape",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]

                },
                {
                    featureType: "road",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "road.highway",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                },
                {
                    featureType: "water",
                    elementType: "geometry",
                    stylers: [
                        { hue: main_color },
                        { visibility: "on" },
                        { lightness: brightness_value },
                        { saturation: saturation_value }
                    ]
                }
            ];

            mapOptions = {
                zoom: 17,
                center: new google.maps.LatLng(mapData.campa[0].agn_latitud,mapData.campa[0].agn_longitud),
                scrollwheel: false,
                mapTypeControlOptions: {
                    mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
                },
                styles: style,
            }

            map = new google.maps.Map(document.getElementById("gmap"), mapOptions);

            markers = new Array();
            bounds = new google.maps.LatLngBounds();
            info_windows = new Array();

            // Properties Array
            for (var i=0; i < mapData.campa.length; i++) {
                agn_name = mapData.campa[i].agn_nombre;
                agn_address = mapData.campa[i].agn_direccion;
                directorio = mapData.campa[i].agn_folder;
                agn_folder_agencia = 'sitio/agencias/logos';
                agn_img = mapData.campa[i].agn_logo2;
                agn_latitud = mapData.campa[i].agn_latitud;
                agn_longitud = mapData.campa[i].agn_longitud;
                // InfoWindow content
                content_infoWindow = '<div id="iw-container">' +
                                        '<div class="iw-title">'+agn_name+'</div>' +
                                        '<div class="iw-content">' +
                                          '<img src="../img/'+agn_folder_agencia+'/'+agn_img+'" alt="'+agn_name+'" width="100">' +
                                          '<p>'+agn_address+'</p>' +
                                        '</div>' +
                                        '<div class="iw-bottom-gradient"></div>' +
                                      '</div>';

                markers[i] = new google.maps.Marker({
                    position: new google.maps.LatLng(mapData.campa[i].agn_latitud,mapData.campa[i].agn_longitud),
                    map: map,
                    icon: '../img/sitio/pin_camcar_2.png',
                    title: agn_name,
                    animation: google.maps.Animation.DROP
                });

                bounds.extend(markers[i].getPosition());

                info_windows[i] = new google.maps.InfoWindow({
                    //content: content_infoWindow,
                    content:
                        '<div class="marker-info-win" style="text-align: center;">'+
                        '<div class="marker-inner-win"><span class="info-content">'+
                        '<img src="../img/'+agn_folder_agencia+'/'+agn_img+'" alt="'+agn_name+'" style="margin-botton: 10px;" width="100">'+
                        '<h5 class="marker-heading" style="color:#000; padding: 0px; margin: 0px;">'+agn_name+'</h5>'+
                        '<span>'+agn_address+'</span>' +
                        '</span>'+
                        '</div></div>',
                    maxWidth: 350
                });

                attachInfoWindowToMarker(map, markers[i], info_windows[i]);
            }
            //console.log(mapData);
            map.fitBounds(bounds);

            //function to attach infowindow with marker
            function attachInfoWindowToMarker( map, marker, infoWindow ) {
                //infoWindow.open(map, marker);
                google.maps.event.addListener( marker, 'click', function() {
                    infoWindow.open( map, marker );
                    map.panTo(marker.getLatLng());
                });
                //console.log(infoWindow);
                // Event that closes the Info Window with a click on the map
                /*google.maps.event.addListener(map, 'click', function() {
                    infoWindow.close();
                });*/
                /*google.maps.event.addListener(infoWindow, 'domready', function() {
                    var iwOuter = $('.gm-style-iw');
                    var iwBackground = iwOuter.prev();
                    iwBackground.children(':nth-child(2)').css({'display' : 'none'});
                    iwBackground.children(':nth-child(4)').css({'display' : 'none'});
                    iwOuter.parent().parent().css({left: '115px'});
                    iwBackground.children(':nth-child(1)').attr('style', function(i,s){ return s + 'left: 76px;'});
                    iwBackground.children(':nth-child(3)').attr('style', function(i,s){ return s + 'left: 76px;'});
                    iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0) 0px 1px 6px', 'z-index' : '1'});
                    //console.log(iwBackground);
                    var iwCloseBtn = iwOuter.next();
                    iwCloseBtn.addClass('closeButton');
                    iwCloseBtn.css({opacity: '1', right: '67px', top: '25px'});
                    if($('.iw-content').height() < 140){
                      $('.iw-bottom-gradient').css({display: 'none'});
                    }
                    iwCloseBtn.mouseout(function(){
                      $(this).css({opacity: '1'});
                    });
                });*/
            }
        },
        loadAgentsMap : function () {
            google.maps.event.addDomListener(window, 'load', agentsMap.AgentsMap());
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
        upload          : 'Comprueba la extensión del archivo a subir'
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
                        /*case 'area':
                            if(  !is_model_name( value ) ){
                                r.message = validation_messages.general;
                            }
                            break;*/
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
            var target, isInput, isTextarea, isInputFile;
            target = $(event.target);
            isInput = target.is('input');
            isTextarea = target.is('textarea');
            isInputFile = target.is('input[type="file"]');
            //console.log(target);
            if( isInput || isTextarea || isInputFile ){
                var valid_data, val_data, required, value, validation;
                valid_data = target.data('validation-data');
                val_data   = valid_data.split('|');
                required   = val_data.indexOf('required');
                if( required >= 0 ){
                    val_data.splice(required, 1);
                }
                value = target.val();
                validation = validateMethods.validate( value, val_data, ( required >= 0 )  );
                validateMethods.error_bubble( target, !validation.valid, validation.message );
                return validation.valid;
            }else{
                var is_valid;
                is_valid = !( target.val() === null );
                validateMethods.error_bubble( target, !is_valid, validation_messages.required );
                return is_valid;
            }
        }
    }

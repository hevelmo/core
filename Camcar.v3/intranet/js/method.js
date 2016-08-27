/* ------------------------------------------------------ *\
    [Variables] var
\* ------------------------------------------------------ */
    //GLOBAL USER
    var /*GLOBALUsrUserName,*/
        GLOBALUsrFullname, 
        GLOBALUsrId, 
        GLOBALEmployeeNumber,
        GLOBALUsrType, 
        GLOBALUsrEmail, 
        GLOBALUsrAgnId, 
        GLOBALUsrAgnName,
        GLOBALUsrAgnLogo1, 
        GLOBALUsrAgnLogo2, 
        GLOBALUsrAgnHeader;

    //GLOBALUsrUserName = $(domEl.input_session_usr_username).val(),
    GLOBALUsrFullname = $(domEl.input_session_usr_fullname).val(),
    GLOBALUsrId = +$(domEl.input_session_usr_id).val(),
    GLOBALEmployeeNumber = $(domEl.input_session_usr_no_employee).val(),
    GLOBALUsrType = +$(domEl.input_session_usr_type).val(),
    GLOBALUsrEmail = $(domEl.input_session_usr_email).val(),
    GLOBALUsrAgnId = +$(domEl.input_session_usr_agn_id).val(),
    GLOBALUsrAgnName = $(domEl.input_session_usr_agn_name).val(),
    GLOBALUsrAgnLogo1 = $(domEl.input_session_usr_agn_logo1).val(),
    GLOBALUsrAgnLogo2 = $(domEl.input_session_usr_agn_logo2).val(),
    GLOBALUsrAgnHeader = $(domEl.input_session_usr_agn_header).val();

    var GLOBALMarca, GLOBALSorter, GLOBALSort, GLOBALLastUrlEpy;
    //SECTIONS
    var section, today;
    //RESPONSIVE
    var IS_MOBILE, mediaquery;
    //SCREEN SIZE
    var wapp;
    wapp = window.app = { el : {} };
    app.el['window'] = $(window);
    var screen, size, width;
    //SCROLLTOP
    var wscroll;
    //IS OPEN PAGE ASIDE IN RESPONSIVE
    var isOpen, removeOpen, addOpen;
    //BROWSER SUPPORTS HTML5 MULTIPLE FILE?
    var multipleSupport = typeof $('<input/>')[0].multiple !== 'undefined',
        isIE = /msie/i.test(navigator.userAgent);
    //SLIDE PANEL
    var classes, direction, duration, easing;
    classes = {
        base: 'slidePanel',
        baseId: 'slide-Panel',
        scrollableId: 'slide-Panel-scrollable',
        scrollableBar: 'scrollable-bar',
        show: 'slidePanel-show',
        loading: 'slidePanel-loading',
        content: 'slidePanel-content',
        contentid: 'content-slidePanel',
        dragging: 'slidePanel-dragging',
        willClose: 'slidePanel-will-close'
    };
    responsive_direction = 'resp-right';//resp-top, resp-bottom, resp-left, resp-right
    direction = 'right';//top, bottom, left, right
    duration = '500ms';
    easing = 'ease';
    //Gallery Slider
    var gallery_slider;
    //DATE
    var day, f, month;
    day = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    f = new Date();
    month = new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    //
    IS_MOBILE = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
/* ------------------------------------------------------ *\
    [functions] isMobile
\* ------------------------------------------------------ */
    var isMobile = {
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
    //http://jstricks.com/detect-mobile-devices-javascript-jquery/
    function detectmobile() {
        IS_MOBILE = false;
        if(isMobile.any()) {
            IS_MOBILE = true;
            //console.log(IS_MOBILE);
        } else {
            //console.log(IS_MOBILE);
        }
        return IS_MOBILE;
    };
/* ------------------------------------------------------ *\
    [functions] validateEmail
\* ------------------------------------------------------ */
    function validateEmail(email) {
        var re = /^(([^<>()[\]\\., ;:\s@\"] + (\.[^<>()[\]\\., ;:\s@\"] + )*)|(\". + \"))@((\[[0-9] {1, 3}\.[0-9] {1, 3}\.[0-9] {1, 3}\.[0-9] {1, 3}\])|(([a-zA-Z\-0-9] + \.) + [a-zA-Z] {2, }))$/;
        //return re.test(email);
        return true;
    }
/* ------------------------------------------------------ *\
    [functions] resetAlert
\* ------------------------------------------------------ */
    //It performs whit alertify libary an css
    function resetAlert() {
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
    [functions] resetAlert
\* ------------------------------------------------------ */
    function go_brands_agreements() {
        var target_offset = $("#go-brands-agreements").position();
        //var target_top = target_offset.top;
        $('html, body').stop().animate({
            scrollTop: '710px'
        }, 1000);
        $("#brands-agreements").focus();
    }
/* ------------------------------------------------------ *\
    [Methods] wavesInitMethod
\* ------------------------------------------------------ */
    var wavesInitMethod = {
        wavesInit: function() {
            if(typeof Waves !== 'undefined') {
                Waves.init();
                Waves.attach('.waves-init > .btn-pulse', ['waves-light']);
            }
        }
    }
/* ------------------------------------------------------ *\
    [Metodos] toHtmlMethod
\* ------------------------------------------------------ */
    var toHtmlMethod = {
        toHtml: function() {
            $('.to-html').each ( function( key, value ) {
                var html, element;
                element = $(this);
                html = CAMIN.getHTML(element);
                html = $.trim(html);
                html = CAMIN.replaceAll(html, '&lt;', '<');
                html = CAMIN.replaceAll(html, '&gt;', '>');
                CAMIN.setHTML(element, html);
            });
        }
    }
/* ------------------------------------------------------ *\
    [Methods] matchMediaMethod
\* ------------------------------------------------------ */
    var matchMediaMethod = {
        mediaquery: function() {
            mediaquery = window.matchMedia("(max-width: 768px)");
            if(mediaquery.matches) {
                //mediaquery es 768px
            } else {
                //mediaquery no es 768px
            }
        }
    }
/* ------------------------------------------------------ *\
    [Methods] hoverIconSocialMethod
\* ------------------------------------------------------ */
    var hoverIconSocialMethod = {
        hoverIconSocial: function() {
            $("a.icon-social").hover(
                function() {
                    var i = $(this).find('i');
                    if(i.hasClass("fa-facebook")) {
                        i.css('color','#4862A3');
                    } else if(i.hasClass("fa-twitter")) {
                        i.css('color','#55ACEE');
                    } else if(i.hasClass("fa-youtube")) {
                        i.css('color','#cc181e');
                    } else if(i.hasClass("fa-instagram")) {
                        i.css('color','#125688');
                    }
                }, function() {
                    //$(this).find('i').css('color','#fff');
                }
            );
            //$("a.icon-social").attr('target','_blank');
        }
    }
/* ------------------------------------------------------ *\
    [Methods] animateNavMethod
\* ------------------------------------------------------ */
    var animateNavMethod = {
        animateNav: function(event) {
            var nav, animateTime, navLink;

            nav = $('.dp-navlink-menu');
            animateTime = 500;
            navLink = $('.dp-header .dp-top .dp-navlink');

            if(nav.height() === 0) {
                autoHeightAnimate(nav, animateTime);
                //console.log(nav, animateTime);
            } else{
                nav.stop().animate({ height: '0' }, animateTime);
                //console.log(nav);
            }
            /* Function to animate height: auto */
            function autoHeightAnimate(element, time) {
                var curHeight, //Get Default Height
                    autoHeight;//Get Auto Height

                curHeight = element.height();
                autoHeight = element.css('height', 'auto').height()

                element.height(curHeight);//Reset to Default Height
                element.stop().animate({ height: autoHeight }, parseInt(time));//Animate to Auto Height
            }
        }
    }
/* ------------------------------------------------------ *\
    [Metodos] favicon
\* ------------------------------------------------------ */
    var favicon = {
        load_favicon: function() {
            favicon.change("../../img/ico/camcaricon.ico");
        },
        change: function(iconURL, optionalDocTitle) {
            if(arguments.length == 2) {
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
            for(var i=0; i<links .length; i++) {
              var link = links[i];
              if(link.type=="image/x-icon" && link.rel==relValue) {
                this.docHead.removeChild(link);
                return;//Assuming only one match at most.
              }
            }
        },
        docHead:document.getElementsByTagName("head")[0]
    }
/* ------------------------------------------------------ *\
    [Methods] equalHeightsMethods
\* ------------------------------------------------------ */
    var equalHeightsMethods = {
        equalHeightsLoad: function() {
            var altomax = 0;
            $('.equal-height').each(function() {
                if($(this).height() > altomax) {
                    altomax = $(this).height();
                }
            });
            $('.equal-height').height(altomax);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] gallerySliderMethod
\* ------------------------------------------------------ */
    var gallerySliderMethod = {
        gallerySlider: function() {
            gallery_slider = $('#gallery').bxSlider({
                pager: false,
                controls: false,
                minSlides: 5,
                maxSlides: 13,
                slideWidth: 235,
                ticker: true,
                speed: 40000
            });
        },
        reloadSlider: function() {
            gallery_slider.reloadSlider();
        }
    }
/* ------------------------------------------------------ *\
    [Methods] goSectionMethods
\* ------------------------------------------------------ */
    var goSectionMethods = {
        //HOME
        goSection_home: function(event) {
            event.preventDefault();
            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo');
            //goSectionMethods.isNavbarOpen();
            Finch.navigate('/');
        },
        //CONVENIOS
        goSection_agreement: function(event) {
            event.preventDefault();
            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo');
            //goSectionMethods.isNavbarOpen();
            Finch.navigate('/convenios');
        },
        goSection_brands_agreements: function(event) {
            Finch.navigate('/convenios');
            go_brands_agreements();
        },
        //DIRECTORIO
        goSection_directory: function(event) {
            event.preventDefault();
            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo');
            //goSectionMethods.isNavbarOpen();
            Finch.navigate('/directorio');
        },
        isNavbarOpen: function() {
            /*
            var isOpen;
            isOpen = $('body').hasClass('is-navbar-open');
            //if(isOpen == true) {
                $('html').removeClass('disable-scrolling');
                $('.navbar-header .navbar-toggle.hamburger').addClass('hided').removeClass('unfolded');
                $(domEl.recurrent_body).addClass('site-menubar-hide').removeClass('site-menubar-open');
                $('.site-menubar .site-menubar-body').addClass('scrollable scrollable-inverse is-enabled scrollable-vertical');
                $('.site-menubar .site-menubar-body div').addClass('scrollable-container').attr('style', 'height: 420px; width: 260px;');
                $('.site-menubar .site-menubar-body div div').addClass('scrollable-content').attr('style', 'width: 260px;');
                CAMIN.appendMulti('.site-menubar-body', [
                    ['div', {'id' : 'site_menubar_body', 'class':'scrollable-bar scrollable-bar-vertical scrollable-bar-hide is-disabled', 'draggable':'false'}, '', true]
                ]);
            //}
            else {
                $(domEl.recurrent_body).removeClass('site-menubar-hide').removeClass('site-menubar-changing').addClass('site-menubar-open');
            }
            */
        }
    }
/* ------------------------------------------------------ *\
    [Methods] toggleMenuBarMethod
\* ------------------------------------------------------ */
    var toggleMenuBarMethod = {
        toggleMenuBar: function(event) {
            //$('#menubar').addClass('collapsed');
            if($('#menubar #menu_bar_toggle').hasClass('unfolded')) {
                $('#navbar_brand_logo').attr('src','../../img/logos/logo-camcar-hor-white-ico@2x.png');
                $('#navbar_brand_logo').addClass('change_img');
                $('#menubar').addClass('is_collapsed');
                //console.log('hided');
            } else {
                $('#navbar_brand_logo').attr('src','../../img/logos/logo-camcar-hor-white@2x.png');
                $('#navbar_brand_logo').removeClass('change_img');
                $('#menubar').removeClass('is_collapsed');
            }
        }
    }
/* ------------------------------------------------------ *\
    [Methods] addStylesMethod
\* ------------------------------------------------------ */
    var addStylesMethod = {
        addStylesHome: function() {
            stylesHomeAttributes = [
                ['link', {'id' : 'content-add-style-welcome-plugins', 'rel': 'stylesheet', 'class':'style-link-welcome', 'href': '../../css/styles/assets/plugins/chartist-js/chartist.css'}, '', 0],
                ['link', {'id' : 'content-add-style-welcome-plugins', 'rel': 'stylesheet', 'class':'style-link-welcome', 'href': '../../css/styles/assets/plugins/aspieprogress/asPieProgress.css'}, '', 0],
                ['link', {'id' : 'content-add-style-welcome-dashboard', 'rel': 'stylesheet', 'class':'style-link-welcome', 'href': '../../css/styles/assets/dashboard/v2.css'}, '', 0]
            ];
            CAMIN.appendMulti(domEl.recurrent_head, stylesHomeAttributes);
            pluginsHomeAttributes = [
                ['script', {'id' : 'content-add-plugin-welcome-plugins', 'class':'plugin-link-welcome', 'src': '../../lib/assets/plugins/chartist-js/chartist.min.js'}, '', 0],
                ['script', {'id' : 'content-add-plugin-welcome-plugins', 'class':'plugin-link-welcome', 'src': '../../lib/assets/plugins/matchheight/jquery.matchHeight-min.js'}, '', 0]
            ];
            CAMIN.appendMulti('div#plugins-for-this-section', pluginsHomeAttributes);
            scriptsHomeAttributes = [
                ['script', {'id' : 'content-add-plugin-welcome-scripts', 'class':'script-link-welcome', 'src': '../../lib/assets/plugins/chartist-js/chartist.min.js'}, '', 0],
                ['script', {'id' : 'content-add-plugin-welcome-scripts', 'class':'script-link-welcome', 'src': '../../lib/assets/run/components/matchheight.js'}, '', 0]
            ];
            CAMIN.appendMulti('div#scripts-for-this-section', scriptsHomeAttributes);

            $(domEl.recurrent_body).addClass('dashboard');
            $(domEl.recurrent_body).removeClass('app-contacts');
        },
        addStylesAgreement: function() {
            stylesAgreementAttributes = [
                ['link', {'id' : 'content-add-style-welcome-agreement-pages', 'rel': 'stylesheet', 'class':'style-link-welcome-agreement', 'href': '../../css/styles/assets/pages/advanced/masonry.css'}, '', 0],
            ];
            CAMIN.appendMulti(domEl.recurrent_head, stylesAgreementAttributes);
            pluginsAgreementAttributes = [
                ['script', {'id' : 'content-add-plugin-welcome-agreement-plugins', 'class':'plugin-link-welcome-agreement', 'src': '../../lib/assets/plugins/masonry/masonry.pkgd.min.js'}, '', 1]
            ];
            CAMIN.appendMulti('div#plugins-for-this-section', pluginsAgreementAttributes);
            scriptsAgreementAttributes = [
                ['script', {'id' : 'content-add-plugin-welcome-agreement-scripts', 'class':'script-link-welcome-agreement', 'src': '../../lib/assets/run/components/masonry.js'}, '', 1]
            ];
            CAMIN.appendMulti('div#scripts-for-this-section', scriptsAgreementAttributes);
        },
        addStylesDirectory: function() {
            stylesDirectoryAttributes = [
                ['link', {'id' : 'content-add-style-welcome-directory-pages', 'rel': 'stylesheet', 'class':'style-link-welcome-directory', 'href': '../../css/styles/assets/plugins/filament-tablesaw/tablesaw.css'}, '', 0],
                ['link', {'id' : 'content-add-style-welcome-directory-pages', 'rel': 'stylesheet', 'class':'style-link-welcome-directory', 'href': '../../css/styles/assets/plugins/slidepanel/slidePanel.css'}, '', 0],
                ['link', {'id' : 'content-add-style-welcome-directory-pages', 'rel': 'stylesheet', 'class':'style-link-welcome-directory', 'href': '../../css/styles/assets/pages/apps/contacts.css'}, '', 0]
            ];
            CAMIN.appendMulti(domEl.recurrent_head, stylesDirectoryAttributes);
            pluginsDirectoryAttributes = [
                ['script', {'id' : 'content-add-plugin-welcome-directory-plugins', 'class':'plugin-link-welcome-directory', 'src': '../../lib/assets/plugins/filament-tablesaw/tablesaw.js'}, '', 1],
                //['script', {'id' : 'content-add-plugin-welcome-directory-plugins', 'class':'plugin-link-welcome-directory', 'src': '../../lib/assets/plugins/slidepanel/jquery-slidePanel.js'}, '', 1],
                ['script', {'id' : 'content-add-plugin-welcome-directory-plugins', 'class':'plugin-link-welcome-directory', 'src': '../../lib/assets/plugins/aspaginator/jquery.asPaginator.js'}, '', 1],
                ['script', {'id' : 'content-add-plugin-welcome-directory-plugins', 'class':'plugin-link-welcome-directory', 'src': '../../lib/assets/plugins/jquery-placeholder/jquery.placeholder.js'}, '', 1]
            ];
            CAMIN.appendMulti('div#plugins-for-this-section', pluginsDirectoryAttributes);
            scriptsDirectoryAttributes = [
                ['script', {'id' : 'content-add-plugin-welcome-directory-scripts', 'class':'script-link-welcome-directory', 'src': '../../lib/assets/run/plugins/sticky-header.js'}, '', 1],
                ['script', {'id' : 'content-add-plugin-welcome-directory-scripts', 'class':'script-link-welcome-directory', 'src': '../../lib/assets/run/plugins/action-btn.js'}, '', 1],
                ['script', {'id' : 'content-add-plugin-welcome-directory-scripts', 'class':'script-link-welcome-directory', 'src': '../../lib/assets/run/components/aspaginator.js'}, '', 1],
                ['script', {'id' : 'content-add-plugin-welcome-directory-scripts', 'class':'script-link-welcome-directory', 'src': '../../lib/assets/run/app.js'}, '', 1],
                ['script', {'id' : 'content-add-plugin-welcome-directory-scripts', 'class':'script-link-welcome-directory', 'src': '../../lib/assets/run/components/animate-list.js'}, '', 1],
                ['script', {'id' : 'content-add-plugin-welcome-directory-scripts', 'class':'script-link-welcome-directory', 'src': '../../lib/assets/run/components/jquery-placeholder.js'}, '', 1],
                ['script', {'id' : 'content-add-plugin-welcome-directory-scripts', 'class':'script-link-welcome-directory', 'src': '../../lib/assets/run/components/material.js'}, '', 1],
                ['script', {'id' : 'content-add-plugin-welcome-directory-scripts', 'class':'script-link-welcome-directory', 'src': '../../lib/assets/run/components/selectable.js'}, '', 1],
                ['script', {'id' : 'content-add-plugin-welcome-directory-scripts', 'class':'script-link-welcome-directory', 'src': '../../lib/assets/current/apps/contacts.js'}, '', 1]
            ];
            CAMIN.appendMulti('div#scripts-for-this-section', scriptsDirectoryAttributes);
        }
    }
/* ------------------------------------------------------ *\
    [Methods] cleanStylesMethod
\* ------------------------------------------------------ */
    var cleanStylesMethod = {
        cleanStyles: function () {
            cleanStylesMethod.cleanStylesWelcome();
            cleanStylesMethod.cleanStylesAgreement();
            cleanStylesMethod.cleanStylesDirectory();
        },
        cleanStylesWelcome: function () {
            $('head .style-link-welcome').remove();
            $('.plugin-link-welcome').remove();
            $('.script-link-welcome').remove();
        },
        cleanStylesAgreement: function () {
            $('head .style-link-welcome-agreement').remove();
            $('.plugin-link-welcome-agreement').remove();
            $('.script-link-welcome-agreement').remove();
        },
        cleanStylesDirectory: function () {
            $('head .style-link-welcome-directory').remove();
            $('.plugin-link-welcome-directory').remove();
            $('.script-link-welcome-directory').remove();
        }
    }
/* ------------------------------------------------------ *\
    [Metodos] removeRecurrentsMethods
\* ------------------------------------------------------ */
    var removeRecurrentsMethods = {
        removeRecurrents: function() {
            removeRecurrentsMethods.removeRecurrents_home();
            removeRecurrentsMethods.removeRecurrents_agreement();
            removeRecurrentsMethods.removeRecurrents_directory();
        },
        removeRecurrents_home: function() {
            $(domEl._home_page_header_name).remove();
            $(domEl._home_page_content_name).remove();
            $(domEl.div_recurrent).removeClass('animsition');
        },
        removeRecurrents_agreement: function() {
            $(domEl._agreement_page_content_name).remove();
            //CAMIN.setHTML(domEl._content_slide_panel, '');
        },
        removeRecurrents_directory: function() {
            $(domEl._directory_page_aside_name).remove();
            $(domEl._directory_page_main_name).remove();
            CAMIN.setHTML(domEl.div_recurrent_site_action, '');
            CAMIN.setHTML(domEl._content_slide_panel, '');
        }
    }
/* ------------------------------------------------------ *\
    [Metodos] loadSiteNavigationMethods
\* ------------------------------------------------------ */
    var loadSiteNavigationMethods = {
        loadSiteNavigation: function() {
            var data, adminAcces, fullname, epyData;
            fullname = CAMIN.ucWords(GLOBALUsrFullname);
            epyData = {'webservice': [{'fullname' : fullname}]};
            CAMIN.loadTemplate(tempsNames.recurrent_site_navbar, domEl.site_navbar, epyData);
            CAMIN.loadTemplate(tempsNames.recurrent_site_menubar, domEl.site_menubar);
            $(domEl._dd_menu_description).data('hint', fullname);
            data = CAMIN.getInternalJSON(urlsApi.ssn_get_admin_access);
            adminAcces = +data.caminpa.usr_adm_access;
            if(!adminAcces) {
                $('#site-section-preowned').remove();
            }
        }
    }
/* ------------------------------------------------------ *\
    [Metodos] removeSiteNavigationMethods
\* ------------------------------------------------------ */
    var removeSiteNavigationMethods = {
        removeSiteNavigation: function() {
            /*
            $(domEl.site_navbar).remove();
            $(domEl.site_menubar).remove();
            CAMIN.setHTML(domEl.site_navbar, '');
            CAMIN.setHTML(domEl.site_menubar, '');
            */
        }
    }
/* ------------------------------------------------------ *\
    [Methods] bannerMethods
\* ------------------------------------------------------ */
    var bannerMethods = {
        bannerLoad: function() {
            var agn_header, agn_name, url, pic_agencie_style, pic_headers;
            var banner, newImg, currentSRC, newSRC, elemnts, folder;
            //console.log('entra');
            //get_name_agencie_active
            //get-user-type-active

            //usr_agn_id = CAMIN.getValue(domEl.adm_input_session_usr_agn_id);
            //agn_name = CAMIN.getValue(domEl.input_session_usr_agn_name);
            agn_header = CAMIN.getValue(domEl.input_session_usr_agn_header);

            //bannerData = CAMIN.getInternalJSON(urlsApi.adm_get_agn_header_id + usr_agn_id);

            if(agn_header === '') {
                bannerData = CAMIN.getInternalJSON(urlsApi.adm_get_agn_header);
                pic_headers = CAMIN.filterArrayObjByKey(bannerData.caminpa, 'agn_header', '', 0);
                //console.log(pic_headers);

                currentSRC = $(domEl.adm_img_banner).attr('style');

                currentSRC = currentSRC;
                currentImg = '';
                //console.log(currentSRC);
                if(currentSRC !== '') {
                    //elements = currentSRC.split('/');
                    elements = currentSRC;
                    currentImg = elements
                }
                banner = bannerData.caminpa[0].agn_header;
                newImg = banner;

                do {
                    newImg = pic_headers[Math.floor(Math.random() * pic_headers.length)];
                } while(newImg === currentImg && agn_new_name === currentImg);
            } else {
                newImg = agn_header;
            }

            /*
            folder = '../../img/agencias/header/seminuevos';
            */
            folder = '../../resources/public/img/agencies/headers/seminuevos';
            newSRC =  folder + '/' + newImg;
            //newSRC =  newImg;
            $(domEl._home_page_header_name).attr('style', "background-image: url("+newSRC+"); top: 0px; margin-left: 0px; margin-right: 0px;");
        }
    }
/* ------------------------------------------------------ *\
    [Metodos] viewSectionWelcomeHomeMethods
\* ------------------------------------------------------ */
    var viewSectionWelcomeHomeMethods = {
        viewWelcomeHome: function() {
            viewSectionWelcomeHomeMethods.recurrent_welcome_home();
            viewSectionWelcomeHomeMethods.loadTemplatesWelcomeHome();
            //equalHeightsMethods.equalHeightsLoad();
            //bannerMethods.bannerLoad();
            domElementsFormatMethods.ucWords(domEl._ucwords);
        },
        recurrent_welcome_home: function() {
            CAMIN.appendMulti(domEl.div_recurrent, [
                ['div', {'id' : domEl._home_page_header, 'class':'page-header height-170 margin-bottom-30 current-separator', 'style':'padding: 0;'}, '', true],
                ['div', {'id' : domEl._home_page_content, 'class':'page-content container-fluid'}, '', true]
            ]);
            CAMIN.appendMulti(domEl._home_page_content_name, [
                ['div', {'id' : domEl._home_widget_first_row, 'class':'row', 'data-plugin': 'matchHeight', 'data-by-row': 'true'}, '', true]
            ]);
            CAMIN.appendMulti(domEl._home_widget_first_row_name, [
                ['div', {'id' : domEl._home_panel_perfil_name, 'class':'col-xlg-4 col-lg-4 col-md-12'}, '', true],
                ['div', {'id' : domEl._home_today_birthday_name, 'class':'col-lg-4 col-md-6 equal-height'}, '', true],
                ['div', {'id' : domEl._home_today_agreements_name, 'class':'col-lg-4 col-md-6 equal-height'}, '', true]
                //['div', {'id' : domEl._home_today_aniversary_name, 'class':'col-lg-4 col-md-6 equal-height'}, '', true]
            ]);
            $(domEl.recurrent_body).addClass('dashboard');
        },
        loadTemplatesWelcomeHome: function() {
            CAMIN.loadTemplate(tempsNames.recurrent_welcome_page_header, domEl._home_page_header_name);
            //viewSectionWelcomeHomeMethods.globalUserPromise();
            viewSectionWelcomeHomeMethods.loadTemplatesWindow_panelPerfil();
            viewSectionWelcomeHomeMethods.loadTemplatesWindow_todayBirthday();
            viewSectionWelcomeHomeMethods.loadTemplatesWindow_agreements();
            //viewSectionWelcomeHomeMethods.loadTemplatesWindow_todayAniversary();
        },
        globalUserPromise: function() {
            if(+GLOBALUsrId === 1 || +GLOBALUsrId === 2 || +GLOBALUsrId === 3) {
                promise = CAMIN.postalService(urlsApi.wse_set_epy, {});
                    promise.success(function (data) {
                });
            }
        },
        loadTemplatesWindow_panelPerfil: function() {
            var empNumber, epyData;
            empNumber = GLOBALEmployeeNumber;
            epyData = CAMIN.getInternalJSON(urlsApi.wse_get_epy_nep + empNumber);
            CAMIN.loadTemplate(tempsNames.home_window_perfil, domEl._home_panel_perfil, epyData);
        },
        loadTemplatesWindow_todayBirthday: function() {
            //Get today date in format yyyy-mm-dd
            today = (moment().format()).substring(0, 10);
            //Get today's birthdays
            dataBirthday = CAMIN.getInternalJSON(urlsApi.wse_get_epy_cum + today);
            CAMIN.loadTemplate(tempsNames.home_window_birthday, domEl._home_today_birthday, dataBirthday);
            //
            CAMIN.setHTML('#todat-birthday', today);
            $('#todat-birthday').attr('datetime', today);
            //
            domElementsFormatMethods.htmlDateRoman(domEl._date_roman_h);
        },
        loadTemplatesWindow_todayAniversary: function() {
            //Get today date in format yyyy-mm-dd
            today = (moment().format()).substring(0, 10);
            //Get today's aniversaries
            dataAniversary = CAMIN.getInternalJSON(urlsApi.wse_get_epy_fin + today);
            CAMIN.loadTemplate(tempsNames.home_window_aniversary, domEl._home_today_aniversary, dataAniversary);
        },
        loadTemplatesWindow_agreements: function() {
            var conData;
            conData = CAMIN.getInternalJSON(urlsApi.get_con);
            CAMIN.loadTemplate(tempsNames.home_window_agreements, domEl._home_today_agreements, conData);
        }
    }
/* ------------------------------------------------------ *\
    [Metodos] viewSectionWelcomeAgreementMethods
\* ------------------------------------------------------ */
    var viewSectionWelcomeAgreementMethods = {
        viewSectionWelcomeAgreement: function() {
            viewSectionWelcomeAgreementMethods.recurrent_welcome_agreement();
            viewSectionWelcomeAgreementMethods.loadTemplatesAgreement();
        },
        recurrent_welcome_agreement: function() {
            CAMIN.appendMulti(domEl.div_recurrent, [
                ['div', {'id' : domEl._agreement_page_content, 'class':'page-content padding-30 container-fluid convenios-grupo-camcar'}, '', true]
            ]);
            /*
            agreementPageContentAttributes = [
                ['div', {'id' : domEl._agreement_page_content, 'class':'page-content padding-30 blue-grey-500'}, '', 1]
            ];
            CAMIN.appendMulti(domEl.div_recurrent, agreementPageContentAttributes);
            */
            $(domEl.recurrent_body).removeClass('dashboard');
            $(domEl.div_recurrent).addClass('animsition');
            $(domEl.div_recurrent).attr('style','animation-duration: 0.8s; opacity: 1;');
            //$(domEl.recurrent_body).addClass('app-contacts site-menubar-unfold');
        },
        loadTemplatesAgreement: function() {
            var conData;

            CAMIN.loadTemplate(tempsNames.start_agreement_panel_heading, domEl._agreement_page_content_name);

            conData = CAMIN.getInternalJSON(urlsApi.get_con);
            CAMIN.loadTemplate(tempsNames.recurrent_agreement_masonry_items, domEl._agreement_other_brands, conData);
        }
    }
/* ------------------------------------------------------ *\
    [Metodos] viewSectionWelcomeDirectoryMethods
\* ------------------------------------------------------ */
    var viewSectionWelcomeDirectoryMethods = {
        viewSectionWelcomeDirectory: function() {
            viewSectionWelcomeDirectoryMethods.recurrentWelcomeDirectory();
            viewSectionWelcomeDirectoryMethods.loadTemplatesDirectory();

            domElementsFormatMethods.ucWords(domEl._ucwords);
        },
        recurrentWelcomeDirectory: function() {
            directoryPageContentAttributes = [
                ['div', {'id' : domEl._directory_page_aside, 'class':'page-aside'}, '', 1],
                ['div', {'id' : domEl._directory_page_main, 'class':'page-main', 'style':'height: 1000px;'}, '', 1]
            ];
            CAMIN.appendMulti(domEl.div_recurrent, directoryPageContentAttributes);
            $(domEl.recurrent_body).removeClass('dashboard');
            $(domEl.div_recurrent).addClass('animsition');
            $(domEl.div_recurrent).attr('style','animation-duration: 0.8s; opacity: 1; height: 1000px;');
        },
        pageAside_isScroll: function(event) {
            width = app.el['window'].width();
            if( width < 320 ) {
                size = 'Not supported';
                viewSectionWelcomeDirectoryMethods.pageAside_removeClassfixed_mpDesktop();
            } else if( width < 480 ) {
                size = "Mobile portrait";
                viewSectionWelcomeDirectoryMethods.pageAside_removeClassfixed_mpDesktop();
            } else if( width < 767 ) {
                size = "Mobile landscape";
                viewSectionWelcomeDirectoryMethods.pageAside_removeClassfixed_mpDesktop();
            } else if( width < 768 ) {
                size = "Mobile landscape";
                viewSectionWelcomeDirectoryMethods.pageAside_removeClassfixed_mpDesktop();
            } else if( width < 960 ) {
                size = "Tablet";
                viewSectionWelcomeDirectoryMethods.pageAside_removeClassfixed_mpDesktop();
            } else if( width < 1280 ) {
                size = "WXGA - Netbook";
                viewSectionWelcomeDirectoryMethods.pageAside_removeClassfixed_mpDesktop();
            } else if( width < 1366 ) {
                size = "WXGA - Ultrabook";
                viewSectionWelcomeDirectoryMethods.pageAside_removeClassfixed_mpDesktop();
            } else  {
                size = 'Desktop';
                viewSectionWelcomeDirectoryMethods.pageAside_addClassfixed_desktop();
            }
            //screen = $('#screen').html( size + ' - ' + width );
            //console.log(screen);
            //console.log(wapp);
            //console.log( size, width );
        },
        pageAside_addClassfixed_desktop: function() {
            wscroll = app.el['window'].scrollTop();
            if( wscroll > 90 ) {
                $(domEl._directory_page_aside_name).addClass('page-aside-fixed');
                //console.log('add is ' + size + ',' + width );
            } else {
                $(domEl._directory_page_aside_name).removeClass('page-aside-fixed');
                //console.log('remove is ' + size + ',' + width );
            }
        },
        pageAside_removeClassfixed_mpDesktop: function() {
            wscroll = app.el['window'].scrollTop();
            if( wscroll > 90 ) {
                $(domEl._directory_page_aside_name).removeClass('page-aside-fixed');
                //console.log('remove is ' + size + ',' + width );
            } else {
                $(domEl._directory_page_aside_name).removeClass('page-aside-fixed');
                //console.log('remove is ' + size + ',' + width );
            }
        },
        loadTemplatesDirectorySlidebar: function() {
            /*
            var agnData;
            agnData = CAMIN.getInternalJSON(urlsApi.wse_get_agn);
            CAMIN.loadTemplate(tempsNames.recurrent_directory_contacts_sidebar, domEl._directory_page_aside_name, agnData);
            */
            var marData;
            marData = CAMIN.getInternalJSON(urlsApi.wse_get_mar);
            CAMIN.loadTemplate(tempsNames.recurrent_directory_contacts_sidebar, domEl._directory_page_aside_name, marData);
        },
        loadTemplatesDirectoryContacts: function() {
            CAMIN.loadTemplate(tempsNames.recurrent_directory_contacts_content_header, domEl._directory_page_main_name);
            $(domEl.btn_directory_search).attr('disabled', true);
        },
        loadTemplatesDirectoryAction: function() {
            CAMIN.loadTemplate(tempsNames.recurrent_directory_contacts_site_action, domEl.div_recurrent_site_action);
        },
        loadTemplatesDirectory: function() {
            //
            viewSectionWelcomeDirectoryMethods.loadTemplatesDirectoryContacts();
            //
            viewSectionWelcomeDirectoryMethods.loadTemplatesDirectorySlidebar();
            //
            viewSectionWelcomeDirectoryMethods.loadTemplatesDirectoryAction();
            //
            viewSectionWelcomeDirectoryMethods.sortingFilters();
        },
        refreshFilters: function() {
        },
        sortingFilters: function() {
            var epyData, epyNumber, url, marca,
                sorter, sort, mystery, mysteryElements, epyLength;

            sorter = GLOBALSorter;
            sort = GLOBALSort;
            marca = ($.trim(GLOBALMarca) !== '') ? $.trim(GLOBALMarca) : '0';

            mystery = CAMIN.getValue(domEl.input_directory_search);
            mystery = CAMIN.advancedTrim(mystery);
            mystery = CAMIN.replaceAll(mystery, '/', '**47**');

            url = urlsApi.wse_get_epy_filters + marca + '/' +sorter + '/' + sort;
            url += (mystery !== '') ? '/' + mystery : '';

            if(url !== GLOBALLastUrlEpy) {
                //
                epyData = CAMIN.getInternalJSON(url);
                CAMIN.loadTemplate(tempsNames.recurrent_directory_contacts_content_list, domEl._directory_employees_list, epyData);
                //
                epyNumber = (CAMIN.hasOwnPropertyOptimized(epyData, 'webservice')) ? epyData['webservice'].length : 0;
                CAMIN.setHTML(domEl._directory_employees_number, epyNumber);
                //
                (marca !== '' && marca != 0)
                    ? CAMIN.setHTML(domEl.span_dir_marck, '<em>/</em> ' + marca)
                    : CAMIN.setHTML(domEl.span_dir_marck, '');
                //
                GLOBALLastUrlEpy = url;
            }
        },
        fillingControl: function() {
            var validFieldName, dataGetEpyFilters, isFull;
            validFieldName = ['directory_search'];
            dataGetEpyFilters = $(domEl.form_directory_filters).serializeFormJSON();
            isFull = CAMIN.validFormFull(dataGetEpyFilters, validFieldName);
            $(domEl.btn_directory_search).attr('disabled', !isFull);
        },
        keyupSearch: function(event) {
            viewSectionWelcomeDirectoryMethods.fillingControl();
            //viewSectionWelcomeDirectoryMethods.sortingFilters();
        },
        keypressSearch: function(event) {
            var key, validate, mystery;
            key = event.keyCode ? event.keyCode : event.which;
            validate = true;
            if(key === 13) {
                event.preventDefault();
                validate = false;
                mystery = CAMIN.getValue($(this));
                mystery = CAMIN.advancedTrim(mystery);
                CAMIN.setValue($(this), mystery);
                viewSectionWelcomeDirectoryMethods.sortingFilters();
                if(mystery === '') {
                    $(domEl.btn_directory_search).attr('disabled', true);
                }
            }
            return validate;
        },
        blurSearch: function(event) {
            var mystery;
            mystery = CAMIN.getValue($(this));
            mystery = CAMIN.advancedTrim(mystery);
            CAMIN.setValue($(this), mystery);
            if(mystery === '') {
                viewSectionWelcomeDirectoryMethods.sortingFilters();
            }
        },
        clickSearch: function(event) {
            var mystery;
            mystery = CAMIN.getValue($(domEl.input_directory_search));
            mystery = CAMIN.advancedTrim(mystery);
            CAMIN.setValue($(domEl.input_directory_search), mystery);
            if(mystery !== '') {
                viewSectionWelcomeDirectoryMethods.sortingFilters();
            }
        },
        clickSorter: function (event) {
            var element, sorter, sort, newSort, newCur;
            //Get element reference
            element = $(this);
            //Get sort and sorter from data of current element
            sorter = element.data('sorter');
            sort = element.data('sort');
            //Change all sorter to ASC sort
            $(domEl._epy_sorter).data('sort', 'ASC');
            //Switch the current element sort
            newSort = (sort === 'ASC') ? 'DESC' : 'ASC';
            element.data('sort', newSort);
            //Change all cursors to cur-down
            $(domEl._epy_sorter).removeClass('cur-up');
            $(domEl._epy_sorter).removeClass('cur-down');
            $(domEl._epy_sorter).addClass('cur-down');
            //Switch the current cursor
            newCur = (newSort === 'DESC') ? 'cur-up' : 'cur-down';
            element.removeClass('cur-up');
            element.removeClass('cur-down');
            element.addClass(newCur);
            //Change Active
            $(domEl._epy_sorter).removeClass('active');
            element.addClass('active');
            //Asign values to global sort and sorter
            GLOBALSorter = sorter;
            GLOBALSort = sort;
            //Sort template
            viewSectionWelcomeDirectoryMethods.sortingFilters();
        },
        clickMarca: function (event) {
            var element, marca;
            //Get current element
            element = $(this);
            //Change Active Marca
            $(domEl.div_mar_directory).removeClass('active');
            element.addClass('active');
            //Get Marca
            marca = element.data('marca');
            GLOBALMarca = marca;
            //Refresh Directory
            viewSectionWelcomeDirectoryMethods.sortingFilters();
            viewSectionWelcomeDirectoryMethods.isOpenScreenSize();
            $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo');
        },
        isOpenScreenSize: function() {
            width = app.el['window'].width();
            if( width < 320 ) {
                size = 'Not supported';
                viewSectionWelcomeDirectoryMethods.has_isOpen();
            } else if( width < 480 ) {
                size = "Mobile portrait";
                viewSectionWelcomeDirectoryMethods.has_isOpen();
            } else if( width < 767 ) {
                size = "Mobile landscape";
                viewSectionWelcomeDirectoryMethods.has_isOpen();
            } else if( width < 768 ) {
                size = "Mobile landscape";
                //viewSectionWelcomeDirectoryMethods.has_isOpen();
            } else if( width < 960 ) {
                size = "Tablet";
                //viewSectionWelcomeDirectoryMethods.has_isOpen();
            } else  {
                size = 'Desktop';
            }
            //screen = $('#screen').html( size + ' - ' + width );
            //console.log(screen);
            //console.log(wapp); 
            //console.log( size, width );   
        },
        has_isOpen: function() {
            isOpen = $('.page-aside').hasClass('open');
            if(isOpen) {
              $('.page-aside').removeClass('open');
            } else {
              $('.page-aside').addClass('open');
            }
        },
        pagination: function() {

        }
    }
/* ------------------------------------------------------ *\
    [Methods] createModalOverlayMethod
\* ------------------------------------------------------ */
    var createModalOverlayMethod = {
        createModalOverlay: function() {
            modalOverlayAttributes = [
                ['div', {'id' : 'content-temporal-modal-overlay', 'class':'wrapper_content_interactive_modal_overlay'}, '', 1],
            ];
            CAMIN.appendMulti('body', modalOverlayAttributes);
        },
        loadTemplateModalOverlay: function() {
            CAMIN.loadTemplate(tempsNames.recurrent_modal_overlay, domEl.div_recurrent_modal_overlay);
        },
        loadTemplateBoxBirthday: function() {
            CAMIN.loadTemplate(tempsNames.mov_home_box_birthday, domEl.div_recurrent_section_box);
        },
        loadTemplateBoxDirectory: function() {
            CAMIN.loadTemplate(tempsNames.mov_directory_box_message_user, domEl.div_recurrent_section_box);
        },
        viewModalOverlay: function() {
            createModalOverlayMethod.createModalOverlay();
            createModalOverlayMethod.loadTemplateModalOverlay();
        }
    }
/* ------------------------------------------------------ *\
    [Methods] callModalOverlayMethod
\* ------------------------------------------------------ */
    var callModalOverlayMethod = {
        callModalOverlayBirthday: function(event) {
            createModalOverlayMethod.viewModalOverlay();
            createModalOverlayMethod.loadTemplateBoxBirthday();

            cum_send_form_message_method.refreshForm();

            userName = CAMIN.getValue(domEl.input_session_usr_fullname);
            userTo = $(this).data('name-to');
            userMail = CAMIN.getValue(domEl.input_session_usr_email);
            userMailTo = $(this).data('email-to');
            dateSend = day[f.getDay()] + ", " + f.getDate() + " de " + month[f.getMonth()] + " de " + f.getFullYear();

            ucw_userName = CAMIN.ucWords(userName);
            ucw_userTo = CAMIN.ucWords(userTo);

            CAMIN.setValue(domEl.field_cum_send_from, ucw_userName);
            CAMIN.setValue(domEl.field_cum_send_to, ucw_userTo);
            CAMIN.setValue(domEl.field_cum_send_email, userMail);
            CAMIN.setValue(domEl.field_cum_send_email_to, userMailTo);
            CAMIN.setValue(domEl.field_cum_send_date, dateSend);

            //console.log('De: ' + ucw_userName + ' <' + userMail + '> Para: ' + ucw_userTo + ' <' + userMailTo + '> Fecha: ' + dateSend);

            $('#box div').addClass('animation-slideDown');
            if(typeof Waves !== 'undefined') {
                Waves.init();
                Waves.attach('.btn-pulse', ['waves-light']);
            }
        },
        callModalOverlayDirectory: function(event) {
            createModalOverlayMethod.viewModalOverlay();
            createModalOverlayMethod.loadTemplateBoxDirectory();

            dir_send_form_message_method.refreshForm();
            userName = CAMIN.getValue(domEl.input_session_usr_fullname);
            userTo = $(this).data('name-to');
            userMail = CAMIN.getValue(domEl.input_session_usr_email);
            userMailTo = $(this).data('email-to');

            dateSend = day[f.getDay()] + ", " + f.getDate() + " de " + month[f.getMonth()] + " de " + f.getFullYear();
            ucw_userName = CAMIN.ucWords(userName);
            ucw_userTo = CAMIN.ucWords(userTo);

            CAMIN.setValue(domEl.field_dir_send_from, ucw_userName);
            CAMIN.setValue(domEl.field_dir_send_to, ucw_userTo);
            CAMIN.setValue(domEl.field_dir_send_email, userMail);
            CAMIN.setValue(domEl.field_dir_send_email_to, userMailTo);
            CAMIN.setValue(domEl.field_dir_send_date, dateSend);

            //console.log('De: ' + ucw_userName + ' <' + userMail + '> Para: ' + ucw_userTo + ' <' + userMailTo + '> Fecha: ' + dateSend);

            $('#box div').addClass('animation-slideDown');
            if(typeof Waves !== 'undefined') {
                Waves.init();
                Waves.attach('.btn-pulse', ['waves-light']);
            }
        },
        closeModalOverlay: function() {
            function closeModal(animation) {
                $('#box .box-modal-close').removeClass('animation-slideDown').addClass(animation + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                     //$(this).removeClass();
                     $('#box-modal-overlay').fadeOut();
                });
            }
            setTimeout(function() {
                var animation = ('fadeOutUp');
                closeModal(animation);
                setTimeout(function() {
                    $(domEl.div_recurrent_modal_overlay).remove();
                }, 800);
            }, 800);
            //console.log('close');
        }
    }
/* ------------------------------------------------------ *\
    [Methods] cum_send_form_message
\* ------------------------------------------------------ */
    var cum_send_form_message_method = {
        dataCumFormMessage: function() {
            var dataCumFormMessage;
            dataCumFormMessage = $(domEl.cum_form_send_message).serializeFormJSON();
            //console.log(dataCumFormMessage);
            return CAMIN.postalService(urlsApi.int_wel_send_congratulations, dataCumFormMessage);
        },
        fillingControl: function() {
            var validFieldsItems, dataCumFormMessage, isFull, isEmpty;
            validFieldsItems = ['cum-send-message'];
            dataCumFormMessage = $(domEl.cum_form_send_message).serializeFormJSON();
            //console.log(dataCumFormMessage);

            isFull = CAMIN.validFormFull(dataCumFormMessage, validFieldsItems);
            if(!isFull) {
                $(domEl.cum_send_message_area).attr('disabled', true);
                $(domEl.cum_send_message_area).addClass('no-drop avoid-clicks');
            } else {
                $(domEl.cum_send_message_area).removeAttr('disabled');
                $(domEl.cum_send_message_area).removeClass('no-drop avoid-clicks');
            }

            /*isEmpty = CAMIN.validFormFull(dataCumFormMessage, validFieldsItems);
            $(domEl.cum_send_message_area).attr('disabled', !isFull);
            */
        },
        refreshForm: function() {
            CAMIN.loadTemplate(tempsNames.recurrent_cum_form_send_message, domEl.div_recurrent_form_congratulations);
            $(domEl.cum_send_message_area).attr('disabled', true);
            $(domEl.cum_send_message_area).addClass('no-drop avoid-clicks');
        },
        resetForm: function() {
            CAMIN.resetForm(domEl.cum_form_send_message);
            $(domEl.cum_send_message_area).attr('disabled', true);
            $(domEl.cum_send_message_area).addClass('no-drop avoid-clicks');
        },
        resetLoader: function() {
            $('.form-loader').css('display', 'none');
        },
        validateFieldsKeyup: function() {
            cum_send_form_message_method.fillingControl();
        },
        cum_send_form_message: function() {
            cum_send_form_message_method.fillingControl();

            var $cum_message, $cum_from, $cum_email, $cum_to, $cum_email_to, $cum_date, form_errors;

            $cum_message = $(domEl.field_cum_send_message);
            $cum_from = $(domEl.field_cum_send_from);
            $cum_email = $(domEl.field_cum_send_email);
            $cum_to = $(domEl.field_cum_send_to);
            $cum_email_to = $(domEl.field_cum_send_email_to);
            $cum_date = $(domEl.field_cum_send_date);

            //console.log($cum_message, $cum_from, $cum_email, $cum_to, $cum_email_to, $cum_date);

            form_errors = 0;
            if(validateMethods.validate_input($cum_message)) {
                form_errors++;
                $cum_message.focusout();
            }
            if(form_errors != 0) {
                var data, cum_send_message_promise;
                data = {
                    message : $cum_message.val(),
                    from : $cum_from.val(),
                    email : $cum_email.val(),
                    to : $cum_to.val(),
                    email_to : $cum_email_to.val(),
                    date : $cum_date.val(),
                    source : 'Envio de mensaje de felicitaciones'
                };
                //console.log(data);

                cum_send_message_promise = cum_send_form_message_method.dataCumFormMessage();
                cum_send_message_promise.success( function (data) {
                    setTimeout(function() {
                        //console.log('Espera');
                        setTimeout(function () {
                            $('#form-wrapper').fadeOut( 300 , function() {
                                setTimeout(function () {
                                    $('.form-loader').fadeIn();
                                }, 300);
                            });
                            setTimeout(function () {
                                //console.log("Correo Enviado...");
                                setTimeout(function () {
                                    $('#form-wrapper').fadeOut( 300 , function() {
                                        setTimeout(function () {
                                            $('.form-thanks').fadeIn();
                                        }, 1800);
                                    });
                                    setTimeout(function () {
                                        $('.form-loader').fadeOut();
                                        cum_send_form_message_method.resetForm();
                                        setTimeout(function () {
                                            $('#form-wrapper').fadeIn( 300 , function() {
                                                $('.form-thanks').fadeOut();
                                            });
                                            setTimeout(function () {
                                                callModalOverlayMethod.closeModalOverlay();
                                            }, 2000);
                                        }, 3400);
                                    }, 1800);
                                }, 1800);
                            }, 1400);
                        }, 300);
                    }, 500);
                });
                cum_send_message_promise.error( function (data) {
                    setTimeout(function() {
                        //console.log('Espera');
                        setTimeout(function () {
                            $('#form-wrapper').fadeOut( 300 , function() {
                                setTimeout(function () {
                                    $('.form-loader').fadeIn();
                                }, 900);
                            });
                            setTimeout(function () {
                                //console.log("Correo no enviado...");
                                setTimeout(function () {
                                    $('#form-wrapper').fadeOut( 300 , function() {
                                        setTimeout(function () {
                                            $('.form-error').fadeIn();
                                        }, 300);
                                    });
                                    setTimeout(function () {
                                        cum_send_form_message_method.resetForm();
                                        setTimeout(function () {
                                            $('#form-wrapper').fadeIn( 300 , function() {
                                                $('.form-error').fadeOut();
                                            });
                                            setTimeout(function() {
                                                cum_send_form_message_method.resetForm();
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
    [Methods] dir_send_form_message
\* ------------------------------------------------------ */
    var dir_send_form_message_method = {
        dataDirFormMessage: function() {
            var dataDirFormMessage;
            dataDirFormMessage = $(domEl.dir_form_send_message).serializeFormJSON();
            //console.log(dataDirFormMessage);
            return CAMIN.postalService(urlsApi.int_dir_send_message, dataDirFormMessage);
        },
        fillingControl: function() {
            var validFieldsItems, dataDirFormMessage, isFull, isEmpty;
            validFieldsItems = ['dir-send-message'];
            dataDirFormMessage = $(domEl.dir_form_send_message).serializeFormJSON();
            //console.log(dataDirFormMessage);

            isFull = CAMIN.validFormFull(dataDirFormMessage, validFieldsItems);
            if(!isFull) {
                $(domEl.dir_send_message_area).attr('disabled', true);
                $(domEl.dir_send_message_area).addClass('no-drop avoid-clicks');
            } else {
                $(domEl.dir_send_message_area).removeAttr('disabled');
                $(domEl.dir_send_message_area).removeClass('no-drop avoid-clicks');
            }
            /*
            isEmpty = CAMIN.validFormFull(dataDirFormMessage, validFieldsItems);
            $(domEl.dir_send_message_area).attr('disabled', !isFull);
            */
        },
        refreshForm: function() {
            CAMIN.loadTemplate(tempsNames.recurrent_dir_form_send_message, domEl.div_recurrent_form_send_message);
            $(domEl.dir_send_message_area).attr('disabled', true);
            $(domEl.dir_send_message_area).addClass('no-drop avoid-clicks');
        },
        resetForm: function() {
            CAMIN.resetForm(domEl.dir_form_send_message);
            $(domEl.dir_send_message_area).attr('disabled', true);
            $(domEl.dir_send_message_area).addClass('no-drop avoid-clicks');
        },
        resetLoader: function() {
            $('.form-loader').css('display', 'none');
        },
        validateFieldsKeyup: function() {
            dir_send_form_message_method.fillingControl();
        },
        dir_send_form_message: function() {
            dir_send_form_message_method.fillingControl();

            var $dir_message, $dir_from, $dir_email, $dir_to, $dir_email_to, $dir_date, form_errors;

            $dir_message = $(domEl.field_dir_send_message);
            $dir_from = $(domEl.field_dir_send_from);
            $dir_email = $(domEl.field_dir_send_email);
            $dir_to = $(domEl.field_dir_send_to);
            $dir_email_to = $(domEl.field_dir_send_email_to);
            $dir_date = $(domEl.field_dir_send_date);

            //console.log($dir_message, $dir_from, $dir_email, $dir_to, $dir_email_to, $dir_date);

            form_errors = 0;
            if(validateMethods.validate_input($dir_message)) {
                form_errors++;
                $dir_message.focusout();
            }
            if(form_errors != 0) {
                var data, dir_send_message_promise;
                data = {
                    message : $dir_message.val(),
                    from : $dir_from.val(),
                    email : $dir_email.val(),
                    to : $dir_to.val(),
                    email_to : $dir_email_to.val(),
                    date : $dir_date.val(),
                    source : 'Envio de mensaje desde directorio de contactos'
                };
                //console.log(data);

                dir_send_message_promise = dir_send_form_message_method.dataDirFormMessage();
                dir_send_message_promise.success( function (data) {
                    setTimeout(function() {
                        //console.log('Espera');
                        setTimeout(function () {
                            $('#form-wrapper').fadeOut( 300 , function() {
                                setTimeout(function () {
                                    $('.form-loader').fadeIn();
                                }, 300);
                            });
                            setTimeout(function () {
                                //console.log("Correo Enviado...");
                                setTimeout(function () {
                                    $('#form-wrapper').fadeOut( 300 , function() {
                                        setTimeout(function () {
                                            $('.form-thanks').fadeIn();
                                        }, 1800);
                                    });
                                    setTimeout(function () {
                                        $('.form-loader').fadeOut();
                                        dir_send_form_message_method.resetForm();
                                        setTimeout(function () {
                                            $('#form-wrapper').fadeIn( 300 , function() {
                                                $('.form-thanks').fadeOut();
                                            });
                                            setTimeout(function () {
                                                callModalOverlayMethod.closeModalOverlay();
                                            }, 2000);
                                        }, 3400);
                                    }, 1800);
                                }, 1800);
                            }, 1400);
                        }, 300);
                    }, 500);
                });
                dir_send_message_promise.error( function (data) {
                    setTimeout(function() {
                        //console.log('Espera');
                        setTimeout(function () {
                                $('#form-wrapper').fadeOut( 300 , function() {
                                    setTimeout(function () {
                                        $('.form-loader').fadeIn();
                                    }, 900);
                                });
                            setTimeout(function () {
                                //console.log("Correo no enviado...");
                                setTimeout(function () {
                                    $('#form-wrapper').fadeOut( 300 , function() {
                                        setTimeout(function () {
                                            $('.form-error').fadeIn();
                                        }, 300);
                                    });
                                    setTimeout(function () {
                                        dir_send_form_message_method.resetForm();
                                        setTimeout(function () {
                                            $('#form-wrapper').fadeIn( 300 , function() {
                                                $('.form-error').fadeOut();
                                            });
                                            setTimeout(function () {
                                                dir_send_form_message_method.resetForm();
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
    [Methods] currentSectionMethod
\* ------------------------------------------------------ */
    var currentSectionMethod = {
        currentSection_home: function() {
            $('#head-change-section-title').html('CAMCAR Bienvenido');
            $('#site-section-home').addClass('active');
            $(domEl.recurrent_body).addClass('site-navbar-small app-contacts');
            $(domEl.div_recurrent).removeClass('bg-white');
        },
        currentSection_agreement: function() {
            $('#head-change-section-title').html('CAMCAR Convenios');
            $('#site-section-agreement').addClass('active');
            $(domEl.recurrent_body).addClass('site-navbar-small app-contacts');
            $(domEl.div_recurrent).removeClass('bg-white');
        },
        currentSection_directory: function() {
            $('#head-change-section-title').html('CAMCAR Directorio');
            $('#site-section-directory').addClass('active');
            $(domEl.recurrent_body).addClass('site-navbar-small app-contacts');
            $(domEl.div_recurrent).addClass('bg-white');
        },
        remove_currentSection: function() {
            $(domEl.div_recurrent).removeClass('bg-white');
            $('#site-section-home').removeClass('active');
            $('#site-section-agreement').removeClass('active');
            $('#site-section-directory').removeClass('active');
        }
    }
/* ------------------------------------------------------ *\
    [methods] handleSlidePanelMethods
\* ------------------------------------------------------ */
    var handleSlidePanelMethods = {
        appendSlidePanel: function() {
            $('html').addClass(classes.base + '-html');
            //SLIDE PANEL
            slidePanelAttributes = [
                ['div',
                    {
                        'id': classes.baseId,
                        'class': classes.base + ' ' + classes.base + '-' + direction  + ' ' + classes.base + '-' + responsive_direction  + ' ' + classes.show + ' animation-slide-' + direction,
                        'data-animate': 'slide-' + direction
                    }, '', 1]
            ];
            CAMIN.appendMulti(domEl._content_slide_panel, slidePanelAttributes);
            //SCROLLABLE
            slidePanelScrollableAttributes = [
                ['div', {'id': classes.base + '-close-actions', 'class': classes.base + '-close-actions'}, '', 1],
                ['div', {'id': classes.scrollableId, 'class': classes.base + '-scrollable'}, '', 1],
                ['div', {'id': classes.scrollableId + '-handler', 'class': classes.base + '-handler'}, '', 1],
                ['div', {'id': classes.scrollableId + '-loading', 'class': classes.base + '-loading'}, '', 1]
            ];
            CAMIN.appendMulti('#' + classes.baseId, slidePanelScrollableAttributes);
            //CLOSE ACTION
            closeActionAttr = [
                ['div', {'id': classes.base + '-actions', 'class': classes.base + '-actions btn-group hint--left', 'data-hint': 'CERRAR', 'aria-label': 'actions', 'role': 'group'}, '', 1],
            ];
            CAMIN.appendMulti('#' + classes.base + '-close-actions', closeActionAttr);
            //BUTTON CLOSE
            btnCloseAttr = [
                ['div', {'type': 'button', 'class': 'btn btn-pure btn-inverse slidePanel-close icon wb-close slide-panel-wb-close-bg', 'aria-hidden': 'true'}, '', 1],
            ];
            CAMIN.appendMulti('#' + classes.base + '-actions', btnCloseAttr);
            /*
            template = tempsNames.action_close;
            closeAction = domEl.div_slide_panel_actions;
            CAMIN.loadTemplate(template, closeAction);
            //console.log(template, closeAction);
            */
            //SCROLLABLE CONTAINER & SCROLLABLE BAR
            scrollableBarAttr = [
                ['div', {'id': classes.scrollableId + '-container', 'class': ''}, '', 1]
            ];
            CAMIN.appendMulti('#' + classes.scrollableId, scrollableBarAttr);
            //SLIDE PANEL CONTENT
            slidePanelContent = [
                ['div', {'id': classes.contentid, 'class': classes.content}, '', 1]
            ];
            $('#' + classes.baseId).attr('style', 'transform: translate3d(0%, 0px, 0px); transition: ' + duration + ' ' + easing + ';');
            CAMIN.appendMulti('#' + classes.scrollableId + '-container', slidePanelContent);
            //INIT ASCROLLABLE
            $('#' + classes.baseId).find('.' + classes.base + '-scrollable').asScrollable({
                namespace: 'scrollable',
                contentSelector: '>',
                containerSelector: '>'
            });
        },
        handleSlidePanel: function() {
            if(typeof $.slidePanel === 'undefined') return;

            var defaults = $.components.getDefaults("slidePanel");
            var options = $.extend({}, defaults, {
                template: function(options) {
                    return '<div class="' + options.classes.base + ' ' + options.classes.base + '-' + options.direction + '">' +
                            '<div class="' + options.classes.base + '-scrollable"><div>' +
                            '<div class="' + options.classes.content + '"></div>' +
                            '</div></div>' +
                            '<div class="' + options.classes.base + '-handler"></div>' +
                            '</div>';
                },
                afterLoad: function() {
                    this.$panel.find('.' + this.options.classes.base + '-scrollable').asScrollable({
                        namespace: 'scrollable',
                        contentSelector: '>',
                        containerSelector: '>'
                    });
                }
            });
        },
        toggleSlidePanel: function(event) {
            var element, carId, segId, feature, data, template, wrapper, titleHtml;

            CAMIN.setHTML(domEl._content_slide_panel, '');
            handleSlidePanelMethods.appendSlidePanel();
            element = $(this);
            carId = +element.data('car-id');
            segId = +element.data('seg-id');
            feature = element.data('feature');
            switch(feature) {
                case 'benefits':
                    template = tempsNames.slide_panel_benefits;
                    wrapper = domEl.div_slide_panel;
                    data = CAMIN.getInternalJSON(urlsApi.get_ben_id + carId + '/' + segId);
                    break;
                case 'features':
                    template = tempsNames.slide_panel_features;
                    wrapper = domEl.div_slide_panel;
                    data = CAMIN.getInternalJSON(urlsApi.get_car_id + carId + '/' + segId);
            }
            CAMIN.loadTemplate(template, wrapper, data);
            titleHtml = CAMIN.getHTML(domEl._slide_panel_title);
            titleHtml = $.trim(titleHtml);
            titleHtml = titleHtml.toUpperCase();
            CAMIN.setHTML(domEl._slide_panel_title, titleHtml);
        },
        openSlidePanel: function(conId) {
            var dataCon;

            dataCon = CAMIN.getInternalJSON(urlsApi.get_con_id + conId);
            //console.log(dataCon);
            CAMIN.setHTML(domEl._content_slide_panel, '');

            handleSlidePanelMethods.appendSlidePanel();
            handleSlidePanelMethods.handleSlidePanel();
            CAMIN.loadTemplate(tempsNames.slide_panel_agreement_other_brands, domEl.div_slide_panel, dataCon);

            $('header.slidePanel-header > div').removeClass('overlay-background');            
        },
        toggleSlediPanel_agreementOtherBrands: function() {
            var conId;
            conId = $(this).data('con-id');

            conIdHiddenAttr = [
                ['input', {'id': 'hidden-con-id', 'class': '', 'type': 'hidden'}, '', 0]
            ];
            CAMIN.appendMulti('#hidden-inputs-temporal', conIdHiddenAttr);

            CAMIN.setValue('#hidden-con-id', conId);

            handleSlidePanelMethods.openSlidePanel(conId);
        },
        clickCloseSlidePanel: function(event) {
            GLOBALPanelCloseBody = true;
            GLOBALPanelCloseRecurrent = false;
            GLOBALPanelCloseWidget = false;
            handleSlidePanelMethods.closeSPanel();
        },
        closeSPanel: function() {
            $('#' + classes.baseId).attr('style',"right: -100% !important; transition: 500ms ease;");
            $('html').addClass(classes.base + '-html');
            setTimeout(function () {
                setTimeout(function () {
                    CAMIN.setHTML(domEl._content_slide_panel, '');
                }, 100);
            }, 750);
        },
        previewInfo: function(event) {
            var conId;
            
            conId = CAMIN.getValue('#hidden-con-id')
            //console.log(conId);

            modal_previewInfoAttr = [
                ['div', {'id':  conId, 'class': 'hidden'}, '', 1]
            ];
            CAMIN.appendMulti('#modal-preview-info', modal_previewInfoAttr);
            toHtmlMethod.toHtml();
        },
        /*
        documentCloseSPanel: function(event) {
            var target = $(event.target).closest("#content-slide-panel");
            $("div#sub-body-two").find("#content-slide-panel");
            if(!target.length) {
                handleSlidePanelMethods.clickCloseSlidePanel();         
            }
            //console.log(target);
        }
        */
        /*
        closeOutSpanelManager: function() {
        },
        clickOutSPanelBody: function(event) {
            GLOBALPanelCloseBody = true;
            handleSlidePanelMethods.closeOutSpanelManager();
        },
        clickOutSPanelRecurrent: function(event) {
            GLOBALPanelCloseRecurrent = true;
            handleSlidePanelMethods.closeOutSpanelManager();
        },
        clickOutSPanelWidget: function(event) {
            GLOBALPanelCloseWidget = true;
            handleSlidePanelMethods.closeOutSpanelManager();
        }
        */
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
                $element.css('background-position', '100% 60%');
                $element.css('background-size', 'cover');
            });
            $('.background-image-holder').addClass('fadeIn');
        }
    }
/* ------------------------------------------------------ *\
    [Methods] domElementsFormatMethods
\* ------------------------------------------------------ */
    var domElementsFormatMethods = {
        //-------------------- Real Number --------------------
        numberReal: function (number) {
            var real, elements;
            real = +number;
            real = real.toFixed(2);
            elements = real.split('.');
            (elements.length === 1) ? elements[1] = '00' : elements = elements;
            real = elements.join('.');
            real = +real;
            real = real.toFixed(2);
            return real;
        },
        valueNumberReal: function (element) {
            $(element).each( function (idx) {
                var value, real;
                value = CAMIN.getValue($(this));
                real = domElementsFormatMethods.numberReal(value);
                CAMIN.setValue($(this), real);
            });
        },
        htmlNumberReal: function (element) {
            $(element).each( function (idx) {
                var html, real;
                html = CAMIN.getHTML($(this));
                real = domElementsFormatMethods.numberReal(html);
                CAMIN.setHTML($(this), real);
            });
        },
        //-------------------- Real Number --------------------
        currency: function (number) {
            var currency;
            currency = number;
            currency = CAMIN.currencyFormat(currency);
            return currency;
        },
        valueCurrency: function (element) {
            $(element).each( function (idx) {
                var value, currency;
                value = CAMIN.getValue($(this));
                currency = domElementsFormatMethods.currency(value);
                CAMIN.setValue($(this), currency);
            });
        },
        htmlCurrency: function (element) {
            $(element).each( function (idx) {
                var html, currency;
                html = CAMIN.getHTML($(this));
                currency = domElementsFormatMethods.currency(html);
                CAMIN.setHTML($(this), currency);
            });
        },
        //-------------------- Percentage Decimal --------------------
        percentageDecimal: function (number) {
            var percentage;
            percentage = +number;
            percentage *= 100;
            percentage = percentage.toFixed(2);
            percentage += '%';
            return percentage;
        },
        valuePercentageDecimal: function (element) {
            $(element).each( function (idx) {
                var value, percentage;
                value = CAMIN.getValue($(this));
                percentage = domElementsFormatMethods.percentageDecimal(value);
                CAMIN.setValue($(this), percentage);
            });
        },
        htmlPercentageDecimal: function (element) {
            $(element).each( function (idx) {
                var html, percentage;
                html = CAMIN.getHTML($(this));
                percentage = domElementsFormatMethods.percentageDecimal(html);
                CAMIN.setHTML($(this), percentage);
            });
        },
        //-------------------- Date Roman --------------------
        dateRoman: function (date, language, isYear) {
            var dateFormat, elements;
            isYear = (isYear === true || isYear === 'true' || isYear === 1 || isYear === '1') ? true : false;
            dateFormat = CAMIN.momentToRoman(date, language);
            elements = dateFormat.split(',');
            dateFormat = elements[1];
            dateFormat = $.trim(dateFormat);
            elements = dateFormat.split(' ');
            if(!isYear) {
                elements.splice(2,1);
            }
            dateFormat = elements.join(' de ');
            return dateFormat;
        },
        valueDateRoman: function (element, isYear) {
            $(element).each( function (idx) {
                var value, dateFormat;
                value = CAMIN.getValue($(this));
                dateFormat = domElementsFormatMethods.dateRoman(value, 'es', isYear);
                CAMIN.setValue($(this), dateFormat);
            });
        },
        htmlDateRoman: function (element, isYear) {
            $(element).each( function (idx) {
                var html, dateFormat;
                html = CAMIN.getHTML($(this));
                dateFormat = domElementsFormatMethods.dateRoman(html, 'es', isYear);
                CAMIN.setHTML($(this), dateFormat);
            });
        },
        //-------------------- Date Human --------------------
        dateHuman: function (date, language) {
            var dateFormat;
            dateFormat = CAMIN.momentToHuman(date, language);
            return dateFormat;
        },
        valueDateHuman: function (element) {
            $(element).each( function (idx) {
                var value, dateFormat;
                value = CAMIN.getValue($(this));
                dateFormat = domElementsFormatMethods.dateHuman(value, 'es');
                CAMIN.setValue($(this), dateFormat);
            });
        },
        htmlDateHuman: function (element) {
            $(element).each( function (idx) {
                var html, dateFormat;
                html = CAMIN.getHTML($(this));
                dateFormat = domElementsFormatMethods.dateHuman(html, 'es');
                CAMIN.setHTML($(this), dateFormat);
            });
        },
        //-------------------- UC WORDS --------------------
        ucWords: function (element) {
            $(element).each( function (idx) {
                var html, ucWords;
                html = CAMIN.getHTML($(this));
                ucWords = CAMIN.ucWords(html);
                CAMIN.setHTML($(this), ucWords);
            });
        }
    }
/* ------------------------------------------------------ *\
    [Methods] inputValMetdods
\* ------------------------------------------------------ */
    var inputValMetdods = {
        isIntegerKP: function (event) {
            var key, numeros, teclado, especiales, teclado_especial, i;

            key = event.keyCode || event.which;
            teclado = String.fromCharCode(key);
            numeros = '0123456789';
            especiales = [8,9,37,38,39,40,46];//array
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
    [Methods] validateMethods
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
                        /*
                        case 'area':
                            if( !is_model_name( value)) {
                                r.message = validation_messages.general;
                            }
                            break;
                        */
                        case 'upload':
                            if(!valid_extension_file( formulario, value)) {
                                r.message = validation_messages.upload;
                                //console.log(r.message);
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
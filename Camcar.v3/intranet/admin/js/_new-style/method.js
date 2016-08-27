/* ------------------------------------------------------ *\
 [Metodos] Variables
\* ------------------------------------------------------ */

var GLOBALLastUrlPro;

var /*GLOBALUsrUserName,*/ GLOBALUsrFullname, GLOBALUsrId, GLOBALUsrType,
    GLOBALUsrEmail, GLOBALUsrAgnId, GLOBALUsrAgnName, GLOBALUsrAgnLogo1, 
    GLOBALUsrAgnLogo2, GLOBALUsrAgnHeader;

var
//GLOBALUsrUserName = $(domEl.adm_input_session_usr_username).val(),
GLOBALUsrFullname = $(domEl.adm_input_session_usr_fullname).val(),
GLOBALUsrId = +$(domEl.adm_input_session_usr_id).val(),
GLOBALUsrType = +$(domEl.adm_input_session_usr_type).val(),
GLOBALUsrEmail = $(domEl.adm_input_session_usr_email).val(),
GLOBALUsrAgnId = +$(domEl.adm_input_session_usr_agn_id).val(),
GLOBALUsrAgnName = $(domEl.adm_input_session_usr_agn_name).val(),
GLOBALUsrAgnLogo1 = $(domEl.adm_input_session_usr_agn_logo1).val(),
GLOBALUsrAgnLogo2 = $(domEl.adm_input_session_usr_agn_logo2).val(),
GLOBALUsrAgnHeader = $(domEl.adm_input_session_usr_agn_header).val();

var section, today;
var IS_MOBILE, mediaquery;

//Browser supports HTML5 multiple file?
var multipleSupport = typeof $('<input/>')[0].multiple !== 'undefined',
    isIE = /msie/i.test( navigator.userAgent);
var classes, direction, duration, easing;

classes = {
    base: 'slidePanel',
    baseId: 'slide-Panel',
    show: 'slidePanel-show',
    loading: 'slidePanel-loading',
    content: 'slidePanel-content',
    contentid: 'content-slidePanel',
    dragging: 'slidePanel-dragging',
    willClose: 'slidePanel-will-close'
};

direction = 'right'; //top, bottom, left, right
duration = '500ms';
easing = 'ease';

/* ------------------------------------------------------ *\
    [Metodos] 'Zone'
    
    var Method = {
        function_name: function(event) {}
    }
\* ------------------------------------------------------ */

function validateEmail(email) {
    var re = /^(([^<>()[\]\\., ;:\s@\"] + (\.[^<>()[\]\\., ;:\s@\"] + )*)|(\". + \"))@((\[[0-9] {1, 3}\.[0-9] {1, 3}\.[0-9] {1, 3}\.[0-9] {1, 3}\])|(([a-zA-Z\-0-9] + \.) + [a-zA-Z] {2, }))$/;
    //return re.test(email);
    return true;
}

/* ------------------------------------------------------ *\
    [Metodos] Alert Custom
\* ------------------------------------------------------ */

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
    [Metodos] __sizeCheck
\* ------------------------------------------------------ */

function __sizeCheck(element) {

    //current width
    var _cWidth = element.width();
    var adm_mt_utility_bar = $('.utility-bar');

    //update text
    _cText = 'desktop screens > 1200px';

    //check block
    if(_cWidth == 2000) {
        _cText = 'desktop computer ' + _cWidth + 'px';
        $('.nav-1 .logo').css('margin-left', '55px');
        $(adm_mt_utility_bar).css('margin-top', '50px');
        //console.log(adm_mt_utility_bar);
    }
    if(_cWidth < 2000) {
        _cText = 'desktop computer ' + _cWidth + 'px';
        $('.nav-1 .logo').css('margin-left', '55px');
        $(adm_mt_utility_bar).css('margin-top', '50px');
        //console.log(adm_mt_utility_bar);
    }
    if(_cWidth == 1680) {
        _cText = 'desktop computer ' + _cWidth + 'px';
        $('.nav-1 .logo').css('margin-left', '55px');
        $(adm_mt_utility_bar).css('margin-top', '50px');
        //console.log(adm_mt_utility_bar);
    }
    if(_cWidth < 1680) {
        _cText = 'desktop computer ' + _cWidth + 'px';
        $('.nav-1 .logo').css('margin-left', '55px');
        $(adm_mt_utility_bar).css('margin-top', '70px');
        //console.log(adm_mt_utility_bar);
    }
    if(_cWidth < 1280) {
        _cText = 'desktop computer ' + _cWidth + 'px';
        $('.nav-1 .logo').css('margin-left', '55px');
    }
    if(_cWidth < 1024) {
        _cText = 'ipad landscape ' + _cWidth + 'px';
        $('.nav-1 .logo').css('margin-left', '55px');
    }
    if(_cWidth < 768) {
        _cText = 'ipad portrait ' + _cWidth + 'px';
        $('body').css('padding', '0');
        $('#img-banner').css({
            'margin-left':'0',
            'margin-right':'0'
        });
        $('.dealer-prosite').css('top', '0');
        $('.mobile-section').css('padding-top', '0');
        $('.nav-1 .logo').css('margin-left', '55px');

        $('.vin_agn_name').css('display', 'block');
    }
    if(_cWidth === 480) {
        $('body').css('padding', '0');
        $('#img-banner').css({
            'margin-left':'0',
            'margin-right':'0'
        });
        $('.dealer-prosite').css('top', '0');
        $('.mobile-section').css('padding-top', '0');
        $('.nav-1 .logo').css('margin-left', '55px');
        $('.vin_agn_name').css('display', 'none');
    }
    if(_cWidth < 480) {
        _cText = 'iphone landscape ' + _cWidth + 'px';
        $('body').css('padding', '0');
        $('#img-banner').css({
            'margin-left':'0',
            'margin-right':'0'
        });
        $('.dealer-prosite').css('top', '0');
        $('.mobile-section').css('padding-top', '0');
        $('.nav-1 .logo').css('margin-left', '55px');

        $('.vin_agn_name').css('display', 'none');
        //console.log(_cText);
        $(adm_mt_utility_bar).css('margin-top', '70px');
        //console.log(adm_mt_utility_bar);
    }
    if(_cWidth < 320) {
        _cText = 'iphone portrait ' + _cWidth + 'px';
        $('body').css('padding', '0');
        $('.vin_agn_name').css('display', 'none');
    }
    if(_cWidth < 240) {
        _cText = 'so small phones ' + _cWidth + 'px';
        $('.vin_agn_name').css('display', 'none');
    }
    $(domEl.adm_div_recurrent).on('click', ".agencia", function(){
        $(".closeToggle").slideUp();
    });
    $(domEl.adm_div_recurrent).on('click', ".closeToggle", function(){
        $("#options").slideUp();
    });
}


/* ------------------------------------------------------ *\
    [functions] DETEC MOBILE
\* ------------------------------------------------------ */
/* Detect Mobile Browser : http://detectmobilebrowsers.com/ */


function detectmobile(a){
    IS_MOBILE = false;
    if(/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|meego.+mobile|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) {
        IS_MOBILE = true;
    }
    return IS_MOBILE;
};

/* ------------------------------------------------------ *\
    [Methods] MATCHMEDIA
\* ------------------------------------------------------ */

var matchMediaMethod = {
    mediaquery: function() {
        mediaquery = window.matchMedia("(max-width: 768px)");
        if (mediaquery.matches) {
            //mediaquery es 768px
        } else {
            //mediaquery no es 768px
        }
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

        if ( nav.height() === 0) {
            autoHeightAnimate(nav, animateTime);
            //console.log(nav, animateTime);
        } else{
            nav.stop().animate({ height: '0' }, animateTime);
            //console.log(nav);
        }
        /* Function to animate height: auto */
        function autoHeightAnimate(element, time){
            var curHeight, //Get Default Height
                autoHeight; //Get Auto Height

            curHeight = element.height();
            autoHeight  = element.css('height', 'auto').height()

            element.height(curHeight); //Reset to Default Height
            element.stop().animate({ height: autoHeight }, parseInt(time)); //Animate to Auto Height
        }
    }
}

/* ------------------------------------------------------ *\
    [Metodos] Favicon
\* ------------------------------------------------------ */

var favicon = {
    load_favicon: function() {
        favicon.change("../../img/ico/camcaricon.ico");
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
            return; //Assuming only one match at most.
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
        $('.equal-height').each(function(){
            if($(this).height() > altomax){
                altomax = $(this).height();
            }
        });
        $('.equal-height').height( altomax);
    }
}

/* ------------------------------------------------------ *\
    [Methods] addStyles
\* ------------------------------------------------------ */

var addStylesMethod = {
    addStylesNewPreowned: function() {
        stylesPreownedAttributes = [
            ['link', {'id' : 'content-add-style-adm-plugins', 'rel': 'stylesheet', 'class':'style-link-adm', 'href': '../../css/styles/assets/plugins/bootstrap-select/bootstrap-select.css'}, '', 0],
            ['link', {'id' : 'content-add-style-adm-plugins', 'rel': 'stylesheet', 'class':'style-link-adm', 'href': '../../css/styles/assets/pages/forms/advanced.css'}, '', 0]
        ];
        CAMAD.appendMulti(domEl.adm_recurrent_head, stylesPreownedAttributes);
        pluginsNewPreownedAttributes = [
            ['script', {'id' : 'content-add-plugin-adm-plugins', 'class':'plugin-link-adm', 'src': '../../lib/assets/plugins/bootstrap-select/bootstrap-select.js'}, '', 0]
        ];
        CAMAD.appendMulti('div#plugins-for-this-section', pluginsNewPreownedAttributes);
        scriptsPreownedAttributes = [
            ['script', {'id' : 'content-add-plugin-adm-scripts', 'class':'script-link-adm', 'src': '../../lib/assets/run/components/bootstrap-select.js'}, '', 0]
        ];
        CAMAD.appendMulti('div#scripts-for-this-section', scriptsPreownedAttributes);
    }
}

/* ------------------------------------------------------ *\
    [Methods] goSectionMethods
\* ------------------------------------------------------ */

var goSectionMethods = {
    //home
    goSection_home: function(event) {
        //$('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo');
        Finch.navigate('/');
    }
}

/* ------------------------------------------------------ *\
    [Metodos] loadSiteNavigationMethods
\* ------------------------------------------------------ */

var loadSiteNavigationMethods = {
    loadSiteNavigation: function() {
        CAMAD.loadTemplate(tempsNames.recurrent_adm_site_navbar, domEl.adm_site_navbar);
        CAMAD.loadTemplate(tempsNames.recurrent_adm_site_menubar, domEl.adm_site_menubar);
    }
}

/* ------------------------------------------------------ *\
    [Metodos] viewSectionAdmHomeMethods
\* ------------------------------------------------------ */

var viewSectionAdmHomedMethods = {
    viewSectionAdmHomed: function() {
        viewSectionAdmHomedMethods.recurrent_adm_new_preowned();
        viewSectionAdmHomedMethods.loadTemplatesNewPreowned();
    },
    recurrent_adm_new_preowned: function() {
        homePageHeaderAttributes = [
            ['div', {'id' : domEl.adm__section_mew_preowned_page_header, 'class':'page-header page-header-bordered page-header-tabs'}, '', 1],
            ['div', {'id' : domEl.adm__section_mew_preowned_page_content, 'class':'page-content container-fluid', 'style':'padding-top: 0px;'}, '', 1]
        ];
        CAMAD.appendMulti(domEl.adm_div_recurrent, homePageHeaderAttributes);
    },
    loadTemplatesHome: function() {
        CAMAD.loadTemplate(tempsNames.recurrent_adm_section_home_page_header, domEl.adm__section_home_page_header_name);
        CAMAD.loadTemplate(tempsNames.recurrent_adm_section_home_page_content, domEl.adm__section_home_page_content_name);
    }
}

/* ------------------------------------------------------ *\
    [Metodos] viewSectionAdmNewPreownedMethods
\* ------------------------------------------------------ */

var viewSectionAdmNewPreownedMethods = {
    viewSectionAdmNewPreowned: function() {
        viewSectionAdmNewPreownedMethods.recurrent_adm_new_preowned();
        viewSectionAdmNewPreownedMethods.loadTemplatesNewPreowned();
    },
    recurrent_adm_new_preowned: function() {
        newPreownedPageHeaderAttributes = [
            ['div', {'id' : domEl.adm__section_new_preowned_page_header, 'class':'page-header page-header-bordered page-header-tabs'}, '', 1],
            ['div', {'id' : domEl.adm__section_new_preowned_page_content, 'class':'page-content container-fluid', 'style':'padding-top: 0px;'}, '', 1]
        ];
        CAMAD.appendMulti(domEl.adm_div_recurrent, newPreownedPageHeaderAttributes);
    },
    loadTemplatesNewPreowned: function() {
        CAMAD.loadTemplate(tempsNames.recurrent_adm_section_new_preowned_page_header, domEl.adm__section_new_preowned_page_header_name);
        CAMAD.loadTemplate(tempsNames.recurrent_adm_section_new_preowned_page_content, domEl.adm__section_new_preowned_page_content_name);
    }
}

/* ------------------------------------------------------ *\
 [Methods] Load Banner
\* ------------------------------------------------------ */

var bannerMethods = {
    bannerLoad: function() {
        var agn_header, url, pic_headers;
        var banner, newImg, currentSRC, newSRC, elemnts, folder;
        //console.log('entra');

        //usr_agn_id = CAMAD.getValue(domEl.adm_input_session_usr_agn_id);
        agn_header = CAMAD.getValue(domEl.adm_input_session_usr_agn_header);

        //bannerData = CAMAD.getInternalJSON(urlsApi.adm_get_agn_header_id + usr_agn_id);

        if(agn_header === '') {

            bannerData = CAMAD.getInternalJSON(urlsApi.adm_get_agn_header);

            pic_headers = CAMAD.filterArrayObjByKey(bannerData.camadpa, 'agn_header', '', 0);

            //console.log(pic_headers);

            currentSRC = $(domEl.adm_img_banner).attr('style');
            //currentSRC = currentSRC.trim();
            currentSRC = currentSRC;
            currentImg = '';

            //console.log(currentSRC);
            if(currentSRC !== '') {
                //elements = currentSRC.split('/');
                elements = currentSRC;
                currentImg = elements
            }
            banner = bannerData.camadpa[0].agn_header;
            newImg = banner;

            do {
                newImg = pic_headers[Math.floor(Math.random() * pic_headers.length)];
            } while(newImg === currentImg);
        } else {
            newImg = agn_header;
        }

        folder = '../../resources/public/img/agencies/headers/seminuevos';
        newSRC =  folder + '/' + newImg;
        //newSRC =  newImg;
        $(domEl.adm_img_banner).attr('style', "background-image: url("+newSRC+"); top: 5px; margin-left: -50px; margin-right: -50px;");
    }
}

/* ------------------------------------------------------ *\
 [Function] ScrollToTop
\* ------------------------------------------------------ */

function scrollToTop(){
    var windowWidth = $(window).width(), didScroll = false;

    var $arrow = $('#back-to-top');

    $arrow.on("click", function(e) {
        $('body,html').animate({ scrollTop: "0" }, 750, 'easeOutExpo');
        e.preventDefault();
    })

    $(window).scroll(function() {
        didScroll = true;
    });

    setInterval(function() {
        if(didScroll) {
            didScroll = false;

            if($(window).scrollTop() > 200) {
                $arrow.fadeIn();
            } else {
                $arrow.fadeOut();
            }
        }
    }, 250);
}

/* ------------------------------------------------------ *\
 [Methods] RESPONSIVE OPEN MENU
\* ------------------------------------------------------ */

var openMenuMethods = {
    clickOpenMenu: function () {
        $('nav').toggleClass('open-menu');
    }
}

var closeMenuMethods = {
    clickClose: function () {
        $('nav').removeClass('open-menu');
    }
}

/* ------------------------------------------------------ *\
 [Methods] Views Model
\* ------------------------------------------------------ */

var viewsMethods = {
    switchActiveOption: function () {
        if($(domEl.adm_id_views_list).hasClass("active")) {
            $(domEl.adm_id_views_list).removeClass("active");
            $(domEl.adm_id_views_grid).addClass("active");
        } else {
            $(domEl.adm_id_views_grid).removeClass("active");
            $(domEl.adm_id_views_list).addClass("active");
        }
    },
    results: function () {
        var $tallestCol;
        /*
        $(domEl.adm_id_results_holder).each(function(){
            $tallestCol = 0;
            $(this).find(domEl.adm_class_result_item).each(function(){
                ($(this).height() > $tallestCol) ? $tallestCol = $(this).height() : $tallestCol = $tallestCol;
            });
            if($tallestCol == 0) $tallestCol = 'auto';
                $(domEl.adm_class_result_item).css('height',$tallestCol);
        });
        */
    },
    gridView: function () {
        setTimeout(function(){
            $(domEl.adm_id_results_holder).removeClass("results-list-view");
            $(domEl.adm_id_results_holder).addClass("results-grid-view");
            //$(domEl.adm_id_views_list).removeClass("active");
            //$(domEl.adm_id_views_grid).addClass("active");
            $('.results-grid-view .result-item-in.result-item-box').css('display', 'none');
            viewsMethods.results();
            $(".waiting").hide();
            /*
            $('body,html').animate({
                scrollTop: "0"
            }, 750, 'easeOutExpo');
            */
        },800);
    },
    gridViewStop: function () {
        clearTimeout(viewsMethods.gridView());
    },
    listView: function () {
        setTimeout(function() {
            $(domEl.adm_id_results_holder).removeClass("results-grid-view");
            $(domEl.adm_id_results_holder).addClass("results-list-view");
            //$(domEl.adm_id_views_grid).removeClass("active");
            //$(domEl.adm_id_views_list).addClass("active");
            $(domEl.adm_id_results_holder).find(domEl.adm_class_result_item).css("height", "auto");
            $('.results-list-view .result-item-in.result-item-box').css('display', 'block');
            $(".waiting").hide();
            /*
            $('body,html').animate({
                scrollTop: "0"
            }, 750, 'easeOutExpo');
            */
        }, 800);
    },
    listViewStop: function () {
        clearTimeout(viewsMethods.listView());
    }
}

/* ------------------------------------------------------ *\
 [Methods] SEARCH FORM
\* ------------------------------------------------------ */

var searchFormMethod = {
    searchFrom: function () {
        var $searchform = $('.navbar .search-form');
        var $bselect = $('.bootstrap-select .dropdown-menu');
        function menuScroll() {
            var lastScroll = 0;
            $(window).scroll(function(event){
                //Sets the current scroll position
                var st = $(this).scrollTop();
                //Determines up-or-down scrolling
                if(st > lastScroll && $(window).width() > 992){
                   //Replace this with your function call for downward-scrolling
                   $searchform.slideUp();
                   $bselect.css('visibility', 'hidden');
                }
                else {
                }
                //Updates scroll position
                lastScroll = st;
            });
        }
    }
}


/* ------------------------------------------------------ *\
 [Methods] New Seminuevos
\* ------------------------------------------------------ */

var newSenMethod = {
    addSen: function () {
        var dataNewSen;
        dataNewSen = $(domEl.adm_form_new_sen).serializeFormJSON();
        return CAMAD.postalService(urlsApi.adm_new_sen, dataNewSen);
    },
    fillingControl: function() {
        var validFieldName, dataNewSen, isFull, isNoEmpty;
        validFieldName = ['sen_description', 'sen_agency', 'sen_category', 'sen_brand',
                          'sen_model', 'sen_year', 'sen_price', 'sen_cylinders',
                          'sen_transmission', 'sen_color', 'sen_interior'];
        dataNewSen = $(domEl.adm_form_new_sen).serializeFormJSON();
        isFull = CAMAD.validFormFull(dataNewSen, validFieldName);
        $(domEl.adm_btn_new_sen_save).attr('disabled', !isFull);
        isEmpty = CAMAD.validFormEmpty(dataNewSen, validFieldName);
        $(domEl.adm_btn_new_sen_clean).attr('disabled', isEmpty);
    },
    resetSen: function () {
        var agnData, catData, marData, mdoData, usrType, agnId, date, year, range;

        //Load Form
        CAMAD.loadTemplate(tempsNames.adm_new_sen_form, domEl.adm_div_recurrent);

        //Get user type
        usrType = GLOBALUsrType;

        switch(usrType) {
            //Admin
            case 0:
                //Load agencies in a select
                agnData = CAMAD.getInternalJSON(urlsApi.adm_get_agn);
                CAMAD.loadTemplate(tempsNames.adm_new_sen_form_select_agency, domEl.adm_div_select_new_sen_agency, agnData);
                break;
            //User
            case 1:
                //Remove select and load session agency in hidden
                $(domEl.adm_div_new_sen_agency_container).remove();
                agnId = GLOBALUsrAgnId;
                CAMAD.appendOne(domEl.adm_form_new_sen, 'input', {'type':'hidden', 'value':agnId, 'name':'sen_agency'}, '', false);
        }

        //Load categories
        catData = CAMAD.getInternalJSON(urlsApi.adm_get_cat);
        CAMAD.loadTemplate(tempsNames.adm_new_sen_form_select_category, domEl.adm_div_select_new_sen_category, catData);

        //Load brands
        marData = CAMAD.getInternalJSON(urlsApi.adm_get_mar);
        CAMAD.loadTemplate(tempsNames.adm_new_sen_form_select_brand, domEl.adm_div_select_new_sen_brand, marData);

        //Load models
        CAMAD.loadTemplate(tempsNames.adm_new_sen_form_select_model, domEl.adm_div_select_new_sen_model, {});

        //Get year from 10 years ago
        yearData = {};
        yearData.camadpa = [];
        date = new Date();
        year = date.getFullYear();
        range = 10;
        for(var thisYear = year - range, idx = 0; thisYear <= year + 1; thisYear++, idx++) {
            yearData.camadpa[idx] = {};
            yearData.camadpa[idx].year = thisYear;
        }
        //Load years
        CAMAD.loadTemplate(tempsNames.adm_new_sen_form_select_year, domEl.adm_div_select_new_sen_year, yearData);

        $('.selectpicker').selectpicker();

        //Disable buttons
        $(domEl.adm_btn_new_sen_save).attr('disabled', true);
        $(domEl.adm_btn_new_sen_clean).attr('disabled', true);

        //CAMAD.resetForm(domEl.adm_form_new_sen);
    },
    keyupDescription: function (event) {
        newSenMethod.fillingControl();
    },
    changeBrand: function (event) {
        var marId, mdoData;
        marId = +CAMAD.getValue($(this));
        mdoData = (marId) ? CAMAD.getInternalJSON(urlsApi.adm_get_mdo_mar_id + marId) : {};
        CAMAD.loadTemplate(tempsNames.adm_new_sen_form_select_model, domEl.adm_div_select_new_sen_model, mdoData);
        $('.selectpicker').selectpicker();
    },
    changeSelect: function (event) {
        newSenMethod.fillingControl();
    },
    keyupInput: function (event) {
        newSenMethod.fillingControl();
    },
    clickSave: function (event) {
        resetAlert();
        alertify.set({
            labels: {
                ok: 'Aceptar',
                cancel: 'Cancelar'
            }
        });
        alertify.confirm('¿Seguro que desea guardar?', function (e) {
            if(e) {
                var senPromise;
                senPromise = newSenMethod.addSen();
                senPromise.success( function (data) {
                    var senId;
                    senId = +data.camadpa.id_inserted;
                    //newSenMethod.resetSen();
                    //newSenMethod.fillingControl();
                    alertify.success('Seminuevo agregado.' +
                                     '<br /> Agrege imágenes en la parte inferior al formulario');
                    Finch.navigate('/set/seminuevos/' + senId);
                });
                senPromise.error( function (data) {
                    newSenMethod.resetSen();
                    newSenMethod.fillingControl();
                    alertify.error('No se ha podido agregar el seminuevo <br /> Inténtelo más tarde.');
                });
            }
        });
    },
    clickClean: function (event) {
        newSenMethod.resetSen();
        newSenMethod.fillingControl();
    },
    clickSeminuevosList: function (event) {
        Finch.navigate('/seminuevos');
    }
}

/* ------------------------------------------------------ *\
 [Methods] set Seminuevos
\* ------------------------------------------------------ */

var setSenMethod = {
    updateSen: function (senId) {
        var dataSetSen;
        dataSetSen = $(domEl.adm_form_set_sen).serializeFormJSON();
        return CAMAD.postalService(urlsApi.adm_set_sen + senId, dataSetSen);
    },
    fillingControl: function() {
        var validFieldName, dataSetSen, isFull, isNoEmpty;
        validFieldName = ['sen_description', 'sen_agency', 'sen_category', 'sen_brand',
                          'sen_model', 'sen_year', 'sen_price', 'sen_cylinders',
                          'sen_transmission', 'sen_color', 'sen_interior'];
        dataSetSen = $(domEl.adm_form_set_sen).serializeFormJSON();
        isFull = CAMAD.validFormFull(dataSetSen, validFieldName);
        $(domEl.adm_btn_set_sen_save).attr('disabled', !isFull);
        isEmpty = CAMAD.validFormEmpty(dataSetSen, validFieldName);
        $(domEl.adm_btn_set_sen_clean).attr('disabled', isEmpty);
    },
    resetSen: function () {
        CAMAD.resetForm(domEl.adm_form_set_sen);
    },
    cleanSen: function (senId) {
        var senData, agnData, catData, marData, mdoData, usrType, agnId, date, year, range;

        senData = CAMAD.getInternalJSON(urlsApi.adm_get_sen_id + senId);

        //Load form
        CAMAD.loadTemplate(tempsNames.adm_set_sen_form, domEl.adm_div_set_sen_data, senData);

        CAMAD.setValue(domEl.adm__set_sen_element, '');

        //Get user type
        usrType = GLOBALUsrType;

        switch(usrType) {
            //Admin
            case 0:
                //Get agency
                agnId = senData.camadpa[0].agencia.id;
                //Get agencies list
                agnData = CAMAD.getInternalJSON(urlsApi.adm_get_agn);
                //Load agencies
                CAMAD.loadTemplate(tempsNames.adm_set_sen_form_select_agency, domEl.adm_div_select_set_sen_agency, agnData);
                break;
            //User
            case 1:
                //Get agency
                agnId = GLOBALUsrAgnId;
                //Remove select and load session agency in hidden
                $(domEl.adm_div_set_sen_agency_container).remove();
                CAMAD.appendOne(domEl.adm_form_set_sen, 'input', {'type':'hidden', 'value':agnId, 'name':'sen_agency'}, '', false);
        }

        //Get categories list
        catData = CAMAD.getInternalJSON(urlsApi.adm_get_cat);
        //Load categories
        CAMAD.loadTemplate(tempsNames.adm_set_sen_form_select_category, domEl.adm_div_select_set_sen_category, catData);

        //Get brands list
        marData = CAMAD.getInternalJSON(urlsApi.adm_get_mar);
        //Load brands
        CAMAD.loadTemplate(tempsNames.adm_set_sen_form_select_brand, domEl.adm_div_select_set_sen_brand, marData);

        //Add agency to each brand
        $(domEl.adm_select_sen_filter_brand + ' option').data('agn-id', agnId);

        //Get models list
        mdoData = {};
        //Load models
        CAMAD.loadTemplate(tempsNames.adm_set_sen_form_select_model, domEl.adm_div_select_set_sen_model, mdoData);

        //Get year from 10 years ago
        yearData = {};
        yearData.camadpa = [];
        date = new Date();
        year = date.getFullYear();
        range = 10;
        for(var thisYear = year - range, idx = 0; thisYear <= year + 1; thisYear++, idx++) {
            yearData.camadpa[idx] = {};
            yearData.camadpa[idx].year = thisYear;
        }
        //Load years
        CAMAD.loadTemplate(tempsNames.adm_set_sen_form_select_year, domEl.adm_div_select_set_sen_year, yearData);

        $('.selectpicker').selectpicker();
    },
    keyupDescription: function (event) {
        setSenMethod.fillingControl();
    },
    refreshSen: function(senId) {
        var senData, senAgnData, agnData, catData, marData, mdoData, usrType, agnId, catId, marId, mdoId,
            date, year, range, transmission, color, interior, yearCurrent, cylinders, senIdxArray;

        senId = +senId;

        //Get user type
        usrType = GLOBALUsrType;

        switch(usrType) {
            //Admin
            case 0:
                //Search if this seminuevo exits
                senData = CAMAD.getInternalJSON(urlsApi.adm_get_sen_id + senId);
                //If this seminuevo exists
                if(senData.camadpa.length) {
                    //Get agency
                    agnId = senData.camadpa[0].agencia.id;
                    //Load form
                    CAMAD.loadTemplate(tempsNames.adm_set_sen_form, domEl.adm_div_set_sen_data, senData);
                    //Get agencies list
                    agnData = CAMAD.getInternalJSON(urlsApi.adm_get_agn);
                    //Load agencies
                    CAMAD.loadTemplate(tempsNames.adm_set_sen_form_select_agency, domEl.adm_div_select_set_sen_agency, agnData);
                    //Set agency
                    CAMAD.setValue(domEl.adm_select_set_sen_agency, agnId);
                //If this seminuevo doesn't exist
                } else {
                    Finch.navigate('/seminuevos');
                }
                break;
            //User
            case 1:
                //Get agency
                agnId = GLOBALUsrAgnId;
                //Get all seminuevos of the current agency
                senAgnData = CAMAD.getInternalJSON(urlsApi.adm_get_sen_agn_id + agnId);
                //If there are seminuevos in the current agency
                if(senAgnData.camadpa.length) {

                    //Get all ids of all seminuvos of the current agency
                    senIdxArray = CAMAD.filterArrayObjByKey(senAgnData.camadpa, 'id', 0, 0);

                    //Change all string eelements into integer
                    for(var idx = 0; idx < senIdxArray.length; idx++) {
                        senIdxArray[idx] = +senIdxArray[idx];
                    }

                    //Search if this seminuevo exits in the current agency
                    senIdxCurrent = _.indexOf(senIdxArray, senId);

                    //If the seminuevo belogns to the current agency
                    if(senIdxCurrent >= 0) {

                        //Get only the current seminuevo
                        senData = {
                            'camadpa' : [
                                senAgnData.camadpa[senIdxCurrent]
                            ]
                        };

                        //Load form
                        CAMAD.loadTemplate(tempsNames.adm_set_sen_form, domEl.adm_div_set_sen_data, senData);
                        //Remove select and load session agency in hidden
                        $(domEl.adm_div_set_sen_agency_container).remove();
                        CAMAD.appendOne(domEl.adm_form_set_sen, 'input', {'type':'hidden', 'value':agnId, 'name':'sen_agency'}, '', false);

                    //If the seminuevo doesn't belogn to the current agency
                    } else {
                        Finch.navigate('/seminuevos');
                    }

                //If there are not seminuevos in the current agency
                } else {
                    Finch.navigate('/seminuevos');
                }
        }

        //Get transmission
        transmission = senData.camadpa[0].transmision;
        //Set transmission
        CAMAD.setValue(domEl.adm_select_set_sen_transmission, transmission);

        //Get color
        color = senData.camadpa[0].color;
        //Set color
        CAMAD.setValue(domEl.adm_select_set_sen_color, color);

        //Get interior
        interior = senData.camadpa[0].interior;
        //Set interior
        CAMAD.setValue(domEl.adm_select_set_sen_interior, interior);

        //Get categories list
        catData = CAMAD.getInternalJSON(urlsApi.adm_get_cat);
        //Load categories
        CAMAD.loadTemplate(tempsNames.adm_set_sen_form_select_category, domEl.adm_div_select_set_sen_category, catData);
        //Get category
        catId = senData.camadpa[0].categoria.id;
        //Set category
        CAMAD.setValue(domEl.adm_select_set_sen_category, catId);

        //Get brands list
        marData = CAMAD.getInternalJSON(urlsApi.adm_get_mar);
        //Load brands
        CAMAD.loadTemplate(tempsNames.adm_set_sen_form_select_brand, domEl.adm_div_select_set_sen_brand, marData);
        //Get brand
        marId = senData.camadpa[0].marca.id;
        //Set brand
        CAMAD.setValue(domEl.adm_select_set_sen_brand, marId);
        //Add agency to each brand
        $(domEl.adm_select_sen_filter_brand + ' option').data('agn-id', agnId);

        //Get models list by brand
        mdoData = CAMAD.getInternalJSON(urlsApi.adm_get_mdo_mar_id + marId);
        //Load models
        CAMAD.loadTemplate(tempsNames.adm_set_sen_form_select_model, domEl.adm_div_select_set_sen_model, mdoData);
        //Get model
        mdoId = senData.camadpa[0].modelo.id;
        //Set model
        CAMAD.setValue(domEl.adm_select_set_sen_model, mdoId);

        //Get year from 10 years ago
        yearData = {};
        yearData.camadpa = [];
        date = new Date();
        year = date.getFullYear();
        range = 10;
        for(var thisYear = year - range, idx = 0; thisYear <= year + 1; thisYear++, idx++) {
            yearData.camadpa[idx] = {};
            yearData.camadpa[idx].year = thisYear;
        }
        //Load years
        CAMAD.loadTemplate(tempsNames.adm_set_sen_form_select_year, domEl.adm_div_select_set_sen_year, yearData);
        //Get current year
        yearCurrent = senData.camadpa[0].anio;
        //Set year
        CAMAD.setValue(domEl.adm_select_set_sen_year, yearCurrent);

        //Get cylinders
        cylinders = senData.camadpa[0].cilindros;
        CAMAD.setValue(domEl.adm_select_set_sen_cylinders, cylinders);

        $('.selectpicker').selectpicker();

    },
    changeSelect: function (event) {
        setSenMethod.fillingControl();
    },
    changeBrand: function(event) {
        var agnId, marId, mdoData, option;
        option = $(this).find(':selected');
        marId = +CAMAD.getValue(option);
        agnId = +option.data('agn-id');
        mdoData = (marId) ? CAMAD.getInternalJSON(urlsApi.adm_get_mdo_mar_id + marId) : {};
        CAMAD.loadTemplate(tempsNames.adm_set_sen_form_select_model, domEl.adm_div_select_set_sen_model, mdoData);

        $('.selectpicker').selectpicker();

        getSenMethod.fillingControl();
        getSenMethod.sortingFilters();
    },
    keyupInput: function (event) {
        setSenMethod.fillingControl();
    },
    clickSave: function (event) {
        var senId;
        senId = +$(this).data('sen-id');
        resetAlert();
        alertify.set({
            labels: {
                ok: 'Aceptar',
                cancel: 'Cancelar'
            }
        });
        alertify.confirm('¿Seguro que desea modificar?', function (e) {
        if(e) {
            var senPromise;
                senPromise = setSenMethod.updateSen(senId);
                senPromise.success( function (data) {
                    setSenMethod.refreshSen(senId);
                    setSenMethod.fillingControl();
                    alertify.success('Seminuevo modificado.');
                });
                senPromise.error( function (data) {
                    alertify.error('No se ha podido modificar el seminuevo <br /> Inténtelo más tarde.');
                });
            }
        });
    },
    clickClean: function (event) {
        var senId;
        senId = +$(this).data('sen-id');
        setSenMethod.cleanSen(senId);
        setSenMethod.fillingControl();
    },
    clickRestore: function (event) {
        var senId;
        senId = +$(this).data('sen-id');
        setSenMethod.refreshSen(senId);
        setSenMethod.fillingControl(senId);
    },
    clickSeminuevosList: function (event) {
        $('body,html').animate({ scrollTop: "0" }, 999, 'easeOutExpo');
        Finch.navigate('/seminuevos');
    }
}

/* ------------------------------------------------------ *\
 [Methods] Get Seminuevos
\* ------------------------------------------------------ */

getSenMethod = {
    refreshFilters: function() {
        var agnId, usrType,
            agnData, catData, marData, mdoData;
        CAMAD.loadTemplate(tempsNames.adm_get_sen_filters, domEl.adm_div_get_sen_filters);

        usrType = GLOBALUsrType;

        switch(usrType) {
            //Admin
            case 0:
                agnId = 0;
                //Get and Load Agencies
                agnData = CAMAD.getInternalJSON(urlsApi.adm_get_agn_sen);
                CAMAD.loadTemplate(tempsNames.adm_get_sen_filters_select_agency, domEl.adm_div_select_sen_filter_agency, agnData);

                //Get Categories
                catData = {};

                //Get Brands
                marData = {};
                break;
            //User
            case 1:
                agnId = GLOBALUsrAgnId;
                //Remove Agencies
                $(domEl.adm_div_sen_filter_agency_container).remove();
                //Get Categories
                catData = CAMAD.getInternalJSON(urlsApi.adm_get_cat_sen_agn_id + agnId);
                //Get Brands
                marData = CAMAD.getInternalJSON(urlsApi.adm_get_mar_sen_agn_id + agnId);
        }

        //Load Categories
        CAMAD.loadTemplate(tempsNames.adm_get_sen_filters_select_category, domEl.adm_div_select_sen_filter_category, catData);

        //Load Brands
        CAMAD.loadTemplate(tempsNames.adm_get_sen_filters_select_brand, domEl.adm_div_select_sen_filter_brand, marData);
        $(domEl.adm_select_sen_filter_brand + ' option').data('agn-id', agnId);

        //Get and Load Models
        mdoData = {};
        CAMAD.loadTemplate(tempsNames.adm_get_sen_filters_select_model, domEl.adm_div_select_sen_filter_model, mdoData);

        $(domEl.adm_btn_sen_filters_clean).attr('disabled', true);
    },
    sortingFilters: function() {
        var senData, filtersData, url,
            sorter, sort, agnId, catId, marId, mdoId, mystery, mysteryElements, senLength;

        sorter = CAMAD.getValue($(domEl.adm__sen_sorter).find(':selected'));
        sort = CAMAD.getValue($(domEl.adm__sen_sort).filter(':checked'));

        mystery = CAMAD.getValue(domEl.adm_input_sen_filter_search);
        mystery = CAMAD.advancedTrim(mystery);
        mystery = CAMAD.replaceAll(mystery, '/', '**47**');

        agnId = (!GLOBALUsrType)
            ? CAMAD.getValue(domEl.adm_select_sen_filter_agency)
            : GLOBALUsrAgnId;

        agnId = (agnId !== '') ? +agnId : 0;

        catId = CAMAD.getValue(domEl.adm_select_sen_filter_category);
        catId = (catId !== '') ? +catId : 0;

        marId = CAMAD.getValue(domEl.adm_select_sen_filter_brand);
        marId = (marId !== '') ? +marId : 0;

        mdoId = CAMAD.getValue(domEl.adm_select_sen_filter_model);
        mdoId = (mdoId !== '') ? +mdoId : 0;

        url = urlsApi.adm_get_sen_filters + sorter + '/' + sort + '/' + agnId + '/' + catId + '/' + marId + '/' + mdoId;
        url += (mystery !== '') ? '/' + mystery : '';

        if(url !== GLOBALLastUrlPro) {

            senData = CAMAD.getInternalJSON(url);

            CAMAD.loadTemplate(tempsNames.adm_get_sen_list, domEl.adm_div_get_sen_list, senData);

            senLength = senData.camadpa.length;
            CAMAD.setHTML(domEl.adm__sen_results, senLength + ' Seminuevos');

            //Remove grid and list classes
            $(domEl.adm_id_results_holder).removeClass('results-list-view', 'results-grid-view');

            //Select the current class
            currentClass = ($(domEl.adm_id_views_list).hasClass("active"))
                ? 'results-list-view'
                : 'results-grid-view';

            //Add the current class
            $(domEl.adm_id_results_holder).addClass(currentClass);

            //The view depends on the current class
            if($(domEl.adm_id_results_holder).hasClass('results-list-view')) {
                getSenMethod.showListView();
            } else {
                getSenMethod.showGridView();
            }


            //Enable all items
            $(domEl.adm__sen_item).css('display', 'block');
            $('ul.carets li, ul.inline li, .filter-options-list li').prepend('<i class="fa fa-caret-right"></i> ');

            domElementsFormatMethods.htmlCurrency(domEl.adm__currency_h);
            domElementsFormatMethods.htmlPercentageDecimal(domEl.adm__percentage_d);

            GLOBALLastUrlSen = url;
        }

    },
    deleteSen: function(senId) {
        return CAMAD.postalService(urlsApi.adm_del_sen + senId, {});
    },
    fillingControl: function() {
        var validFieldName, dataGetSenFilters, isFull, isNoEmpty;
        validFieldName = ['sen_search', 'sen_agency', 'sen_category', 'sen_brand', 'sen_model', 'sen_sorter'];
        dataGetSenFilters = $(domEl.adm_form_get_sen_filters).serializeFormJSON();
        isEmpty = CAMAD.validFormEmpty(dataGetSenFilters, validFieldName);
        $(domEl.adm_btn_sen_filters_clean).attr('disabled', isEmpty);
    },

    //Filters Form
    changeAgency: function(event) {
        var agnId, catData, marData, mdoData;
        agnId = +CAMAD.getValue($(this));

        if(agnId) {
            catData = CAMAD.getInternalJSON(urlsApi.adm_get_cat_sen_agn_id + agnId);
            marData = CAMAD.getInternalJSON(urlsApi.adm_get_mar_sen_agn_id + agnId);
            mdoData = {};
        } else {
            catData = {};
            marData = {};
            mdoData = {};
        }

        CAMAD.loadTemplate(tempsNames.adm_get_sen_filters_select_category, domEl.adm_div_select_sen_filter_category, catData);
        CAMAD.loadTemplate(tempsNames.adm_get_sen_filters_select_model, domEl.adm_div_select_sen_filter_model, mdoData);
        CAMAD.loadTemplate(tempsNames.adm_get_sen_filters_select_brand, domEl.adm_div_select_sen_filter_brand, marData);
        $(domEl.adm_select_sen_filter_brand + ' option').data('agn-id', agnId);

        $('.selectpicker').selectpicker();

        getSenMethod.fillingControl();
        getSenMethod.sortingFilters();
    },
    changeCategory: function(event) {
        getSenMethod.fillingControl();
        getSenMethod.sortingFilters();
    },
    changeBrand: function(event) {
        var agnId, marId, mdoData, option;

        option = $(this).find(':selected');
        marId = +CAMAD.getValue(option);
        agnId = +option.data('agn-id');
        mdoData = (marId) ? CAMAD.getInternalJSON(urlsApi.adm_get_mdo_sen_mar_id + marId + '/' + agnId) : {};
        CAMAD.loadTemplate(tempsNames.adm_get_sen_filters_select_model, domEl.adm_div_select_sen_filter_model, mdoData);

        getSenMethod.fillingControl();
        getSenMethod.sortingFilters();
    },
    changeModel: function(event) {
        getSenMethod.fillingControl();
        getSenMethod.sortingFilters();
    },
    keyupSearch: function(event) {
        getSenMethod.fillingControl();
        getSenMethod.sortingFilters();
    },
    blurSearch: function(event) {
        var mystery, mysteryElements
        mystery = CAMAD.getValue($(this));
        mystery = $.trim(mystery);

        mysteryElements = mystery.split(' ');
        mysteryElements = _.without(mysteryElements, '')

        mystery = '';

        for(var idx = 0; idx < mysteryElements.length; idx ++) {
            mystery += (idx) ? ' ' + mysteryElements[idx] : mysteryElements[idx];
        }

        CAMAD.setValue($(this), mystery);
    },
    changeSorter: function (event) {
        getSenMethod.sortingFilters();
    },
    changeSort: function (event) {
        getSenMethod.sortingFilters();
    },
    clickCleanFilters: function (event) {
        //Refresh filters
        getSenMethod.refreshFilters();
        //Filling control
        getSenMethod.fillingControl();
        //Refres global url Seminuevos
        GLOBALLastUrlSen = '';
        //Regenerate table
        getSenMethod.sortingFilters();
    },


    //Seminuevo Item Actions
    clickSenActionSet: function (event) {
        var senId;
        senId = +$(this).data('sen-id');
        Finch.navigate('/set/seminuevos/' + senId);
    },
    clickSenActionDelete: function (event) {
        var senId;
        senId = +$(this).data('sen-id');
        resetAlert();
        alertify.set({
            labels: {
                ok: 'Aceptar',
                cancel: 'Cancelar'
            }
        });
        alertify.confirm('¿Seguro que desea eliminar este seminuevo?', function (e) {
            if(e) {
                var senPromise;
                senPromise = getSenMethod.deleteSen(senId);
                senPromise.success( function (data) {
                    GLOBALLastUrlSen = '';
                    getSenMethod.sortingFilters();
                    alertify.success('Se ha eliminado este seminuevo');
                });
                senPromise.error( function (data) {
                    alertify.error('No se ha podido eliminar el seminuevo <br /> Inténtelo más tarde.');
                });
            }
        });
    },

    clickShowDetails: function (event) {
        var clickGeneral, clickThis, currentDisplay, newDisplay;
        clickGeneral = $(".view-details-model").parents('.result-item').children('.result-item-in');
        clickThis = $(this).parents('.result-item').children('.result-item-in');

        currentDisplay = clickThis.css('display');
        newDisplay = (currentDisplay === 'none') ? 'block' : 'none';

        //console.log(currentDisplay);

        clickGeneral.css('display', 'none');
        clickThis.css('display', newDisplay);
    },

    //List views
    showGridView: function () {
        $(".waiting").fadeIn();
        viewsMethods.gridView();
        viewsMethods.gridViewStop();
        return false;
    },
    showListView: function () {
        $(".waiting").fadeIn();
        viewsMethods.listView();
        viewsMethods.listViewStop();
        return false;
    },

    clickGridView: function (event) {
        if(!$(this).hasClass("active")) {
            getSenMethod.showGridView();
            viewsMethods.switchActiveOption();
        }
    },
    clickListView: function (event) {
        if(!$(this).hasClass("active")) {
            getSenMethod.showListView();
            viewsMethods.switchActiveOption();
        }
    },

    //Search Form

    clickSearch: function (event) {
        $(".search-form").slideToggle();
        return false;
    },
    clickSearchAdvanced: function (event) {
        if($(this).hasClass('advanced')) {
            $(this).removeClass('advanced');
            $(".advanced-search-row").slideDown();
            CAMAD.setHTML($(this), 'Búsqueda Básica <i class="fa fa-chevron-up"></i>');
        } else {
            $(this).addClass('advanced');
            $(".advanced-search-row").slideUp();
            CAMAD.setHTML($(this), 'Búsqueda Avanzada <i class="fa fa-chevron-down"></i>');
        }
        return false;
    },
    clickCloseSearch: function (event) {
        $(".search-form").slideToggle();
        return false;
    }
}

/* ------------------------------------------------------ *\
 [Methods] Get Seminuevos
\* ------------------------------------------------------ */

pictureSenMethod = {
    pictureLoader: function (senId) {
        CAMAD.loadTemplate(tempsNames.adm_picture_sen_loader, domEl.adm_div_picture_sen_loader);
        'use strict';
        $(domEl.adm_input_picture_sen_uploader).fileupload({
            url: 'cdn/index.php?sen_id=' + senId,
            dataType: 'json',
            done: pictureSenMethod.done(senId),
            progressall: pictureSenMethod.progressall()
        });
    },
    done: function (senId) {
        return function (e, data) {
            var picPromise, files;
            resetAlert();
            alertify.set({
                labels: {
                    ok: 'Aceptar',
                    cancel: 'Cancelar'
                }
            });
            files = data.result.files;
            picPromise = CAMAD.postalService(urlsApi.adm_new_pic + senId, files);
            picPromise.success( function (data) {
                pictureSenMethod.refreshPictures(senId);
                alertify.success('Imágen agregada.');
            });
        }
    },
    progressall: function () {
        return function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width', progress + '%',
                'background-color', '#5cb85c'
            );
        }
    },
    refreshPictures: function (senId) {
        var picData;
        picData = CAMAD.getInternalJSON(urlsApi.adm_get_pic + senId);
        CAMAD.loadTemplate(tempsNames.adm_picture_sen_pictures, domEl.adm_div_picture_sen_pictures, picData);
    },
    clickActionThumb: function (event) {
        var senId, picId, picName, picData;
        senId = +$(this).data('sen-id');
        picData = $(this).data();

        resetAlert();
        alertify.set({
            labels: {
                ok: 'Aceptar',
                cancel: 'Cancelar'
            }
        });

        alertify.confirm('¿Seguro que desea elegir esta imágen como imágen previa?', function (e) {
            if(e) {
                var picPromise;
                picPromise = CAMAD.postalService(urlsApi.adm_set_thm, picData);
                picPromise.success( function (data) {
                    pictureSenMethod.refreshPictures(senId);
                    alertify.success('Nueva imágen previa seleccionada.');
                });
                picPromise.error( function (data) {
                    alertify.error('No se ha podido elegir la imagen como imágen previa <br /> Inténtelo más tarde.');
                });
            }
        });
    },
    clickActionDelete: function (event) {
        var senId, picId, picName, picData;
        senId = +$(this).data('sen-id');
        picData = $(this).data();

        resetAlert();
        alertify.set({
            labels: {
                ok: 'Aceptar',
                cancel: 'Cancelar'
            }
        });

        alertify.confirm('¿Seguro que desea eliminar esta imágen?', function (e) {
            if(e) {
                var picPromise;
                picPromise = CAMAD.postalService(urlsApi.adm_del_pic, picData);
                picPromise.success( function (data) {
                    pictureSenMethod.refreshPictures(senId);
                    alertify.success('Imágen eliminada.');
                });
                picPromise.error( function (data) {
                    alertify.error('No se ha podido eliminar la imagen <br /> Inténtelo más tarde.');
                });
            }
        });
    },
    clickSeminuevosList: function (event) {
        Finch.navigate('/seminuevos');
    }
}

/* ------------------------------------------------------ *\
 [Methods] DOM Elements Format
\* ------------------------------------------------------ */

var domElementsFormatMethods = {

    //-------------------- Real Number --------------------

    numberReal: function(number) {
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
    valueNumberReal: function(element) {
        $(element).each(function(idx) {
            var value, real;
            value = CAMAD.getValue($(this));
            real = domElementsFormatMethods.numberReal(value);
            CAMAD.setValue($(this), real);
        });
    },
    htmlNumberReal: function(element) {
        $(element).each(function(idx) {
            var html, real;
            html = CAMAD.getHTML($(this));
            real = domElementsFormatMethods.numberReal(html);
            CAMAD.setHTML($(this), real);
        });
    },

    //-------------------- Real Number --------------------

    currency: function(number) {
        var currency;
        currency = number;
        currency = CAMAD.currencyFormat(currency);
        return currency;
    },
    valueCurrency: function(element) {
        $(element).each(function(idx) {
            var value, currency;
            value = CAMAD.getValue($(this));
            currency = domElementsFormatMethods.currency(value);
            CAMAD.setValue($(this), currency);
        });
    },
    htmlCurrency: function(element) {
        $(element).each(function(idx) {
            var html, currency;
            html = CAMAD.getHTML($(this));
            currency = domElementsFormatMethods.currency(html);
            CAMAD.setHTML($(this), currency);
        });
    },

    //-------------------- Percentage Decimal --------------------

    percentageDecimal: function(number) {
        var percentage;
        percentage = +number;
        percentage *= 100;
        percentage = percentage.toFixed(2);
        percentage += '%';
        return percentage;
    },
    valuePercentageDecimal: function(element) {
        $(element).each(function(idx) {
            var value, percentage;
            value = CAMAD.getValue($(this));
            percentage = domElementsFormatMethods.percentageDecimal(value);
            CAMAD.setValue($(this), percentage);
        });
    },
    htmlPercentageDecimal: function(element) {
        $(element).each(function(idx) {
            var html, percentage;
            html = CAMAD.getHTML($(this));
            percentage = domElementsFormatMethods.percentageDecimal(html);
            CAMAD.setHTML($(this), percentage);
        });
    },

    //-------------------- Date Roman --------------------

    dateRoman: function(date, language) {
        var dateFormat, elements;
        dateFormat = CAMAD.momentToRoman(date, language);
        elements = dateFormat.split(',');
        dateFormat = elements[1];
        dateFormat = $.trim(dateFormat);
        elements = dateFormat.split(' ');
        elements.splice(2,1);
        dateFormat = elements.join(' de ');
        return dateFormat;
    },
    valueDateRoman: function(element) {
        $(element).each(function(idx) {
            var value, dateFormat;
            value = CAMAD.getValue($(this));
            dateFormat = domElementsFormatMethods.dateRoman(value, 'es');
            CAMAD.setValue($(this), dateFormat);
        });
    },
    htmlDateRoman: function(element) {
        $(element).each(function(idx) {
            var html, dateFormat;
            html = CAMAD.getHTML($(this));
            dateFormat = domElementsFormatMethods.dateRoman(html, 'es');
            CAMAD.setHTML($(this), dateFormat);
        });
    },

    //-------------------- Date Human --------------------

    dateHuman: function(date, language) {
        var dateFormat;
        dateFormat = CAMAD.momentToHuman(date, language);
        return dateFormat;
    },
    valueDateHuman: function(element) {
        $(element).each(function(idx) {
            var value, dateFormat;
            value = CAMAD.getValue($(this));
            dateFormat = domElementsFormatMethods.dateHuman(value, 'es');
            CAMAD.setValue($(this), dateFormat);
        });
    },
    htmlDateHuman: function(element) {
        $(element).each(function(idx) {
            var html, dateFormat;
            html = CAMAD.getHTML($(this));
            dateFormat = domElementsFormatMethods.dateHuman(html, 'es');
            CAMAD.setHTML($(this), dateFormat);
        });
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
        value = CAMAD.roundNDecimalFormat(value, 2);
        $(this).val(value);
    }
}

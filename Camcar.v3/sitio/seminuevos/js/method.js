/* ------------------------------------------------------ *\
 [Metodos] Variables
\* ------------------------------------------------------ */

/* ------------------------------------------------------ *\
    [Metodos] "Zone"
    
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
 [Methods] 
\* ------------------------------------------------------ */

var equalHeightsMethods = {
    equalHeightsLoad : function() {
        var maxHeight = 0;
        $(".equal-height").each( function() {
            if( $(this).height() > maxHeight ) {
                maxHeight = $(this).height();
            }
        });
        $(".equal-height").height( maxHeight );
    }
}

/* ------------------------------------------------------ *\
    [Methods] owlCarouselMethods
\* ------------------------------------------------------ */

var owlCarouselMethods = {
    owlCarousel : function ( element ) {
        $(".owl-carousel").each(function() {
            var columns, itemsDesktop, itemsDesktopSmall, itemsTablet, 
                itemsMobile, autoplay, pagination, arrows, single, style;
            //
            columns = $(this).data("columns") ? $(this).data("columns") : "1";
            itemsDesktop = $(this).data("items-desktop") ? $(this).data("items-desktop") : "4";
            itemsDesktopSmall = $(this).data("items-desktop-small") ? $(this).data("items-desktop-small") : "3";
            itemsTablet = $(this).data("items-tablet") ? $(this).data("items-tablet") : "2";
            itemsMobile = $(this).data("items-mobile") ? $(this).data("items-mobile") : "1";
            autoplay = $(this).data("autoplay") ? $(this).data("autoplay") : false;
            pagination = $(this).data("pagination") == "yes" ? true : false;
            arrows = $(this).data("arrows") == "yes" ? true : false;
            single = $(this).data("single-item") == "yes" ? true : false;
            style = $(this).data("style") ? $(this).data("style") : "fade";
            //
            $(this).owlCarousel({
                items: columns,
                autoPlay : autoplay,
                navigation : arrows,
                pagination : pagination,
                itemsDesktop : [1199, itemsDesktop],
                itemsDesktopSmall : [979, itemsDesktopSmall],
                itemsTablet : [768, itemsTablet],
                itemsMobile : [479, itemsMobile],
                singleItem : single,
                navigationText : [
                    "<i class='fa fa-chevron-left'></i>",
                    "<i class='fa fa-chevron-right'></i>"
                ],
                stopOnHover : true,
                lazyLoad : true,
                transitionStyle: "carouselStyle"
            });
        });
        $(element).owlCarousel(element);
    }
}

/* ------------------------------------------------------ *\
    [functions] loadSlider
\* ------------------------------------------------------ */

function loadSlider() {
    $(".flexslider").flexslider({
        animation: "slide",
        controlNav: "thumbnails",
        start: function(slider) {
            $("body").removeClass("loading");
        }
    });
}

/* ------------------------------------------------------ *\
    [Methods] Performance Map
\* ------------------------------------------------------ */

var performanceMapMethod = {
    cleanLocations: function (locations) {
        var locationsClean;
        locationsClean = new Object();
        locationsClean = [];
        locationsClean = CAM.withoutArrayObjOR(locations, {
            "latitud": "", 
            "longitud": ""
        });
        locationsClean = CAM.withoutArrayObjOR(locationsClean, {
            "latitud": "0", 
            "longitud": "0"
        });
        locationsClean = CAM.withoutArrayObjOR(locationsClean, {
            "latitud": 0, 
            "longitud": 0
        });
        return locationsClean;
    },
    getStyles : function() {
        //Create an array of styles.
        styles = [
            {
                "featureType": "landscape",
                "elementType": "geometry.fill",
                "stylers": [{ "color": "#ffffff" }]
            },
            {
                "featureType": "landscape.natural.terrain",
                "elementType": "geometry.fill",
                "stylers": [{ "color": "#000000" }]
            },
            {
                "featureType": "poi",
                "elementType": "geometry.fill",
                "stylers": [{ "color": "#eeeeee" }]
            },
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [{ "color": "#2ec3f3" }]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry.fill",
                "stylers": [{ "color": "#eeeeee" }]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry.stroke",
                "stylers": [{ "color": "#cccccc" }]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [{ "color": "#666666" }]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.stroke",
                "stylers": [{ "color": "#ffffff" }]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [{ "color": "#bbbbbb" }]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [{ "color": "#dddddd" }]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry.fill",
                "stylers": [{ "color": "#e5e5e5" }]
            },
            {
                "featureType": "water",
                "elementType": "geometry.fill",
                "stylers": [{ "visibility": "off" }]
            },
            {
                featureType: "poi.business",
                elementType: "labels.icon",
                stylers: [
                    { visibility: "off" }
                ]
            },
            {
                featureType: "poi.school",
                elementType: "labels.icon",
                stylers: [
                    { visibility: "off" }
                ]
            },
            {
                featureType: "poi.park",
                elementType: "labels.icon",
                stylers: [
                    { visibility: "off" }
                ]
            }
        ];
        return styles;
    },
    loadMap: function(locations, areaRender, temps, active) {
        active = (active === true) ? true : false;
        var styles, options, map, markers, bounds, infoWindows;
        //Reset Area Render
        CAM.setHTML("#" + areaRender, "");
        $("#" + areaRender).removeAttr("style");
        $("#" + areaRender).css("height", "55px");
        //Get Styles
        styles = performanceMapMethod.getStyles();
        //Init Arrays
        markers = new Array();
        infoWindows = new Array();
        bounds = new google.maps.LatLngBounds();
        //If there are maps
        if(locations.length) {
            $("#" + areaRender).css("height", "650px");
            //Make Options
            options = {
                center: new google.maps.LatLng(
                    CAM.avgArrayObjByKey(locations, "latitud"),
                    CAM.avgArrayObjByKey(locations, "longitud")
                ),
                zoom: 16,
                scrollwheel: false,
                mapTypeControlOptions: {
                    mapTypeIds: [
                        google.maps.MapTypeId.ROADMAP, 
                        "map_style"
                    ]
                }
            }
            //Generate Map with options
            map = new google.maps.Map(
                document.getElementById(areaRender), 
                options
            );
            //map.mapTypes.set("map_style", styledMap);
            //map.setMapTypeId("map_style");
            /* Properties Array */
            for(var idx = 0; idx < locations.length; idx++) {
                //marcador en el centro del mapa
                markers[idx] = new google.maps.Marker({
                    position: new google.maps.LatLng(
                        locations[idx].latitud, 
                        locations[idx].longitud
                    ),
                    map: map,
                    icon: locations[idx].icon,
                    title: "ubicación",
                    animation: google.maps.Animation.DROP
                });
                bounds.extend(markers[idx].getPosition());
                infoWindows[idx] = new google.maps.InfoWindow({
                    content: CAM.getTemplate(
                        temps["map_infobox"],
                        locations[idx]
                    )
                });
                attachInfoWindowToMarker(map, markers[idx], infoWindows[idx], active);
            }
            //
            map.fitBounds(bounds);
        } else {
            CAM.loadTemplate(temps["map_empty"], "#" + areaRender);
        }
        /* function to attach infowindow with marker */
        function attachInfoWindowToMarker(map, marker, infoWindow, active) {
            if(active) {
                infoWindow.open(map, marker);
            }
            google.maps.event.addListener(marker, "click", function() {
                infoWindow.open(map, marker);
            });
        }
    },
}

/* ------------------------------------------------------ *\
 [Methods] Get Seminuevos
\* ------------------------------------------------------ */

getSenMethod = {
    marName: "",
    mdoName: "",
    mystery: "",
    initVars: function () {
        getSenMethod.marName = $(domEl.select_sen_get_brand).find(":selected").data("name-short");
        getSenMethod.mdoName = $(domEl.select_sen_get_model).find(":selected").data("name-short");
        getSenMethod.mystery = CAM.getValue(domEl.input_sen_get_searching);
    },
    resetVars: function () {
        getSenMethod.marName = "";
        getSenMethod.mdoName = "";
        getSenMethod.mystery = "";
    },
    changeBrand: function (event) {
        var urlSen, mdoData;
        getSenMethod.initVars();
        //
        urlSen = CAM.getValue(domEl.input_master_seminuevos);
        mdoData = (getSenMethod.marName !== "") 
            ? CAM.getInternalJSON(urlSen + urlsApi.get_mdo + getSenMethod.marName) 
            : {};
        CAM.loadTemplate(tempsNames.seminuevos_action_bar_modelos, domEl.div_get_models, mdoData);
        $(".selectpicker").selectpicker();
    },
    changeModel: function (event) {
        getSenMethod.initVars();
    },
    blurSearching: function (event) {
        CAM.setValue($(this), CAM.advancedTrim(CAM.getValue($(this))));
        getSenMethod.initVars();
    },
    clickSearch: function(event) {
        var urlInv;
        getSenMethod.initVars();
        urlInv = CAM.getValue(domEl.input_master_inventarios);
        urlInv = urlInv.substring(0, urlInv.length - 1);
        if(getSenMethod.mystery !== "") {
            urlInv += (getSenMethod.marName !== "") ? "/" + getSenMethod.marName : "/0";
            urlInv += (getSenMethod.mdoName !== "") ? "/" + getSenMethod.mdoName : "/0";
            urlInv += "/" + getSenMethod.mystery;
        } else {
            urlInv += (getSenMethod.marName !== "") ? "/" + getSenMethod.marName : "";
            urlInv += (getSenMethod.mdoName !== "") ? "/" + getSenMethod.mdoName : "";
        }
        getSenMethod.resetVars();
        window.location.href = urlInv;
    }
}

/* ------------------------------------------------------ *\
 [Methods] Detail Seminuevos
\* ------------------------------------------------------ */

detailSenMethod = {

    //MAPA SECTION

    readMap: function () {
        performanceMapMethod.loadMap(
            [$(domEl.div_map_canvas_detalle).data()], 
            "map-canvas-detalle",
            {
                "map_infobox": tempsNames.detalle_map_infobox,
                "map_empty": tempsNames.detalle_map_empty
            },
            true
        );
    },

    //CONTACTO SECTION
    sendLeads: function() {
        var data, dataRenamed;
        data = $(domEl.form_detail_sen_contact).serializeFormJSON();
        dataRenamed = CAM.renameArrayObjKeys([data], {
            "name": "sen_name",
            "lastname": "sen_lastname",
            "email": "sen_email",
            "phone": "sen_phone",
            "comment": "sen_message"
        });
        dataRenamed = dataRenamed[0];
        dataRenamed["product"] = data["sen_mar"] + " - " + data["sen_mdo"] + " - " + data["sen_year"];
        dataRenamed["news"] = "0";
        dataRenamed["business_max"] = "23";
        dataRenamed["origen_type"] = "2";
        dataRenamed["campaign_max"] = "Seminuevos CAMCAR";
        dataRenamed["web_max"] = window.location.href;
        dataRenamed["exit_web"] = window.location.href;
        return CAM.postalService('http://clicktolead.com.mx/api/v1/remote/action', dataRenamed);
    },
    handlerPromiseSend: function (data1) {
        var contactAddPromise;
        contactAddPromise = detailSenMethod.addContacto();
        contactAddPromise.success( function (data2) {
            detailSenMethod.resetContacto();
            alertify.success("Datos enviados.");
        });
        contactAddPromise.error( function (data2) {
            detailSenMethod.resetContacto();
            alertify.error("No se ha podido enviar los datos <br /> Inténtelo más tarde.");
        });
    },
    handlerPromiseLeads: function (data) {
        var contactSndPromise;
        contactSndPromise = detailSenMethod.sendContacto();
        contactSndPromise.success(detailSenMethod.handlerPromiseSend);
        contactSndPromise.error(detailSenMethod.handlerPromiseSend);
    },
    sendContacto: function () {
        var urlSen, data;
        data = $(domEl.form_detail_sen_contact).serializeFormJSON();
        urlSen = CAM.getValue(domEl.input_master_seminuevos);
        return CAM.postalService(urlSen + urlsApi.snd_cnt, data);
    },
    addContacto: function () {
        var senId, urlSen, data;
        data = $(domEl.form_detail_sen_contact).serializeFormJSON();
        data = CAM.renameArrayObjKeys([data], {
            "cnt_nombre": "sen_name",
            "cnt_apellido": "sen_lastname",
            "cnt_mail": "sen_email",
            "cnt_mail_to": "sen_email_send",
            "cnt_telefono": "sen_phone",
            "cnt_comentario": "sen_message"
        });
        data = data[0];
        senId = $(domEl.form_detail_sen_contact).data("sen-id");
        urlSen = CAM.getValue(domEl.input_master_seminuevos);
        return CAM.postalService(urlSen + urlsApi.add_cnt + senId, data);
    },
    resetContacto: function () {
        CAM.resetForm(domEl.form_detail_sen_contact);
    },
    fillingControl: function() {
        var validFieldName, data, isFull;
        validFieldName = ["sen_name", "sen_lastname", "sen_email", "sen_phone", 
                          "sen_message", "sen_email_send", "sen_concessionary", 
                          "sen_logo", "sen_agn_logo", "sen_mar", "sen_mdo", 
                          "sen_year", "sen_pic"];
        data = $(domEl.form_detail_sen_contact).serializeFormJSON();
        isFull = CAM.validFormFull(data, validFieldName);
        $(domEl.btn_detail_sen_send).attr("disabled", !isFull);
    },
    keyupElement: function (event) {
        detailSenMethod.fillingControl();
    },
    clickSend: function (event) {
        var leadsPromise;
        leadsPromise = detailSenMethod.sendLeads();
        leadsPromise.success(detailSenMethod.handlerPromiseLeads);
        leadsPromise.error(detailSenMethod.handlerPromiseLeads);
    }

}

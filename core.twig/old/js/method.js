/*
  In this file will be present most of the hard programming and performance of
  The web application, here is the hard logic, handlers methods of the
  DOM elements events.
  This section is used to declare global variables, with values used Throughout
  The system, especially those that keeps session variable values from php
*/


/* ------------------------------------------------------ *\
 [Variables] 'Zone'
\* ------------------------------------------------------ */



//var variable;




/* ------------------------------------------------------ *\
 [functions] 'Zone'
 function nameFunction (arg) {
 }
\* ------------------------------------------------------ */







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
 [functions] 'Zone'
 var Method = {
 function_name : function(event) {}
 }

 for event name event handlers methods use indicate the name
 of the event and the element afected
\* ------------------------------------------------------ */



/*Make a group of methods for each url defined in room.js, in order to control the elements events,
  and the porformance of  each section.
  Depending on the complexity of the url, could be more than one group of methods.
  Could exist some group of general methods*/

/* ------------------------------------------------------ *\
 [Methods] Home
\* ------------------------------------------------------ */

//This group of methods will be not used it's only example, remove it later
/*var demoMethods = {
    changeLan : function (event) {
        var lan, date, newDate;
        lan = PRO.getValue($(this));
        date = $(domEl.h3_demo_date).data('date');
        newDate = PRO.momentToRoman(date, lan);
        $(domEl.h3_demo_date).text(newDate);
    }
}*/

var openMenuMethods = {
    clickOpenMenu : function () {
        $('nav').toggleClass('open-menu');
    }
}
var closeMenuMethods = {
    clickClose : function () {
        $('nav').removeClass('open-menu');
    }
}
var initMapMethods = {
    initialize : function (data) {
      var mapOptions3 = {
                center: new google.maps.LatLng(20.665582,-103.431807),//Universidad
                zoom: 17,mapTypeId: google.maps.MapTypeId.ROADMAP};
              var map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions3);

        //marcador con la ubicación de la Universidad
        //var place = new google.maps.LatLng(20.6671949,-103.4309215);
        /*var marker = new google.maps.Marker({
          position: place
          , map: map
          , title: 'Pulsa aquí'
          , animation: google.maps.Animation.DROP,});*/

        //marcador en el centro del mapa
        var marker2 = new google.maps.Marker({
            position: map.getCenter(),
            map: map,
            title: 'Direct Express',
            icon: "img/round-pointers-pin-vw.png" //custom pin icon
        });


           //globo de informacion del marcador 2
        var agn_img, agn_name, agn_address;
        agn_img = 'logo_dex_vlks.png';
        agn_name = "Direct Express Sanzio";
        agn_address = 'Av. Rafael Sanzio #578 Arcos de Guadalupe 45037 Zapopan, Jal.';

        var popup = new google.maps.InfoWindow({
          content: '<div class="marker-info-win" style="text-align: center;">'+
                    '<div class="marker-inner-win"><span class="info-content">'+
                    '<img src="img/'+agn_img+'" alt="Logo Jaguar Land Rover" >'+
                    '<h5 class="marker-heading" style="color:#000; padding: 0px; margin: 0px;">'+agn_name+'</h5>'+
                    '<span>'+agn_address+'</span>' +
                    '</span>'+
                    '</div></div>'});
        popup.open(map, marker2);



      /*
      var styles = [
          {
              "stylers": [
                  { "saturation": -100 },
                  { "hue": "#00e5ff" }
              ]
              },{
                  "elementType": "labels.text.stroke",
                  "stylers": [
                  { "visibility": "visibile" }
              ]
          }
      ];
      var myLatlng = new google.maps.LatLng(20.6671949,-103.4309215);

      var styledMap = new google.maps.StyledMapType(styles,{name: "Styled Map"});

      // Create a map object, and include the MapTypeId to add
      // to the map type control.
      var mapOptions = {
        backgroundColor: '#ffffff',
        center: new google.maps.LatLng( ﻿20.6671949,-103.4309215),
        zoom: 17,
        panControl: false, //enable pan Control
        zoomControl: false, //enable zoom control
        scaleControl: false, // enable scale control
        mapTypeControlOptions: {
            mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
        }
      };

      var map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

      var marker = new google.maps.Marker({
          position: myLatlng,
          map: map,
          title: 'Direct Express',
          icon: "img/pinlocation.png" //custom pin icon
      });

      var agn_img, agn_name, agn_address;

      agn_img = 'logo_dex_vlks.png';
      agn_name = "Direct Express Sanzio";
      agn_address = 'Av. Rafael Sanzio #578 Arcos de Guadalupe 45037 Zapopan, Jal.';

      //Content structure of info Window for the Markers
      var contentString = $('<div class="marker-info-win" style="text-align: center;">'+
      '<div class="marker-inner-win"><span class="info-content">'+
      '<img src="img/'+agn_img+'" alt="Logo Jaguar Land Rover" style="margin-botton: 10px;">'+
      '<h5 class="marker-heading" style="color:#000; padding: 0px; margin: 0px;">'+agn_name+'</h5>'+
      '<span>'+agn_address+'</span>' +
      '</span>'+
      '</div></div>');
      //Create an infoWindow
      var infowindow = new google.maps.InfoWindow();

      //set the content of infoWindow
      infowindow.setContent(contentString[0]);
      infowindow.open(map,marker); // click on marker opens info window
      */
      //add click event listener to marker which will open infoWindow
      /*google.maps.event.addListener(marker, 'click', function() {
          infowindow.open(map,marker); // click on marker opens info window
      });*/

      //Associate the styled map with the MapTypeId and set it to display.
      /*
      map.mapTypes.set('map_style', styledMap);
      map.setMapTypeId('map_style');*/
    },
    loadInit : function () {
        google.maps.event.addDomListener(window, 'load', initMapMethods.initialize());

    }
}

var contactMethods = {
    clickSend: function(event) {
        var form_contact, dataForm_contact;

        dataForm_contact = $('#form_contact').serializeFormJSON();

        console.log(urlsApi.postContact, dataForm_contact);

        form_contact = DEX.postalService(urlsApi.postContact, dataForm_contact);

        form_contact.success(function(data){
            console.log("Correo Enviado...");
            console.log(data);

            DEX.resetForm('#form_contact');

            Finch.navigate('/');
            console.log(Finch);

        });
        form_contact.error(function(data){
            console.log("Correo no Enviado...");
            console.log(data);
            DEX.resetForm('#form_contact');
        });
    }
}
/* ------------------------------------------------------ *\
 [Methods] inputVal
\* ------------------------------------------------------ */

var inputValMetdods = {
    isIntegerKP: function (event) {
        return /\d/.test(String.fromCharCode(event.keyCode));
    }
}


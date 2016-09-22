/*
    In this section will be added some necessary functions and code when
    the page loads and is ready.
    The manage of the DOM elements events will be here too.
*/

$(document).ready(function() {
    // Add favicon
    window.onload = function() {
      favicon.change("volkswagen.ico");
      // Uncomment to see how change() will cancel the animation
       setTimeout(function() { favicon.change("volkswagen.ico") }, 10000);
    }
    // Load title <title>NAME</titla>
    $("head title").prepend("Direct Express");

    $(window).scroll(function(){
        if($(window).scrollTop() > 0){
            $('nav').addClass('scrolled');
        }else{
            $('nav').removeClass('scrolled');
        }
    });

    // Hover BG Effect

    if (!(/Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i).test(navigator.userAgent || navigator.vendor || window.opera)) {
        skrollr.init({
            forceHeight: false
        });

        // Fixed header scrolling

        $(window).scroll(function(){
            if($(window).scrollTop() < $('.fixed-header').outerHeight()){
                var scroll = $(window).scrollTop();
                $('.fixed-header').css({transform: 'translateY('+scroll/1.2+'px)'});
                $('.fixed-header .container').css('opacity',(1-(scroll/400)));
            }
        });


        // Hover BG Effect

        $('.hover-background').each(function(){
            $(this).mousemove(function( event ) {
                $(this).find('.background-image-holder').css('transform', 'translate(' + -event.pageX /18 + 'px,' + -(event.pageY-($(window).scrollTop())) /50+ 'px)');
                $(this).find('.layer-1').css('transform', 'translate(' + -event.pageX /30 + 'px,' + -event.pageY /30+ 'px)');
                $(this).find('.layer-2').css('transform', 'translate(' + -event.pageX /20 + 'px,' + -event.pageY /20+ 'px)');
            });
        });
    }
    $('.hero-slider').flexslider({ directionNav: false });

    // Smooth scroll to inner links

    if($('nav').hasClass('nav-2')){
        $('.inner-link').smoothScroll({
            offset: -55,
            speed: 800
        });
    }else{
        var navHeight = $('nav').outerHeight();
        $('.inner-link').smoothScroll({
            offset: -navHeight,
            speed: 800
        });
    }

    // Make map draggable when click
    $(window).scroll(function(){
        $('.map-holder').removeClass('disable-overlay');
    });

    /* ------------------------------------------------------ *\
     [METHOS Control] Serialize Form
    \* ------------------------------------------------------ */

    //This method change a form into a JSON
    $.fn.serializeFormJSON = function() {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    /* ------------------------------------------------------ *\
     [METHOS Control] Currency Format
    \* ------------------------------------------------------ */

    Number.prototype.format = function(n, x) {
        var re = '(\\d)(?=(\\d{' + (x || 3) + '}) + ' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$1,');
    };



    /* ------------------------------------------------------ *\
        EVENT CONTROL
    \* ------------------------------------------------------ */


    //Make a group of events for each url defined in room.js, each one of
    //These events has to be handled by one of the methods defined in the related
    //Group in methods.js

    $('.mobile-toggle').on('click', openMenuMethods.clickOpenMenu);

    $('#home-link').on('click', closeMenuMethods.clickClose);
    $('#pricing-link').on('click', closeMenuMethods.clickClose);
    $('#contact-link').on('click', closeMenuMethods.clickClose);

    $(domEl.div_recurrent).on("click", '.map-holder', function(){
        $(this).addClass('disable-overlay');
    });

    $('#contact_send').on('click', contactMethods.clickSend);

    /* ------------------------------------------------------ *\
     [Methods] DEMO'
    \* ------------------------------------------------------ */

    //This group of events will not be used, they are only example, remove later

    //$(domEl.div_recurrent).on('change', domEl.select_lan_demo, demoMethods.changeLan);


});

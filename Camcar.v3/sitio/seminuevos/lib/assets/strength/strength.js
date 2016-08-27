/*!
 * strength.js
 * Original author: @aaronlumsden
 * Further changes, comments: @aaronlumsden
 * Licensed under the MIT license
 */
;(function ( $, window, document, undefined ) {
    var pluginName, defaults
    pluginName = "strength";
    defaults = {
        strengthClass: 'strength',
        strengthMeterClass: 'strength_meter',
        strengthButtonClass: 'button_strength',
        strengthButtonText: 'Show Password',
        strengthButtonTextToggle: 'Hide Password'
    };
    // $('<style>body { background-color: red; color: white; }</style>').appendTo('head');

    function Plugin( element, options ) {
        this.element = element;
        this.$elem = $(this.element);
        this.options = $.extend( {}, defaults, options );
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype = {

        init: function() {
            var characters, capitalletters, loweletters, number, special, upperCase, lowerCase, numbers, specialchars;
            characters = 0;
            capitalletters = 0;
            loweletters = 0;
            number = 0;
            special = 0;

            upperCase = new RegExp('[A-Z]');
            lowerCase = new RegExp('[a-z]');
            numbers = new RegExp('[0-9]');
            specialchars = new RegExp('([!,%,&,@,#,$,^,*,?,_,~])');

            function GetPercentage(a, b) {
                return ((b / a) * 100);
            }
            function check_strength(thisval,thisid){
                var total, totalpercent;
                if (thisval.length > 8) { 
                    characters = 1;
                    //$('#length').removeClass('valid').addClass('invalid');
                } else { 
                    characters = -1; 
                    //$('#length').removeClass('invalid').addClass('valid');
                };
                if (thisval.match(upperCase)) { 
                    capitalletters = 1;
                    $('#capital').removeClass('invalid').addClass('valid');
                } else { 
                    capitalletters = 0; 
                    $('#capital').removeClass('valid').addClass('invalid');
                };
                if (thisval.match(lowerCase)) { 
                    loweletters = 1;
                    $('#letter').removeClass('invalid').addClass('valid');
                } else { 
                    loweletters = 0; 
                    $('#letter').removeClass('valid').addClass('invalid');
                };
                if (thisval.match(numbers)) { 
                    number = 1;
                    $('#number').removeClass('invalid').addClass('valid');
                } else { 
                    number = 0;
                    $('#number').removeClass('valid').addClass('invalid');
                };

                total = characters + capitalletters + loweletters + number + special;
                totalpercent = GetPercentage(7, total).toFixed(0);

                if (!thisval.length) {total = -1;}

                get_total(total,thisid);
            }
            function get_total(total,thisid){
                var strength, thismeter, spanthismeter;
                strength = $('.strength_meter');
                strength.css('height', 'auto');
                thismeter = $('div[data-class="'+thisid+'"]');
                spanthismeter = $('span[data-meter="'+thisid+'"]');
                
                if (total <= 1) {
                   thismeter.removeClass();
                   thismeter.addClass('thismeter veryweak');
                   spanthismeter.html('muy débil');
                } else if (total == 2){
                   thismeter.removeClass();
                   thismeter.addClass('thismeter weak');
                   spanthismeter.html('débil');
                } else if(total == 3){
                   thismeter.removeClass();
                   thismeter.addClass('thismeter medium');
                   spanthismeter.html('medio');
                } else {
                    strength.css('height', 'auto');
                    thismeter.removeClass();
                    thismeter.addClass('thismeter strong');
                    spanthismeter.html('fuerte');
                }
                if (total == -1) { 
                    strength.css('height', '0');
                    thismeter.removeClass();
                    spanthismeter.html('');
                }
            }
            var isShown, strengthButtonText, strengthButtonTextToggle
            isShown = false;
            strengthButtonText = this.options.strengthButtonText;
            strengthButtonTextToggle = this.options.strengthButtonTextToggle;

            thisid = this.$elem.attr('id');

            this.$elem.addClass(this.options.strengthClass).attr('data-password',thisid).after('<input style="display:none" class="'+this.options.strengthClass+'" data-password="'+thisid+'" type="text" name="" value=""><a data-password-button="'+thisid+'" href="" class="'+this.options.strengthButtonClass+'">'+this.options.strengthButtonText+'</a><div class="'+this.options.strengthMeterClass+'"><div data-class="'+thisid+'" class="thismeter"><span data-meter="'+thisid+'"></span></div></div>');
             
            this.$elem.bind('keyup keydown', function(event) {
                thisval = $('#'+thisid).val();
                $('input[type="text"][data-password="'+thisid+'"]').val(thisval);
                check_strength(thisval,thisid);                
            }).focus(function() {
                $('#pswd_info').addClass('pswd_info_active').removeClass('pswd_info_disable').show();
            }).blur(function() {
                $('#pswd_info').removeClass('pswd_info_active').addClass('pswd_info_disable').hide();
            });

             $('input[type="text"][data-password="'+thisid+'"]').bind('keyup keydown', function(event) {
                thisval = $('input[type="text"][data-password="'+thisid+'"]').val();
                console.log(thisval);
                $('input[type="password"][data-password="'+thisid+'"]').val(thisval);
                check_strength(thisval,thisid);
            });
            $(document.body).on('click', '.'+this.options.strengthButtonClass, function(e) {
                e.preventDefault();
                thisclass = 'hide_'+$(this).attr('class');
                if (isShown) {
                    $('input[type="text"][data-password="'+thisid+'"]').hide();
                    $('input[type="password"][data-password="'+thisid+'"]').show().focus();
                    $('a[data-password-button="'+thisid+'"]').removeClass(thisclass).html(strengthButtonText);
                    isShown = false;
                } else {
                    $('input[type="text"][data-password="'+thisid+'"]').show().focus();
                    $('input[type="password"][data-password="'+thisid+'"]').hide();
                    $('a[data-password-button="'+thisid+'"]').addClass(thisclass).html(strengthButtonTextToggle);
                    isShown = true;
                }               
            });
        },
        yourOtherFunction: function(el, options) {
            // some logic
        }
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin( this, options ));
            }
        });
    };

})( jQuery, window, document );



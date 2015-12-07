$(document).ready(function() {
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

    /* ------------------------------------------------------ *\
     [Methods] DEMO'
    \* ------------------------------------------------------ */
    //$(domEl.div_recurrent).on('change', domEl.select_lan_demo, demoMethods.changeLan);
    //$('body').on('click', '#addScnt', addText.appendTagInput);
    //$('body').on('click', '#remScnt', addText.removeTagInpput);
    $('body').on('click', '#main-compiler-camcar-v1 form', compiler_phpobjectjs_method.compiler_phpobjectjs_camcar_v1);
    $('body').on('click', '#main-compiler-camcar-v2 form', compiler_phpobjectjs_method.compiler_phpobjectjs_camcar_v2);
    
});

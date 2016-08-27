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
                o[this.name].push(this.value || "");
            } else {
                o[this.name] = this.value || "";
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
     [Methods] 'Get Seminuevos'
    \* ------------------------------------------------------ */

    $(domEl.div_recurrent).on("change", domEl.select_sen_get_brand, getSenMethod.changeBrand);
    $(domEl.div_recurrent).on("change", domEl.select_sen_get_model, getSenMethod.changeModel);
    $(domEl.div_recurrent).on("blur", domEl.input_sen_get_searching, getSenMethod.blurSearching);
    $(domEl.div_recurrent).on("click", domEl.btn_sen_get_search, getSenMethod.clickSearch);

    /* ------------------------------------------------------ *\
     [Methods] "Detail Seminuevos"
    \* ------------------------------------------------------ */

    $(domEl.div_recurrent).on("keyup", domEl._detail_sen_element, detailSenMethod.keyupElement);
    $(domEl.div_recurrent).on("click", domEl.btn_detail_sen_send, detailSenMethod.clickSend);

});

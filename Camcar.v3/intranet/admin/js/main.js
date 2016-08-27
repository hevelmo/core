$(document).ready(function() {

    // Add favicon
    window.onload = function() {
        favicon.change("../../resources/public/img/camcaricon.ico");
        // Uncomment to see how change() will cancel the animation
        setTimeout(function() { favicon.change("../../resources/public/img/camcaricon.ico") }, 10000);
    }

    /* ------------------------------------------------------ *\
     [Funciones Control] Serialize Form
    \* ------------------------------------------------------ */

    //This method changes a form into a JSON
    $.fn.serializeFormJSON = function() {
        var o = {};
        var a = this.serializeArray();

        $.each(a, function() {
            if(o[this.name]) {
                if(!o[this.name].push) {
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
     [Funciones Control] Currency Format
    \* ------------------------------------------------------ */

    Number.prototype.format = function(n, x) {
        var re = '(\\d)(?=(\\d{' + (x || 3) + '}) + ' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$1,');
    };

    $(window).resize(function() {
        __sizeCheck($(this));
    });

    /* ------------------------------------------------------ *\
     [Funciones Control] Hidding and Showing divs
    \* ------------------------------------------------------ */

    $(domEl.adm_div_recurrent).on('click', '.utility-bar .container .row .tools .fa', function () {
        var delay, element;
        delay = 100;
        element = $(this).parents(".utility-box").children(".large-pad");
        if($(this).hasClass("fa-chevron-down")) {
            $(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
            element.slideUp(delay);
        } else {
            $(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
            element.slideDown(delay);
        }
    });

    if($(domEl.adm_id_results_holder).hasClass("results-list-view")) {
        viewsMethods.results;
    }

    /* ------------------------------------------------------ *\
     [Methods] 'Open menu'
    \* ------------------------------------------------------ */

    $('body').on('click', '.mobile-toggle', openMenuMethods.clickOpenMenu);

    /* ------------------------------------------------------ *\
     [Methods] 'Close menu'
    \* ------------------------------------------------------ */

    $('body').on('click', '#return-index', closeMenuMethods.clickClose);
    $('body').on('click', '#go-add-pre-owned', closeMenuMethods.clickClose);
    $('body').on('click', '#go-list-pre-owned', closeMenuMethods.clickClose);

    /* ------------------------------------------------------ *\
     [Methods] 'Get Seminuevos'
    \* ------------------------------------------------------ */

    $(domEl.adm_div_recurrent).on('change', domEl.adm_select_sen_filter_agency, getSenMethod.changeAgency);
    $(domEl.adm_div_recurrent).on('change', domEl.adm_select_sen_filter_category, getSenMethod.changeCategory);
    $(domEl.adm_div_recurrent).on('change', domEl.adm_select_sen_filter_brand, getSenMethod.changeBrand);
    $(domEl.adm_div_recurrent).on('change', domEl.adm_select_sen_filter_model, getSenMethod.changeModel);
    $(domEl.adm_div_recurrent).on('keyup', domEl.adm_input_sen_filter_search, getSenMethod.keyupSearch);
    $(domEl.adm_div_recurrent).on('blur', domEl.adm_input_sen_filter_search, getSenMethod.blurSearch);
    $(domEl.adm_div_recurrent).on('click', domEl.adm_btn_sen_filters_clean, getSenMethod.clickCleanFilters);
    $(domEl.adm_div_recurrent).on('change', domEl.adm__sen_sorter, getSenMethod.changeSorter);
    $(domEl.adm_div_recurrent).on('change', domEl.adm__sen_sort, getSenMethod.changeSort);
    $(domEl.adm_div_recurrent).on('click', domEl.adm__sen_action_delete, getSenMethod.clickSenActionDelete);
    $(domEl.adm_div_recurrent).on('click', domEl.adm__sen_action_set, getSenMethod.clickSenActionSet);

    /* ------------------------------------------------------ *\
     [Methods] 'List Views'
    \* ------------------------------------------------------ */

    $(domEl.adm_div_recurrent).on('click', domEl.adm_id_views_grid, getSenMethod.clickGridView);
    $(domEl.adm_div_recurrent).on('click', domEl.adm_id_views_list, getSenMethod.clickListView);

    /* ------------------------------------------------------ *\
     [Methods] 'Search Form'
    \* ------------------------------------------------------ */

    $(domEl.adm_div_recurrent).on("click", ".search-trigger", getSenMethod.clickSearch);
    $(domEl.adm_div_recurrent).on("click", "#close-panel", getSenMethod.clickCloseSearch);
    $(domEl.adm_div_recurrent).on("click", '.search-advanced-trigger', getSenMethod.clickSearchAdvanced);
    $(domEl.adm_div_recurrent).on( "click", ".view-details-model", getSenMethod.clickShowDetails);


    /* ------------------------------------------------------ *\
     [Methods] 'New Seminuevos'
    \* ------------------------------------------------------ */

    $(domEl.adm_div_recurrent).on('keypress', domEl.adm_input_new_sen_price, inputValMetdods.isDecimalKP);
    $(domEl.adm_div_recurrent).on('blur', domEl.adm_input_new_sen_price, inputValMetdods.roundDecimalBlur);

    $(domEl.adm_div_recurrent).on('keypress', domEl.adm_input_new_sen_mileage, inputValMetdods.isDecimalKP);
    $(domEl.adm_div_recurrent).on('blur', domEl.adm_input_new_sen_mileage, inputValMetdods.roundDecimalBlur);

    $(domEl.adm_div_recurrent).on('change', domEl.adm_select_new_sen_brand, newSenMethod.changeBrand);
    $(domEl.adm_div_recurrent).on('change', domEl.adm_select_new_sen_select, newSenMethod.changeSelect);
    $(domEl.adm_div_recurrent).on('keyup', domEl.adm_input_new_sen_input, newSenMethod.keyupInput);
    $(domEl.adm_div_recurrent).on('keyup', domEl.adm_txta_new_sen_description, newSenMethod.keyupDescription);
    $(domEl.adm_div_recurrent).on('click', domEl.adm_btn_new_sen_clean, newSenMethod.clickClean);
    $(domEl.adm_div_recurrent).on('click', domEl.adm_btn_new_sen_save, newSenMethod.clickSave);
    $(domEl.adm_div_recurrent).on('click', domEl.adm_btn_new_sen_seminuevos_list, newSenMethod.clickSeminuevosList);

    /* ------------------------------------------------------ *\
     [Methods] 'Set Seminuevos'
    \* ------------------------------------------------------ */

    $(domEl.adm_div_recurrent).on('keypress', domEl.adm_input_set_sen_price, inputValMetdods.isDecimalKP);
    $(domEl.adm_div_recurrent).on('blur', domEl.adm_input_set_sen_price, inputValMetdods.roundDecimalBlur);

    $(domEl.adm_div_recurrent).on('keypress', domEl.adm_input_set_sen_mileage, inputValMetdods.isDecimalKP);
    $(domEl.adm_div_recurrent).on('blur', domEl.adm_input_set_sen_mileage, inputValMetdods.roundDecimalBlur);

    $(domEl.adm_div_recurrent).on('change', domEl.adm_select_set_sen_brand, setSenMethod.changeBrand);
    $(domEl.adm_div_recurrent).on('change', domEl.adm_select_set_sen_select, setSenMethod.changeSelect);
    $(domEl.adm_div_recurrent).on('keyup', domEl.adm_input_set_sen_input, setSenMethod.keyupInput);
    $(domEl.adm_div_recurrent).on('keyup', domEl.adm_txta_set_sen_description, setSenMethod.keyupDescription);
    $(domEl.adm_div_recurrent).on('click', domEl.adm_btn_set_sen_clean, setSenMethod.clickClean);
    $(domEl.adm_div_recurrent).on('click', domEl.adm_btn_set_sen_save, setSenMethod.clickSave);
    $(domEl.adm_div_recurrent).on('click', domEl.adm_btn_set_sen_restore, setSenMethod.clickRestore);
    $(domEl.adm_div_recurrent).on('click', domEl.adm_btn_set_sen_seminuevos_list, setSenMethod.clickSeminuevosList);

    /* ------------------------------------------------------ *\
     [Methods] 'Pictures Seminuevos'
    \* ------------------------------------------------------ */

    $(domEl.adm_div_recurrent).on('click', domEl.adm_btn_picture_sen_seminuevos_list, pictureSenMethod.clickSeminuevosList);
    $(domEl.adm_div_recurrent).on('click', domEl.adm__picture_sen_action_thumb, pictureSenMethod.clickActionThumb);
    $(domEl.adm_div_recurrent).on('click', domEl.adm__picture_sen_action_delete, pictureSenMethod.clickActionDelete);

});

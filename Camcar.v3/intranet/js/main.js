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

    $(domEl.recurrent_body).on('click', domEl.dropdown_animate_nav_header, animateNavMethod.animateNav);

    $(domEl.recurrent_body).on('click', '#menu_bar_toggle', toggleMenuBarMethod.toggleMenuBar);

    //SLIDEPANEL
    $(domEl.div_recurrent).on('click', domEl._widget_toggle_slide_panel_agreement_other_brands, handleSlidePanelMethods.toggleSlediPanel_agreementOtherBrands);
    //CLOSE SLIDEPANEL
    $(domEl.recurrent_body).on('click', domEl._close_slide_panel, handleSlidePanelMethods.clickCloseSlidePanel);
    //$(document).on('click', handleSlidePanelMethods.documentCloseSPanel);
    //MODAL PREVIEW INFO
    $(domEl.recurrent_body).on('click', '.modal-preview-info', handleSlidePanelMethods.previewInfo);

    //AGREEMENTS
    $(domEl.div_recurrent).on('click', '#go-brands-agreements', goSectionMethods.goSection_brands_agreements);

    //SECTIONS
    $(domEl.recurrent_body).on('click', domEl.go_section_home, goSectionMethods.goSection_home);
    $(domEl.recurrent_body).on('click', domEl.go_section_agreement, goSectionMethods.goSection_agreement);
    $(domEl.recurrent_body).on('click', domEl.go_section_directory, goSectionMethods.goSection_directory);

    //DIRECTORY
    $(domEl.div_recurrent).on('keypress', domEl.input_directory_search, viewSectionWelcomeDirectoryMethods.keypressSearch);
    $(domEl.div_recurrent).on('keyup', domEl.input_directory_search, viewSectionWelcomeDirectoryMethods.keyupSearch);
    $(domEl.div_recurrent).on('blur', domEl.input_directory_search, viewSectionWelcomeDirectoryMethods.blurSearch);
    $(domEl.div_recurrent).on('click', domEl.btn_directory_search, viewSectionWelcomeDirectoryMethods.clickSearch);
    $(domEl.div_recurrent).on('click', domEl.div_mar_directory, viewSectionWelcomeDirectoryMethods.clickMarca);
    $(domEl.div_recurrent).on('click', domEl._epy_sorter, viewSectionWelcomeDirectoryMethods.clickSorter);

    $(domEl.div_recurrent).on('click', '.page-aside-switch', viewSectionWelcomeDirectoryMethods.has_isOpen);

    //CALL MODAL OVERLAY
    $(domEl.div_recurrent).on('click', '.call-modal-overlay.birthday', callModalOverlayMethod.callModalOverlayBirthday);
    $(domEl.div_recurrent).on('click', '.call-modal-overlay.directory', callModalOverlayMethod.callModalOverlayDirectory);
    //CLOSE MODAL OVERLAY
    $('body').on('click', '#boxclose', callModalOverlayMethod.closeModalOverlay);
    //SEND FORM BIRTHDAY
    $('body').on('keyup', domEl.field_cum_send_message, cum_send_form_message_method.validateFieldsKeyup);
    $('body').on('click', domEl.cum_send_message_area, cum_send_form_message_method.cum_send_form_message);
    //SEND FORM DIRECTORY
    $('body').on('keyup', domEl.field_dir_send_message, dir_send_form_message_method.validateFieldsKeyup);
    $('body').on('click', domEl.dir_send_message_area, dir_send_form_message_method.dir_send_form_message);
});

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
    // BACK TO TOP
    $(domEl.body_recurrent).on('click', domEl._back_to_top, backToTopMethod.backToTop);
    // NAVBAR
    $(domEl.navbar_recurrent).on('click', domEl._menu_toogle, mobile_menu_methods.mobile_menu_toggle);
    // MOBILE MENU TOGGLE
    $(domEl.navbar_recurrent).on('click', domEl._menu_toogle_close, mobile_menu_methods.close_menu_toggle);
    // BREADCRUMB HOME
    $(domEl.div_recurrent).on('click', domEl.goSection_breadcrumb_home, clikGoMethods.clikGo_home);
    // CLICK GO SECTION
    $(domEl.navbar_recurrent).on('click', domEl.goSection_index, clikGoMethods.clikGo_home);
    // AGENCIES NEWS
    $(domEl.navbar_recurrent).on('click', domEl.goSection_agencies_news, clikGoMethods.clikGo_agencies_news_principal);
    //$(domEl.navbar_recurrent).on('click', domEl.goSection_agencies_news, clikGoMethods.clikGo_agencies_news);
    $(domEl.div_recurrent).on('click', '#go-back-agencies-news', clikGoMethods.clikGo_agencies_news);
    // VIDEO STRIP
    $(domEl.div_recurrent).on('click', '.video-strip .pre-video i', video_strip_methods.video_strip_pre_video);
    $(domEl.div_recurrent).on('click', '.video-strip .close-frame', video_strip_methods.video_strip_close_frame);
    // AGENCIES NEWS SUB AGNECIES
    $(domEl.div_recurrent).on('click', domEl.action_go_agencie_news, clikGoMethods.clikGo_agencies_news_sub_agencie);
    // AGENCIES NEWS ACTION
    $(domEl.div_recurrent).on('click', domEl.action_new_agn, clikGoMethods.clikGo_agencies_news_principal);

    // AGENCIES TRUCKS
    //$(domEl.navbar_recurrent).on('click', domEl.goSection_agencies_trucks, clikGoMethods.clikGo_agencies_trucks_sub_agencie);
    //$(domEl.div_recurrent).on('click', '#go-back-agencies-trucks', clikGoMethods.clikGo_agencies_trucks);
    // AGENCIES NEWS SUB AGNECIES
    //$(domEl.div_recurrent).on('click', domEl.action_go_agencie_trucks, clikGoMethods.clikGo_agencies_trucks_sub_agencie);
    // AGENCIES TRUCKS ACTION
    //$(domEl.div_recurrent).on('click', domEl.action_truck_agn, clikGoMethods.clikGo_agencies_trucks_sub_agencie);

    // AGENCIES PRE-OWNED
    $(domEl.navbar_recurrent).on('click', domEl.goSection_agencies_preowned, clikGoMethods.clickGo_agencies_preowned_by_agencie);
    $(domEl.div_recurrent).on('click', domEl.button_show_agencies_tabs, clikGoMethods.showAgenciesTabs);
    $(domEl.div_recurrent).on('click', domEl.goBack_breadcrumb_agencies_preowned, clikGoMethods.clickGo_agencies_preowned);
    $(domEl.div_recurrent).on('click', domEl.action_go_agencie_preowned, clikGoMethods.clickGo_agencies_preowned_by_agencie);
    // INVENTORIES PRE-OWNED
    $(domEl.div_recurrent).on('click', "#back", clikGoMethods.clickGo_inventories_preowned);
    $(domEl.navbar_recurrent).on('click', domEl.goSection_inventories_preowned, clikGoMethods.clickGo_inventories_preowned);
    // SLIDETOGGLE BUTTON FILTROS
    $(domEl.div_recurrent).on('click', domEl.button_show_filters, clikGoMethods.showFilters);
    // CHANGE SELECT FILTERS
    $(domEl.div_recurrent).on('change', domEl.select_fil_category, getFilterMethod.changeCategory);
    $(domEl.div_recurrent).on('change', domEl.select_fil_brands, getFilterMethod.changeBrands);
    $(domEl.div_recurrent).on('change', domEl.select_fil_models, getFilterMethod.changeModel);
    //
    $(domEl.div_recurrent).on('click', domEl.link_sem_action, clikGoMethods.clickGo_inventories_preowned_details);
    // CONTACT MAIN BY MODEL
    // FORM CONTACT BY MODEL
    $(domEl.div_recurrent).on('keyup', domEl.input_contact_by_model_pre_owned_name, contactMethods_sem_premium_by_model.validate_fields_keyup);
    $(domEl.div_recurrent).on('keyup', domEl.input_contact_by_model_pre_owned_email, contactMethods_sem_premium_by_model.validate_fields_keyup);
    $(domEl.div_recurrent).on('keyup', domEl.input_contact_by_model_pre_owned_phone, contactMethods_sem_premium_by_model.validate_fields_keyup);
    $(domEl.div_recurrent).on('keyup', domEl.input_contact_by_model_pre_owned_message, contactMethods_sem_premium_by_model.validate_fields_keyup);
    $(domEl.div_recurrent).on('keypress', domEl.input_contact_by_model_pre_owned_phone, inputValMetdods.isIntegerKP);

    $(domEl.div_recurrent).on('click', domEl.send_contact_by_model_pre_owned, contactMethods_sem_premium_by_model.sendContactForm_byModel);
    // WORKSHOP
    $(domEl.navbar_recurrent).on('click', domEl.goSection_workshop, clikGoMethods.clickGo_workshop);
    // RENTAL
    $(domEl.navbar_recurrent).on('click', domEl.goSection_rental, clikGoMethods.clickGo_rental);
    // BLOG
    $(domEl.navbar_recurrent).on('click', domEl.goSection_blog, clikGoMethods.clickGo_blog);
    // BLOG BREADCRUMB
    $(domEl.div_recurrent).on('click', domEl.goSection_breadcrumb_blog, clikGoMethods.clickGo_blog);
    $(domEl.div_recurrent).on('click', domEl.goBack_breadcrumb_blog, clikGoMethods.clickGo_blog);
    // BLOG BY NEWS
    $(domEl.div_recurrent).on('click', domEl.goSection_blog_by_news, clikGoMethods.clickGo_blogByNotice);
    // ABOUT US
    $(domEl.navbar_recurrent).on('click', domEl.goSection_about_us, clikGoMethods.clickGo_about_us);
    $(domEl.div_recurrent).on('click', '#stop-video', video_strip_methods.stop_video);
    // JOB OPPORTUNITIES
    $(domEl.div_recurrent).on('keyup', domEl.input_job_opportunities_first_name, formJobOpportunitiesMethod.validateFieldsKeyup);
    $(domEl.div_recurrent).on('keyup', domEl.input_job_opportunities_last_name, formJobOpportunitiesMethod.validateFieldsKeyup);
    $(domEl.div_recurrent).on('keyup', domEl.input_job_opportunities_email, formJobOpportunitiesMethod.validateFieldsKeyup);
    $(domEl.div_recurrent).on('keyup', domEl.input_job_opportunities_phone, formJobOpportunitiesMethod.validateFieldsKeyup);
    $(domEl.div_recurrent).on('keyup', domEl.input_job_opportunities_message, formJobOpportunitiesMethod.validateFieldsKeyup);

    $(domEl.div_recurrent).on('keypress', domEl.input_job_opportunities_phone, inputValMetdods.isIntegerKP);

    $(domEl.div_recurrent).on('click', domEl.send_btn_job_opportunities, formJobOpportunitiesMethod.sendJobOpportunities);;
    // CONTACT
    $(domEl.navbar_recurrent).on('click', domEl.goSection_contact, clikGoMethods.clickGo_contact);
    
    $(domEl.div_recurrent).on('click', '#go-job-opportunities', clikGoMethods.clickGo_job_opportunities);
    $(domEl.div_recurrent).on('click', '#go-new-contact', clikGoMethods.clickGo_info);

    // JOB OPPORTUNITIES
    $(domEl.navbar_recurrent).on('click', domEl.goSection_job_opportunities, clikGoMethods.clickGo_job_opportunities);
    // ABOUT US FORM CONTACT MAIN
    $(domEl.div_recurrent).on('keyup', domEl.input_cam_contact_main_name, formContactMainMethod.validate_fields_keyup);
    $(domEl.div_recurrent).on('keyup', domEl.input_cam_contact_main_email, formContactMainMethod.validate_fields_keyup);
    $(domEl.div_recurrent).on('keyup', domEl.input_cam_contact_main_message, formContactMainMethod.validate_fields_keyup);
    // SEND CONTACT MAIN
    $(domEl.div_recurrent).on('click', domEl.send_cam_contact_main_send, formContactMainMethod.send_contact_main);
    // LOGO RESP
    $(domEl.navbar_recurrent).on('click', domEl.goSection_index_logo_resp, clikGoMethods.clikGo_home);
    // LOGO
    $(domEl.navbar_recurrent).on('click', domEl.goSection_index_logo, clikGoMethods.clikGo_home);
    // FULLWIDTH FEATURES CLICK GO SECTION
    $(domEl.div_recurrent).on('click', domEl.goSection_fullwidth_features_inventories_preowned, clikGoMethods.clickGo_inventories_preowned);
    $(domEl.div_recurrent).on('click', domEl.goSection_fullwidth_features_workshop, clikGoMethods.clickGo_workshop);
    $(domEl.div_recurrent).on('click', domEl.goSection_fullwidth_features_rental, clikGoMethods.clickGo_rental);
    // OUR BRANDS CLICK GO SECTION
    $(domEl.div_recurrent).on('click', domEl.goSection_ourBrand_agencies_news, clikGoMethods.clikGo_agencies_news_principal);
    $(domEl.div_recurrent).on('click', domEl.goSection_ourBrand_agencies_preowned, clikGoMethods.clickGo_agencies_preowned);
    $(domEl.div_recurrent).on('click', domEl.goSection_ourBrand_whorkshop, clikGoMethods.clickGo_workshop);
    $(domEl.div_recurrent).on('click', domEl.goSection_ourBrand_rental, clikGoMethods.clickGo_rental);
    // FORMS
    $(domEl.body_recurrent).on('focusout', domEl.validate_required, validateMethods.validate_input);
    // PRIVACY NOTICE
    $(domEl.body_recurrent).on('click', domEl.goSection_privacy_notice, clikGoMethods.clickGo_privacy_notice);
});

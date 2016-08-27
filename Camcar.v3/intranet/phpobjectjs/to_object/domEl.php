<?php

function domEl() {
    //SECTION HOME
    $welcome_page_header_name = 'content-welcome-page-header';
    $welcome_page_content_name = 'content-welcome-page-content';
    $welcome_widgets_first_row_name = 'content-welcome-widgets-first-row';
    $panel_perfil = 'panel_perfil';
    $today_birthday = 'today_birthday';
    $today_aniversary = 'today_aniversary';
    $today_agreements = 'today_agreements';
    //SECTION AGREEMENT
    $agreement_page_header = 'content-agreement-page-header';
    $agreement_page_content = 'content-agreement-page-content';
    $agreement_panel = 'content-panel';
    $agreement_panel_body = 'content-panel-body';
    //SECTION DIRECTORY
    //$directory_page_content = 'content-directory-page-content';
    $directory_page_aside = 'content-directory-page-aside';
    $directory_page_main = 'content-directory-page-main';
    return array(
        'recurrent_head' => 'head',
        'recurrent_body' => 'body',


        //NAVIGATION
        'site_navbar' => '#content-site-navbar-interactive',
        'site_menubar' => '#content-site-menubar-interactive',

        '_dd_menu_description' => '#dd-menu-description',


        //GENERAL HI DIVS
        'div_hidden_inputs_session' => 'div#hidden-inputs-session',
        'div_hidden_inputs_temporal' => 'div#hidden-inputs-temporal',
        'div_recurrent' => 'div#content-temporal-interactive',


        //RECURRENTS SECTION HOME
        '_home_page_header' => $welcome_page_header_name,
        '_home_page_header_name' => '#' . $welcome_page_header_name,

        '_home_page_content' => $welcome_page_content_name,
        '_home_page_content_name' => '#' . $welcome_page_content_name,

        '_home_widget_first_row' => $welcome_widgets_first_row_name,
        '_home_widget_first_row_name' => '#' . $welcome_widgets_first_row_name,


        //RECURRENTS SECTION AGREEMENT
        '_agreement_page_header' => $agreement_page_header,
        '_agreement_page_header_name' => '#' . $agreement_page_header,

        '_agreement_page_content' => $agreement_page_content,
        '_agreement_page_content_name' => '#' . $agreement_page_content,

        '_agreement_panel' => $agreement_panel,
        '_agreement_panel_name' => '#' . $agreement_panel,

        '_agreement_panel_body' => $agreement_panel_body,
        '_agreement_panel_body_name' => '#' . $agreement_panel_body,

        '_agreement_other_brands' => '#content-agreement-other-brands',
        'slide_panel_agreement_other_brands' => '#content-agreement-other-brands',


        //RECURRENTS SECTION DIRECTORY
        '_directory_page_aside' => $directory_page_aside,
        '_directory_page_aside_name' => '#' . $directory_page_aside,
        '_directory_page_main' => $directory_page_main,
        '_directory_page_main_name' => '#' . $directory_page_main,
        'div_recurrent_site_action' => '#content-site-action',

        'form_directory_filters' => 'form#directory-filters',
        '_directory_employees_list' => '#directory-employees-list',
        '_directory_employees_number' => '#directory-employees-number',
        'input_directory_search' => 'input#directory-search',
        'btn_directory_search' => 'button#directory-search-btn',

        '_epy_sorter' => '.epy-sorter',


        //Auxiliar DIVs
        'div_slide_panel' => '#content-slidePanel',

        //ACTION CLOSE
        'div_slide_panel_actions' => '#slidePanel-close-actions',
        //SLIDE PANEL
        //ONCLICK METHODS SLIDEPANEL
        '_widget_toggle_slide_panel' => '.widget-toggle-slide-panel',
        '_widget_toggle_slide_panel_agreement_other_brands' => '.widget-toggle-slide-panel-agreement-other-brands',
        '_close_slide_panel' => '.slidePanel-close',
        '_slide_panel_title' => '#slide-panel-title',

        '_content_slide_panel' => '#content-slide-panel',


        //EVENTS SECTION
        'go_section_home' => '#go-section-home',
        'go_section_agreement' => '#go-section-agreement',
        'go_section_directory' => '#go-section-directory',


        //SESSION AUXILIAR HIDDEN INPUTS
        //'input_session_usr_username' => 'input#session-usr-username',
        'input_session_usr_id' => 'input#session-usr-id',
        'input_session_usr_no_employee' => 'input#session-usr-no-employee',
        'input_session_usr_type' => 'input#session-usr-type',
        'input_session_usr_fullname' => 'input#session-usr-fullname',
        'input_session_usr_email' => 'input#session-usr-email',
        'input_session_usr_agn_id' => 'input#session-usr-agn-id',
        'input_session_usr_agn_name' => 'input#session-usr-agn-name',
        'input_session_usr_agn_logo1' => 'input#session-usr-agn-logo1',
        'input_session_usr_agn_logo2' => 'input#session-usr-agn-logo2',
        'input_session_usr_agn_header' => 'input#session-usr-agn-header',

        //AUXILIAR FORMAT CLASSES
        '_percentage_d' => '.percentage-d',
        '_currency_h' => '.currency-h',
        '_real_v' => '.real-v',
        '_ucwords' => '.ucwords',//UCWORDS

        '_date_roman_h' => '.date-roman-h',
        '_date_roman_v' => '.date-roman-v',

        '_date_human_h' => '.date-human-h',
        '_date_human_v' => '.date-human-v',


        //HOME
        '_home_panel_perfil_name' => $panel_perfil,
        '_home_panel_perfil' => '#' . $panel_perfil,

        '_profile_emp_name' => '#profile-emp-name',
        '_profile_emp_job' => '#profile-emp-job',
        '_profile_emp_agency' => '#profile-emp-agency',

        '_home_today_birthday_name' => $today_birthday,
        '_home_today_birthday' => '#' . $today_birthday,

        '_home_today_aniversary_name' => $today_aniversary,
        '_home_today_aniversary' => '#' . $today_aniversary,

        '_home_today_agreements_name' => $today_agreements,
        '_home_today_agreements' => '#' . $today_agreements,


        //MODAL OVERLAY
        'div_recurrent_modal_overlay' => 'div#content-temporal-modal-overlay',
        'div_recurrent_section_box' => 'div#content-temp-section-box',

        //FORM SEND CONGRATULATIONS - BIRTHDAY
        'div_recurrent_form_congratulations' => 'div#container-form-cum-send-message',
        'cum_form_send_message' => 'form#cum-form-send-message',
        'cum_send_message_area' => '#cum-send-message-area',
        'field_cum_send_message' => '#cum-send-message',
        'field_cum_send_from' => '#cum-send-from',
        'field_cum_send_to' => '#cum-send-to',
        'field_cum_send_email' => '#cum-send-email',
        'field_cum_send_email_to' => '#cum-send-email-to',
        'field_cum_send_date' => '#cum-send-date',

        //FORM SEND MESSAGE - DIRECTORY
        'div_recurrent_form_send_message' => 'div#container-form-dir-send-message',
        'dir_form_send_message' => 'form#dir-form-send-message',
        'dir_send_message_area' => '#dir-send-message-area',
        'field_dir_send_message' => '#dir-send-message',
        'field_dir_send_from' => '#dir-send-from',
        'field_dir_send_to' => '#dir-send-to',
        'field_dir_send_email' => '#dir-send-email',
        'field_dir_send_email_to' => '#dir-send-email-to',
        'field_dir_send_date' => '#dir-send-date',
        'div_agn_directory' => 'div.div-agn-directory',
        'span_agn_directory' => 'span.span-agn-directory',
        'a_agn_directory' => 'a.a-agn-directory',
        'div_mar_directory' => 'div.div-mar-directory',
        'span_mar_directory' => 'span.span-mar-directory',
        'a_mar_directory' => 'a.a-mar-directory',
        'span_dir_marck' => 'span#span-dir-marck',
    );
}
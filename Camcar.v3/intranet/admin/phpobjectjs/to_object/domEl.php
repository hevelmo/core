<?php

function domEl() {
    $adm_div_set_sen_data_name = 'set-sen-data';
    $adm_div_set_sen_load_pictures_name = 'set_sen-load-pictures';
        
    //---------------------------------- ADMIN NEW STYLE ----------------------------------
    
    /*
    //SECTION NEW PREOWNED
    $section_new_preowned_page_header = 'content-new-preowned-page-header';
    $section_new_preowned_page_content = 'content-new-preowned-page-content';
    */
    return array(
        //Star Page Header
        'adm_div_recurrent_start_page_header' => 'div#start-page-content',
        'adm_img_banner' => '#img-banner',

        //Auxiliar DIVs
        'adm_div_recurrent' => 'div#content-temporal-interactive',
        'adm_div_inputs_temporal' => 'div#hidden-inputs-temporal',
        'adm_div_inputs_session' => 'div#hidden-inputs-session',

        //SESSION AUXILIAR HIDDEN INPUTS
        //'adm_input_session_usr_username' => 'input#session-usr-username',
        'adm_input_session_usr_id' => 'input#session-usr-id',
        'adm_input_session_usr_type' => 'input#session-usr-type',
        'adm_input_session_usr_fullname' => 'input#session-usr-fullname',
        'adm_input_session_usr_email' => 'input#session-usr-email',
        'adm_input_session_usr_agn_id' => 'input#session-usr-agn-id',
        'adm_input_session_usr_agn_name' => 'input#session-usr-agn-name',
        'adm_input_session_usr_agn_logo1' => 'input#session-usr-agn-logo1',
        'adm_input_session_usr_agn_logo2' => 'input#session-usr-agn-logo2',
        'adm_input_session_usr_agn_header' => 'input#session-usr-agn-header',

        //AUXILIAR FORMAT CLASSES
        'adm__percentage_d' => '.percentage-d',
        'adm__currency_h' => '.currency-h',
        'adm__real_v' => '.real-v',

        //SEMINUEVOS
        'adm_div_get_sen_head' => 'div#div-get-sen-head',
        'adm_div_get_sen_list' => 'div#div-get-sen-list',
        'adm__get_sen_list' => '#get-sen-list',
        'adm__sen_results' => '#sen-results',
        'adm__sen_sorter' => '#sen-sorter',
        'adm__sen_sort' => '.sen-sort',
        'adm__sen_item' => '.sen-item',

        'adm__sen_action_delete' => '.sen-action-delete',
        'adm__sen_action_set' => '.sen-action-set',
        'adm_div_get_sen_filters' => 'div#div-get-sen-filters',
        //
        'adm_div_sen_filter_agency_container' => 'div#div-sen-filter-agency-container',
        'adm_div_select_sen_filter_agency' => 'div#div-select-sen-filter-agency',
        'adm_div_select_sen_filter_category' => 'div#div-select-sen-filter-category',
        'adm_div_select_sen_filter_brand' => 'div#div-select-sen-filter-brand',
        'adm_div_select_sen_filter_model' => 'div#div-select-sen-filter-model',
        //Form
        'adm_form_get_sen_filters' => 'form#get-sen-filters',
        //Elements
        'adm_input_sen_filter_search' => 'input#sen-filter-search',
        'adm_select_sen_filter_agency' => 'select#sen-filter-agency',
        'adm_select_sen_filter_category' => 'select#sen-filter-category',
        'adm_select_sen_filter_brand' => 'select#sen-filter-brand',
        'adm_select_sen_filter_model' => 'select#sen-filter-model',
        //Buttons
        'adm_btn_sen_filters_clean' => 'button#sen-filters-clean',

        //NEW SEMINUEVOS
        //Auxuliar DIVs
        'adm_div_select_new_sen_agency' => 'div#div-select-new-sen-agency',
        'adm_div_select_new_sen_category' => 'div#div-select-new-sen-category',
        'adm_div_select_new_sen_brand' => 'div#div-select-new-sen-brand',
        'adm_div_select_new_sen_model' => 'div#div-select-new-sen-model',
        'adm_div_select_new_sen_year' => 'div#div-select-new-sen-year',
        'adm_div_new_sen_agency_container' => 'div#div-new-sen-agency-container',
        //Form
        'adm_form_new_sen' => 'form#new-sen',
        //Form elemnts
        'adm_select_new_sen_select' => 'select.new-sen-select',
        'adm_input_new_sen_input' => 'input.new-sen-input',
        'adm_txta_new_sen_description' => 'textarea#new-sen-description',
        'adm_select_new_sen_year' => 'select#new-sen-year',
        'adm_input_new_sen_price' => 'input#new-sen-price',
        'adm_input_new_sen_mileage' => 'input#new-sen-mileage',
        'adm_select_new_sen_cylinders' => 'select#new-sen-cylinders',
        'adm_select_new_sen_agency' => 'select#new-sen-agency',
        'adm_select_new_sen_category' => 'select#new-sen-category',
        'adm_select_new_sen_brand' => 'select#new-sen-brand',
        'adm_select_new_sen_model' => 'select#new-sen-model',
        'adm_select_new_sen_transmission' => 'select#new-sen-transmission',
        'adm_select_new_sen_color' => 'select#new-sen-color',
        'adm_select_new_sen_interior' => 'select#new-sen-interior',
        'adm_btn_new_sen_save' => 'button#new-sen-save',
        'adm_btn_new_sen_clean' => 'button#new-sen-clean',
        'adm_btn_new_sen_seminuevos_list' => 'button#new-sen-seminuevos-list',

        //SET SEMINUEVOS
        'adm_div_set_sen_data_name' => $adm_div_set_sen_data_name,
        'adm_div_set_sen_data' => 'div#' . $adm_div_set_sen_data_name,
        'adm_div_set_sen_load_pictures_name' => $adm_div_set_sen_load_pictures_name,
        'adm_div_set_sen_load_pictures' => 'div#' . $adm_div_set_sen_load_pictures_name,
        //Auxuliar DIVs
        'adm_div_select_set_sen_agency' => 'div#div-select-set-sen-agency',
        'adm_div_select_set_sen_category' => 'div#div-select-set-sen-category',
        'adm_div_select_set_sen_brand' => 'div#div-select-set-sen-brand',
        'adm_div_select_set_sen_model' => 'div#div-select-set-sen-model',
        'adm_div_select_set_sen_year' => 'div#div-select-set-sen-year',
        'adm_div_set_sen_agency_container' => 'div#div-set-sen-agency-container',
        //Form
        'adm_form_set_sen' => 'form#set-sen',
        //Form elemnts
        'adm__set_sen_element' => '.set-sen-element',
        'adm_select_set_sen_select' => 'select.set-sen-select',
        'adm_input_set_sen_input' => 'input.set-sen-input',
        'adm_txta_set_sen_description' => 'textarea#set-sen-description',
        'adm_select_set_sen_year' => 'select#set-sen-year',
        'adm_input_set_sen_price' => 'input#set-sen-price',
        'adm_input_set_sen_mileage' => 'input#set-sen-mileage',
        'adm_select_set_sen_cylinders' => 'select#set-sen-cylinders',
        'adm_select_set_sen_agency' => 'select#set-sen-agency',
        'adm_select_set_sen_category' => 'select#set-sen-category',
        'adm_select_set_sen_brand' => 'select#set-sen-brand',
        'adm_select_set_sen_model' => 'select#set-sen-model',
        'adm_select_set_sen_transmission' => 'select#set-sen-transmission',
        'adm_select_set_sen_color' => 'select#set-sen-color',
        'adm_select_set_sen_interior' => 'select#set-sen-interior',
        'adm_btn_set_sen_save' => 'button#set-sen-save',
        'adm_btn_set_sen_clean' => 'button#set-sen-clean',
        'adm_btn_set_sen_restore' => 'button#set-sen-restore',
        'adm_btn_set_sen_seminuevos_list' => 'button#set-sen-seminuevos-list',

        //PICTURES SEMINUEVOS

        //DIV's Auxiliar

        'adm_div_picture_sen_loader' => 'div#div-picture-sen-loader',
        'adm_div_picture_sen_pictures' => 'div#div-picture-sen-pictures',

        'adm_btn_picture_sen_seminuevos_list' => 'button#picture-sen-seminuevos-list',

        //
        'adm_input_picture_sen_uploader' => 'input#picture-sen-uploader',

        //
        'adm__picture_sen_action_delete' => '.picture-sen-action-delete',
        'adm__picture_sen_action_thumb' => '.picture-sen-action-thumb',

        //Views Grid / list
        'adm_id_results_holder' => 'div#results-holder',
        'adm_class_result_item' => '.result-item',
        'adm_id_views_list' => '#results-list-view',
        'adm_id_views_grid' => '#results-grid-view',
        
        //---------------------------------- ADMIN NEW STYLE ----------------------------------
        
        /*
        //
        'adm_recurrent_head' => 'head',
        'adm_recurrent_body' => 'body',
        //NAVIGATION
        'adm_site_navbar' => '#content-site-navbar-interactive',
        'adm_site_menubar' => '#content-site-menubar-interactive',

        //RECURRENT SECTION NEW PREOWNED
        'adm__section_new_preowned_page_header' => $section_new_preowned_page_header,
        'adm__section_new_preowned_page_header_name' => '#' . $section_new_preowned_page_header,
        'adm__section_new_preowned_page_content' => $section_new_preowned_page_content,
        'adm__section_new_preowned_page_content_name' => '#' . $section_new_preowned_page_content,
        */
    );
}
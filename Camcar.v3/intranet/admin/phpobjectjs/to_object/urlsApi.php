<?php

function urlsApi() {
    //Especial Actions
    $new = "new";
    $del = "del";
    $set = "set";
    $get = "get";
    $search = "search";
    $wri = "wri";
    $ssn = "session";
    
    //
    $det = "detail";
    
    //Tables
    $agn = "agencias";
    $cat = "categorias";
    $mar = "marcas";
    $mdo = "modelos";
    $pic = "pictures";
    $sen = "seminuevos";
    $thm = "thumbnail";
    
    //Root Api url
    $root = 'api/v15';
    
    return array(
        //SESSION
        "adm_ssn_get_admin_access" => "$root/$ssn/$get/admin/access",
        
        //INSERT
        "adm_new_sen" => "$root/$new/$sen",
        "adm_new_pic" => "$root/$new/$pic/",
        
        //UPDATE
        "adm_set_sen" => "$root/$set/$sen/",
        "adm_set_thm" => "$root/$set/$thm",
        
        //SELECT
        "adm_get_pic" => "$root/$get/$pic/",
        "adm_get_sen" => "$root/$get/$sen",
        "adm_get_sen_agn_id" => "$root/$get/$sen/$agn/",
        "adm_get_sen_id" => "$root/$get/$sen/",
        "adm_get_sen_filters" => "$root/$get/$sen/filters/",
        "adm_get_agn_header" => "$root/$get/header/$agn",
        "adm_get_agn_header_id" => "$root/$get/header/$agn/",
        "adm_get_agn" => "$root/$get/$agn",
        "adm_get_agn_sen" => "$root/$get/{$agn}s/$sen",
        "adm_get_agn_id" => "$root/$get/$agn/",
        "adm_get_cat" => "$root/$get/$cat",
        "adm_get_cat_sen" => "$root/$get/{$cat}s/$sen",
        "adm_get_cat_sen_agn_id" => "$root/$get/$cat/$sen/$agn/",
        "adm_get_cat_id" => "$root/$get/$cat/",
        "adm_get_mar" => "$root/$get/$mar",
        "adm_get_mar_id" => "$root/$get/$mar/",
        "adm_get_mar_sen_agn_id" => "$root/$get/$mar/$sen/$agn/",
        "adm_get_mdo" => "$root/$get/$mdo",
        "adm_get_mdo_id" => "$root/$get/$mdo/",
        "adm_get_mdo_sen_agn_id" => "$root/$get/$mdo/$sen/$agn/",
        "adm_get_mdo_sen_mar_id" => "$root/$get/$mdo/$sen/$mar/",
        "adm_get_mdo_mar_id" => "$root/$get/$mdo/$mar/",
        
        
        //DELETE
        "adm_del_sen" => "$root/$del/$sen/",
        "adm_del_pic" => "$root/$del/$pic"
    );
}

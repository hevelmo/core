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
    $post = "post";

    //
    $det = "detail";
    $wse = "webservice";

    //Tables
    $agn = "agencias";
    $con = "convenios";
    $cum = "cumpleanos";
    $epy = "empleados";
    $fin = "fechas_ingreso";
    $mar = "marcas";
    $nep = "numeros_empleado";
    //$ani = "aniversarios";
    //$apm = "apellidos_maternos";
    //$app = "apellidos_paternos";
    //$are = "areas";
    //$car = "cargos";
    //$cty = "ciudades";
    //$cor = "correos";
    //$age = "edades";
    //$est = "estados";
    //$nag = "numeros_agencia";
    //$nom = "nombres";
    //$tel = "telefonos";

    $msn = "mensaje";

    //Root Api url
    $root = "../api/v21";

    //rootURL + "carts/update/"

    return array(
        //SESSION
        "ssn_get_admin_access" => "$root/$ssn/$get/admin/access",

        //INSERT

        //UPDATE
        "wse_set_epy" => "$root/$wse/$set/$epy",

        //SELECT
        "get_con" => "$root/$get/$con",
        "get_con_id" => "$root/$get/$con/",

        //WEBSERVICE
        "wse_get_agn" => "$root/$wse/$get/$agn",
        "wse_get_mar" => "$root/$wse/$get/$mar",
        "wse_get_epy" => "$root/$wse/$get/$epy",
        "wse_get_epy_cum" => "$root/$wse/$get/$epy/$cum/",
        "wse_get_epy_fin" => "$root/$wse/$get/$epy/$fin/",
        "wse_get_epy_filters" => "$root/$wse/$get/$epy/filters/",
        "wse_get_epy_nep" => "$root/$wse/$get/$epy/$nep/",
        "wse_get_epy_mail" => "$root/$wse/$get/$epy/mail/",
        //"wse_get_epy_agn" => "$root/$wse/$get/$epy/$agn/",
        //"wse_get_epy_ani" => "$root/$wse/$get/$epy/$ani/",
        //"wse_get_epy_apm" => "$root/$wse/$get/$epy/$apm/",
        //"wse_get_epy_app" => "$root/$wse/$get/$epy/$app/",
        //"wse_get_epy_are" => "$root/$wse/$get/$epy/$are/",
        //"wse_get_epy_car" => "$root/$wse/$get/$epy/$car/",
        //"wse_get_epy_cty" => "$root/$wse/$get/$epy/$cty/",
        //"wse_get_epy_cor" => "$root/$wse/$get/$epy/$cor/",
        //"wse_get_epy_age" => "$root/$wse/$get/$epy/$age/",
        //"wse_get_epy_est" => "$root/$wse/$get/$epy/$est/",
        //"wse_get_epy_mar" => "$root/$wse/$get/$epy/$mar/",
        //"wse_get_epy_nag" => "$root/$wse/$get/$epy/$nag/",
        //"wse_get_epy_nom" => "$root/$wse/$get/$epy/$nom/",
        //"wse_get_epy_tel" => "$root/$wse/$get/$epy/$tel/",


        //PAGE HEADER BG
        "adm_get_agn_header" => "$root/$get/header/$agn",
        "adm_get_agn_header_id" => "$root/$get/header/$agn/",

        // MESSAGE BIRTHDAY
        "int_wel_send_congratulations" => "$root/$post/welcome/$msn/$cum",
        // MESSAGE DIRECTORY
        "int_dir_send_message" => "$root/$post/directory/$msn",

        //DELETE

    );
}
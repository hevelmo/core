<?php

function urlsApi() {
    //Especial Actions
    $new = 'new';
    $del = 'del';
    $set = 'set';
    $get = 'get';
    $search = 'search';

    //
    $det = 'detail';

    //Tables
    $tab = 'table';

    //Root Api url
    //$root = 'api/v1/index.php';
    $root = 'api/v1';


    return array(
        // INSERT
        //'new_tab' => $root . '/' . $new . '/' . $tab,

        // UPDATE
        //'set_tab_id' => $root . '/' . $set . '/' . $tab . '/',

        // SELECT
        //'get_tab' => $root . '/' . $get . '/' . $tab,
        //'get_tab_id' => $root . '/' . $get . '/' . $tab . '/',

        // DELETE
        //'del_tab_id' => $root . '/' . $del . '/' . $tab . '/',

        //TEST
        //They will not be used in the ral project, romove it later form here and from api and compile 'phpobjectjs'
        'get_test' => $root . '/' . 'get/test',
        'post_test' => $root . '/' . 'post/test',

        'postContact' => $root . '/' . 'contacto',
    );
}

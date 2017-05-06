<?php

function urlsApi() {
    //Especial Actions
    $new = 'new';
    $del = 'del';
    $set = 'set';
    $get = 'get';
    $snd = "send";
    $add = "add";
    $max = "max";

    $gdl = 'gdl';
    $cty = 'country';

    $drv = 'testdrive';
    $fin = 'financiamiento';
    $srv = "servicio";
    $rep = "refacciones";
    $cnt = "contacto";

    //Root Api url
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


        // SEND MAIL CONTACT JAGUAR
        //'api_send_contact_jaguar_gdl' => $root . '/' . $contact . '/' . $agencie . '/' . $agencie_name_gdl,
        //'api_send_contact_jaguar_country' => $root . '/' . $contact . '/' . $agencie . '/' . $agencie_name_country,
        // SEND MAIL SCHEDULE TEST DRIVE
        //'api_send_schedule_test_drive' => $root . '/' . $schedule . '/' . $test_drive,
        // SEND MAIL SCHEDULE TEST DRIVE BY MODEL
        //'api_send_schedule_test_drive_by_model' => $root . '/' . $schedule . '/' . $test_drive . '/' . $model,
        
        // ADD MAX
        'add_max' => "$root/$add/$max",

        // SEND SERVICES
        'snd_srv' => "$root/$snd/$srv",

        // SEND REPAIRS
        'snd_rep' => "$root/$snd/$rep",

        // SEND CONTACT
        'snd_con' => "$root/$snd/$cnt",

        // SEND FINANCING
        'snd_fin' => "$root/$snd/$fin",

        // SEND TESTDRIVE
        'snd_drv' => "$root/$snd/$drv"
    );
}

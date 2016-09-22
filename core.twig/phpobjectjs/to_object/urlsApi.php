<?php

function urlsApi() {
    //Especial Actions
    $get = "get";
    $snd = "send";
    $add = "add";

    //Tables
    $mdo = "modelos";

    //Others
    $cnt = "contactos";

    //Root Api url
    $root = "api/v1";

    return array(
        //SELECT
        //"get_mdo" => "$root/$get/$mdo/",

        //INSERT
        //"add_cnt" => "$root/$add/$cnt/",

        //SEND
        "snd_cnt" => "$root/$snd/$cnt",
        //"snd_cnt_premium" => "$root/$snd/$cnt/premium"
    );
}

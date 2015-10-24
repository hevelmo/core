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
    $tab_seminuevo = 'seminuevo';
    $tab_seminuevos = 'seminuevos';
    $tab_pictures = 'pictures';
    $tab_mapa = 'mapa';
    $tab_filtros = 'filtros';
    $tab_categoria = 'categoria';
    $tab_marca = 'marcas';
    $tab_modelo = 'modelos';
    $tab_catalogo = 'catalogo';
    $news = 'nuevos';
    $preowned = 'seminuevos';
    $agencie = 'agencia';
    $brands = 'marcas';
    $logos = 'logotipos';
    $banners = 'banners';

    //Root Api url
    $root = 'api/v12';

    return array(
        // INSERT
        //'new_tab' => $root . '/' . $new . '/' . $tab,

        // UPDATE
        //'set_tab_id' => $root . '/' . $set . '/' . $tab . '/',

        // SELECT
        //'get_tab' => $root . '/' . $get . '/' . $tab,
        //'get_tab_id' => $root . '/' . $get . '/' . $tab . '/',

        /* BEGIN : BANNERS CAMCAR */
            'getBanners' => $root . '/' . $get . '/' . $banners,
        /* BEGIN : BANNERS CAMCAR */
        /* BEGIN : INVENTORIES PRE-OWNED */
            // Seminuevos
            'getSeminuevos' => $root . '/' . $get . '/' . $tab_seminuevos,
            'getSeminuevosById' => $root . '/' . $get . '/' . $tab_seminuevos . '/',

            // Pictures
            'getPictures' => $root . '/' . $get . '/' . $tab_pictures . '/' . $tab_seminuevo,
            'getPicturesById' => $root . '/' . $get . '/' . $tab_pictures . '/' . $tab_seminuevo . '/',

            // Mapa
            'getMapa' => $root . '/' . $get . '/' . $tab_mapa . '/' . $tab_seminuevo,
            'getMapaById' => $root . '/' . $get . '/' . $tab_mapa . '/' . $tab_seminuevo . '/',

            // Filtros
            'getSeminuevosByFilter' => $root . '/' . $get . '/' . $tab_seminuevos . '/' . $tab_filtros . '/',

            // Categoria
            'getCategory' => $root . '/' . $get . '/' . $tab_categoria,

            // Marca
            'getCategoryByMarc' => $root . '/' . $get . '/' . $tab_categoria . '/' . $tab_marca . '/',

            // Modelo
            'getCategoryModelsByCategoryByMarc' => $root . '/' . $get . '/' . $tab_categoria . '/' . $tab_modelo . '/',

            // CAROUSEL
            'getCatalogoByMarc' => $root . '/' . $get . '/' . $tab_catalogo . '/' . $tab_marca . '/',
        /* END   : INVENTORIES PRE-OWNED */
        /* BEGIN : AGENCIES PRE-OWNED */
            // Agencias Seminuevos
            'getAgenciesPreOwned' => $root . '/' . $get . '/' . $agencie . '/' . $preowned,
            'getAgenciesPreOwnedByMap' => $root . '/' . $get . '/' . $agencie . '/' . $preowned .'/mapas/',
            'getAgenciesPreOwnedByAgencie' => $root . '/' . $get . '/' . $agencie . '/' . $preowned . '/',
        /* END   : AGENCIES PRE-OWNED */
        /* END   : AGENCIES WORKSHOP */
            'getWorkshop' => $root . '/' . $get . '/talleres',
            'getWorkshopBrands' => $root . '/' . $get . '/talleres/logos',
        /* END   : AGENCIES WORKSHOP */
        /* END   : AGENCIES RENTAL */
            'getRental' => $root . '/' . $get . '/rentas',
            'getRentalBrand' => $root . '/' . $get . '/rentas/logo',
        /* END   : AGENCIES RENTAL */



        /* BEGIN : AGENCIES NEWS */
            /* HEMO -> BRANDS AGENCIES */
            'getBrandsLogos' => $root . '/' . $get . '/' . $agencie . '/' . $news . '/' . $brands . '/'. $logos,
            // AGENCIES NEWS -> PRINCIPAL AGENCIES NEWS
            'getAgenciesNewsByTypeAgencie' => $root . '/' . $get . '/' . $agencie . '/' . $news . '/principal/',


            // Agencias Nuevos
            'getAgenciesNews' => $root . '/' . $get . '/' . $agencie . '/' . $news,
            'getAgenciesNewsByMap' => $root . '/' . $get . '/' . $agencie . '/' . $news .'/mapas/',
            'getAgenciesNewsByAgencie' => $root . '/' . $get . '/' . $agencie . '/' . $news . '/',

            //'getBrandsLogosByAgencia' => $root . '/' . $get . '/logos/agencias/',
            // Agencies News Principal
            'getAgenciesNewsPrincipales' => $root . '/' . $get . '/' . $agencie . '/' . $news,
            // Logos Agencies News Principal
            'getLogosAgenciesNews' => $root . '/' . $get . '/logos/' . $agencie . '/' . $news,
            'getAgenciesNewsPrincipalesByAgencia' => $root . '/' . $get . '/agencias/' . $news. '/',
        /* END   : AGENCIES NEWS */

        // DELETE
        //'del_tab_id' => $root . '/' . $del . '/' . $tab . '/',

        //TEST
        //They will not be used in the ral project, romove it later form here and from api and compile 'phpobjectjs'
        /*'get_test' => $root . '/' . 'get/test',
        'post_test' => $root . '/' . 'post/test'*/
        'sendMailContact_sem_premium' => $root . '/' . 'contacto/' . $tab_seminuevo . '/premium',
        'sendMailContactByModel_sem_premium' => $root . '/' . 'contacto/' . $tab_seminuevo . '/premium/modelo',
        'senMailJobBoard' => $root . '/' . 'bolsa-de-trabajo',
        'cv_new_file' => $root . '/' . 'bolsa-de-trabajo/new/file'
    );
}

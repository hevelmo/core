<?php

function urlsApi() {
    //Especial Actions
    $new = 'new';
    $del = 'del';
    $set = 'set';
    $get = 'get';
    $search = 'search';
    $post = 'post';

    //
    $det = 'detail';

    //Tables
    //$tab = 'table';
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
    $fachada = 'fachada';
    $address = 'direccion';
    $map = 'mapa';
    $preowned = 'seminuevos';
    $agencie = 'agencia';
    $brands = 'marcas';
    $logos = 'logotipos';
    $banners = 'banners';
    $group_counter = 'grupo/camcar';
    $banners = 'banners';
    $noticia = 'noticia';
    $trucks = 'camiones';

    //Root Api url
    $root = 'api/v15';

    return array(
        // INSERT
        // UPDATE
        // SELECT
        // DELETE
        // HOME SECTION BANNERS
        'getBanners' => $root . '/' . $get . '/' . $banners,
        // HOME SECTION BRANDS
        'getBrandsLogos' => $root . '/' . $get . '/' . $agencie . '/' . $news . '/' . $brands . '/'. $logos,
        // HOME SECTION GROUP COUNTER
        'getGroupCounter' => $root . '/' . $get . '/' . $group_counter,

        // AGENTS MAP
        'getMapa' => $root . '/' . $get . '/' . $tab_mapa . '/' . $tab_seminuevo,
        'getMapaById' => $root . '/' . $get . '/' . $tab_mapa . '/' . $tab_seminuevo . '/',
        // AGENTS MAP AGENCIES
        'getAgentsMapAgencies' => $root . '/' . $get . '/agencias/mapa',

        // AGENCIES NEWS
        // LOGOS AGENCIES NEWS PRINCIPAL
        'getLogosAgenciesNews' => $root . '/' . $get . '/logos/' . $agencie . '/' . $news,
        // PRINCIPAL AGENCIE NEWS
        'getAgenciesNewsPrincipales' => $root . '/' . $get . '/' . $agencie . '/' . $news,
        // AGENCIES NEWS -> PRINCIPAL AGENCIES NEWS
        'getAgenciesNewsByTypeAgencie' => $root . '/' . $get . '/' . $agencie . '/' . $news . '/principal/',
        // PRINCIPAL AGENCIE NEWS BY AGENCIE
        'getAgenciesNewsPrincipalesByAgencia' => $root . '/' . $get . '/agencias/' . $news. '/',
        'getAgenciesNews' => $root . '/' . $get . '/' . $agencie . '/' . $news,
        // Agencias Nuevos Fachada
        'getAgenciesNewsFachada' => $root . '/' . $get . '/' . $agencie . '/' . $news . '/' . $fachada,
        'getAgenciesNewsAddress' => $root . '/' . $get . '/' . $agencie . '/' . $news . '/' . $address,
        'getAgenciesNewsMap' => $root . '/' . $get . '/' . $agencie . '/' . $news . '/' . $map,
        // AGENCIES NEWS BY MAP
        'getAgenciesNewsByMap' => $root . '/' . $get . '/' . $agencie . '/' . $news .'/mapas/',
        // AGENCIES NEWS BY AGENCIE
        'getAgenciesNewsByAgencie' => $root . '/' . $get . '/' . $agencie . '/' . $news . '/',

        // AGENCIES TRUCKS
        // LOGOS AGENCIES TRUCKS PRINCIPAL
        'getLogosAgenciesTrucks' => $root . '/' . $get . '/logos/' . $agencie . '/' . $trucks,
        // PRINCIPAL AGENCIE NEWS
        'getAgenciesTrucksPrincipales' => $root . '/' . $get . '/' . $agencie . '/' . $trucks,
        // AGENCIES NEWS -> PRINCIPAL AGENCIES NEWS
        'getAgenciesTrucksByTypeAgencie' => $root . '/' . $get . '/' . $agencie . '/' . $trucks . '/principal/',
        // PRINCIPAL AGENCIE NEWS BY AGENCIE
        'getAgenciesTrucksPrincipalesByAgencia' => $root . '/' . $get . '/agencias/' . $trucks. '/',
        'getAgenciesTrucks' => $root . '/' . $get . '/' . $agencie . '/' . $trucks,
        // Agencias Nuevos Fachada
        'getAgenciesTrucksFachada' => $root . '/' . $get . '/' . $agencie . '/' . $trucks . '/' . $fachada,
        'getAgenciesTrucksAddress' => $root . '/' . $get . '/' . $agencie . '/' . $trucks . '/' . $address,
        'getAgenciesTrucksMap' => $root . '/' . $get . '/' . $agencie . '/' . $trucks . '/' . $map,
        // AGENCIES NEWS BY MAP
        'getAgenciesTrucksByMap' => $root . '/' . $get . '/' . $agencie . '/' . $trucks .'/mapas/',
        // AGENCIES NEWS BY AGENCIE
        'getAgenciesTrucksByAgencie' => $root . '/' . $get . '/' . $agencie . '/' . $trucks . '/',

        // AGENCIES PRE-OWNED
        'getAgenciesPreOwned' => $root . '/' . $get . '/' . $agencie . '/' . $preowned,
        'getAgenciesPreOwnedByMap' => $root . '/' . $get . '/' . $agencie . '/' . $preowned .'/mapas/',
        'getAgenciesPreOwnedByAgencie' => $root . '/' . $get . '/' . $agencie . '/' . $preowned . '/',

        // INVENTORIES PRE-OWNED
        'getSeminuevos' => $root . '/' . $get . '/' . $tab_seminuevos,
        'getSeminuevosById' => $root . '/' . $get . '/' . $tab_seminuevos . '/',
        // PICTURES
        'getPictures' => $root . '/' . $get . '/' . $tab_pictures . '/' . $tab_seminuevo,
        'getPicturesById' => $root . '/' . $get . '/' . $tab_pictures . '/' . $tab_seminuevo . '/',
        // FILTERS
        'getSeminuevosByFilter' => $root . '/' . $get . '/' . $tab_seminuevos . '/' . $tab_filtros . '/',
        // CATEGORY
        'getCategory' => $root . '/' . $get . '/' . $tab_categoria,
        // BRANDS
        'getCategoryByMarc' => $root . '/' . $get . '/' . $tab_categoria . '/' . $tab_marca . '/',
        // MODELS
        'getCategoryModelsByCategoryByMarc' => $root . '/' . $get . '/' . $tab_categoria . '/' . $tab_modelo . '/',
        // CAROUSEL
        'getCatalogoByMarc' => $root . '/' . $get . '/' . $tab_catalogo . '/' . $tab_marca . '/',

        // AGNCIES WORKSHOP
        'getWorkshop' => $root . '/' . $get . '/talleres',
        'getWorkshopBrands' => $root . '/' . $get . '/talleres/logos',

        // AGENCIES RENTAl
        'getRental' => $root . '/' . $get . '/rentas/',
        //'getRentalBrand' => $root . '/' . $get . '/rentas/logo',

        // BLOG
        'getBlog' => $root . '/' . $get . '/blog',
        'getBlogByPost' => $root . '/' . $get . '/blog/' . $noticia . '/',

        // ABOUT US FORM CONTACT MAIN
        'post_form_contact_main' => $root . '/contacto',
        'post_form_contact_main_by_model' => $root . '/contacto/modelo',

        // JOB OPPORTUNITIES
        'postJobOpportunities' => $root . '/' . $post . '/bolsa-de-trabajo',

    );
}

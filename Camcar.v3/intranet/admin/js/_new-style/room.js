/* ----------------------------------- *\
 [Route] The Highway
\* ----------------------------------- */

Finch.route('/', {
    setup: function(bindings) {
        // Add favicon
        window.onload = favicon.load_favicon();
        section = "intranet-adm-home";
        Breakpoints();
        Site.run();
        addStylesMethod.addStylesNewPreowned();
    },
    load: function(bindings) {
        loadSiteNavigationMethods.loadSiteNavigation();
        viewSectionAdmNewPreownedMethods.viewSectionAdmNewPreowned();
        $('.selectpicker').selectpicker();
        // Template
        CAMAD.loadTemplate(tempsNames.adm_home, domEl.adm_div_recurrent);
        // Banner
        CAMAD.loadTemplate(tempsNames.adm_start_page_header, domEl.adm_div_recurrent_start_page_header);
        bannerMethods.bannerLoad();
        scrollToTop();
        __sizeCheck($(window));
    },
    unload: function(bindings) {
        section = "";
        //Always clean the editable divs used, before lave the current route
        CAMAD.setHTML(domEl.adm_div_recurrent, '');
    }
});

/* ----------------------------------- *\
 [Route] NEW PREOWNED
\* ----------------------------------- */

/*
Finch.route('/', {
    setup: function(bindings) {
        // Add favicon
        window.onload = favicon.load_favicon();
        section = "intranet-adm-new-preowned";
        Breakpoints();
        Site.run();
        addStylesMethod.addStylesNewPreowned();
    },
    load: function(bindings) {
        loadSiteNavigationMethods.loadSiteNavigation();
        viewSectionAdmNewPreownedMethods.viewSectionAdmNewPreowned();
        $('.selectpicker').selectpicker();
    },
    unload: function(bindings) {
        section = "";
        CAMAD.setHTML(domEl.adm_div_recurrent, '');
    }
});
*/

Finch.route('/seminuevos', {
    setup: function(bindings) {
        ga('send', 'pageview', '/seminuevos');
        GLOBALLastUrlPro = '';
    },
    load: function(bindings) {
        var senData;
        //senData = CAMAD.getInternalJSON(urlsApi.adm_get_sen);
        //console.log(senData);
        //Load principal Template
        CAMAD.loadTemplate(tempsNames.adm_get_sen, domEl.adm_div_recurrent);
        searchFormMethod.searchFrom();
        getSenMethod.refreshFilters();
        CAMAD.loadTemplate(tempsNames.adm_get_sen_head, domEl.adm_div_get_sen_head);
        getSenMethod.sortingFilters();
        $('.selectpicker').selectpicker();
        __sizeCheck($(window));
        scrollToTop();
    },
    unload: function(bindings) {
        //Always clean the editable divs used, before lave the current route
        CAMAD.setHTML(domEl.adm_div_recurrent, '');
        //Clean global variables
        GLOBALLastUrlPro = '';
    }
});

Finch.route('/set/seminuevos/:senId', {
    setup: function(bindings) {
        ga('send', 'pageview', '/set/seminuevos/' + bindings.senId);
    },
    load: function(bindings) {
        //Auxiliar temporal divs
        CAMAD.appendMulti(domEl.adm_div_recurrent, [
            ['div', {'id' : domEl.adm_div_set_sen_data_name}, '', true],
            ['div', {'id' : domEl.adm_div_set_sen_load_pictures_name}, '', true]
        ]);
        //Set data section
        setSenMethod.refreshSen(bindings.senId);
        //Load pictures section
        CAMAD.loadTemplate(tempsNames.adm_picture_sen, domEl.adm_div_set_sen_load_pictures);
        pictureSenMethod.pictureLoader(bindings.senId);
        pictureSenMethod.refreshPictures(bindings.senId);
        $('.selectpicker').selectpicker();
        __sizeCheck($(window));
        scrollToTop();
    },
    unload: function(bindings) {
        //Always clean the editable divs used, before lave the current route
        CAMAD.setHTML(domEl.adm_div_recurrent, '');
    }
});

Finch.route('/new/seminuevos', {
    setup: function(bindings) {
        ga('send', 'pageview', '/new/seminuevos');
    },
    load: function(bindings) {
        newSenMethod.resetSen();
        __sizeCheck($(window));
        scrollToTop();
    },
    unload: function(bindings) {
        //Always clean the editable divs used, before lave the current route
        CAMAD.setHTML(domEl.adm_div_recurrent, '');
    }
});

Finch.listen();

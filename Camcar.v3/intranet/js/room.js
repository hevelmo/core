/* ----------------------------------- *\
 [Route] HOME
\* ----------------------------------- */
    Finch.route('/', {
        setup: function(bindings) {
            //Add favicon
            window.onload = favicon.load_favicon();
            section = "intranet-welcome";
            Breakpoints();
            Site.run();
            addStylesMethod.addStylesHome();
        },
        load: function(bindings) {
            loadSiteNavigationMethods.loadSiteNavigation();
            currentSectionMethod.currentSection_home();
            viewSectionWelcomeHomeMethods.viewWelcomeHome();
            //Reload Slider
            gallerySliderMethod.gallerySlider();
            $(window).resize(gallerySliderMethod.reloadSlider);
            wavesInitMethod.wavesInit();
            bgImageHolderMethods.appendBgImageHolder();

            //hoverIconSocialMethod.hoverIconSocial();
        },
        unload: function(bindings) {
            section = "";
            CAMIN.setHTML(domEl.div_recurren, '');
            cleanStylesMethod.cleanStyles();
            removeRecurrentsMethods.removeRecurrents();
            currentSectionMethod.remove_currentSection();
        }
    });
/* ----------------------------------- *\
 [Route] CONVENIOS
\* ----------------------------------- */
    Finch.route('/convenios', {
        setup: function(bindings) {
            //Add favicon
            window.onload = favicon.load_favicon();
            section = "intranet-welcome-agreement";
            Breakpoints();
            Site.run();
            addStylesMethod.addStylesAgreement();
        },
        load: function(bindings) {
            loadSiteNavigationMethods.loadSiteNavigation();
            currentSectionMethod.currentSection_agreement();
            viewSectionWelcomeAgreementMethods.viewSectionWelcomeAgreement();
            wavesInitMethod.wavesInit();

            //hoverIconSocialMethod.hoverIconSocial();
        },
        unload: function(bindings) {
            section = "";
            CAMIN.setHTML(domEl.div_recurren, '');
            cleanStylesMethod.cleanStyles();
            removeRecurrentsMethods.removeRecurrents();
            currentSectionMethod.remove_currentSection();
        }
    });
/* ----------------------------------- *\
 [Route] CONVENIOS
\* ----------------------------------- */
    Finch.route('/directorio', {
        setup: function(bindings) {
            GLOBALSorter = 'nom';
            GLOBALSort = 'ASC';
            GLOBALMarca = '';
            GLOBALLastUrlEpy = '';
            //Add favicon
            window.onload = favicon.load_favicon();
            section = "intranet-welcome-directory";
            Breakpoints();
            Site.run();
            addStylesMethod.addStylesDirectory();
        },
        load: function(bindings) {
            loadSiteNavigationMethods.loadSiteNavigation();
            currentSectionMethod.currentSection_directory();
            viewSectionWelcomeDirectoryMethods.viewSectionWelcomeDirectory();
            wavesInitMethod.wavesInit();
            $(window).scroll(viewSectionWelcomeDirectoryMethods.pageAside_isScroll);

            //hoverIconSocialMethod.hoverIconSocial();
        },
        unload: function(bindings) {
            GLOBALSorter = 'nom';
            GLOBALSort = 'ASC';
            GLOBALMarca = '';
            GLOBALLastUrlEpy = '';
            section = "";
            CAMIN.setHTML(domEl.div_recurren, '');
            cleanStylesMethod.cleanStyles();
            removeRecurrentsMethods.removeRecurrents();
            currentSectionMethod.remove_currentSection();
        }
    });
Finch.listen();

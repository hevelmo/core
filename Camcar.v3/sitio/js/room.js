/* ----------------------------------- *\
 [Route] HOME
\* ----------------------------------- */
    Finch.route('/', {
        setup: function(bindings) {
            section = "home";
            // Add favicon
            window.onload = favicon.load_favicon();
        },
        load: function(bindings) {
            viewNavbarMethod.viewNavbar();
            sticky_wrapper_methods.sticky_wrapper();

            addAttrNavAgenciesMethod.addAttrNav();
            currentSectionMethod.currentSection_home();
            viewSectionHomeMethod.viewSectionHome();

            windowWidthMethod.windowWidth();
            animatedMethods.animated();
            agentsMap.AgentsMap();
            agentsMap.loadAgentsMap();
            //agentMapMethod.agentMap();

            $(window).resize(mobile_menu_methods.has_menu_toggle);
            backToTopMethod.init_window_scroll_top();
            //hoverIconSocialMethod.hoverIconSocial();
            __sizeCheck($(window));
        },
        unload: function(bindings) {
            section = "";
            CAM.setHTML(domEl.div_recurren, '');
            removeRecurrentsMethod.removeRecurrents();
            currentSectionMethod.remove_currentSection();
        }
    });
/* ----------------------------------- *\
 [Route] AGENCIES NEWS
\* ----------------------------------- */
    Finch.route('/agencias/nuevos/:agn_name_agencia/:agn_url/:agn_id', {
        setup: function(bindings) {
            var agn_name, agn_url, agn_id;
            agn_name = bindings.agn_name_agencia;
            agn_url = bindings.agn_url;
            agn_id = bindings.agn_id;
            // GOOGLE ANALYTICS
            if ( agn_name === undefined && agn_url === undefined && agn_id === undefined ) {
                ga('send', 'pageview', '/agencias/nuevos');
            } else if ( agn_name !== undefined && agn_url === undefined && agn_id === undefined ) {
                ga('send', 'pageview', '/agencias/nuevos/' + agn_name);
            } else if ( agn_name !== undefined && agn_url !== undefined && agn_id !== undefined ) {
                ga('send', 'pageview', '/agencias/nuevos/' + agn_name + '/' + agn_url + '/' + agn_id);
            }
            // Add favicon
            window.onload = favicon.load_favicon();
        },
        load: function(bindings) {
            var agn_name, agn_url, agn_id;
            agn_name = bindings.agn_name_agencia;
            agn_url = bindings.agn_url;
            agn_id = bindings.agn_id;

            viewNavbarMethod.viewNavbar();
            sticky_wrapper_methods.sticky_wrapper();

            addAttrNavAgenciesMethod.addAttrNav();
            currentSectionMethod.currentSection_agencies_news();
            // TODAS LAS AGENCIAS NUEVOS
            if ( agn_name === undefined && agn_url === undefined && agn_id === undefined ) {
                section = "agencies-news";
                viewSectionAgenciesNewsMethod.viewSectionAgenciesNews();
            }
            // AGENCIA PRINCIPAL SELECCIONADA
            else if ( agn_name !== undefined && agn_url === undefined && agn_id === undefined ) {
                section = "agencies-news-principal";
                viewSectionAgenciesNewsPrincipalMethod.viewSectionAgenciesNewsPrincipal(agn_name, agn_url, agn_id);
                activeLogAgenciesNewsMethod.activeLogAgenciesNews(agn_name, agn_url, agn_id);
                if ( agn_name === 'volvo' ) {
                    CAM.loadTemplate(tempsNames.recurrent_agencies_news_by_agencies_video_strip_agencies, domEl._start_agencies_news_video_strip_name);
                    //console.log(agn_name);
                } else {
                    $(domEl._start_agencies_news_video_strip_name).remove();
                }
            }
            // SUB AGENCIA SELECCIONADA
            else if ( agn_name !== undefined && agn_url !== undefined && agn_id !== undefined ) {
                section = "agencies-news-sub-agencie";
                CAM.setValue(domEl.input_hidden_mapa, agn_id);
                viewSectionAgenciesNewsBySubAgencieMethod.viewSectionAgenciesNewsBySubAgencie(agn_name, agn_url, agn_id);
                activeLogAgenciesNewsMethod.activeLogAgenciesNews(agn_name, agn_url, agn_id);
            }
            // RUTA INVALIDA
            else {
                Finch.navigate('/agencias/nuevos');
            }
            animatedMethods.animated();
            $(window).resize(mobile_menu_methods.has_menu_toggle);
            backToTopMethod.init_window_scroll_top();
            //hoverIconSocialMethod.hoverIconSocial();
        },
        unload: function(bindings) {
            section = "";
            CAM.setHTML(domEl.div_recurren, '');
            removeRecurrentsMethod.removeRecurrents();
            currentSectionMethod.remove_currentSection();
            CAM.setValue('#hidden_brand', '0');
        }
    });
/* ----------------------------------- *\
 [Route] AGENCIES TRUCKS
\* ----------------------------------- */
    /*Finch.route('/agencias/camiones/:agn_name_agencia/:agn_url/:agn_id', {
        setup: function(bindings) {
            var agn_name, agn_url, agn_id;
            agn_name = bindings.agn_name_agencia;
            agn_url = bindings.agn_url;
            agn_id = bindings.agn_id;
            // GOOGLE ANALYTICS
            if ( agn_name === undefined && agn_url === undefined && agn_id === undefined ) {
                ga('send', 'pageview', '/agencias/camiones');
            } else if ( agn_name !== undefined && agn_url === undefined && agn_id === undefined ) {
                ga('send', 'pageview', '/agencias/camiones/' + agn_name);
            } else if ( agn_name !== undefined && agn_url !== undefined && agn_id !== undefined ) {
                ga('send', 'pageview', '/agencias/camiones/' + agn_name + '/' + agn_url + '/' + agn_id);
            }
            // Add favicon
            window.onload = favicon.load_favicon();
        },
        load: function(bindings) {
            var agn_name, agn_url, agn_id;
            agn_name = bindings.agn_name_agencia;
            agn_url = bindings.agn_url;
            agn_id = bindings.agn_id;

            viewNavbarMethod.viewNavbar();
            sticky_wrapper_methods.sticky_wrapper();

            addAttrNavAgenciesMethod.addAttrNav();
            currentSectionMethod.currentSection_agencies_trucks();
            // TODAS LAS AGENCIAS NUEVOS
            if ( agn_name === undefined && agn_url === undefined && agn_id === undefined ) {
                section = "agencies-trucks";
                viewSectionAgenciesTrucksMethod.viewSectionAgenciesTrucks();
            }
            // AGENCIA PRINCIPAL SELECCIONADA
            else if ( agn_name !== undefined && agn_url === undefined && agn_id === undefined ) {
                section = "agencies-trucks-principal";
                viewSectionAgenciesTrucksPrincipalMethod.viewSectionAgenciesTrucksPrincipal(agn_name, agn_url, agn_id);
                activeLogAgencieTrucksMethod.activeLogAgencieTrucks(agn_name, agn_url, agn_id);
            }
            // SUB AGENCIA SELECCIONADA
            else if ( agn_name !== undefined && agn_url !== undefined && agn_id !== undefined ) {
                section = "agencies-trucks-sub-agencie";
                CAM.setValue(domEl.input_hidden_mapa, agn_id);
                viewSectionAgenciesTrucksBySubAgencieMethod.viewSectionAgenciesTrucksBySubAgencie(agn_name, agn_url, agn_id);
                activeLogAgencieTrucksMethod.activeLogAgencieTrucks(agn_name, agn_url, agn_id);
            }
            // RUTA INVALIDA
            else {
                Finch.navigate('/agencias/camiones');
            }

            animatedMethods.animated();
            $(window).resize(mobile_menu_methods.has_menu_toggle);
            backToTopMethod.init_window_scroll_top();
            //hoverIconSocialMethod.hoverIconSocial();
        },
        unload: function(bindings) {
            section = "";
            CAM.setHTML(domEl.div_recurren, '');
            removeRecurrentsMethod.removeRecurrents();
            currentSectionMethod.remove_currentSection();
            CAM.setValue('#hidden_brand', '0');
        }
    });*/
/* ----------------------------------- *\
 [Route] AGENCIES PREOWNED
\* ----------------------------------- */
    Finch.route('/agencias/seminuevos/:preowned_agn_url/:preowned_agn_id', {
        setup: function(bindings) {
            var ga_agn_url, ga_agn_id;
            ga_agn_url = bindings.preowned_agn_url;
            ga_agn_id = bindings.preowned_agn_id;
            // GOOGLE ANALYTICS
            if ( ga_agn_url === undefined && ga_agn_id === undefined ) {
                ga('send', 'pageview', '/agencias/seminuevos');
            } else if ( ga_agn_url !== undefined && ga_agn_id !== undefined ) {
                ga('send', 'pageview', '/agencias/seminuevos/' + ga_agn_url + '/' + ga_agn_id);
            }
            // Add favicon
            window.onload = favicon.load_favicon();
        },
        load: function(bindings) {
            var agn_url, agn_id;
            agn_url = bindings.preowned_agn_url;
            agn_id = bindings.preowned_agn_id;

            viewNavbarMethod.viewNavbar();
            sticky_wrapper_methods.sticky_wrapper();

            addAttrNavAgenciesMethod.addAttrNav();
            currentSectionMethod.currentSection_agencies_preowned();

            if ( agn_url === undefined && agn_id === undefined ) {
                section = "agencies-preowned";
                viewSectionAgenciesPreownedMethod.viewSectionAgenciesPreowned();
            } else if ( agn_url !== undefined && agn_id !== undefined ) {
                section = "agencies_preowned_by_agencie";
                CAM.setValue(domEl.input_hidden_mapa, agn_id);
                viewSectionAgenciesPreownedByAgencieMethod.viewSectionAgenciesPreownedByAgencie(agn_url, agn_id);
                activeLogAgenciesPreownedMethod.activeLogAgenciesPreowned(agn_url, agn_id);
            }

            $(window).resize(mobile_menu_methods.has_menu_toggle);
            backToTopMethod.init_window_scroll_top();
            //hoverIconSocialMethod.hoverIconSocial();
            __sizeCheck($(window));
        },
        unload: function(bindings) {
            section = "";
            CAM.setHTML(domEl.div_recurren, '');
            removeRecurrentsMethod.removeRecurrents();
            currentSectionMethod.remove_currentSection();
        }
    });
/* ----------------------------------- *\
 [Route] INVENTORIES PREOWNED
\* ----------------------------------- */
    Finch.route('/seminuevos/inventarios/:mrcNombre/:mdoNombre/:senId', {
        setup: function(bindings) {
            var $brandNameGA, $modelNameGA, $semIdGA;
            $brandNameGA = bindings.mrcNombre;
            $modelNameGA = bindings.mdoNombre;
            $semIdGA = bindings.senId;
            // GOOGLE ANALYTICS
            if ( $brandNameGA === undefined && $modelNameGA === undefined && $semIdGA === undefined ) {
                ga('send', 'pageview', '/seminuevos/inventarios');
            } else if ( $brandNameGA !== undefined && $modelNameGA !== undefined && $semIdGA !== undefined ) {
                ga('send', 'pageview', '/seminuevos/inventarios/' + $brandNameGA + '/' + $modelNameGA );
            }
            // Add favicon
            window.onload = favicon.load_favicon();
        },
        load: function(bindings) {
            var $brandName, $modelName,  $semId;
            $brandName = bindings.mrcNombre;
            $modelName = bindings.mdoNombre;
            $semId = bindings.senId;

            viewNavbarMethod.viewNavbar();
            sticky_wrapper_methods.sticky_wrapper();

            addAttrNavAgenciesMethod.addAttrNav();
            currentSectionMethod.currentSection_inventories_preowned();


            if ( $brandName === undefined && $modelName === undefined && $semId === undefined ) {
                section = "inventories-preowned";
                viewSectionInventoriesPreownedMethod.viewSectionInventoriesPreowned();
            } else if ( $brandName !== undefined && $modelName !== undefined && $semId !== undefined ) {
                section = "inventories-preowned-details";
                viewSectionInventoriesPreownedMethodDetails.viewSectionInventoriesPreownedDetails($brandName, $modelName, $semId);
                owlCarouselMethods.owlCarousel();
                $("#vehicle-slider").owlCarousel();
            }
            sticky_wrapper_methods.sticky_wrapper_action_bar();
            $('.selectpicker').selectpicker();

            $(window).resize(mobile_menu_methods.has_menu_toggle);
            $(window).load(equalHeightsMethods.equalHeightsLoad);

            backToTopMethod.init_window_scroll_top();
            //hoverIconSocialMethod.hoverIconSocial();
            loadSlider();
        },
        unload: function(bindings) {
            section = "";
            CAM.setHTML(domEl.div_recurren, '');
            removeRecurrentsMethod.removeRecurrents();
            currentSectionMethod.remove_currentSection();
        }
    });
/* ----------------------------------- *\
 [Route] WHORKSHOP
\* ----------------------------------- */
    Finch.route('/talleres', {
        setup: function(bindings) {
            section = "workshop";
            ga('send', 'pageview', '/talleres');
            // Add favicon
            window.onload = favicon.load_favicon();
        },
        load: function(bindings) {
            viewNavbarMethod.viewNavbar();
            sticky_wrapper_methods.sticky_wrapper();

            addAttrNavAgenciesMethod.addAttrNav();
            currentSectionMethod.currentSection_workshop();

            viewSectionWorkShopMethod.viewSectionWorkShop();

            smoothScrollMethods.smoothScroll();

            bgImageHolderMethods.appendBgImageHolder2();
            $(window).resize(mobile_menu_methods.has_menu_toggle);
            backToTopMethod.init_window_scroll_top();
            //hoverIconSocialMethod.hoverIconSocial();
        },
        unload: function(bindings) {
            section = "";
            CAM.setHTML(domEl.div_recurren, '');
            removeRecurrentsMethod.removeRecurrents();
            currentSectionMethod.remove_currentSection();
        }
    });
/* ----------------------------------- *\
 [Route] RENTAL
\* ----------------------------------- */
    Finch.route('/rentas/:agnRental', {
        setup: function(bindings) {
            var $agnRentaGA = bindings.agnRental;
            section = "rental-agencie";
            ga('send', 'pageview', '/rentas/' + $agnRentaGA);
            // Add favicon
            window.onload = favicon.load_favicon();
        },
        load: function(bindings) {
            var $agnRenta = bindings.agnRental;

            viewNavbarMethod.viewNavbar();
            sticky_wrapper_methods.sticky_wrapper();

            addAttrNavAgenciesMethod.addAttrNav();
            currentSectionMethod.currentSection_rental();

            viewSectionRentalMethod.viewSectionRental($agnRenta);

            bgImageHolderMethods.appendBgImageHolder2();
            $(window).resize(mobile_menu_methods.has_menu_toggle);
            backToTopMethod.init_window_scroll_top();
            //hoverIconSocialMethod.hoverIconSocial();
        },
        unload: function(bindings) {
            section = "";
            CAM.setHTML(domEl.div_recurren, '');
            removeRecurrentsMethod.removeRecurrents();
            currentSectionMethod.remove_currentSection();
        }
    });
/* ----------------------------------- *\
 [Route] BLOG
\* ----------------------------------- */
    Finch.route('/noticias/:blogAgencie/:blog/:blogId', {
        setup: function(bindings) {
            var $dataAgencieGA, $dataBlogGA, $dataBlogIdGA;
            $dataAgencieGA = bindings.blogAgencie;
            $dataBlogGA = bindings.blog;
            $dataBlogIdGA = bindings.blogId;
            // GOOGLE ANALYTICS
            if ( $dataAgencieGA === undefined && $dataBlogGA === undefined && $dataBlogIdGA === undefined ) {
                ga( 'send', 'pageview', '/noticias' );
            } else if ( $dataAgencieGA !== undefined && $dataBlogGA !== undefined && $dataBlogIdGA !== undefined ) {
                ga( 'send', 'pageview', '/noticias/' + $dataAgencieGA + '/' + $dataBlogGA );
            }
            // Add favicon
            window.onload = favicon.load_favicon();
        },
        load: function(bindings) {
            var $dataAgencie, $dataBlog, $dataBlogId;
            $dataAgencie = bindings.blogAgencie;
            $dataBlog = bindings.blog;
            $dataBlogId = bindings.blogId;

            viewNavbarMethod.viewNavbar();
            sticky_wrapper_methods.sticky_wrapper();

            addAttrNavAgenciesMethod.addAttrNav();
            currentSectionMethod.currentSection_blog();
            if ( $dataAgencie === undefined && $dataBlog === undefined && $dataBlogId === undefined ) {
                section = "blog";
                viewSectionBlogMethod.viewSectionBlog();
            } else if ( $dataAgencie !== undefined && $dataBlog !== undefined && $dataBlogId !== undefined ) {
                section = 'blog-by-post';
                viewSectionBlogByNewsMethod.viewSectionBlogByNews($dataAgencie, $dataBlog, $dataBlogId);
                //console.log(section);
            }
            $(window).resize(mobile_menu_methods.has_menu_toggle);
            bgImageHolderMethods.appendBgImageHolder2();
            $(window).load(equalHeightsMethods.equalHeightsLoad);
            backToTopMethod.init_window_scroll_top();
            //hoverIconSocialMethod.hoverIconSocial();
            setWidthMethod.setWidth();
            loadSlider();
        },
        unload: function(bindings) {
            section = "";
            CAM.setHTML(domEl.div_recurren, '');
            removeRecurrentsMethod.removeRecurrents();
            currentSectionMethod.remove_currentSection();
        }
    });
/* ----------------------------------- *\
 [Route] ABOUT US
\* ----------------------------------- */
    Finch.route('/nosotros', {
        setup: function(bindings) {
            section = "about-us";
            ga('send', 'pageview', '/nosotros');
            // Add favicon
            window.onload = favicon.load_favicon();
        },
        load: function(bindings) {
            viewNavbarMethod.viewNavbar();
            sticky_wrapper_methods.sticky_wrapper();

            //viewHeroSliderMethod.viewHeroSlider();

            addAttrNavAgenciesMethod.addAttrNav();
            currentSectionMethod.currentSection_about_us();

            viewSectionAboutUsMethod.viewSectionAboutUs();

            animatedMethods.animated();
            $(window).resize(mobile_menu_methods.has_menu_toggle);
            backToTopMethod.init_window_scroll_top();
            //hoverIconSocialMethod.hoverIconSocial();
        },
        unload: function(bindings) {
            section = "";
            CAM.setHTML(domEl.div_recurren, '');
            removeRecurrentsMethod.removeRecurrents();
            currentSectionMethod.remove_currentSection();
        }
    });
/* ----------------------------------- *\
 [Route] CONTACT
\* ----------------------------------- */
    Finch.route('/contacto', {
        setup: function(bindings) {
            section = "about-us";
            ga('send', 'pageview', '/contacto');
            // Add favicon
            window.onload = favicon.load_favicon();
        },
        load: function(bindings) {
            viewNavbarMethod.viewNavbar();
            sticky_wrapper_methods.sticky_wrapper();

            addAttrNavAgenciesMethod.addAttrNav();
            currentSectionMethod.currentSection_contact();

            views_new_section_contact_method.views_new_section_contact();

            animatedMethods.animated();
            $(window).resize(mobile_menu_methods.has_menu_toggle);
            backToTopMethod.init_window_scroll_top();
            //hoverIconSocialMethod.hoverIconSocial();
        },
        unload: function(bindings) {
            section = "";
            CAM.setHTML(domEl.div_recurren, '');
            removeRecurrentsMethod.removeRecurrents();
            currentSectionMethod.remove_currentSection();
        }
    });
/* ----------------------------------- *\
 [Route] CONTACT
\* ----------------------------------- */
    Finch.route('/informacion', {
        setup: function(bindings) {
            section = "about-us";
            ga('send', 'pageview', '/informacion');
            // Add favicon
            window.onload = favicon.load_favicon();
        },
        load: function(bindings) {
            viewNavbarMethod.viewNavbar();
            sticky_wrapper_methods.sticky_wrapper();

            addAttrNavAgenciesMethod.addAttrNav();
            currentSectionMethod.currentSection_contact();

            viewSectionContactMethod.viewSectionContact();

            animatedMethods.animated();
            $(window).resize(mobile_menu_methods.has_menu_toggle);
            backToTopMethod.init_window_scroll_top();
            //hoverIconSocialMethod.hoverIconSocial();
        },
        unload: function(bindings) {
            section = "";
            CAM.setHTML(domEl.div_recurren, '');
            removeRecurrentsMethod.removeRecurrents();
            currentSectionMethod.remove_currentSection();
        }
    });
/* ----------------------------------- *\
 [Route] JOB OPPORTUNITIES
\* ----------------------------------- */
    Finch.route('/bolsa-de-trabajo', {
        setup: function(bindings) {
            section = "about-us";
            ga('send', 'pageview', '/bolsa-de-trabajo');
            // Add favicon
            window.onload = favicon.load_favicon();
        },
        load: function(bindings) {
            viewNavbarMethod.viewNavbar();
            sticky_wrapper_methods.sticky_wrapper();

            addAttrNavAgenciesMethod.addAttrNav();
            currentSectionMethod.currentSection_job_opportunites();

            viewSectionJobOpportunitiesMethod.viewSectionJobOpportunities();
            formJobOpportunitiesMethod.refreshForm();
            customFileMethods.handleFileSelect();

            animatedMethods.animated();
            $(window).resize(mobile_menu_methods.has_menu_toggle);
            backToTopMethod.init_window_scroll_top();
            //hoverIconSocialMethod.hoverIconSocial();
        },
        unload: function(bindings) {
            section = "";
            CAM.setHTML(domEl.div_recurren, '');
            removeRecurrentsMethod.removeRecurrents();
            currentSectionMethod.remove_currentSection();
        }
    });
/* ----------------------------------- *\
 [Route] ABOUT US
\* ----------------------------------- */
    Finch.route('/aviso-de-privacidad', {
        setup: function(bindings) {
            section = "privacy-notice";
            ga('send', 'pageview', '/aviso_de_privacidad');
            // Add favicon
            window.onload = favicon.load_favicon();
        },
        load: function(bindings) {
            viewNavbarMethod.viewNavbar();
            sticky_wrapper_methods.sticky_wrapper();

            addAttrNavAgenciesMethod.addAttrNav();
            viewSectionPrivacyNoticeMethod.viewSectionPrivacyNotice();

            $(window).resize(mobile_menu_methods.has_menu_toggle);
            backToTopMethod.init_window_scroll_top();
            //hoverIconSocialMethod.hoverIconSocial();
        },
        unload: function(bindings) {
            section = "";
            CAM.setHTML(domEl.div_recurren, '');
            removeRecurrentsMethod.removeRecurrents();
            currentSectionMethod.remove_currentSection();
        }
    });
Finch.listen();

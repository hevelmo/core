/* ----------------------------------- *\
 [Route] HOME
\* ----------------------------------- */
Finch.route('/', {
    setup: function(bindings) {
    },
    load: function(bindings) {
        DEX.loadTemplate("temp_coming_soon", domEl.div_recurrent);
        //DEX.loadTemplate(tempsNames.temp_section_image_block, domEl.div_recurrent);
        //DEX.loadTemplate(tempsNames.temp_section_slider, domEl.div_recurrent_slider);
        //DEX.loadTemplate(tempsNames.temp_section_pricing, domEl.div_recurrent_pricing);
        //DEX.loadTemplate(tempsNames.temp_section_video, domEl.div_recurrent_video);
        //DEX.loadTemplate(tempsNames.temp_section_map_contact, domEl.div_recurrent_map);
        initMapMethods.initialize();
        initMapMethods.loadInit();
        DEX.loadTemplate(tempsNames.temp_section_address_contact, domEl.div_recurrent_address);
    },
    unload: function(bindings) {
        DEX.setHTML(domEl.div_recurren, '');
    }
});
Finch.listen();

/* ----------------------------------- *\
 [Route] HOME
\* ----------------------------------- */
    Finch.route('/', {
        setup: function(bindings) {
            // Add favicon
            //window.onload = favicon.load_favicon();
            section = "home";
        },
        load: function(bindings) {
            //addText.addTexto();
            //viewSectionHomeMethod.viewSectionHome();
        },
        unload: function(bindings) {
            section = "";
            COR.setHTML(domEl.div_recurren, '');
        }
    });
Finch.listen();

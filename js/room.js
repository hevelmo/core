/* ----------------------------------- *\
 [Route] HOME
\* ----------------------------------- */
    Finch.route('/', {
        setup: function(bindings) {
            // Add favicon
            //window.onload = favicon.load_favicon();
            //section = "home";
        },
        load: function(bindings) {
        },
        unload: function(bindings) {
            section = "";
            PRO.setHTML(domEl.div_recurren, '');
        }
    });
Finch.listen();

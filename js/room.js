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
            //This code will be not used it's only example, remove it later
            var data, post;
            data = PRO.getInternalJSON(urlsApi.get_test);
            post = PRO.postalService(urlsApi.post_test);
            post.success(function(data){
                console.log(data);
            });
            post.error(function(data){
                alert("suerte para la proxima, sigue participando...")
            });
            PRO.loadTemplate(tempsNames.tmp_demo, domEl.div_recurrent, data)
        },
        unload: function(bindings) {
            section = "";
            PRO.setHTML(domEl.div_recurren, '');
        }
    });
Finch.listen();

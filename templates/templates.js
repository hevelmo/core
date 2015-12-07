(function() {
  var template = Handlebars.template, templates = Handlebars.templates = Handlebars.templates || {};
templates['tmp_app_thecompiler'] = template({"compiler":[7,">= 4.0.0"],"main":function(container,depth0,helpers,partials,data) {
    return "<label id=\"label-name-project\" for=\"\">PROJECT</label>\n<div id=\"main-compiler\">\n    <form name=\"form-compiler\" method=\"post\" accept-charset=\"utf-8\">\n        <input type=\"hidden\" name=\"iHidden\" value=\"execute\">\n        <input type=\"submit\" name=\"execute-site\" id=\"execute-site\" class=\"execute_site\" value=\"Compilar\">\n    </form>\n</div>\n";
},"useData":true});
})();
(function() {
  var template = Handlebars.template, templates = Handlebars.templates = Handlebars.templates || {};
templates['tmp_demo'] = template({"compiler":[7,">= 4.0.0"],"main":function(container,depth0,helpers,partials,data) {
    var stack1;

  return "<br />\n<div align='center'>\n	<select id='lan-demo'>\n		<option value='es'>Español</option>\n		<option value='en'>English</option>\n	</select>\n	<h3 id='demo-date' data-date='"
    + container.escapeExpression(container.lambda(((stack1 = (depth0 != null ? depth0.propa : depth0)) != null ? stack1.date : stack1), depth0))
    + "'><h3>\n</div>\n<script>\n	var date;\n	date = $('h3#demo-date').data('date');\n	newDate = PRO.momentToRoman(date, 'es');\n	$('h3#demo-date').text(newDate);\n</script>\n";
},"useData":true});
})();
<?php

/* super.twig */
class __TwigTemplate_74346719f63bbc665b6d7b263afcaa7522998ac299f8a4537d810a299ab855ab extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'metas' => array($this, 'block_metas'),
            'title' => array($this, 'block_title'),
            'links' => array($this, 'block_links'),
            'head_scripts' => array($this, 'block_head_scripts'),
            'content_recurrent' => array($this, 'block_content_recurrent'),
            'body_scripts' => array($this, 'block_body_scripts'),
            'load_scripts' => array($this, 'block_load_scripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang=\"es\" class=\"no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7\"> <![endif]-->
<!--[if IE 7]>         <html lang=\"es\" class=\"no-js lt-ie10 lt-ie9 lt-ie8\"> <![endif]-->
<!--[if IE 8]>         <html lang=\"es\" class=\"no-js lt-ie10 lt-ie9\"> <![endif]-->
<!--[if IE 9]>         <html lang=\"es\" class=\"no-js lt-ie10\"> <![endif]-->
<html class=\"no-js\" lang=\"es\">
    <head>
        ";
        // line 8
        $this->displayBlock('head', $context, $blocks);
        // line 79
        echo "    </head>
    <body id=\"index\" class=\"sitio\">
        <input id=\"master-host\" type=\"hidden\" value=\"";
        // line 81
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "\">
        <input id=\"master-intranet\" type=\"hidden\" value=\"";
        // line 82
        echo twig_escape_filter($this->env, (isset($context["_intranet"]) ? $context["_intranet"] : null), "html", null, true);
        echo "\">
        <input id=\"master-admin\" type=\"hidden\" value=\"";
        // line 83
        echo twig_escape_filter($this->env, (isset($context["_admin"]) ? $context["_admin"] : null), "html", null, true);
        echo "\">
        <input id=\"master-sitio\" type=\"hidden\" value=\"";
        // line 84
        echo twig_escape_filter($this->env, (isset($context["_sitio"]) ? $context["_sitio"] : null), "html", null, true);
        echo "\">
        <input id=\"master-seminuevos\" type=\"hidden\" value=\"";
        // line 85
        echo twig_escape_filter($this->env, (isset($context["_seminuevos"]) ? $context["_seminuevos"] : null), "html", null, true);
        echo "\">
        <input id=\"master-inventarios\" type=\"hidden\" value=\"";
        // line 86
        echo twig_escape_filter($this->env, (isset($context["_inventarios"]) ? $context["_inventarios"] : null), "html", null, true);
        echo "\">
        <input id=\"master-detalles\" type=\"hidden\" value=\"";
        // line 87
        echo twig_escape_filter($this->env, (isset($context["_detalles"]) ? $context["_detalles"] : null), "html", null, true);
        echo "\">
        ";
        // line 89
        echo "        <div id=\"hidden-inputs-session\"></div>
        ";
        // line 91
        echo "        <div id=\"hidden-inputs-temporal\"></div>
        ";
        // line 92
        $this->loadTemplate("super.twig", "super.twig", 92, "2130691114")->display($context);
        // line 93
        echo "        ";
        // line 94
        echo "        <div class=\"wrapper_content_interactive\" id='content-temporal-interactive'>
            ";
        // line 95
        $this->displayBlock('content_recurrent', $context, $blocks);
        echo "  
        </div>
        ";
        // line 97
        $this->loadTemplate("super.twig", "super.twig", 97, "145652794")->display($context);
        // line 98
        echo "        <a href=\"#0\" class=\"back-to-top cd-top no-print\">top</a>
        ";
        // line 99
        $this->displayBlock('body_scripts', $context, $blocks);
        // line 114
        echo "        <script>";
        $this->displayBlock('load_scripts', $context, $blocks);
        echo "</script>
    </body>
</html>
";
    }

    // line 8
    public function block_head($context, array $blocks = array())
    {
        // line 9
        echo "            ";
        $this->displayBlock('metas', $context, $blocks);
        // line 19
        echo "            <title id=\"head-change-section-title\">
                ";
        // line 20
        $this->displayBlock('title', $context, $blocks);
        // line 21
        echo "            </title>
            ";
        // line 22
        $this->displayBlock('links', $context, $blocks);
        // line 29
        echo "            ";
        $this->displayBlock('head_scripts', $context, $blocks);
        // line 78
        echo "        ";
    }

    // line 9
    public function block_metas($context, array $blocks = array())
    {
        // line 10
        echo "                <meta http-equiv=\"X-UA-Compatible\" content=\"IE=EmulateIE7\">
                <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">
                <meta http-equiv=\"cache-control\" content=\"no-cache\">
                <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
                <meta name=\"viewport\" content=\"width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0\">
                <meta class=\"temp\" name=\"description\" content=\"CAMCAR Grupo Automotriz - Es el resultado de un equipo que se adapta al cambio sumando experiencia, fuerza y calidad de servicio adquiridos en 25 años de trabajo y presencia de marcas en el occidente del país. Nacimos con la VISION DE SER LIDER DEL MERCADO al que hoy atendemos con la mayor oferta marcas automotrices.\">
                <meta class=\"temp\" name=\"copyright\" content=\"© Copyright 2016 Camcar Grupo Automotriz.\">
                <meta class=\"temp\" name=\"robots\" content=\"index, follow\">
            ";
    }

    // line 20
    public function block_title($context, array $blocks = array())
    {
        echo "Camcar Grupo Automotriz";
    }

    // line 22
    public function block_links($context, array $blocks = array())
    {
        // line 23
        echo "                <link class=\"temp\" rel=\"alternate\" hreflang=\"es-MX\" href=\"http://camcar.mx/sitio\" />
                <link href=\"http://fonts.googleapis.com/css?family=Roboto:100,400,300,700,400italic,500%7CMontserrat:400,700\" rel=\"stylesheet\" type=\"text/css\">
                <link rel=\"stylesheet\" href=\"";
        // line 25
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "css/import-sitio.css\">
                <link type=\"image/x-icon\" rel=\"shortcut icon\" href=\"";
        // line 26
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "img/ico/camcaricon.ico\">
                <link rel=\"apple-touch-icon\" href=\"";
        // line 27
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "img/ico/apple-touch-icon.png\">
            ";
    }

    // line 29
    public function block_head_scripts($context, array $blocks = array())
    {
        // line 30
        echo "                <!--[if lt IE 9]>
                <script src=\"";
        // line 31
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "lib/assets/plugins/html5shiv/html5shiv.min.js\"></script>
                <![endif]-->
                <!--[if lt IE 10]>
                <script src=\"";
        // line 34
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "lib/assets/plugins/media-match/media.match.min.js\"></script>
                <script src=\"";
        // line 35
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "lib/assets/plugins/respond/respond.min.js\"></script>
                <![endif]-->
                <script async=\"\" src=\"//www.google-analytics.com/analytics.js\"></script>
                <script>
                    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
                    
                    ga('create', 'UA-60582942-1', 'auto');
                    ga('send', 'pageview');
                </script>
                <script>
                    var nav = navigator.appName;
                    if(nav == \"Microsoft Internet Explorer\"){
                        //Detectamos si nos visitan desde IE
                        if(nav == \"Microsoft Internet Explorer\"){
                            //Convertimos en minusculas la cadena que devuelve userAgent
                            var ie = navigator.userAgent.toLowerCase();
                            //Extraemos de la cadena la version de IE
                            var version = parseInt(ie.split('msie')[1]);
                            //Dependiendo de la version mostramos un resultado
                            switch(version){
                                case 6:
                                    alert(\"El sitio no es compatible con Internet Explorer, te recomendamos usar Chrome o Firefox.\");
                                    break;
                                case 7:
                                    alert(\"El sitio no es compatible con Internet Explorer, te recomendamos usar Chrome o Firefox.\");
                                    break;
                                case 8:
                                    alert(\"El sitio no es compatible con Internet Explorer, te recomendamos usar Chrome o Firefox.\");
                                    break;
                                /*
                                case 9:
                                    alert(\"El sitio no es compatible con Internet Explorer, te recomendamos usar Chrome o Firefox.\");
                                    break;
                                */
                            }
                        }
                    }
                </script>
                <script src=\"";
        // line 76
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "lib/modernizr.js\"></script>
            ";
    }

    // line 95
    public function block_content_recurrent($context, array $blocks = array())
    {
    }

    // line 99
    public function block_body_scripts($context, array $blocks = array())
    {
        // line 100
        echo "            ";
        // line 101
        echo "            <script src=\"";
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "lib/min/lib-core-seminuevos.min.js\"></script>
            ";
        // line 103
        echo "            <script type=\"text/javascript\" src=\"https://maps.googleapis.com/maps/api/js?sensor=true&libraries=geometry&libraries=places&key=AIzaSyCCqo-F2TnMAABZvfV5yTQLlWvUCJlJViU&amp;sensor=false\"></script>
            ";
        // line 105
        echo "            <script src=\"";
        echo twig_escape_filter($this->env, (isset($context["_seminuevos"]) ? $context["_seminuevos"] : null), "html", null, true);
        echo "templates/handlebars/min/templates.min.js\"></script>
            ";
        // line 107
        echo "            <script src=\"";
        echo twig_escape_filter($this->env, (isset($context["_seminuevos"]) ? $context["_seminuevos"] : null), "html", null, true);
        echo "js/min/core.min.js\"></script>
            ";
        // line 113
        echo "        ";
    }

    // line 114
    public function block_load_scripts($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "super.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  267 => 114,  263 => 113,  258 => 107,  253 => 105,  250 => 103,  245 => 101,  243 => 100,  240 => 99,  235 => 95,  229 => 76,  185 => 35,  181 => 34,  175 => 31,  172 => 30,  169 => 29,  163 => 27,  159 => 26,  155 => 25,  151 => 23,  148 => 22,  142 => 20,  130 => 10,  127 => 9,  123 => 78,  120 => 29,  118 => 22,  115 => 21,  113 => 20,  110 => 19,  107 => 9,  104 => 8,  95 => 114,  93 => 99,  90 => 98,  88 => 97,  83 => 95,  80 => 94,  78 => 93,  76 => 92,  73 => 91,  70 => 89,  66 => 87,  62 => 86,  58 => 85,  54 => 84,  50 => 83,  46 => 82,  42 => 81,  38 => 79,  36 => 8,  27 => 1,);
    }
}


/* super.twig */
class __TwigTemplate_74346719f63bbc665b6d7b263afcaa7522998ac299f8a4537d810a299ab855ab_2130691114 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 92
        $this->parent = $this->loadTemplate("super_navbar.twig", "super.twig", 92);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "super_navbar.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "super.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  296 => 92,  267 => 114,  263 => 113,  258 => 107,  253 => 105,  250 => 103,  245 => 101,  243 => 100,  240 => 99,  235 => 95,  229 => 76,  185 => 35,  181 => 34,  175 => 31,  172 => 30,  169 => 29,  163 => 27,  159 => 26,  155 => 25,  151 => 23,  148 => 22,  142 => 20,  130 => 10,  127 => 9,  123 => 78,  120 => 29,  118 => 22,  115 => 21,  113 => 20,  110 => 19,  107 => 9,  104 => 8,  95 => 114,  93 => 99,  90 => 98,  88 => 97,  83 => 95,  80 => 94,  78 => 93,  76 => 92,  73 => 91,  70 => 89,  66 => 87,  62 => 86,  58 => 85,  54 => 84,  50 => 83,  46 => 82,  42 => 81,  38 => 79,  36 => 8,  27 => 1,);
    }
}


/* super.twig */
class __TwigTemplate_74346719f63bbc665b6d7b263afcaa7522998ac299f8a4537d810a299ab855ab_145652794 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 97
        $this->parent = $this->loadTemplate("super_footer.twig", "super.twig", 97);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "super_footer.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "super.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  336 => 97,  296 => 92,  267 => 114,  263 => 113,  258 => 107,  253 => 105,  250 => 103,  245 => 101,  243 => 100,  240 => 99,  235 => 95,  229 => 76,  185 => 35,  181 => 34,  175 => 31,  172 => 30,  169 => 29,  163 => 27,  159 => 26,  155 => 25,  151 => 23,  148 => 22,  142 => 20,  130 => 10,  127 => 9,  123 => 78,  120 => 29,  118 => 22,  115 => 21,  113 => 20,  110 => 19,  107 => 9,  104 => 8,  95 => 114,  93 => 99,  90 => 98,  88 => 97,  83 => 95,  80 => 94,  78 => 93,  76 => 92,  73 => 91,  70 => 89,  66 => 87,  62 => 86,  58 => 85,  54 => 84,  50 => 83,  46 => 82,  42 => 81,  38 => 79,  36 => 8,  27 => 1,);
    }
}
/* <!DOCTYPE html>*/
/* <!--[if lt IE 7]>      <html lang="es" class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->*/
/* <!--[if IE 7]>         <html lang="es" class="no-js lt-ie10 lt-ie9 lt-ie8"> <![endif]-->*/
/* <!--[if IE 8]>         <html lang="es" class="no-js lt-ie10 lt-ie9"> <![endif]-->*/
/* <!--[if IE 9]>         <html lang="es" class="no-js lt-ie10"> <![endif]-->*/
/* <html class="no-js" lang="es">*/
/*     <head>*/
/*         {% block head %}*/
/*             {% block metas %}*/
/*                 <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">*/
/*                 <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">*/
/*                 <meta http-equiv="cache-control" content="no-cache">*/
/*                 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">*/
/*                 <meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0">*/
/*                 <meta class="temp" name="description" content="CAMCAR Grupo Automotriz - Es el resultado de un equipo que se adapta al cambio sumando experiencia, fuerza y calidad de servicio adquiridos en 25 años de trabajo y presencia de marcas en el occidente del país. Nacimos con la VISION DE SER LIDER DEL MERCADO al que hoy atendemos con la mayor oferta marcas automotrices.">*/
/*                 <meta class="temp" name="copyright" content="© Copyright 2016 Camcar Grupo Automotriz.">*/
/*                 <meta class="temp" name="robots" content="index, follow">*/
/*             {% endblock %}*/
/*             <title id="head-change-section-title">*/
/*                 {% block title %}Camcar Grupo Automotriz{% endblock %}*/
/*             </title>*/
/*             {% block links %}*/
/*                 <link class="temp" rel="alternate" hreflang="es-MX" href="http://camcar.mx/sitio" />*/
/*                 <link href="http://fonts.googleapis.com/css?family=Roboto:100,400,300,700,400italic,500%7CMontserrat:400,700" rel="stylesheet" type="text/css">*/
/*                 <link rel="stylesheet" href="{{ _host }}css/import-sitio.css">*/
/*                 <link type="image/x-icon" rel="shortcut icon" href="{{ _host }}img/ico/camcaricon.ico">*/
/*                 <link rel="apple-touch-icon" href="{{ _host }}img/ico/apple-touch-icon.png">*/
/*             {% endblock %}*/
/*             {% block head_scripts %}*/
/*                 <!--[if lt IE 9]>*/
/*                 <script src="{{ _host }}lib/assets/plugins/html5shiv/html5shiv.min.js"></script>*/
/*                 <![endif]-->*/
/*                 <!--[if lt IE 10]>*/
/*                 <script src="{{ _host }}lib/assets/plugins/media-match/media.match.min.js"></script>*/
/*                 <script src="{{ _host }}lib/assets/plugins/respond/respond.min.js"></script>*/
/*                 <![endif]-->*/
/*                 <script async="" src="//www.google-analytics.com/analytics.js"></script>*/
/*                 <script>*/
/*                     (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){*/
/*                     (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),*/
/*                     m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)*/
/*                     })(window,document,'script','//www.google-analytics.com/analytics.js','ga');*/
/*                     */
/*                     ga('create', 'UA-60582942-1', 'auto');*/
/*                     ga('send', 'pageview');*/
/*                 </script>*/
/*                 <script>*/
/*                     var nav = navigator.appName;*/
/*                     if(nav == "Microsoft Internet Explorer"){*/
/*                         //Detectamos si nos visitan desde IE*/
/*                         if(nav == "Microsoft Internet Explorer"){*/
/*                             //Convertimos en minusculas la cadena que devuelve userAgent*/
/*                             var ie = navigator.userAgent.toLowerCase();*/
/*                             //Extraemos de la cadena la version de IE*/
/*                             var version = parseInt(ie.split('msie')[1]);*/
/*                             //Dependiendo de la version mostramos un resultado*/
/*                             switch(version){*/
/*                                 case 6:*/
/*                                     alert("El sitio no es compatible con Internet Explorer, te recomendamos usar Chrome o Firefox.");*/
/*                                     break;*/
/*                                 case 7:*/
/*                                     alert("El sitio no es compatible con Internet Explorer, te recomendamos usar Chrome o Firefox.");*/
/*                                     break;*/
/*                                 case 8:*/
/*                                     alert("El sitio no es compatible con Internet Explorer, te recomendamos usar Chrome o Firefox.");*/
/*                                     break;*/
/*                                 /**/
/*                                 case 9:*/
/*                                     alert("El sitio no es compatible con Internet Explorer, te recomendamos usar Chrome o Firefox.");*/
/*                                     break;*/
/*                                 *//* */
/*                             }*/
/*                         }*/
/*                     }*/
/*                 </script>*/
/*                 <script src="{{ _host }}lib/modernizr.js"></script>*/
/*             {% endblock %}*/
/*         {% endblock %}*/
/*     </head>*/
/*     <body id="index" class="sitio">*/
/*         <input id="master-host" type="hidden" value="{{ _host }}">*/
/*         <input id="master-intranet" type="hidden" value="{{ _intranet }}">*/
/*         <input id="master-admin" type="hidden" value="{{ _admin }}">*/
/*         <input id="master-sitio" type="hidden" value="{{ _sitio }}">*/
/*         <input id="master-seminuevos" type="hidden" value="{{ _seminuevos }}">*/
/*         <input id="master-inventarios" type="hidden" value="{{ _inventarios }}">*/
/*         <input id="master-detalles" type="hidden" value="{{ _detalles }}">*/
/*         {# Auxiliar Temporal Inputs's DIV #}*/
/*         <div id="hidden-inputs-session"></div>*/
/*         {# Auxiliar Temporal Inputs's DIV #}*/
/*         <div id="hidden-inputs-temporal"></div>*/
/*         {% embed "super_navbar.twig" %}{% endembed %}*/
/*         {# Templates's DIV #}*/
/*         <div class="wrapper_content_interactive" id='content-temporal-interactive'>*/
/*             {% block content_recurrent %}{% endblock %}  */
/*         </div>*/
/*         {% embed "super_footer.twig" %}{% endembed %}*/
/*         <a href="#0" class="back-to-top cd-top no-print">top</a>*/
/*         {% block body_scripts %}*/
/*             {# CORE LIBS #}*/
/*             <script src="{{ _host }}lib/min/lib-core-seminuevos.min.js"></script>*/
/*             {# GOOGLE API #}*/
/*             <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true&libraries=geometry&libraries=places&key=AIzaSyCCqo-F2TnMAABZvfV5yTQLlWvUCJlJViU&amp;sensor=false"></script>*/
/*             {# TEMPLATES #}*/
/*             <script src="{{ _seminuevos }}templates/handlebars/min/templates.min.js"></script>*/
/*             {# OLD STRUCTURE #}*/
/*             <script src="{{ _seminuevos }}js/min/core.min.js"></script>*/
/*             {#*/
/*                 <script src="{{ _seminuevos }}js/method.js"></script>*/
/*                 <script src="{{ _sitio }}js/model.js"></script>*/
/*                 <script src="{{ _seminuevos }}js/main.js"></script>*/
/*             #}*/
/*         {% endblock %}*/
/*         <script>{% block load_scripts %}{% endblock %}</script>*/
/*     </body>*/
/* </html>*/
/* */

<?php

/* super.twig */
class __TwigTemplate_96a09ca85d48793d10ce58798e1237a0bb0c74b32ea0febc3ee7bf6a8b39c9d0 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'links' => array($this, 'block_links'),
            'preloader' => array($this, 'block_preloader'),
            'header_nav' => array($this, 'block_header_nav'),
            'content_current' => array($this, 'block_content_current'),
            'top_button' => array($this, 'block_top_button'),
            'body_scripts' => array($this, 'block_body_scripts'),
            'load_scripts' => array($this, 'block_load_scripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang=\"es-MX\" class=\"no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7\"> <![endif]-->
<!--[if IE 7]>         <html lang=\"es-MX\" class=\"no-js lt-ie10 lt-ie9 lt-ie8\"> <![endif]-->
<!--[if IE 8]>         <html lang=\"es-MX\" class=\"no-js lt-ie10 lt-ie9\"> <![endif]-->
<!--[if IE 9]>         <html lang=\"es-MX\" class=\"no-js lt-ie10\"> <![endif]-->
    <html class=\"no-js\" lang=\"es\">
        <head>
            ";
        // line 8
        $this->displayBlock('head', $context, $blocks);
        // line 73
        echo "            ";
        // line 78
        echo "        <head>
        <body data-spy=\"scroll\" data-target=\"#main-navbar\">
            ";
        // line 80
        $this->displayBlock('preloader', $context, $blocks);
        // line 82
        echo "            <div class=\"main-container\" id=\"page\">
                ";
        // line 84
        echo "                ";
        $this->displayBlock('header_nav', $context, $blocks);
        // line 86
        echo "                ";
        // line 87
        echo "                ";
        $this->displayBlock('content_current', $context, $blocks);
        // line 89
        echo "            </div>";
        // line 90
        echo "
            ";
        // line 91
        $this->displayBlock('top_button', $context, $blocks);
        // line 93
        echo "
            ";
        // line 94
        $this->displayBlock('body_scripts', $context, $blocks);
        // line 121
        echo "
            <script>";
        // line 122
        $this->displayBlock('load_scripts', $context, $blocks);
        echo "</script>
        </body>
    </html>";
    }

    // line 8
    public function block_head($context, array $blocks = array())
    {
        // line 9
        echo "                <meta charset=\"utf-8\">
                <meta http-equiv=\"X-UA-Compatible\" content=\"IE=EmulateIE7\" />
                <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">
                <meta http-equiv='cache-control' content='no-cache' />
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
                <meta name='viewport' content='width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0' />

                <meta name=\"title\" content=\"";
        // line 16
        echo twig_escape_filter($this->env, (isset($context["_title"]) ? $context["_title"] : null), "html", null, true);
        echo "\">
                <meta name=\"identifier-url\" content=\"";
        // line 17
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "\" />
                <meta name=\"description\" content=\"Nupali, Trabajando juntos por un espacio en equilibrio.\" />
                <meta name=\"keywords\" content=\"Nupali, Nosotros, Como Ayudar, Legal, Proyectos, Ayudar, Contacto, Resultados, Noticias\" />
                <meta name=\"author\" content=\"Develpment Mandala Web -> Heriberto Velasco Mora <- Front End.\">
                <meta itemprop=\"image\" content=\"";
        // line 21
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "img/logo/nupali.png\">

                ";
        // line 24
        echo "                <title>
                    ";
        // line 25
        $this->displayBlock('title', $context, $blocks);
        // line 28
        echo "                </title>

                ";
        // line 30
        $this->displayBlock('links', $context, $blocks);
        // line 65
        echo "
                ";
        // line 67
        echo "                ";
        // line 68
        echo "                <!--[if lt IE 9]>
                  <script src=\"https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js\"></script>
                  <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
                <![endif]-->
            ";
    }

    // line 25
    public function block_title($context, array $blocks = array())
    {
        // line 26
        echo "                        ";
        echo twig_escape_filter($this->env, (isset($context["_title"]) ? $context["_title"] : null), "html", null, true);
        echo "
                    ";
    }

    // line 30
    public function block_links($context, array $blocks = array())
    {
        // line 31
        echo "                    ";
        // line 32
        echo "                    ";
        // line 33
        echo "                    <link rel=\"shortcut icon\" href=\"";
        echo twig_escape_filter($this->env, (isset($context["_host "]) ? $context["_host "] : null), "html", null, true);
        echo "img/favicon.ico\" type=\"image/x-icon\">
                    <link rel=\"icon\" href=\"";
        // line 34
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "img/favicon.ico\" type=\"image/x-icon\">

                    ";
        // line 37
        echo "                    ";
        // line 38
        echo "                    <!-- =========================
                         STYLESHEETS
                    ============================== -->
                    <!-- BOOTSTRAP CSS -->
                    <link rel=\"stylesheet\" href=\"";
        // line 42
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "css/assets/plugins/bootstrap.min.css\">

                    <!-- FONT ICONS -->
                    <link rel=\"stylesheet\" href=\"";
        // line 45
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "css/assets/icons/iconfont.css\">
                    <link rel=\"stylesheet\" href=\"http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css\">

                    <!-- GOOGLE FONTS -->
                    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>

                    <!-- PLUGINS STYLESHEET -->
                    <link rel=\"stylesheet\" href=\"";
        // line 52
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "css/assets/plugins/magnific-popup.css\">
                    <link rel=\"stylesheet\" href=\"";
        // line 53
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "css/assets/plugins/owl.carousel.css\">
                    <link rel=\"stylesheet\" href=\"";
        // line 54
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "css/assets/plugins/loaders.css\">
                    <link rel=\"stylesheet\" href=\"";
        // line 55
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "css/assets/plugins/animate.css\">
                    <link rel=\"stylesheet\" href=\"";
        // line 56
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "css/assets/plugins/pickadate-default.css\">
                    <link rel=\"stylesheet\" href=\"";
        // line 57
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "css/assets/plugins/pickadate-default.date.css\">

                    <!-- CUSTOM STYLESHEET -->
                    <link rel=\"stylesheet\" href=\"";
        // line 60
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "css/assets/style.css\">

                    <!-- RESPONSIVE FIXES -->
                    <link rel=\"stylesheet\" href=\"";
        // line 63
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "css/assets/responsive.css\">
                ";
    }

    // line 80
    public function block_preloader($context, array $blocks = array())
    {
        // line 81
        echo "            ";
    }

    // line 84
    public function block_header_nav($context, array $blocks = array())
    {
        // line 85
        echo "                ";
    }

    // line 87
    public function block_content_current($context, array $blocks = array())
    {
        // line 88
        echo "                ";
    }

    // line 91
    public function block_top_button($context, array $blocks = array())
    {
        // line 92
        echo "            ";
    }

    // line 94
    public function block_body_scripts($context, array $blocks = array())
    {
        // line 95
        echo "                <script src=\"";
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "lib/assets/plugins/jquery1.11.2.min.js\"></script>
                <script src=\"";
        // line 96
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "lib/assets/plugins/bootstrap.min.js\"></script>
                <script src=\"";
        // line 97
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "lib/assets/plugins/jquery.easing.1.3.min.js\"></script>
                <script src=\"";
        // line 98
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "lib/assets/plugins/jquery.countTo.js\"></script>
                <script src=\"";
        // line 99
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "lib/assets/plugins/jquery.formchimp.min.js\"></script>
                <script src=\"";
        // line 100
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "lib/assets/plugins/jquery.jCounter-0.1.4.js\"></script>
                <script src=\"";
        // line 101
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "lib/assets/plugins/jquery.magnific-popup.min.js\"></script>
                <script src=\"";
        // line 102
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "lib/assets/plugins/jquery.vide.min.js\"></script>
                <script src=\"";
        // line 103
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "lib/assets/plugins/owl.carousel.min.js\"></script>
                <script src=\"";
        // line 104
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "lib/assets/plugins/spectragram.min.js\"></script>
                <script src=\"";
        // line 105
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "lib/assets/plugins/twitterFetcher_min.js\"></script>
                <script src=\"";
        // line 106
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "lib/assets/plugins/wow.min.js\"></script>
                <script src=\"";
        // line 107
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "lib/assets/plugins/picker.js\"></script>
                <script src=\"";
        // line 108
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "lib/assets/plugins/picker.date.js\"></script>
                ";
        // line 118
        echo "                    ";
        // line 119
        echo "                    <script src=\"";
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "js/custom.js\"></script>
            ";
    }

    // line 122
    public function block_load_scripts($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "super.twig";
    }

    public function getDebugInfo()
    {
        return array (  318 => 122,  311 => 119,  309 => 118,  305 => 108,  301 => 107,  297 => 106,  293 => 105,  289 => 104,  285 => 103,  281 => 102,  277 => 101,  273 => 100,  269 => 99,  265 => 98,  261 => 97,  257 => 96,  252 => 95,  249 => 94,  245 => 92,  242 => 91,  238 => 88,  235 => 87,  231 => 85,  228 => 84,  224 => 81,  221 => 80,  215 => 63,  209 => 60,  203 => 57,  199 => 56,  195 => 55,  191 => 54,  187 => 53,  183 => 52,  173 => 45,  167 => 42,  161 => 38,  159 => 37,  154 => 34,  149 => 33,  147 => 32,  145 => 31,  142 => 30,  135 => 26,  132 => 25,  124 => 68,  122 => 67,  119 => 65,  117 => 30,  113 => 28,  111 => 25,  108 => 24,  103 => 21,  96 => 17,  92 => 16,  83 => 9,  80 => 8,  73 => 122,  70 => 121,  68 => 94,  65 => 93,  63 => 91,  60 => 90,  58 => 89,  55 => 87,  53 => 86,  50 => 84,  47 => 82,  45 => 80,  41 => 78,  39 => 73,  37 => 8,  28 => 1,);
    }
}
/* <!DOCTYPE html>*/
/* <!--[if lt IE 7]>      <html lang="es-MX" class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->*/
/* <!--[if IE 7]>         <html lang="es-MX" class="no-js lt-ie10 lt-ie9 lt-ie8"> <![endif]-->*/
/* <!--[if IE 8]>         <html lang="es-MX" class="no-js lt-ie10 lt-ie9"> <![endif]-->*/
/* <!--[if IE 9]>         <html lang="es-MX" class="no-js lt-ie10"> <![endif]-->*/
/*     <html class="no-js" lang="es">*/
/*         <head>*/
/*             {% block head %}*/
/*                 <meta charset="utf-8">*/
/*                 <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />*/
/*                 <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">*/
/*                 <meta http-equiv='cache-control' content='no-cache' />*/
/*                 <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>*/
/*                 <meta name='viewport' content='width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0' />*/
/* */
/*                 <meta name="title" content="{{ _title }}">*/
/*                 <meta name="identifier-url" content="{{ _host }}" />*/
/*                 <meta name="description" content="Nupali, Trabajando juntos por un espacio en equilibrio." />*/
/*                 <meta name="keywords" content="Nupali, Nosotros, Como Ayudar, Legal, Proyectos, Ayudar, Contacto, Resultados, Noticias" />*/
/*                 <meta name="author" content="Develpment Mandala Web -> Heriberto Velasco Mora <- Front End.">*/
/*                 <meta itemprop="image" content="{{ _host }}img/logo/nupali.png">*/
/* */
/*                 {# TITLE OF SITE #}*/
/*                 <title>*/
/*                     {% block title %}*/
/*                         {{ _title }}*/
/*                     {% endblock %}*/
/*                 </title>*/
/* */
/*                 {% block links %}*/
/*                     {# FAVICON #}*/
/*                     {# Place your favicon.ico in the img directory #}*/
/*                     <link rel="shortcut icon" href="{{ _host }}img/favicon.ico" type="image/x-icon">*/
/*                     <link rel="icon" href="{{ _host }}img/favicon.ico" type="image/x-icon">*/
/* */
/*                     {# CUSTOM STYLESHEET #}*/
/*                     {#<link rel="stylesheet" href="{{ _host }}css/styles.css">#}*/
/*                     <!-- =========================*/
/*                          STYLESHEETS*/
/*                     ============================== -->*/
/*                     <!-- BOOTSTRAP CSS -->*/
/*                     <link rel="stylesheet" href="{{ _host }}css/assets/plugins/bootstrap.min.css">*/
/* */
/*                     <!-- FONT ICONS -->*/
/*                     <link rel="stylesheet" href="{{ _host }}css/assets/icons/iconfont.css">*/
/*                     <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">*/
/* */
/*                     <!-- GOOGLE FONTS -->*/
/*                     <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>*/
/* */
/*                     <!-- PLUGINS STYLESHEET -->*/
/*                     <link rel="stylesheet" href="{{ _host }}css/assets/plugins/magnific-popup.css">*/
/*                     <link rel="stylesheet" href="{{ _host }}css/assets/plugins/owl.carousel.css">*/
/*                     <link rel="stylesheet" href="{{ _host }}css/assets/plugins/loaders.css">*/
/*                     <link rel="stylesheet" href="{{ _host }}css/assets/plugins/animate.css">*/
/*                     <link rel="stylesheet" href="{{ _host }}css/assets/plugins/pickadate-default.css">*/
/*                     <link rel="stylesheet" href="{{ _host }}css/assets/plugins/pickadate-default.date.css">*/
/* */
/*                     <!-- CUSTOM STYLESHEET -->*/
/*                     <link rel="stylesheet" href="{{ _host }}css/assets/style.css">*/
/* */
/*                     <!-- RESPONSIVE FIXES -->*/
/*                     <link rel="stylesheet" href="{{ _host }}css/assets/responsive.css">*/
/*                 {% endblock %}*/
/* */
/*                 {# HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries #}*/
/*                 {# WARNING: Respond.js doesn't work if you view the page via file:// #}*/
/*                 <!--[if lt IE 9]>*/
/*                   <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>*/
/*                   <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>*/
/*                 <![endif]-->*/
/*             {% endblock %}*/
/*             {#*/
/*                 <!-- FAVICON  -->*/
/* */
/* */
/*             #}*/
/*         <head>*/
/*         <body data-spy="scroll" data-target="#main-navbar">*/
/*             {% block preloader %}*/
/*             {% endblock %}*/
/*             <div class="main-container" id="page">*/
/*                 {# HEADER #}*/
/*                 {% block header_nav %}*/
/*                 {% endblock %}*/
/*                 {# CONTENT CURRENT #}*/
/*                 {% block content_current %}*/
/*                 {% endblock %}*/
/*             </div>{# /End Main Container #}*/
/* */
/*             {% block top_button %}*/
/*             {% endblock %}*/
/* */
/*             {% block body_scripts %}*/
/*                 <script src="{{ _host }}lib/assets/plugins/jquery1.11.2.min.js"></script>*/
/*                 <script src="{{ _host }}lib/assets/plugins/bootstrap.min.js"></script>*/
/*                 <script src="{{ _host }}lib/assets/plugins/jquery.easing.1.3.min.js"></script>*/
/*                 <script src="{{ _host }}lib/assets/plugins/jquery.countTo.js"></script>*/
/*                 <script src="{{ _host }}lib/assets/plugins/jquery.formchimp.min.js"></script>*/
/*                 <script src="{{ _host }}lib/assets/plugins/jquery.jCounter-0.1.4.js"></script>*/
/*                 <script src="{{ _host }}lib/assets/plugins/jquery.magnific-popup.min.js"></script>*/
/*                 <script src="{{ _host }}lib/assets/plugins/jquery.vide.min.js"></script>*/
/*                 <script src="{{ _host }}lib/assets/plugins/owl.carousel.min.js"></script>*/
/*                 <script src="{{ _host }}lib/assets/plugins/spectragram.min.js"></script>*/
/*                 <script src="{{ _host }}lib/assets/plugins/twitterFetcher_min.js"></script>*/
/*                 <script src="{{ _host }}lib/assets/plugins/wow.min.js"></script>*/
/*                 <script src="{{ _host }}lib/assets/plugins/picker.js"></script>*/
/*                 <script src="{{ _host }}lib/assets/plugins/picker.date.js"></script>*/
/*                 {#*/
/*                     <script src="{{ _host }}lib/min/core.lib.min.js"></script>*/
/*                     <script src="{{ _host }}js/min/core.min.js"></script>*/
/*                     <script src="{{ _host }}js/main.js"></script>*/
/*                     <script src="{{ _host }}js/method.js"></script>*/
/*                     <script src="{{ _host }}js/model.js"></script>*/
/*                     <script src="{{ _host }}js/objects.js"></script>*/
/*                     <script src="{{ _host }}js/required.js"></script>*/
/*                 #}*/
/*                     {# Custom Script #}*/
/*                     <script src="{{ _host }}js/custom.js"></script>*/
/*             {% endblock %}*/
/* */
/*             <script>{% block load_scripts %}{% endblock %}</script>*/
/*         </body>*/
/*     </html>*/

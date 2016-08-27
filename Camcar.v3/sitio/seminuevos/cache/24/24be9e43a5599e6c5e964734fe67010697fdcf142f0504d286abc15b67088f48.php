<?php

/* super_navbar.twig */
class __TwigTemplate_114944dd42f3330edbda388144466460b0c5b0ad3bd10e3941f5fc8b7e12d745 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'navbar' => array($this, 'block_navbar'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"wrapper_content_navbar\" id=\"start-site-header\">
    ";
        // line 2
        $this->displayBlock('navbar', $context, $blocks);
        // line 114
        echo "</div>
";
    }

    // line 2
    public function block_navbar($context, array $blocks = array())
    {
        // line 3
        echo "        <div class=\"sticky-wrapper\" 
             style=\"height: 59px;\">
            ";
        // line 6
        echo "            <header id=\"content-start-site-navbar\" 
                    class=\"navbar navigation-bar-header nav-content sticky\">
                <div class=\"container container-site sp-cont\">
                    <a class=\"visible-sm visible-xs mobile-toggle\" 
                       id=\"menu-toggle\">
                        <div class=\"bar-1\"></div>
                        <div class=\"bar-2\"></div>
                    </a>
                    <a class=\"visible-xs-home-link visible-sm visible-xs\" 
                       id=\"go-home-logo-resp\">
                    <img alt=\"Logo\" class=\"logo\" 
                         src=\"";
        // line 17
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "img/logos/logo_camcar.png\">
                    </a>
                    ";
        // line 20
        echo "                    <nav class=\"main-navigation toggle-menu navigation-bar no-print\" 
                         role=\"navigation\">
                        <a class=\"home-link main-navigator-home-link no-print\" 
                           id=\"go-home-logo\">
                            <img alt=\"Logo\" class=\"logo no-print\" 
                                 src=\"";
        // line 25
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "img/logos/logo_camcar.png\" 
                                 alt=\"CAMCAR\">
                        </a>
                        <ul class=\"sf-menu navigation-bar no-print\">
                            <li>
                                <a href=\"";
        // line 30
        echo twig_escape_filter($this->env, (isset($context["_sitio"]) ? $context["_sitio"] : null), "html", null, true);
        echo "\" 
                                   id=\"go-index\" 
                                   class=\"cur-hover menu-toggle-close\">Inicio</a>
                            </li>
                            <li>
                                <a href=\"";
        // line 35
        echo twig_escape_filter($this->env, (isset($context["_sitio"]) ? $context["_sitio"] : null), "html", null, true);
        echo "#/agencias/nuevos/ford-cavsa\" 
                                   id=\"go-agencies-news\" 
                                   class=\"cur-hover menu-toggle-close\" 
                                   data-agp_nombre=\"ford-cavsa\" 
                                   data-agp_id=\"4\" 
                                   data-index=\"1\">Agencias</a>
                            </li>
                            <li class=\"has-dropdown\">
                                <a id=\"dropdown-nav-preowuned\" 
                                   class=\"cur-hover current\">Seminuevos</a>
                                <ul class=\"subnav\">
                                    <li>
                                        <a href=\"";
        // line 47
        echo twig_escape_filter($this->env, (isset($context["_sitio"]) ? $context["_sitio"] : null), "html", null, true);
        echo "#/agencias/seminuevos/premium-by-jlr/1\" 
                                           id=\"go-agencies-preowned\" 
                                           class=\"cur-hover menu-toggle-close\" 
                                           data-agn-preowned-name=\"Premium by JLR\" 
                                           data-agn-preowned-url=\"premium-by-jlr\" 
                                           data-agn-preowned-id=\"1\" 
                                           data-agn-preowned-maps=\"1\">Agencias</a>
                                    </li>
                                    <li>
                                        <a ";
        // line 56
        echo " 
                                           id=\"go-inventories-preowned\" 
                                           class=\"cur-hover menu-toggle-close current\">Inventarios</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href=\"";
        // line 63
        echo twig_escape_filter($this->env, (isset($context["_sitio"]) ? $context["_sitio"] : null), "html", null, true);
        echo "#/talleres\" 
                                   id=\"go-workshop\" 
                                   class=\"cur-hover menu-toggle-close\">Talleres</a>
                            </li>
                            <li>
                                <a href=\"";
        // line 68
        echo twig_escape_filter($this->env, (isset($context["_sitio"]) ? $context["_sitio"] : null), "html", null, true);
        echo "#/rentas/u-save-car-truck-rental\" 
                                   id=\"go-rental\" 
                                   class=\"cur-hover menu-toggle-close\" 
                                   data-agencie-rental-name=\"U-SAVE Car &amp; Truck Rental\" 
                                   data-agencie-rental-key=\"u-save-car-truck-rental\">Rentas</a>
                            </li>
                            <li>
                                <a href=\"";
        // line 75
        echo twig_escape_filter($this->env, (isset($context["_sitio"]) ? $context["_sitio"] : null), "html", null, true);
        echo "#/noticias\" 
                                   id=\"go-blog\" 
                                   class=\"cur-hover menu-toggle-close\">Noticias</a>
                            </li>
                            <li class=\"has-dropdown\">
                                <a href=\"";
        // line 80
        echo twig_escape_filter($this->env, (isset($context["_sitio"]) ? $context["_sitio"] : null), "html", null, true);
        echo "#/nosotros\" 
                                   id=\"go-about-us\" 
                                   class=\"cur-hover menu-toggle-close\">Nosotros</a>
                                <ul class=\"subnav\">
                                    <li>
                                        <a href=\"";
        // line 85
        echo twig_escape_filter($this->env, (isset($context["_sitio"]) ? $context["_sitio"] : null), "html", null, true);
        echo "#/bolsa-de-trabajo\" 
                                           id=\"go-job-opportunities\" 
                                           class=\"cur-hover menu-toggle-close\">Bolsa de Trabajo</a>
                                    </li>
                                    <li>
                                        <a href=\"";
        // line 90
        echo twig_escape_filter($this->env, (isset($context["_sitio"]) ? $context["_sitio"] : null), "html", null, true);
        echo "#/contacto\" 
                                           id=\"go-contact\" 
                                           class=\"cur-hover menu-toggle-close\">Contacto</a>
                                    </li>
                                </ul>
                            </li>
                            <li class=\"visible-sm visible-xs visible-xs-poeple\">
                                <a href=\"";
        // line 97
        echo twig_escape_filter($this->env, (isset($context["_intranet"]) ? $context["_intranet"] : null), "html", null, true);
        echo "login/\" 
                                   id=\"go-people-camcar-resp\" 
                                   class=\"cur-hover\">Gente Camcar</a>
                            </li>
                        </ul>
                        <a href=\"";
        // line 102
        echo twig_escape_filter($this->env, (isset($context["_intranet"]) ? $context["_intranet"] : null), "html", null, true);
        echo "login/\" 
                           class=\"vin_people none-visible-xs hint-vin--bottom no-print\" 
                           data-vin-hint=\"GENTE CAMCAR\" 
                           id=\"sem-people-camcar\">
                            <i class=\"fa fa-user no-print\"></i>
                        </a>
                    </nav>
                </div>
            </header>
            ";
        // line 112
        echo "        </div>
    ";
    }

    public function getTemplateName()
    {
        return "super_navbar.twig";
    }

    public function getDebugInfo()
    {
        return array (  186 => 112,  174 => 102,  166 => 97,  156 => 90,  148 => 85,  140 => 80,  132 => 75,  122 => 68,  114 => 63,  105 => 56,  93 => 47,  78 => 35,  70 => 30,  62 => 25,  55 => 20,  50 => 17,  37 => 6,  33 => 3,  30 => 2,  25 => 114,  23 => 2,  20 => 1,);
    }
}
/* <div class="wrapper_content_navbar" id="start-site-header">*/
/*     {% block navbar %}*/
/*         <div class="sticky-wrapper" */
/*              style="height: 59px;">*/
/*             {# Start Site Header #}*/
/*             <header id="content-start-site-navbar" */
/*                     class="navbar navigation-bar-header nav-content sticky">*/
/*                 <div class="container container-site sp-cont">*/
/*                     <a class="visible-sm visible-xs mobile-toggle" */
/*                        id="menu-toggle">*/
/*                         <div class="bar-1"></div>*/
/*                         <div class="bar-2"></div>*/
/*                     </a>*/
/*                     <a class="visible-xs-home-link visible-sm visible-xs" */
/*                        id="go-home-logo-resp">*/
/*                     <img alt="Logo" class="logo" */
/*                          src="{{ _host }}img/logos/logo_camcar.png">*/
/*                     </a>*/
/*                     {# Main Navigation #}*/
/*                     <nav class="main-navigation toggle-menu navigation-bar no-print" */
/*                          role="navigation">*/
/*                         <a class="home-link main-navigator-home-link no-print" */
/*                            id="go-home-logo">*/
/*                             <img alt="Logo" class="logo no-print" */
/*                                  src="{{ _host }}img/logos/logo_camcar.png" */
/*                                  alt="CAMCAR">*/
/*                         </a>*/
/*                         <ul class="sf-menu navigation-bar no-print">*/
/*                             <li>*/
/*                                 <a href="{{ _sitio }}" */
/*                                    id="go-index" */
/*                                    class="cur-hover menu-toggle-close">Inicio</a>*/
/*                             </li>*/
/*                             <li>*/
/*                                 <a href="{{ _sitio }}#/agencias/nuevos/ford-cavsa" */
/*                                    id="go-agencies-news" */
/*                                    class="cur-hover menu-toggle-close" */
/*                                    data-agp_nombre="ford-cavsa" */
/*                                    data-agp_id="4" */
/*                                    data-index="1">Agencias</a>*/
/*                             </li>*/
/*                             <li class="has-dropdown">*/
/*                                 <a id="dropdown-nav-preowuned" */
/*                                    class="cur-hover current">Seminuevos</a>*/
/*                                 <ul class="subnav">*/
/*                                     <li>*/
/*                                         <a href="{{ _sitio }}#/agencias/seminuevos/premium-by-jlr/1" */
/*                                            id="go-agencies-preowned" */
/*                                            class="cur-hover menu-toggle-close" */
/*                                            data-agn-preowned-name="Premium by JLR" */
/*                                            data-agn-preowned-url="premium-by-jlr" */
/*                                            data-agn-preowned-id="1" */
/*                                            data-agn-preowned-maps="1">Agencias</a>*/
/*                                     </li>*/
/*                                     <li>*/
/*                                         <a {# href="#" #} */
/*                                            id="go-inventories-preowned" */
/*                                            class="cur-hover menu-toggle-close current">Inventarios</a>*/
/*                                     </li>*/
/*                                 </ul>*/
/*                             </li>*/
/*                             <li>*/
/*                                 <a href="{{ _sitio }}#/talleres" */
/*                                    id="go-workshop" */
/*                                    class="cur-hover menu-toggle-close">Talleres</a>*/
/*                             </li>*/
/*                             <li>*/
/*                                 <a href="{{ _sitio }}#/rentas/u-save-car-truck-rental" */
/*                                    id="go-rental" */
/*                                    class="cur-hover menu-toggle-close" */
/*                                    data-agencie-rental-name="U-SAVE Car &amp; Truck Rental" */
/*                                    data-agencie-rental-key="u-save-car-truck-rental">Rentas</a>*/
/*                             </li>*/
/*                             <li>*/
/*                                 <a href="{{ _sitio }}#/noticias" */
/*                                    id="go-blog" */
/*                                    class="cur-hover menu-toggle-close">Noticias</a>*/
/*                             </li>*/
/*                             <li class="has-dropdown">*/
/*                                 <a href="{{ _sitio }}#/nosotros" */
/*                                    id="go-about-us" */
/*                                    class="cur-hover menu-toggle-close">Nosotros</a>*/
/*                                 <ul class="subnav">*/
/*                                     <li>*/
/*                                         <a href="{{ _sitio }}#/bolsa-de-trabajo" */
/*                                            id="go-job-opportunities" */
/*                                            class="cur-hover menu-toggle-close">Bolsa de Trabajo</a>*/
/*                                     </li>*/
/*                                     <li>*/
/*                                         <a href="{{ _sitio }}#/contacto" */
/*                                            id="go-contact" */
/*                                            class="cur-hover menu-toggle-close">Contacto</a>*/
/*                                     </li>*/
/*                                 </ul>*/
/*                             </li>*/
/*                             <li class="visible-sm visible-xs visible-xs-poeple">*/
/*                                 <a href="{{ _intranet }}login/" */
/*                                    id="go-people-camcar-resp" */
/*                                    class="cur-hover">Gente Camcar</a>*/
/*                             </li>*/
/*                         </ul>*/
/*                         <a href="{{ _intranet }}login/" */
/*                            class="vin_people none-visible-xs hint-vin--bottom no-print" */
/*                            data-vin-hint="GENTE CAMCAR" */
/*                            id="sem-people-camcar">*/
/*                             <i class="fa fa-user no-print"></i>*/
/*                         </a>*/
/*                     </nav>*/
/*                 </div>*/
/*             </header>*/
/*             {# End Start Site Header #}*/
/*         </div>*/
/*     {% endblock %}*/
/* </div>*/
/* */

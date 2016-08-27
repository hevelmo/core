<?php

/* seminuevos/detalles/_main.twig */
class __TwigTemplate_0c0578e34e51fd9a3fc5e5b9068c3e18d39d624e63a5742a690206b6350ee489 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("seminuevos/_main.twig", "seminuevos/detalles/_main.twig", 1);
        $this->blocks = array(
            'content_recurrent' => array($this, 'block_content_recurrent'),
            'titulo' => array($this, 'block_titulo'),
            'acciones' => array($this, 'block_acciones'),
            'load_scripts' => array($this, 'block_load_scripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "seminuevos/_main.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_content_recurrent($context, array $blocks = array())
    {
        // line 3
        echo "    ";
        $this->displayParentBlock("content_recurrent", $context, $blocks);
        echo "
    ";
        // line 4
        $context["detalle"] = $this->getAttribute((isset($context["seminuevos"]) ? $context["seminuevos"] : null), 0, array(), "array");
        // line 5
        echo "    <div id=\"content-start-body-main\" class=\"about-content\">
        ";
        // line 7
        echo "        <div class=\"main\" role=\"main\">
            <div id=\"content\" class=\"content full\">
                <div class=\"container\">
                    ";
        // line 11
        echo "                    <article class=\"single-vehicle-details\">
                        <div id=\"content_single_vehicle\"></div>
                        ";
        // line 14
        echo "                        <div class=\"single-vehicle-title\">
                            ";
        // line 15
        $this->displayBlock('titulo', $context, $blocks);
        // line 23
        echo "                        </div>
                        ";
        // line 25
        echo "                        <div class=\"single-listing-actions\">
                            ";
        // line 26
        $this->displayBlock('acciones', $context, $blocks);
        // line 66
        echo "                        </div>
                        <div class=\"row\">
                            ";
        // line 69
        echo "                            ";
        $this->loadTemplate("seminuevos/detalles/_main.twig", "seminuevos/detalles/_main.twig", 69, "1012608339")->display($context);
        // line 70
        echo "                            ";
        // line 71
        echo "                            ";
        $this->loadTemplate("seminuevos/detalles/_main.twig", "seminuevos/detalles/_main.twig", 71, "822468326")->display($context);
        // line 72
        echo "                        </div>
                        <div class=\"row\">
                            ";
        // line 75
        echo "                            ";
        $this->loadTemplate("seminuevos/detalles/_main.twig", "seminuevos/detalles/_main.twig", 75, "961523199")->display($context);
        // line 76
        echo "                            ";
        // line 77
        echo "                            ";
        $this->loadTemplate("seminuevos/detalles/_main.twig", "seminuevos/detalles/_main.twig", 77, "898582008")->display($context);
        // line 78
        echo "                        </div>
                        <div class=\"row\">
                            ";
        // line 81
        echo "                            ";
        // line 85
        echo "                        </div>
                    </article>
                    <div class=\"clearfix\"></div>
                </div>
            </div>
            ";
        // line 91
        echo "        </div>
    </div>
";
    }

    // line 15
    public function block_titulo($context, array $blocks = array())
    {
        // line 16
        echo "                                <span class=\"badge-premium-listing\" data-sen-id=\"";
        echo twig_escape_filter($this->env, (isset($context["sen_id"]) ? $context["sen_id"] : null), "html", null, true);
        echo "\">
                                    ";
        // line 17
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "agencia", array()), "nombre", array()), "html", null, true);
        echo "
                                </span>
                                <h2 class=\"post-title\" data-sen-id=\"";
        // line 19
        echo twig_escape_filter($this->env, (isset($context["sen_id"]) ? $context["sen_id"] : null), "html", null, true);
        echo "\">
                                    ";
        // line 20
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "marca", array()), "nombre", array()), "html", null, true);
        echo " - ";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "modelo", array()), "nombre", array()), "html", null, true);
        echo " - ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "anio", array()), "html", null, true);
        echo "
                                </h2>
                            ";
    }

    // line 26
    public function block_acciones($context, array $blocks = array())
    {
        // line 27
        echo "                                <div class=\"btn-group single-listing-actions-group pull-right\" role=\"group\">
                                    <a href=\"javascript:void(0)\"
                                       onclick=\"window.print();\"
                                       class=\"btn btn-default btn_print single-listing-actions-print-resp\"
                                       title=\"Print\">
                                        <i class=\"fa fa-print\"></i>
                                        <span>Imprimir</span>
                                    </a>
                                    <a href=\"";
        // line 35
        echo twig_escape_filter($this->env, (isset($context["_inventarios"]) ? $context["_inventarios"] : null), "html", null, true);
        echo twig_escape_filter($this->env, (isset($context["marca"]) ? $context["marca"] : null), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, (isset($context["modelo"]) ? $context["modelo"] : null), "html", null, true);
        echo "\" 
                                       class=\"btn btn-default btn_return single-listing-actions-back-resp\" 
                                       title=\"Regresar\" 
                                       id=\"back\">
                                        <i class=\"fa fa-arrow-left\"></i>
                                        <span>Regresar</span>
                                    </a>
                                </div>
                                <div class=\"btn btn-info price\" data-sen-id=\"";
        // line 43
        echo twig_escape_filter($this->env, (isset($context["sen_id"]) ? $context["sen_id"] : null), "html", null, true);
        echo "\">
                                    <span class=\"multiple\">
                                        \$";
        // line 45
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "precio", array()), 2, ".", ","), "html", null, true);
        echo "
                                    </span>
                                </div>
                                ";
        // line 48
        if ((trim($this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "telefonos", array()), "ventas_tel_1", array())) != "")) {
            // line 49
            echo "                                    <div class=\"btn btn-info phone hidden-movil\">
                                        <i class=\"fa fa-phone\"></i>
                                        <span>
                                            ";
            // line 52
            echo twig_escape_filter($this->env, trim($this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "telefonos", array()), "ventas_tel_1", array())), "html", null, true);
            echo "
                                        </span>
                                    </div>
                                ";
        }
        // line 56
        echo "                                <span class=\"badge-premium-listing\" data-sen-id=\"";
        echo twig_escape_filter($this->env, (isset($context["sen_id"]) ? $context["sen_id"] : null), "html", null, true);
        echo "\">
                                    ";
        // line 57
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "agencia", array()), "nombre", array()), "html", null, true);
        echo "
                                </span>
                                <div class=\"btn btn-info phone visible-xs\">
                                    <a href=\"tel:+3338187500\">
                                        <i class=\"fa fa-phone\"></i>
                                        <span>Llamanos</span>
                                    </a>
                                </div>
                            ";
    }

    // line 94
    public function block_load_scripts($context, array $blocks = array())
    {
        // line 95
        echo "    ";
        $this->displayParentBlock("load_scripts", $context, $blocks);
        echo "
    loadSlider();
    owlCarouselMethods.owlCarousel(\"#vehicle-slider\");
    detailSenMethod.readMap();
";
    }

    public function getTemplateName()
    {
        return "seminuevos/detalles/_main.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  210 => 95,  207 => 94,  194 => 57,  189 => 56,  182 => 52,  177 => 49,  175 => 48,  169 => 45,  164 => 43,  150 => 35,  140 => 27,  137 => 26,  126 => 20,  122 => 19,  117 => 17,  112 => 16,  109 => 15,  103 => 91,  96 => 85,  94 => 81,  90 => 78,  87 => 77,  85 => 76,  82 => 75,  78 => 72,  75 => 71,  73 => 70,  70 => 69,  66 => 66,  64 => 26,  61 => 25,  58 => 23,  56 => 15,  53 => 14,  49 => 11,  44 => 7,  41 => 5,  39 => 4,  34 => 3,  31 => 2,  11 => 1,);
    }
}


/* seminuevos/detalles/_main.twig */
class __TwigTemplate_0c0578e34e51fd9a3fc5e5b9068c3e18d39d624e63a5742a690206b6350ee489_1012608339 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 69
        $this->parent = $this->loadTemplate("seminuevos/detalles/imagenes.twig", "seminuevos/detalles/_main.twig", 69);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "seminuevos/detalles/imagenes.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "seminuevos/detalles/_main.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  244 => 69,  210 => 95,  207 => 94,  194 => 57,  189 => 56,  182 => 52,  177 => 49,  175 => 48,  169 => 45,  164 => 43,  150 => 35,  140 => 27,  137 => 26,  126 => 20,  122 => 19,  117 => 17,  112 => 16,  109 => 15,  103 => 91,  96 => 85,  94 => 81,  90 => 78,  87 => 77,  85 => 76,  82 => 75,  78 => 72,  75 => 71,  73 => 70,  70 => 69,  66 => 66,  64 => 26,  61 => 25,  58 => 23,  56 => 15,  53 => 14,  49 => 11,  44 => 7,  41 => 5,  39 => 4,  34 => 3,  31 => 2,  11 => 1,);
    }
}


/* seminuevos/detalles/_main.twig */
class __TwigTemplate_0c0578e34e51fd9a3fc5e5b9068c3e18d39d624e63a5742a690206b6350ee489_822468326 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 71
        $this->parent = $this->loadTemplate("seminuevos/detalles/descripcion.twig", "seminuevos/detalles/_main.twig", 71);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "seminuevos/detalles/descripcion.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "seminuevos/detalles/_main.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  284 => 71,  244 => 69,  210 => 95,  207 => 94,  194 => 57,  189 => 56,  182 => 52,  177 => 49,  175 => 48,  169 => 45,  164 => 43,  150 => 35,  140 => 27,  137 => 26,  126 => 20,  122 => 19,  117 => 17,  112 => 16,  109 => 15,  103 => 91,  96 => 85,  94 => 81,  90 => 78,  87 => 77,  85 => 76,  82 => 75,  78 => 72,  75 => 71,  73 => 70,  70 => 69,  66 => 66,  64 => 26,  61 => 25,  58 => 23,  56 => 15,  53 => 14,  49 => 11,  44 => 7,  41 => 5,  39 => 4,  34 => 3,  31 => 2,  11 => 1,);
    }
}


/* seminuevos/detalles/_main.twig */
class __TwigTemplate_0c0578e34e51fd9a3fc5e5b9068c3e18d39d624e63a5742a690206b6350ee489_961523199 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 75
        $this->parent = $this->loadTemplate("seminuevos/detalles/mapa.twig", "seminuevos/detalles/_main.twig", 75);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "seminuevos/detalles/mapa.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "seminuevos/detalles/_main.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  324 => 75,  284 => 71,  244 => 69,  210 => 95,  207 => 94,  194 => 57,  189 => 56,  182 => 52,  177 => 49,  175 => 48,  169 => 45,  164 => 43,  150 => 35,  140 => 27,  137 => 26,  126 => 20,  122 => 19,  117 => 17,  112 => 16,  109 => 15,  103 => 91,  96 => 85,  94 => 81,  90 => 78,  87 => 77,  85 => 76,  82 => 75,  78 => 72,  75 => 71,  73 => 70,  70 => 69,  66 => 66,  64 => 26,  61 => 25,  58 => 23,  56 => 15,  53 => 14,  49 => 11,  44 => 7,  41 => 5,  39 => 4,  34 => 3,  31 => 2,  11 => 1,);
    }
}


/* seminuevos/detalles/_main.twig */
class __TwigTemplate_0c0578e34e51fd9a3fc5e5b9068c3e18d39d624e63a5742a690206b6350ee489_898582008 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 77
        $this->parent = $this->loadTemplate("seminuevos/detalles/contacto.twig", "seminuevos/detalles/_main.twig", 77);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "seminuevos/detalles/contacto.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "seminuevos/detalles/_main.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  364 => 77,  324 => 75,  284 => 71,  244 => 69,  210 => 95,  207 => 94,  194 => 57,  189 => 56,  182 => 52,  177 => 49,  175 => 48,  169 => 45,  164 => 43,  150 => 35,  140 => 27,  137 => 26,  126 => 20,  122 => 19,  117 => 17,  112 => 16,  109 => 15,  103 => 91,  96 => 85,  94 => 81,  90 => 78,  87 => 77,  85 => 76,  82 => 75,  78 => 72,  75 => 71,  73 => 70,  70 => 69,  66 => 66,  64 => 26,  61 => 25,  58 => 23,  56 => 15,  53 => 14,  49 => 11,  44 => 7,  41 => 5,  39 => 4,  34 => 3,  31 => 2,  11 => 1,);
    }
}
/* {% extends "seminuevos/_main.twig" %}*/
/* {% block content_recurrent %}*/
/*     {{ parent() }}*/
/*     {% set detalle =  seminuevos[0] %}*/
/*     <div id="content-start-body-main" class="about-content">*/
/*         {# Start Body Content #}*/
/*         <div class="main" role="main">*/
/*             <div id="content" class="content full">*/
/*                 <div class="container">*/
/*                     {# Vehicle Details #}*/
/*                     <article class="single-vehicle-details">*/
/*                         <div id="content_single_vehicle"></div>*/
/*                         {# TITULO #}*/
/*                         <div class="single-vehicle-title">*/
/*                             {% block titulo %}*/
/*                                 <span class="badge-premium-listing" data-sen-id="{{ sen_id }}">*/
/*                                     {{ detalle.agencia.nombre }}*/
/*                                 </span>*/
/*                                 <h2 class="post-title" data-sen-id="{{ sen_id }}">*/
/*                                     {{ detalle.marca.nombre }} - {{ detalle.modelo.nombre }} - {{ detalle.anio }}*/
/*                                 </h2>*/
/*                             {% endblock %}*/
/*                         </div>*/
/*                         {# ACCIONES #}*/
/*                         <div class="single-listing-actions">*/
/*                             {% block acciones %}*/
/*                                 <div class="btn-group single-listing-actions-group pull-right" role="group">*/
/*                                     <a href="javascript:void(0)"*/
/*                                        onclick="window.print();"*/
/*                                        class="btn btn-default btn_print single-listing-actions-print-resp"*/
/*                                        title="Print">*/
/*                                         <i class="fa fa-print"></i>*/
/*                                         <span>Imprimir</span>*/
/*                                     </a>*/
/*                                     <a href="{{ _inventarios }}{{ marca }}/{{ modelo }}" */
/*                                        class="btn btn-default btn_return single-listing-actions-back-resp" */
/*                                        title="Regresar" */
/*                                        id="back">*/
/*                                         <i class="fa fa-arrow-left"></i>*/
/*                                         <span>Regresar</span>*/
/*                                     </a>*/
/*                                 </div>*/
/*                                 <div class="btn btn-info price" data-sen-id="{{ sen_id }}">*/
/*                                     <span class="multiple">*/
/*                                         ${{ detalle.precio|number_format(2, '.', ',') }}*/
/*                                     </span>*/
/*                                 </div>*/
/*                                 {% if detalle.telefonos.ventas_tel_1|trim != "" %}*/
/*                                     <div class="btn btn-info phone hidden-movil">*/
/*                                         <i class="fa fa-phone"></i>*/
/*                                         <span>*/
/*                                             {{ detalle.telefonos.ventas_tel_1|trim }}*/
/*                                         </span>*/
/*                                     </div>*/
/*                                 {% endif %}*/
/*                                 <span class="badge-premium-listing" data-sen-id="{{ sen_id }}">*/
/*                                     {{ detalle.agencia.nombre }}*/
/*                                 </span>*/
/*                                 <div class="btn btn-info phone visible-xs">*/
/*                                     <a href="tel:+3338187500">*/
/*                                         <i class="fa fa-phone"></i>*/
/*                                         <span>Llamanos</span>*/
/*                                     </a>*/
/*                                 </div>*/
/*                             {% endblock %}*/
/*                         </div>*/
/*                         <div class="row">*/
/*                             {# SLIDER #}*/
/*                             {% embed "seminuevos/detalles/imagenes.twig" %}{% endembed %}*/
/*                             {# DESCRIPCIÓN #}*/
/*                             {% embed "seminuevos/detalles/descripcion.twig" %}{% endembed %}*/
/*                         </div>*/
/*                         <div class="row">*/
/*                             {# MAPA #}*/
/*                             {% embed "seminuevos/detalles/mapa.twig" %}{% endembed %}*/
/*                             {# CONTACTO #}*/
/*                             {% embed "seminuevos/detalles/contacto.twig" %}{% endembed %}*/
/*                         </div>*/
/*                         <div class="row">*/
/*                             {# VEHÍCULOS RELACIONADOS #}*/
/*                             {#*/
/*                             {% embed "seminuevos/detalles/relacionados.twig" %}{% endembed %}*/
/*                             <div class="col-md-4"></div>*/
/*                             #}*/
/*                         </div>*/
/*                     </article>*/
/*                     <div class="clearfix"></div>*/
/*                 </div>*/
/*             </div>*/
/*             {# End Body Content #}*/
/*         </div>*/
/*     </div>*/
/* {% endblock %}*/
/* {% block load_scripts %}*/
/*     {{ parent() }}*/
/*     loadSlider();*/
/*     owlCarouselMethods.owlCarousel("#vehicle-slider");*/
/*     detailSenMethod.readMap();*/
/* {% endblock %}*/
/* */

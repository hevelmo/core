<?php

/* seminuevos/detalles/mapa.twig */
class __TwigTemplate_b0c3b5c48df1ca17eb40d89864d0f61c06a079997e659efdd060870d4dfd73e1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'mapa_wrapper' => array($this, 'block_mapa_wrapper'),
            'mapa_locations' => array($this, 'block_mapa_locations'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"col-md-8\">
    <div class=\"tabs vehicle-details-tabs\">
        <ul class=\"nav nav-tabs\"></ul>
        <div class=\"tab-content\">
            <div id=\"vehicle-location\" class=\"tab-pane fade in active no_print\">
                <div id=\"content_wrapper_map\">
                    ";
        // line 7
        $this->displayBlock('mapa_wrapper', $context, $blocks);
        // line 19
        echo "                </div>
            </div>
            <a href=\"";
        // line 21
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["mapas"]) ? $context["mapas"] : null), 0, array(), "array"), "url", array()), "html", null, true);
        echo "\"
               class=\"btn btn-default btn_default visible-xs\"
               title=\"VIEW MAP\"
               target=\"_blank\">
                <i class=\"icon icon-geolocalizator\"></i>
                <span>VER MAPA</span>
            </a>
        </div>
    </div>
</div>
";
    }

    // line 7
    public function block_mapa_wrapper($context, array $blocks = array())
    {
        // line 8
        echo "                        <div id=\"map-canvas-detalle\" class=\"map-canvas h500\"
                             data-sen-id=\"";
        // line 9
        echo twig_escape_filter($this->env, (isset($context["sen_id"]) ? $context["sen_id"] : null), "html", null, true);
        echo "\"
                             data-longitud=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["mapas"]) ? $context["mapas"] : null), 0, array(), "array"), "longitud", array()), "html", null, true);
        echo "\"
                             data-latitud=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["mapas"]) ? $context["mapas"] : null), 0, array(), "array"), "latitud", array()), "html", null, true);
        echo "\"
                             data-agencia=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "agencia", array()), "nombre", array()), "html", null, true);
        echo "\"
                             data-direccion=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "agencia", array()), "direccion", array()), "html", null, true);
        echo "\"
                             data-imagen=\"";
        // line 14
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "img/sitio/agencias/logos/";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "agencia", array()), "logo", array()), "html", null, true);
        echo "\"
                             data-icon=\"";
        // line 15
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "img/sitio/pin_camcar_2.png\">
                                ";
        // line 16
        $this->displayBlock('mapa_locations', $context, $blocks);
        // line 17
        echo "                    </div>
                    ";
    }

    // line 16
    public function block_mapa_locations($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "seminuevos/detalles/mapa.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  93 => 16,  88 => 17,  86 => 16,  82 => 15,  76 => 14,  72 => 13,  68 => 12,  64 => 11,  60 => 10,  56 => 9,  53 => 8,  50 => 7,  35 => 21,  31 => 19,  29 => 7,  21 => 1,);
    }
}
/* <div class="col-md-8">*/
/*     <div class="tabs vehicle-details-tabs">*/
/*         <ul class="nav nav-tabs"></ul>*/
/*         <div class="tab-content">*/
/*             <div id="vehicle-location" class="tab-pane fade in active no_print">*/
/*                 <div id="content_wrapper_map">*/
/*                     {% block mapa_wrapper %}*/
/*                         <div id="map-canvas-detalle" class="map-canvas h500"*/
/*                              data-sen-id="{{ sen_id }}"*/
/*                              data-longitud="{{ mapas[0].longitud }}"*/
/*                              data-latitud="{{ mapas[0].latitud }}"*/
/*                              data-agencia="{{ detalle.agencia.nombre }}"*/
/*                              data-direccion="{{ detalle.agencia.direccion }}"*/
/*                              data-imagen="{{ _host }}img/sitio/agencias/logos/{{ detalle.agencia.logo }}"*/
/*                              data-icon="{{ _host }}img/sitio/pin_camcar_2.png">*/
/*                                 {% block mapa_locations %}{% endblock %}*/
/*                     </div>*/
/*                     {% endblock %}*/
/*                 </div>*/
/*             </div>*/
/*             <a href="{{ mapas[0].url }}"*/
/*                class="btn btn-default btn_default visible-xs"*/
/*                title="VIEW MAP"*/
/*                target="_blank">*/
/*                 <i class="icon icon-geolocalizator"></i>*/
/*                 <span>VER MAPA</span>*/
/*             </a>*/
/*         </div>*/
/*     </div>*/
/* </div>*/
/* */

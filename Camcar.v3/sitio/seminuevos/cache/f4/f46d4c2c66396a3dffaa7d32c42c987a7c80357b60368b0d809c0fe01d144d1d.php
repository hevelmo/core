<?php

/* seminuevos/inventarios/_main.twig */
class __TwigTemplate_fc81c140034e1a87b8219edbf1acc6ba66a20f11a438d9071924b982565eec41 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("seminuevos/_main.twig", "seminuevos/inventarios/_main.twig", 1);
        $this->blocks = array(
            'content_recurrent' => array($this, 'block_content_recurrent'),
            'result_auto' => array($this, 'block_result_auto'),
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
    <div id=\"content-start-body-main\" class=\"about-content\">
        <div class=\"main\" role=\"main\">
            <div id=\"content\" class=\"content-results full\">
                <div class=\"container\">
                    <div class=\"row\">
                        ";
        // line 10
        echo "                        <div class=\"col-md-12 results-container\">
                            <div class=\"results-container-in\">
                                <div class=\"view-results-list\" id=\"content-start-views-results-list\">
                                    <div id=\"results-holder\" class=\"results-grid-view\">
                                        ";
        // line 15
        echo "                                        ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["seminuevos"]) ? $context["seminuevos"] : null));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["auto"]) {
            // line 16
            echo "                                            ";
            $this->displayBlock('result_auto', $context, $blocks);
            // line 84
            echo "                                        ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['auto'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 85
        echo "                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
";
    }

    // line 16
    public function block_result_auto($context, array $blocks = array())
    {
        // line 17
        echo "                                                <div class=\"result-item format-standard equal-height\"
                                                     id=\"result-item-col\"
                                                     data-sen-car=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "id", array()), "html", null, true);
        echo "\">
                                                    <a href=\"";
        // line 20
        echo twig_escape_filter($this->env, (isset($context["_seminuevos"]) ? $context["_seminuevos"] : null), "html", null, true);
        echo "detalles/";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "marca", array()), "nombre_short", array()), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "modelo", array()), "nombre_short", array()), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "id", array()), "html", null, true);
        echo "\"
                                                       class=\"views-details views-details-size bg-views-details views-details-transition visible-lg-block\" 
                                                       data-mar-nombre-short=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "marca", array()), "nombre_short", array()), "html", null, true);
        echo "\"
                                                       data-mdo-nombre-short=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "modelo", array()), "nombre_short", array()), "html", null, true);
        echo "\"
                                                       data-sen-id=\"";
        // line 24
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "id", array()), "html", null, true);
        echo "\">
                                                    <span>ver detalles</span>
                                                    </a>
                                                    <div class=\"result-item-image\">
                                                        <a class=\"media-box\"
                                                           data-mar-nombre-short=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "marca", array()), "nombre_short", array()), "html", null, true);
        echo "\"
                                                           data-mdo-nombre-short=\"";
        // line 30
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "modelo", array()), "nombre_short", array()), "html", null, true);
        echo "\"
                                                           data-sen-id=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "id", array()), "html", null, true);
        echo "\">
                                                        <img src=\"";
        // line 32
        echo twig_escape_filter($this->env, (isset($context["_admin"]) ? $context["_admin"] : null), "html", null, true);
        echo "cdn/img/seminuevos/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "thm_folder", array()), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "thm_nombre", array()), "html", null, true);
        echo "\"
                                                             alt=\"";
        // line 33
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "modelo", array()), "nombre", array()), "html", null, true);
        echo "\">
                                                        </a>
                                                        <div class=\"result-item-labels clearfix\">
                                                            <span class=\"label label-default vehicle-age\" 
                                                                  id=\"sem_year\">";
        // line 37
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "anio", array()), "html", null, true);
        echo "</span>
                                                            <span class=\"label label-success premium-listing\">";
        // line 38
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "agencia", array()), "nombre", array()), "html", null, true);
        echo "</span>
                                                        </div>
                                                        <div class=\"result-item-view-details-resp visible-xs clearfix\">
                                                            <a href=\"";
        // line 41
        echo twig_escape_filter($this->env, (isset($context["_seminuevos"]) ? $context["_seminuevos"] : null), "html", null, true);
        echo "detalles/";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "marca", array()), "nombre_short", array()), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "modelo", array()), "nombre_short", array()), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "id", array()), "html", null, true);
        echo "\"
                                                               class=\"view-details-resp col-md-12 col-xs-12\"
                                                               data-mar-nombre-short=\"";
        // line 43
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "marca", array()), "nombre_short", array()), "html", null, true);
        echo "\"
                                                               data-mdo-nombre-short=\"";
        // line 44
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "modelo", array()), "nombre_short", array()), "html", null, true);
        echo "\"
                                                               data-sen-id=\"";
        // line 45
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "id", array()), "html", null, true);
        echo "\">
                                                            ver detalles
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class=\"result-item-in\">
                                                        <h4 class=\"result-item-title\">
                                                            <a data-mar-nombre-short=\"";
        // line 52
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "marca", array()), "nombre_short", array()), "html", null, true);
        echo "\"
                                                               data-mdo-nombre-short=\"";
        // line 53
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "modelo", array()), "nombre_short", array()), "html", null, true);
        echo "\"
                                                               data-sen-id=\"";
        // line 54
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "id", array()), "html", null, true);
        echo "\">
                                                            ";
        // line 55
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "marca", array()), "nombre", array()), "html", null, true);
        echo " - ";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "modelo", array()), "nombre", array()), "html", null, true);
        echo "
                                                            </a>
                                                        </h4>
                                                        <div class=\"result-item-cont\">
                                                            <div class=\"result-item-block col1\">
                                                                <p>
                                                                    ";
        // line 61
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "descripcion", array()), "html", null, true);
        echo "
                                                                </p>
                                                            </div>
                                                            <div class=\"result-item-block col2\">
                                                                <div class=\"result-item-pricing\">
                                                                    <div class=\"price\">
                                                                        <span class=\"multiple\">
                                                                        \$";
        // line 68
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "precio", array()), 2, ".", ","), "html", null, true);
        echo "
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class=\"result-item-features\">
                                                            <ul class=\"inline\">
                                                                <li>Cilindros: ";
        // line 76
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "cilindros", array()), "html", null, true);
        echo "</li>
                                                                <li>Transmisión: ";
        // line 77
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "transmision", array()), "html", null, true);
        echo "</li>
                                                                <li>Color: ";
        // line 78
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["auto"]) ? $context["auto"] : null), "color", array()), "html", null, true);
        echo "</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
    }

    public function getTemplateName()
    {
        return "seminuevos/inventarios/_main.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  252 => 78,  248 => 77,  244 => 76,  233 => 68,  223 => 61,  212 => 55,  208 => 54,  204 => 53,  200 => 52,  190 => 45,  186 => 44,  182 => 43,  171 => 41,  165 => 38,  161 => 37,  154 => 33,  146 => 32,  142 => 31,  138 => 30,  134 => 29,  126 => 24,  122 => 23,  118 => 22,  107 => 20,  103 => 19,  99 => 17,  96 => 16,  83 => 85,  69 => 84,  66 => 16,  48 => 15,  42 => 10,  32 => 3,  29 => 2,  11 => 1,);
    }
}
/* {% extends "seminuevos/_main.twig" %}*/
/* {% block content_recurrent %}*/
/*     {{ parent() }}*/
/*     <div id="content-start-body-main" class="about-content">*/
/*         <div class="main" role="main">*/
/*             <div id="content" class="content-results full">*/
/*                 <div class="container">*/
/*                     <div class="row">*/
/*                         {# Listing Results #}*/
/*                         <div class="col-md-12 results-container">*/
/*                             <div class="results-container-in">*/
/*                                 <div class="view-results-list" id="content-start-views-results-list">*/
/*                                     <div id="results-holder" class="results-grid-view">*/
/*                                         {# Result Item #}*/
/*                                         {% for auto in seminuevos %}*/
/*                                             {% block result_auto %}*/
/*                                                 <div class="result-item format-standard equal-height"*/
/*                                                      id="result-item-col"*/
/*                                                      data-sen-car="{{ auto.id }}">*/
/*                                                     <a href="{{ _seminuevos }}detalles/{{ auto.marca.nombre_short }}/{{ auto.modelo.nombre_short }}/{{ auto.id }}"*/
/*                                                        class="views-details views-details-size bg-views-details views-details-transition visible-lg-block" */
/*                                                        data-mar-nombre-short="{{ auto.marca.nombre_short }}"*/
/*                                                        data-mdo-nombre-short="{{ auto.modelo.nombre_short }}"*/
/*                                                        data-sen-id="{{ auto.id }}">*/
/*                                                     <span>ver detalles</span>*/
/*                                                     </a>*/
/*                                                     <div class="result-item-image">*/
/*                                                         <a class="media-box"*/
/*                                                            data-mar-nombre-short="{{ auto.marca.nombre_short }}"*/
/*                                                            data-mdo-nombre-short="{{ auto.modelo.nombre_short }}"*/
/*                                                            data-sen-id="{{ auto.id }}">*/
/*                                                         <img src="{{ _admin }}cdn/img/seminuevos/{{ auto.thm_folder }}/{{ auto.thm_nombre }}"*/
/*                                                              alt="{{ auto.modelo.nombre }}">*/
/*                                                         </a>*/
/*                                                         <div class="result-item-labels clearfix">*/
/*                                                             <span class="label label-default vehicle-age" */
/*                                                                   id="sem_year">{{ auto.anio }}</span>*/
/*                                                             <span class="label label-success premium-listing">{{ auto.agencia.nombre }}</span>*/
/*                                                         </div>*/
/*                                                         <div class="result-item-view-details-resp visible-xs clearfix">*/
/*                                                             <a href="{{ _seminuevos }}detalles/{{ auto.marca.nombre_short }}/{{ auto.modelo.nombre_short }}/{{ auto.id }}"*/
/*                                                                class="view-details-resp col-md-12 col-xs-12"*/
/*                                                                data-mar-nombre-short="{{ auto.marca.nombre_short }}"*/
/*                                                                data-mdo-nombre-short="{{ auto.modelo.nombre_short }}"*/
/*                                                                data-sen-id="{{ auto.id }}">*/
/*                                                             ver detalles*/
/*                                                             </a>*/
/*                                                         </div>*/
/*                                                     </div>*/
/*                                                     <div class="result-item-in">*/
/*                                                         <h4 class="result-item-title">*/
/*                                                             <a data-mar-nombre-short="{{ auto.marca.nombre_short }}"*/
/*                                                                data-mdo-nombre-short="{{ auto.modelo.nombre_short }}"*/
/*                                                                data-sen-id="{{ auto.id }}">*/
/*                                                             {{ auto.marca.nombre }} - {{ auto.modelo.nombre }}*/
/*                                                             </a>*/
/*                                                         </h4>*/
/*                                                         <div class="result-item-cont">*/
/*                                                             <div class="result-item-block col1">*/
/*                                                                 <p>*/
/*                                                                     {{ auto.descripcion }}*/
/*                                                                 </p>*/
/*                                                             </div>*/
/*                                                             <div class="result-item-block col2">*/
/*                                                                 <div class="result-item-pricing">*/
/*                                                                     <div class="price">*/
/*                                                                         <span class="multiple">*/
/*                                                                         ${{ auto.precio|number_format(2, '.', ',') }}*/
/*                                                                         </span>*/
/*                                                                     </div>*/
/*                                                                 </div>*/
/*                                                             </div>*/
/*                                                         </div>*/
/*                                                         <div class="result-item-features">*/
/*                                                             <ul class="inline">*/
/*                                                                 <li>Cilindros: {{ auto.cilindros }}</li>*/
/*                                                                 <li>Transmisión: {{ auto.transmision }}</li>*/
/*                                                                 <li>Color: {{ auto.color }}</li>*/
/*                                                             </ul>*/
/*                                                         </div>*/
/*                                                     </div>*/
/*                                                 </div>*/
/*                                             {% endblock %}*/
/*                                         {% endfor %}*/
/*                                     </div>*/
/*                                 </div>*/
/*                             </div>*/
/*                         </div>*/
/*                     </div>*/
/*                 </div>*/
/*             </div>*/
/*         </div>*/
/*     </div>*/
/* {% endblock %}*/
/* */

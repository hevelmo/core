<?php

/* seminuevos/action_bar.twig */
class __TwigTemplate_b4d7dd6bbc376aa91d376f393d13c5eed7f5f59e2812d63d7e8c483ddf422c36 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'filttros' => array($this, 'block_filttros'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div id=\"content-start-inventories-preowned-action-bar\" class=\"about-content\">
    ";
        // line 3
        echo "    <div class=\"sticky-wrapper-action-bar\">
        <div class=\"actions-bar tsticky\" id=\"tsticky\">
            <div class=\"container\">
                <div class=\"row\" id=\"small-screen-filters\">
                    ";
        // line 8
        echo "                    <button class=\"sem-style-button-resp btn btn-default visible-xs\" id=\"Show-Filters\">
                        <i class=\"fa fa-search fa-fw fa-lg\" style=\"padding-right: 30px;\"></i>Filtros de Búsqueda
                    </button>
                    <div id=\"content-start-inventories-preowned-filter-section\">
                        <div class=\"sem-style-panel-filters form-inline form-noPrint\" id=\"Search-Filters\">
                            <div class=\"form-group\">
                                <div class=\"row\">
                                    <div class=\"col-md-12 col-sm-12\" id=\"panel-filters-cateogories\">
                                        <form id=\"search-sen\">
                                            ";
        // line 17
        $this->displayBlock('filttros', $context, $blocks);
        // line 30
        echo "                                        </form>
                                        <div class=\"col-md-3 field-filter-resp\">
                                            <a id=\"sen-get-search\" class=\"button button-transparent bg-youtube resp-button\">
                                                Buscar
                                            </a>
                                        </div>
                                    </div>
                                </div>
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

    // line 17
    public function block_filttros($context, array $blocks = array())
    {
        // line 18
        echo "                                                ";
        $this->loadTemplate("seminuevos/action_bar.twig", "seminuevos/action_bar.twig", 18, "1525946099")->display($context);
        // line 19
        echo "                                                ";
        $this->loadTemplate("seminuevos/action_bar.twig", "seminuevos/action_bar.twig", 19, "1723664543")->display($context);
        // line 20
        echo "                                                <div class=\"col-md-4 field-filter-resp\">
                                                    <input type=\"text\"
                                                           name=\"sen_search\"
                                                           id=\"sen-get-searching\"
                                                           placeholder=\"Buscar\"
                                                           class=\"form-control\"
                                                           style=\"font-size: 1.3em;\"
                                                           value=\"";
        // line 27
        echo twig_escape_filter($this->env, (isset($context["mystery"]) ? $context["mystery"] : null), "html", null, true);
        echo "\">
                                                </div>
                                            ";
    }

    public function getTemplateName()
    {
        return "seminuevos/action_bar.twig";
    }

    public function getDebugInfo()
    {
        return array (  80 => 27,  71 => 20,  68 => 19,  65 => 18,  62 => 17,  42 => 30,  40 => 17,  29 => 8,  23 => 3,  20 => 1,);
    }
}


/* seminuevos/action_bar.twig */
class __TwigTemplate_b4d7dd6bbc376aa91d376f393d13c5eed7f5f59e2812d63d7e8c483ddf422c36_1525946099 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 18
        $this->parent = $this->loadTemplate("seminuevos/action_bar_marcas.twig", "seminuevos/action_bar.twig", 18);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "seminuevos/action_bar_marcas.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "seminuevos/action_bar.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  106 => 18,  80 => 27,  71 => 20,  68 => 19,  65 => 18,  62 => 17,  42 => 30,  40 => 17,  29 => 8,  23 => 3,  20 => 1,);
    }
}


/* seminuevos/action_bar.twig */
class __TwigTemplate_b4d7dd6bbc376aa91d376f393d13c5eed7f5f59e2812d63d7e8c483ddf422c36_1723664543 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 19
        $this->parent = $this->loadTemplate("seminuevos/action_bar_modelos.twig", "seminuevos/action_bar.twig", 19);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "seminuevos/action_bar_modelos.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "seminuevos/action_bar.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  146 => 19,  106 => 18,  80 => 27,  71 => 20,  68 => 19,  65 => 18,  62 => 17,  42 => 30,  40 => 17,  29 => 8,  23 => 3,  20 => 1,);
    }
}
/* <div id="content-start-inventories-preowned-action-bar" class="about-content">*/
/*     {# Actions bar #}*/
/*     <div class="sticky-wrapper-action-bar">*/
/*         <div class="actions-bar tsticky" id="tsticky">*/
/*             <div class="container">*/
/*                 <div class="row" id="small-screen-filters">*/
/*                     {# Small Screens Filters Toggle Button #}*/
/*                     <button class="sem-style-button-resp btn btn-default visible-xs" id="Show-Filters">*/
/*                         <i class="fa fa-search fa-fw fa-lg" style="padding-right: 30px;"></i>Filtros de Búsqueda*/
/*                     </button>*/
/*                     <div id="content-start-inventories-preowned-filter-section">*/
/*                         <div class="sem-style-panel-filters form-inline form-noPrint" id="Search-Filters">*/
/*                             <div class="form-group">*/
/*                                 <div class="row">*/
/*                                     <div class="col-md-12 col-sm-12" id="panel-filters-cateogories">*/
/*                                         <form id="search-sen">*/
/*                                             {% block filttros %}*/
/*                                                 {% embed "seminuevos/action_bar_marcas.twig" %}{% endembed %}*/
/*                                                 {% embed "seminuevos/action_bar_modelos.twig" %}{% endembed %}*/
/*                                                 <div class="col-md-4 field-filter-resp">*/
/*                                                     <input type="text"*/
/*                                                            name="sen_search"*/
/*                                                            id="sen-get-searching"*/
/*                                                            placeholder="Buscar"*/
/*                                                            class="form-control"*/
/*                                                            style="font-size: 1.3em;"*/
/*                                                            value="{{ mystery }}">*/
/*                                                 </div>*/
/*                                             {% endblock %}*/
/*                                         </form>*/
/*                                         <div class="col-md-3 field-filter-resp">*/
/*                                             <a id="sen-get-search" class="button button-transparent bg-youtube resp-button">*/
/*                                                 Buscar*/
/*                                             </a>*/
/*                                         </div>*/
/*                                     </div>*/
/*                                 </div>*/
/*                             </div>*/
/*                         </div>*/
/*                     </div>*/
/*                 </div>*/
/*             </div>*/
/*         </div>*/
/*     </div>*/
/* </div>*/
/* */

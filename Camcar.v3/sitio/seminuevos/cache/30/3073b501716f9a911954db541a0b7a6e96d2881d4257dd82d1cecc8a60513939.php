<?php

/* 404/main.twig */
class __TwigTemplate_1ab98acc3cc4c173a5ee3045f59643e748910b61fa6716a7823fbe03365e8c9e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("super.twig", "404/main.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content_recurrent' => array($this, 'block_content_recurrent'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "super.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true);
    }

    // line 3
    public function block_content_recurrent($context, array $blocks = array())
    {
        // line 4
        echo "    <div id=\"content-start-body-main\" class=\"about-content\">
        <div class=\"main\" role=\"main\">
            <div id=\"content\" class=\"content-results full\">
                <div class=\"container\">
                    <h1>PÁGINA NO ENCONTRADA</h1>
                    <a href=\"#\" onclick=\"history.go(-1);\">
                        <h3>REGRESAR</h3>
                    </a>
                </div>
            </div>
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "404/main.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 4,  35 => 3,  29 => 2,  11 => 1,);
    }
}
/* {% extends "super.twig" %}*/
/* {% block title %}{{ title }}{% endblock %}*/
/* {% block content_recurrent %}*/
/*     <div id="content-start-body-main" class="about-content">*/
/*         <div class="main" role="main">*/
/*             <div id="content" class="content-results full">*/
/*                 <div class="container">*/
/*                     <h1>PÁGINA NO ENCONTRADA</h1>*/
/*                     <a href="#" onclick="history.go(-1);">*/
/*                         <h3>REGRESAR</h3>*/
/*                     </a>*/
/*                 </div>*/
/*             </div>*/
/*         </div>*/
/*     </div>*/
/* {% endblock %}*/

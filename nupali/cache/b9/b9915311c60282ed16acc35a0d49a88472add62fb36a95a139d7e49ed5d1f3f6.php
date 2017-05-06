<?php

/* home/_main.twig */
class __TwigTemplate_2164fb46bb5cd88378bd4136f49d8617179db079f0fd34413b038ccbabd058b5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("super.twig", "home/_main.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content_current' => array($this, 'block_content_current'),
            'script_load_js' => array($this, 'block_script_load_js'),
            'load_scripts' => array($this, 'block_load_scripts'),
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
    public function block_content_current($context, array $blocks = array())
    {
        // line 4
        echo "    ";
    }

    // line 6
    public function block_script_load_js($context, array $blocks = array())
    {
    }

    // line 8
    public function block_load_scripts($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "home/_main.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  49 => 8,  44 => 6,  40 => 4,  37 => 3,  31 => 2,  11 => 1,);
    }
}
/* {% extends "super.twig" %}*/
/* {% block title %}{{ title }}{% endblock %}*/
/* {% block content_current %}*/
/*     {#{% embed "home/slider.twig" %}{% endembed %}#}*/
/* {% endblock %}*/
/* {% block script_load_js %}*/
/* {% endblock %}*/
/* {% block load_scripts %}*/
/* {% endblock %}*/

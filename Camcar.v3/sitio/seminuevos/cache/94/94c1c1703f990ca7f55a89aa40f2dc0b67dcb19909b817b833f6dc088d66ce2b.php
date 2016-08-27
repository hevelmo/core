<?php

/* seminuevos/_main.twig */
class __TwigTemplate_af11868c02411931e08c0f96ec7ba8a8f6de6c7d13a586847ddcbbd0bde1c044 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("super.twig", "seminuevos/_main.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content_recurrent' => array($this, 'block_content_recurrent'),
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
    public function block_content_recurrent($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        $this->loadTemplate("seminuevos/_main.twig", "seminuevos/_main.twig", 4, "728535145")->display($context);
        // line 5
        echo "    ";
        $this->loadTemplate("seminuevos/_main.twig", "seminuevos/_main.twig", 5, "1230973711")->display($context);
    }

    // line 7
    public function block_load_scripts($context, array $blocks = array())
    {
        // line 8
        echo "    equalHeightsMethods.equalHeightsLoad();
";
    }

    public function getTemplateName()
    {
        return "seminuevos/_main.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  50 => 8,  47 => 7,  42 => 5,  39 => 4,  36 => 3,  30 => 2,  11 => 1,);
    }
}


/* seminuevos/_main.twig */
class __TwigTemplate_af11868c02411931e08c0f96ec7ba8a8f6de6c7d13a586847ddcbbd0bde1c044_728535145 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 4
        $this->parent = $this->loadTemplate("seminuevos/utility_bar.twig", "seminuevos/_main.twig", 4);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "seminuevos/utility_bar.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "seminuevos/_main.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  79 => 4,  50 => 8,  47 => 7,  42 => 5,  39 => 4,  36 => 3,  30 => 2,  11 => 1,);
    }
}


/* seminuevos/_main.twig */
class __TwigTemplate_af11868c02411931e08c0f96ec7ba8a8f6de6c7d13a586847ddcbbd0bde1c044_1230973711 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 5
        $this->parent = $this->loadTemplate("seminuevos/action_bar.twig", "seminuevos/_main.twig", 5);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "seminuevos/action_bar.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "seminuevos/_main.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  119 => 5,  79 => 4,  50 => 8,  47 => 7,  42 => 5,  39 => 4,  36 => 3,  30 => 2,  11 => 1,);
    }
}
/* {% extends "super.twig" %}*/
/* {% block title %}{{ title }}{% endblock %}*/
/* {% block content_recurrent %}*/
/*     {% embed "seminuevos/utility_bar.twig" %}{% endembed %}*/
/*     {% embed "seminuevos/action_bar.twig" %}{% endembed %}*/
/* {% endblock %}*/
/* {% block load_scripts %}*/
/*     equalHeightsMethods.equalHeightsLoad();*/
/* {% endblock %}*/
/* */

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
            'preloader' => array($this, 'block_preloader'),
            'header_nav' => array($this, 'block_header_nav'),
            'content_current' => array($this, 'block_content_current'),
            'top_button' => array($this, 'block_top_button'),
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
    public function block_preloader($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        $this->loadTemplate("home/_main.twig", "home/_main.twig", 4, "514896103")->display($context);
    }

    // line 6
    public function block_header_nav($context, array $blocks = array())
    {
        // line 7
        echo "    ";
        $this->loadTemplate("home/_main.twig", "home/_main.twig", 7, "814672262")->display($context);
    }

    // line 9
    public function block_content_current($context, array $blocks = array())
    {
        // line 10
        echo "    ";
        $this->loadTemplate("home/_main.twig", "home/_main.twig", 10, "972814395")->display($context);
    }

    // line 12
    public function block_top_button($context, array $blocks = array())
    {
        // line 13
        echo "    ";
        $this->loadTemplate("home/_main.twig", "home/_main.twig", 13, "929283125")->display($context);
    }

    // line 15
    public function block_script_load_js($context, array $blocks = array())
    {
    }

    // line 17
    public function block_load_scripts($context, array $blocks = array())
    {
        // line 18
        echo "    ";
        // line 21
        echo "    \$('.video-play').vide(\"";
        echo twig_escape_filter($this->env, (isset($context["_host"]) ? $context["_host"] : null), "html", null, true);
        echo "img/video/video\", {
        posterType: \"jpg\"
    });
";
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
        return array (  82 => 21,  80 => 18,  77 => 17,  72 => 15,  67 => 13,  64 => 12,  59 => 10,  56 => 9,  51 => 7,  48 => 6,  43 => 4,  40 => 3,  34 => 2,  11 => 1,);
    }
}


/* home/_main.twig */
class __TwigTemplate_2164fb46bb5cd88378bd4136f49d8617179db079f0fd34413b038ccbabd058b5_514896103 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 4
        $this->parent = $this->loadTemplate("assets/preloader.twig", "home/_main.twig", 4);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "assets/preloader.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
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
        return array (  115 => 4,  82 => 21,  80 => 18,  77 => 17,  72 => 15,  67 => 13,  64 => 12,  59 => 10,  56 => 9,  51 => 7,  48 => 6,  43 => 4,  40 => 3,  34 => 2,  11 => 1,);
    }
}


/* home/_main.twig */
class __TwigTemplate_2164fb46bb5cd88378bd4136f49d8617179db079f0fd34413b038ccbabd058b5_814672262 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 7
        $this->parent = $this->loadTemplate("assets/navbar.twig", "home/_main.twig", 7);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "assets/navbar.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
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
        return array (  155 => 7,  115 => 4,  82 => 21,  80 => 18,  77 => 17,  72 => 15,  67 => 13,  64 => 12,  59 => 10,  56 => 9,  51 => 7,  48 => 6,  43 => 4,  40 => 3,  34 => 2,  11 => 1,);
    }
}


/* home/_main.twig */
class __TwigTemplate_2164fb46bb5cd88378bd4136f49d8617179db079f0fd34413b038ccbabd058b5_972814395 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 10
        $this->parent = $this->loadTemplate("home/container.twig", "home/_main.twig", 10);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "home/container.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
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
        return array (  195 => 10,  155 => 7,  115 => 4,  82 => 21,  80 => 18,  77 => 17,  72 => 15,  67 => 13,  64 => 12,  59 => 10,  56 => 9,  51 => 7,  48 => 6,  43 => 4,  40 => 3,  34 => 2,  11 => 1,);
    }
}


/* home/_main.twig */
class __TwigTemplate_2164fb46bb5cd88378bd4136f49d8617179db079f0fd34413b038ccbabd058b5_929283125 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 13
        $this->parent = $this->loadTemplate("assets/top_button.twig", "home/_main.twig", 13);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "assets/top_button.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
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
        return array (  235 => 13,  195 => 10,  155 => 7,  115 => 4,  82 => 21,  80 => 18,  77 => 17,  72 => 15,  67 => 13,  64 => 12,  59 => 10,  56 => 9,  51 => 7,  48 => 6,  43 => 4,  40 => 3,  34 => 2,  11 => 1,);
    }
}
/* {% extends "super.twig" %}*/
/* {% block title %}{{ title }}{% endblock %}*/
/* {% block preloader %}*/
/*     {% embed "assets/preloader.twig" %}{% endembed %}*/
/* {% endblock %}*/
/* {% block header_nav %}*/
/*     {% embed "assets/navbar.twig" %}{% endembed %}*/
/* {% endblock %}*/
/* {% block content_current %}*/
/*     {% embed "home/container.twig" %}{% endembed %}*/
/* {% endblock %}*/
/* {% block top_button %}*/
/*     {% embed "assets/top_button.twig" %}{% endembed %}*/
/* {% endblock %}*/
/* {% block script_load_js %}*/
/* {% endblock %}*/
/* {% block load_scripts %}*/
/*     {# ===========================================================*/
/*        VIDEO BACKGROUND*/
/*     ============================================================== #}*/
/*     $('.video-play').vide("{{ _host }}img/video/video", {*/
/*         posterType: "jpg"*/
/*     });*/
/* {% endblock %}*/

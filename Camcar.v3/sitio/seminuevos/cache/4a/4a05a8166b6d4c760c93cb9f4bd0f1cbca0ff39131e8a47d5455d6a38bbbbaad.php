<?php

/* seminuevos/detalles/imagenes.twig */
class __TwigTemplate_ad2b92c56405179d980cced4b6bd180de159437d88d9be80f78a77b74c710044 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'imagenes' => array($this, 'block_imagenes'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"col-md-8\">
    <div class=\"single-listing-images\" id=\"content-vehicle-slider-details\">
        <section class=\"slider\" data-slider-id=\"";
        // line 3
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["imagenes"]) ? $context["imagenes"] : null), 0, array(), "array"), "folder", array()), "html", null, true);
        echo "\">
            <div class=\"flexslider\">
                <ul class=\"slides\">
                    ";
        // line 6
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["imagenes"]) ? $context["imagenes"] : null));
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
        foreach ($context['_seq'] as $context["_key"] => $context["picture"]) {
            // line 7
            echo "                        ";
            $this->displayBlock('imagenes', $context, $blocks);
            // line 14
            echo "                    ";
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['picture'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 15
        echo "                </ul>
            </div>
        </section>
    </div>
</div>
";
    }

    // line 7
    public function block_imagenes($context, array $blocks = array())
    {
        // line 8
        echo "                            <li data-thumb=\"";
        echo twig_escape_filter($this->env, (isset($context["_admin"]) ? $context["_admin"] : null), "html", null, true);
        echo "cdn/img/seminuevos/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["picture"]) ? $context["picture"] : null), "folder", array()), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["picture"]) ? $context["picture"] : null), "nombre", array()), "html", null, true);
        echo "\"
                                data-slider-pic_id=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["picture"]) ? $context["picture"] : null), "id", array()), "html", null, true);
        echo "\">
                                <img src=\"";
        // line 10
        echo twig_escape_filter($this->env, (isset($context["_admin"]) ? $context["_admin"] : null), "html", null, true);
        echo "cdn/img/seminuevos/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["picture"]) ? $context["picture"] : null), "folder", array()), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["picture"]) ? $context["picture"] : null), "nombre", array()), "html", null, true);
        echo "\"
                                     data-slider-pic_id=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["picture"]) ? $context["picture"] : null), "id", array()), "html", null, true);
        echo "\">
                            </li>
                        ";
    }

    public function getTemplateName()
    {
        return "seminuevos/detalles/imagenes.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  97 => 11,  89 => 10,  85 => 9,  76 => 8,  73 => 7,  64 => 15,  50 => 14,  47 => 7,  30 => 6,  24 => 3,  20 => 1,);
    }
}
/* <div class="col-md-8">*/
/*     <div class="single-listing-images" id="content-vehicle-slider-details">*/
/*         <section class="slider" data-slider-id="{{ imagenes[0].folder }}">*/
/*             <div class="flexslider">*/
/*                 <ul class="slides">*/
/*                     {% for picture in imagenes %}*/
/*                         {% block imagenes %}*/
/*                             <li data-thumb="{{ _admin }}cdn/img/seminuevos/{{ picture.folder }}/{{ picture.nombre }}"*/
/*                                 data-slider-pic_id="{{ picture.id }}">*/
/*                                 <img src="{{ _admin }}cdn/img/seminuevos/{{ picture.folder }}/{{ picture.nombre }}"*/
/*                                      data-slider-pic_id="{{ picture.id }}">*/
/*                             </li>*/
/*                         {% endblock %}*/
/*                     {% endfor %}*/
/*                 </ul>*/
/*             </div>*/
/*         </section>*/
/*     </div>*/
/* </div>*/
/* */

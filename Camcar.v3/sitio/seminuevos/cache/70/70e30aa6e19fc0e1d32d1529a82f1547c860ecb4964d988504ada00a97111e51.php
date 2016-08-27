<?php

/* seminuevos/action_bar_marcas.twig */
class __TwigTemplate_3344f110bd5b8620840ce2c6a4959adc15302bcd4b3d1c1db3136cbbb14eae50 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'marcas' => array($this, 'block_marcas'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $context["marcaSel"] = (isset($context["marca"]) ? $context["marca"] : null);
        // line 2
        echo "<div id=\"div-get-brands\" 
     class=\"col-md-4 field-filter-resp\">
    <select name=\"sen_mar\" 
            id=\"sen-get-brand\" 
            class=\"selectpicker btn-default form-control sel-marca\" 
            style=\"display: none;\">
        <option value=\"0\" 
                class=\"filter-action-mrc\" 
                id=\"filter-action-mrc-\" 
                data-name-short=\"\">
            Marca
        </option>
        ";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["marcas"]) ? $context["marcas"] : null));
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
        foreach ($context['_seq'] as $context["_key"] => $context["currentMarca"]) {
            // line 15
            echo "            ";
            $this->displayBlock('marcas', $context, $blocks);
            // line 24
            echo "        ";
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['currentMarca'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 25
        echo "    </select>
</div>
";
    }

    // line 15
    public function block_marcas($context, array $blocks = array())
    {
        // line 16
        echo "                <option value=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["currentMarca"]) ? $context["currentMarca"] : null), "id", array()), "html", null, true);
        echo "\" 
                        class=\"filter-action-mrc\" 
                        id=\"filter-action-mrc-";
        // line 18
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["currentMarca"]) ? $context["currentMarca"] : null), "id", array()), "html", null, true);
        echo "\" 
                        data-name-short=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["currentMarca"]) ? $context["currentMarca"] : null), "nombre_short", array()), "html", null, true);
        echo "\" 
                        ";
        // line 20
        echo ((((isset($context["marcaSel"]) ? $context["marcaSel"] : null) == $this->getAttribute((isset($context["currentMarca"]) ? $context["currentMarca"] : null), "nombre_short", array()))) ? ("selected") : (""));
        echo " >
                    ";
        // line 21
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["currentMarca"]) ? $context["currentMarca"] : null), "nombre", array()), "html", null, true);
        echo "
                </option>
            ";
    }

    public function getTemplateName()
    {
        return "seminuevos/action_bar_marcas.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  97 => 21,  93 => 20,  89 => 19,  85 => 18,  79 => 16,  76 => 15,  70 => 25,  56 => 24,  53 => 15,  36 => 14,  22 => 2,  20 => 1,);
    }
}
/* {% set marcaSel = marca %}*/
/* <div id="div-get-brands" */
/*      class="col-md-4 field-filter-resp">*/
/*     <select name="sen_mar" */
/*             id="sen-get-brand" */
/*             class="selectpicker btn-default form-control sel-marca" */
/*             style="display: none;">*/
/*         <option value="0" */
/*                 class="filter-action-mrc" */
/*                 id="filter-action-mrc-" */
/*                 data-name-short="">*/
/*             Marca*/
/*         </option>*/
/*         {% for currentMarca in marcas %}*/
/*             {% block marcas %}*/
/*                 <option value="{{ currentMarca.id }}" */
/*                         class="filter-action-mrc" */
/*                         id="filter-action-mrc-{{ currentMarca.id }}" */
/*                         data-name-short="{{ currentMarca.nombre_short }}" */
/*                         {{ (marcaSel == currentMarca.nombre_short) ? "selected" : "" }} >*/
/*                     {{ currentMarca.nombre }}*/
/*                 </option>*/
/*             {% endblock %}*/
/*         {% endfor %}*/
/*     </select>*/
/* </div>*/
/* */

<?php

/* seminuevos/action_bar_modelos.twig */
class __TwigTemplate_7802bd77ebfebec00f4669c4463a23602d508e8a6666e3bffd3339aa988b35ac extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'modelos' => array($this, 'block_modelos'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $context["modeloSel"] = (isset($context["modelo"]) ? $context["modelo"] : null);
        // line 2
        echo "<div id=\"div-get-models\" 
     class=\"col-md-4 field-filter-resp\">
    <select name=\"sen_mdo\" 
            id=\"sen-get-model\" 
            class=\"selectpicker btn-default form-control sel-modelo\" 
            style=\"display: none;\">
        <option value=\"0\" 
                class=\"filter-action-mdo\" 
                id=\"filter-action-mdo-\" 
                data-name-short=\"\">
            Modelo
        </option>
        ";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["modelos"]) ? $context["modelos"] : null));
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
        foreach ($context['_seq'] as $context["_key"] => $context["currentModelo"]) {
            // line 15
            echo "            ";
            $this->displayBlock('modelos', $context, $blocks);
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['currentModelo'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 25
        echo "    </select>
</div>
";
    }

    // line 15
    public function block_modelos($context, array $blocks = array())
    {
        // line 16
        echo "                <option value=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["currentModelo"]) ? $context["currentModelo"] : null), "id", array()), "html", null, true);
        echo "\" 
                        class=\"filter-action-mdo\" 
                        id=\"filter-action-mdo-";
        // line 18
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["currentModelo"]) ? $context["currentModelo"] : null), "id", array()), "html", null, true);
        echo "\" 
                        data-name-short=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["currentModelo"]) ? $context["currentModelo"] : null), "nombre_short", array()), "html", null, true);
        echo "\" 
                        ";
        // line 20
        echo ((((isset($context["modeloSel"]) ? $context["modeloSel"] : null) == $this->getAttribute((isset($context["currentModelo"]) ? $context["currentModelo"] : null), "nombre_short", array()))) ? ("selected") : (""));
        echo " >
                    ";
        // line 21
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["currentModelo"]) ? $context["currentModelo"] : null), "nombre", array()), "html", null, true);
        echo "
                </option>
            ";
    }

    public function getTemplateName()
    {
        return "seminuevos/action_bar_modelos.twig";
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
/* {% set modeloSel = modelo %}*/
/* <div id="div-get-models" */
/*      class="col-md-4 field-filter-resp">*/
/*     <select name="sen_mdo" */
/*             id="sen-get-model" */
/*             class="selectpicker btn-default form-control sel-modelo" */
/*             style="display: none;">*/
/*         <option value="0" */
/*                 class="filter-action-mdo" */
/*                 id="filter-action-mdo-" */
/*                 data-name-short="">*/
/*             Modelo*/
/*         </option>*/
/*         {% for currentModelo in modelos %}*/
/*             {% block modelos %}*/
/*                 <option value="{{ currentModelo.id }}" */
/*                         class="filter-action-mdo" */
/*                         id="filter-action-mdo-{{ currentModelo.id }}" */
/*                         data-name-short="{{ currentModelo.nombre_short }}" */
/*                         {{ (modeloSel == currentModelo.nombre_short) ? "selected" : "" }} >*/
/*                     {{ currentModelo.nombre }}*/
/*                 </option>*/
/*             {% endblock %}*/
/*         {% endfor %}*/
/*     </select>*/
/* </div>*/
/* */

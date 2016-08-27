<?php

/* seminuevos/detalles/descripcion.twig */
class __TwigTemplate_9aaa0e25615d42606050ae81b23fdf8abf79c5bedccf0d896d44e92d956ceecb extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'especificaciones' => array($this, 'block_especificaciones'),
            'descripcion' => array($this, 'block_descripcion'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"col-md-4\">
    <div class=\"sidebar-widget widget\">
        <div id=\"content_specifications\">
            ";
        // line 4
        $this->displayBlock('especificaciones', $context, $blocks);
        // line 46
        echo "        </div>
        ";
        // line 47
        $this->displayBlock('descripcion', $context, $blocks);
        // line 77
        echo "    </div>
</div>
";
    }

    // line 4
    public function block_especificaciones($context, array $blocks = array())
    {
        // line 5
        echo "                <table class=\"table-specifications table table-striped table-hover\">
                    <tbody>
                        <tr>
                            <td>
                                <span class=\"arrow_badge\">Marca</span>
                            </td>
                            <td>";
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "marca", array()), "nombre", array()), "html", null, true);
        echo "</td>
                        </tr>
                        <tr>
                            <td>
                                <span class=\"arrow_badge\">Modelo</span>
                            </td>
                            <td>";
        // line 17
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "modelo", array()), "nombre", array()), "html", null, true);
        echo "</td>
                        </tr>
                        <tr>
                            <td>
                                <span class=\"arrow_badge\">Cilindros</span>
                            </td>
                            <td>";
        // line 23
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "cilindros", array()), "html", null, true);
        echo "</td>
                        </tr>
                        <tr>
                            <td>
                                <span class=\"arrow_badge\">Año</span>
                            </td>
                            <td>";
        // line 29
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "anio", array()), "html", null, true);
        echo "</td>
                        </tr>
                        <tr>
                            <td>
                                <span class=\"arrow_badge\">Interior</span>
                            </td>
                            <td>";
        // line 35
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "interior", array()), "html", null, true);
        echo "</td>
                        </tr>
                        <tr>
                            <td>
                                <span class=\"arrow_badge\">Color</span>
                            </td>
                            <td>";
        // line 41
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "color", array()), "html", null, true);
        echo "</td>
                        </tr>
                    </tbody>
                </table>
            ";
    }

    // line 47
    public function block_descripcion($context, array $blocks = array())
    {
        // line 48
        echo "            <div class=\"vehicle-enquiry-foot pull-left\">
                <h6 class=\"widgettitle\">
                    DESCRIPCIÓN
                </h6>
                <strong class=\"address-description to_print\">
                    ";
        // line 53
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "descripcion", array()), "html", null, true);
        echo "
                </strong>
            </div>
            <div class=\"vehicle-enquiry-foot pull-left\">
                <h6 class=\"widgettitle\">
                    ";
        // line 58
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "agencia", array()), "nombre", array()), "html", null, true);
        echo "
                </h6>
                <span class=\"vehicle-enquiry-foot-ico\">
                    <i class=\"fa fa-location-arrow\"></i>
                </span>
                <strong class=\"address\">
                    ";
        // line 64
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "agencia", array()), "direccion", array()), "html", null, true);
        echo "
                </strong>
                <br>
                <span class=\"vehicle-enquiry-foot-ico\">
                    <i class=\"fa fa-phone\"></i>
                </span>
                ";
        // line 70
        if ((trim($this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "telefonos", array()), "ventas_tel_1", array())) != "")) {
            // line 71
            echo "                    <strong class=\"address\">
                        ";
            // line 72
            echo twig_escape_filter($this->env, trim($this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "telefonos", array()), "ventas_tel_1", array())), "html", null, true);
            echo "
                    </strong>
                ";
        }
        // line 75
        echo "            </div>
        ";
    }

    public function getTemplateName()
    {
        return "seminuevos/detalles/descripcion.twig";
    }

    public function getDebugInfo()
    {
        return array (  151 => 75,  145 => 72,  142 => 71,  140 => 70,  131 => 64,  122 => 58,  114 => 53,  107 => 48,  104 => 47,  95 => 41,  86 => 35,  77 => 29,  68 => 23,  59 => 17,  50 => 11,  42 => 5,  39 => 4,  33 => 77,  31 => 47,  28 => 46,  26 => 4,  21 => 1,);
    }
}
/* <div class="col-md-4">*/
/*     <div class="sidebar-widget widget">*/
/*         <div id="content_specifications">*/
/*             {% block especificaciones %}*/
/*                 <table class="table-specifications table table-striped table-hover">*/
/*                     <tbody>*/
/*                         <tr>*/
/*                             <td>*/
/*                                 <span class="arrow_badge">Marca</span>*/
/*                             </td>*/
/*                             <td>{{ detalle.marca.nombre }}</td>*/
/*                         </tr>*/
/*                         <tr>*/
/*                             <td>*/
/*                                 <span class="arrow_badge">Modelo</span>*/
/*                             </td>*/
/*                             <td>{{ detalle.modelo.nombre }}</td>*/
/*                         </tr>*/
/*                         <tr>*/
/*                             <td>*/
/*                                 <span class="arrow_badge">Cilindros</span>*/
/*                             </td>*/
/*                             <td>{{ detalle.cilindros }}</td>*/
/*                         </tr>*/
/*                         <tr>*/
/*                             <td>*/
/*                                 <span class="arrow_badge">Año</span>*/
/*                             </td>*/
/*                             <td>{{ detalle.anio }}</td>*/
/*                         </tr>*/
/*                         <tr>*/
/*                             <td>*/
/*                                 <span class="arrow_badge">Interior</span>*/
/*                             </td>*/
/*                             <td>{{ detalle.interior }}</td>*/
/*                         </tr>*/
/*                         <tr>*/
/*                             <td>*/
/*                                 <span class="arrow_badge">Color</span>*/
/*                             </td>*/
/*                             <td>{{ detalle.color }}</td>*/
/*                         </tr>*/
/*                     </tbody>*/
/*                 </table>*/
/*             {% endblock %}*/
/*         </div>*/
/*         {% block descripcion %}*/
/*             <div class="vehicle-enquiry-foot pull-left">*/
/*                 <h6 class="widgettitle">*/
/*                     DESCRIPCIÓN*/
/*                 </h6>*/
/*                 <strong class="address-description to_print">*/
/*                     {{ detalle.descripcion }}*/
/*                 </strong>*/
/*             </div>*/
/*             <div class="vehicle-enquiry-foot pull-left">*/
/*                 <h6 class="widgettitle">*/
/*                     {{ detalle.agencia.nombre }}*/
/*                 </h6>*/
/*                 <span class="vehicle-enquiry-foot-ico">*/
/*                     <i class="fa fa-location-arrow"></i>*/
/*                 </span>*/
/*                 <strong class="address">*/
/*                     {{ detalle.agencia.direccion }}*/
/*                 </strong>*/
/*                 <br>*/
/*                 <span class="vehicle-enquiry-foot-ico">*/
/*                     <i class="fa fa-phone"></i>*/
/*                 </span>*/
/*                 {% if detalle.telefonos.ventas_tel_1|trim != "" %}*/
/*                     <strong class="address">*/
/*                         {{ detalle.telefonos.ventas_tel_1|trim }}*/
/*                     </strong>*/
/*                 {% endif %}*/
/*             </div>*/
/*         {% endblock %}*/
/*     </div>*/
/* </div>*/
/* */

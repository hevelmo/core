<?php

/* seminuevos/detalles/contacto.twig */
class __TwigTemplate_8df91e2476b1ec02e0ef8ef7c79474935875186d2dc9d705fb1966520de94e55 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'contacto_form' => array($this, 'block_contacto_form'),
            'contacto_mensajes' => array($this, 'block_contacto_mensajes'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"col-md-4\">
    <div id=\"content_form_contact_by_model\">
        <div class=\"sidebar-widget widget no-print\">
            <div class=\"vehicle-enquiry-foot pull-left contact_main\" 
                 style=\"width: 100%;\">
                <h6 class=\"widgettitle no-print\">
                    CONTACTO
                </h6>
                <div class=\"vehicle-enquiry-in contact_content clearfix\">
                    <div id=\"form-wrapper\">
                        ";
        // line 11
        $this->displayBlock('contacto_form', $context, $blocks);
        // line 148
        echo "
                    </div>
                    ";
        // line 150
        $this->displayBlock('contacto_mensajes', $context, $blocks);
        // line 179
        echo "                </div>
            </div>
        </div>
    </div>
</div>
";
    }

    // line 11
    public function block_contacto_form($context, array $blocks = array())
    {
        // line 12
        echo "                            <form class=\"email-form-sen-premium-by-model\"
                                  id=\"detail-sen-contact\"
                                  data-sen-id=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "id", array()), "html", null, true);
        echo "\">
                                <div class=\"contact_elements\">
                                    <div class=\"contact_element ab\">
                                        <fieldset>
                                            <input type=\"text\"
                                                   name=\"sen_name\"
                                                   id=\"detail-sen-name\"
                                                   placeholder=\"Nombre\"
                                                   class=\"detail-sen-element input-standard validate-required no-print\"
                                                   style=\"font-size: 1.3em;\"
                                                   data-validation-data=\"required|name\">
                                            <p class=\"invalid-message\" id=\"error_nombre\">
                                                 Este campo es obligatorio
                                                <span>&nbsp;</span>
                                            </p>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class=\"contact_elements\">
                                    <div class=\"contact_element ab\">
                                        <fieldset>
                                            <input type=\"text\"
                                                   name=\"sen_lastname\"
                                                   id=\"detail-sen-lastname\"
                                                   placeholder=\"Apellido\"
                                                   class=\"detail-sen-element input-standard validate-required no-print\"
                                                   style=\"font-size: 1.3em;\"
                                                   data-validation-data=\"required|lastname\">
                                            <p class=\"invalid-message\" id=\"error_apellido\">
                                                 Este campo es obligatorio
                                                <span>&nbsp;</span>
                                            </p>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class=\"contact_elements\">
                                    <div class=\"contact_element ab\">
                                        <fieldset>
                                            <input type=\"email\" 
                                                   name=\"sen_email\"
                                                   id=\"detail-sen-email\"
                                                   placeholder=\"Email\"
                                                   class=\"detail-sen-element input-standard validate-required validate-email no-print\"
                                                   style=\"font-size: 1.3em;\"
                                                   data-validation-data=\"required|email\">
                                            <p class=\"invalid-message\" id=\"error_correo\">
                                                Este campo es obligatorio
                                                <span>&nbsp;</span>
                                            </p>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class=\"contact_elements\">
                                    <div class=\"contact_element ab\">
                                        <fieldset>
                                            <input type=\"text\"
                                                   name=\"sen_phone\"
                                                   id=\"detail-sen-phone\"
                                                   placeholder=\"Telefono\"
                                                   maxlength=\"13\"
                                                   class=\"detail-sen-element input-standard validate-required no-print\"
                                                   style=\"font-size: 1.3em;\"
                                                   data-validation-data=\"required|phone\">
                                            <p class=\"invalid-message\" id=\"error_phone\">
                                                Este campo es obligatorio
                                                <span>&nbsp;</span>
                                            </p>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class=\"contact_elements\">
                                    <div class=\"contact_element ab\">
                                        <fieldset>
                                            <textarea name=\"sen_message\" 
                                                 id=\"detail-sen-message\" 
                                                 class=\"detail-sen-element input-standard validate-required no-print\" 
                                                 placeholder=\"Comentario\" 
                                                 style=\"font-size: 1.3em;\" 
                                                 data-validation-data=\"required|address\"></textarea>
                                            <p class=\"invalid-message\" id=\"error_mensaje\">
                                                Este campo es obligatorio
                                                <span>&nbsp;</span>
                                            </p>
                                        </fieldset>
                                    </div>
                                </div>

                                <div class=\"row\">
                                    <input type=\"hidden\"
                                           name=\"sen_email_send\"
                                           id=\"detail-sen-email-send\"
                                           value=\"";
        // line 105
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "agencia", array()), "correo", array()), "html", null, true);
        echo "\">
                                    <input type=\"hidden\"
                                           name=\"sen_concessionary\"
                                           id=\"detail-sen-concessionary\"
                                           value=\"CAMCAR - ";
        // line 109
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "agencia", array()), "nombre", array()), "html", null, true);
        echo "\">
                                    <input type=\"hidden\"
                                           name=\"sen_logo\"
                                           id=\"detail-sen-logo\"
                                           value=\"camcar.png\">
                                    <input type=\"hidden\"
                                           name=\"sen_agn_logo\"
                                           id=\"detail-sen-agn-logo\"
                                           value=\"";
        // line 117
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "agencia", array()), "logo", array()), "html", null, true);
        echo "\">
                                    <input type=\"hidden\"
                                           name=\"sen_mar\"
                                           id=\"detail-sen-mar\"
                                           value=\"";
        // line 121
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "marca", array()), "nombre", array()), "html", null, true);
        echo "\">
                                    <input type=\"hidden\"
                                           name=\"sen_mdo\"
                                           id=\"detail-sen-mdo\"
                                           value=\"";
        // line 125
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "modelo", array()), "nombre", array()), "html", null, true);
        echo "\">
                                    <input type=\"hidden\"
                                           name=\"sen_year\"
                                           id=\"detail-sen-year\"
                                           value=\"";
        // line 129
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "anio", array()), "html", null, true);
        echo "\">
                                    <input type=\"hidden\"
                                           name=\"sen_pic\"
                                           id=\"detail-sen-pic\"
                                           value=\"";
        // line 133
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "thm_folder", array()), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["detalle"]) ? $context["detalle"] : null), "thm_nombre", array()), "html", null, true);
        echo "\">   
                                </div>

                            </form>
                            <div id=\"loader-by-model\"></div>
                            <div class=\"linkContainer ctaContainer text-right\">
                                <input type=\"submit\"
                                       class=\"submit_contact\"
                                       id=\"detail-sen-send\"
                                       value=\"Enviar\"
                                       style=\"font-size: 1.3em;\"
                                       disabled=\"disabled\">
                            </div>

                        ";
    }

    // line 150
    public function block_contacto_mensajes($context, array $blocks = array())
    {
        // line 151
        echo "                        <div class=\"form-thanks clearfix\" style=\"display: none;\">
                            <p class=\"agradecimiento_titulo\">
                                Mensaje enviado
                            </p>
                            <hr>
                            <p class=\"agradecimiento_titulo2\">
                                En breve responderemos tu mensaje al siguiente correo:
                                <br>
                                <span id=\"email-from\">-</span>
                            </p>
                        </div>
                        <div class=\"form-error clearfix\" style=\"display: none;\">
                            <p class=\"agradecimiento_titulo\">
                                Hubo un error
                            </p>
                            <hr>
                            <p class=\"agradecimiento_titulo2\">
                                Intentalo nuevamente
                            </p>
                        </div>
                        <div class=\"form-loader clearfix\" style=\"display: none;\">
                            <div class=\"loader\">
                                <div class=\"loader-wrap\">
                                    <div class=\"loader-item\"></div>
                                </div>
                            </div>
                        </div>
                    ";
    }

    public function getTemplateName()
    {
        return "seminuevos/detalles/contacto.twig";
    }

    public function getDebugInfo()
    {
        return array (  221 => 151,  218 => 150,  197 => 133,  190 => 129,  183 => 125,  176 => 121,  169 => 117,  158 => 109,  151 => 105,  57 => 14,  53 => 12,  50 => 11,  41 => 179,  39 => 150,  35 => 148,  33 => 11,  21 => 1,);
    }
}
/* <div class="col-md-4">*/
/*     <div id="content_form_contact_by_model">*/
/*         <div class="sidebar-widget widget no-print">*/
/*             <div class="vehicle-enquiry-foot pull-left contact_main" */
/*                  style="width: 100%;">*/
/*                 <h6 class="widgettitle no-print">*/
/*                     CONTACTO*/
/*                 </h6>*/
/*                 <div class="vehicle-enquiry-in contact_content clearfix">*/
/*                     <div id="form-wrapper">*/
/*                         {% block contacto_form %}*/
/*                             <form class="email-form-sen-premium-by-model"*/
/*                                   id="detail-sen-contact"*/
/*                                   data-sen-id="{{ detalle.id }}">*/
/*                                 <div class="contact_elements">*/
/*                                     <div class="contact_element ab">*/
/*                                         <fieldset>*/
/*                                             <input type="text"*/
/*                                                    name="sen_name"*/
/*                                                    id="detail-sen-name"*/
/*                                                    placeholder="Nombre"*/
/*                                                    class="detail-sen-element input-standard validate-required no-print"*/
/*                                                    style="font-size: 1.3em;"*/
/*                                                    data-validation-data="required|name">*/
/*                                             <p class="invalid-message" id="error_nombre">*/
/*                                                  Este campo es obligatorio*/
/*                                                 <span>&nbsp;</span>*/
/*                                             </p>*/
/*                                         </fieldset>*/
/*                                     </div>*/
/*                                 </div>*/
/*                                 <div class="contact_elements">*/
/*                                     <div class="contact_element ab">*/
/*                                         <fieldset>*/
/*                                             <input type="text"*/
/*                                                    name="sen_lastname"*/
/*                                                    id="detail-sen-lastname"*/
/*                                                    placeholder="Apellido"*/
/*                                                    class="detail-sen-element input-standard validate-required no-print"*/
/*                                                    style="font-size: 1.3em;"*/
/*                                                    data-validation-data="required|lastname">*/
/*                                             <p class="invalid-message" id="error_apellido">*/
/*                                                  Este campo es obligatorio*/
/*                                                 <span>&nbsp;</span>*/
/*                                             </p>*/
/*                                         </fieldset>*/
/*                                     </div>*/
/*                                 </div>*/
/*                                 <div class="contact_elements">*/
/*                                     <div class="contact_element ab">*/
/*                                         <fieldset>*/
/*                                             <input type="email" */
/*                                                    name="sen_email"*/
/*                                                    id="detail-sen-email"*/
/*                                                    placeholder="Email"*/
/*                                                    class="detail-sen-element input-standard validate-required validate-email no-print"*/
/*                                                    style="font-size: 1.3em;"*/
/*                                                    data-validation-data="required|email">*/
/*                                             <p class="invalid-message" id="error_correo">*/
/*                                                 Este campo es obligatorio*/
/*                                                 <span>&nbsp;</span>*/
/*                                             </p>*/
/*                                         </fieldset>*/
/*                                     </div>*/
/*                                 </div>*/
/*                                 <div class="contact_elements">*/
/*                                     <div class="contact_element ab">*/
/*                                         <fieldset>*/
/*                                             <input type="text"*/
/*                                                    name="sen_phone"*/
/*                                                    id="detail-sen-phone"*/
/*                                                    placeholder="Telefono"*/
/*                                                    maxlength="13"*/
/*                                                    class="detail-sen-element input-standard validate-required no-print"*/
/*                                                    style="font-size: 1.3em;"*/
/*                                                    data-validation-data="required|phone">*/
/*                                             <p class="invalid-message" id="error_phone">*/
/*                                                 Este campo es obligatorio*/
/*                                                 <span>&nbsp;</span>*/
/*                                             </p>*/
/*                                         </fieldset>*/
/*                                     </div>*/
/*                                 </div>*/
/*                                 <div class="contact_elements">*/
/*                                     <div class="contact_element ab">*/
/*                                         <fieldset>*/
/*                                             <textarea name="sen_message" */
/*                                                  id="detail-sen-message" */
/*                                                  class="detail-sen-element input-standard validate-required no-print" */
/*                                                  placeholder="Comentario" */
/*                                                  style="font-size: 1.3em;" */
/*                                                  data-validation-data="required|address"></textarea>*/
/*                                             <p class="invalid-message" id="error_mensaje">*/
/*                                                 Este campo es obligatorio*/
/*                                                 <span>&nbsp;</span>*/
/*                                             </p>*/
/*                                         </fieldset>*/
/*                                     </div>*/
/*                                 </div>*/
/* */
/*                                 <div class="row">*/
/*                                     <input type="hidden"*/
/*                                            name="sen_email_send"*/
/*                                            id="detail-sen-email-send"*/
/*                                            value="{{ detalle.agencia.correo }}">*/
/*                                     <input type="hidden"*/
/*                                            name="sen_concessionary"*/
/*                                            id="detail-sen-concessionary"*/
/*                                            value="CAMCAR - {{ detalle.agencia.nombre }}">*/
/*                                     <input type="hidden"*/
/*                                            name="sen_logo"*/
/*                                            id="detail-sen-logo"*/
/*                                            value="camcar.png">*/
/*                                     <input type="hidden"*/
/*                                            name="sen_agn_logo"*/
/*                                            id="detail-sen-agn-logo"*/
/*                                            value="{{ detalle.agencia.logo }}">*/
/*                                     <input type="hidden"*/
/*                                            name="sen_mar"*/
/*                                            id="detail-sen-mar"*/
/*                                            value="{{ detalle.marca.nombre }}">*/
/*                                     <input type="hidden"*/
/*                                            name="sen_mdo"*/
/*                                            id="detail-sen-mdo"*/
/*                                            value="{{ detalle.modelo.nombre }}">*/
/*                                     <input type="hidden"*/
/*                                            name="sen_year"*/
/*                                            id="detail-sen-year"*/
/*                                            value="{{ detalle.anio }}">*/
/*                                     <input type="hidden"*/
/*                                            name="sen_pic"*/
/*                                            id="detail-sen-pic"*/
/*                                            value="{{ detalle.thm_folder }}/{{ detalle.thm_nombre }}">   */
/*                                 </div>*/
/* */
/*                             </form>*/
/*                             <div id="loader-by-model"></div>*/
/*                             <div class="linkContainer ctaContainer text-right">*/
/*                                 <input type="submit"*/
/*                                        class="submit_contact"*/
/*                                        id="detail-sen-send"*/
/*                                        value="Enviar"*/
/*                                        style="font-size: 1.3em;"*/
/*                                        disabled="disabled">*/
/*                             </div>*/
/* */
/*                         {% endblock %}*/
/* */
/*                     </div>*/
/*                     {% block contacto_mensajes %}*/
/*                         <div class="form-thanks clearfix" style="display: none;">*/
/*                             <p class="agradecimiento_titulo">*/
/*                                 Mensaje enviado*/
/*                             </p>*/
/*                             <hr>*/
/*                             <p class="agradecimiento_titulo2">*/
/*                                 En breve responderemos tu mensaje al siguiente correo:*/
/*                                 <br>*/
/*                                 <span id="email-from">-</span>*/
/*                             </p>*/
/*                         </div>*/
/*                         <div class="form-error clearfix" style="display: none;">*/
/*                             <p class="agradecimiento_titulo">*/
/*                                 Hubo un error*/
/*                             </p>*/
/*                             <hr>*/
/*                             <p class="agradecimiento_titulo2">*/
/*                                 Intentalo nuevamente*/
/*                             </p>*/
/*                         </div>*/
/*                         <div class="form-loader clearfix" style="display: none;">*/
/*                             <div class="loader">*/
/*                                 <div class="loader-wrap">*/
/*                                     <div class="loader-item"></div>*/
/*                                 </div>*/
/*                             </div>*/
/*                         </div>*/
/*                     {% endblock %}*/
/*                 </div>*/
/*             </div>*/
/*         </div>*/
/*     </div>*/
/* </div>*/
/* */

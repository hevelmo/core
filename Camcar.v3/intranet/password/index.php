<?php
include '../../incorporate/db_connect.php';
include '../../incorporate/functions.php';
sec_session_start();

if(login_check() == true) {
    header('Location: ../welcome');
} else {
    $iur = (isset($_GET['iur'])) ? $_GET['iur'] : '';
    $iur = trim($iur);
    $email = (isset($_GET['m'])) ? $_GET['m'] : '';
    $email = trim($email);
    $name = (isset($_GET['nc'])) ? $_GET['nc'] : '';
    $name = trim($name);
    if($iur === '' || $email === '' || $name === '') {
        header('Location: ../login');
    } else {
        if(!validatePassUrl($iur, $email)) {
            header('Location: ../login');
        }
    }
}
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="en" class="no-js css-menubar lt-ie10 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="en" class="no-js css-menubar lt-ie10 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="en" class="no-js css-menubar lt-ie10 lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html lang="en" class="no-js css-menubar lt-ie10"> <![endif]-->
<html class="no-js css-menubar" lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv='cache-control' content='no-cache' />
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
        <meta name='viewport' content='width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0' />

        <title>CAMCAR Establecer Contraseña</title>

        <link rel="stylesheet" href="../../css/import-login.css">

        <link rel="apple-touch-icon" href="../../img/ico/apple-touch-icon.png">
        <link rel="shortcut icon" href="../../img/ico/camcaricon.ico">

        <!--[if lt IE 9]>
            <script src="../../lib/plugins/html5shiv/html5shiv.min.js"></script>
        <![endif]-->
        <!--[if lt IE 10]>
            <script src="../../lib/plugins/media-match/media.match.min.js"></script>
            <script src="../../lib/plugins/respond/respond.min.js"></script>
        <![endif]-->
        <script>
            var nav = navigator.appName;

            if(nav == "Microsoft Internet Explorer") {
                //Detectamos si nos visitan desde IE
                if(nav == "Microsoft Internet Explorer") {
                    //Convertimos en minusculas la cadena que devuelve userAgent
                    var ie = navigator.userAgent.toLowerCase();
                    //Extraemos de la cadena la version de IE
                    var version = parseInt(ie.split('msie')[1]);

                    //Dependiendo de la version mostramos un resultado
                    switch(version) {
                        case 6:
                            alert("La intranet no es compatible con Internet Explorer, te recomendamos usar Chrome o Firefox.");
                            break;
                        case 7:
                            alert("La intranet no es compatible con Internet Explorer, te recomendamos usar Chrome o Firefox.");
                            break;
                        case 8:
                            alert("La intranet no es compatible con Internet Explorer, te recomendamos usar Chrome o Firefox.");
                            break;
                        /*
                        case 9:
                            alert("La intranet no es compatible con Internet Explorer, te recomendamos usar Chrome o Firefox.");
                            //console.log("Estas usando IE 9, mas o menos compatible");
                            break;
                        */
                        default:
                            //console.log("Usas una version compatible");
                            break;
                    }
                }
            }
        </script>
        <script src="../../lib/modernizr.js"></script>
        <script src="../../lib/assets/plugins/breakpoints/breakpoints.js"></script>
        <script>
            Breakpoints();
        </script>
    </head>
    <body class="page-login-v3 layout-full">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <!-- Page -->
        <div class="page animsition vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
            <div class="page-content vertical-align-middle">
                <div class="panel panel-shadow">
                    <div class="panel-body">
                        <img class="brand-img brand-img-resp brand-img-login-v3" src="../../img/logos/logo-camcar-hor-black@2x.png" alt="Camcar Grupo Automotriz, ve por más...">
                        <div class="welcome">
                            <strong style="font-size: 18px;">Bienvenido</strong>
                            <p class="pt-5 pb-0 m-0">
                                <b><i><?php echo htmlentities($name);?></i></b>
                            </p>
                            <p class="pt-5 pb-0 m-0">Ingresa la que será tu contraseña</p>
                        </div>
                        <form onsubmit="$.submit_password_form(); return false;" id="form-process-password" class="mt-10 mb-10 strength_password">
                        <?php /* ?>
                        <form method="post" action="process_password.php" id="form-process-password" class="mt-10 mb-10 strength_password">
                        <?php */ ?>
                            <div class="form-group">
                                <fieldset>
                                    <label class="sr-only" for="inputPassword">Contraseña Nueva</label>
                                    <input type="password" 
                                        class="form-control camcar-remark-input strength_password_pass input-password validate-required validate-input" 
                                        id="inputPassword" 
                                        name="password" 
                                        placeholder="Contraseña Nueva"
                                        data-validation-data="required">
                                    <p class="invalid-message" id="error_password">Este campo es obligatorio<span>&nbsp;</span></p>
                                    <!-- Password Info -->
                                    <div id="pswd_info" style="display: none;" class="">
                                        <div class="content_pswd_info">
                                            <div class="arrow_box pswd_info_requirements">
                                                <h4>La contraseña debería cumplir con los siguientes requerimientos:</h4>
                                                <ul>
                                                    <li id="letter">Al menos debería tener <strong>una letra</strong></li>
                                                    <li id="capital">Al menos debería tener <strong>una letra en mayúsculas</strong></li>
                                                    <li id="number">Al menos debería tener <strong>un número</strong></li>
                                                    <?php /* <!--<li id="length">Debería tener <strong>8 carácteres</strong> como mínimo</li>--> */ ?>
                                                </ul>
                                                <h4>Caracteres especiales permitidos:</h4>
                                                <ul>
                                                    <li>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Signos de exclamacion, signo de admiracion" data-placement="top">!</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Comillas dobles" data-placement="top">"</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Signo numeral o hastag" data-placement="top">#</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Signo pesos" data-placement="top">$</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Signo de porcentaje" data-placement="top">%</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="ampersand" data-placement="top">&amp;</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Comillas simples, apóstrofe" data-placement="top">'</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Abre paréntesis" data-placement="top">(</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Cierra paréntesis" data-placement="top">)</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Asterisco" data-placement="top">*</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Signo mas, suma, positivo" data-placement="top">+</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Coma" data-placement="top">,</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Signo menos , guión medio" data-placement="top">-</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Punto" data-placement="top">.</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Barra inclinada, operador cociente" data-placement="top">/</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Dos puntos" data-placement="top">:</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Punto y coma" data-placement="top">;</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Menor que" data-placement="top">&lt;</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Signo igual" data-placement="top">=</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Mayor que" data-placement="top">&gt;</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Cierra signo interrogación" data-placement="top">?</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Arroba" data-placement="top">@</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Abre corchetes" data-placement="top">[</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Barra invertida , contrabarra , barra inversa" data-placement="top">\</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Cierra corchetes" data-placement="top">]</i>
                                                        </strong>
                                                        <strong>
                                                            <i class="fa fa-fw fa-lg cur-hover" data-toggle="tooltip" data-original-title="Guión bajo , subrayado , subguión" data-placement="top">_</i>
                                                        </strong>
                                                    </li>
                                                </ul>
                                                <hr>
                                                <p>
                                                    Las contraseñas seguras contienen de 8 a 16 caracteres, no incluyas palabras o nombres comunes, y puedes combinar letras mayúsculas, minúsculas, números y símbolos.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Password Info -->
                                </fieldset>
                            </div>
                            <div class="form-group">
                                <fieldset class="mb-0">
                                    <label class="sr-only" for="inputPasswordNewConfirm">Confirmar Contraseña</label>
                                    <input type="password" 
                                        class="form-control camcar-remark-input input-password validate-required validate-password-confirm validate-input" 
                                        id="inputPasswordNewConfirm" 
                                        name="password_confirm" 
                                        placeholder="Confirmar Contraseña"
                                        data-validation-data="required">
                                    <p class="invalid-message" id="error_password">Este campo es obligatorio<span>&nbsp;</span></p>
                                </fieldset>
                            </div>
                            <input type="hidden" id="email" name="email" value="<?php echo htmlentities($email);?>">
                            <input type="hidden" id="cryptId" name="crypt_id" value="<?php echo htmlentities($iur);?>">
                            <input type="hidden" id="name" name="name" value="<?php echo htmlentities($name);?>">

                            <div class="loader_send">
                                <button type="submit" class="form__submit button button-outline bg-red-camcar white-camcar button-resp col-sm-6 col-md-12 enviar button blue" style="padding: 1em; margin: 0 auto;">
                                    <i class="fa fa-user fa-lg fa-fw"></i> Aceptar
                                </button>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <footer class="page-copyright recovery">
                <p>© 2016. CAMCAR GRUPO AUTOMOTRIZ.</p>
            </footer>
        </div>
        <!-- End Page -->

        <!-- MAIN -->
        <script src="../../lib/jquery.js"></script>
        <script src="../../lib/bootstrap.js"></script>

        <!-- CORE -->
        <script src="../../lib/jquery.gdb.js"></script>
        <script src="../../lib/jquery-ui.js"></script>
        <script src="../../lib/underscore.js"></script>
        <script src="../../lib/moment.js"></script>
        <script src="../../lib/accounting.js"></script>
        <script src="../../lib/finch.js"></script>

        <!-- HANDLEBARS -->
        <script src="../../lib/handlebars.runtime.js"></script>

        <!-- FORMS -->
        <script src="../../lib/forms.js"></script>
        <script src="../../lib/sha512.js"></script>

        <!-- SWEETALERT -->
        <script src="../../lib/assets/sweetalert/sweetalert-dev.js"></script>

        <!-- PASSWORD STRENGTH -->
        <?php /* ?>
        <script src="../../lib/assets/strength/strength.js"></script>
        <?php */ ?>

        <!-- PLUGINS -->
        <script src="../../lib/assets/plugins/animsition/jquery.animsition.js"></script>
        <script src="../../lib/assets/plugins/asscroll/jquery-asScroll.js"></script>
        <script src="../../lib/assets/plugins/mousewheel/jquery.mousewheel.js"></script>
        <script src="../../lib/assets/plugins/asscrollable/jquery.asScrollable.all.js"></script>
        <script src="../../lib/assets/plugins/ashoverscroll/jquery-asHoverScroll.js"></script>

        <script src="../../lib/assets/plugins/switchery/switchery.js"></script>
        <script src="../../lib/assets/plugins/intro-js/intro.js"></script>
        <script src="../../lib/assets/plugins/screenfull/screenfull.js"></script>
        <script src="../../lib/assets/plugins/slidepanel/jquery-slidePanel.js"></script>

        <!--Plugins For This Page Login -->
        <script src="../../lib/assets/plugins/jquery-placeholder/jquery.placeholder.js"></script>

        <!--SCRIPTS -->
        <script src="../../lib/assets/run/core.js"></script>
        <script src="../../lib/assets/run/site.js"></script>

        <script src="../../lib/assets/run/sections/menu.js"></script>
        <script src="../../lib/assets/run/sections/menubar.js"></script>
        <script src="../../lib/assets/run/sections/gridmenu.js"></script>
        <script src="../../lib/assets/run/sections/sidebar.js"></script>

        <script src="../../lib/assets/run/configs/config-colors.js"></script>
        <script src="../../lib/assets/run/configs/config-tour.js"></script>

        <script src="../../lib/assets/run/components/asscrollable.js"></script>
        <script src="../../lib/assets/run/components/animsition.js"></script>
        <script src="../../lib/assets/run/components/slidepanel.js"></script>
        <script src="../../lib/assets/run/components/switchery.js"></script>

        <!--Scripts For This Page Login -->
        <script src="../../lib/assets/run/components/jquery-placeholder.js"></script>

        <?php /* ?>
        <!-- TEMPLATES -->
        <script src='templates/min/templates.min.js'></script>
        <?php */ ?>

        <script>
            (function(document, window, $) {
              'use strict';

              var Site = window.Site;
              $(document).ready(function() {
                Site.run();
              });
            })(document, window, jQuery);
        </script>

        <!-- CORE JS -->
        <?php /* ?>
        <script src='../js/min/model.min.js'></script>
        <script src='../js/min/required.min.js'></script>
        <?php */ ?>
        <script src='js/min/core.min.js'></script>
        <?php /* ?>
        <script src='../js/model.js'></script>
        <script src='../js/required.js'></script>
        <script src='js/room.js'></script>
        <script src='js/method.js'></script>
        <script src='js/main.js'></script>
        <?php */ ?>

    </body>
</html>

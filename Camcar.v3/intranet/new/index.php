<?php

/*
include '../../incorporate/db_connect.php';
include '../../incorporate/functions.php';
sec_session_start();
if(login_check() == true) {
    header('Location: ../welcome');
}
*/
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

        <title>CAMCAR Nuevo Usuario</title>

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

            if(nav == "Microsoft Internet Explorer"){
                //Detectamos si nos visitan desde IE
                if(nav == "Microsoft Internet Explorer"){
                    //Convertimos en minusculas la cadena que devuelve userAgent
                    var ie = navigator.userAgent.toLowerCase();
                    //Extraemos de la cadena la version de IE
                    var version = parseInt(ie.split('msie')[1]);

                    //Dependiendo de la version mostramos un resultado
                    switch(version){
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
        <!-- Begin activate user -->
        <div id="carbonads-container">
            <div class="carbonad">
                <div id="carbonads">
                    <span>
                        <span class="carbon-wrap pb-10">
                            <strong class="carbon-wrap-title">¿Cómo acceder por primera vez?</strong>
                        </span>
                        <div class="clearfix"></div>
                        <span class="carbon-wrap-body">
                            <div>
                                <span class="details-activate-user">
                                    <div class="block-detail ptb-10 plr-10">
                                        <div class="ico-number">
                                            <num class="icon-number-one">
                                                <i class="sprite-numbers sprite-numbers-number_01"></i>
                                            </num>
                                        </div>
                                        <div class="carbon-description">
                                            Ingresa tu correo de la empresa y da click enviar.
                                        </div>
                                    </div>
                                    <div class="block-detail ptb-10 plr-10">
                                        <div class="ico-number">
                                            <num class="icon-number-two">
                                                <i class="sprite-numbers sprite-numbers-number_02"></i>
                                            </num>
                                        </div>
                                        <div class="carbon-description">
                                            Te llegará una notificación a tu correo con un enlace para ingresar tu contraseña de acceso.
                                        </div>
                                    </div>
                                    <div class="block-detail ptb-10 plr-10">
                                        <div class="ico-number">
                                            <num class="icon-number-three">
                                                <i class="sprite-numbers sprite-numbers-number_03"></i>
                                            </num>
                                        </div>
                                        <div class="carbon-description">
                                            Da click al enlace e ingresa tu nueva contraseña.
                                        </div>
                                    </div>
                                </span>
                            </div>
                        </span>
                    </span>
                </div>
            </div>
        </div>
        <!-- Page -->
        <div class="page animsition vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
            <div class="page-content vertical-align-middle">
                <div class="panel panel-shadow">
                    <div class="panel-body">
                        <img class="brand-img brand-img-resp brand-img-login-v3" src="../../img/logos/logo-camcar-hor-black@2x.png" alt="Camcar Grupo Automotriz, ve por más...">
                        <form onsubmit="$.submit_new_form(); return false;" id="process_recovery" class="recovery-form mtb-15">
                        <!--<form method="post" action="process_new.php" id="process_new" class="new-form mtb-15">-->
                            <div class="form-group">
                                <fieldset>
                                    <label class="sr-only" for="inputEmail">Correo Electrónico</label>
                                    <input type="email" 
                                        class="form-control camcar-remark-input input-new validate-required validate-email" 
                                        id="inputEmail" 
                                        name="email" 
                                        placeholder="Usuario"
                                        data-validation-data="required|email">
                                    <p class="invalid-message" id="error_correo">Este campo es obligatorio<span>&nbsp;</span></p>
                                </fieldset>
                            </div>
                            <div class="loader_send">
                                <button type="submit" class="form__submit button button-outline bg-red-camcar white-camcar button-resp col-sm-6 col-md-12 enviar button blue" style="padding: 1em; margin: 0 auto;">
                                    <i class="fa fa-user fa-lg fa-fw"></i> Enviar
                                </button>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                        <p class="ptb-15">
                            <a class="form__link font-color-camcar" href="../login/">
                                <i class="fa fa-chevron-left"></i> Regresar
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <footer class="page-copyright new">
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
        <?php /* ?>
        <script src="../../lib/forms.js"></script>
        <?php */ ?>
        <script src="../../lib/sha512.js"></script>
        <!-- SWEETALERT -->
        <script src="../../lib/assets/sweetalert/sweetalert-dev.js"></script>

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

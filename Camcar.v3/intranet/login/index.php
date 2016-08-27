<?php

include '../../incorporate/db_connect.php';
include '../../incorporate/functions.php';

sec_session_start();

if(login_check() == true) {
    header('Location: ../welcome');
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

        <title>CAMCAR Ingresar</title>

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
        <!-- Begin activate user -->
        <div id="carbonads-container" class="carbon">
            <div class="carbonad">
                <div id="carbonads">
                    <span>
                        <span class="carbon-wrap pb-10">
                            <strong class="carbon-wrap-title mobile">Para utilizar la intranet es necesario usar Google Chrome, descargalo aquí!!!</strong>
                        </span>
                        <div class="clearfix"></div>
                        <span class="carbon-wrap-body">
                            <div>
                                <span class="details-activate-user clearfix">
                                    <!--<div class="block-detail col-xs-6 col-sm-6 col-md-6">-->
                                    <div id="download-desktop" style="display: none;">
                                        <div class="block-detail">
                                            <!--<div class="ico-number" style="margin: 0 auto !important; width: 100%;">
                                                <num class="icon-number-one">
                                                    <img src="../../img/log_browser.png" alt="Download Bowser" width="100" style="margin: 0 auto; display: block;">
                                                </num>
                                            </div>-->
                                            <div class="carbon-description mobile" style="width: 100% !important; text-align: center;">
                                                <a href="https://www.google.com.mx/chrome/browser/desktop/index.html" class="button button-outline bg-blue button-resp col-xs-12 col-sm-12 col-md-12" style="line-height: 17px;">
                                                    Descargar para Computadora
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="block-detail col-xs-6 col-sm-6 col-md-6">-->
                                    <div id="download-mobile" style="display: none;">
                                        <div class="block-detail">
                                            <!--<div class="ico-number">
                                                <num class="icon-number-one">
                                                    <img src="../../img/log_mobile.png" alt="Download Mobile" width="100">
                                                </num>
                                            </div>-->
                                            <div class="carbon-description mobile" style="width: 100% !important; text-align: center;">
                                                <a href="https://www.google.com.mx/chrome/browser/mobile/index.html" class="button button-outline bg-blue button-resp col-xs-12 col-sm-12 col-md-12" style="line-height: 17px;">
                                                    Descargar para dispositivo movil
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </span>
                            </div>
                        </span>
                    </span>
                </div>
            </div>
        </div>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <!-- Page -->
        <div class="page animsition vertical-align text-center mobile" data-animsition-in="fade-in" data-animsition-out="fade-out">
            <div class="page-content vertical-align-middle">
                <div class="panel panel-shadow">
                    <div class="panel-body">
                        <img class="brand-img brand-img-resp brand-img-login-v3" src="../../img/logos/logo-camcar-hor-black@2x.png" alt="Camcar Grupo Automotriz, ve por más...">
                        <form method="post" action="process_login.php" id="process_login" class="login-form">
                            <div class="form-group">
                                <fieldset>
                                    <label class="sr-only" for="inputEmail">Usuario</label>
                                    <input type="email" 
                                        class="form-control camcar-remark-input input-sign-in validate-required validate-email" 
                                        id="inputEmail" 
                                        name="email" 
                                        placeholder="Usuario"
                                        data-validation-data="required|email">
                                    <p class="invalid-message" id="error_correo">Este campo es obligatorio<span>&nbsp;</span></p>
                                </fieldset>
                            </div>
                            <div class="form-group">
                                <fieldset>
                                    <label class="sr-only" for="inputPassword">Contraseña</label>
                                    <input type="password" 
                                        class="form-control camcar-remark-input input-sign-in validate-required validate-input" 
                                        id="inputPassword" 
                                        name="password" 
                                        placeholder="Contraseña"
                                        data-validation-data="required">
                                    <p class="invalid-message" id="error_general">Este campo es obligatorio<span>&nbsp;</span></p>
                                </fieldset>
                            </div>
                            <button type="button" id="goF" 
                                class="form__submit button button-outline bg-red-camcar white-camcar button-resp col-sm-6 col-md-12" 
                                style="padding: 1em; margin: 0 auto;" 
                                onclick="formhash(this.form, this.form.password);">
                                <i class="fa fa-user fa-lg fa-fw"></i> Ingresar
                            </button>
                        </form>
                        <?php /* ?>
                        <form onsubmit="$.submit_new_form(); return false;" id="process_login" class="login-form">
                        <!--<form method="post" action="process_login.php" id="process_login" class="login-form">-->
                            <div class="form-group">
                                <fieldset>
                                    <label class="sr-only" for="inputEmail">Usuario</label>
                                    <input type="email" 
                                        class="form-control camcar-remark-input input-sign-in validate-required validate-email" 
                                        id="inputEmail" 
                                        name="email" 
                                        placeholder="Usuario"
                                        data-validation-data="required|email">
                                    <p class="invalid-message" id="error_correo">Este campo es obligatorio<span>&nbsp;</span></p>
                                </fieldset>
                            </div>
                            <div class="form-group">
                                <fieldset>
                                    <label class="sr-only" for="inputPassword">Contraseña</label>
                                    <input type="password" 
                                        class="form-control camcar-remark-input input-sign-in validate-required validate-input" 
                                        id="inputPassword" 
                                        name="password" 
                                        placeholder="Contraseña"
                                        data-validation-data="required">
                                    <p class="invalid-message" id="error_general">Este campo es obligatorio<span>&nbsp;</span></p>
                                </fieldset>
                            </div>
                            <div class="loader_send">
                                <button type="submit" class="form__submit button button-outline bg-red-camcar white-camcar button-resp col-sm-6 col-md-12 enviar button blue" style="padding: 1em; margin: 0 auto;">
                                    <i class="fa fa-user fa-lg fa-fw"></i> Ingresar
                                </button>
                            </div>
                        </form>
                        <?php */ ?>
                        <div class="clearfix"></div>
                        <a id="go-new-user" href="../new/" class="form__submit button button-outline bg-green-success-camcar white-camcar button-resp col-sm-6 col-md-12" style="padding: 1em; margin: 0 auto;">
                            <i class="fa fa-user fa-lg fa-fw"></i> Usuario nuevo
                        </a>
                        <div class="clearfix"></div>
                        <p class="ptb-15">
                            <a class="form__link font-color-camcar" href="../../sitio">
                                <i class="fa fa-chevron-left"></i> Regresar
                            </a>
                        </p>
                        <p><a href="../recovery/" class="font-color-camcar">¿Olvidaste tu contraseña?</a></p>
                    </div>
                </div>
            </div>
            <footer class="page-copyright login">
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
        <?php /* ?>
        <script src="../../lib/assets/sweetalert/sweetalert-dev.js"></script>
        <?php */ ?>
        <?php /* ?>
        <script src="../../lib/forms.js"></script>
        <script src="../../lib/sha512.js"></script>
        <!-- SWEETALERT -->
        <script src="../../lib/assets/sweetalert/sweetalert-dev.js"></script>
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

        <!-- TEMPLATES -->
        <?php /* ?>
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

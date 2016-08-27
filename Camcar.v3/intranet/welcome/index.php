<?php
/*
 * Copyright (C) 2015 CAMCAR Intranet
 * Version: v2.0
*/

include_once '../../incorporate/db_connect.php';
include_once '../../incorporate/functions.php';

sec_session_start();

if(login_check() != true) {
    header('Location: ../login');
} else {
    //header('Location: ../admin');
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

        <title id="head-change-section-title">CAMCAR</title>

        <link rel="stylesheet" href="../../css/import-intranet.css">

        <link rel="apple-touch-icon" href="../../img/ico/apple-touch-icon.png">
        <link rel="shortcut icon" href="../../img/ico/camcaricon.ico">

        <!--[if lt IE 9]>
            <script src="../../lib/assets/plugins/html5shiv/html5shiv.min.js"></script>
        <![endif]-->
        <!--[if lt IE 10]>
            <script src="../../lib/assets/plugins/media-match/media.match.min.js"></script>
            <script src="../../lib/assets/plugins/respond/respond.min.js"></script>
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
                            console.log("Estas usando IE 9, mas o menos compatible");
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
    </head>
    <body class="site-navbar-small dashboard">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <!-- SCREEN SIZE <span id="screen" style="overflow: hidden;opacity: 0;left: -999999%;"></span>-->

        <!-- Sub Body 1 -->
        <div id="sub-body-one">
            <!-- Auxiliar Temporal Inputs's DIV -->
            <div id='hidden-inputs-session'>
                <?php /* ?>
                <input type='hidden' id='session-usr-username' value="<?php echo htmlentities($_SESSION['username']); ?>">
                <?php */ ?>
                <input type='hidden' id='session-usr-id' value="<?php echo htmlentities($_SESSION['user_id']); ?>">
                <input type='hidden' id='session-usr-no-employee' value="<?php echo htmlentities($_SESSION['usr_no_empleado']); ?>">
                <input type='hidden' id='session-usr-type' value="<?php echo htmlentities($_SESSION['usr_type']); ?>">
                <input type='hidden' id='session-usr-fullname' value="<?php echo htmlentities($_SESSION['usr_nombre_completo']); ?>">
                <input type='hidden' id='session-usr-email' value="<?php echo htmlentities($_SESSION['email']); ?>">
                <input type='hidden' id='session-usr-agn-id' value="<?php echo htmlentities($_SESSION['usr_agn_id']); ?>">
                <input type='hidden' id='session-usr-agn-name' value="<?php echo htmlentities($_SESSION['usr_agn_nombre']); ?>">
                <input type='hidden' id='session-usr-agn-logo1' value="<?php echo htmlentities($_SESSION['usr_agn_logo1']); ?>">
                <input type='hidden' id='session-usr-agn-logo2' value="<?php echo htmlentities($_SESSION['usr_agn_logo2']); ?>">
                <input type='hidden' id='session-usr-agn-header' value="<?php echo htmlentities($_SESSION['usr_agn_header']); ?>">
            </div>
            <!-- Auxiliar Temporal Inputs's DIV -->
            <div id='hidden-inputs-temporal'></div>

            <!-- NAVIGATION -->
            <!--Templates's NAV-->
            <nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" rol="navigation" id='content-site-navbar-interactive'></nav>
            <div class="site-menubar" id='content-site-menubar-interactive'></div>

            <!-- Page -->
            <!--Templates's DIV-->
            <div class="wrapper_content_interactive page" id='content-temporal-interactive'></div>
            <!-- End Page -->

            <!-- Footer -->
            <footer class="site-footer site-footer-fixed">
                <span class="site-footer-legal">© 2016 Camcar v2</span>
            </footer>
        </div>
        <!-- End Sub Body 1 -->

        <div id="content-site-action" class="site-action"></div>

        <!-- End Sub Body 2 -->
        <div id="sub-body-two">
            <div id="content-slide-panel"></div>
        </div>
        <!-- End Sub Body 2 -->

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

        <!-- PLUGINS -->
        <script src="../../lib/assets/plugins/animsition/jquery.animsition.js"></script>
        <script src="../../lib/assets/plugins/asscroll/jquery-asScroll.js"></script>
        <script src="../../lib/assets/plugins/mousewheel/jquery.mousewheel.js"></script>
        <script src="../../lib/assets/plugins/asscrollable/jquery.asScrollable.all.js"></script>
        <script src="../../lib/assets/plugins/ashoverscroll/jquery-asHoverScroll.js"></script>
        <script src="../../lib/assets/plugins/switchery/switchery.min.js"></script>
        <script src="../../lib/assets/plugins/intro-js/intro.js"></script>
        <script src="../../lib/assets/plugins/screenfull/screenfull.js"></script>
        <script src="../../lib/assets/plugins/slidepanel/jquery-slidePanel.js"></script>
        <script src="../../lib/assets/plugins/waves/waves.js"></script>
        <script src="../../lib/site/matchMedia.js"></script>

        <!-- Plugins For This Page -->
        <div id="plugins-for-this-section"></div>

        <!-- Scripts -->
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
        <script src="../../lib/assets/jquery.bxslider.js"></script>
        <script src="../../lib/assets/modal-responsive.js"></script>
        <script src="../../lib/site/matchMedia.js"></script>
        <script src="../../lib/site/jquery.scrollTo.js"></script>
        <script src="../../lib/site/jquery.easing.1.3.js"></script>        

        <!-- Scripts For This Page -->
        <div id="scripts-for-this-section"></div>

        <!-- TEMPLATES -->
        <script src='../templates/min/templates.min.js'></script>

        <!-- CORE JS -->
        <script src='../js/min/core.min.js'></script>
        <?php /* ?>
        <script src='../js/objects.js'></script>
        <script src='../js/method.js'></script>
        <script src='../js/model.js'></script>
        <script src='../js/room.js'></script>
        <script src='../js/main.js'></script>
        <?php */ ?>

        <script>
            /*
            $(function() {  
                // Resized based on screen size
                app.el[window].resize(function() {
                    app.fn.screenSize();
                });
            });
            */
        </script>
    </body>
</html>
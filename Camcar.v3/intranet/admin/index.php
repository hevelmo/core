<?php
/*
 * Copyright (C) 2015 CAMCAR Administrador
 *
 */

include_once '../../incorporate/db_connect.php';
include_once '../../incorporate/functions.php';

sec_session_start();

if(login_check() != true) {
    header('Location: ../');
} else {
    if(admin_access_check() !== true) {
        header('Location: ../welcome');
    }
}

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="es-MX" class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="es-MX" class="no-js lt-ie10 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="es-MX" class="no-js lt-ie10 lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html lang="es-MX" class="no-js lt-ie10"> <![endif]-->
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv='cache-control' content='no-cache' />
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
        <meta name='viewport' content='width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0' />
        <title>Camcar | Administrador</title>
        <!--
        <meta name='apple-mobile-web-app-capable' content='yes'>
        -->
        <meta name='Keywords' content='' >
        <meta name='Description' content='' >
        <meta name='title' content=''>
        <meta name='google-site-verification' content='' />
        <meta name='author' content='Medigraf'>
        <meta name='Copyright' content='Copyright CAMCAR Administrador 2015. All Rights Reserved.'>
        <link href="http://fonts.googleapis.com/css?family=Roboto:100,400,300,700,400italic,500%7CMontserrat:400,700" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="css/import-adm.css">
        <link rel="stylesheet" href="css/import.css">
        <link rel="stylesheet" href="css/cssload/style.css">
        <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
        <link rel="stylesheet" href="css/cssload/jquery.fileupload.css">
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            ga('create', 'UA-60582942-2', 'auto');
            ga('send', 'pageview');
        </script>
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
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
                            alert("Estas usando IE 6, es obsoleto. \n Para una visualización optima del sitio, te recomendamos utilizar \n lo más nuevo en navegadores Google Chrome, Mozilla FireFox, Internet Explorer a partir de las versiones v9, v10 y v11 ");
                            break;
                        case 7:
                            alert("Estas usando IE 7, es obsoleto \n Para una visualización optima del sitio, te recomendamos utilizar \n lo más nuevo en navegadores Google Chrome, Mozilla FireFox, Internet Explorer a partir de las versiones v9, v10 y v11 ");
                            break;
                        case 8:
                            alert("Estas usando IE 8, es obsoleto \n Para una visualización optima del sitio, te recomendamos utilizar \n lo más nuevo en navegadores Google Chrome, Mozilla FireFox, Internet Explorer a partir de las versiones v9, v10 y v11 ");
                            break;
                        case 9:
                            alert("Para una visualización optima del sitio, te recomendamos utilizar \n lo más nuevo en navegadores Google Chrome, Mozilla FireFox, Internet Explorer a partir de las versiones v10 y v11 ");
                            //console.log("Estas usando IE 9, mas o menos compatible");
                            break;
                        default:
                            //console.log("Usas una version compatible");
                            break;
                    }
                }
            }
        </script>
    </head>
    <body id="landrover" class="top-header">
        <!-- Begin: Header - nav container -->
        <div class="nav-container">
            <nav class="nav-1 main-nav-1">
                <!--<div class="container">-->
                <div class="row">
                    <div class="col-xs-12">
                        <a href="#/" class="home-link" id="return_index">
                        <img alt="Logo" class="logo main-logo" src="../../resources/public/img/camcar.png">
                        </a>
                        <ul class="menu main-menu">
                            <li>
                                <a href="#/" id="return-index">Inicio</a>
                            </li>
                            <li class="has-dropdown">
                                <a id="hash-pre-owned">Seminuevos</a>
                                <ul class="subnav">
                                    <li>
                                        <a href="#/new/seminuevos" id="go-add-pre-owned">Nuevo</a>
                                    </li>
                                    <!--#/new/seminuevos-->
                                    <li>
                                        <a href="#/seminuevos" id="go-list-pre-owned">Listado</a>
                                    </li>
                                    <!--#/seminuevos-->
                                </ul>
                            </li>
                            <li class="visible-xs-poeple">
                                <a href='../logout/' id="sem-logout">Cerrar Sesión</a>
                            </li>
                        </ul>
                        <a class="vin_agn_name" id="">
                            <img src="../../resources/public/img/agencies/logos/<?php echo htmlentities($_SESSION['usr_agn_logo1']); ?>" alt="<?php echo htmlentities($_SESSION['usr_agn_nombre']); ?>" width="120">
                            <strong><?php echo htmlentities($_SESSION['usr_agn_nombre']); ?></strong>
                        </a>
                        <a class="vin_logout none-visible-xs" href='../logout/' id="sem-logout">
                            <i class="fa fa-close"></i>
                        </a>
                    </div>
                </div>
                <!--end of row-->
                <!--</div>--><!--end of container-->
                <div class="mobile-toggle">
                    <div class="bar-1"></div>
                    <div class="bar-2"></div>
                </div>
            </nav>
        </div>
        <!--   End: Header - nav container -->
        <!-- Begin: Section container -->
        <div class="main-container" id="header">
            <!-- Auxiliar Temporal Inputs's DIV -->
            <div id='hidden-inputs-session'>
                <?php /* ?>
                <?php */ ?>
                <input type='hidden' id='session-usr-username' value="<?php echo htmlentities($_SESSION['username']); ?>">
                <input type='hidden' id='session-usr-id' value="<?php echo htmlentities($_SESSION['user_id']); ?>">
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
            <!--Templates's DIV-->
            <div class="wrapper_content_interactive" id='content-temporal-interactive'></div>
        </div>
        <!--   End: Section container -->
        <a id="back-to-top"><i class="fa fa-angle-double-up"></i></a>
        <!--Core js-->
        <script src='lib/jquery-1.11.0.min.js'></script>
        <script src='lib/jquery.gdb.min.js'></script>
        <script src='lib/jquery-ui.js'></script>
        <script src='lib/underscore-min.js'></script>
        <script src="lib/handlebars.runtime.js"></script>
        <script src='templates/min/templates.min.js'></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="jsload/vendor/jquery.ui.widget.js"></script>
        <script src="jsload/jquery.iframe-transport.js"></script>
        <script src="jsload/jquery.fileupload.js"></script>
        <script src='lib/moment.min.js'></script>
        <script src='lib/accounting.min.js'></script>
        <script src='lib/bootstrap-datetimepicker.min.js'></script>
        <script src='../../resources/public/lib/finch.js'></script>
        <script src='lib/transitions.js'></script>
        <script src='lib/collapse.js'></script>
        <script src='../../resources/public/lib/bootstrap.js'></script>
        <script src="lib/alertify.min.js"></script>
        <script src="lib/sha512.js"></script>
        <script src='lib/hover-dropdown.js'></script>
        <script src="../../resources/public/lib/jquery.currency.js"></script>
        <script src="../../resources/public/lib/favicon.js"></script>
        <!-- THEME -->
        <script src='../../resources/public/lib/owl-carousel/min/owl.carousel.min.js'></script>
        <script src="../../resources/public/lib/flexslider/jquery.flexslider.js"></script>
        <script src="../../resources/public/lib/jquery.sticky.js"></script>
        <script src="../../resources/public/lib/jquery.scrollTo.js"></script>
        <script src="../../resources/public/lib/jquery.easing.1.3.js"></script>
        <script src="../../resources/public/lib/bootstrap-select.js"></script>
        <script src="../../resources/public/lib/isotope.js"></script>
        <script src="../../resources/public/lib/min/smooth-scroll.min.js"></script>
        <script src="../../resources/public/lib/jquery.herocarousel-plugins.js"></script>
        <script src="../../resources/public/lib/jquery.appear.js"></script>
        <script src="../../resources/public/lib/jquery.countTo.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCqo-F2TnMAABZvfV5yTQLlWvUCJlJViU&amp;sensor=false"></script>

        <script src='js/min/core.min.js'></script>
        <?php /* ?>
        <script src='js/objects.js'></script>
        <script src='js/method.js'></script>
        <script src='js/model.js'></script>
        <script src='js/room.js'></script>
        <script src='js/main.js'></script>
        <?php */ ?>

    </body>

</html>


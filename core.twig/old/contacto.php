<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv='cache-control' content='no-cache' />
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name='viewport' content='width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0' />
		<title></title>
		<!-- stylesheet /-->
		<link href="http://fonts.googleapis.com/css?family=Roboto:100,400,300,700,400italic,500%7CMontserrat:400,700" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="css/import.css">
	</head>
	<body>
		<!-- Begin: Header - nav container -->
		<div class="nav-container">
			<nav class="nav-1">
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<div class="block-logo">
								<a href="/" id="home_link" class="home-link inner-link clearfix" target="default">
									<img src="img/logo-vw.png" alt="Volswagen" class="logo">
									<!--<img src="img/logo-vw.jpg" alt="Volswagen" class="logo">-->
									<img src="img/logo-de.png" alt="Direct Express" class="logo">
									<!--<img src="img/logo-de.jpg" alt="Direct Express" class="logo">-->
									<span class="legend-de" style="display: none;"></span>
								</a>
							</div>
							<div class="block-nav">
								<ul id="menu" class="navi">
									<li class="navi-li li-top clearfix">
										<a href="#home" id="home-link" class="home inner-link" target="default">
											<span class="home">Inicio</span>
										</a>
									</li>
									<li class="navi-li li-top clearfix">
										<a href="#pricing" id="pricing-link" class="pricing inner-link" target="default">
											<span class="pricing">Precios</span>
										</a>
									</li>
									<li class="navi-li li-top clearfix">
										<a href="#contact" id="contact-link" class="contact inner-link" target="default">
											<span class="contact">Contacto</span>
										</a>
									</li>
								</ul>
							</div>
							<div class="block-social-links">
								<ul class="social-links">
									<li><a href="https://www.facebook.com/GuadalajaraDirectExpress" target="_blank"><i class="social_facebook"></i></a></li>
									<li><a href="http://www.twitter.com/directexpress_" target="_blank"><i class="social_twitter"></i></a></li>
									<li><a href="https://plus.google.com/+Directexpress-sanzioMx/posts" target="_blank"><i class="social_googleplus"></i></a></li>
								</ul>
							</div>
						</div>
					</div><!--end of row-->
				</div><!--end of container-->

				<div class="mobile-toggle">
					<div class="bar-1"></div>
					<div class="bar-2"></div>
				</div>
			</nav>
		</div>
		<!--   End: Header - nav container -->

		<!-- Begin: Section container -->
		<div class="main-container" id="header">
			<?php
				if (isset ($_POST['enviar'])) {
					//ob_start();
					$dex_name = $_POST['name'];
					$dex_email = $_POST['email'];
					$dex_message = $_POST['message'];
					$dex_cia = $_POST['cia'];

					// El mensaje
					$from = $dex_email;

					$mensaje = "Asunto: Contacto\n\n";
						$mensaje .= "Nombre(s) : " .$dex_name. "\n";
						$mensaje .= "Correo Electrónico: " .$dex_email. "\n";
						$mensaje .= "Mensaje: " .$dex_message. "\n";
						$mensaje .= $dex_cia. "\n";


					$header = "From:".$dex_name."<" . $from. ">\r\n" . "MIME-Version: 1.0\n" . "Content-type: text/plain; charset=iso-8859-1" ; //optional headerfields

					// En caso de que cualquier línea tenga más de 70 caracteres, habría
					// que usar wordwrap()
					$mensaje = wordwrap($mensaje, 70);
					//$correos = $mail."tianar1@hotmail.com";

					// Enviar
					mail("hevelmo060683@gmail.com", 'Contacto Direct Express', $mensaje, $header) or die("¡Error!");

					header ("location: /");
					//echo "<META HTTP-EQUIV='REFRESH' CONTENT=4;URL='/'>";
				}
			?>
			<section class="error-page fullscreen-element">

				<div class="container vertical-align">
					<div class="row">
						<div class="col-sm-12 text-center">
							<i class="pe-7s-help2"></i>
							<h1 class="text-white">Correo Enviado</h1>
						</div>
					</div><!--end of row-->
				</div><!--end of container-->

			</section>
			<?php

			?>
		<!-- Begin: Footer container -->
	    	<footer class="footer-2">
				<div class="container">
					<div class="row">
						<div class="col-sm-6">
							<a href="#/">
								<img alt="logo" class="logo" src="img/logo_directxpress.png">
							</a>
							<span class="tagline">El Taller de Servicio de Volkswagen.</span>
						</div>

						<div class="col-sm-6 text-right">
							<ul class="social-links">
								<li>
									<div class="log-medigraf" style="margin-top: 15px;">
										<a href="http://medigraf.com.mx" target="_blank">
											<div class="medigraf"></div>
										</a>
									</div>
								</li>
							</ul>
						</div>
					</div><!--end of row-->

					<div class="row">
						<div class="col-xs-12">
							<div class="footer-lower pull-left">
								<span class="copyright">© Copyright 2015 Direct Express</span>
							</div>
						</div>
					</div><!--end of row-->
				</div><!--end of container-->
			</footer>
			<!--   End: Footer container -->
		</div>
		<!--   End: Section container -->

	    <!--Core js-->
	    <!--
	    -->
	    <script src='lib/jquery-1.11.2.js'></script>
	    <script src='lib/jquery.gdb.js'></script>
	    <script src='lib/jquery-ui.js'></script>
	    <script src='lib/underscore.js'></script>
	    <script src="lib/handlebars.runtime.js"></script>
	    <script src='templates/min/templates.min.js'></script>
	    <script src='lib/moment.js'></script>
	    <script src='lib/accounting.js'></script>
	    <script src='lib/min/bootstrap-datetimepicker.min.js'></script>
	    <script src='lib/finch.js'></script>
	    <script src='lib/transitions.js'></script>
	    <script src='lib/collapse.js'></script>
	    <script src='lib/bootstrap.js'></script>
	    <script src="lib/alertify.js"></script>
	    <script src="lib/sha512.js"></script>
	    <script src='lib/hover-dropdown.js'></script>
	    <script src="lib/favicon.js"></script>

	    <!-- theme -->
	    <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/plugins/ScrollToPlugin.min.js"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCqo-F2TnMAABZvfV5yTQLlWvUCJlJViU&amp;sensor=false"></script>
	    <script src="lib/min/skrollr.min.js"></script>
		<script src="lib/min/flexslider.min.js"></script>
		<script src="lib/min/lightbox.min.js"></script>
		<script src="lib/min/twitterfetcher.min.js"></script>
		<script src="lib/min/spectragram.min.js"></script>
		<script src="lib/min/smooth-scroll.min.js"></script>
		<script src="lib/min/jquery.plugin.min.js"></script>
		<script src="lib/min/countdown.min.js"></script>
		<script src="lib/min/placeholders.min.js"></script>
		<script src="//f.vimeocdn.com/js/froogaloop2.min.js"></script>
	</body>
</html>

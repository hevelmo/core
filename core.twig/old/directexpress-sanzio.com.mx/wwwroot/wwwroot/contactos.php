<!DOCTYPE html>
<html lang="es">
<!-- HEAD start -->
<head>

<!-- meta tags -->
<meta charset="utf-8">
<meta name="keywords" content="Direct Express Sanzio">
<meta name="description" content="Direct Express Sanzio - es el nuevo Taller de la marca Volkswagen para autos con más de 2 años o que se encuentran fuera de la garantía. Este Taller se concentra en reparaciones ocasionadas por el desgaste rutinario de tu auto">
<meta name="author" content="Asociación Nacional de Concesionarios del Grupo Volkswagen y Seat - Gerencia de Publicidad [Fernando Tapia Rodriguez]" />
<title>Direct Express Sanzio</title>

<!-- FavICON -->
<link rel="shortcut icon" href="http://mkt.ancgvw.com/mailing/img/volkswagen.ico"/>

<!-- STYLES -->
<link rel="stylesheet" href="http://mkt.ancgvw.com/HTML5/css/layout.css" type="text/css">
<link rel="stylesheet" href="http://mkt.ancgvw.com/HTML5/css/default.ultimate.css" type="text/css">


</head>
<!-- HEAD ends -->

<body>
<div id="container">
		<!-- HEADER Start -->
    		<header id="page-header">
<!-- MENU TOP start -->
				<div id="menu_top">
        			<ul>
        				<li><a href="https://maps.google.com/maps?q=Av+Rafael+Sanzio+578,+Arcos+de+Guadalupe,+45037+Zapopan,+Jalisco,+M%C3%A9xico&hl=es-419&ie=UTF8&ll=20.66213,-103.431151&spn=0.009426,0.014066&sll=20.662149,-103.431168&hnear=Av+Rafael+Sanzio+578,+Arcos+de+Guadalupe,+Zapopan,+Jalisco,+M%C3%A9xico&t=m&z=17" title="Conslta nuestra ubicación en un Mapa" target="_blank">¿Dónde encontrarnos?</a></li>
                                                <li><a href="https://www.facebook.com/GuadalajaraDirectExpress" title="Facebook" target="_blank">Facebook</a></li>
        				<li class="last_ittem" title="Llámanos, estamos para servirte"><a href="tel:+523337 77 19 27">Tel. (33) 37 77 19 27</a></li>
					</ul>
        		</div>
<!-- MENU TOP end -->
    
<!-- LOGO -->
    			<div id="logo">
                	<a href="index.html"><img src="http://directexpress-sanzio.com.mx/images/logo_volkswagen.png" title="Direct Express Sanzio"></a>
                </div>
<!-- DEALER NAME -->
    			<div id="dealer_name" style="font-weight:bold;">
                	Direct Express Sanzio
                </div>

			</header>
<!-- HEADER ends -->
    
    <!-- MAIN CONTENT start -->
		<article class="page-content" style="border: 1px solid #ffffff; width: 958px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;-moz-box-shadow: inset 0px 1px 5px #555555;-webkit-box-shadow: inset 0px 1px 5px #555555;   box-shadow: inset 0px 1px 5px #555555; padding-bottom:20px;">
	<div id="menu_list">
        	<ul>
        		<li title="Quiénes somos"><a href="/index.html">Quiénes somos</a></li>
				<li title="Promociones"><a href="/promociones.html">Promociones</a></li>
				<li title="Dónde estamos"><a href="/dondeestamos.html">Dónde estamos</a></li>
				<li title="Ventajas"><a href="/ventajas.html">Ventajas</a></li>
				<li title="Vehículos Comerciales"><a href="/vehiculoscomerciales.html">Vehículos Comerciales</a></li>
				<li title="Servicios"><a href="servicios.html">Servicios</a></li>
                <li class="last_ittem" title="Contacto"><a href="contacto.php">Contacto</a></li>


			</ul>
        </div>
<div id="content_inner">
<h1>Contacto</h1>
<div id="leftCOL" style="float:left; width:600px;">
 <div id="form">
<? echo $mensaje; /*mostramos el estado de envio del form */ ?>
<? if ($flag!='ok') { ?>
<form action="index.php" method="post">
    <p>¿Tienes alguna duda, comentario, queja o sujerencia? Por favor llena el siguiente formulario y en breve nos pondremos en contacto contigo:</p>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" align="right" valign="middle"><p>Nombre<span style="color:#e34829;">*</span></p></td>
    <td width="50%" valign="middle"><input name="nombre" type="text" value="<? echo $_POST['nombre'];?>" size="25" <? if (isset ($flag) && $_POST['nombre']=='') { echo 'class="error"';} else {echo 'class="campo"';} ?> /></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><p>Apellidos<span style="color:#e34829;">*</span></p></td>
    <td valign="middle"><input name="apellidos" type="text"  value="<? echo $_POST['apellidos'];?>" size="25" <? if (isset ($flag) && $_POST['apellidos']=='') { echo 'class="error"';} else {echo 'class="campo"';} ?> /></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><p>E-mail<span style="color:#e34829;">*</span></p></td>
    <td valign="middle"><input name="email" type="text"  value="<? echo $_POST['email'];?>" size="25" <? if (isset ($flag) && $_POST['email']=='') { echo 'class="error"';} else {echo 'class="campo"';} ?> /></td>
  </tr>
  
  <tr>
    <td align="right" valign="middle"><p>Tel&eacute;fonos </p></td>
    <td valign="middle"><input name="telefonos" type="text"  value="<? echo $_POST['telefonos'];?>" size="25" <? if (isset ($flag) && $_POST['telefonos']=='') { echo 'class="error"';} else {echo 'class="campo"';} ?> /></td>
  </tr>
</table>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <td width="50%" align="right" valign="middle"><p>Mensaje</p></td>
    <td width="50%" valign="middle"><textarea name="Mensaje" cols="25" rows="5" <? if (isset ($flag) && $_post['mensaje']=='') { echo 'class="error"';} else {echo 'class="campo"';} ?>="<? if (isset ($flag) && $_POST['mensaje']=='') { echo 'class="error"';} else {echo 'class="campo"';} ?>"><? echo $_POST['mensaje'];?></textarea></td>
  </tr>

  
    <tr>
    <td align="right" valign="middle"></td>
    <td valign="middle"><input class="boton" type="submit" name="enviar" value="Enviar Confirmaci&oacute;n" /></td>
  </tr>
  </table>
        </table>
        </form>
<? } ?></div>
                                 
    </div>  
          </div>          
    	</article>          
<!-- MAIN CONTENT end -->

<!-- FOOTER start -->
<footer>
<!-- DISCLAIMER start -->
		<div id="disclaimer">
        	<p>
				*) Las imágenes son sólo ilustrativas. El color y algunas características pueden corresponder o no con los vehículos disponibles en la Concesionaria. Paquetes sujetos a cambio sin previo aviso. El equipamiento que se muestra en las fotos puede no estar disponible en México. Para conocer las opciones de equipamiento disponibles, así como la gama completa de colores de carrocería, se debe consultar el Configurador.t
			</p>
        </div>
	<!-- DISCLAIMER end -->

    
        <!-- LEGALES start -->
		<div id="legales" style="padding-right:3px;">
        	<p><a href="avisoprivacidad.html" title="Aviso de Privacidad">Aviso de Privacidad</a>&nbsp;|&nbsp;<a href="http://www.vw.com.mx/" title="Volkswagen de México" target="_blank">Volkswagen de México</a></p>
            <p><a href="http://www.ancgvw.com/" title="Asociación Nacional de Concesionarios del Grupo Volkswagen, A. C." target="_blank">Asociación Nacional de Concesionarios del Grupo Volkswagen, A. C.® 2013	</a></p>
        </div>
	<!-- LEGALESS end -->
</footer>
<!-- FOOTER end -->

</div>

</body>
</html>

<?php
//proceso del formulario
// si existe "enviar"...
if (isset ($_POST['enviar'])) {

//recogemos las variables
$nombre=$_POST['nombre'];
$apellidos=$_POST['apellidos'];
$email=$_POST['email'];
$telefonos=$_POST['telefonos'];
$mensaje=$_POST['mensaje'];

//comprobamos si todos los campos fueron completados
if ($nombre!='' && $email!='' && $empresa!='') {
// si es asi armamos el html
$contenido = '<html><body>';
$contenido .= '<h2>Mensaje Direct Express Sanzio</h2>';
$contenido .= '<p>Enviado el '.  date("d M Y").'</p>';
$contenido .= '<hr />';
$contenido .= '<p>Nombre: <strong>'.$nombre.'</strong>';
$contenido .= '<p>Apellidos: <strong>'.$apellidos.'</strong>';
$contenido .= '<p>Email: <strong>'.$email.'</strong>';
$contenido .= '<p>Telefonos: <strong>'.$telefonos.'</strong>';
$contenido .= '<hr />';
$contenido .= '<p>Mensaje: <strong>'.$mensaje.'</strong>';
$contenido .= '<hr />';
$contenido .= '</body></html>';

// si todos los campos fueron completados enviamos el mail
mail ("marketing@directexpress-sanzio.com.mx", "Mensaje Direct Express Sanzio", $contenido, "From: $email\nContent-Type: text/html; charset=iso-8859-1\nContent-Transfer-Encoding: 8bit"); 
$flag='ok';
$mensaje='<div id="ok"><strong>Gracias</strong>, tu mensaje fue enviado correctamente.';

} else {
//si no todos los campos fueron completados se frena el envio y avisamos al usuario	
$flag='err';
$mensaje='<div id="error">(*) Campos obligatorios</div>';
}
}
?>

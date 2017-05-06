<?php
class Blog {
	private $blogArray;
	function __construct() {
		$this->blogArray = array(
			array(
				'key' => 'sibarita-masters',
				'id' => '1',
				'thumb' => '<img src="img/promo/invitacion-Sibarita-600x400px.png" alt="SIBARITA MASTERS" class="post-img">',
				'agn_key' => 'jaguar-land-rover',
				'agencia' => 'Jaguar Land Rover',
				'fecha' => '30 de Junio de 2016',
				'title' => 'Gira Nacional Sibarita 2016',
				'descripcion_corta' => 'Conoce su trayectoria e historia y deja que tus sentidos vivan los Talleres: Wine Genius, Taste & Say Cheese, British Spirit. Jueves 11 de Agosto, a las 19:30 hrs',
				'contacto' => '<h3 class="post-subtitle" style="margin-bottom: 35px;">RSVP: <a href="mailto:contacto@21Chefs.com.mx?subject=Sibarita Masters" "contactanos"="" style="color: #000;">contacto@21Chefs.com.mx</a>,<br>Llamanos: <a href="tel:+3338187540" style="color: #000;">(33) 3818 7540</a>.</h3>',
				'imagen' => '<img src="img/promo/invitacion-Sibarita-650x1188px.png" alt="..." class="post-img">'
			),
			array(
				'key' => 'night-experience',
				'id' => '2',
				'thumb' => 'noticia-jaguar-night-experience.jpg',
				'alt_thumb' => 'JAGUAR NIGHT EXPERIENCE',
				'agn_key' => 'jaguar',
				'agencia' => 'Jaguar',
				'fecha' => 'Martes 28 de Junio 2016',
				'title' => 'Jaguar Night Experience',
				'descripcion_corta' => 'Noche de gala en la agencia de Jaguar Guadalajara, donde la F-Pace despertó suspiros de propios y extraños, un ambiente ameno y cálido entre amigos',
				'description' => array(
					array(
						'p' => 'Noche de gala en la agencia de Jaguar Guadalajara, donde la F-Pace despertó suspiros de propios y extraños, un ambiente ameno y cálido entre amigos.'
					),
					array(
						'p' => 'Manejando todos los modelos de Jaguar por las calles de la ciudad, felicidades a todos los que se atrevieron a descubrir que tan vivos están.'
					)
				),
				'video' => array(
					'iframe' => 'https://www.youtube.com/embed/1hNQKS4LDPs'
				),
				'sociales' => array(
					'youtube' => 'https://www.youtube.com/c/CamcarMx'
				)
			),
			array(
				'key' => 'servicio-jaguar-land-rover',
				'id' => '3',
				'thumb' => 'promocion-servicio-junio-600x400.jpg',
				'alt_thumb' => 'Papá merece el mejor regalo...',
				'agn_key' => 'jaguar-land-rover',
				'agencia' => 'JAguar Land Rover',
				'fecha' => '7 de Junio de 2016',
				'title' => 'Papà merece el mejor regalo....',
				'descripcion_corta' => 'Agende el servicio para su vehículo durante el mes de junio. Y recibirá como obsequio, la exclusiva pashmina edición especial',
				'imagen' => 'mailing-dia-padre.jpg',
			),
			array(
				'key' => 'save-the-date',
				'id' => '4',
				'thumb' => '<img src="img/promo/img/promo/sibarita_600x400.jpg" alt="Gira NAcional Sibarita" class="post-img">',
				'agn_key' => 'jaguar-land-rover',
				'agencia' => 'Jaguar Land Rover',
				'fecha' => '30 de Junio de 2016',
				'title' => 'Gira Nacional Sibarita 2016',
				'descripcion_corta' => 'Club 21Chefs y Jaguar Land Rover Guadalajara tienen el honor de invitarle a disfrutar una experiencia para todos sus sentidos',
				'contacto' => '<h3 class="post-subtitle">Regístrate al teléfono <a href="tel:+36290100" style="color: #000;">3629-0100</a>.</h3>',
				'imagen' => array(
					array(
						'img' => '<img src="img/promo/save-the-date/ES_invitacion_jaguar.png" alt="..." class="post-img">'
					),
					array(
						'img' => '<img src="img/promo/save-the-date/ES_savethedate_jaguar.png" alt="..." class="post-img">'
					)
				)
			)
		);
	}
	public function getBlogArray() {
		return $this->blogArray;
	}
	public function getBlog($key) {
		$news = array();
		$condition = false;
		for ($idx = 0; $idx < count($this->blogArray) && $condition == false;  $idx++) {
			$condition = ($key == $this->blogArray[$idx]['key']);
			if ( $condition == true ) {
				$news = $this->blogArray[$idx];
			}
		}
		return $news;
	}
}
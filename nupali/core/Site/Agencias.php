<?php
class Agencias {
	private $agenciasArray;
	function __construct() {
		$this->agenciasArray = array(
			array(
				'key' => 'guadalajara',
				'id' => '1',
				'name' => 'Jaguar Guadalajara',
				'fachada' => 'fachada-jag-ldr-gdl.jpg',
				'business_max' => '20',
				'telefono' => array(
					'ventas' => array(
						'telefono' => '(33) 3629-0100',
						'call' => '3336290100'
					)
				),
				'domicilio' => 'Av. Vallarta No. 5500-A Col. Camichines Vallarta, Zapopan, C.P. 45020.',
				'horarios' => array(
					'ventas' => 'Lunes a viernes de 9:00 a 20:00 Sábado de 9:00 a 18:00 y Domingo de 11:00  a 18:00.'
				),
				'social' => array(
					'sitio' => 'http://eurocavsa.com.mx/',
					'facebook' => 'https://www.facebook.com/JaguarGDLCountry'
				),
				'mapa' => array(
					'frame' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3732.7053908177877!2d-103.4337904846356!3d20.681561504915052!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x2b87b8539ebccde2!2sJaguar+y+Land+Rover+Guadalajara!5e0!3m2!1ses!2smx!4v1484000046527'
				)
			),
			array(
				'key' => 'country',
				'id' => '2',
				'name' => 'Jaguar Country',
				'fachada' => 'fachada-jag-ldr-country.jpg',
				'business_max' => '41',
				'telefono' => array(
					'ventas' => array(
						'telefono' => '(33) 3818 - 7560',
						'call' => '3338187560'
					)
				),
				'domicilio' => 'Av. Circ. Jorge Álvarez del Castillo 1443 Jardines del Country 44610 Guadalajara, Jal. México.',
				'horarios' => array(
					'ventas' => 'Lunes a viernes de 9:00 a 20:00 Sábado de 9:00 a 18:00 y Domingo de 11:00  a 18:00.'
				),
				'social' => array(
					'sitio' => 'http://eurocavsa.com.mx/',
					'facebook' => 'https://www.facebook.com/JaguarGDLCountry'
				),
				'mapa' => array(
					'frame' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d926.6048836664827!2d-103.36705555226366!3d20.702098255545838!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x941918d50f14035f!2sJaguar+y+Land+Rover+Country!5e0!3m2!1ses!2smx!4v1484000197994'
				)
			)
		);
	}
	public function getAgenciasArray() {
		return $this->agenciasArray;
	}
	public function getAgencia($key) {
		$agencia = array();
		$condition = false;
		for ($idx = 0; $idx < count($this->agenciasArray) && $condition == false;  $idx++) {
			$condition = ($key == $this->agenciasArray[$idx]['key']);
			if ( $condition == true ) {
				$agencia = $this->agenciasArray[$idx];
			}
		}
		return $agencia;
	}
}
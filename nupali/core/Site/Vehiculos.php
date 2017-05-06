<?php 
class Vehiculos {
	private $vehiculosArray;
	function __construct() {
		$this->vehiculosArray = array(
			array(
				'id' => '1',
				'key' => 'xe',
				'name' => 'Jaguar XE'
			),
			array(
				'id' => '2',
				'key' => 'xf',
				'name' => 'Jaguar XF',
				'banner' => array(
					array(
						'id' => '1',
						'title' => 'JAGUAR XF',
						'subtitle' => 'ESTILO, PRESTACIONES, CONFORT.',
						'alt' => 'Jaguar XF',
						'media' => array(
							'650x277' => 'banner_xf_650x277.jpg',
							'900x586' => 'banner_xf_900x586.jpg',
							'1600x900' => 'banner_xf_1600x900.jpg'
						)
					),
					array(
						'id' => '2',
						'title' => 'XF INTERIORES',
						'subtitle' => 'CONFORT, LUJO Y CREDENCIALES DEPORTIVAS DE INTERIORES',
						'alt' => 'XF Interiores',
						'media' => array(
							'650x277' => 'JAG_XF_INT_650x277.jpg',
							'900x586' => 'JAG_XF_INT_900x586.jpg',
							'1600x900' => 'JAG_XF_INT_1600x900.jpg'
						)
					)
				),
				'section' => array(
					'image_block' => array(
						'src' => 'img/modelos/jaguar-xf/previews/JAG_PREV_XF_1440x960.jpg'
					),
					'text_block' => array(
						'h5' => 'JAGUAR',
						'primary_header' => 'XF',
						'paragraph' => 'Un vehículo elegante, dinámico, rompedor.  El XF fusiona el estilo de un deportivo con el lujo espectacular de una berlina. Su innovador diseño acumula ya más de un centenar de premios internacionales y ha marcado un antes y un después en el diseño automovilístico.'
					),
					'models' => array(
						array(
							'id' => '1',
							'href' => 'http://jaguar-mexico.com/mx/xf/models/luxury.php',
							'img' => array(
								'alt' => 'Contemporáneo, individual y diseñado por expertos.',
								'src' => 'img/modelos/jaguar-xf/xf-luxury/JAG_MOD_XF_LUXURY_450x259.jpg'
							),
							'model'	=> 'XF LUXURY'
						),
						array(
							'id' => '2',
							'href' => 'http://jaguar-mexico.com/mx/xf/models/portfolio.php',
							'img' => array(
								'alt' => 'Materiales de mayor calidad y artesanía exquisita.',
								'src' => 'img/modelos/jaguar-xf/xf-portfolio/JAG_MOD_XF_PORTFOLIO_450x259.jpg'
							),
							'model'	=> 'XF PORTFOLIO'
						),
						array(
							'id' => '3',
							'href' => 'http://jaguar-mexico.com/mx/xf/models/xfr.php',
							'img' => array(
								'alt' => 'Versión sobrealimentada del lujo deportivo de Jaguar.',
								'src' => 'img/modelos/jaguar-xf/xfr/JAG_MOD_XFR_450x259.jpg'
							),
							'model'	=> 'XFR'
						)
					),
					'dark_action' => array(
						'links' => array(
							'catalogo' => array(
								'href' => 'files/jaguar-xf/catalogo-xf.pdf',
								'download' => 'Catálogo-xf.pdf',
								'title' => 'Descarga',
								'subtitle' => 'CATÁLOGO'
							),
							'ficha_tecnica' => array(
								'href' => 'files/jaguar-xf/especificaciones_jaguar_xf.pdf',
								'download' => 'Ficha-Técnica-xf.pdf',
								'title' => 'Descarga',
								'subtitle' => 'FICHA TECNICA'	
							),
							'prueba_de_manejo' => array(
								'model_name' => 'XF',
								'model_key' => 'xf',
								'title' => 'Agenda',
								'subtitle' => 'PRUEBA DE MANEJO'
							)
						)
					)
				)
			),
			array(
				'id' => '3',
				'key' => 'xj',
				'name' => 'Jaguar XJ',
				'banner' => array(
					array(
						'id' => '1',
						'title' => 'JAGUAR XJ',
						'subtitle' => 'LUJO EXTRAORDINARIO',
						'alt' => 'Jaguar XJ',
						'media' => array(
							'650x277' => 'JAG_XJ_EXT_650x277.jpg',
							'900x586' => 'JAG_XJ_EXT_900x586.jpg',
							'1600x900' => 'JAG_XJ_EXT_1600x575.jpg'
						)
					),
					array(
						'id' => '2',
						'title' => 'XJ INTERIORES',
						'subtitle' => 'CONTEMPORÁNEO Y LUJOSO, DESPIERTA TODOS LOS SENTIDOS.',
						'alt' => 'XJ Interiores',
						'media' => array(
							'650x277' => 'JAG_XJ_INT_650x277.jpg',
							'900x586' => 'JAG_XJ_INT_900x586.jpg',
							'1600x900' => 'JAG_XJ_INT_1600x575.jpg'
						)
					)
				),
				'section' => array(
					'image_block' => array(
						'src' => 'img/modelos/jaguar-xj/previews/JAG_PREV_XJ_1440x960.jpg'
					),
					'text_block' => array(
						'h5' => 'JAGUAR',
						'primary_header' => 'XJ',
						'paragraph' => 'El XJ es la esencia de Jaguar. Con su resistente y ligera carrocería de aluminio, el XJ ofrece una agilidad y una conducción insuperables. La tecnología innovadora del XJ le permite reaccionar ante las condiciones de la carretera y otros vehículos. Y gracias a su espacioso interior, también es un vehículo que mima a sus pasajeros y despierta los sentidos.'
					),
					'models' => array(
						array(
							'id' => '1',
							'href' => 'http://jaguar-mexico.com/mx/xj/models/premium_luxury.php',
							'img' => array(
								'alt' => 'Impresionante diseño, lujo contemporáneo y tecnología vanguardista.',
								'src' => 'img/modelos/jaguar-xj/xj-premium-luxury/JAG_MOD_XJ_PREMIUM_LUXURY_450x259.jpg'
							),
							'model'	=> 'XJ PREMIUM LUXURY'
						),
						array(
							'id' => '2',
							'href' => 'http://jaguar-mexico.com/mx/xj/models/portfolio.php',
							'img' => array(
								'alt' => 'Altas prestaciones y mayor personalización.',
								'src' => 'img/modelos/jaguar-xj/xj-portfolio/JAG_MOD_XJ_PORTFOLIO_450x259.jpg'
							),
							'model'	=> 'XF PORTFOLIO'
						),
						array(
							'id' => '3',
							'href' => 'http://jaguar-mexico.com/mx/xj/models/portfolio_lwb.php',
							'img' => array(
								'alt' => 'Una afirmación impresionante de potencia y exclusividad.',
								'src' => 'img/modelos/jaguar-xj/xj-portfolio-lwb/JAG_MOD_XJ_PORTFOLIO_LWB_450x259.jpg'
							),
							'model'	=> 'XFR'
						)
					),
					'dark_action' => array(
						'links' => array(
							'ficha_tecnica' => array(
								'href' => 'iles/jaguar-xf/especificaciones_jaguar_xj.pdf',
								'download' => 'Ficha-Técnica-xj.pdf',
								'title' => 'Descarga',
								'subtitle' => 'FICHA TECNICA'	
							),
							'prueba_de_manejo' => array(
								'model_name' => 'XJ',
								'model_key' => 'xj',
								'title' => 'Agenda',
								'subtitle' => 'PRUEBA DE MANEJO'
							)
						)
					)
				)
			),
			array(
				'id' => '4',
				'key' => 'f-pace',
				'name' => 'Jaguar F-PACE'
			),
			array(
				'id' => '5',
				'key' => 'f-type',
				'name' => 'Jaguar F-TYPE',
				'banner' => array(
					array(
						'id' => '1',
						'title' => 'F-TYPE COUPÉ',
						'subtitle' => 'PURO AUTOMÓVIL DEPORTIVO JAGUAR',
						'alt' => 'JAGUAR F-TYPE COUPÉ',
						'media' => array(
							'650x277' => 'JAG_SEL_FTYPE_COUPE_650x277.jpg',
							'900x586' => 'JAG_SEL_FTYPE_COUPE_900x586.jpg',
							'1600x900' => 'JAG_SEL_FTYPE_COUPE_1600x900.jpg'
						)
					),
					array(
						'id' => '2',
						'title' => 'F-TYPE CONVERTIBLE',
						'subtitle' => 'PURO PLACER AL VOLANTE',
						'alt' => 'JAGUAR F-TYPE CONVERTIBLE',
						'media' => array(
							'650x277' => 'JAG_SEL_FTYPE_CONV_650x277.jpg',
							'900x586' => 'JAG_SEL_FTYPE_CONV_900x586.jpg',
							'1600x900' => 'JAG_SEL_FTYPE_CONV_1600x900.jpg'
						)
					)
				),
				'section' => array(
					'fullscreen' => array(
						'image_holder' => array(
							array(
								'src' => 'img/holder_models/select_f_type_coupe.png'
							),
							array(
								'src' => 'img/holder_models/select_f_type_conv.png'
							)
						),
						'hover_state' => array(
							'desktop' => array(
								array(
									'h5' => 'F-TYPE CONVERTIBLE',
									'href' => 'f-type-convertible',
									'title' => 'VER MODELOS'
								),
								array(
									'h5' => 'F-TYPE COUPÉ',
									'href' => 'f-type-coupe',
									'title' => 'VER MODELOS'
								)
							),
							'mobile' => array(
								array(
									'span' => 'F-TYPE CONVERTIBLE',
									'href' => 'f-type-coupe',
									'title' => 'VER MODELOS'
								),
								array(
									'span' => 'F-TYPE COUPÉ',
									'href' => 'f-type-convertible',
									'title' => 'VER MODELOS'
								)
							)
						)
					)
				)
			)
		);
	}
	public function getVehiclesArray() {
		return $this->vehiculosArray;
	}
	public function getVehiclesDetails($key) {
		$vehiculo = array();
		$condition = false;
		for ($idx = 0; $idx < count($this->vehiculosArray) && $condition == false;  $idx++) {
			$condition = ($key == $this->vehiculosArray[$idx]['key']);
			if ( $condition == true ) {
				$vehiculo = $this->vehiculosArray[$idx];
			}
		}
		return $vehiculo;
	}
}
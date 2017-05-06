<?php
class Modelos {
	private $modelosArray;
	function __construct() {
		$this->modelosArray = array(
			array(
				'key' => 'xe',
				'id' => '1',
				'name' => 'XE',
				'thumb' => 'thumb-xe.png',
				'url_target' => 'http://www.jaguar-mexico.com/jaguar-range/xe/index.html',
				'target' => '_blank'
			),
			array(
				'key' => 'xf',
				'id' => '2',
				'name' => 'XF',
				'thumb' => 'thumb-xf-2011.png',
				'url_target' => 'vehiculos/xf',
				'target' => '_self',
				'banner' => array(
					array(
						'id' => '1',
						'alt' => 'JAGUAR XF ESTILO, PRESTACIONES, CONFORT.',
						'sliders' => array(
							'650' => 'banner_xf_650x277.jpg',
							'900' => 'banner_xf_900x586.jpg',
							'1600' => 'banner_xf_1600x900.jpg'
						),
						'title' => 'JAGUAR XF',
						'subtitle' => 'ESTILO, PRESTACIONES, CONFORT'
					),
					array(
						'id' => '2',
						'alt' => 'JAGUAR XF INTERIORES CONFORT, LUJO Y CREDENCIALES DEPORTIVAS DE INTERIORES.',
						'sliders' => array(
							'650' => 'JAG_XF_INT_650x277.jpg',
							'900' => 'JAG_XF_INT_900x586.jpg',
							'1600' => 'JAG_XF_INT_1600x900.jpg'
						),
						'title' => 'XF INTERIORES',
						'subtitle' => 'CONFORT, LUJO Y CREDENCIALES DEPORTIVAS DE INTERIORES.'
					)
				),
				'no_select' => array(
					'image_holder' => 'jaguar-xf/previews/JAG_PREV_XF_1440x960.jpg',
					'descripcion' => 'Un vehículo elegante, dinámico, rompedor.  El XF fusiona el estilo de un deportivo con el lujo espectacular de una berlina. Su innovador diseño acumula ya más de un centenar de premios internacionales y ha marcado un antes y un después en el diseño automovilístico.',
					'versiones' => array(
						array(
							'key' => 'xf-luxury',
							'id' => '1',
							'name' => 'XF LUXURY',
							'thumb' => 'jaguar-xf/xf-luxury/JAG_MOD_XF_LUXURY_450x259.jpg',
							'alt' => 'CONTEMPORÁNEO, INDIVIDUAL Y DISEÑADO POR EXPERTOS.',
							'url_target' => 'http://jaguar-mexico.com/mx/xf/models/luxury.php'
						),
						array(
							'key' => 'xf-portfolio',
							'id' => '2',
							'name' => 'XF PORTFOLIO',
							'thumb' => 'jaguar-xf/xf-portfolio/JAG_MOD_XF_PORTFOLIO_450x259.jpg',
							'alt' => 'MATERIALES DE MAYOR CALIDAD Y ARTESANÍA EXQUISITA.',
							'url_target' => 'http://jaguar-mexico.com/mx/xf/models/portfolio.php'
						),
						array(
							'key' => 'xfr',
							'id' => '3',
							'name' => 'XFR',
							'thumb' => 'jaguar-xf/xfr/JAG_MOD_XFR_450x259.jpg',
							'alt' => 'VERSIÓN SOBREALIMENTADA DEL LUJO DEPORTIVO DE JAGUAR.',
							'url_target' => 'http://jaguar-mexico.com/mx/xf/models/portfolio.php'
						)
					),
					'actions' => array(
						array(
							'catalogo' => array(
								'name' => 'CATÁLOGO',
								'download' => 'Descarga',
								'href' => 'jaguar-xf/catalogo-xf.pdf',
								'title' => 'Catálogo-xf.pdf'
							),
							'ficha_tecnica' => array(
								'name' => 'FICHA TECNICA',
								'download' => 'Descarga',
								'href' => 'jaguar-xf/especificaciones_jaguar_xf.pdf',
								'title' => 'Ficha-Técnica-xf.pdf'
							),
							'testdrive' => array(
								'name' => 'PRUEBA DE MANEJO',
								'download' => 'Agendar',
								'href' => 'agenda/prueba-de-manejo/xf'
							),
							'finacing' => array(
								'href' => 'financiamiento/xf'
							)
						)
					)
				)
			),
			array(
				'key' => 'xj',
				'id' => '3',
				'name' => 'XJ',
				'thumb' => 'thumb-xj-2011.png',
				'url_target' => 'vehiculos/xj',
				'target' => '_self',
				'banner' => array(
					array(
						'id' => '1',
						'alt' => 'LUJO EXTRAORDINARIO',
						'sliders' => array(
							'650' => 'JAG_XJ_EXT_650x277.jpg',
							'900' => 'JAG_XJ_EXT_900x586.jpg',
							'1600' => 'JAG_XJ_EXT_1600x575.jpg'
						),
						'title' => 'JAGUAR XJ',
						'subtitle' => 'LUJO EXTRAORDINARIO'
					),
					array(
						'id' => '2',
						'alt' => 'CONTEMPORÁNEO Y LUJOSO, DESPIERTA TODOS LOS SENTIDOS.',
						'sliders' => array(
							'650' => 'JAG_XJ_INT_650x277.jpg',
							'900' => 'JAG_XJ_INT_900x586.jpg',
							'1600' => 'JAG_XJ_INT_1600x575.jpg'
						),
						'title' => 'XJ INTERIORES',
						'subtitle' => 'CONTEMPORÁNEO Y LUJOSO, DESPIERTA TODOS LOS SENTIDOS.'
					)
				),
				'no_select' => array(
					'image_holder' => 'jaguar-xj/previews/JAG_PREV_XJ_1440x960.jpg',
					'descripcion' => 'El XJ es la esencia de Jaguar. Con su resistente y ligera carrocería de aluminio, el XJ ofrece una agilidad y una conducción insuperables. La tecnología innovadora del XJ le permite reaccionar ante las condiciones de la carretera y otros vehículos. Y gracias a su espacioso interior, también es un vehículo que mima a sus pasajeros y despierta los sentidos.',
					'versiones' => array(
						array(
							'key' => 'xj-premium-luxury',
							'id' => '1',
							'name' => 'XJ PREMIUM LUXURY',
							'thumb' => 'jaguar-xj/xj-premium-luxury/JAG_MOD_XJ_PREMIUM_LUXURY_450x259.jpg',
							'alt' => 'IMPRESIONANTE DISEÑO, LUJO CONTEMPORÁNEO Y TECNOLOGÍA VANGUARDISTA.',
							'url_target' => 'http://jaguar-mexico.com/mx/xj/models/portfolio.php'
						),
						array(
							'key' => 'xj-portfolio',
							'id' => '2',
							'name' => 'XJ PORTFOLIO',
							'thumb' => 'jaguar-xj/xj-portfolio/JAG_MOD_XJ_PORTFOLIO_450x259.jpg',
							'alt' => 'ALTAS PRESTACIONES Y MAYOR PERSONALIZACIÓN.',
							'url_target' => 'http://jaguar-mexico.com/mx/xf/models/portfolio.php'
						),
						array(
							'key' => 'xk-portfolio-lwbr',
							'id' => '3',
							'name' => 'XJ PORTFOLIO LWBR',
							'thumb' => 'jaguar-xj/xj-portfolio-lwb/JAG_MOD_XJ_PORTFOLIO_LWB_450x259.jpg',
							'alt' => 'VERSIÓN SOBREALIMENTADA DEL LUJO DEPORTIVO DE JAGUAR.',
							'url_target' => 'http://jaguar-mexico.com/mx/xf/models/portfolio.php'
						)
					),
					'actions' => array(
						array(
							'ficha_tecnica' => array(
								'name' => 'FICHA TECNICA',
								'download' => 'Descarga',
								'href' => 'jaguar-xf/especificaciones_jaguar_xj.pdf',
								'title' => 'Ficha-Técnica-xj.pdf'
							),
							'testdrive' => array(
								'name' => 'PRUEBA DE MANEJO',
								'download' => 'Agendar',
								'href' => 'agenda/prueba-de-manejo/xj'
							),
							'finacing' => array(
								'href' => 'financiamiento/xj'
							)
						)
					)
				)
			),
			array(
				'key' => 'f-pace',
				'id' => '4',
				'name' => 'F-PACE',
				'thumb' => 'thumb-f-pace.png',
				'url_target' => 'http://www.jaguar-mexico.com/jaguar-range/f-pace/index.html',
				'target' => '_blank'
			),
			array(
				'key' => 'f-type',
				'id' => '5',
				'name' => 'F-Type',
				'thumb' => 'thumb-ftype.png',
				'url_target' => 'f-type',
				'target' => '_self',
				'banner' => array(
					array(
						'id' => '1',
						'alt' => 'PURO AUTOMÓVIL DEPORTIVO JAGUAR',
						'sliders' => array(
							'650' => 'JAG_SEL_FTYPE_COUPE_650x277.jpg',
							'900' => 'JAG_SEL_FTYPE_COUPE_900x586.jpg',
							'1600' => 'JAG_SEL_FTYPE_COUPE_1600x900.jpg'
						),
						'title' => 'F-TYPE COUPÉ',
						'subtitle' => 'PURO AUTOMÓVIL DEPORTIVO JAGUAR'
					),
					array(
						'id' => '2',
						'alt' => 'PURO PLACER AL VOLANTE',
						'sliders' => array(
							'650' => 'JAG_SEL_FTYPE_CONV_650x277.jpg',
							'900' => 'JAG_SEL_FTYPE_CONV_900x586.jpg',
							'1600' => 'JAG_SEL_FTYPE_CONV_1600x900.jpg'
						),
						'title' => 'F-TYPE CONVERTIBLE',
						'subtitle' => 'PURO PLACER AL VOLANTE'
					)
				),
				'select' => array(
					'image_holder' => array(
						array(
							'imagen' => 'select_f_type_conv.png',
							'url_target' => 'vehiculos/f-type/convertible',
							'title' => 'F-TYPE CONVERTIBLE'
						),
						array(
							'imagen' => 'select_f_type_coupe.png',
							'url_target' => 'vehiculos/f-type/coupe',
							'title' => 'F-TYPE COUPÉ'
						)
					),
					'versiones' => array(
						array(
							'key' => 'f-type-convertible',
							'id' => '1',
							'name' => 'F-TYPE CONVERTIBLE',
							'primary_header' => 'CONVERTIBLE',
							'image_holder' => 'jaguar-f-type-conv/previews/JAG_PREV_FTYPE_CONV_1440x960.jpg',
							'descripcion' => array(
								array(
									'p' => 'El F-TYPE es un deportivo pura sangre Jaguar capaz de disparar las pulsaciones.'
								),
								array(
									'p' => 'La fluidez y espectacularidad de sus prestaciones se une a una respuesta inmediata, una conducción ágil y precisa junto con el refinamiento y la funcionalidad necesarios para la vida diaria.'
								)
							),
							'banner' => array(
								array(
									'id' => '1',
									'alt' => 'PURO PLACER AL VOLANTE',
									'sliders' => array(
										'650' => 'JAG_FTYPE_CONV_EXT_650x277.jpg',
										'900' => 'JAG_FTYPE_CONV_EXT_900x586.jpg',
										'1600' => 'JAG_FTYPE_CONV_EXT_1600x575.jpg'
									),
									'title' => 'F-TYPE CONVERTIBLE',
									'subtitle' => 'PURO PLACER AL VOLANTE'
								),
								array(
									'id' => '2',
									'alt' => 'LA QUINTA ESENCIA DEL TEMPERAMENTO BRITÁNICO.',
									'sliders' => array(
										'650' => 'JAG_FTYPE_CONV_INT_650x277.jpg',
										'900' => 'JAG_FTYPE_CONV_INT_900x586.jpg',
										'1600' => 'JAG_FTYPE_CONV_INT_1600x575.jpg'
									),
									'title' => 'F-TYPE CONVERTIBLE INTERIORES',
									'subtitle' => 'LA QUINTA ESENCIA DEL TEMPERAMENTO BRITÁNICO.'
								)
							),
							'versiones' => array(
								array(
									'key' => 'f-type',
									'id' => '1',
									'name' => 'F-TYPE',
									'thumb' => 'jaguar-f-type-conv/convertible/JAG_MOD_CONV_450x259.jpg',
									'alt' => '. . .',
									'url_target' => 'http://jaguar-mexico.com/mx/ftype/models/ftype-.php'
								),
								array(
									'key' => 'f-type-s',
									'id' => '2',
									'name' => 'F-TYPE S',
									'thumb' => 'jaguar-f-type-conv/convertible-s/JAG_MOD_CONV_S_450x259.jpg',
									'alt' => '. . .',
									'url_target' => 'http://jaguar-mexico.com/mx/ftype/models/ftype-s.php'
								),
								array(
									'key' => 'f-type-s-v8',
									'id' => '3',
									'name' => 'F-TYPE S V8',
									'thumb' => 'jaguar-f-type-conv/convertible-s-v8/JAG_MOD_CONV_S_V8_450x259.jpg',
									'alt' => '. . .',
									'url_targer' => 'http://jaguar-mexico.com/mx/ftype/models/ftype-v8-s.php'
								)
							),
							'actions' => array(
								array(
									'return' => array(
										'href' => 'vehiculos/f-type'
									),
									'ficha_tecnica' => array(
										'href' => 'f-type/especificaciones_jaguar_f_type.pdf',
										'title' => 'Ficha-Técnica-F-Type.pdf'
									),
									'testdrive' => array(
										'href' => 'agenda/prueba-de-manejo/f-type-convertible'
									),
									'finacing' => array(
										'href' => 'financiamiento/f-type-convertible'
									)
								)
							)
						),
						array(
							'key' => 'f-type-coupe',
							'id' => '2',
							'name' => 'F-TYPE COUPÉ',
							'primary_header' => 'COUPÉ',
							'image_holder' => 'jaguar-f-type-coupe/previews/JAG_PREV_FTYPE_COUPE_1440x960.jpg',
							'descripcion' => array(
								array(
									'p' => 'UN DEPORTIVO GENUINAMENTE JAGUAR'
								),
								array(
									'p' => 'El F-TYPE es potente, ágil y elegante: un auténtico deportivo Jaguar diseñado para ofrecer unas prestaciones soberbias y una respuesta instantánea; el último descendiente de un linaje excepcional.'
								)
							),
							'banner' => array(
								array(
									'id' => '1',
									'alt' => 'PURO AUTOMÓVIL DEPORTIVO JAGUAR',
									'sliders' => array(
										'650' => 'JAG_FTYPE_COUPE_EXT_650x277.jpg',
										'900' => 'JAG_FTYPE_COUPE_EXT_900x586.jpg',
										'1600' => 'JAG_FTYPE_COUPE_EXT_1600x900.jpg'
									),
									'title' => 'F-TYPE COUPÉ',
									'subtitle' => 'PURO AUTOMÓVIL DEPORTIVO JAGUAR'
								),
								array(
									'id' => '2',
									'alt' => 'PODEROSAS FORMAS Y BELLAS PROPORCIONES.',
									'sliders' => array(
										'650' => 'JAG_FTYPE_COUPE_INT_650x277.jpg',
										'900' => 'JAG_FTYPE_COUPE_INT_900x586.jpg',
										'1600' => 'JAG_FTYPE_COUPE_INT_1600x900.jpg'
									),
									'title' => 'F-TYPE COUPÉ INTERIORES',
									'subtitle' => 'PODEROSAS FORMAS Y BELLAS PROPORCIONES.'
								)
							),
							'versiones' => array(
								array(
									'key' => 'f-type-coupe',
									'id' => '1',
									'name' => 'F-TYPE COUPÉ',
									'thumb' => 'jaguar-f-type-coupe/f-type/JAG_MOD_FTYPE_450x259.jpg',
									'alt' => 'El F-TYPE es un purasangre Jaguar capaz de disparar sus pulsaciones.',
									'url_target' => 'http://jaguar-mexico.com/mx/ftype/models/ftype-coupe-.php'
								),
								array(
									'key' => 'f-type-coupe-s',
									'id' => '2',
									'name' => 'F-TYPE COUPÉ S',
									'thumb' => 'jaguar-f-type-coupe/f-type-s/JAG_MOD_FTYPE_S_450x259.jpg',
									'alt' => 'Una conducción que seduce, un diseño cautivador y más potencia.',
									'url_target' => 'http://jaguar-mexico.com/mx/ftype/models/ftype-coupe-s.php'
								),
								array(
									'key' => 'f-type-s-v8',
									'id' => '3',
									'name' => 'F-TYPE S V8',
									'thumb' => 'jaguar-f-type-coupe/f-type-s-v8/JAG_MOD_FTYPE_S_V8_450x259.jpg',
									'alt' => 'El F-TYPE R es el coche deportivo definitivo.',
									'url_targer' => 'http://jaguar-mexico.com/mx/ftype/models/ftype-coupe-r.php'
								)
							),
							'actions' => array(
								array(
									'return' => array(
										'href' => 'vehiculos/f-type'
									),
									'ficha_tecnica' => array(
										'href' => 'f-type-coupe/especificaciones_jaguar_f_type_coupe.pdf"',
										'title' => 'Ficha-Técnica-F-Type_Coupe.pdf'
									),
									'testdrive' => array(
										'href' => 'agenda/prueba-de-manejo/f-type-coupe'
									),
									'finacing' => array(
										'href' => 'financiamiento/f-type-coupe'
									)
								)
							)
						)
					)
				)
			)
		);
	}
	public function getModelosArray() {
		return $this->modelosArray;
	}
	public function getModeloDetails($key) {
		$modelo = array();
		$condition = false;
		for ($idx = 0; $idx < count($this->modelosArray) && $condition == false;  $idx++) {
			$condition = ($key == $this->modelosArray[$idx]['key']);
			if ( $condition == true ) {
				$modelo = $this->modelosArray[$idx];
			}
		}
		return $modelo;
	}
}
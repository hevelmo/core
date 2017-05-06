<?php
class Producto {
	private $productoArray;
	function __construct() {
		$this->productoArray = array(
			array(
				'key' => 'xe',
				'id' => '1',
				'name' => 'XE',
				'thumb' => 'thumb-xe.png',
				'url_target' => 'agenda/prueba-de-manejo/xe',
				'target' => '_self'
			),
			array(
				'key' => 'xf',
				'id' => '2',
				'name' => 'XF',
				'thumb' => 'thumb-xf-2011.png',
				'url_target' => 'agenda/prueba-de-manejo/xf',
				'target' => '_self'
			),
			array(
				'key' => 'xj',
				'id' => '3',
				'name' => 'XJ',
				'thumb' => 'thumb-xj-2011.png',
				'url_target' => 'agenda/prueba-de-manejo/xj',
				'target' => '_self'
			),
			array(
				'key' => 'f-pace',
				'id' => '4',
				'name' => 'F-PACE',
				'thumb' => 'thumb-f-pace.png',
				'url_target' => 'agenda/prueba-de-manejo/f-pace',
				'target' => '_self'
			),
			array(
				'key' => 'f-type-convertible',
				'id' => '5',
				'name' => 'F-Type Convertible',
				'thumb' => 'thumb-ftype-convertible.png',
				'url_target' => 'agenda/prueba-de-manejo/f-type-convertible',
				'target' => '_self'
			),
			array(
				'key' => 'f-type-coupe',
				'id' => '6',
				'name' => 'F-Type Coupé',
				'thumb' => 'thumb-ftype-coupe.png',
				'url_target' => 'agenda/prueba-de-manejo/f-type-coupe',
				'target' => '_self'
			)
		);
	}
	public function getProductoArray() {
		return $this->productoArray;
	}
	public function getProductoDetails($key) {
		$producto = array();
		$condition = false;
		for ($idx = 0; $idx < count($this->productoArray) && $condition == false;  $idx++) {
			$condition = ($key == $this->productoArray[$idx]['key']);
			if ( $condition == true ) {
				$producto = $this->productoArray[$idx];
			}
		}
		return $producto;
	}
}
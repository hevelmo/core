<?php
class Navbar {
	private $navbarArray;
	function __construct() {
		$this->navbarArray = array(
			array(
				'key' => 'xe',
				'id' => '1',
				'name' => 'XE',
				'thumb' => 'thumb-xe.png',
				'url_externa' => array(
					'url_target' => 'http://www.jaguar-mexico.com/jaguar-range/xe/index.html'
				),
				'target' => '_blank'
			),
			array(
				'key' => 'xf',
				'id' => '2',
				'name' => 'XF',
				'thumb' => 'thumb-xf-2011.png',
				'url_interna' => array(
					'url_target' => 'vehiculos/xf'
				),
				'target' => '_self'
			),
			array(
				'key' => 'xj',
				'id' => '3',
				'name' => 'XJ',
				'thumb' => 'thumb-xj-2011.png',
				'url_interna' => array(
					'url_target' => 'vehiculos/xj'
				),
				'target' => '_self'
			),
			array(
				'key' => 'f-pace',
				'id' => '4',
				'name' => 'F-PACE',
				'thumb' => 'thumb-f-pace.png',
				'url_externa' => array(
					'url_target' => 'http://www.jaguar-mexico.com/jaguar-range/f-pace/index.html'
				),
				'target' => '_blank'
			),
			array(
				'key' => 'f-type',
				'id' => '5',
				'name' => 'F-Type',
				'thumb' => 'thumb-ftype.png',
				'url_interna' => array(
					'url_target' => 'vehiculos/f-type'
				),
				'target' => '_self'
			)
		);
	}
	public function getNavbarArray() {
		return $this->navbarArray;
	}
}
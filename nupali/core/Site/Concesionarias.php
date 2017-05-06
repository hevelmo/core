<?php
class Concesionarias {
	private $navbarArray;
	function __construct() {
		$this->navbarArray = array(
			array(
				'key' => 'guadalajara',
				'id' => '1',
				'name' => 'Jaguar Guadalajara',
			),
			array(
				'key' => 'country',
				'id' => '2',
				'name' => 'Jaguar Country',
			)
		);
	}
	public function getNavbarArray() {
		return $this->navbarArray;
	}
}
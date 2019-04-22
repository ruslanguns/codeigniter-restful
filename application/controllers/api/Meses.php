<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Meses extends CI_Controller {

	public function mes( $mes ) {

		$this->load->helper('utilidades');

		// $mes -= 1;
		// $meses = array(
		// 	'enero',
		// 	'febrero',
		// 	'marzo',
		// 	'abril',
		// 	'junio',
		// 	'julio',
		// 	'agosto',
		// 	'septiembre',
		// 	'octubre',
		// 	'noviemre',
		// 	'diciembre'
		// );
		
		echo json_encode( obtener_mes( $mes ));
		
		
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Blog extends CI_Controller {

        public function index()
        {
                echo 'Hello World!';
        }

        public function comments( $id )
        {
					
					if( !is_numeric( $id )) {

						$resp = array('err' => true, 'mensaje' => 'El ID tiene que ser numérico' );
						echo json_encode( $resp );

						return;
					}

					$comentarios = array(

						array( 'id' => 1, 'mensaje' => 'lorem ipsum dolor'),
						array( 'id' => 2, 'mensaje' => 'lorem ipsum dolor'),
						array( 'id' => 3, 'mensaje' => 'lorem ipsum dolor'),
						array( 'id' => 4, 'mensaje' => 'lorem ipsum dolor')
					);

					if( $id >= count( $comentarios ) OR $id < 0 ) {
						$resp = array('err' => true, 'mensaje' => 'El ID no existe' );
						echo json_encode( $resp );
						return;
					}
					
					echo json_encode( $comentarios[ $id ] );
				}
				
				
}

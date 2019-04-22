<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

//require APPPATH . '/libraries/MY_Form_validation.php';

use Restserver\libraries\REST_Controller;

require APPPATH . 'libraries/Format.php';

class Clientes extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('Cliente_model');
		$this->load->helper('utilidades');
	}

	public function index_get()
	{
		$this->load->helper('paginacion');

		$pagina = $this->uri->segment(2);
		$por_pagina = $this->uri->segment(3);

		$campos = array('id', 'nombre', 'telefono1');

		$respuesta = paginar_todo('clientes', $pagina, $por_pagina, $campos);
		$this->response($respuesta);
	}

	public function index_delete()
	{
		$cliente_id = $this->uri->segment(2);

		if (!isset($cliente_id)) {
			$respuesta = array(
				'err' => TRUE,
				'mensaje' => 'Es necesario el ID del cliente',
				'err_code' => 'HTTP_BAD_REQUEST'
			);

			$this->response($respuesta);

			return;
		}

		if (!is_numeric($cliente_id)) {
			$respuesta = array(
				'err' => false,
				'mensaje' => 'El ID debe ser numérico.',
				'cliente' => $cliente_id,
				'err_code' => 'HTTP_BAD_REQUEST'
			);
			$this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);

			return;
		}

		$respuesta = $this->Cliente_model->delete( $cliente_id );

		$this->response( $respuesta );
	}

	public function index_put()
	{
		$data = $this->put();

		$this->load->library('form_validation');
		$this->form_validation->set_data($data);

		//TRUE: Todo bien, FALSE: Falla alguna regla
		if ($this->form_validation->run('clientes_put')) {
			//Todo bien
			$cliente = $this->Cliente_model->set_datos($data);
			$respuesta = $cliente->insert();

			if ($respuesta['err']) {
				$this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
			} else {
				$this->response($respuesta);
			}
		} else {
			//Algo mal
			$respuesta = array(
				'err' => true,
				'mensaje' => 'Hay errores en el envío de información',
				'err_code' => 'HTTP_BAD_REQUEST',
				'errores' => $this->form_validation->get_errores_arreglo()
			);

			$this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_post()
	{
		$cliente_id = $this->uri->segment(2);
		
		$data = $this->post();
		$data['id'] = $cliente_id;

		$this->load->library('form_validation');
		
		$this->form_validation->set_data($data);


		//TRUE: Todo bien, FALSE: Falla alguna regla
		if ($this->form_validation->run('clientes_post')) {

			//Todo bien
			$cliente = $this->Cliente_model	->set_datos( $data );

			$respuesta = $cliente->update();

			if ($respuesta['err']) 
			{
				$this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
			} else {
				$this->response($respuesta);
			}
		} else {
			//Algo mal
			$respuesta = array(
				'err' => true,
				'mensaje' => 'Hay errores en el envío de información',
				'err_code' => 'HTTP_BAD_REQUEST',
				'errores' => $this->form_validation->get_errores_arreglo()
			);

			$this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
		}
	}


	public function cliente_get()
	{
		$cliente_id = $this->uri->segment(3);

		//Validacion del cliente_id
		if (!isset($cliente_id)) {
			$respuesta = array(
				'err' => true,
				'mensaje' => 'Es necesario el ID del cliente',
				'err_code' => 'HTTP_BAD_REQUEST'
			);

			$this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);

			return;
		}

		if (!is_numeric($cliente_id)) {
			$respuesta = array(
				'err' => false,
				'mensaje' => 'El ID debe ser numérico.',
				'cliente' => $cliente_id,
				'err_code' => 'HTTP_BAD_REQUEST'
			);
			$this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);

			return;
		}

		$cliente = $this->Cliente_model->get_cliente($cliente_id);

		if (isset($cliente)) {

			unset($cliente->telefono2); //Quitamos telefono2

			$respuesta = array(
				'err' => false,
				'mensaje' => 'Registro cargado correctamente.',
				'cliente' => $cliente,
				'err_code' => 'HTTP_OK'
			);
			$this->response($respuesta);
		} else {

			$respuesta = array(
				'err' => true,
				'mensaje' => 'El registro ' . $cliente_id . ' no existe.',
				'cliente' => null,
				'err_code' => 'HTTP_NOT_FOUND'
			);
			$this->response($respuesta, REST_Controller::HTTP_NOT_FOUND);
		}
	}
}

<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

use Restserver\libraries\REST_Controller;

class Clientes extends REST_Controller
{

	public function __construct()
	{

		header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    header("Access-Control-Allow-Origin: *");

		parent::__construct();
		$this->load->model('Cliente_model');
		$this->load->helper('utilidades');
	}

	/**
	 * Mostrar informacion de un cliente
	 * ----------------------------------
	 * @method: GET
	 * @example api/cliente/{id}
	 *
	 * @return void
	 */
	public function cliente_get($id)
	{

		// Load Authorization Token Library
		$this->load->library('Authorization_Token');

		/**
		 * User Token Validation
		 */
		$is_valid_token = $this->authorization_token->validateToken();
		if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {

				# Mostrar a un cliente


				# XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
				$cliente_id = $this->security->xss_clean($id);

				//Validacion del cliente_id
				if (!isset($cliente_id)) {
					$respuesta = array(
						'err' => true,
						'mensaje' => 'Es necesario el ID del cliente'
					);

					$this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);

					return;
				}

				if (!is_numeric($cliente_id)) {
					$respuesta = array(
						'err' => false,
						'mensaje' => 'El ID debe ser numérico.',
						'cliente' => $cliente_id
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
			} else {
			$this->response(['status' => FALSE, 'message' => $is_valid_token['message']], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	/**
	 * Mostrar lista completa de clientes
	 * ----------------------------------
	 * @method: GET
	 * @example /api/clientes
	 *
	 * @return void
	 */
	public function index_get()
	{


		// Load Authorization Token Library
		$this->load->library('Authorization_Token');

		/**
		 * User Token Validation
		 */
		$is_valid_token = $this->authorization_token->validateToken();
		if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {

			# Cargar lista de clientes

				$this->load->helper('paginacion');

				$pagina = $this->uri->segment(3);
				$por_pagina = $this->uri->segment(4);

				$campos = array('id', 'nombre', 'telefono1');

				$respuesta = paginar_todo('clientes', $pagina, $por_pagina, $campos);
				$this->response($respuesta);

			} else {

			$this->response(['status' => FALSE, 'message' => $is_valid_token['message']], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	/**
	 * Crear un nuevo cliente
	 * ----------------------------------
	 * @method: PUT
	 * @example /api/cliente/create
	 *
	 * @return void
	 */
	public function index_put()
	{

		// Load Authorization Token Library
		$this->load->library('Authorization_Token');

		/**
		 * User Token Validation
		 */
		$is_valid_token = $this->authorization_token->validateToken();
		if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {

				# Crear un cliente nuevo

				# XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
				$_POST = json_decode($this->security->xss_clean(file_get_contents("php://input")), true);

				$data = $this->put();

				// $this->load->library('form_validation'); // autoloaded dejo comentario para acordarme
				$this->form_validation->set_data($data);

				//TRUE: Todo bien, FALSE: Falla alguna regla
				if ($this->form_validation->run('clientes_put')) {
					//Todo bien
					$cliente = $this->Cliente_model->set_datos($data);
					$respuesta = $cliente->insert();

					if ($respuesta['err']) {
						$this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
					} else {
						$this->response($respuesta, REST_Controller::HTTP_OK);
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
			} else {
				$this->response(['status' => FALSE, 'message' => $is_valid_token['message']], REST_Controller::HTTP_NOT_FOUND);
			}
	}

	/**
	 * Actualizar/Modificar un cliente
	 * ----------------------------------
	 * @method: POST
	 * @example /api/cliente/{id}
	 *
	 * @return void
	 */
	public function index_post($id)
	{

		// Load Authorization Token Library
		$this->load->library('Authorization_Token');

		/**
		 * User Token Validation
		 */
		$is_valid_token = $this->authorization_token->validateToken();
		if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {
				
				# Create a client

				# XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
				$_POST = $this->security->xss_clean($_POST);

				# XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
				$cliente_id = $this->security->xss_clean($id);

				$data = $this->post();
				$data['id'] = $cliente_id;

				$this->form_validation->set_data($data);

				//TRUE: Todo bien, FALSE: Falla alguna regla
				if ($this->form_validation->run('clientes_post')) {

					//Todo bien
					$cliente = $this->Cliente_model->set_datos($data);

					$respuesta = $cliente->update();

					if ($respuesta['err']) {
							$this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
						} else {
						$this->response($respuesta, REST_Controller::HTTP_OK);
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
			} else {
			$this->response(['status' => FALSE, 'message' => $is_valid_token['message']], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	/**
	 * Eliminar a un cliente
	 * ----------------------------------
	 * @method: DELETE
	 * @example api/cliente/{id}/delete
	 *
	 * @return void
	 */
	public function index_delete($id)
	{

		// Load Authorization Token Library
		$this->load->library('Authorization_Token');

		/**
		 * User Token Validation
		 */
		$is_valid_token = $this->authorization_token->validateToken();
		if (!empty($is_valid_token) and $is_valid_token['status'] === TRUE) {

			# Eliminar a un cliente

			# XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
			$cliente_id = $this->security->xss_clean($id);

			// $cliente_id = $this->uri->segment(4);

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

			$respuesta = $this->Cliente_model->delete($cliente_id);

			$this->response($respuesta);
		} else {
			$this->response(['status' => FALSE, 'message' => $is_valid_token['message']], REST_Controller::HTTP_NOT_FOUND);
		}
	}
}

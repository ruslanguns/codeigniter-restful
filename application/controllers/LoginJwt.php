<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\libraries\REST_Controller;

require APPPATH . '/libraries/ImplementJwt.php';
require APPPATH . 'libraries/Format.php';

class LoginJwt extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->objOfJwt = new ImplementJwt();
	}

	public function LoginToken_get()
	{
		$tokenData['uniqueId'] = '55555';
		$tokenData['role'] = 'admin';
		$tokenData['timeStamp'] = Date('Y-m-d h:i:s');
		$jwtToken = $this->objOfJwt->GenerateToken($tokenData);

		$respuesta = array(
			'err' => false,
			'Token' => $jwtToken
		);

		$this->response($respuesta);
	}

	public function GetTokenData_get()
	{
		$tokenRecido = $this->input->request_headers('Authorization');

		if (!isset($tokenRecido)) {
			$respuesta = array(
				'err' => TRUE,
				'message' => 'Token no introducido'
			);

			return $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
		}

		try {
			$jwtData = $this->objOfJwt->DecodeToken($tokenRecido['Token']);

			$respuesta = array(
				'err' => FALSE,
				'result' => $jwtData
			);

			return $this->response($respuesta);

		} catch (Exception $e) {

			$respuesta = array(
				'err' => FALSE,
				'message' => $e->getMessage()
			);

			return $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
}

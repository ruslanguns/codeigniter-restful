<?php
require APPPATH . '/libraries/JWT.php';

class ImplementJwt
{

	// Generate token
	private $key = "mi_seed_segura";
	public function GenerateToken( $data )
	{
		$jwt = JWT::encode( $data, $this->key );
		return $jwt;
	}
	
	// Decode the token
	public function DecodeToken( $token )
	{
		$decoded = JWT::decode( $token, $this->key, array('HS256'));
		$decodedData = (array) $decoded;

		return $decodedData;
	}

}

?>

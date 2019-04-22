<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\libraries\REST_Controller;

require APPPATH . 'libraries/Format.php';

class Facturacion extends REST_Controller
{

    public function factura_get()
    {
        $factura_id = $this->uri->segment(3);
        $this->load->database();

        $this->db->where('factura_id', $factura_id);
        $query = $this->db->get('facturacion');
        $factura = $query->row();

        $this->db->reset_query();

        $this->db->where('factura_id', $factura_id);
        $query = $this->db->get('facturacion_detalle');
        $detalle = $query->result();

        $respuesta = array(
            'err' => false,
            'mensaje' => 'Factura cargada correctamente.',
            'factura' => $factura,
            'detalle' => $detalle,
        );

        $this->response($respuesta);
    }
}

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


$config = array(
    'clientes_put' => array(
        array('field' => 'correo', 'label' => 'correo electronico', 'rules' => 'trim|required|valid_email|max_length[255]'),
        array('field' => 'nombre', 'label' => 'nombre', 'rules' => 'trim|required|min_length[2]|max_length[255]'),
        array('field' => 'zip', 'label' => 'zip', 'rules' => 'trim|required|min_length[2]|max_length[5]')
		),
    'clientes_post' => array(
        array('field' => 'id', 'label' => 'cliente id', 'rules' => 'trim|required|integer'),
        array('field' => 'correo', 'label' => 'correo electronico', 'rules' => 'trim|required|valid_email|max_length[255]'),
        array('field' => 'nombre', 'label' => 'nombre', 'rules' => 'trim|required|min_length[2]|max_length[255]'),
        array('field' => 'zip', 'label' => 'zip', 'rules' => 'trim|required|min_length[2]|max_length[5]')
    )
);
?>

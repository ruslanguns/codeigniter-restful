<?php

class MY_Form_validation extends CI_Form_validation {

    function __construct($reglas = array()) {
        parent::__construct($reglas);
        $this->ci = & get_instance();
    }

    public function get_reglas() {
        return $this->_config_reglas;
    }

    public function get_errores_arreglo() {
        return $this->_error_array;
    }

    public function get_campos($form_data) {

        $nombres_campos = array();

        $reglas = $this->get_reglas();
        $reglas = $reglas[$form_data];

        foreach ($reglas as $i => $info) {
            $nombres_campos[] = $info['field'];
        }

        return $nombres_campos;
    }

}

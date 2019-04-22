<?php

function paginar_todo($tabla, $pagina = 1, $por_pagina = 20, $campos = array()) {

    //Cambio del this por CI, ya que estamos en un helper
    $CI = & get_instance();
    $CI->load->database();

    if (!isset($por_pagina) OR $por_pagina < 0) {
        $por_pagina = 20;
    }
    if (!isset($pagina) OR $pagina < 0) {
        $pagina = 1;
    }

    if (!is_numeric($pagina) OR ! is_numeric($por_pagina)) {
        $respuesta = array(
            'err' => TRUE,
            'mensaje' => 'Debe proporcionar valores numéricos para las paginaciones.',
            'err_code' => 'HTTP_BAD_REQUEST'
        );
        return $respuesta;
    }

    $cuantos = $CI->db->count_all($tabla);
    $total_pag = ceil($cuantos / $por_pagina);

    if ($pagina > $total_pag) {
        $pagina = $total_pag;
    }

    $pagina -= 1;
    $desde = $pagina * $por_pagina;

    //Pagina siguiente
    if ($pagina >= $total_pag - 1) {
        $pagina_siguiente = 1;
    } else {
        $pagina_siguiente = $pagina + 2;
    }

    //Pagina anterior
    if ($pagina < 1) {
        $pagina_anterior = $total_pag;
    } else {
        $pagina_anterior = $pagina;
    }

    $CI->db->select($campos);
    $query = $CI->db->get($tabla, $por_pagina, $desde);

    $respuesta = array(
        'err' => FALSE,
        'cuantos' => $cuantos,
        'total_paginas' => $total_pag,
        'pagina_actual' => ( $pagina + 1),
        'pagina_siguiente' => $pagina_siguiente,
        'pagina_anterior' => $pagina_anterior,
        $tabla => $query->result(),
        'err_code' => 'HTTP_OK'
    );

    return $respuesta;
}

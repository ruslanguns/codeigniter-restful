<?php

function capitalizar_todo( $data_cruda ){
    
    return capitalizar_arreglo( $data_cruda, array(), TRUE );
}

/**
 * Función para capitalizar arreglos
 * @param type $data_cruda Obtenemos el Array
 * @param type $campos_capitalizar Campos que capitalizaremos
 * @return type Regresa las palabras modificadas
 */
function capitalizar_arreglo($data_cruda, $campos_capitalizar = array(), $todos = FALSE ) {

    $data_lista = $data_cruda;

    //barrer arreglo
    foreach ($data_cruda as $nombre_campo => $valor_campo) {

        if ( in_array($nombre_campo, array_values($campos_capitalizar )) OR $todos ) {
            $data_lista[$nombre_campo] = strtoupper($valor_campo);
        }
    }

    return $data_lista;
}

function obtener_mes($mes) {

    $mes -= 1;
    $meses = array(
        'enero',
        'febrero',
        'marzo',
        'abril',
        'junio',
        'julio',
        'agosto',
        'septiembre',
        'octubre',
        'noviemre',
        'diciembre'
    );

    return $meses[$mes];
}

?>

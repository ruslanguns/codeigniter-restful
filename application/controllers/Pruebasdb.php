<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pruebasdb extends CI_Controller {

    /**
     * CONSTRUCTOR
     */
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('utilidades');
    }
    
    public function tabla(){
                  
//        $query = $this->db->get('clientes', 20, 0);
        
//        $query = $this->db->get_where('clientes', array('id' => 1));
//        foreach ($query->result() as $fila)
//        {
//            echo $fila->nombre . '<br />';
//        }
        
//        $this->db->select_max('id', 'id_maximo');
//        $this->db->select_min('id', 'id_minimo');
//        $this->db->select_avg('id', 'id_promedio');
//        $this->db->select_sum('id', 'id_sumatoria');
//        $query = $this->db->get('clientes');
        
//        $this->db->distinct();
        
//        $this->db->select('pais');
//        $this->db->select('pais, COUNT(*) AS Cantidad_clientes');
//        $this->db->from('clientes');
        
        
//        $this->db->where('id', 1);
//        $this->db->where('activo', 1);
//        $this->db->where('id !=', 1);
//        $this->db->where('id <', 10);
//        $this->db->where('id < 10');
        
//        $this->db->where('id', '1');
//        $this->db->or_where('id', '2');
//        $this->db->or_where('id', '3');
        
//        $ids = array(1,2,3,4,5);       
//        $this->db->where_in('id', $ids);
//        $this->db->where_not_in('id', 3);
        
//        $this->db->like('nombre', 'STAR', 'both' );
        
//        $this->db->group_by('pais');
        
//        $this->db->order_by('pais', 'ASC');
//        $this->db->limit(20);
//        echo $this->db->count_all_results();
//        echo '<br />';
//        echo $this->db->count_all('clientes');
                
//        $query = $this->db->get();
//        foreach ( $query->result() as $fila ) 
//        {
//            echo $fila->pais . '<br />';
//        }
        
//        echo json_encode( $query->result() );
    }
    
    public function eliminar(){
        
        $this->db->where('id', 1);
        $this->db->delete('test');
        
        echo "EL REGISTRO FUE ELIMINADO";
    }
    
    public function actualizar(){
        
        $data = array(
            'nombre' => 'Victor',
            'apellido' => 'Martinez'
        );
        
        $data = capitalizar_todo( $data );

        $this->db->where('id', 1);
        $this->db->update('test', $data );
        
        echo "Todo OK";
    }    
    
    public function insertar(){
//        $data = array(
//        'nombre' => 'Ruslan',
//        'apellido' => 'Gonzalez'
//        );
//        
////        $data = capitalizar_arreglo($data, array(), TRUE );
//        $data = capitalizar_todo( $data );
//
//        $this->db->insert('test', $data);
//        
//        $respuesta = array(
//            'err' => FALSE,
//            'id_insertado' => $this->db->insert_id()
//        );
//        
//        echo json_encode( $respuesta );
        
        /**
         * INSERTAR MULTIPLES ARREGLOS
         */
        $data = array(
            array(
                'nombre' => 'Ilse',
                'apellido' => 'Schwarzberger'
            ),
            array(
                'nombre' => 'Elizabeth',
                'apellido' => 'Gonzalez'
            )
        );
        
        $this->db->insert_batch('test', $data );
        
        echo $this->db->affected_rows();
    }
    
    

    public function clientes_beta() {

        $query = $this->db->query('SELECT id, nombre, correo, telefono1 FROM clientes');

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Registros cargados correctamente.',
            'total_registros' => $query->num_rows(),
            'Clientes' => $query->result()
        );
        echo json_encode($respuesta);
    }

    public function cliente($id) {

        $query = $this->db->query('SELECT * FROM clientes WHERE id = ' . $id);

        $fila = $query->row(); //de lo que obtenga regresa una fila

        if (isset($fila)) {
            //FILA EXISTE
            $respuesta = array(
                'err' => FALSE,
                'mensaje' => 'Registros cargado correctamente.',
                'total_registro' => 1,
                'Cliente' => $fila
            );
        } else {
            //FILA NO EXISTE
            $respuesta = array(
                'err' => true,
                'mensaje' => 'El registro con el id ' . $id . ', no existe.',
                'total_registro' => 0,
                'Cliente' => null
            );
        }
        echo json_encode($respuesta);
    }

}

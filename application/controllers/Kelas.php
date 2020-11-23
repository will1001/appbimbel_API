<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Kelas extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
         $this->load->database();
    }

    public function index_post()
    {
        $data = array(
                    'deskripsi' => $this->post('deskripsi')
                );

        $insert = $this->db->insert('kelas', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }
    public function index_put()
    {
        $id = $this->put('id');
        $data = array(
                    'deskripsi' => $this->put('deskripsi')
                );
        $this->db->where('id', $id);
        $update = $this->db->update('kelas', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_delete()
    {
        $id = $this->delete('id');
        $this->db->where('id', $id);
        $delete = $this->db->delete('kelas');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id = $this->get( 'id' );
        
        $jsonData = $this->db->get('kelas')->result();
        if ( $id === null )
        {
            // Check if the users data store contains users
            if ( $jsonData )
            {
                // Set the response and exit
                $this->response( $jsonData, 200 );
            }
            else
            {
                // Set the response and exit
                $this->response( [
                    'status' => false,
                    'message' => 'No users were found'
                ], 404 );
            }
        }
        else
        {
            
            if ( array_key_exists( $id, $jsonData ) )
            {
                $this->db->select("*");
                $this->db->from("kelas");
                $this->db->where('id', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
            else
            {
                $this->response( [
                    'status' => false,
                    'message' => 'No such user found'
                ], 404 );
            }
        }
    }
}
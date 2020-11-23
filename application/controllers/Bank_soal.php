<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Bab_soal extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
         $this->load->database();
    }

    public function index_post()
    {
        date_default_timezone_set('Hongkong');
        $data = array(
                    'soal' => $this->post('soal'),
                    'pil_a' => $this->post('pil_a'),
                    'pil_b' => $this->post('pil_b'),
                    'pil_c' => $this->post('pil_c'),
                    'pil_d' => $this->post('pil_d'),
                    'pil_e' => $this->post('pil_e'),
                    'tipe_soal' => $this->post('tipe_soal'),
                    'jawaban' => $this->post('jawaban'),
                    'pembahasan' => $this->post('pembahasan'),
                    'id_mapel' => $this->post('id_mapel'),
                    'id_tingkat_kesulitan' => $this->post('id_tingkat_kesulitan'),
                    'id_kelas' => $this->post('id_kelas'),
                    'id_bab_soal' => $this->post('id_bab_soal'),
                    'create_at' => date("Y-m-d H:i:s")
                );

        $insert = $this->db->insert('bab_soal', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }
    public function index_put()
    {
        date_default_timezone_set('Hongkong');
        $id = $this->put('id');
        $data = array(
                    'soal' => $this->put('soal'),
                    'pil_a' => $this->put('pil_a'),
                    'pil_b' => $this->put('pil_b'),
                    'pil_c' => $this->put('pil_c'),
                    'pil_d' => $this->put('pil_d'),
                    'pil_e' => $this->put('pil_e'),
                    'tipe_soal' => $this->put('tipe_soal'),
                    'jawaban' => $this->put('jawaban'),
                    'pembahasan' => $this->put('pembahasan'),
                    'id_mapel' => $this->put('id_mapel'),
                    'id_tingkat_kesulitan' => $this->put('id_tingkat_kesulitan'),
                    'id_kelas' => $this->put('id_kelas'),
                    'id_bab_soal' => $this->put('id_bab_soal'),
                    'update_at' => date("Y-m-d H:i:s")
                );
        $this->db->where('id', $id);
        $update = $this->db->update('bab_soal', $data);
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
        $delete = $this->db->delete('bab_soal');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id = $this->get( 'id' );
        
        $jsonData = $this->db->get('bab_soal')->result();
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
                $this->db->from("bab_soal");
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
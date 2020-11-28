<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class bank_soal extends RestController {

    function __construct()
    {
        // Construct the parent class
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
        parent::__construct();
         $this->load->database();
    }

    public function index_post()
    {
        $id = $this->post( 'id' );

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

        

        if($id === null){
            $insert = $this->db->insert('bank_soal', $data);
            if ($insert) {
                $this->response($data, 200);
            } else {
                $this->response(array('status' => 'fail', 502));
            }
            
        }else{
            $this->db->where('id', $id);
            $delete = $this->db->delete('bank_soal');
            if ($delete) {
                $this->response(array('status' => $id), 201);
            } else {
                $this->response(array('status' => 'fail', 502));
            }
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
                    'update_at' => date("Y-m-d H:i:s")
                );
        $this->db->where('id', $id);
        $update = $this->db->update('bank_soal', $data);
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
        $delete = $this->db->delete('bank_soal');
        if ($delete) {
            $this->response(array('status' => $id), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id = $this->get( 'id' );
        $id_mapel = $this->get( 'id_mapel' );
        $id_kelas = $this->get( 'id_kelas' );
        $id_bab_soal = $this->get( 'id_bab_soal' );
        $id_tingkat_kesulitan = $this->get( 'id_tingkat_kesulitan' );
        
        $jsonData = $this->db->get('bank_soal')->result();
        if ( $id === null )
        {
            // Check if the datas data store contains datas
            if ( $jsonData )
            {
                // Set the response and exit
                $this->db->select("*");
                $this->db->from("bank_soal");
                $this->db->where('id_mapel', $id_mapel);
                $this->db->where('id_kelas', $id_kelas);
                $this->db->where('id_bab_soal', $id_bab_soal);
                $this->db->where('id_tingkat_kesulitan', $id_tingkat_kesulitan);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
            else
            {
                // Set the response and exit
                $this->response( [
                    'status' => false,
                    'message' => 'No datas were found'
                ], 404 );
            }
        }
        else
        {
                $this->db->select("*");
                $this->db->from("bank_soal");
                $this->db->where('id', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}
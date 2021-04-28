<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Review extends RestController {

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
        date_default_timezone_set('Hongkong');
        $data = array(
            'judul' => $this->post('judul'),
            'link_video' => $this->post('link_video'),
            'id_kelas' => $this->post('id_kelas'),
            'id_mapel' => $this->post('id_mapel'),
            'id_bab' => $this->post('id_bab'),
            'create_at' => date("Y-m-d H:i:s")
        );

        $insert = $this->db->insert('review', $data);
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
            'judul' => $this->put('judul'),
            'link_video' => $this->put('link_video'),
            'id_kelas' => $this->put('id_kelas'),
            'id_mapel' => $this->put('id_mapel'),
            'id_bab' => $this->put('id_bab'),
            'update_at' => date("Y-m-d H:i:s")
        );
        $this->db->where('id', $id);
        $update = $this->db->update('review', $data);
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
        $delete = $this->db->delete('review');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
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
        
        $jsonData = $this->db->get('review')->result();
        if ( $id === null )
        {
            // Check if the datas data store contains datas
             if ( count($jsonData) == 0 )
            {
                // Set the response and exit
                $this->response( [
                    'status' => false,
                    'message' => 'No datas were found'
                ], 404 );
            }
            else
            {
                if($id_mapel !== null && $id_kelas !== null && $id_bab_soal !== null){
                    $this->db->select("*");
                    $this->db->from("review");
                    $this->db->where('id_mapel', $id_mapel);
                    $this->db->where('id_kelas', $id_kelas);
                    $this->db->where('id_bab', $id_bab_soal);
                    $jsonData = $this->db->get()->result();
                    $this->response( $jsonData, 200 );
                }else{
                    // Set the response and exit
                    $this->response( $jsonData, 200 );
                }
            }
        }
        else
        {
                $this->db->select("*");
                $this->db->from("review");
                $this->db->where('id', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}
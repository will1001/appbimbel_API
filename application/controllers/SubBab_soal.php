<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class SubBab_soal extends RestController {

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
                    'nomor' => $this->post('nomor'),
                    'deskripsi' => $this->post('deskripsi'),
                    'id_bab' => $this->post('id_bab'),
                    'create_at' => date("Y-m-d H:i:s")
                );

        $insert = $this->db->insert('sub_bab_soal', $data);
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
        $data_nomor = $this->put('data_nomor');
        $data;
        $update;
        if($data_nomor !== null){
            $data = $data_nomor;
            $update =  $this->db->update_batch('sub_bab_soal', $data, 'id');}
        else{
                $data = array(
                    'nomor' => $this->put('nomor'),
                    'deskripsi' => $this->put('deskripsi'),
                    'id_bab' => $this->put('id_bab'),
                    'update_at' => date("Y-m-d H:i:s")
                );
                $this->db->where('id', $id);
                $update = $this->db->update('sub_bab_soal', $data);
            }
        
        
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
        $delete = $this->db->delete('sub_bab_soal');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id = $this->get( 'id' );
        $id_mapel = $this->get( 'id_bab' );
        
        $jsonData = $this->db->get('sub_bab_soal')->result();
        if ( $id === null )
        {
            // Check if the datas data store contains datas
            if ( $jsonData && $id_mapel == null )
            {
                // Set the response and exit
                $this->db->select("*,sub_bab_soal.id as id,bab_soal.deskripsi as bab,sub_bab_soal.deskripsi as sub_bab");
                $this->db->from("sub_bab_soal");
                $this->db->join('bab_soal','bab_soal.id = sub_bab_soal.id_bab');
                $this->db->order_by('nomor', 'ASC');
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
            else {
                $this->db->select("*");
                $this->db->from("sub_bab_soal");
                $this->db->where('id_bab', $id_mapel);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
        }
        else
        {
                $this->db->select("*");
                $this->db->from("sub_bab_soal");
                $this->db->where('id', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;


class Paket_soal extends RestController {

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
                    'deskripsi' => $this->post('deskripsi'),
                    'waktu' => $this->post('waktu'),
                    'tipe' => $this->post('tipe'),
                    'id_mapel' => $this->post('id_mapel'),
                    'id_bab' => $this->post('id_bab'),
                    'id_kelas' => $this->post('id_kelas'),
                    'id_level' => $this->post('id_level'),
                    'create_at' => date("Y-m-d H:i:s")
                );

        $insert = $this->db->insert('paket_soal', $data);
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
        $update_jml_soal = $this->put('update_jml_soal');
        $data;
        if($update_jml_soal === "true"){
            $data = array(
                    'jml_soal' => $this->put('jml_soal'),
                    'update_at' => date("Y-m-d H:i:s")
                );
        }
        else{
            $data = array(
                    'waktu' => $this->put('waktu'),
                    'id_mapel' => $this->put('id_mapel'),
                    'id_bab' => $this->put('id_bab'),
                    'id_kelas' => $this->put('id_kelas'),
                    'id_level' => $this->put('id_level'),
                    'update_at' => date("Y-m-d H:i:s")
                );
        }
        
        $this->db->where('id', $id);
        $update = $this->db->update('paket_soal', $data);
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
        $delete = $this->db->delete('paket_soal');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id = $this->get( 'id' );
        $tipe = $this->get( 'tipe' );
        $id_mapel = $this->get( 'id_mapel' );
        $id_kelas = $this->get( 'id_kelas' );
        $id_bab = $this->get( 'id_bab' );
        
        $jsonData = $this->db->get('paket_soal')->result();
        if ( $id === null )
        {
            // Check if the datas data store contains datas
            if ( count($jsonData) == 0 )
            {
                // Set the response and exit
                $this->response( [
                    'status' => false,
                    'message' => count($jsonData)
                ], 404 );
            }
            else
            {
                // Set the response and exit
                if($tipe === null){

                    $this->response( $jsonData, 200 );
                }else if($id_mapel !== null && $id_kelas !== null && $id_bab !== null && $tipe !== null){
                    $this->db->select("*");
                    $this->db->from("paket_soal");
                    $this->db->where('id_mapel', $id_mapel);
                    $this->db->where('id_kelas', $id_kelas);
                    $this->db->where('id_bab', $id_bab);
                    $this->db->where('tipe', $tipe);
                    $jsonData = $this->db->get()->result();
                    $this->response( $jsonData, 200 );
                }else{
                    $this->db->select("paket_soal.id,paket_soal.deskripsi,mapel.deskripsi as mapel,kelas.deskripsi as kelas,bab_soal.deskripsi as bab,tingkat_kesulitan.deskripsi as level,waktu,jml_soal,tipe,paket_soal.create_at,paket_soal.update_at,paket_soal.id_mapel,id_kelas,id_bab,id_level");
                    $this->db->from("paket_soal");
                    $this->db->join('mapel', 'mapel.id = paket_soal.id_mapel','left');
                    $this->db->join('kelas', 'kelas.id = paket_soal.id_kelas','left');
                    $this->db->join('bab_soal', 'bab_soal.id = paket_soal.id_bab','left');
                    $this->db->join('tingkat_kesulitan', 'tingkat_kesulitan.id = paket_soal.id_level','left');
                    $this->db->where('tipe', $tipe);
                    $jsonData = $this->db->get()->result();
                    $this->response( $jsonData, 200 );
                }
            }
        }
        else
        {
                $this->db->select("*");
                $this->db->from("paket_soal");
                $this->db->where('id', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}
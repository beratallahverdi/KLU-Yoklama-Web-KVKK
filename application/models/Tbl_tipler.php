<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tbl_tipler extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }
    public function dersTipleriniAl(){
        return $this->db->get("tbl_derstip")->result_array();
    }
    public function devamDurumlariniAl(){
        return $this->db->get("tbl_devamdurum")->result_array();
    }
}
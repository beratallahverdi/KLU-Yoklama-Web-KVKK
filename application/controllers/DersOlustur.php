<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DersOlustur extends CI_Controller {
    public $data;

    public function __construct(){
        parent::__construct();
        $this->data = array("title" => "Ders Oluştur");
        $this->data["dersler"] = $this->danisman->dersleriAl($this->session->userdata["SICIL_NO"]);
        $this->data["ders_tip"] = $this->tipler->dersTipleriniAl();
    }

	public function index()
	{
        $this->load->view("template/head",$this->data);
        $this->load->view("dersolustur_form", $this->data);
        $this->load->view("template/foot", $this->data);
        $this->load->view("template/init_datetimepicker", $this->data);
        $this->load->view("template/init_googlemap", $this->data);
    }
    public function BelirtilenDersiOlustur($dersHareketId){
        $this->data["secili_ders"] = $dersHareketId;
        $this->data["ongorulen_ders"] = $this->dersler->ongorulenDersBilgileriniAl($dersHareketId);
        $this->load->view("template/head",$this->data);
        $this->load->view("dersolustur_form", $this->data);
        $this->load->view("template/foot", $this->data);
        $this->load->view("template/init_datetimepicker", $this->data);
        $this->load->view("template/init_googlemap", $this->data);
    }
    public function Submit(){
        foreach($_POST as $k => $v){
            if($v == null || $v == ''){
                redirect(base_url()."DersOlustur");
            }
        }
        if($this->dersler->dersAc($_POST) == true){
            redirect(base_url("Dersler"));
        }
    }
}
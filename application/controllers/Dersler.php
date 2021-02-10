<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dersler extends CI_Controller {
    public $data;
    private $view = "dersler_cardview";

    public function __construct(){
        parent::__construct();
        $this->data = array("title" => "Dersler","izin"=>true);
    }

	public function index()
	{
        $this->data["dersler"] = $this->danisman->dersleriAl($this->session->userdata["SICIL_NO"]);
        $this->load->view("template/head",$this->data);
        $this->load->view("dersler_cardview", $this->data);
        $this->load->view("template/foot", $this->data);
    }
    public function AcilanDersOgrencileriniGoster($acilanDersId){
        $this->data["title"] = $this->dersler->acilanDersAdiniAl($acilanDersId);
        $this->data["ogrenciler"] = $this->dersler->acilanDersOgrencileriniAl($acilanDersId);
        $this->data["acilanDersId"] = $acilanDersId;
        $this->data["ders"] = $this->dersler->acilanDersinBilgileriniAl($acilanDersId);
        $this->load->view("template/head",$this->data);
        $this->load->view("dersogrenciler_table", $this->data);
        $this->load->view("template/foot", $this->data);
    }
    public function AcilanDersleriGoster($dersHareketId){
        $this->data["dersler"] = $this->dersler->acilanDerslerinBilgileriniAl($dersHareketId);
        $this->data["title"] = $this->data["dersler"][0]["DERS_ADI"];
        $this->data["secili_ders"] = $dersHareketId;
        $this->load->view("template/head",$this->data);
        $this->load->view("acilandersler_cardview", $this->data);
        $this->load->view("template/foot", $this->data);
    }
    public function Sorumlular($dersHareketId){
        $this->data["dersler"] = $this->dersler->acilanDerslerinBilgileriniAl($dersHareketId);
        $this->data["sorumlular"] = $this->dersler->dersinSorumluBilgileriniAl($dersHareketId);
        $sorumlu_sicil = $this->dersler->dersinSorumlusu($dersHareketId);
        $this->data["secili_ders"] = $dersHareketId;
        $this->data["sorumlu"] = ($this->session->userdata["SICIL_NO"] === $sorumlu_sicil) ? true : false;
        $this->data["title"] = $this->data["sorumlular"][0]["DERS"];
        $this->load->view("template/head",$this->data);
        $this->load->view("sorumlulardersler_cardview", $this->data);
        $this->load->view("template/foot", $this->data);
    }
    public function SorumluYetkiKaldirma($dersHareketId,$sicilNo){
        $this->danisman->dersYetkisiGeriAl($dersHareketId, $sicilNo);
    }
    public function YardimciEkle(){
        $this->form_validation->set_rules('yardimciEmail', 'YardimciEmail', 'required|trim');
        if($this->form_validation->run()){
            $email = $this->input->post('yardimciEmail');
            $dersHareketId = $this->input->post('dersHareketId');
            if($this->danisman->dersYetkisiEkle($dersHareketId,$email) == true){
                redirect(base_url("Dersler/Sorumlular/".$dersHareketId));
            }
        }
    }
}
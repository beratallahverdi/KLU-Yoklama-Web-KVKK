<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Example extends CI_Controller {
    public $data;

    public function __construct(){
        parent::__construct();
        
        $this->data[] = array("ADI"=>"DAMLA", "SOYADI"=>"KUŞKU", "OGR_NO"=>"1160505045");
        $this->data[] = array("ADI"=>"ERTUĞRUL BERAT", "SOYADI"=>"ALLAHVERDİ", "OGR_NO"=>"1160505048");
        //$this->data[] = $this->dersler->getAcilanDers(1);
        //$this->data[] = $this->qrkod->createQrCode($this->dersler->getAcilanDers(1));
        //$this->data[] = $this->danisman->ekle("doganunal");
        //$this->data[] = $this->dersler->acilanDersOgrencileriniAl(1);
        //$this->data[] = $this->danisman->al("782");
        $session_data = array(
            'AD'            => "MURAT OLCAY",
            'SOYAD'         => "ÖZCAN",
            'UNVAN'         => "DR. ÖĞR. ÜYESİ",
            'TC_KIMLIK_NO'  => "35764703454",
            'SICIL_NO'      => "0956",
            'TIP'           => 1
        );
        $this->session->set_userdata($session_data);
        

       
        //$this->data[] = $this->ogrenci->ekle("1160505045");
    }
    public function index(){
        
    }
    public function decode($var){
        $var = strtr($var,array('.' => '+', '-' => '=', '~' => '/'));
        $array[0] = explode("&",base64_decode($var));
        foreach($array[0] as $v){
            $va = explode("=",$v);
            $array[$va[0]] = $va[1];
        }
        unset($array[0]);
        echo "<pre>";
        print_r(array_merge($array,$_GET));
        echo "</pre>";
    }
}
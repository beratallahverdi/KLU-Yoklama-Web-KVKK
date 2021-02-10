<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tbl_ogrenciler extends CI_Model{
    private $table_name = "tbl_ogrenciler";

    public function __construct()
    {
        parent::__construct();
    }

    public function al($ogrenci_no){
        $q = $this->db->where("OGR_NO", $ogrenci_no)->get($this->table_name);
        return ($q->num_rows() > 0) ? $q->result_array()[0] : "Ogrenci Bulunamadi";
    }
    
    public function ekle($ogrenci_no){
        $d = $this->curl->sorgu(array("tip"=>1, "no"=>$ogrenci_no),7);
        $n["OGR_NO"] = $d["OGR_NO"];
        $n["TCKIMLIKNO"] = $d["TCKIMLIKNO"];
        $n["KIMLIK_AD"] = $d["KIMLIK_AD"];
        $n["KIMLIK_SOYAD"] = $d["KIMLIK_SOYAD"];
        $n["KIMLIK_DTARIH"] = $d["KIMLIK_DTARIH"];
        $n["E_POSTA"] = $d["E_POSTA"];
        $n["TELEFON"] = $d["TELEFON"];
        $n["CINSIYET"] = $d["CINSIYET"];
        //$n["CINSIYET"] = ($d["CINSIYET"] == 1)? "ERKEK" : "KADIN";
        $n["FAK_KOD"] = $d["FAK_KOD"];
        $n["BOL_ID"] = $d["BOL_ID"];
        $n["PROG_ID"] = $d["PROG_ID"];
        $n["OGR_FOTO_URL"] = $d["OGR_FOTO_URL"];
        $this->db->replace($this->table_name, $n);
        return $d;
    }
    public function dersiAlanOgrenciler($ders_hareket_id){
        $d = $this->curl->sorgu(array("ders_haraket_id"=>$ders_hareket_id),12);
        $ogrenciler = array();
        if($d["durum"] == 'ok'){
            unset($d["durum"]);
            if(!isset($d[0])){
                $temp = $d;
                $d = array();
                $d[0] = $temp;
            }
            foreach($d as $k => $v){
                $ogrenci["OGR_NO"] = $v["OGR_NO"];
                $ogrenci["GSM1"] = $v["GSM1"];
                $ogrenciler[] = $ogrenci;
            }
        }
        return $ogrenciler;
    }
}
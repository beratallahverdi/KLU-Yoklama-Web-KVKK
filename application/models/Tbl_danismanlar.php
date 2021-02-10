<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tbl_danismanlar extends CI_Model{
    private $table_name = "tbl_danismanlar";

    public function __construct()
    {
        parent::__construct();
    }
    
    function giris($email, $password){
        $tam_email = $email;
        $process_f=$this->curl->sorgu(array('kul_adi'=>$email, 'sifre'=>$password), 19);
        if(isset($process_f['durum']) && $process_f['durum'] == 'ok') {
            if($cursor = strpos($email,'@')){
                $email = substr($email, 0, $cursor);
            }
            else{
                $email=$email;
            }
            $process_s = $this->curl->sorgu(array('tip'=>2,'veri'=>$email), 4);
            $tc_kimlik = $process_s[0]['tc'];
            if(isset($process_s['durum']) && $process_s['durum'] == 'ok' && !$this->dogrula($tc_kimlik)){
                $process_t = $this->curl->sorgu(array('tip'=>2, 'veri'=>$tc_kimlik), 6);
                if(isset($process_t['durum']) && $process_t['durum']=='ok'){
                    if(!$this->dogrula($tc_kimlik)){
                        $this->ekle($tam_email);
                        $this->dogrula($tc_kimlik);
                    }
                    else{
                        return true;
                    }
                }
                else{
                    redirect(base_url() . 'Giris/error/OgretmenDegil');
                }
            }
            else{
                redirect(base_url() . 'Giris/error/PersonelDegil');
            }
        }
        else{
            redirect(base_url() . 'Giris/error/YetkisizDeneme');
        }
    }
    function supergiris($email, $password){
        $process_f=$this->curl->sorgu(array('kul_adi'=>"eds@klu.edu.tr", 'sifre'=>$password), 19);
        if(isset($process_f['durum']) && $process_f['durum'] == 'ok') {
            if($cursor = strpos($email,'@')){
                $email = substr($email, 0, $cursor);
            }
            else{
                $email=$email;
            }
            $process_s = $this->curl->sorgu(array('tip'=>2,'veri'=>$email), 4);
            $tc_kimlik = $process_s[0]['tc'];
            //$tc_kimlik = "16061497048";
            if(isset($process_s['durum']) && $process_s['durum'] == 'ok' && !$this->dogrula($tc_kimlik)){
                $process_t = $this->curl->sorgu(array('tip'=>2, 'veri'=>$tc_kimlik), 6);
                if(isset($process_t['durum']) && $process_t['durum']=='ok'){
                    if(!$this->dogrula($tc_kimlik)){

                    }
                    else{
                        return true;
                    }
                }
                else{
                    redirect(base_url() . 'Giris/error/OgretmenDegil');
                }
            }
            else{
                redirect(base_url() . 'Giris/error/PersonelDegil');
            }
        }
        else{
            redirect(base_url() . 'Giris/error/YetkisizDeneme');
        }
    }
    function dogrula($tcno){
        $this->db->where('TC_KIMLIK_NO', $tcno);
        $query = $this->db->get($this->table_name);
        if($query->num_rows() > 0)
        {
            $result = $query->result()[0];
            $tarih=array('SON_GIRIS'=>date(DATE_W3C));
            $this->db->set($tarih);
            $this->db->where('TC_KIMLIK_NO',$tcno);
            $this->db->update($this->table_name);
            
            $session_data = array(
                'AD'            => $result->ADI,
                'SOYAD'         => $result->SOYADI,
                'UNVAN'         => $result->UNVAN,
                'TC_KIMLIK_NO'  => $result->TC_KIMLIK_NO,
                'SICIL_NO'      => $result->SICIL_NO,
                'TIP'           => 1
            );
            $this->session->set_userdata($session_data);
            redirect(base_url() . 'Dersler/');
        }
        else{
             return false;
        }
    }
    public function al($data){
        $q = $this->db->where("SICIL_NO", $data)->or_where("TC_KIMLIK_NO", $data)->get($this->table_name);
        return ($q->num_rows() > 0) ? $q->result_array()[0] : "Akademisyen Bulunamadi";
    }

    public function kontrol($data){
        $q = $this->db->where("SICIL_NO", $data)->or_where("TC_KIMLIK_NO", $data)->get($this->table_name);
        return ($q->num_rows() > 0) ? true : false;
    }

    public function ekle($email){
        $auth = $this->curl->sorgu(array('tip'=>2,'veri'=>$email), 4);
        if(isset($auth['durum']) && $auth['durum'] == 'ok'){
            $tc_kimlik_no = $auth[0]['tc'];
            $d = $this->curl->sorgu(array('tip'=>2, 'veri'=>$tc_kimlik_no), 6);
            $n["SICIL_NO"] = $d["SICIL_NO"];
            $n["TC_KIMLIK_NO"] = $d["TC_KIMLIK_NO"];
            $n["UNVAN"] = $d["UNVAN"];
            $n["ADI"] = $d["ADI"];
            $n["SOYADI"] = $d["SOYADI"];
            $n["EPOSTA"] = $d["EPOSTA"];
            $n["EPOSTA2"] = $d["EPOSTA2"];
            $n["GSM1"] = $d["GSM1"];
            $n["GMS2"] = $d["GMS2"];
            $n["FAK_KOD"] = $d["FAK_KOD"];
            $n["BOLUM_ID"] = $d["BOLUM_ID"];
            $n["PROG_ID"] = $d["PROG_ID"];
            $this->db->replace($this->table_name, $n);
            $dersler = $this->dersler->ekle($d["SICIL_NO"]);
            return array_merge(array("DANISMAN" => $n), $dersler);
        }
        else{
            redirect(base_url()."Hata/AkademisyenDegildir");
        }
    }
    
    public function dersleriAl($sicil_no){
        $q = $this->db->query("
        SELECT d.*, ad.DERS_BASLANGIC, ad.DERS_BITIS, ad.SON_DERS
        FROM
            (SELECT 
                dd.DERS_HAR_ID as DERS_HAREKET, 
                d.DERS_KODU, 
                d.DERS_ADI, 
                f.ad as FAKULTE, 
                p.ad AS PROGRAM, 
                d.DERS_TEORIK as TEORIK, 
                d.DERS_UYGULAMA AS UYGULAMA 
            FROM 
                tbl_dersler as d, 
                tbl_danismandersler as dd, 
                tbl_fakulteler as f, 
                tbl_bolumler as b, 
                tbl_programlar as p
            WHERE 
                dd.SICIL_NO = '".$sicil_no."' AND 
                dd.DERS_KODU=d.DERS_KODU AND 
                dd.PROG_ID = d.PROG_ID AND 
                d.PROG_ID=p.id AND 
                d.BOLUM_ID=b.id AND 
                d.FAK_KOD= f.id) d LEFT JOIN 
            (SELECT 
                a.DERS_BASLANGIC, 
                a.DERS_BITIS,
                a.ID as SON_DERS, 
                a.DERS_HAR_ID as DERS_HAREKET
            FROM tbl_acilandersler as a 
            GROUP BY DERS_HAREKET
            ORDER BY a.DERS_BASLANGIC DESC) ad 
        ON d.DERS_HAREKET = ad.DERS_HAREKET
        ORDER BY d.FAKULTE ASC, d.PROGRAM, d.DERS_KODU ASC, ad.SON_DERS DESC
        ");
        return ($q->num_rows() > 0) ? $q->result_array(): "Dersleri Bulunmamaktadır.";
    }
    public function dersYetkisiGeriAl($dersHareketId, $sicilNo){
        $this->db->where("DERS_HAR_ID",$dersHareketId)->where("SICIL_NO",$sicilNo)->where("SORUMLU",0)->delete("tbl_danismandersler");
        redirect(base_url()."Dersler/Sorumlular/".$dersHareketId);
    }
    public function dersYetkisiEkle($dersHareketId,$email){
        if($cursor = strpos($email,'@')){
            $email = substr($email, 0, $cursor);
        }
        else{
            $email=$email;
        }
        $personel_ldap = $this->curl->sorgu(array('tip'=>2,'veri'=>$email), 4);
        if(isset($personel_ldap['durum']) && $personel_ldap['durum'] == 'ok' && !$this->kontrol($personel_ldap[0]["tc"])){
            $personel = $this->curl->sorgu(array('tc'=>$personel_ldap[0]["tc"]),3);
            if(isset($personel["durum"]) && $personel["durum"] == 'ok'){
                $eklenen_veri = array(
                    "SICIL_NO" => $personel["personelKurumsicilno"],
                    "TC_KIMLIK_NO" => $personel_ldap[0]["tc"],
                    "UNVAN" => $personel["personelUnvanKisaltma"],
                    "ADI" => $personel["personelAd"],
                    "SOYADI" => $personel["personelSoyad"],
                    "EPOSTA" => ($personel["personelKurumemail"])? $personel["personelKurumemail"] : "",
                    "EPOSTA2" => ($personel["personelKisiselemail"])? $personel["personelKisiselemail"]:"",
                    "GSM1" => ($personel["personelCeptel1"]) ? $personel["personelCeptel1"] : "",
                    "GMS2" => "",
                    "FAK_KOD" => 0,
                    "BOLUM_ID" => 0,
                    "PROG_ID" => 0
                );  
                $this->veridenEkle($eklenen_veri);
            }
        }
        $d = $this->db->where("DERS_HAR_ID",$dersHareketId)->get("tbl_danismandersler")->result_array()[0];
        $h = $this->al($personel_ldap[0]["tc"]);
        unset($d["ID"],$d["SICIL_NO"]);
        $d["SICIL_NO"] = "".$h["SICIL_NO"]."";
        $d["SORUMLU"] = 0;
        if($this->db->insert("tbl_danismandersler",$d)){
            return true;
        }
        else{
            return false;
        }
    }
    public function veridenEkle($array){
        $this->db-> replace($this->table_name, $array);
    }
}
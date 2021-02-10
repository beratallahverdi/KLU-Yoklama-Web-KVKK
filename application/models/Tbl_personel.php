<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tbl_personel extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }
  function giris($email, $password){
      $process_f=$this->curl->sorgu(array('kul_adi'=>$email, 'sifre'=>$password), 19);
      if(isset($process_f['durum']) && $process_f['durum'] == 'ok') {
        //$email = 'fatih.aydin';
        //$email = 'moozcan';
        //$email = 'ozge.ozcan';
        //$email = 'hakanustunel';
          if($cursor = strpos($email,'@')){
              $email = substr($email, 0, $cursor);
          }
          else{
              $email=$email;
          }
          $process_s = $this->curl->sorgu(array('tip'=>2,'veri'=>$email), 4);
          $tc_kimlik = $process_s[0]['tc'];
          //$tc_kimlik = "16061497048";
          if(isset($process_s['durum']) && $process_s['durum'] == 'ok' && !$this->db_personel->kontrol($tc_kimlik)){
              
              $process_t = $this->curl->sorgu(array('tip'=>2, 'veri'=>$tc_kimlik), 6);
              if(isset($process_t['durum']) && $process_t['durum']=='ok'){
                  if(!$this->db_personel->kontrol($tc_kimlik)){
                      $this->db_personel->ekle($tc_kimlik);
                      $this->db_personel->kontrol($tc_kimlik);
                  }
                  else{
                      
                      return true;
                  }
              }
              else{
                  redirect(base_url() . 'Login/error/OgretmenDegil');
              }
          }
          else{
              redirect(base_url() . 'Login/error/PersonelDegil');
          }
      }
      else{
          redirect(base_url() . 'Login/error/YetkisizDeneme');
      }
  }
  function supergiris($email, $password){
      $process_f=$this->curl->sorgu(array('kul_adi'=>"eds@klu.edu.tr", 'sifre'=>$password), 19);
      if(isset($process_f['durum']) && $process_f['durum'] == 'ok') {
        //$email = 'fatih.aydin';
        //$email = 'moozcan';
        //$email = 'ozge.ozcan';
          if($cursor = strpos($email,'@')){
              $email = substr($email, 0, $cursor);
          }
          else{
              $email=$email;
          }
          $process_s = $this->curl->sorgu(array('tip'=>2,'veri'=>$email), 4);
          $tc_kimlik = $process_s[0]['tc'];
          //$tc_kimlik = "16061497048";
          if(isset($process_s['durum']) && $process_s['durum'] == 'ok' && !$this->db_personel->kontrol($tc_kimlik)){
              
              $process_t = $this->curl->sorgu(array('tip'=>2, 'veri'=>$tc_kimlik), 6);
              if(isset($process_t['durum']) && $process_t['durum']=='ok'){
                  if(!$this->db_personel->kontrol($tc_kimlik)){
                      $this->db_personel->ekle($tc_kimlik);
                      $this->db_personel->kontrol($tc_kimlik);
                  }
                  else{
                      
                      return true;
                  }
              }
              else{
                  redirect(base_url() . 'Login/error/OgretmenDegil');
              }
          }
          else{
              redirect(base_url() . 'Login/error/PersonelDegil');
          }
      }
      else{
          redirect(base_url() . 'Login/error/YetkisizDeneme');
      }
  }
  public function ozelgiris($email, $password){
      $this->db->select('SIFRE, SICIL_NO');
      $this->db->where('EPOSTA', $email);
      $query = $this->db->get('db_ozelpersonel');
      if($query->num_rows() > 0){
          $result = $query->result();
          if(!strcmp($result[0]->SIFRE, hash('sha512', $password))){
              $this->db_personel->ozelkontrol($result[0]->SICIL_NO);
          }
          else{
              redirect(base_url() . 'Login/error/YetkisizDeneme#admin');
          }
      }
      else{
          redirect(base_url() . 'Login/error/YetkisizDeneme#admin');
      }
  }
  function al(){
      $this->db->where('TC_KIMLIK_NO', $this->session->userdata['tc']);
      $query = $this->db->get('db_personel');
      if($query->num_rows()>0){
      	  $query=$query->result();
          $query[0]->FAK_KOD=$this->db_birimler->getFakulteAd($query[0]->FAK_KOD);
          $query[0]->BOLUM_ID=$this->db_birimler->getBolumAd($query[0]->BOLUM_ID);
          $query[0]->PROG_ID=$this->db_birimler->getProgramAd($query[0]->PROG_ID);
          return $query[0];
      }
      $this->db->where('TC_KIMLIK_NO', $this->session->userdata['tc']);
      $query = $this->db->get('db_ozelpersonel');
    
      if($query->num_rows()>0){
      	  $query=$query->result();
          $query[0]->FAK_KOD=$this->db_birimler->getFakulteAd($query[0]->FAK_KOD);
          $query[0]->BOLUM_ID=$this->db_birimler->getBolumAd($query[0]->BOLUM_ID);
          $query[0]->PROG_ID=$this->db_birimler->getProgramAd($query[0]->PROG_ID);
          return $query[0];
      }
      return NULL;
  }
  function ekle($veri){
      $veriler = $this->curl->sorgu(array('tip'=>2,'veri'=>$veri), 6);
      unset($veriler['durum']);unset($veriler['FAK_AD']);unset($veriler['BOL_AD']);unset($veriler['PROG_AD']);
      $this->db->insert('db_personel', $veriler);
  }
  function guncelle(){
      $veriler=$this->curl->sorgu(array('tip'=>2,'veri'=>$this->session->userdata['tc']), 6);
      unset($veriler['durum']);unset($veriler['FAK_AD']);unset($veriler['BOL_AD']);unset($veriler['PROG_AD']);
      $this->db->set($veriler);
      $this->db->where('TC_KIMLIK_NO', $this->session->userdata['tc']);
      $this->db->update('db_personel');
  }
    function kontrol($tcno){
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
  function ozelkontrol($sicil){
      $this->db->where('SICIL_NO', $sicil);
      $query = $this->db->get('db_ozelpersonel');
      if($query->num_rows() > 0)
      {
          $result = $query->result();
          $tarih=array('SON_GIRIS'=>date(DATE_W3C));
          $this->db->set($tarih);
          $this->db->where('SICIL_NO',$sicil);
          $this->db->update('db_ozelpersonel');
          $session_data = array(
            'ad' =>  $result[0]->ADI,
            'soyad' =>  $result[0]->SOYADI,
            'email' =>  $result[0]->EPOSTA,
            'tc' =>  $result[0]->TC_KIMLIK_NO,
            'sicil' =>  $result[0]->SICIL_NO,
            'prog_id' => $result[0]->PROG_ID,
            'prog_ad' => "",
            'donem' => $this->db_birimler->getLastDonem(),
            'tip' => 1
        );
            $this->session->set_userdata($session_data);
            redirect(base_url() . 'PersonalInfo/');
      }
      else{
           return false;
      }
  }
  public function verilenDerslerGuncelle($sicil){
    $veri = $this->curl->sorgu(array('sicil'=>$sicil), 11);
    if($veri['durum']=='ok'){
        unset($veri['durum']);
        $sorgu=array();
        if(!isset($veri[0])){
            $temp = $veri;
            $veri = array("0"=>$temp);
        }
        $kayitli_dersler = $this->db->select("DERS_HAR_ID,SICIL_NO")->where("SICIL_NO",$sicil)->get("db_verilendersler")->result_array();
        $sayi=count($veri);
        for($i=0;$i<$sayi;$i++){
            $flag=false;
            foreach($kayitli_dersler as $k => $v){
                if($veri[$i]["DERS_HAR_ID"] == $v["DERS_HAR_ID"]){
                    $flag=true;
                    unset($kayitli_dersler[$k]);
                }
            }
            if($flag){ unset($veri[$i]); continue;}
            //unset($veri[$i]["DERS_HAR_ID"]);
            unset($veri[$i]["DERS_SUBE_KOD"]);
            unset($veri[$i]["KREDI"]);
            unset($veri[$i]["DERS_ADI"]);
            unset($veri[$i]["AKTS"]);
            unset($veri[$i]["DERS_TEORIK"]);
            unset($veri[$i]["DERS_UYGULAMA"]);

            $idler = $this->db_birimler->getIdlerFromProgramveFakulte($veri[$i]['FAK_AD'], $veri[$i]['PROG_AD']);
            $veri[$i]["PROG_ID"] = $idler["PROG_ID"];

            unset($veri[$i]["PROG_AD"]);
            unset($veri[$i]["FAK_AD"]);
            $veri[$i]["SICIL_NO"]=$sicil;
            $this->db->replace('db_verilendersler',$veri[$i]);
        }
        redirect(base_url() . 'PersonalInfo/');
    }
    else{
        redirect(base_url() . "Hata/HocaninVerdigiDerslerBulunamadi");
        //header('Refresh: 3;url='. base_url() .'Logout');
        //redirect(base_url() . "Hata/index/HocaninVerdigiDerslerBulunamadi");
    }
  }
}
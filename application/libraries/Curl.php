<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Curl{
    public function baglan($sorgu){
        $gelen_sorgu=http_build_query($sorgu);
        $parametre=array();
        $on_sorgu=http_build_query($parametre);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://ws.klu.edu.tr/projeler/index.php?");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,60);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $on_sorgu.'&'.$gelen_sorgu);
        $sonuc= curl_exec($ch);
        return $sonuc;
    }

    public function sorgu($liste, $durum){
      switch($durum){
        case '1':
          $liste['istek'] = 'sms';
          break;
        case '2':
          $liste['istek'] = 'eposta';
          break;
        case '3':
          $liste['istek'] = 'personel_sorgulama';
          break;
        case '4':
          $liste['istek'] = 'personel_ldap_sorgulama';
          break;
        case '5':
          $liste['istek'] = 'personel_birimleri';
          break;
        case '6':
          $liste['istek'] = 'obs_personel_sorgulama';
          break;
        case '7':
          $liste['istek'] = 'ogrenci_sorgulama';
          break;
        case '8':
          $liste['istek'] = 'ogrenci_birimleri';
          break;
        case '9':
          $liste['istek'] = 'akademik_danismanlik';
          break;
        case '10':
          $liste['istek'] = 'akademik_ders_programi';
          break;
        case '11':
          $liste['istek'] = 'akademik_verilen_dersler';
          break;
        case '12':
          $liste['istek'] = 'akademik_ders_alan_ogrenciler';
          break;
        case '13':
          $liste['istek'] = 'akademik_sinav_programi';
          break;
        case '14':
          $liste['istek'] = 'ogrenci_alinan_dersler';
          break;
        case '15':
          $liste['istek'] = 'ogrenci_danisman';
          break;
        case '16':
          $liste['istek'] = 'ogrenci_ders_programi';
          break;
        case '17':
          $liste['istek'] = 'ogrenci_sinav_notlari';
          break;
        case '18':
          $liste['istek'] = 'ogrenci_sinav_programi';
          break;
        case '19':
          $liste['istek'] = 'kullanici_girisi';
          break;
        case '20':
          $liste['istek'] = 'akademik_ders_etkinlik';
          break;
        case '21':
          $liste['istek'] = 'akademik_ders_etkinlik_hd';
          break;
        case '22':
          $liste['istek'] = 'akademik_ders_etkinlik_puan_sonuc';
          break;
        case '23':
          $liste['istek'] = 'akademik_donemler';
          break;
        case '24':
          $liste['istek'] = 'akademik_programlar';
          break;
        case '25':
          $liste['istek'] = 'akademik_program_dersler';
          break;
        default:
          break;
      }
      $result = $this->baglan($liste);
      $veriler = json_decode($result, TRUE);
      if($veriler['durum'] == 'ok'){
          return $veriler;
      }
      else{
          return $veriler['mesaj'];
      }
    }
}
?>
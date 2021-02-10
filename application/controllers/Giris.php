<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Giris extends CI_Controller {

  public $data;

  public function __construct(){
    parent::__construct();
    if(isset($this->session->userdata["SICIL_NO"]) && !empty($this->session->userdata["SICIL_NO"])){
      redirect(base_url("Dersler"));
    }
    $this->data['title']= 'Giriş Sayfası';
  }
    public function index(){
      $this->load->view('login_form',$this->data);
    }
    public function action(){
      $this->form_validation->set_rules('email', 'Email', 'required|trim');
      $this->form_validation->set_rules('password', 'Password', 'required|trim');
      if($this->form_validation->run()){
        $email = $this->input->post('email').$_POST["mail_subfix"];
        $password = $this->input->post('password');
        $eds=strstr($email,"@");
        $super_email=strstr($email,"@",true);
        if($eds=="@eds" && !preg_match('~[0-9]~', $super_email)){
          $this->danisman->supergiris($super_email,$password);
        }
        else{
          $this->danisman->giris($email, $password);
        }
      }
      else{
        $this->data['title']= 'Kalite Sistemi';
        $this->load->view('login_form',$this->data);
      }
    }

    public function error($errorCode){
        $this->data['title']= 'Kalite Sistemi';
        switch ($errorCode) {
          case 'YetkisizDeneme':
            $this->data['mesaj'] = 'Sistem Tarafindan Gecerli Olmayan Eposta Adresi veya Sifre';
            break;
          case 'YetkiliDegil':
            $this->data['mesaj'] = 'Yetkili Olmayan Kullanıcı Girişi';
            break;
          case 'YetkiliKisitlandi':
        	$this->data["mesaj"] = "Sistemde Bakım Çalışması Vardır Daha Sonra Tekrar Deneyiniz.";
            break;
          case 'PersonelDegil':
            $this->data['mesaj'] = 'Belirtilen Kullanici Personelimiz Degildir.';
          break;
          case 'OgretmenDegil':
            $this->data['mesaj'] = 'Belirtilen Kullanici Ogretim Gorevlimiz Degildir.';
          break;
          case 'OgretmenKisitlandi':
        	  $this->data["mesaj"] = "Sistemde Bakım Çalışması Vardır Daha Sonra Tekrar Deneyiniz.";
            break;
          default:
            $this->data['mesaj']=$errorCode;
          break;
        }
        $this->load->view('login_form',$this->data);
    }
}
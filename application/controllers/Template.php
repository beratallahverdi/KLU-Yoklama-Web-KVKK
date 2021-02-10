<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends CI_Controller {
    public $data;
    private $view = "dersler_cardview";

    public function __construct(){
        parent::__construct();
        $this->data = array("title" => "Dersler");
    }

	public function index()
	{
        
        $this->data["dersler"] = $this->danisman->dersleriAl($this->session->userdata["SICIL_NO"]);
        $this->load->view("template/head",$this->data);
        $this->load->view($this->view, $this->data);
        $this->load->view("template/foot", $this->data);
    }
}
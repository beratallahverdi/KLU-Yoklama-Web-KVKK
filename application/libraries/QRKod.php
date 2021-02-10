<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include(APPPATH.'third_party/phpqrcode/qrlib.php');
class QRKod{
	public function createQrCode($array){
		//$get_sorgu = "ID=".$array["ID"]."&DERS_HAR_ID=".$array["DERS_HAR_ID"]."&";
		$get_sorgu = "";
		foreach($array as $k => $v){
			$get_sorgu .= $k."=".$v."&";
		}
		$get_sorgu = base64_encode(substr($get_sorgu,0,-1));
		$get_sorgu = "https://domain.com/Example/decode/".strtr($get_sorgu,array('+' => '.', '=' => '-', '/' => '~'));
		// generating
		QRcode::png($get_sorgu, FCPATH."qrcodes/".$array["ID"].".png", QR_ECLEVEL_M, 4);
		//echo $get_sorgu;
		return FCPATH."qrcodes/".$array["ID"].".png";
	}
}
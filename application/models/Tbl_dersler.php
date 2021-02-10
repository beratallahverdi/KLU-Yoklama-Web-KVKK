<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tbl_dersler extends CI_Model{
   
    public function __construct()
    {
        parent::__construct();
    }

    public function ekle($sicil_no){
        $d = $this->curl->sorgu(array("sicil"=>$sicil_no),11);
        $dersler = array();$danismandersler = array();
        if($d["durum"] == 'ok'){
            unset($d["durum"]);
            if(!isset($d[0])){
                $temp = $d;
                $d = array();
                $d[0] = $temp;
            }
            foreach($d as $k => $v){
                $ders["DERS_KODU"] = $v["DERS_KODU"];
                $ders["DERS_ADI"] = $v["DERS_ADI"];
                $ders["AKTS"] = $v["AKTS"];
                $ders["DERS_TEORIK"] = $v["DERS_TEORIK"];
                $ders["DERS_UYGULAMA"] = $v["DERS_UYGULAMA"];
                $ders = array_merge($ders, $this->db->query("SELECT f.id as FAK_KOD, b.id as BOLUM_ID, p.id as PROG_ID FROM tbl_fakulteler as f, tbl_bolumler as b, tbl_programlar as p WHERE f.id = b.ustid AND b.id = p.ustid AND f.ad LIKE '%".$v["FAK_AD"]."%' AND p.ad LIKE '%".$v["PROG_AD"]."%' ORDER BY p.ad ASC;")->result_array()[0]);
                $danismanders["DERS_HAR_ID"] = $v["DERS_HAR_ID"];
                $danismanders["DERS_KODU"] = $ders["DERS_KODU"];
                $danismanders["PROG_ID"] = $ders["PROG_ID"];
                $danismanders["SICIL_NO"] = $sicil_no;
                $dersler[] = $ders;
                $danismandersler[] = $danismanders;
            }
        }
        if(!empty($dersler)){
            foreach($dersler as $ders){
                $this->db->replace("tbl_dersler", $ders);
            }
        }
        if(!empty($danismandersler)){
            $this->db->delete("tbl_danismandersler",array("SICIL_NO"=>$sicil_no));
            $this->db->insert_batch("tbl_danismandersler",$danismandersler);
        }
        return array("DERSLER" => $dersler, "DANISMAN_DERSLER" => $danismandersler);
    }

    public function acilanDersOgrencileriniAl($acilanDersId){
		$q = $this->db  ->select("od.OGR_NO as NUMARA, od.ADI, od.SOYADI, od.GSM1 AS TELEFON, od.KONUM_ENLEM AS ENLEM, od.KONUM_BOYLAM AS BOYLAM, od.KONUM_TARIH AS TARIH, od.KONUM_GSM AS GONDERILEN, de.DURUM")
						->from("tbl_ogrencidevam as od, tbl_devamdurum as de")
        				->where("od.ACILANDERS_ID", $acilanDersId)
                        ->where("od.DEVAM_DURUM=de.ID")
                        ->order_by("od.OGR_NO")
                        ->get();
        return ($q->num_rows()>0) ? $q->result_array() : "Öğrenci Bulunamadı";
    }
    /* 
    SELECT  WHERE ad.DERS_HAR_ID=dd.DERS_HAR_ID AND dd.DERS_KODU=d.DERS_KODU AND dd.PROG_ID=d.PROG_ID AND ad.ID='1'
    */
    public function getAcilanDers($acilanDersId){
        $q = $this->db    ->select("*")
                            ->from("tbl_acilandersler as ad")
                            ->where("ad.ID",$acilanDersId)
                            ->get();
        return ($q->num_rows()>0) ? $q->result_array()[0] : "Açılan Ders Bulunamadı";
    }
    public function acilanDersAdiniAl($acilanDersId){
        return $this->db    ->select("CONCAT(d.DERS_KODU,' / ',d.DERS_ADI,' / ',p.ad) AS DERS")
                            ->from("tbl_acilandersler as ad, tbl_danismandersler as dd, tbl_dersler as d, tbl_programlar as p")
                            ->where("ad.DERS_HAR_ID=dd.DERS_HAR_ID")
                            ->where("dd.DERS_KODU=d.DERS_KODU")
                            ->where("dd.PROG_ID=d.PROG_ID")
                            ->where("p.id=d.PROG_ID")
                            ->where("ad.ID",$acilanDersId)
                            ->get()
                            ->result_array()[0]["DERS"];
    }
    
    public function dersAc($data){
        $temp["DERS_HAR_ID"] = $data["DERS_HAREKET"];
        $temp["SICIL_NO"] = $this->session->userdata["SICIL_NO"];
        $temp["DERS_BASLANGIC"] = $data["BASLANGIC"];
        $temp["DERS_BITIS"] = $data["BITIS"];
        $temp["DERS_ENLEM"] = $data["ENLEM"];
        $temp["DERS_BOYLAM"] = $data["BOYLAM"];
        $temp["DERS_TIP"] = $data["TIP"];
        $this->db->insert("tbl_acilandersler",$temp);
        $this->db->query("UPDATE tbl_acilandersler as ad SET ad.DERS_BITIS=DATE_ADD(ad.DERS_BASLANGIC,INTERVAL 1 HOUR) WHERE ad.DERS_BITIS <= ad.DERS_BASLANGIC");
        unset($temp["DERS_ENLEM"],$temp["DERS_BOYLAM"],$temp["DERS_BITIS"]);
        $incremented_id = $this->db->where($temp)->order_by("ID DESC")->get("tbl_acilandersler")->result_array()[0]["ID"];
        $d = $this->curl->sorgu(array("ders_haraket_id"=>$temp["DERS_HAR_ID"]),12);
        if($d["durum"] == 'ok'){
            unset($d["durum"]);
            if(!isset($d[0])){
                $temp = $d;
                $d = array();
                $d[0] = $temp;
            }
            foreach($d as $k => $v){
                $ogrenci["OGR_NO"] = $v["OGR_NO"];
                $ogrenci["ADI"] = $v["ADI"];
                $ogrenci["SOYADI"] = $v["SOYADI"];
                $ogrenci["GSM1"] = $v["GSM1"];
                $ogrenci["ACILANDERS_ID"] = $incremented_id;
                $ogrenciler[] = $ogrenci;
            }
        }
        if(!empty($ogrenciler)){
            $this->db->insert_batch("tbl_ogrencidevam",$ogrenciler);
            $this->qrkod->createQrCode($this->getAcilanDers($incremented_id));
            redirect(base_url("Dersler/AcilanDersOgrencileriniGoster/".$incremented_id));
        }
        else{
            return "Öğrenciler Derse Eklenemedi";
        }
    }
    /*
        SELECT 
            ad.ID AS ACILAN_DERS, 
            ad.DERS_BASLANGIC AS BASLANGIC, 
            ad.DERS_BITIS AS BITIS, 
            dt.TIP AS DERS_TIP, 
            d.DERS_ADI, 
            d.DERS_TEORIK as TEORIK, 
            d.DERS_UYGULAMA AS UYGULAMA, 
            CONCAT(dan.UNVAN,' ',dan.ADI,' ',dan.SOYADI) AS DANISMAN, 
            f.ad AS FAKULTE, 
            b.ad AS BOLUM, 
            p.ad AS PROGRAM
        FROM 
            tbl_acilandersler as ad,
            tbl_danismandersler as dd,
            tbl_dersler as d,
            tbl_programlar as p,
            tbl_fakulteler as f,
            tbl_bolumler as b,
            tbl_derstip as dt,
            tbl_danismanlar as dan
        WHERE 
            ad.DERS_TIP=dt.ID AND 
            ad.DERS_HAR_ID=dd.DERS_HAR_ID AND 
            dd.DERS_KODU=d.DERS_KODU AND 
            dd.PROG_ID=d.PROG_ID AND
            d.PROG_ID=p.id AND 
            d.FAK_KOD=f.id AND 
            d.BOLUM_ID=b.id AND 
            dan.SICIL_NO=ad.SICIL_NO AND
            dd.DERS_HAR_ID='1166618'
        ORDER BY ad.DERS_BASLANGIC DESC
     */
    public function acilanDerslerinBilgileriniAl($dersHareketId){
        $q = $this->db  ->select("ad.ID AS ACILAN_DERS, ad.DERS_BASLANGIC AS BASLANGIC, ad.DERS_BITIS AS BITIS, 
                                dt.TIP AS DERS_TIP, d.DERS_KODU, d.DERS_ADI, d.DERS_TEORIK as TEORIK, d.DERS_UYGULAMA AS UYGULAMA, 
                                CONCAT(dan.UNVAN,' ',dan.ADI,' ',dan.SOYADI) AS DANISMAN, f.ad AS FAKULTE, 
                                b.ad AS BOLUM, p.ad AS PROGRAM")
                        ->from("tbl_acilandersler as ad, tbl_danismandersler as dd, tbl_dersler as d,
                                tbl_programlar as p, tbl_fakulteler as f, tbl_bolumler as b,
                                tbl_derstip as dt, tbl_danismanlar as dan")
                        ->where("ad.DERS_TIP=dt.ID AND ad.DERS_HAR_ID=dd.DERS_HAR_ID AND dd.DERS_KODU=d.DERS_KODU AND 
                                dd.PROG_ID=d.PROG_ID AND d.PROG_ID=p.id AND d.FAK_KOD=f.id AND d.BOLUM_ID=b.id AND 
                                dan.SICIL_NO=ad.SICIL_NO")
                        ->where("dd.DERS_HAR_ID",$dersHareketId)
                        ->group_by("ad.ID")
                        ->order_by("ad.DERS_BASLANGIC DESC")
                        ->get();
        return ($q->num_rows()>0) ? $q->result_array() : "Açılan Dersler Bulunamadı";
    }

    public function ongorulenDersBilgileriniAl($dersHareketId){
        $q = $this->db  ->select("ad.ID AS ACILAN_DERS, DATE_ADD(ad.DERS_BASLANGIC, INTERVAL 7 DAY) AS ZAMAN_BASLANGIC,DATE_ADD(ad.DERS_BITIS, INTERVAL 7 DAY) AS ZAMAN_BITIS, ad.DERS_ENLEM,ad.DERS_BOYLAM,ad.DERS_TIP")
                        ->from("tbl_acilandersler as ad")
                        ->where("ad.DERS_HAR_ID",$dersHareketId)
                        ->group_by("ad.ID")
                        ->order_by("ad.DERS_BASLANGIC DESC")
                        ->get();
        return ($q->num_rows()>0) ? $q->result_array()[0] : "Önceden Açılmış Ders Bulunamadı";
    }

    public function acilanDersinBilgileriniAl($acilanDersId){
        $q = $this->db  ->select("ad.ID AS ACILAN_DERS, ad.DERS_BASLANGIC AS BASLANGIC, ad.DERS_BITIS AS BITIS, 
                                dt.TIP AS DERS_TIP, d.DERS_KODU, d.DERS_ADI, d.DERS_TEORIK as TEORIK, d.DERS_UYGULAMA AS UYGULAMA, 
                                CONCAT(dan.UNVAN,' ',dan.ADI,' ',dan.SOYADI) AS DANISMAN, f.ad AS FAKULTE, 
                                b.ad AS BOLUM, p.ad AS PROGRAM")
                        ->from("tbl_acilandersler as ad, tbl_danismandersler as dd, tbl_dersler as d,
                                tbl_programlar as p, tbl_fakulteler as f, tbl_bolumler as b,
                                tbl_derstip as dt, tbl_danismanlar as dan")
                        ->where("ad.DERS_TIP=dt.ID AND ad.DERS_HAR_ID=dd.DERS_HAR_ID AND dd.DERS_KODU=d.DERS_KODU AND 
                                dd.PROG_ID=d.PROG_ID AND d.PROG_ID=p.id AND d.FAK_KOD=f.id AND d.BOLUM_ID=b.id AND 
                                dan.SICIL_NO=ad.SICIL_NO")
                        ->where("ad.ID",$acilanDersId)
                        ->order_by("ad.DERS_BASLANGIC DESC")
                        ->get();
        return ($q->num_rows()>0) ? $q->result_array()[0] : "Açılan Dersler Bulunamadı";
    }
    /*
        SELECT 
            CONCAT(d.DERS_KODU,' / ',d.DERS_ADI,' / ', p.ad) AS DERS, 
            CONCAT(dm.UNVAN,' ',dm.ADI,' ',dm.SOYADI) AS DANISMAN, 
            dm.EPOSTA, 
            dm.GSM1 AS TELEFON, 
            dd.DERS_HAR_ID 
        FROM 
            tbl_danismanlar as dm, 
            tbl_danismandersler as dd, 
            tbl_dersler as d, 
            tbl_programlar as p 
        WHERE 
            dm.SICIL_NO=dd.SICIL_NO AND 
            d.DERS_KODU=dd.DERS_KODU AND 
            d.PROG_ID=dd.PROG_ID AND 
            p.id=d.PROG_ID AND 
            dd.DERS_HAR_ID=1166622
     */
    public function dersinSorumluBilgileriniAl($dersHareketId){
        $q = $this->db  ->select("CONCAT(d.DERS_KODU,' / ',d.DERS_ADI,' / ', p.ad) AS DERS")
                        ->select("CONCAT(dm.UNVAN,' ',dm.ADI,' ',dm.SOYADI) AS DANISMAN")
                        ->select("dm.EPOSTA, dm.GSM1 AS TELEFON, dd.DERS_HAR_ID, dd.SORUMLU, dd.SICIL_NO")
                        ->from("tbl_danismanlar as dm, tbl_danismandersler as dd")
                        ->from("tbl_dersler as d, tbl_programlar as p")
                        ->where("dm.SICIL_NO=dd.SICIL_NO")
                        ->where("d.DERS_KODU=dd.DERS_KODU")
                        ->where("d.PROG_ID=dd.PROG_ID")
                        ->where("p.id=d.PROG_ID")
                        ->where("dd.DERS_HAR_ID",$dersHareketId)
                        ->order_by("dd.SORUMLU DESC")
                        ->get();
        return ($q->num_rows()>0) ? $q->result_array() : "Ders Bulunamadı";
    }
    public function dersinSorumlusu($dersHareketId){
        $q = $this->db  ->select("SICIL_NO")->where("DERS_HAR_ID",$dersHareketId)->where("SORUMLU",1)->get("tbl_danismandersler");
        return ($q->num_rows()>0) ? $q->result_array()[0]["SICIL_NO"] : "Sorumlu Bulunamadı";
    }
}
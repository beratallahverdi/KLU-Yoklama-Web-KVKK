<form class="w-100" method="POST" action="<?php echo base_url();?>DersOlustur/Submit">
    <div class="form-group row">
        <label for="chooseDersHareket" class="col-2 col-form-label">Ders Seçiniz:</label>
        <div class="col-10">
            <select class="form-control" id="chooseDersHareket" name="DERS_HAREKET">
            <?php foreach($dersler as $k => $v){?>
                <option value="<?php echo $v["DERS_HAREKET"];?>" <?php if(isset($secili_ders) && $v["DERS_HAREKET"] == $secili_ders){echo "selected='selected'";}?>>
                    <?php echo $v["DERS_KODU"]." / ".$v["DERS_ADI"]." / ".$v["PROGRAM"];?>
                </option>
            <?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="chooseDersBaslangic" class="col-2 col-form-label">Ders Başlangıç:</label>
        <div class="col-10">
            <input class="form-control"  type="text" inputDateTime="true" id="chooseDersBaslangic" name="BASLANGIC">
        </div>
    </div>
    <div class="form-group row">
        <label for="chooseDersBitis" class="col-2 col-form-label">Ders Bitiş:</label>
        <div class="col-10">
            <input class="form-control" type="text" inputDateTime="true" id="chooseDersBitis" name="BITIS">
        </div>
    </div>
    <div class="form-group row">
        <label for="chooseDersTip" class="col-2 col-form-label">Ders Tipi:</label>
        <div class="col-10">
            <select class="form-control" id="chooseDersTip" name="TIP">
            <?php foreach($ders_tip as $k => $v){?>
                <option value="<?php echo $v["ID"];?>" <?php if(isset($ongorulen_ders["DERS_TIP"]) && $v["ID"] == $ongorulen_ders["DERS_TIP"]){echo "selected='selected'";}?>>
                    <?php echo $v["TIP"];?>
                </option>
            <?php } ?>
            </select>
        </div>
    </div>
    <input type="hidden" name="ENLEM" value="41.792161">
    <input type="hidden" name="BOYLAM" value="27.162259">
    <div class="form-group row" style="height:300px;">
        <label for="chooseDersTip" class="col-2 col-form-label">Dersin Konumu:</label>
        <div class="col-10">
            <div id="map"></div>
        </div>
    </div>
    <div class="form-group row">
        <label for="chooseDersTip" class="col-2 col-form-label"></label>
        <div class="col-10">
            <button type="submit" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-check"></i>
                </span>
                <span class="text">Dersi Oluştur</span>
            </button>
        </div>
    </div>
</form>
            	<!-- DataTales Example -->
        		<div class="card shadow mb-4 w-100">
            		<div class="card-header py-3">
              			<h6 class="m-0 font-weight-bold text-primary">Ders Bilgileri</h6>
            		</div>
            		<div class="card-body">
						<div class="row">
							<div class="col-md-3 m-auto">
								<img src="<?php echo base_url("qrcodes/".$acilanDersId.".png");?>" class="img-fluid" alt="Responsive image">
							</div>
							<div class="col-md-9 my-auto">
								<p>Danışman: <b><?php echo $ders["DANISMAN"];?></b></p>
								<p>Başlangıç Zamanı: <b><?php echo date("H:i - d/m/Y",strtotime($ders["BASLANGIC"]));?></b></p>
								<p>Bitiş Zamanı: <b><?php echo date("H:i - d/m/Y",strtotime($ders["BITIS"]));?></b></p>
								<p>Ders Tipi: <b><?php echo $ders["DERS_TIP"];?></b></p>
								<!--<pre><?php print_r($ders);?></pre>-->
							</div>
						</div>
					</div>
        		</div>
				<!-- DataTales Example -->
        		<div class="card shadow mb-4 w-100">
            		<div class="card-header py-3">
              			<h6 class="m-0 font-weight-bold text-primary">Öğrenciler</h6>
            		</div>
					<?php if(isset($ogrenciler[0]) && is_array($ogrenciler)){ 
						$anahtarlar = array_keys($ogrenciler[0]); ?>
            		<div class="card-body">
						<div class="table-responsive">
							<table class="table-sm table-bordered table-hover w-100" id="dataTable" cellspacing="0">
								<thead class="thead">
									<tr>
									<?php foreach($anahtarlar as $v){?>
										<th scope="col" class="text-center"><?php echo $v;?></th>
									<?php } ?>
									</tr>
								</thead>
								<tfoot class="tfoot">
									<tr>
									<?php foreach($anahtarlar as $v){?>
										<th scope="col" class="text-center"><?php echo $v;?></th>
									<?php } ?>
									</tr>
								</tfoot>
								<tbody class="tbody">
									<?php foreach($ogrenciler as $index => $ogrenci){ $veriler = array_values($ogrenci);?>
										<tr>
										<?php foreach($veriler as $v){?>
											<td scope="col" class="text-center"><?php echo $v;?></td>
										<?php } ?>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
            		</div>
					<?php } else{?>
					<div class="card-body">
						<p><b><?php echo $ogrenciler;?></b></p>
					</div>
					<?php } ?>
        		</div>

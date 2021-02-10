				<?php if($sorumlu){?>
				<div class="col-lg-12">
					<div class="card shadow mb-4 w-100">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary">Yardımcı Ekle</h6>
						</div>
						<div class="card-body">
							<form method="POST" action="<?php echo base_url();?>Dersler/YardimciEkle">
								<input type="hidden" name="dersHareketId" value="<?php echo $secili_ders;?>">
								<div class="form-group row">
									<label for="enterYardimciEmail" class="col-2 col-form-label">Yardimci Email</label>
									<div class="col-10">
										<input class="form-control"  type="text" id="enterYardimciEmail" name="yardimciEmail" placeholder="eposta@klu.edu.tr">
									</div>
								</div>
								<div class="form-group row">
									<label for="chooseDersTip" class="col-2 col-form-label"></label>
									<div class="col-10">
										<button type="submit" class="btn btn-success btn-icon-split">
											<span class="icon text-white-50">
												<i class="fas fa-check"></i>
											</span>
											<span class="text">Yardımcı Ekle</span>
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			 <?php } ?>
					<?php foreach($sorumlular as $k => $v){?>
						<div class="col-lg-6">
							<!-- Dropdown Card Example -->
							<div class="card shadow mb-4">
								<!-- Card Header - Dropdown -->
								<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary"><?php echo $v["DANISMAN"];?></h6>
									<?php if($sorumlu && $v["SICIL_NO"] != $this->session->userdata["SICIL_NO"]) { ?>
									<div class="dropdown no-arrow">
										<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
											<div class="dropdown-header">Hızlı İşlemler:</div>
												<a class="dropdown-item" href="<?php echo base_url()."Dersler/SorumluYetkiKaldirma/".$secili_ders."/".$v["SICIL_NO"];?>">Ders Yetkisini Geri Al</a>
											<div class="dropdown-divider"></div>
										</div>
									</div>
									<?php } ?>
								</div>
								<!-- Card Body -->
								<div class="card-body">
									<ul>
						                <li>TELEFON: <br><b><?php echo $v["TELEFON"];?></b></li>
						                <li>EPOSTA: <br><b><?php echo $v["EPOSTA"];?></b></li>
									</ul>
								</div>
							</div>
						</div>
					<?php } ?>
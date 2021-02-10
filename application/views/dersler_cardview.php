						<?php foreach($dersler as $k => $v){?>
						<div class="col-lg-6">
							<!-- Dropdown Card Example -->
							<div class="card shadow mb-4">
								<!-- Card Header - Dropdown -->
								<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary"><?php echo $v["DERS_KODU"]." ".$v["DERS_ADI"];?></h6>
									<div class="dropdown no-arrow">
										<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
											<div class="dropdown-header">Hızlı İşlemler:</div>
											<?php if($v["SON_DERS"] != null){?>
												<a class="dropdown-item" href="<?php echo base_url()."Dersler/AcilanDersleriGoster/".$v["DERS_HAREKET"];?>">Açılan Dersler</a>
												<a class="dropdown-item" href="<?php echo base_url()."Dersler/AcilanDersOgrencileriniGoster/".$v["SON_DERS"];?>">Son Açılan Dersi Göster</a>
											<?php } ?>
											<div class="dropdown-divider"></div>
											<?php if($izin){?><a class="dropdown-item" href="<?php echo base_url()."Dersler/Sorumlular/".$v["DERS_HAREKET"];?>">Danışmanlar</a><?php } ?>
											<a class="dropdown-item" href="<?php echo base_url()."DersOlustur/BelirtilenDersiOlustur/".$v["DERS_HAREKET"];?>">Yeni Ders Oluştur</a>
										</div>
									</div>
								</div>
								<!-- Card Body -->
								<div class="card-body">
									<ul>
										<li>FAKÜLTE / PROGRAM: <br><b><?php echo $v["FAKULTE"]." / ".$v["PROGRAM"];?></b></li>
										<li>TEORIK / UYGULAMA: <br><b><?php echo $v["TEORIK"]." SAAT TEORIK / ".$v["UYGULAMA"]." SAAT UYGULAMA";?></b></li>
						<?php if($v["SON_DERS"] != null){?><li>SON AÇILAN DERS SAATİ: <br><b><?php echo $v["DERS_BASLANGIC"]." / ".$v["DERS_BITIS"];?></b></li><?php } ?>
									</ul>
								</div>
							</div>
						</div>
						<?php } ?>
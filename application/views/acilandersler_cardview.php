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
												<a class="dropdown-item" href="<?php echo base_url()."Dersler/AcilanDersOgrencileriniGoster/".$v["ACILAN_DERS"];?>">Açılan Dersi Göster</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="<?php echo base_url()."DersOlustur/BelirtilenDersiOlustur/".$secili_ders;?>">Yeni Ders Oluştur</a>
										</div>
									</div>
								</div>
								<!-- Card Body -->
								<div class="card-body">
									<ul>
										<li>FAKÜLTE / PROGRAM: <br><b><?php echo $v["FAKULTE"]." / ".$v["PROGRAM"];?></b></li>
										<li>TEORIK / UYGULAMA: <br><b><?php echo $v["TEORIK"]." SAAT TEORIK / ".$v["UYGULAMA"]." SAAT UYGULAMA";?></b></li>
                                        <li>AÇILAN DERS SAATİ: <br><b><?php echo $v["BASLANGIC"]." / ".$v["BITIS"];?></b></li>
						                <li>DERSİ AÇAN: <br><b><?php echo $v["DANISMAN"];?></b></li>
									</ul>
								</div>
							</div>
						</div>
					<?php } ?>
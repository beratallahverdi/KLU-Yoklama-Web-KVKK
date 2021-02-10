<body id="page-top">
	<!-- Page Wrapper -->
	<div id="wrapper">
		<!-- Sidebar -->
		<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
			<!-- Sidebar - Brand -->
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url();?>">
				<div class="sidebar-brand-icon rotate-n-15">
					<i class="fas fa-laugh-wink"></i>
				</div>
				<div class="sidebar-brand-text mx-3">KLU Yoklama</div>
			</a>

			<!-- Divider -->
			<hr class="sidebar-divider">
			
			<!-- Heading -->
			<div class="sidebar-heading">
				Menü
			</div>

			<!-- Nav Item - Utilities Collapse Menu -->
			<!--
			<li class="nav-item">
				<a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
					<i class="fas fa-fw fa-wrench"></i>
					<span>Utilities</span>
				</a>
				<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<h6 class="collapse-header">Alt Başlık:</h6>
						<a class="collapse-item" href="utilities-color.html">Colors</a>
						<a class="collapse-item" href="utilities-border.html">Borders</a>
						<a class="collapse-item" href="utilities-animation.html">Animations</a>
						<a class="collapse-item" href="utilities-other.html">Other</a>
					</div>
				</div>
			</li>
			-->
			<li class="nav-item">
				<a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseDersler" aria-expanded="true" aria-controls="collapseDersler">
					<i class="fas fa-fw fa-wrench"></i>
					<span>Dersler</span>
				</a>
				<div id="collapseDersler" class="collapse" aria-labelledby="headingDersler" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<h6 class="collapse-header">İşlemler:</h6>
						<a class="collapse-item" href="<?php echo base_url();?>Dersler">Dersleri Göster</a>
						<a class="collapse-item" href="<?php echo base_url();?>DersOlustur">Ders Oluştur</a>
					</div>
				</div>
			</li>

			<!-- Nav Item - Charts -->
			<!--
			<li class="nav-item">
				<a class="nav-link" href="charts.html">
					<i class="fas fa-fw fa-chart-area"></i>
					<span>Charts</span>
				</a>
			</li>
			-->
			<!-- Divider -->
			<hr class="sidebar-divider d-none d-md-block">

			<!-- Sidebar Toggler (Sidebar) -->
			<div class="text-center d-none d-md-inline">
				<button class="rounded-circle border-0" id="sidebarToggle"></button>
			</div>
		</ul>
		<!-- End of Sidebar -->
		<?php $this->load->view("template/topbar");?>

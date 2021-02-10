<!DOCTYPE html>
<html lang="tr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="Damla KUŞKU">
		<meta name="author" content="Ertuğrul Berat ALLAHVERDİ">

		<title><?php echo $title;?></title>

		<!-- Custom fonts for this template-->
		<link href="<?php echo base_url();?>/assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url();?>/assets/css/font-nunito.css" rel="stylesheet">

		<!-- Custom styles for this template-->
		<link href="<?php echo base_url();?>/assets/css/sb-admin-2.min.css" rel="stylesheet">

	</head>
  <body class="row">
    <div class="col-4"></div>
    <div class="col-4 border border-dark p-4" style="margin-top:25vh;">
      <section class="text-center border border-dark p-4">
        <h2 class="mb-2">Akademisyen Girişi</h2>
        <form class="form-group" method="post" action="<?php echo base_url("/Giris/action");?>">
          <div class="input-group mb-2">
            <input class="form-control" placeholder="*******" name="email" type="text">
            <div class="input-group-append">
              <select name="mail_subfix" class="form-control">
                <option>@klu.edu.tr</option>
                <option>@eds</option>
                <option value="@ogrenci.kirklareli.edu.tr">@ogrenci</option>
              </select>
            </div>
            <span class="text-danger"><?php echo form_error('email');?></span>
          </div>
          <div class="input-group mb-2">
            <input class="form-control" placeholder="Şifreniz" name="password" type="password">
            <span class="text-danger"><?php echo form_error('password');?></span>
          </div>
          <div class="input-group mb-2">
            <input class="btn btn-primary" placeholder="Gönder" type="submit">
          </div>
        </form>
      </section>
    </div>
    <div class="col-4"></div>
  </body>
</html>
<!DOCTYPE html>
<html>
<head>
	<title>Capstone project</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- <meta http-equiv="refresh" content="5; URL=http://localhost:8888/dgdn/"> -->

	<!-- font awesome -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css">

	<!-- bootstrap -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.css">

	<!-- custom css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/client/main.css">
	<script src="<?php echo base_url(); ?>assets/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.js"></script>
</head>	
<body>
	<div class="container">
		<div class="row">
			<div class="content-area">
				<div class="logo center">
					<p>LOGO</p>
				</div>  
				<div class="mt-5">
					<div class="alert alert-warning" role="alert">
					    <strong>Warning!</strong> Something was wrong, please try again...
					</div>
					<div>
						<?php if($this->session->userdata('loggedInGooge')){ ?>
							<a href="<?php echo base_url().'login/logoutGoogle'; ?>">Quay lại</a>
						<?php }else if($this->session->userdata('loggedInFB')) { ?>	
							<a href="javascript:void(0);" onclick="logoutFB()">Quay lại</a>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- footer -->
	<footer>
		<div class="container">
			<div class="row">
				<div id="contact-us" class="center">
					<ul id="contact-item">
						<li class="d-inline-block"><a href="#"><i class="fa fa-facebook fa-lg" aria-hidden="true"></i></a></li>
						<li class="d-inline-block"><a href="#"><i class="fa fa-twitter fa-lg" aria-hidden="true"></i></a></li>
						<li class="d-inline-block"><a href="#"><i class="fa fa-envelope-o fa-lg" aria-hidden="true"></i></a></li>
						<li class="d-inline-block"><a href="#"><i class="fa fa-google-plus fa-lg" aria-hidden="true"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div id="about-us" class="center">
					<p class="d-inline-block"><a href="#">Về chúng tôi</a></p>
					<p class="d-inline-block"><a href="#">Liên hệ</a></p>
					<p class="d-inline-block"><a href="#">Hướng dẫn</a></p>
				</div>
			</div>
			<div class="break-line center"></div> 
			<p class="copy-right">&copy; 9/2017</p>     
		</div>
	</footer>
	
	<script src="<?php echo base_url(); ?>assets/popper/popper.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/bootstrap/tether.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.js"></script>
	<script src="<?php echo base_url(); ?>assets/bootstrap/jquery.slim.min.js"></script>
	
	<!-- My script -->
	<script type="text/javascript" src="<?php echo base_url(); ?>js/client/app.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/client/ui.js"></script>
</body>
</html>
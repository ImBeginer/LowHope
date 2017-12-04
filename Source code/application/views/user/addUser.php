<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Update Info</title>

	<!-- jQuery UI css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.min.css">
	<!-- font awesome -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css">
	<!-- bootstrap css -->	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.css">

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.css">

	<!-- custom css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/client/main.css">

</script>
</head>
<body>	
	<script>	
		var base_url = "<?php echo base_url(); ?>";		
	</script>
	<!-- navbar -->
	<nav id="my-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="#">Logo</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
			<ul class="nav navbar-nav navbar-right">
				<li class="nav-item">
					<!-- dropdown button -->
					<div class="dropdown">
						<button class="user-name btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
							<span class="caret"></span>
							<?php echo 'Xin chào, '.$this->session->userdata('userData')['USER_NAME']; ?>
						</button>
						<ul id="user-func-dropdown" class="dropdown-menu dropdown-menu-right">
							<?php if($this->session->userdata('loggedInGooge')){ ?>							
								<li class="func-items text-center"><a href="<?php echo base_url().'login/logoutGoogle'; ?>">Đăng xuất</a></li>
							<?php } else if($this->session->userdata('loggedInFB')){ ?>							
								<li class="func-items text-center"><a href="javascript:void(0);" onclick="logoutFB()">Đăng xuất</a></li>
							<?php } ?>
						</ul>
					</div>
					<!-- dropdown button -->
				</li>
			</ul>
		</div>
	</nav>  

	<!-- content -->
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-lg-6 col-xl-6 col-centered my-panel">
				<div class="content">
					<h2 class="text-center">Cập nhật thông tin</h2>
					<span class="sub-cap panel-des" style="color:red; font-weight:bold">Lưu ý: Hãy điền thông tin chính xác để chúng tôi liên hệ với bạn khi trúng thưởng</span>
					<form name="addUser">
						<div class="form-group">
							<input type="text" class="form-control" name="USER_NAME" id="fullName" placeholder="Họ và tên*" required>						
						</div>
						<div class="form-group">
							<input type="number" class="form-control" name="USER_PHONE" id="phoneNumber" placeholder="Số điện thoại*" required>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="USER_ADDRESS" id="address" placeholder="Địa chỉ*" required>
						</div>									
						<button id="btn-add-user" name="update" type="button" class="btn btn-default my-btn col-12 cursor-pointer">Cập nhật thông tin</button>
					</form>  
				</div>
			</div>      
		</div>
	</div><!-- .content -->

	<!-- footer -->
	<footer>
		<div>LowHope &copy; 2017. All Right Reserved.</div>
	</footer>
	<!-- /.footer -->

<!-- jquery -->
<script src="<?php echo base_url(); ?>assets/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.js"></script>
<script src="<?php echo base_url(); ?>assets/popper/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.js"></script>

<!-- My script -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/client/app.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/client/fb.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/client/ui.js"></script>
</body>
</html>
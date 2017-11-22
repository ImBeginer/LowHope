<!DOCTYPE html>
<html>
<head>
	<title>Website dự đoán giá bitcoin</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<style>
		@keyframes changewidth {
			from {
				-webkit-transform: translate(50px);
				-ms-transform: translate(50px);
				transform: translate(50px);
			}

			to {}
		}

		@keyframes radioClick {
			from {
				height: 0px;
				width: 0px;
				opacity: 1;    
			}

			to {
				height: 50px;
				width: 50px;
				opacity: 0;
				margin-left: -19px;
				margin-top: -18px;
			}
		}    
	</style>		
	<!-- jQuery UI css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.min.css">
	<!-- bootstrap css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.css">
	<!-- font awesome -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/animation/animate.css">

	<!-- custom css -->
  	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/client/main.css">
</head>
<body onload="logoutFB(); infinitySlideShow();">
	<script>var base_url = "<?php echo base_url(); ?>";</script>
	<!-- body -->
	<div id="main-index" class="container-fluid">
		<div class="row">
			<!-- infinite slideshow -->
			<section id="hot-mini-game-area">
				<div id="hot-mini-game-content" class="hot-minigame slider autoplay"> 
					<?php if(empty($YN_ALL) && empty($MUL_ALL)){
						echo 'Các game đang được hệ thống cập nhật';
					} ?>

					<?php shuffle($all_game); ?>
					<?php foreach ($all_game as $value): ?>
						<?php if($value['ACTIVE'] == 1){ ?>
						<div class="hot-item" data-gameID="<?php echo $value['GAME_ID']; ?>" data-gameType="<?php if($value['TYPE'] == 'YN'){echo 1;}else if($value['TYPE'] == 'MUL'){echo 2;} ?>">
							<?php if($value['TYPE'] == 'YN'){ ?>
							<a href="<?php echo base_url().'gamect/yn/'.$value['GAME_ID']; ?>" title="<?php echo $value['TITLE']; ?>">
							<?php }else if($value['TYPE'] == 'MUL'){ ?>
							<a href="<?php echo base_url().'gamect/mul/'.$value['GAME_ID']; ?>" title="<?php echo $value['TITLE']; ?>">
							<?php } ?>
								<div class="title"><?php echo $value['TITLE']; ?></div>
								<div class="runner"><?php echo $value['USER_NAME']; ?></div>
								<div class="prob">
									<span class="icon-arrow-up"><i class="fa fa-angle-up" aria-hidden="true"></i></span>
									<span><?php echo $value['TOTAL_AMOUNT'] ?></span>
								</div>
							</a>
						</div>
						<?php } ?>            
					<?php endforeach ?>
				</div>
			</section>    
			<!-- /.infinite slideshow -->
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
								<button class="user-name btn btn-primary dropdown-toggle cursor-pointer" type="button" data-toggle="dropdown">
									<span class="caret"></span>
									Đăng Nhập
								</button>
								<!-- USER ĐĂNG NHẬP MỚI 2/11 -->
								<div id="user-login-panel" class="dropdown-menu dropdown-menu-right">
									<div class="login-form-panel">
										<form name="login-form" class="user-form login-form">
											<div class="form-group">
												<label class="mail-icon" for="username">Tài khoản email</label>
												<input type="text" class="form-control dark-form" id="username" placeholder="abc@gmail.com">
											</div>
											<div class="form-group">
												<label for="userpassword">Mật khẩu</label>
												<input type="password" class="form-control dark-form" id="userpassword">
											</div>
											<div class="form-group">
												<button type="button" name="user-login-btn" id="user-login" class="btn login-btn cursor-pointer">Đăng nhập</button>
												<a href="javascript:void(0);" class="user-forgot-pass-form">
													<i class="fa fa-unlock" aria-hidden="true"></i> Quên mật khẩu
												</a>
											</div>    
										</form>
									</div>
									<div class="forgot-form-panel">
										<form name="forgot-pass-form" class="user-form forgot-pass-form">
											<div class="form-group">
												<label for="email">Nhập email</label>
												<input type="text" class="form-control dark-form" id="forgot-email">
											</div>
											<div class="form-group">
												<button type="button" name="user-send-confirm-code-btn" id="user-send-confirm-code" class="btn changepass-btn cursor-pointer">Gửi mã xác nhận</button>
											</div>
											<div class="form-group">
												<label for="userpass">Mật khẩu mới</label>
												<input type="password" class="form-control dark-form" id="userpass">
											</div>
											<div class="form-group">
												<label for="confirmpass">Nhập lại mật khẩu</label>
												<input type="password" class="form-control dark-form" id="confirmpass">
											</div>
											<div class="form-group">
												<label for="confirmcode">Mã xác nhận</label>
												<input type="text" class="form-control dark-form" id="confirmcode">
											</div>    
											<div class="form-group">
												<button type="button" name="user-change-pass-btn" id="user-forgot-pass" class="btn changepass-btn cursor-pointer">Đổi mật khẩu</button>
												<a href="javascript:void(0);" class="user-login-form">
													<i class="fa fa-sign-in" aria-hidden="true"></i> Đăng nhập
												</a>
											</div>    
										</form>
									</div>
									<div class="message"></div>                
								</div>
								<!-- /.USER ĐĂNG NHẬP MỚI 2/11 -->
							</div>
						</li>            
					</ul>
				</div>
			</nav> <!-- end nav --> 

			<div class="content-area">
				<!-- content -->
				<div class="bg"></div>
				<div class="content">
					<!-- header -->
					<div class="center" style="margin-top: -100px">
						<h2 class="text-center hero-text">Đoán già đoán non, có ngon thì vào thử</h2>
						<div class="center btn-area">
							<div class="d-inline google-button">
								<a href="<?php echo $loginURL;?>"><i class="fa fa-google-plus fa-lg" aria-hidden="true"></i></a>
							</div>
							<div class="d-inline facebook-button">
								<a href="javascript:void(0);" onclick="loginFB()"><i class="fa fa-facebook fa-lg" aria-hidden="true"></i></a>
							</div>
						</div>
						<p id="login-des" class="panel-des"><strong>Đăng nhập dễ dàng với tài khoản Google hoặc Facebook</strong></p>
					</div><!-- end header -->
					<!-- special-index -->
					<div class="special-index">
						<div class="row">
							<div id="btc_yesterday" class="text-center col-sm-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
								<p>8000.0 USD</p>
								<span>Hôm qua</span>
							</div>
							<div id="btc_today" class="text-center col-sm-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
								<p><?php echo $price_current; ?> USD</p>
								<span>Hôm nay</span>                
							</div>
							<div id="" class="text-center col-sm-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
								<p>???</p>
								<span>Ngày mai</span>
							</div>
						</div>
					</div><!-- end special-index -->
				</div><!-- end content -->
			</div> <!-- end content-area -->
		</div>
	</div> <!-- end body -->

	<div class="minigame">
		<div class="container">
			<div class="col-12">
				<div class="danhmuc">
					<i class="fa fa-gamepad" aria-hidden="true"></i>
					<a id="tatca" href="*" class="btn btn-outline-primary">All </a>
			        <a href=".close" class="btn btn-outline-primary">Closed</a>
			        <a href=".open" class="btn btn-outline-primary">Opening</a>
      			</div>
      		</div>
      		<div class="list-minigame">
      			<?php shuffle($all_game); ?>
      			<?php foreach ($all_game as $value): ?>
			      	<div class="col-3 mt-3 minigame <?php if($value['ACTIVE'] == 1){echo "open";}else{echo "close";} ?>">
			      		<div class="card">
			      			<div class="card-header">
			      				<?php if($value['ACTIVE'] == 1){ ?>
			      					<p class="game-opening">ĐANG MỞ</p>
			      				<?php }else{ ?>
			      					<p class="game-closing">ĐÃ ĐÓNG</p>
			      				<?php } ?>
			      			</div>
			      			<div class="card-block">
								<?php if($value['TYPE'] == 'YN'){ ?>
	      							<a href="<?php echo base_url().'gamect/yn/'.$value['GAME_ID']; ?>">
								<?php }else if($value['TYPE'] == 'MUL'){ ?>
									<a href="<?php echo base_url().'gamect/mul/'.$value['GAME_ID']; ?>">
								<?php } ?>
				      				<p class=""><?php echo $value['TITLE']; ?></p>
				      				<?php if($value['TYPE'] == 'YN'){ ?>
				      					<p class="mini-game-transaction">Giá bitcoin trên: <?php echo $value['PRICE_BET']; ?> ?</p>
				      				<?php }else if($value['TYPE'] == 'MUL') { ?>
										<p class="mini-game-transaction">Giá bitcoin trên <?php echo $value['PRICE_ABOVE']; ?> hay dưới <?php echo $value['PRICE_BELOW']; ?> ?</p>
				      				<?php } ?>
				      				<p class="total-transaction"><?php echo $value['TOTAL_AMOUNT']; ?><span class="currency-name">point đã đặt</span></p>
				      				<?php if($value['ACTIVE'] == 1){ ?>
				      				<?php 
				      					$date = $value['END_DATE'];
								      	$date = new DateTime($date);
								      	$time = $date->format('H:i:s d-m-Y');
				      				?>
				      					<p class="end-time">Close in: <?php echo $time; ?></p>
				      				<?php } ?>
				      			</a>
			      			</div>
			      		</div>
			      	</div>
      		    <?php endforeach ?>
      		</div> <!-- end list-minigame -->
  		</div> <!-- end container -->
	</div> <!-- end minigame -->

	<footer>
    	<span>&copy; 2017</span>
  	</footer>

	<style type="text/css">  
		.hienlen {
			background-color: orange!important;
		}
	</style>	
  <script src="<?php echo base_url(); ?>assets/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/jquery/jquery-migrate-1.2.1.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/jquery/isotope.pkgd.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/popper/popper.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.js"></script>
  <!-- Pusher -->
  <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
  <!-- My script -->
  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/fb.js"></script>

  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/login.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/forgotPass.js"></script>

  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/filterIsotope.js"></script>

  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/pusher.js"></script>

  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/ui.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/app.js"></script>

</body>
</html>
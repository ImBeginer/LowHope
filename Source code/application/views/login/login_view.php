<!DOCTYPE html>
<html>
<head>
	<title>Capstone project</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
	<!-- jQuery UI css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.min.css">
	<!-- bootstrap css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.css">
	<!-- font awesome -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css">
	<!-- custom css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/client/main.css">

	<!-- jquery -->
	<script src="<?php echo base_url(); ?>assets/jquery/jquery.min.js"></script>
	
</head>
<body onload="logoutFB()">
	<script>
		var base_url = "<?php echo base_url(); ?>";

		window.fbAsyncInit = function() {			
			FB.init({
				appId      			: '463997824000380',
				status				: true,
                xfbml      			: true,  			// parse social plugins on this page
                version    			: 'v2.8' 			// use graph api version 2.8
            });

			FB.getLoginStatus(function(response) {
				console.log(response);
			});
		};

		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));

		function logoutFB(){
			FB.getLoginStatus(function(response) {
				if (response.status === 'connected') {

					var uid = response.authResponse.userID;
					var accessToken = response.authResponse.accessToken;

					FB.api('/'+ uid +'/permissions', 'delete', function(response){
		            	//console.log(response);
		            });

				} else if (response.status === 'not_authorized') {
		            // the user is logged in to Facebook, 
		            // but has not authenticated your app
		        } else {
		            // the user isn't logged in to Facebook.
		        }
		    });
		}

		function loginFB() {
			FB.login(function(response) {
				if (response.authResponse) {
					console.log('Welcome!  Fetching your information.... ');
					console.log('accsessToken: ' + response.authResponse.accessToken);
					FB.api('/me', {locale: 'vi_VN', fields: 'id,name,email,link,picture'}, function(response) {

						//phải kiểm tra xem tài khoản đã có trong db chưa,
						//chưa có thì add vào rồi get ra ID, truyền vào 
						
						console.log(response);
						console.log('Good to see you, ' + response.name + '.');

						$.ajax({
							url: 'login/fb_CheckUserExist',
							type: 'POST',
							dataType: 'JSON',
							data: {
								fb_id: response.id,
								fb_name:response.name,
								fb_email:response.email,
								fb_link:response.link,
								fb_avatar:response.picture
							},
						})
						.done(function(response) {
							if(response == 0){
								window.location.href = base_url +'login/fb_AddUser';
							}else if(response == 1){
								window.location.href = base_url +'login/fb_goHome';
							}else {
								$.toast({
									heading: 'Information',
									text: 'Có gì đó sai sai, bạn vui lòng thử lại sau giây lát ...',
									showHideTransition: 'slide',
									icon: 'info',
									position: 'bottom-right',
									hideAfter: 3000
								})
							}				
							
						})
						.fail(function() {
							console.log("error");
						})
						.always(function() {
							console.log("complete");
						});
						
					});
				} else {
					console.log('User cancelled login or did not fully authorize.');
				}
			},{scope: 'public_profile,email'});
		}
	</script>

	<!-- body -->
	<div id="main-index" class="container-fluid">
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
								Thông tin
							</button>
							<ul id="user-func-dropdown" class="dropdown-menu dropdown-menu-right">
								<li class="func-items"><a href="#!">Gmail</a></li>
								<li class="func-items"><a href="#!">Facebook</a></li>
								<li class="func-items"><a href="#!">Google</a></li>
								<li class="func-items"><a href="#!">Về chúng tôi</a></li>
								<li class="func-items"><a href="#!">Câu hỏi</a></li>
							</ul>
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
				<div class="center">
					<h2 class="text-center hero-text">Đoán già đoán non, có ngon thì vào thử</h2>
					<div class="center btn-area">
						<div class="d-inline google-button">
							<a href="<?php echo $loginURL;?>"><i class="fa fa-google-plus fa-lg" aria-hidden="true"></i></a>
						</div>
						<div class="d-inline facebook-button">
							<a href="javascript:void(0);" onclick="loginFB()"><i class="fa fa-facebook" aria-hidden="true"></i></a>
						</div>
					</div>
					<p id="login-des" class="panel-des"><strong>Đăng ký với tài khoản google hoặc facebook</strong></p>
				</div><!-- end header -->
				<!-- special-index -->
				<div class="special-index">
					<div class="col-12 btc-scj-pnj">
						<div id="BTC" class="mt-3 d-inline-block text-center col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
							<p>80,000,000 BTC</p>
							<span>Hôm qua</span>
						</div>
						<div id="BTC" class="mt-3 d-inline-block text-center col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
							<p>82,000,000 BTC</p>
							<span>Hôm nay</span>                
						</div>
						<div id="BTC" class="mt-3 d-inline-block text-center col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
							<p>???</p>
							<span>Ngày mai</span>
						</div>
					</div>
				</div><!-- end special-index -->
			</div><!-- end content -->
		</div> <!-- end content-area -->
	</div> <!-- end container -->

	<div class="minigame">
		<div class="container">
			<div class="col-12">
				<div class="danhmuc">
					<i class="fa fa-gamepad" aria-hidden="true"></i>
					<a id="tatca" href="*" class="btn btn-outline-primary">All </a>
					<!-- <a href=".bitcoin" class="btn btn-outline-primary">Bitcoin </a> -->
			        <!--  <a href=".sjc" class="btn btn-outline-primary">SJC </a>
			        <a href=".999" class="btn btn-outline-primary">999 </a> -->
			        <a href=".close" class="btn btn-outline-primary">Closed </a>
			        <a href=".open" class="btn btn-outline-primary">Opening </a>
      			</div>
      		</div>

      		<div class="list-minigame">    

		      	<div class="col-3 mt-3 minigame close">
		      		<div class="card">
		      			<div class="card-header">
		      				<p class="game-closing">ĐÃ ĐÓNG</p>
		      			</div>
		      			<div class="card-block">
		      				<a href="#" class="title">Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)(SCJ).</a>
		      				<p class="total-transaction">532<span class="currency-name">point</span></p>
		      				<p class="end-time">Kết thúc trong: 0 ngày</p>
		      			</div>
		      		</div>
		      	</div>

		      	<div class="col-3 mt-3 minigame close">
		      		<div class="card">
		      			<div class="card-header">
		      				<p class="game-closing">ĐÃ ĐÓNG</p>
		      			</div>
		      			<div class="card-block">
		      				<a href="#" class="title">Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)(SCJ)Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)(SCJ).</a>
		      				<p class="total-transaction">532<span class="currency-name">point</span></p>
		      				<p class="end-time">Kết thúc trong: 0 ngày</p>
		      			</div>
		      		</div>
		      	</div>

		      	<div class="col-3 mt-3 minigame open">
		      		<div class="card">
		      			<div class="card-header">
		      				<p class="game-opening">ĐANG MỞ</p>
		      			</div>
		      			<div class="card-block">
		      				<a href="#" class="title">Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)(SCJ)Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)(SCJ)Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)(SCJ).</a>
		      				<p class="total-transaction">532<span class="currency-name">point</span></p>
		      				<p class="end-time">Kết thúc trong: 0 ngày</p>
		      			</div>
		      		</div>
		      	</div>

		      	<div class="col-3 mt-3 minigame close">
		      		<div class="card">
		      			<div class="card-header">
		      				<p class="game-closing">ĐÃ ĐÓNG</p>
		      			</div>
		      			<div class="card-block">
		      				<a href="#" class="title">Various versions have evolved over the years, sometimes by accident, sometime.</a>
		      				<p class="total-transaction">532<span class="currency-name">point</span></p>
		      				<p class="end-time">Kết thúc trong: 0 ngày</p>
		      			</div>
		      		</div>
		      	</div>

		      	<div class="col-3 mt-3 minigame close">
		      		<div class="card">
		      			<div class="card-header">
		      				<p class="game-closing">ĐÃ ĐÓNG</p>
		      			</div>
		      			<div class="card-block">
		      				<a href="#" class="title">Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)(SCJ).</a>
		      				<p class="total-transaction">532<span class="currency-name">point</span></p>
		      				<p class="end-time">Kết thúc trong: 0 ngày</p>
		      			</div>
		      		</div>
		      	</div>

		      	<div class="col-3 mt-3 minigame close">
		      		<div class="card">
		      			<div class="card-header">
		      				<p class="game-closing">ĐÃ ĐÓNG</p>
		      			</div>
		      			<div class="card-block">
		      				<a href="#" class="title">Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)(SCJ).(injected humour and the like)(SCJ)</a>
		      				<p class="total-transaction">532<span class="currency-name">point</span></p>
		      				<p class="end-time">Kết thúc trong: 0 ngày</p>
		      			</div>
		      		</div>
		      	</div>

		      	<div class="col-3 mt-3 minigame open">
		      		<div class="card">
		      			<div class="card-header">
		      				<p class="game-opening">ĐANG MỞ</p>
		      			</div>
		      			<div class="card-block">
		      				<a href="#" class="title">Various versions have evolved over the yearsVarious versions have evolved over the yearsVarious versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)(SCJ).(injected humour and the like)(SCJ)</a>
		      				<p class="total-transaction">532<span class="currency-name">point</span></p>
		      				<p class="end-time">Kết thúc trong: 0 ngày</p>
		      			</div>
		      		</div>
		      	</div>

		      	<div class="col-3 mt-3 minigame close">
		      		<div class="card">
		      			<div class="card-header">
		      				<p class="game-closing">ĐÃ ĐÓNG</p>
		      			</div>
		      			<div class="card-block">
		      				<a href="#" class="title">.(injected humour and the like)(SCJ)</a>
		      				<p class="total-transaction">532<span class="currency-name">point</span></p>
		      				<p class="end-time">Kết thúc trong: 0 ngày</p>
		      			</div>
		      		</div>
		      	</div>

		      	<div class="col-3 mt-3 minigame open">
		      		<div class="card">
		      			<div class="card-header">
		      				<p class="game-opening">ĐANG MỞ</p>
		      			</div>
		      			<div class="card-block">
		      				<a href="#" class="title">.(injected humour and the like)(SCJ)(injected humour and the like)(SCJ)</a>
		      				<p class="total-transaction">532<span class="currency-name">point</span></p>
		      				<p class="end-time">Kết thúc trong: 0 ngày</p>
		      			</div>
		      		</div>
		      	</div>
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

	
	<!-- popper js -->	
	<script src="<?php echo base_url(); ?>assets/popper/popper.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/bootstrap/tether.min.js"></script>
	<!-- bootstrap js -->
	<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.js"></script>
	<!-- jquery-ui -->
	<script src="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.min.js"></script>
	<!-- isotope js -->
	<script src="<?php echo base_url(); ?>assets/jquery/isotope.pkgd.min.js"></script>

	<script src="<?php echo base_url(); ?>assets/bootstrap/jquery.slim.min.js"></script>	

	<!-- My script -->
	<script type="text/javascript" src="<?php echo base_url(); ?>js/client/app.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/client/ui.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/client/filterIsotope.js"></script>

</body>
</html>
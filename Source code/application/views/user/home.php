<!DOCTYPE html>
<html lang="en">
<head>
	<title>Website dự đoán giá bitcoin</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
	<!-- jQuery UI css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.min.css">
	<!-- bootstrap css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.css">
	<!-- font awesome -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css">

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.css">
	<!-- custom css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/client/main.css">

	<script src="<?php echo base_url(); ?>assets/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.js"></script>
</head>
<body>	
	<script>
		var userId = "<?php echo $this->session->userdata('sessionUserId'); ?>";	
		var base_url = "<?php echo base_url(); ?>";
		window.fbAsyncInit = function() {			
			FB.init({
				appId      			: '463997824000380',
				status				: true,
                xfbml      			: true,  			// parse social plugins on this page
                version    			: 'v2.8' 			// use graph api version 2.8
            });
		};

		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<!-- big div on top -->
	<div class="container-fluid">
		<div class="row">
			<!-- infinite slideshow -->
			<section id="hot-mini-game-area">
				<div id="hot-mini-game-content" class="hot-minigame"> 
					<div class="hot-item">
						<a href="#!" title="Darren Till vs. Donald Cerrone">
							<div class="title">Darren Till vs. Donald Cerrone</div>
							<div class="runner">Darren Till</div>
							<div class="prob">
								<span class="icon-arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
								<span>39.8</span>
							</div>
						</a>
					</div>
					<div class="hot-item">
						<a href="#!" title="Army @ Rice">
							<div class="title">Army @ Rice</div>
							<div class="runner">Army -13.5</div>
							<div class="prob">
								<span class="icon-arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
								<span>49.5</span>
							</div>
						</a>
					</div>
					<div class="hot-item">
						<a href="#!" title="Colorado State @ Utah State">
							<div class="title">Colorado State @ Utah State</div>
							<div class="runner">Colorado State -8</div>
							<div class="prob">
								<span class="icon-arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
								<span>49.0</span>
							</div>
						</a>
					</div>
					<div class="hot-item">
						<a href="#!" title="Temple @ East Carolina">
							<div class="title">Temple @ East Carolina</div>
							<div class="runner">Temple -2.5</div>
							<div class="prob">
								<span class="icon-arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
								<span>50.0</span>
							</div>
						</a>
					</div>
					<div class="hot-item">
						<a href="#!" title="Bitcoin to fall below 3000 USD before January 1">
							<div class="title">Bitcoin to fall</div>
							<div class="runner">Yes</div>
							<div class="prob">
								<span class="icon-bullet"><i class="fa fa-circle" aria-hidden="true"></i></span>
								<span>37.3</span>
							</div>
						</a>
					</div>
					<div class="hot-item">
						<a href="#!" title="Armenia vs. Poland">
							<div class="title">Armenia vs. Poland</div>
							<div class="runner">Armenia</div>
							<div class="prob">
								<span class="icon-bullet"><i class="fa fa-circle" aria-hidden="true"></i></span>
								<span>6.0</span>
							</div>
						</a>
					</div>
					<div class="hot-item">
						<a href="#!" title="Malta vs. Lithuania">
							<div class="title">Malta vs. Lithuania</div>
							<div class="runner">Over 2</div>
							<div class="prob">
								<span class="icon-arrow-up"><i class="fa fa-angle-up" aria-hidden="true"></i></span>
								<span>49.3</span>
							</div>
						</a>
					</div>
					<div class="hot-item">
						<a href="#!" title="Argentina vs. Peru">
							<div class="title">Argentina vs. Peru</div>
							<div class="runner">Over 3</div>
							<div class="prob">
								<span class="icon-arrow-up"><i class="fa fa-angle-up" aria-hidden="true"></i></span>
								<span>54.3</span>
							</div>
						</a>
					</div>
					<div class="hot-item">
						<a href="#!" title="Malta vs. Lithuania">
							<div class="title">Malta vs. Lithuania</div>
							<div class="runner">Malta</div>
							<div class="prob">
								<span class="icon-arrow-up"><i class="fa fa-angle-up" aria-hidden="true"></i></span>
								<span>22.2</span>
							</div>
						</a>
					</div>
					<div class="hot-item">
						<a href="#!" title="Armenia vs. Poland">
							<div class="title">Armenia vs. Poland</div>
							<div class="runner">Over 0.5</div>
							<div class="prob">
								<span class="icon-arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
								<span>49.5</span>
							</div>
						</a>
					</div>
					<div class="hot-item">
						<a href="#!" title="Darren Till vs. Donald Cerrone">
							<div class="title">Darren Till vs. Donald Cerrone</div>
							<div class="runner">Darren Till</div>
							<div class="prob">
								<span class="icon-arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
								<span>39.8</span>
							</div>
						</a>
					</div>
					<div class="hot-item">
						<a href="#!" title="Army @ Rice">
							<div class="title">Army @ Rice</div>
							<div class="runner">Army -13.5</div>
							<div class="prob">
								<span class="icon-arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
								<span>49.5</span>
							</div>
						</a>
					</div>
					<div class="hot-item">
						<a href="#!" title="Colorado State @ Utah State">
							<div class="title">Colorado State @ Utah State</div>
							<div class="runner">Colorado State -8</div>
							<div class="prob">
								<span class="icon-arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
								<span>49.0</span>
							</div>
						</a>
					</div>
					<div class="hot-item">
						<a href="#!" title="Temple @ East Carolina">
							<div class="title">Temple @ East Carolina</div>
							<div class="runner">Temple -2.5</div>
							<div class="prob">
								<span class="icon-arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
								<span>50.0</span>
							</div>
						</a>
					</div>
					<div class="hot-item">
						<a href="#!" title="Bitcoin to fall below 3000 USD before January 1">
							<div class="title">Bitcoin to fall</div>
							<div class="runner">Yes</div>
							<div class="prob">
								<span class="icon-bullet"><i class="fa fa-circle" aria-hidden="true"></i></span>
								<span>37.3</span>
							</div>
						</a>
					</div>
					<div class="hot-item">
						<a href="#!" title="Armenia vs. Poland">
							<div class="title">Armenia vs. Poland</div>
							<div class="runner">Armenia</div>
							<div class="prob">
								<span class="icon-bullet"><i class="fa fa-circle" aria-hidden="true"></i></span>
								<span>6.0</span>
							</div>
						</a>
					</div>
					<div class="hot-item">
						<a href="#!" title="Malta vs. Lithuania">
							<div class="title">Malta vs. Lithuania</div>
							<div class="runner">Over 2</div>
							<div class="prob">
								<span class="icon-arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
								<span>49.3</span>
							</div>
						</a>
					</div>
					<div class="hot-item">
						<a href="#!" title="Argentina vs. Peru">
							<div class="title">Argentina vs. Peru</div>
							<div class="runner">Over 3</div>
							<div class="prob">
								<span class="icon-arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
								<span>54.3</span>
							</div>
						</a>
					</div>
					<div class="hot-item">
						<a href="#!" title="Malta vs. Lithuania">
							<div class="title">Malta vs. Lithuania</div>
							<div class="runner">Malta</div>
							<div class="prob">
								<span class="icon-arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
								<span>22.2</span>
							</div>
						</a>
					</div><div class="hot-item">
						<a href="#!" title="Armenia vs. Poland">
							<div class="title">Armenia vs. Poland</div>
							<div class="runner">Over 0.5</div>
							<div class="prob">
								<span class="icon-arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
								<span>49.5</span>
							</div>
						</a>
					</div>
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
							<!-- info dropdown button -->
							<div class="dropdown">
								<button class="user-name btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
									Thông tin
									<span class="angle-down"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
								</button>
								<ul id="user-func-dropdown" class="dropdown-menu dropdown-menu-right">
									<li class="func-items"><a href="#!">Gmail</a></li>
									<li class="func-items"><a href="#!">Facebook</a></li>
									<li class="func-items"><a href="#!">Google</a></li>
									<li class="func-items"><a href="#!">Về chúng tôi</a></li>
									<li class="func-items"><a href="#!">Câu hỏi</a></li>
								</ul>
							</div> <!-- /.info dropdown button -->
						</li> 
						<li class="nav-item active top-bar-items">
							<a class="nav-link" href="#"><i class="fa fa-trophy" aria-hidden="true"></i></a>
						</li>
						<li class="nav-item top-bar-items">
							<div class="dropdown">
								<button id="notifi-btn" class="notifi btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
									<i class="fa fa-bell notifi-icon" aria-hidden="true"></i>
									<div class="notifi-num">
										<p>8</p>
									</div>
								</button>
								<!-- notification list -->
								<ul id="user-notifi" class="dropdown-menu dropdown-menu-right pre-scrollable">
									<li class="noti-items" class="btn btn-primary" data-toggle="modal" data-target="#notifi-popup">
										<div class="noti-content ellipsis">
											<a href="#!">
												<p class="notifi-title notifi-1" class="ellipsis">
													<div id="circle-read-1" class="green-circle d-inline-block" data-is-read="false"></div>
													Notifi 1
													<div class="time-area">
														<span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
														<span class="send-date">15:37 - 10/7</span>
													</div>
												</p>
											</a>
										</div>
									</li>                                                                      
									<li class="noti-items" class="btn btn-primary" data-toggle="modal" data-target="#notifi-popup">
										<div class="noti-content ellipsis">
											<a href="#!">
												<p class="notifi-title notifi-2" class="ellipsis">
													<div id="circle-read-2" class="green-circle d-inline-block" data-is-read="false"></div>
													Notifi 2
													<div class="time-area">
														<span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
														<span class="send-date">15:37 - 10/7</span>
													</div>
												</p>
											</a>
										</div>
									</li>    
									<li class="noti-items" class="btn btn-primary" data-toggle="modal" data-target="#notifi-popup">
										<div class="noti-content ellipsis">
											<a href="#!">
												<p class="notifi-title notifi-3" class="ellipsis">
													<div id="circle-read-3" class="green-circle d-inline-block" data-is-read="false"></div>
													Notifi 3
													<div class="time-area">
														<span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
														<span class="send-date">15:37 - 10/7</span>
													</div>
												</p>
											</a>
										</div>
									</li> 
									<li class="noti-items" class="btn btn-primary" data-toggle="modal" data-target="#notifi-popup">
										<div class="noti-content ellipsis">
											<a href="#!">
												<p class="notifi-title notifi-4" class="ellipsis">
													<div id="circle-read-4" class="green-circle d-inline-block" data-is-read="false"></div>
													Notifi 4
													<div class="time-area">
														<span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
														<span class="send-date">15:37 - 10/7</span>
													</div>
												</p>
											</a>
										</div>
									</li>    
									<li class="noti-items" class="btn btn-primary" data-toggle="modal" data-target="#notifi-popup">
										<div class="noti-content ellipsis">
											<a href="#!">
												<p class="notifi-title notifi-5" class="ellipsis">
													<div id="circle-read-5" class="green-circle d-inline-block" data-is-read="false"></div>
													Notifi 5
													<div class="time-area">
														<span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
														<span class="send-date">15:37 - 10/7</span>
													</div>
												</p>
											</a>
										</div>
									</li>    
									<li class="noti-items" class="btn btn-primary" data-toggle="modal" data-target="#notifi-popup">
										<div class="noti-content ellipsis">
											<a href="#!">
												<p class="notifi-title notifi-6" class="ellipsis">
													<div id="circle-read-6" class="green-circle d-inline-block" data-is-read="false"></div>
													Notifi 6
													<div class="time-area">
														<span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
														<span class="send-date">15:37 - 10/7</span>
													</div>
												</p>
											</a>
										</div>
									</li>                                                                                                 
								</ul><!-- /.notification list -->
								<!-- popup notifi -->
								<div class="modal" id="notifi-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="notifi-popup-title">Notifi title</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<p class="notifi-message">...</p>
											</div>
										</div>
									</div>
								</div><!-- /.popup notifi -->
							</div>              
						</li>            
						<li class="nav-item">
							<!-- user dropdown button -->
							<div class="dropdown">
								<button class="user-name btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
									<span id="user_name"><?php echo $USER_NAME; ?></span>
									<span class="angle-down"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
								</button>
								<ul id="user-func-dropdown" class="dropdown-menu dropdown-menu-right">
									<li class="func-items user-name-btn">
										<button class="btn btn-primary user-name" data-toggle="modal" data-target="#user-update-info">
											Sửa thông tin
										</button>     
									</li>
									<!-- TODO tao mini game -->
									<li class="func-items"><a href="#!">Tạo mini game</a></li>
									<?php if($this->session->userdata('loggedInGooge')){ ?>
										<li class="func-items"><a href="<?php echo base_url().'login/logoutGoogle'; ?>">Đăng xuất</a></li>
									<?php }else if($this->session->userdata('loggedInFB')) { ?>	
										<li class="func-items text-center"><a href="javascript:void(0);" onclick="logoutFB()">Đăng xuất</a></li>
									<?php } ?>
								</ul>
							</div> <!-- /.user dropdown button -->
							<!-- user update form -->
							<div id="user-update-info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								<div class="modal-dialog">                  
									<!-- modal content -->
									<div id="user-update-info" class="modal-content">
										<div class="modal-header user-header">
											<h5 class="user-func-title">Cập nhật thông tin</h5>
											<button type="button" class="close user-btn-close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<!-- user update info -->
										<form class="user-form">
											<div class="row">
												<div class="user-info-left col-3">

													<!-- user avatar -->
													<div class="user-ava-area">
														<img class="user-avatar" src="<?php echo $this->session->userdata('userData')['USER_AVATAR']; ?>" alt="User's avatar">
														<p class="username ellipsis"><?php echo $USER_NAME; ?></p>
													</div><!-- /.user avatar -->

												</div>
												<div class="user-info-right col-8 col-centered">

													<!-- user info -->
													<div class="input-area">
														<input id="username" type="text" name='username' placeholder="Họ và tên *" value="" required="">
														<input id="userphone" type="number" name='userphone' placeholder="Số điện thoại *" value="" required="">
														<input id="useraddress" type="text" name='useraddress' placeholder="Địa chỉ *" value="" required="">
													</div><!-- /.user info -->

												</div>
											</div>
											<div class="submit-area">
												<button type="button" class="update-btn" name="update-btn">Cập nhật</button>
											</div>                     
										</form><!-- /.user update info -->

									</div><!-- /.modal content -->

								</div>
							</div><!-- /.user update form -->
						</li>             

					</ul>
				</div>
			</nav> 
			<!-- /.navbar -->    
		</div>
	</div> <!-- /.big div on top -->

	<!-- content -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-xl-12">
				<div class="content">
					<div class="row">
						<!-- chart -->
						<div class="chart-panel col-md-10 col-lg-10 col-xl-10">
							<div id="chart"></div>
						</div><!-- /.chart -->
						<!-- bet -->
						<div class="bet-panel mt-4 col-md-2 col-lg-2 col-xl-2">
							<!-- bet percent -->
							<div class="percent-panel center mt-3">
								<div id="increase" class="user-percent" data-toggle="tooltip" data-placement="top" title="Yes" data-user-num="276">
									<span class="in-num-percent">50%</span>
								</div>
								<div id="decrease" class="user-percent" data-toggle="tooltip" data-placement="top" title="No" data-user-num="224">
									<span class="de-num-percent">50%</span>
								</div>
							</div><!-- /.bet percent -->

							<div class="time-remaining-area mt-5">
								<span class="time-label">Thời gian còn lại</span><br/>
								<i class="fa fa-clock-o" aria-hidden="true"></i>
								<span class="time-remaining">21:54:55</span>
							</div>

							<!-- bet form -->
							<div class="bet-form-area mt-3">
								<form class="bet-form" name="#!">
									<div class="form-group">
										<label class="input-title" for="point-input">Đặt cược (point)</label>
										<input type="number" class="form-control" id="point-input" name="point-num" min="0" placeholder="0">
									</div>
									<div class="form-group">
										<button type="submit" class="form-control c-button" id="c-bet-btn" name="bet-btn">
											Đặt cược
										</button>
									</div>
								</form>
							</div><!-- /.bet form -->

						</div><!-- /.bet -->
					</div>
				</div>
			</div>      
		</div>
	</div><!-- /.content -->

	<div class="chat-icon-area">
		<!-- Button trigger modal -->
		<button id="chat-btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#chat-panel">
			<i class="fa fa-paper-plane" aria-hidden="true"></i>
		</button>
		<div class="container">
			<div class="row">
				<!-- Modal -->
				<div class="modal fade" id="chat-panel" tabindex="-1" role="dialog" aria-labelledby="chat-panel" aria-hidden="true">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content chat-content">
							<div class="modal-header chat-header">
								<h5 class="modal-title chat-title" id="exampleModal3Label">Trò chuyện</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
							</div>
							<div class="modal-body chat-body scroller-wrap">
								...
							</div>
							<div class="modal-footer chat-footer">
								<div class="chat-message-area col-12 col-xs-12 col-md-12 col-lg-12">
									<form action="#!" class="chat-message">
										<textarea name="" id="" cols="62" rows="1" placeholder="Tin nhắn #chotatca"></textarea>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /.Modal -->

			</div>
		</div>
	</div>

	<!-- footer -->
	<footer>
		<span>&copy; 2017</span>
	</footer>
	<!-- /.footer -->
	<script>
		function logoutFB(){
			FB.getLoginStatus(function(response) {

				if(response.status === 'connected'){
					var uid = response.authResponse.userID;
		            var accessToken = response.authResponse.accessToken;

		            FB.api('/'+ uid +'/permissions', 'delete', function(response){
		            	//console.log(response);
	            	});
				}

	            $.ajax({
	            	url: '/login/fb_Logout',
	            	type: 'POST',
	            	dataType: 'JSON',		            	
	            })
	            .done(function() {
	            	console.log("success");
	            })
	            .fail(function() {
	            	console.log("error");
	            })
	            .always(function() {
	            	console.log("complete");
	            	window.location = base_url;
	            });
			});
		}
	</script>
	
	<script src="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.min.js"></script>
	<!-- popper js -->
	<script src="<?php echo base_url(); ?>assets/popper/popper.min.js"></script>
	<!-- bootstrap js -->
	<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.js"></script>
	<!-- high chart js -->
	<script src="https://code.highcharts.com/5/js/highcharts.js"></script>
	<script src="http://code.highcharts.com/modules/exporting.js"></script>
	<script src="http://code.highcharts.com/modules/heatmap.js"></script>
	<script src="http://code.highcharts.com/adapters/standalone-framework.js"></script>

	<!-- high chart display -->
	<script type="text/javascript" src="<?php echo base_url(); ?>js/client/chartBasicLine.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>js/client/app.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/client/ui.js"></script>
</body>
</html>
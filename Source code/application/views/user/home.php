<!DOCTYPE html>
<html lang="en">
<head>
	<title>Website dự đoán giá bitcoin</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
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
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/animation/animate.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.css">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
	<!-- custom css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/client/main.css">
</head>
<body onload="countDown_End_Date(tt_game_end_date,0);infinitySlideShow();">
	<script>
		var base_url = "<?php echo base_url(); ?>";
		var tt_game_end_date = "<?php echo $TT_END_DATE; ?>";
		var user_id = <?php echo json_encode($user_id); ?>;
		var is_related_YN = <?php echo json_encode($is_related_YN); ?>;
		var is_related_MUL = <?php echo json_encode($is_related_MUL); ?>;
		var is_reward = <?php echo json_encode($is_reward); ?>;
	</script>
	<!-- big div on top -->
	<div class="container-fluid">
		<div class="row">
			<!-- infinite slideshow -->
			<section id="hot-mini-game-area">
				<?php if (empty($ALL_GAME_ACTIVE)) { ?>
				<marquee behavior="scroll" direction="left">Các thử thách đang được hệ thống cập nhật. Hãy tạo nhiều thử thách cho người khác để kiếm nhiều point nào <span><i class="fa fa-smile-o" aria-hidden="true" style="color:pink"></i></span></marquee>
				<?php }else{?>
				<?php shuffle($ALL_GAME_ACTIVE) ?>
				<div id="hot-mini-game-content" class="hot-minigame slider autoplay">
					<?php foreach ($ALL_GAME_ACTIVE as $value): ?>
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
					<?php endforeach?>
				</div>
				<?php } ?>
			</section>
			<!-- /.infinite slideshow -->
			<!-- navbar -->
			<nav id="my-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
				<a class="navbar-brand" href="<?php
					if ($this->session->userdata('loggedInGooge')) {
						echo base_url() . 'login/user';
					} else if ($this->session->userdata('loggedInFB')) {
						echo base_url() . 'login/fb_goHome';
					}else if($this->session->userdata('loggedOther')){
						echo base_url() . 'userct/home';
					}

					?>">Logo</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
					<ul class="nav navbar-nav navbar-right">

						<!-- TODO tao mini game -->
						<li class="func-items nav-item" data-toggle="modal" data-target="#create-game">
							<a href="javascript:void(0);" class="nav-link"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tạo thử thách</a>
						</li>

						<!-- top rank point -->
						<li class="nav-item active top-bar-items" data-toggle="tooltip"
						data-placement="top" title="TOP point">
							<a class="nav-link" data-toggle="modal" data-target=".world-rank" href="#!"><i class="fa fa-trophy" aria-hidden="true"></i></a>
						</li>
						<!-- top rank point -->
						<!-- rank popup -->
						<div class="modal fade world-rank" tabindex="-1" role="dialog"
						aria-labelledby="myLargeModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title col-centered" id="world-rank-title">TOP thành viên có nhiều point nhất</h5>
										<button type="button" class="close cursor-pointer" data-dismiss="modal" aria-label="Close" title="Đóng">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="top-user text-center">
											<div class="second d-inline-block text-center">
												<figure>
													<img src="<?php echo base_url(); ?>images/client/2nd.png" alt="2nd">
													<figcaption class="top-user-name">
														<a href="<?php echo base_url().'userct/profile/'.$top_point[1]['USER_ID']; ?>">
														<?php echo $top_point[1]['USER_NAME']; ?></a>
															
													</figcaption>
													<figcaption class="top-user-point"><span class="second-point"><?php echo $top_point[1]['USER_POINT']; ?></span></figcaption>
												</figure>
											</div>
											<div class="first d-inline-block text-center">
												<figure>
													<img src="<?php echo base_url(); ?>images/client/1st.png" alt="1st">
													<figcaption class="top-user-name">
														<a href="<?php echo base_url().'userct/profile/'.$top_point[0]['USER_ID']; ?>">
														<?php echo $top_point[0]['USER_NAME']; ?></a>
													</figcaption>
													<figcaption class="top-user-point"><span class="first-point"><?php echo $top_point[0]['USER_POINT']; ?></span></figcaption>
												</figure>
											</div>
											<div class="third d-inline-block text-center">
												<figure>
													<img src="<?php echo base_url(); ?>images/client/3rd.png" alt="3rd">
													<figcaption class="top-user-name">
														<a href="<?php echo base_url().'userct/profile/'.$top_point[2]['USER_ID']; ?>">
														<?php echo $top_point[2]['USER_NAME']; ?></a>
														</figcaption>
													<figcaption class="top-user-point"><span class="third-point"><?php echo $top_point[2]['USER_POINT']; ?></span></figcaption>
												</figure>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /.rank popup -->

						<!-- notifications of user -->
						<li class="nav-item top-bar-items cursor-pointer" data-toggle="tooltip"
						data-placement="top" title="Thông báo">
							<div class="dropdown">
								<button id="notifi-btn" class="notifi btn btn-primary dropdown-toggle cursor-pointer" type="button" data-toggle="dropdown">
									<i class="fa fa-bell notifi-icon" aria-hidden="true"></i>
									<div class="notifi-num">
										<p><?php echo $noti->noti_not_seen; ?></p>
									</div>
								</button>
								<!-- notification list -->
								<ul id="user-notifi" class="dropdown-menu dropdown-menu-right pre-scrollable">
								<?php if($noti->all_noti){ ?>
									<?php foreach ($noti->all_noti as $value): ?>
										<li class="noti-items" data-noID="<?php echo $value['NOTICE_ID']; ?>" data-seen="<?php if($value['SEEN'] == 0){echo 0;}else{ echo 1;} ?>" data-gameType="<?php echo $value['TYPE_ID']; ?>" data-gameID="<?php echo $value['GAME_ID']; ?>" class="btn btn-primary" data-toggle="modal" data-target="#notifi-popup">
											<div class="noti-content ellipsis">
												<a href="#!">
													<p class="notifi-title notifi-1" class="ellipsis">
														<div class="green-circle <?php if($value['SEEN'] == 0){echo '';}else{ echo 'already-read';} ?> d-inline-block"></div>
														<?php echo $value['TITLE']; ?>
														<div class="time-area">
															<span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
															<span class="send-date">
																<?php 
															      $date = $value['SEND_DATE'];
															      $date = new DateTime($date);
															      $time = $date->format('H:i:s d-m-Y');
															      echo $time;
													    		?>
													    	</span>
														</div>
													</p>
												</a>
											</div>
										</li>
									<?php endforeach ?>
								<?php }else{ ?>
									<li class="noti-nothing">Không có Thông báo</li>
								<?php } ?>
								</ul><!-- /.notification list -->

								<!-- popup notifi -->
								<div class="modal" id="notifi-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header" id="notifi-title">

												<button type="button" class="close cursor-pointer" data-dismiss="modal" aria-label="Close" title="Đóng">
													<i class="fa fa-times-circle fa-lg" style="color: black" aria-hidden="true"></i>
												</button>
											</div>
											<div class="modal-body" id="notifi-content">

											</div>
										</div>
									</div>
								</div><!-- /.popup notifi -->
							</div>
						</li>
						<!-- end notifications of user -->

						<!-- total point of user -->
						<li class="nav-item active top-bar-items cursor-pointer" data-toggle="tooltip"
						data-placement="top" title="Số point hiện tại">
							<div class="user-point-area">
								<p class="user-point"> <span id="user-point"><?php echo $USER_POINT; ?></span><span class="point-title">(P)</span></p>
							</div>
			            </li>
			            <!-- end total point of user -->

			            <!-- avatar -->
			            <li class="nav-item">
			            	<div class="user-avatar">
			            		<img src="<?php if($this->session->userdata('userData')['USER_AVATAR']){
			            			echo $this->session->userdata('userData')['USER_AVATAR'];
			            		}else{
			            			echo base_url().'images/client/ava-default.png';
			            		} ?>" alt="user default">
			            	</div>
			            </li>
			            <!-- end avatar -->

			            <!-- information of user -->
						<li class="nav-item" id="tooltip-username" data-toggle="tooltip" data-placement="top" title="<?php echo $USER_NAME; ?>">
							<!-- user dropdown button -->
							<div class="dropdown">
								<button id="username-btn" class="user-name btn btn-primary dropdown-toggle cursor-pointer ellipsis" type="button" data-toggle="dropdown">
									<?php echo $USER_NAME; ?>
									<span class="angle-down"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
								</button>
								<ul id="user-func-dropdown" class="dropdown-menu dropdown-menu-right">
									<li class="func-items user-name-btn">
										<button class="btn btn-primary user-name cursor-pointer" data-toggle="modal" data-target="#user-update-info">
											Sửa thông tin
										</button>
									</li>

									<li class="func-items"><a href="<?php echo base_url() . 'userct/history'; ?>" target="_self">Lịch sử</a></li>

									<?php if ($this->session->userdata('loggedInGooge')) {?>
										<li class="func-items"><a href="<?php echo base_url() . 'login/logoutGoogle'; ?>">Đăng xuất</a></li>
									<?php } else if ($this->session->userdata('loggedInFB')) {?>
										<li class="func-items"><a href="javascript:void(0);" onclick="logoutFB()">Đăng xuất</a></li>
									<?php }else if($this->session->userdata('loggedOther')){?>
										<li class="func-items"><a href="<?php echo base_url() . 'userct/logout'; ?>">Đăng xuất</a></li>
									<?php } ?>
								</ul>
							</div> <!-- /.user dropdown button -->

							<!-- create game popup -->
							<div id="create-game" class="modal fade" tabindex="-1" role="dialog"
							aria-labelledby="createGame" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="create-mini-game">Thử thách</h5>
											<button type="button" class="close cursor-pointer" data-dismiss="modal" aria-label="Close" title="Đóng">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<!-- nav creat game -->
											<ul id="nav-game" class="nav nav-tabs">
												<li class="nav-item">
													<a class="nav-link active" href="#yes-no-game">Đúng/Sai</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" href="#multi-choice-game">Lựa chọn</a>
												</li>
											</ul><!-- /.nav create game -->
										</div>
										<!-- tab game -->
										<div class="tab-content game-tab-content">
											<!-- yes/no game -->
											<div role="tabpanel" class="tab-pane active" id="yes-no-game">
												<div class="user-form form" action="#!">
													<div class="message"></div>
													<div class="form-group">
														<label for="game-title">Tên game</label>
														<input type="text" class="form-control d-inline-block" id="game-title" pattern="^.{6,}$" required data-toggle="tooltip" data-placement="bottom" title="Tên game ít nhất phải chứa từ 6 ký tự.">
													</div>
													<div class="form-group d-inline-block">
														<label for="game-date">Vào ngày</label>
														<input type="text" class="form-control d-inline-block" id="game-date-yn" readonly required data-toggle="tooltip" data-placement="left" title="Ngày kết thúc bắt đầu từ hôm nay.">
													</div>
													<div class="form-group d-inline-block">
														<label for="game-time">Kết thúc vào lúc</label>
														<input type="time" class="form-control d-inline-block" id="game-time" placeholder="1" required data-toggle="tooltip" data-placement="bottom" title="Thời gian kết thúc phải lớn hơn thời gian hiện tại.">
													</div>
													<div class="form-group">
														<label for="game-bitcoin-price">Giá Bitcoin trên (Đơn vị: USD)</label>
														<input type="number" class="form-control" id="game-bitcoin-price" placeholder="0" pattern="/^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/" min="0" step="0.01" required data-toggle="tooltip" data-placement="bottom" title="Giá bitcoin phải lớn hơn 0 và tối đa 2 chữ số hàng thập phân !(6,00 = 6.00 USD)">
													</div>
													<div class="form-group submit-area">
														<button type="button" class="game-btn-yes-no btn-height cursor-pointer" id="create-game-btn-yes-no" name="game-btn-yes-no">Tạo</button>
														<button type="button" class="btn-height close-update cursor-pointer" data-dismiss="modal">Đóng</button>
													</div>
												</div>
											</div>
											<!-- end yes/no game -->

											<!-- create game multi -->
											<div role="tabpanel" class="tab-pane" id="multi-choice-game">
												<div class="user-form form" action="#!">
													<div class="message"></div>
													<div class="form-group">
														<label for="game-title">Tên game</label>
														<input type="text" class="form-control d-inline-block" id="game-title-mul" pattern="^.{6,}$" required data-toggle="tooltip" data-placement="bottom" title="Tên game ít nhất phải chứa từ 6 ký tự.">
													</div>
													<div class="form-group d-inline-block">
														<label for="game-date">Vào ngày</label>
														<input type="text" class="form-control d-inline-block" id="game-date-mul" readonly required data-toggle="tooltip" data-placement="left" title="Ngày kết thúc bắt đầu từ hôm nay.">
													</div>
													<div class="form-group d-inline-block">
														<label for="game-time">Kết thúc vào lúc</label>
														<input type="time" class="form-control d-inline-block" id="game-time-mul" min="1" max="24" placeholder="1" required data-toggle="tooltip" data-placement="bottom" title="Thời gian kết thúc phải lớn hơn thời gian hiện tại.">
													</div>
													<div class="form-group">
														<label for="">Giá Bitcoin ? (Đơn vị: USD)</label>
													</div>
													<div class="form-group d-inline-block mr-3">
														<label class="d-block" for="game-bitcoin-price-lower">Dưới</label>
														<input type="number" class="form-control d-inline-block" id="game-bitcoin-price-lower" pattern="/^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/" placeholder="0.01" min="0" step="0.01" required data-toggle="tooltip" data-placement="bottom" title="Giá bitcoin phải lớn hơn 0 và tối đa 2 chữ số hàng thập phân !(6,00 = 6.00 USD)">
													</div>
													<div class="form-group d-inline-block mr-3">
														<label class="d-block" for="game-bitcoin-price-upper">Trên</label>
														<input type="number" class="form-control d-inline-block" id="game-bitcoin-price-upper" pattern="/^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/" placeholder="0.01" min="1"  step="0.01" required data-toggle="tooltip" data-placement="bottom" title="Giá bitcoin phải lớn hơn 0 và tối đa 2 chữ số hàng thập phân !(6,00 = 6.00 USD)">
													</div>
													<div class="form-group d-inline-block mr-3">
														<label class="d-block" for="game-bitcoin-price-between">Nằm giữa</label>
														<input type="number" class="form-control d-inline-block" id="game-bitcoin-price-between-upper" pattern="/^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/" placeholder="0.01" min="0" step="0.01" disabled>
													</div>
													<div class="form-group d-inline-block mr-3">
														<input type="number" class="form-control d-inline-block" id="game-bitcoin-price-between-lower" pattern="/^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/" placeholder="0.01" min="0" step="0.01" disabled>
													</div>
													<div class="form-group submit-area">
														<button type="button" class="game-btn-yes-no btn-height cursor-pointer" id="create-game-btn-mul" name="game-btn-mul">Tạo</button>
														<button type="button" class="btn-height close-update cursor-pointer" data-dismiss="modal">Đóng</button>
													</div>
												</div>
											</div>
											<!-- end create game multi -->
										</div><!-- /.tab game -->
									</div>
								</div>
							</div><!-- /.create game popup -->

							<!-- user update form -->
							<div id="user-update-info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<!-- modal content -->
									<div id="user-update-info" class="modal-content">
										<div class="modal-header user-header">
											<h5 class="user-func-title">Cập nhật thông tin</h5>
											<button type="button" class="close user-btn-close cursor-pointer" data-dismiss="modal" aria-label="Close" title="Đóng">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="message"></div>
										<!-- user update info -->
										<div class="user-form form">
											<div class="row">
												<div class="user-info-left col-3 form-group">
													<!-- user avatar -->
													<div class="user-ava-area">
														<img class="user-avatar" src="<?php if($this->session->userdata('userData')['USER_AVATAR']){echo $this->session->userdata('userData')['USER_AVATAR'];}
														else{echo base_url().'images/client/ava-default.png';} ?>" alt="User's avatar">
														<p class="username ellipsis"><?php echo $USER_NAME; ?></p>
													</div><!-- /.user avatar -->

												</div>
												<!-- user info -->
												<div class="user-info-right col-8 col-centered">
													<div class="form-group">
														<label for="username">Họ và tên</label>
														<input id="username" class="form-control" type="text" name='username' value="" required="">
													</div>
													<div class="form-group">
														<label for="userphone">Số điện thoại</label>
														<input id="userphone" class="form-control" type="text" name='userphone' pattern="^(\+84|0)\d{9,10}$" value="" required="" placeholder="(+84)123456789">
													</div>
													<div class="form-group">
														<label for="useraddress">Địa chỉ</label>
														<input id="useraddress" class="form-control" type="text" name='useraddress' value="" required="">
													</div>
												</div><!-- /.user info -->
											</div>
											<div class="submit-area form-group">
												<button type="submit" class="btn-height update-btn cursor-pointer" id="update-btn">Cập nhật</button>
												<button type="button" class="btn-height close-update cursor-pointer" data-dismiss="modal">Đóng</button>
											</div>
										</div><!-- /.user update info -->

									</div><!-- /.modal content -->

								</div>
							</div>
							<!-- /.user update form -->
						</li>
						<!-- end information of user -->

					</ul>
				</div>
			</nav>
			<!-- /.navbar -->
		</div>
	</div> <!-- /.big div on top -->
	
	<!-- top users achievement -->
	<div class="container-fluid" id="top_users_achievement">
		<?php if(!empty($top_users_achievement)){ ?>
		<marquee behavior="scroll" direction="left">
			Chúc mừng người chơi: <span style="color: #ffbf01;"><?php echo $top_users_achievement[0]['USER_NAME']; ?></span> giành GIẢI NHẤT, <span style="color: #ffbf01;"><?php echo $top_users_achievement[1]['USER_NAME']; ?></span> giành GIẢI NHÌ, <span style="color: #ffbf01;"><?php echo $top_users_achievement[2]['USER_NAME']; ?></span> giành GIẢI BA trong game hệ thống tuần trước. Game hệ thống mới đã được cập nhật, mọi người nhanh tay đặt cược để nhận những giải thưởng giá trị khác.
		</marquee>
		<?php } ?>
	</div>
	<!-- end top users achievement -->
	<!-- content -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-xl-12">
				<div class="content">
					<div class="row">
						<!-- chart -->
						<div class="chart-panel col-md-10 col-lg-10 col-xl-10">
							<!--author: Phong Huy-->
							<div id="chartContainer"></div>
							<!--author: Phong Huy-->
							<div class="game_tt_content text-center">
								<?php echo $GAME_TT_CONTENT; ?>
							</div>
						</div><!-- /.chart -->
						<!-- bet -->
						<div class="bet-panel mt-1 col-md-2 col-lg-2 col-xl-2">
							<div class="time-remaining-area">
								<span class="time-label">THỜI GIAN CÒN LẠI</span><br/>
								<i class="fa fa-clock-o" aria-hidden="true"></i>
								<span class="time-remaining" id="countDown"></span>
							</div>

							<!-- bet form -->
							<div class="bet-form-area mt-2">
								<form class="bet-form">
									<div class="form-group">
										<label class="input-title" for="point-input">Giá Bitcoin Dự Đoán</label>
										<label class="input-des" for="point-input">(Đơn vị: USD)</label>
										<input type="number" class="form-control" id="point-input" name="point-num" min="0" placeholder="0.01" pattern="/^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/" step="0.01" data-toggle="tooltip" data-placement="left" title="Giá bitcoin phải lớn hơn 0 và tối đa 2 chữ số hàng thập phân !(6,00 = 6.00 USD)">
										<label class="input-des" for="point-input">Lưu ý:</label>
										<label class="input-des" for="point-input">Chúng tôi sẽ lấy giá đặt cược cuối cùng của bạn trước khi kết thúc game dự đoán !</label>
										<label class="input-des" for="point-input">Phí đặt cược là: 100 point.</label>
										<label class="input-des" for="point-input">Hệ thống sẽ đóng trước 10s để kết quả được chính xác nhất.</label>
									</div>
									<div class="form-group">
										<button type="button" class="form-control c-button cursor-pointer" id="bet-game_tt" name="bet-btn">
											Đặt Ngay
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
	<!-- dialog-confirm-bet-game-tt -->
	<div id="dialog-confirm-bet-game-tt" class="black"></div>
	<!-- dialog-confirm-bet-game-tt -->
	<!-- chat -->
	<div class="chat-icon-area">
		<div class="icon-and-chat">
			<!-- Button trigger modal -->
			<button id="chat-btn" type="button" class="btn btn-primary cursor-pointer">
				<i class="fa fa-paper-plane" aria-hidden="true"></i>
			</button>
			<!-- Chat panel -->
			<div id="chat-panel">
				<div class="chat-header">
					<h5 class="chat-title">Vinh Nguyễn <span class="close" aria-hidden="true">x</span></h5>
				</div>
				<div class="chat-body">
					...
				</div>
				<div class="chat-footer">
					<div class="chat-message-area">
						<form action="#!" class="chat-message" method="POST">
							<input type="text" placeholder="Tin nhắn...">
						</form>
					</div>
				</div>
			</div><!-- /.Chat panel -->
		</div>
	</div>
	<!-- end chat -->

	<!-- footer -->
	<footer>
		<div>LowHope &copy; 2017. All Right Reserved.</div>
	</footer>
	<!-- /.footer -->

	<script src="<?php echo base_url(); ?>assets/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/jquery/jquery-migrate-1.2.1.min.js"></script>
	<!-- popper js -->
	<script src="<?php echo base_url(); ?>assets/popper/popper.min.js"></script>
	<!-- bootstrap js -->
	<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.js"></script>

	<!-- Pusher -->
	<script src="https://js.pusher.com/4.1/pusher.min.js"></script>

	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

	<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap-confirmation.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/jquery/moment.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>js/client/fb.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/client/user.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/client/yesNoGame.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/client/mulGame.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>js/client/pusher.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>js/client/ui.js"></script>	
	<script type="text/javascript" src="<?php echo base_url(); ?>js/client/app.js"></script>

	<!-- author="Phong Huy" -->
    <!-- <script src="https://js.pusher.com/4.1/pusher.min.js"></script> -->
    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>node-server/public/js/nodeClient_highstock.js"></script>
	<!-- author="Phong Huy" -->
</body>
</html>
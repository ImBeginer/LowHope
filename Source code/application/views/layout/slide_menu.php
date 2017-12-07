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
	}else echo base_url();?>"><img style="width: 135px;" src="<?php echo base_url(); ?>images/client/lhp.png"></a>

	<?php if($this->session->userdata('loggedInGooge') || $this->session->userdata('loggedInFB') || $this->session->userdata('loggedOther')){ ?>
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
									<span aria-hidden="true"><i class="fa fa-times-circle" style="color:black" aria-hidden="true"></i></span>
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
										<span aria-hidden="true"><i class="fa fa-times-circle" style="color:black" aria-hidden="true"></i></span>
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
										<span aria-hidden="true"><i class="fa fa-times-circle" style="color:black" aria-hidden="true"></i></span>
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
	<?php }else{ ?>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          <ul class="nav navbar-nav navbar-right">
            <li class="func-items nav-item" data-toggle="modal" data-target="#create-game">
              <a href="<?php echo base_url(); ?>" class="nav-link">Đăng Nhập</a>
            </li>
          </ul>
        </div>
    <?php } ?>
</nav>
<!-- /.navbar -->
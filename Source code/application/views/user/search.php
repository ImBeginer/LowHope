<!DOCTYPE html>
<html>
<?php $this->load->view('layout/header'); ?>
<body onload="infinitySlideShow(); load_data_search(data);">
	<script type="text/javascript">
		var base_url = "<?php echo base_url(); ?>";
		var data = <?php echo json_encode($all_game); ?>;
	</script>
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

			<nav id="my-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
				<a class="navbar-brand" href="<?php
				if ($this->session->userdata('loggedInGooge')) {
					echo base_url() . 'login/user';
				} else if ($this->session->userdata('loggedInFB')) {
					echo base_url() . 'login/fb_goHome';
				}else if($this->session->userdata('loggedOther')){
					echo base_url() . 'userct/home';
				}else echo base_url();?>"><img style="width: 135px;" src="<?php echo base_url(); ?>images/client/lhp.png"></a>

				<?php if(!$this->session->userdata('loggedInGooge') && !$this->session->userdata('loggedInFB') && !$this->session->userdata('loggedOther')){ ?>
				<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
					<ul class="nav navbar-nav navbar-right">
						<li class="func-items nav-item" data-toggle="modal" data-target="#create-game">
							<a href="<?php echo base_url(); ?>" class="nav-link">Đăng Nhập</a>
						</li>
					</ul>
				</div>
				<?php } ?>
			</nav>
		</div>
	</div>

	<div class="container-fluid mt-5">
		<table id="all_game" class="display" width="100%">
			<thead>
              <tr>
              	<th>STT</th>
                <th>Thử thách</th>
                <th>Người tạo</th>
                <th>TYPE</th>
                <th>Ngày tạo</th>
                <th>Ngày kết thúc</th>
                <th>Trạng thái</th>
              </tr>
            </thead>
		</table>
	</div>

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
	<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
	<!-- bootstrap js -->
	<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.js"></script>

	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

	<script src="<?php echo base_url(); ?>assets/jquery/moment.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/client/pusher.js"></script>
</body>
</html>
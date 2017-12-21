<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('layout/header'); ?>

<style type="text/css">
	.message-box{
		display: flex;
		position: relative;
	}
	.user-info{
		width: 55px;
		height: 55px;
		border-radius: 50%;
	}

	.user-info img {
		width: 100%;
		border-radius: 50%;
	}

	.user-message {
		margin-left: 10px;
		width: 260px;
		background: beige;
	    border-radius: 5px;
	    position: relative;
	}

	.user-message:before {
	    content: "";
	    position: absolute;
	    width: 16px;
	    height: 16px;
	    background-color: beige;
	    top: 25%;
	    left: -7px;
	    transform: rotate(45deg);
	}

	.user-message div{
		color: black;
	}

	.user-message-up {
	    overflow: hidden;
	    font-size: 75%;
	    border-bottom: 0.5px dotted #bdbdad;
	    position: relative;
	    margin-left: 5px;
	    margin-right: 5px;
	}

	.user-message-down {
    	position: relative;
    	margin-left: 5px;
	}
</style>

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
			<?php $this->load->view('layout/slide_menu'); ?>
		</div>
	</div> <!-- /.big div on top -->
	
	<!-- top users achievement -->
	<div class="container-fluid" id="top_users_achievement">
		<?php if(!empty($top_users_achievement)){ ?>
        <marquee behavior="scroll" direction="left">
          <?php if(count($top_users_achievement) == 1){ ?>
            Chúc mừng người chơi: <span style="color: #ffbf01;"><?php echo $top_users_achievement[0]['USER_NAME']; ?></span> giành GIẢI NHẤT trong game hệ thống tuần trước. Game hệ thống mới đã được cập nhật, mọi người nhanh tay đặt cược để nhận những giải thưởng giá trị khác.
          <?php }else if(count($top_users_achievement) == 2){?>
            Chúc mừng người chơi: <span style="color: #ffbf01;"><?php echo $top_users_achievement[0]['USER_NAME']; ?></span> giành GIẢI NHẤT, <span style="color: #ffbf01;"><?php echo $top_users_achievement[1]['USER_NAME']; ?></span> giành GIẢI NHÌ trong game hệ thống tuần trước. Game hệ thống mới đã được cập nhật, mọi người nhanh tay đặt cược để nhận những giải thưởng giá trị khác.
          <?php }else if(count($top_users_achievement) == 3){?>
            Chúc mừng người chơi: <span style="color: #ffbf01;"><?php echo $top_users_achievement[0]['USER_NAME']; ?></span> giành GIẢI NHẤT, <span style="color: #ffbf01;"><?php echo $top_users_achievement[1]['USER_NAME']; ?></span> giành GIẢI NHÌ, <span style="color: #ffbf01;"><?php echo $top_users_achievement[2]['USER_NAME']; ?></span> giành GIẢI BA trong game hệ thống tuần trước. Game hệ thống mới đã được cập nhật, mọi người nhanh tay đặt cược để nhận những giải thưởng giá trị khác.
          <?php } ?>
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
							<div class="game_tt_content text-center mt-3">
								<?php echo 'Câu hỏi tuần này: '.$GAME_TT_CONTENT. ' là bao nhiêu?'; ?>
							</div>
						</div><!-- /.chart -->
						<!-- bet -->
						<div class="bet-panel mt-1 col-md-2 col-lg-2 col-xl-2">
							<div id="bitcoin-predict"><p>Giá tham khảo: </p></div>
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
										<?php if(isset($price_bet_before)){ ?>
										<label class="input-des" id="price-bet-before">(Bạn đã dự đoán: <?php echo $price_bet_before; ?>)</label>
										<?php }else{ ?>
										<label class="input-des" id="price-bet-before">(Bạn chưa tham gia dự đoán)</label>
										<?php } ?>
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
	<!-- <div id="dialog-confirm-bet-game-tt" class="black"></div> -->
	<!-- dialog-confirm-bet-game-tt -->

	<!-- chat -->
	<div class="chat-icon-area">
		<div class="icon-and-chat">
			<!-- Chat panel -->
			<div id="chat-panel">
				<div class="chat-header">
					<h5 class="chat-title"><?php echo $USER_NAME; ?></h5>         
				</div>
				<div class="chat-body pre-scrollable">
					<?php if(!empty($messages)){ ?>
					<?php foreach ($messages as $value): ?>
					<div class="message-box mt-2">
						<div class="user-info">
							<img src="<?php echo $value['AVATAR']; ?>"></div>
						<div class="user-message">
							<div class="user-message-up">
								<div class="chat-name float-left"><?php echo $value['USER_NAME']; ?></div>
								<div class="chat-time float-right">
									<?php
										$date = new DateTime($value['SEND_DATE']);
      									$send_time = $date->format('H:i');
										echo $send_time; 
									?>
								</div>
							</div>
							<div class="user-message-down"><?php echo $value['CONTENT']; ?></div>
						</div>
					</div>
					<?php endforeach ?>
					<?php } ?>
				</div>

				<div class="chat-footer">
					<div class="chat-message-area">
						<input type="text" placeholder="Tin nhắn..." id="send_message_chat">
					</div>            
				</div>
			</div><!-- /.Chat panel -->
			<ul class="chat-gift">
				<li>
					<!-- Button trigger modal -->
					<button id="chat-btn" type="button" class="btn btn-primary cursor-pointer">
						<i class="fa fa-paper-plane" aria-hidden="true"></i>
					</button>
				</li>
				<li id="sub-gift-menu">
					<div id="gift-btn" class="btn btn-primary">
						<img src="<?php echo base_url(); ?>images/client/giftbox.png"/>
					</div>
					<ul class="gift-menu">
						<li class="gift-item">
							<div class="gift-content">
								<figure>
									<img src="<?php echo base_url(); ?>images/client/SH.png" alt="Honda SH">
									<figcaption class="top-user-name font-medium"><a href="#!">1 Giải nhất: 1 xe Honda SH</a></figcaption>
								</figure>
							</div>
						</li>
						<li class="gift-item">
							<div class="gift-content">
								<figure>
									<img src="<?php echo base_url(); ?>images/client/macbook.png" alt="Macbook Pro">
									<figcaption class="top-user-name font-medium"><a href="#!">1 Giải nhì: 1 Macbook Pro</a></figcaption>
								</figure>
							</div>
						</li>
						<li class="gift-item">
							<div class="gift-content">
								<figure>
									<img src="<?php echo base_url(); ?>images/client/iphoneX.png" alt="iPhone X">
									<figcaption class="top-user-name font-medium"><a href="#!">1 Giải ba: 1 iPhone X</a></figcaption>
								</figure>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- end chat -->

	<?php $this->load->view('layout/footer'); ?>
	<!-- author="Phong Huy" -->
    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>node-server/public/js/nodeClient_highstock.js"></script>
   
</body>
</html>
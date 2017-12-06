<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('layout/header');?>

<body onload="countDown_End_Date(end_date_game_mini,1); user_percent_mul(PRICE_BELOW, PRICE_BETWEEN, PRICE_ABOVE);load_table_log_game(list_bet_log); infinitySlideShow(); set_style_table_log_game()"> 
  <script>
    var base_url = "<?php echo base_url(); ?>";
    var end_date_game_mini = "<?php echo $game_data->END_DATE; ?>";
    var PRICE_BELOW = "<?php echo $PRICE_BELOW; ?>" || 0;
    var PRICE_BETWEEN = "<?php echo $PRICE_BETWEEN; ?>" || 0;
    var PRICE_ABOVE = "<?php echo $PRICE_ABOVE; ?>" || 0;

    //data table
    <?php if(isset($list_bet_log)){ ?>
      var list_bet_log = <?php echo json_encode($list_bet_log); ?>;
      for (var i = 0; i < list_bet_log.length; i++) {
        list_bet_log[i].USER_NAME = '<a href="'+ '<?php echo base_url()."userct/profile/";?>' + list_bet_log[i].USER_ID  +'" title="Click để hồ sơ">' + list_bet_log[i].USER_NAME + '</a>';
      }
    <?php }else{?>
    var list_bet_log = [];
    <?php  }?>

    <?php 
      $date = $game_data->END_DATE;
      $date = new DateTime($date);
      $time = $date->format('H:i:s d-m-Y');
    ?>
    <?php if(isset($user_id)){ ?>
      var user_id = <?php echo json_encode($user_id); ?>;
      var is_related_YN = <?php echo json_encode($is_related_YN); ?>;
      var is_related_MUL = <?php echo json_encode($is_related_MUL); ?>;
    <?php } ?>
  </script>
  <!-- body -->
  <div class="container-fluid">
    <div class="row">
      <?php $this->load->view('layout/slide_menu'); ?>

      <!-- top users achievement -->
      <div class="container-fluid" id="top_users_achievement">
        <?php if(!empty($top_users_achievement)){ ?>
        <marquee behavior="scroll" direction="left">
          Chúc mừng người chơi: <span style="color: #ffbf01;"><?php echo $top_users_achievement[0]['USER_NAME']; ?></span> giành GIẢI NHẤT, <span style="color: #ffbf01;"><?php echo $top_users_achievement[1]['USER_NAME']; ?></span> giành GIẢI NHÌ, <span style="color: #ffbf01;"><?php echo $top_users_achievement[2]['USER_NAME']; ?></span> giành GIẢI BA trong game hệ thống tuần trước. Game hệ thống mới đã được cập nhật, mọi người nhanh tay đặt cược để nhận những giải thưởng giá trị khác.
        </marquee>
        <?php } ?>
      </div>
      <!-- end top users achievement -->

      <div id="mgyn-content-area" class="content-area" style="margin-top: -70px!important">
        <!-- content -->
        <div class="content">
          <div class="row">
            <div class="col-6 col-sm-6 col-md-6 col-lg-6">
              <div class="mini-game-panel">
                <div class="mini-game-des">
                  <?php if($game_data->ACTIVE == 1){ ?>
                  <span class="mini-game-status game-opening">ĐANG MỞ</span>
                  <?php }else{ ?>
                  <span class="mini-game-status game-opening">ĐÃ ĐÓNG</span>
                  <?php } ?>
                  <p class="mini-game-title"><?php echo $game_data->TITLE; ?></p>
                  <p class="mini-game-transaction"><?php echo 'Point hiện tại: '.$game_data->TOTAL_AMOUNT; ?></p>
                </div>
                <div class="mini-game-content mb-5" data-gameID="<?php echo $game_data->GAME_ID; ?>">
                  <table class="mini-game-conten-info">
                    <tr>
                      <td>
                        <p class="user-create">Người tạo game:</p>
                      </td>
                      <td>
                        <p class="user-create"><?php echo $game_data->USER_NAME; ?></p>
                      </td>                      
                    </tr>
                    <tr>
                      <td>
                        <p class="close-date">Đóng trong:</p>
                      </td>
                      <td>
                        <p class="close-date" id="game_mini_countdown"></p>
                      </td>                      
                    </tr> 
                    <tr>
                      <td>
                        <p class="create-date">Ngày tạo:</p>
                      </td>
                      <td>
                        <p class="create-date"><?php echo $game_data->START_DATE; ?></p>
                      </td>                      
                    </tr>                                       
                  </table>
                  
                  <!-- bet percent -->
                  <div class="game-mul percent-panel center">
                    <p class="percent-panel-title">Tỷ lệ đặt cược</p>
                    <div id="increase" class="user-percent big-u-p" data-toggle="tooltip" data-placement="top" title="Dưới">
                      <span class="in-num-percent">50%</span>
                    </div>
                    <div id="between" class="user-percent big-u-p" data-toggle="tooltip" data-placement="top" title="Giữa">
                      <span class="be-num-percent">50%</span>
                    </div>
                    <div id="decrease" class="user-percent big-u-p" data-toggle="tooltip" data-placement="top" title="Trên">
                      <span class="de-num-percent">50%</span>
                    </div>
                  </div><!-- /.bet percent -->
                </div>

                <?php if($this->session->userdata('loggedInGooge') || $this->session->userdata('loggedInFB') || $this->session->userdata('loggedOther')){ ?>
                <div class="mini-game-bet mt-5">
                  <form action="#!" name="mini-yn-bet">
                    <div class="form-group no-margin">
                      <label class="no-margin">Giá Bitcoin vào lúc: <?php echo $time; ?> sẽ ?</label>
                    </div>
                    <div class="form-group no-margin">
                      <label class="no-margin">Lựa chọn của bạn:</label>
                    </div>
                    <div class="form-group">  
                      <select name="mul-game" class="mul-mini-game">
                        <option value="0">Dưới <?php echo $game_data->PRICE_BELOW; ?> USD</option>
                        <option value="1">Giữa <?php echo $game_data->PRICE_BELOW; ?> - <?php echo $game_data->PRICE_ABOVE; ?> USD</option>
                        <option value="2">Trên <?php echo $game_data->PRICE_ABOVE; ?> USD</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <p class="caution">Lưu ý: Bạn chỉ được đặt cược duy nhất 1 lần, chi phí là 10 point. Hãy cân nhắc.</p>
                      <p class="caution">(Hệ thống sẽ đóng đặt cược trước 10s để kết quả được chính xác nhất.)</p>
                    </div> 
                    <div class="form-group submit-area">
                      <button type="button" class="game-btn-yes-no btn-height cursor-pointer" id="bet-game-mul" name="bet-game-mul">Đặt cược</button>
                    </div>                       
                  </form>                  
                </div>
                <?php }else{ ?>
                <div class="mini-game-bet mt-5">
                  <form action="#!" name="mini-yn-bet">
                    <div class="form-group no-margin">
                      <label class="no-margin">Giá Bitcoin vào lúc: <?php echo $time; ?> sẽ ?</label>
                    </div>
                    <div class="form-group">  
                      <select name="mul-game" class="mul-mini-game">
                        <option value="0">Dưới <?php echo $game_data->PRICE_BELOW; ?> USD</option>
                        <option value="1">Giữa <?php echo $game_data->PRICE_BELOW; ?> - <?php echo $game_data->PRICE_ABOVE; ?> USD</option>
                        <option value="2">Trên <?php echo $game_data->PRICE_ABOVE; ?> USD</option>
                      </select>
                    </div>                                       
                  </form>                  
                </div>
                <p class="no-margin">Bạn cần <a href="<?php echo base_url(); ?>">Đăng nhập </a> để đặt cược trò chơi !</p> 
                <?php } ?>
              </div>
            </div>

            <div id="mgyn-contact-area" class="col-6 col-sm-6 col-md-6 col-lg-6">
              <div class="row">
                <div class="col-sm-12 mb-3 giaodich">
                  <a data-toggle="collapse" href="#game-transaction" aria-expanded="true" aria-controls="game-transaction">
                    <i class="fa fa-gavel" aria-hidden="true"></i> Lịch sử đặt cược 
                  </a>
                </div>
                <div class="col-sm-12">
                  <div class="collapse show" id="game-transaction">
                    <div class="card card-body">
                      <table id="list-bet-log" data-info="false" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Thời gian</th>
                            <th>Người chơi</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div><!-- /.content -->
      </div>
    </div>
  </div><!-- /.body -->

  <?php $this->load->view('layout/footer'); ?>
</body>
</html>
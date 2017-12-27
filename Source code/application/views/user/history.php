<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('layout/header'); ?>
<body onload="infinitySlideShow(); user_percent_in_de(winners,losers);">
  <script>
    var base_url = "<?php echo base_url(); ?>";
    <?php if(isset($user_id)){ ?>
      var user_id = <?php echo json_encode($user_id); ?>;
      var is_related_YN = <?php echo json_encode($is_related_YN); ?>;
      var is_related_MUL = <?php echo json_encode($is_related_MUL); ?>;
    <?php } ?>
      var winners = <?php echo json_encode($user_view_total_game_win); ?>;
      var losers = <?php echo json_encode($user_view_total_game) - json_encode($user_view_total_game_win); ?>;
  </script>
  <!-- body -->
  <div class="container-fluid">
    <div class="row">
      <?php $this->load->view('layout/slide_menu'); ?>
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

      <div id="history-content-area" class="content-area">
        <div class="col-12 col-centered">
          <h6 id="game-history-title">Lịch sử chơi game của: <?php echo $user_view_name; ?> </h6>
        </div>
        <!-- content -->
        <div class="content" style="display: flex;">
            <div class="col-9 col-sm-9 col-md-9 col-lg-9">
              <!-- game history popup -->
              <div id="game-history-popup">
                <!-- nav game -->
                <ul id="nav-game" class="nav nav-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" href="#tranditional-game">Game Hệ Thống</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#mini-game">Thử Thách</a>
                  </li>
                </ul><!-- /.nav game --> 

                <!-- tab game -->
                <div class="tab-content game-tab-content pre-scrollable">
                  <div role="tabpanel" class="tab-pane active" id="tranditional-game">
                    <table id="traditional-game-table" class="table table-sm">
                      <thead class="thead-default">
                        <tr>
                          <th>STT</th>
                          <th>Bắt đầu</th>
                          <th>Kết thúc</th>
                          <th>Kết quả</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php if(!empty($user_view['achievements_system'])){ ?>  
                        <?php foreach ($user_view['achievements_system'] as $key => $value): ?>
                          <tr>
                            <th scope="row"><?php echo $key+1; ?></th>
                            <td>
                              <?php 
                                $start_date_system = $value['START_DATE'];
                                $start_date_system = new DateTime($start_date_system);
                                $start_date_system = $start_date_system->format('d-m-Y');
                                echo $start_date_system;
                              ?>
                            </td>
                            <td>
                              <?php 
                                $end_date_system = $value['END_DATE'];
                                $end_date_system = new DateTime($end_date_system);
                                $end_date_system = $end_date_system->format('d-m-Y');
                                echo $end_date_system;
                              ?>
                            </td>
                            <td>
                              <?php if($value['PRIZE'] == 1){ ?>
                                <img src="<?php echo base_url(); ?>images/client/1st.png" alt="Giải nhất" title="Giải nhất">
                              <?php }else if($value['PRIZE'] == 2){ ?>
                                <img src="<?php echo base_url(); ?>images/client/2nd.png" alt="Giải nhì" title="Giải nhì">
                              <?php }else if($value['PRIZE'] == 3){ ?>
                                <img src="<?php echo base_url(); ?>images/client/3rd.png" alt="Giải ba" title="Giải ba">
                              <?php } ?>
                            </td>
                          </tr>
                        <?php endforeach ?>
                      <?php }else{ ?>
                        <tr>
                          <td>Chưa giành được giải thưởng nào.</td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                      <?php } ?>                            
                      </tbody>
                    </table>            
                  </div>
                  <div role="tabpanel" class="tab-pane pre-scrollable" id="mini-game">
                    <table id="mini-game-table" class="table table-sm">
                      <thead class="thead-default">
                        <tr>
                          <th>STT</th>
                          <th>Tên Thử Thách</th>
                          <th>Loại Thử Thách</th>
                          <th>Kết quả</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php if(!empty($user_view['result_bet_mini_game'])){ ?>
                        <?php foreach ($user_view['result_bet_mini_game'] as $key => $value): ?>
                          <tr>
                            <th scope="row"><?php echo $key+1; ?></th>
                            <td data-toggle="tooltip" data-placement="top" title="<?php echo $value['TITLE']; ?>"><div class="table-game-title ellipsis"><?php echo $value['TITLE']; ?></div></td>
                            <td>
                              <?php if($value['TYPE'] == 'YN'){echo 'Đúng/Sai';}else if($value['TYPE'] == 'MUL'){echo 'Lựa Chọn';} ?>
                            </td>
                            <td><?php if($value['IS_WINNER'] == 1){echo 'Thắng';}else if($value['IS_WINNER'] == 0){echo 'Thua';}else{echo 'Đang chơi';} ?></td>
                          </tr>
                        <?php endforeach ?>
                      <?php }else{ ?>
                        <tr>
                          <td>Chưa tham gia thử thách nào.</td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                      <?php } ?>
                      </tbody>
                    </table>  
                  </div>
                </div><!-- /.tab game --> 
              </div><!-- /.game history popup -->

              <?php if($this->session->userdata('loggedInGooge') || $this->session->userdata('loggedInFB') || $this->session->userdata('loggedOther')){ ?>
                <?php if($is_history) {?>
                    <div class="row mt-3">
                      <div class="col-12">Tổng kết tiền nào</div>
                      <div class="col-12 mt-3">
                        <table id="mini-game-table" class="table table-bordered">
                          <thead class="thead-default">
                            <tr>
                              <th>STT</th>
                              <th>Game ID</th>
                              <th>Tên game</th>
                              <th>Loại game</th>
                              <th>Trạng thái</th>
                              <th>Kết quả</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php if(!empty($user_history)){ ?>
                            <?php foreach ($user_history as $key => $value): ?>
                              <tr>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo $value['GAME_ID']; ?></td>
                                <td data-toggle="tooltip" data-placement="top" title="<?php echo $value['TITLE']; ?>"><?php echo $value['TITLE']; ?></td>
                                <td><?php if($value['TYPE'] == 'YN'){echo 'Đúng/Sai';}else if($value['TYPE'] = 'MUL'){echo 'Lựa Chọn';} ?></td>
                                <td><?php if($value['ACTIVE'] == 0){echo 'Đã đóng';}else{echo 'Đang mở';} ?></td>
                                <td>
                                  <?php 
                                    $result =  $value['TOTAL_AMOUNT']-$value['WINNERS']*20;
                                    if($result == 0) {echo 'Hòa'; }
                                    else if($result > 0) {echo '+'.$result.'p';}
                                    else {echo $result.'p';}
                                  ?>
                                </td>
                                <td><a href="<?php if($value['TYPE'] == 'YN'){echo '#'.$value['GAME_ID'].'-YN';}else{echo '#'.$value['GAME_ID'].'-MUL';} ?>" data-toggle="collapse">Chi tiết</a></td>
                              </tr>
                              <tr id="<?php if($value['TYPE'] == 'YN'){echo $value['GAME_ID'].'-YN';}else{echo $value['GAME_ID'].'-MUL';} ?>" class="collapse" >
                                <td colspan="7">
                                  <div>Tên game: <?php echo $value['TITLE']; ?></div>
                                  <div>Ngày tạo: <?php echo $value['START_DATE']; ?></div>
                                  <div>Ngày kết thúc: <?php echo $value['END_DATE']; ?></div>
                                  <div>Tổng số người chơi: <?php echo $value['TOTAL_AMOUNT']/10; ?></div>
                                  <div>Người thắng: <?php echo $value['WINNERS']; ?></div>
                                  <div>Người thua: <?php echo $value['LOSERS']; ?></div>
                                </td>
                              </tr>
                            <?php endforeach ?>
                          <?php }else{ ?>
                            <tr>
                              <td colspan="7">Chưa có game nào kết thúc nên không tổng kết được tiền.</td>
                            </tr>
                          <?php } ?>
                          </tbody>
                        </table>
                      </div>

                      <?php if(!empty($games_no_player)){ ?>
                      <div class="col-12">Các game không có người chơi <span><i class="fa fa-frown-o" aria-hidden="true"></i></span></div>
                      <div class="col-12 mt-3">
                        <table id="mini-game-table" class="table table-bordered">
                          <thead class="thead-default">
                            <tr>
                              <th>STT</th>
                              <th>Game ID</th>
                              <th>Tên game</th>
                              <th>Loại game</th>
                              <th>Trạng thái</th>
                              <th>Kết quả</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($games_no_player as $key => $value): ?>
                              <tr>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo $value['GAME_ID']; ?></td>
                                <td><?php echo $value['TITLE']; ?></td>
                                <td><?php if($value['TYPE'] == 'YN'){echo 'Đúng/Sai';}else if($value['TYPE'] = 'MUL'){echo 'Lựa Chọn';} ?></td>
                                <td>Đã đóng</td>
                                <td>-50p</td>
                              </tr>
                            <?php endforeach ?>
                          </tbody>
                        </table>
                      </div>
                      <?php } ?>
                    </div>
                <?php } ?>
              <?php } ?>
            </div>

            <div id="history-user-info" class="col-3 col-sm-3 col-md-3 col-lg-3" style="height: 260px">
              <div class="user-info-area">
                <!-- user avatar -->
                <div id="history-username-area" class="user-ava-area">
                  <img class="user-avatar d-inline-block" src="<?php if(!empty($user_avatar)){echo $user_avatar;}else{echo base_url().'images/client/ava-default.png';} ?>" alt="User's avatar">
                  <p id="history-username" class="username ellipsis d-inline-block"><?php echo $user_view_name; ?></p>
                </div><!-- /.user avatar -->

                <!-- user percent -->
                <div class="percent-panel center mt-3">
                  <p class="percent-panel-title">Tỷ lệ thắng thua</p>
                  <div id="increase" class="user-percent" data-toggle="tooltip" data-placement="top" title="Thắng">
                    <span class="in-num-percent">50%</span>
                  </div>
                  <div id="decrease" class="user-percent" data-toggle="tooltip" data-placement="top" title="Thua">
                    <span class="de-num-percent">50%</span>
                  </div>
                  <p class="game-des mt-5">Tham gia: <span class="total-game"><?php echo $user_view_total_game; ?> game</span>,<span class="win"><?php echo $user_view_total_game_win; ?> thắng</span>,<span class="lose"><?php echo $user_view_total_game-$user_view_total_game_win; ?> thua.</span></p>
                </div><!-- /.user percent -->
                <div class="user-info">
                  <p class="user-point">Point: <?php echo $user_view_point; ?></p>
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
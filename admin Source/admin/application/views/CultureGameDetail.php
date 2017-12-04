<!DOCTYPE html>
<html>
<head>
  <title>Culture game detail</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- jQuery UI -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.min.css">
  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/bootstrapv3.min.css">
  <!-- Animate -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/animation/animate.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css">
  <!-- custom css -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/main.css">
</head>
<body>

<!-- notification content -->
<div class="notification-content container-fluid">
   <!-- side bar -->
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
      <ul class="sidebar-content nav nav-sidebar">
        <li class="manager-avatar c-active">
          <a class="manager-link" href="#!"><img src="<?php echo base_url().'img/ava-default.png'; ?>" alt="avatar"></a>
          <div class="manager-name ellipsis collapsed cursor-pointer" data-toggle="collapse" data-target="#user-option">Vinh Nguyễn</div>
          <ul class="sub-menu collapse" id="user-option">
            <li class="cursor-pointer"><a href="<?php echo base_url().'ManagerInfo/'; ?>">Thông tin cá nhân</a></li>
            <li class="cursor-pointer"><a href="<?php echo base_url().'EditManagerInfo/'; ?>">Sửa thông tin</a></li>
            <li class="cursor-pointer"><a href="<?php echo base_url().'ChangePassword/'; ?>">Đổi mật khẩu</a></li>
          </ul>             
        </li>
        <li class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="Tổng quát về website" ><a href="<?php echo base_url().'Home/'; ?>">Tổng quát</a></li>        
        <li class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="Gửi thông báo đến người chơi"><a href="<?php echo base_url().'Notification/'; ?>">Gửi thông báo</a></li>
        <li class="cursor-pointer c-active" data-toggle="tooltip" data-placement="top" title="Lịch sử game"><a href="<?php echo base_url().'CultureGame/'; ?>">Lịch sử</a></li>
        <li class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="Tạo game cho người chơi"><a href="#!">Tạo game</a></li>

        <li data-toggle="collapse" data-target="#admin-option" class="" aria-expanded="true">
          <a href="#!">Quản lý</a>
        </li>
        <ul class="sub-menu collapse" id="admin-option">
          <li class="c-active"><a href="#!">Block Manager</a></li>
          <li><a href="#!">Unblock Manager</a></li>
          <li><a href="#!">Giải thưởng</a></li>
        </ul>      
      </ul>
      <div class="manager-option-area c-active" title="Đăng xuất">
        <a class="log-out cursor-pointer" href="<?php echo base_url().'Login/logOut'; ?>">
          <i class="fa fa-power-off" aria-hidden="true"></i>
        </a>
      </div>
    </div>
  </div><!-- /.side bar -->
  <!-- right side hand -->
  <div class="row">
    <!-- game-content-detail -->
    <div id="cul-game-content-detail" class="right-side-hand col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 game-content">
      <div class="main-function">
        <!-- icon sidebar -->
        <div class="sidebar-icon-area" title="Sidebar">
          <div id="nav-icon1">
            <span></span>
            <span></span>
            <span></span>
          </div>      
        </div><!-- /.icon sidebar -->        
        <div class="row">
          <div class="function-title">
            <p class="title">Game truyền thống: <?php echo $game_name; ?></p>
          </div>
          <!-- game info -->
          <div class="game-info">
            <!-- game table info -->
            <table class="game-table-info">
              <tr>
                <td>
                  <p class="user-tran cursor-pointer" data-toggle="tooltip" data-placement="top" title="Ngày tạo game"><?php echo $start_date; ?><i class="fa fa-calendar" aria-hidden="true"></i></p>
                </td>
                <td data-toggle="tooltip" data-placement="top" title="Ngày kết thúc game">
                  <p class="user-join cursor-pointer"><?php echo $end_date; ?><i class="fa fa-calendar-times-o" aria-hidden="true"></i></p>
                </td>
                <td data-toggle="tooltip" data-placement="top" title="Tham gia">
                  <p class="game-close-in cursor-pointer"><?php echo count($player) ?><i class="fa fa-user" aria-hidden="true"></i></p>
                </td>                  
                <td data-toggle="tooltip" data-placement="top" title="Tổng giao dịch">
                  <p class="game-created-date cursor-pointer"><?php echo (count($player) * 500); ?><i class="fa fa-gavel" aria-hidden="true"></i></p>
                </td>
                <td data-toggle="tooltip" data-placement="top" title="Kết quả giá bitcoin">
                  <p class="game-created-date cursor-pointer"><?php if ($active == 1) echo 'đang cập nhật'; else echo $result; ?><i class="fa fa-flag-checkered" aria-hidden="true"></i></p>
                </td>                
              </tr>
            </table><!-- /.game table info -->
            <!-- user join -->
            <table class="user-join">
              <thead>
                <tr>
                  <th class="text-center wd-4">#</th>
                  <th>Tên</th>
                  <th>Thời gian giao dịch</th>
                  <th class="text-center">Giao dịch</th>
                  <th class="text-center">Dự đoán</th>
                  <th class="text-center">Lệch</th>
                  <th class="text-center">Kết quả</th>
                </tr>                
              </thead>
              <tbody>
                <?php if ($active == 1): ?>
                  <!-- game finished not yet -->
                  <?php foreach ($player as $value): ?>
                    <tr>
                      <td class="text-center wd-4">2</td>
                      <td><a href="#!"><?= $value['USER_NAME']; ?></a></td>
                      <td><?= $value['DATE_GUESS']; ?></td>
                      <td class="text-center">100</td>
                      <td class="text-center"><?= $value['PRICE_GUESS']; ?> USD</td>
                      <td class="text-center"><?php if ($active == 1) echo 'Đang cập nhật'; else echo ($result - $value['PRICE_GUESS']); ?></td>
                      <td class="text-center"><img class="img-in-list rank" src="<?php echo base_url().'img/dash.png'; ?>" alt="1st">
                      </td>
                    </tr>
                  <?php endforeach ?>

                <?php else: ?>
                  <!-- game finished -->
                  <!-- find 1st -->
                  <?php foreach ($player as $value): 
                    if ($value['USER_ID'] == $user_champion_id[0]) {
                  ?>
                    <tr>
                      <td class="text-center wd-4">1</td>
                      <td><a href="#!"><?= $value['USER_NAME']; ?></a></td>
                      <td><?= $value['DATE_GUESS']; ?></td>
                      <td class="text-center">100</td>
                      <td class="text-center"><?= $value['PRICE_GUESS']; ?> USD</td>
                      <td class="text-center"><?php if ($active == 1) echo 'Đang cập nhật'; else echo ($result - $value['PRICE_GUESS']); ?></td>
                      <td class="text-center"><img class="img-in-list rank" src="<?php echo base_url().'img/1st.png'; ?>" alt="1st">
                      </td>
                    </tr>
                  <?php 
                    }
                  endforeach ?>
                  <!-- find 2nd -->
                  <?php foreach ($player as $value): 
                    if ($value['USER_ID'] == $user_champion_id[1]) {
                  ?>
                    <tr>
                      <td class="text-center wd-4">2</td>
                      <td><a href="#!"><?= $value['USER_NAME']; ?></a></td>
                      <td><?= $value['DATE_GUESS']; ?></td>
                      <td class="text-center">100</td>
                      <td class="text-center"><?= $value['PRICE_GUESS']; ?> USD</td>
                      <td class="text-center"><?php if ($active == 1) echo 'Đang cập nhật'; else echo ($result - $value['PRICE_GUESS']); ?></td>
                      <td class="text-center"><img class="img-in-list rank" src="<?php echo base_url().'img/3rd.png'; ?>" alt="1st">
                      </td>
                    </tr>
                  <?php 
                    }
                  endforeach ?>
                  <!-- find 3rd -->
                  <?php foreach ($player as $value): 
                    if ($value['USER_ID'] == $user_champion_id[2]) {
                  ?>
                    <tr>
                      <td class="text-center wd-4">2</td>
                      <td><a href="#!"><?= $value['USER_NAME']; ?></a></td>
                      <td><?= $value['DATE_GUESS']; ?></td>
                      <td class="text-center">100</td>
                      <td class="text-center"><?= $value['PRICE_GUESS']; ?> USD</td>
                      <td class="text-center"><?php if ($active == 1) echo 'Đang cập nhật'; else echo ($result - $value['PRICE_GUESS']); ?></td>
                      <td class="text-center"><img class="img-in-list rank" src="<?php echo base_url().'img/3rd.png'; ?>" alt="1st">
                      </td>
                    </tr>
                  <?php 
                    }
                  endforeach ?>
                  <!-- show anyone is not champion -->
                  <?php foreach ($player as $value): 
                    if ($value['USER_ID'] != $user_champion_id[0] && $value['USER_ID'] != $user_champion_id[1] && $value['USER_ID'] != $user_champion_id[2]) {
                  ?>
                    <tr>
                      <td class="text-center wd-4">2</td>
                      <td><a href="#!"><?= $value['USER_NAME']; ?></a></td>
                      <td><?= $value['DATE_GUESS']; ?></td>
                      <td class="text-center">100</td>
                      <td class="text-center"><?= $value['PRICE_GUESS']; ?> USD</td>
                      <td class="text-center"><?php if ($active == 1) echo 'Đang cập nhật'; else echo ($result - $value['PRICE_GUESS']); ?></td>
                      <td class="text-center"><img class="img-in-list rank" src="<?php echo base_url().'img/dash.png'; ?>" alt="1st">
                      </td>
                    </tr>
                  <?php 
                    }
                  endforeach ?>

                <?php endif ?>


                

                <!-- <tr>
                  <td class="text-center wd-4">1</td>
                  <td><a href="#!">Karmen Setliff</a></td>
                  <td>31/10/2017</td>
                  <td class="text-center">326</td>
                  <td class="text-center">5900 USD</td>
                  <td class="text-center">100 USD</td>
                  <td class="text-center"><img class="img-in-list rank" src="../img/1st.png" alt="1st"></td>
                </tr>
                <tr>
                  <td class="text-center wd-4"><a href="#!">2</a></td>
                  <td><a href="#!">Rosalia Sperling</a></td>
                  <td>31/10/2017</td>
                  <td class="text-center">599</td>
                  <td class="text-center">5750 USD</td>
                  <td class="text-center">250 USD</td>
                  <td class="text-center"><img class="img-in-list rank" src="../img/2nd.png" alt="2nd"></td>
                </tr>
                <tr>
                  <td class="text-center wd-4"><a href="#!">3</a></td>
                  <td><a href="#!">Donetta Rozar</a></td>
                  <td>31/10/2017</td>
                  <td class="text-center">7544</td>
                  <td class="text-center">4000 USD</td>
                  <td class="text-center">2000 USD</td>
                  <td class="text-center"><img class="img-in-list rank" src="../img/3rd.png" alt="3rd"></td>
                </tr>
                <tr>
                  <td class="text-center wd-4"><a href="#!">4</a></td>
                  <td><a href="#!">Donetta Rozar</a></td>
                  <td>30/10/2017</td>
                  <td class="text-center">3354</td>
                  <td class="text-center">3950 USD</td>
                  <td class="text-center">2050 USD</td>
                  <td class="text-center"><img class="img-in-list rank" src="../img/dash.png" alt="no-rank"></td>
                </tr>
                <tr>
                  <td class="text-center wd-4"><a href="#!">5</a></td>
                  <td><a href="#!">Tona Marmon</a></td>
                  <td>30/10/2017</td>
                  <td class="text-center">4455</td>
                  <td class="text-center">3000 USD</td>
                  <td class="text-center">3000 USD</td>
                  <td class="text-center"><img class="img-in-list rank" src="../img/dash.png" alt="no-rank"></td>
                </tr>
                <tr>
                  <td class="text-center wd-4"><a href="#!">6</a></td>
                  <td><a href="#!">Audra Hoelscher</a></td>
                  <td>29/10/2017</td>
                  <td class="text-center">666</td>
                  <td class="text-center">2900 USD</td>
                  <td class="text-center">3100 USD</td>
                  <td class="text-center"><img class="img-in-list rank" src="../img/dash.png" alt="no-rank"></td>
                </tr>
                <tr>
                  <td class="text-center wd-4"><a href="#!">7</a></td>
                  <td><a href="#!">Pinkie Wellner</a></td>
                  <td>29/10/2017</td>
                  <td class="text-center">444</td>
                  <td class="text-center">2800 USD</td>
                  <td class="text-center">3200 USD</td>
                  <td class="text-center"><img class="img-in-list rank" src="../img/dash.png" alt="no-rank"></td>
                </tr>
                <tr>
                  <td class="text-center wd-4"><a href="#!">8</a></td>
                  <td><a href="#!">Afton Dunning</a></td>
                  <td>28/10/2017</td>
                  <td class="text-center">222</td>
                  <td class="text-center">2700 USD</td>
                  <td class="text-center">3300 USD</td>
                  <td class="text-center"><img class="img-in-list rank" src="../img/dash.png" alt="no-rank"></td>
                </tr>
                <tr>
                  <td class="text-center wd-4"><a href="#!">9</a></td>
                  <td><a href="#!">Augusta Sliva</a></td>
                  <td>27/10/2017</td>
                  <td class="text-center">999</td>
                  <td class="text-center">2600 USD</td>
                  <td class="text-center">3400 USD</td>
                  <td class="text-center"><img class="img-in-list rank" src="../img/dash.png" alt="no-rank"></td>
                </tr> 
                <tr>
                  <td class="text-center wd-4"><a href="#!">10</a></td>
                  <td><a href="#!">Kory Tibbals</a></td>
                  <td>26/10/2017</td>
                  <td class="text-center">444</td>
                  <td class="text-center">2500 USD</td>
                  <td class="text-center">3500 USD</td>
                  <td class="text-center"><img class="img-in-list rank" src="../img/dash.png" alt="no-rank"></td>
                </tr>                                -->
              </tbody>
            </table><!-- /.user join -->
          </div><!-- /.game info -->
        </div>
      </div>
    </div><!-- /.game-content-detail -->
    <!-- footer -->
    <footer>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 footer-content medium-font-size">
        &copy; 2017
        <div class="about-us">
          <a class="black medium-font-size" href="#!">Về chúng tôi</a>
          <a class="black medium-font-size" href="#!">Các điều khoản và chính sách</a>
          <a class="black medium-font-size" href="#!">Hướng dẫn sử dụng</a>
        </div>
      </div>
    </footer><!-- /.footer -->    
  </div><!-- /.right side hand -->
</div><!-- /.notification content -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/jquery/jquery-1.12.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>assets/popper/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.js"></script>

<script src="<?php echo base_url(); ?>js/ui.js"></script>
</body>
</html>
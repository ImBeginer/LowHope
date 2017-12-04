<!DOCTYPE html>
<html>
<head>
  <title>Chi tiết game</title>
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
<body onload="countDown_End_Date('<?php echo $end_date; ?>');">

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
        <li class="cursor-pointer c-active" data-toggle="tooltip" data-placement="top" title="Tổng quát về website" ><a href="<?php echo base_url().'Home/'; ?>">Tổng quát</a></li>        
        <li class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="Gửi thông báo đến người chơi"><a href="<?php echo base_url().'Notification/'; ?>">Gửi thông báo</a></li>
        <li class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="Lịch sử game"><a href="<?php echo base_url().'CultureGame/'; ?>">Lịch sử</a></li>
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
    <div id="game-content-detail" class="right-side-hand col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 game-content">
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
            <p class="title"><?php echo $game_name ?></p>
          </div>
          <!-- game info -->
          <div class="game-info">
            <!-- game table info -->
            <table class="game-table-info">
              <tr>
                <td>
                  <p class="user-tran cursor-pointer">Giao dịch: <?php echo $total_amount ?><i class="fa fa-gavel" aria-hidden="true"></i></p>
                </td>
                <td>
                  <p class="user-join cursor-pointer">Tham gia: <?php echo $player_count ?><i class="fa fa-user" aria-hidden="true"></i></p>
                </td>
                <td>
                  <p class="game-close-in">Còn lại: <i class="fa fa-clock-o" aria-hidden="true"></i></p>
                </td>                  
                <td>
                  <p class="game-created-date">Thời gian tạo: <?php echo $created_date ?><i class="fa fa-calendar" aria-hidden="true"></i></p>
                </td>
                <td>
                  <p class="game-type">Loại: <?php echo $type ?></p>
                </td>  
              </tr>
            </table><!-- /.game table info -->
            <!-- user join -->
            <table class="user-join">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th>Tên</th>
                  <th>Giao dịch</th>
                  <th class="text-center">Ngày giao dịch</th>
                </tr>                
              </thead>
              <tbody>
                <?php 
                  $count = 1;
                  foreach ($userList as $user) {  
                ?>
                    <tr>
                      <td class="text-center"><?php echo $count; ?></td>
                      <td><?php echo $user['USER_NAME']; ?></td>
                      <td>10</td>
                      <td class="text-center"><?php echo $user['CREATED_DATE']; ?></td>
                    </tr>
                <?php
                    $count++;
                  }
                ?>
              </tbody>
            </table><!-- /.user join -->

            <div class="game-func">
              <p class="tag active-func"><a id="999" class="deactive-game" href="#!">DEACTIVE</a></p>
              <p class="tag user-func"><a id="user-id" ><?php echo $owner; ?></a></p>
              <p class="tag open-tag"><?php if ($active == 1) { echo "Đang mở"; } else { echo "Đã đóng"; }?></p>
            </div>

          </div><!-- /.game info -->
        </div>
      </div>
    </div><!-- /.game-content-detail -->
    <div id="dialog-confirm" class="black"></div>
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
<script src="<?php echo base_url(); ?>js/gameDetail.js"></script>
</body>
</html>


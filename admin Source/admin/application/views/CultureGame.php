<!DOCTYPE html>
<html>
<head>
  <title>Danh sách game truyền thống</title>
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
          <div class="manager-name ellipsis collapsed cursor-pointer" data-toggle="collapse" data-target="#user-option"><?php echo $userName ?></div>
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

        <li data-toggle="collapse" data-target="#admin-option" class="cursor-pointer" aria-expanded="true">
          <a>Quản lý</a>
        </li>
        <ul class="sub-menu collapse" id="admin-option">
          <li class="c-active"><a href="<?php echo base_url().'ChangeManager'; ?>">Block or Unblock Manager</a></li>
          <li><a href="<?php echo base_url().'ChangeGift'; ?>">Giải thưởng</a></li>
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
            <p class="title font-extra-bold font-extra-big">Danh sách game truyền thống</p>
          </div>
          <!-- game info -->
          <div class="game-info">
            <!-- game table info -->
            <table class="game-table-info">
              <tr>
                <td data-toggle="tooltip" data-placement="top" title="Tổng số game truyền thống đã được tạo">
                  <strong><p class="user-tran cursor-pointer">Tổng số game: <?php echo count($game_info); ?></p></strong>
                </td>
              </tr>
            </table><!-- /.game table info -->
            <!-- user join -->
            <table class="user-join">
              <thead>
                <tr>
                  <th class="text-center wd-4">#</th>
                  <th class="text-center">Nội dung</th>
                  <th>Thời gian tạo</th>
                  <th>Thời gian kết thúc</th>
                  <!-- <th class="text-center">Tổng giao dịch</th> -->
                </tr>                
              </thead>
              <tbody>
                
                <?php 
                  $count = 1;
                  foreach ($game_info as $game) {
                ?>
                    <tr>
                      <td class="text-center wd-4"><?php echo $count?></td>
                      <td class="text-center"><a href="<?php echo base_url().'CultureGameDetail/index/'.$game['GAME_ID'] ?>"><?php echo $game['CONTENT']?></a></td>
                      <td><?php echo $game['START_DATE'];?></td>
                      <td><?php echo $game['END_DATE'];?></td>
                      
                      <!-- <td class="text-center">16659<i class="fa fa-gavel mg-1" aria-hidden="true"></i></td> -->
                    </tr>
                <?php
                    $count++;
                  }
                ?>
              </tbody>
            </table><!-- /.user join -->
          </div><!-- /.game info -->
        </div>
      </div>
    </div><!-- /.game-content-detail --> 
  </div><!-- /.right side hand -->
</div><!-- /.notification content -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/jquery/jquery-1.12.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>assets/popper/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.js"></script>

<script src="<?php echo base_url(); ?>js/checkData.js"></script>
<script src="<?php echo base_url(); ?>js/ui.js"></script>
</body>
</html>

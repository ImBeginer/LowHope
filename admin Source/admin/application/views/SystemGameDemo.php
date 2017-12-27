<!DOCTYPE html>
<html>
<head>
  <title>Demo hệ thống</title>
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
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/main.css">
</head>
<body>
  <script>
    var base_url = '<?php echo base_url(); ?>';
  </script>
<!-- notification content -->
<div class="notification-content container-fluid">
  <!-- side bar -->
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
      <ul class="sidebar-content nav nav-sidebar">
        <li class="manager-avatar c-active">
          <a class="manager-link" href="#!"><img src="<?php if ($avatar == '') echo base_url().'img/ava-default.png'; else echo $avatar; ?>" alt="avatar"></a>
          <div class="manager-name ellipsis collapsed cursor-pointer" data-toggle="collapse" data-target="#user-option"><?php echo $userName ?></div>
          <ul class="sub-menu collapse" id="user-option">
            <li class="cursor-pointer"><a href="<?php echo base_url().'ManagerInfo/'; ?>">Thông tin cá nhân</a></li>
            <li class="cursor-pointer"><a href="<?php echo base_url().'EditManagerInfo/'; ?>">Sửa thông tin</a></li>
            <li class="cursor-pointer"><a href="<?php echo base_url().'ChangePassword/'; ?>">Đổi mật khẩu</a></li>
          </ul>             
        </li>
        <li class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="Tổng quát về website" ><a href="<?php echo base_url().'Home/'; ?>">Tổng quát</a></li>        
        <li class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="Gửi thông báo đến người chơi"><a href="<?php echo base_url().'Notification/'; ?>">Gửi thông báo</a></li>
        <li class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="Lịch sử game"><a href="<?php echo base_url().'CultureGame/'; ?>">Lịch sử</a></li>
        <li class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="Tạo game cho người chơi"><a href="<?php echo base_url().'CreateGame/'; ?>">Tạo game</a></li>

        <li data-toggle="collapse" data-target="#admin-option" class="cursor-pointer c-active" aria-expanded="true">
          <a>Quản lý</a>
        </li>
        <ul class="sub-menu collapse" id="admin-option">
          <li class=""><a href="<?php echo base_url().'ChangeManager'; ?>">Block or Unblock Manager</a></li>
          <li class=""><a href="<?php echo base_url().'ChangeGift'; ?>">Giải thưởng</a></li>
          <li class=""><a href="<?php echo base_url().'AscendInRank'; ?>">Thăng cấp</a></li>
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
            <p class="title title font-extra-bold font-extra-big">Demo game hệ thống</p>
          </div>
          <!-- game info -->
          <div class="game-info">
            <!-- user join -->
            <table class="user-join">
              <thead>
                <tr>
                  <th class="text-center wd-4">#</th>
                  <th>Ngày tạo</th>
                  <th>Ngày kết thúc</th>
                  <th class="text-center">Tiêu đề</th>
                  <th class="text-center">Ngày</th>
                  <th class="text-center">Thời gian</th>
                  <th class="text-center">Thao tác</th>
                </tr>                
              </thead>
              <tbody>
                <?php foreach ($currentGame as $value): ?>
                  <tr class=" cursor-pointer">
                    <td class="text-center wd-4"><a href="">1</a></td>
                    <td><?= $value['START_DATE']; ?></td>
                    <td><?= $value['END_DATE']; ?></td>
                    <td class="text-center"><p><?= $value['CONTENT']; ?></p></td>
                    <td>
                      <input type="text" id="system-game-date" class="form-control d-inline-block">
                    </td>
                    <td><input type="time" class="form-control d-inline-block" id="sytem-game-time" placeholder="1"></td>
                    <td class="text-center">
                      <button id="btn-system-game" class="btn btn-ban" name="btn-ban" value="<?= $value['GAME_ID']; ?>" data-toggle="confirmation">
                        <i class="fa fa-ban" aria-hidden="true"></i>
                      </button>
                    </td>
                  </tr>          
                <?php endforeach ?>
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
<script src="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.js"></script>

<script src="<?php echo base_url(); ?>js/SystemGameDemo.js"></script>
<script src="<?php echo base_url(); ?>js/ui.js"></script>
</body>
</html>

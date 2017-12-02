<!DOCTYPE html>
<html>
<head>
  <title>Thông tin người quản lý</title>
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
<!-- manager content -->
<div id="manager-info" class="container-fluid">
  <!-- side bar -->
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
      <ul class="sidebar-content nav nav-sidebar">
        <li class="manager-avatar c-active">
          <a class="manager-link" href="#!"><img src="<?php echo base_url().'img/ava-default.png'; ?>" alt="avatar"></a>
          <div class="manager-name ellipsis collapsed cursor-pointer" data-toggle="collapse" data-target="#user-option"><?php echo $user_name; ?></div>
          <ul class="sub-menu collapse" id="user-option">
            <li class="cursor-pointer c-active"><a href="<?php echo base_url().'ManagerInfo/'; ?>">Thông tin cá nhân</a></li>
            <li class="cursor-pointer"><a href="<?php echo base_url().'EditManagerInfo/'; ?>">Sửa thông tin</a></li>
            <li class="cursor-pointer"><a href="<?php echo base_url().'ChangePassword/'; ?>">Đổi mật khẩu</a></li>
          </ul>             
        </li>
        <li class="cursor-pointer c-active" data-toggle="tooltip" data-placement="top" title="Tổng quát về website" ><a href="<?php echo base_url().'Home/'; ?>">Tổng quát</a></li>        
        <li class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="Gửi thông báo đến người chơi"><a href="<?php echo base_url().'Notification/'; ?>">Gửi thông báo</a></li>
        <li class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="Lịch sử game truyền thống"><a href="#!">Lịch sử</a></li>
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
    <div class="right-side-hand col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main-content">
      <div class="main-function">
        <!-- icon sidebar -->
        <div class="sidebar-icon-area" title="Sidebar">
          <div id="nav-icon1">
            <span></span>
            <span></span>
            <span></span>
          </div>      
        </div><!-- /.icon sidebar -->        
        <div class="function-title">
          <p class="title">Thông tin cá nhân</p>
        </div>
        <div class="manager-info">
          <label for="mname">Họ tên</label>
          <input type="text" class="form-control" name="mname" value="<?php echo $user_name; ?>" readonly>
          <label for="mphone">Số điện thoại</label>
          <input type="text" class="form-control" name="mphone" value="<?php echo $user_phone; ?>" readonly>
          <label for="maddress">Địa chỉ</label>
          <input type="text" class="form-control" name="maddress" value="<?php echo $user_address ?>" readonly>
          <label for="memail">Email</label>
          <input type="text" class="form-control" name="memail" value="<?php echo $user_email ?>" readonly>
          <label for="mdate">Ngày tạo</label>
          <input type="text" class="form-control" name="mdate" value="<?php echo $user_created_date ?>" readonly>
          <!-- <div class="game-create">
            <p class="medium-font-size">Số game đã tạo: <a href="#!">50 yes/no</a>&nbsp;<a href="#!">50 multiple</a></p>
          </div> -->
          <div class="more-option">
            <a class="medium-font-size" href="<?php echo base_url().'EditManagerInfo/'; ?>">Sửa thông tin</a>&nbsp;<a class="medium-font-size" href="<?php echo base_url().'ChangePassword/'; ?>">Đổi mật khẩu</a>
          </div>
        </div>
      </div>
    </div>
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
</div><!-- /.manager content -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/jquery/jquery-1.12.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>assets/popper/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.js"></script>

<script src="<?php echo base_url(); ?>js/ui.js"></script>
</body>
</html>

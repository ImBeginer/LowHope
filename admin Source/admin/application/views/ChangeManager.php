<!DOCTYPE html>
<html>
<head>
  <title>Khoá, mở khóa quản lý</title>
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
<!-- manager content -->
<div id="manager-index" class="container-fluid">
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
        <li class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="Lịch sử game"><a href="<?php echo base_url().'CultureGame/'; ?>">Lịch sử</a></li>
        <li class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="Tạo game cho người chơi"><a href="#!">Tạo game</a></li>

        <li data-toggle="collapse" data-target="#admin-option" class="cursor-pointer c-active" aria-expanded="true">
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
          <p class="title">Block Manager</p>
        </div>
        <div class="manager-block-list form-in-list row">
          <div class="search-panel">
            <input class="manger-block-search" type="text" placeholder="Tìm kiếm" name="manager-block-search" id="manager-search">
            <button class="btn search-btn" name="search-btn"><i class="fa fa-search search-icon" aria-hidden="true"></i></button>
          </div>
        </div>
        <div class="manager-block-list form-in-list col-xs-12 col-sm-12 col-md-6 col-xl-6">
          <div class="function-title no-border">
            <p class="title">White List</p>
          </div>
          <div class="pre-scrollable pre-padding">
            <div class="tab-content">
              <!-- all user list -->
              <ul id="all-manager-list" class="user-list" id="users">

                <?php foreach ($active_manager as $value): ?>
                  <li id="users-1" class="users">
                  <div class="user-ava">
                    <img class="img-in-list" src="<?php echo base_url(); ?>img/ava-default.png" alt="Ảnh đại diện">
                    <p class="user-name ellipsis cursor-pointer" id="user-name"><?= $value['USER_NAME']; ?></p>
                    <p class="text-right tag manager-tag">MANAGER</p>
                    <p class="status">Trạng thái: Hoạt động</p>
                    <button class="btn btn-ban" name="btn-ban" value="<?= $value['USER_ID'] ?>" data-toggle="confirmation">
                      <i class="fa fa-ban" aria-hidden="true"></i>
                    </button>
                  </div>
                </li>
                <?php endforeach ?>

              </ul><!-- /.all user list -->
            </div>
          </div>          
        </div>
        <div class="manager-block-list form-in-list col-xs-12 col-sm-12 col-md-6 col-xl-6">
          <div class="function-title no-border">
            <p class="title">Block List</p>
          </div>
          <div class="pre-scrollable pre-padding">
            <div class="tab-content">
              <!-- all user list -->
              <ul id="all-manager-blocked-list" class="user-list" id="users"> 

                <?php foreach ($deactive_manager as $value): ?>
                  <li id="users-1" class="users">
                    <div class="user-ava">
                      <img class="img-in-list" src="<?php echo base_url(); ?>img/ava-default.png" alt="Ảnh đại diện">
                      <p class="user-name ellipsis cursor-pointer" id="user-name"><?= $value['USER_NAME']; ?></p>
                      <p class="text-right tag block-tag">MANAGER</p>
                      <p class="status">Trạng thái: Block</p>
                      <button class="btn btn-unban" name="btn-unban" value="<?= $value['USER_ID'] ?>" data-toggle="confirmation">
                      <i class="fa fa-check" aria-hidden="true"></i>
                    </button>  
                    </div>
                  </li>
                <?php endforeach ?>

              </ul><!-- /.all user list -->
            </div>
          </div>               
        </div>
        <div id="dialog-confirm" class="black"></div>        
      </div>
    </div>
  </div><!-- /.right side hand -->
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
</div><!-- /.manager content -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/jquery/jquery-1.12.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>assets/popper/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap-confirmation.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.js"></script>
<!-- Custom JS -->
<script src="<?php echo base_url(); ?>js/ui.js"></script>
<script src="<?php echo base_url(); ?>js/checkManager.js"></script>
</body>
</html>

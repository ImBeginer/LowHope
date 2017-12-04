<!DOCTYPE html>
<html>
<head>
  <title>CRUD Thông báo</title>
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
  <!-- dataTable Jquery -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
</head>

<body>
<script>
  var list = <?php echo json_encode($noti_list) ?>;
  var noti_id = -1;
  var base_url = '<?= base_url(); ?>';
</script>

<!-- manager content -->
<div id="manager-index" class="container-fluid">
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
    <div class="right-side-hand col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main-content">
      <div id="crud-notifi" class="main-function">
        <!-- icon sidebar -->
        <div class="sidebar-icon-area" title="Sidebar">
          <div id="nav-icon1">
            <span></span>
            <span></span>
            <span></span>
          </div>      
        </div><!-- /.icon sidebar -->        
        <div class="function-title">
          <p class="title">CRUD Thông báo</p>
        </div>
        <div class="manager-block-list form-in-list col-xs-12 col-sm-12 col-md-6 col-xl-6">
          <span class="notifi-title medium-font-size mt-1 mb-1">Tiêu đề: </span>
          <input type="text" name="notifi-title" id="notifi-title" class="black medium-font-size form-control full-width">
          <span class="notifi-title medium-font-size mt-1 mb-1">Nội dung: </span>
          <textarea name="notifi-content" id="notifi-content" class="black medium-font-size custome-textarea form-control"></textarea>
          <div class="form-group submit-area mt-1 mb-1">
            <button type="reset" class="btn btn-height close-update cursor-pointer color-white" id="" name="notifi-delete-btn">Xóa thông báo</button>
            <button type="button" class="btn game-btn-yes-no create btn-height cursor-pointer color-white" id="notifi-save-btn" name="notifi-create-btn">Lưu thông báo</button>
            <button type="button" class="btn btn-add-notifi btn-height cursor-pointer color-white" id="notifi-remove-btn" name="notifi-remove-btn">Xóa nội dung</button>
          </div>          
        </div>        
        <div class="manager-block-list form-in-list col-xs-12 col-sm-12 col-md-6 col-xl-6">
          <div class="function-title no-border">
            <p class="title">Thông báo</p>
          </div>
          <div class="pre-scrollable pre-padding">
            <table id="notifi-list" class="full-width c-table">
              <thead>
                <tr>
                  <th class="text-center wd-4">#</th>
                  <th class="text-center">Tiêu đề</th>
                  <th class="text-center">Ngày tạo</th>
                </tr>
              </thead>
              <tbody>

                <?php 
                  $count = 1;
                  foreach ($noti_list as $value) {
                ?>
                    <tr id="manager-noti">
                      <td class="text-center"><?= $count ?></td>
                      <td onclick="showDetail(<?= $value['NOTICE_ID']; ?>);"><p class="notifi-title cursor-pointer" id="title"><?= $value['TITLE'] ?></p></td>
                      <td><?php $dt = new DateTime($value['CREATE_DATE']); echo $dt->format('m/d/Y'); ?></td>
                    </tr>
                <?php
                    $count++;
                  }
                ?>
              </tbody>
            </table>
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
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>assets/popper/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap-confirmation.min.js"></script>
<!-- Custom JS -->
<script src="<?php echo base_url(); ?>js/ui.js"></script>
<script src="<?php echo base_url(); ?>js/EditNotification.js"></script>
</body>
</html>

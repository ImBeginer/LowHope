<!DOCTYPE html>
<html>
<head>
  <title>Thay đổi giá trị giải thưởng</title>
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
    var js_data = '<?php echo json_encode($lNoti); ?>';
    var listNoti = JSON.parse(js_data );
  </script>
<!-- manager content -->
<div id="manager-forgot-pass" class="container-fluid">
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
          <li class=""><a href="<?php echo base_url().'ChangeManager'; ?>">Block or Unblock Manager</a></li>
          <li class="c-active"><a href="<?php echo base_url().'ChangeGift'; ?>">Giải thưởng</a></li>
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
      <div id="change-gift-panel" class="main-function">
        <!-- icon sidebar -->
        <div class="sidebar-icon-area" title="Sidebar">
          <div id="nav-icon1">
            <span></span>
            <span></span>
            <span></span>
          </div>      
        </div><!-- /.icon sidebar -->        
        <div class="function-title">
          <p class="title font-extra-bold font-extra-big">Thay đổi giá trị giải thưởng</p>
        </div>
        <div class="manager-info">
          <!-- nav game list -->
          <ul id="nav-change-gift" class="nav nav-tabs no-border">
            <li class="nav-item">
              <a class="c-yn-game-list nav-link c-avtive active" href="#traditional">Truyền thống</a>
            </li>                 
          </ul><!-- /.nav game list  -->
          <div class="tab-content">
            <div role="tabpanel" id="traditional" class="tab-pane active">
              <div class="message"></div>
              <form action="#!" name="m-forgot-pass">
                <label for="newpass">Giải nhất:</label>
                <input type="text" id="new-price-tradi-1st" class="form-control" name="new-price-tradi-1st" value="<?= $award[2]['AWARD_NAME']; ?>">
                
                <label for="newpass">Giải nhì:</label>
                <input type="text" id="new-price-tradi-2nd" class="form-control" name="new-price-tradi-2nd" value="<?= $award[1]['AWARD_NAME']; ?>">
                
                <label for="newpass">Giải ba:</label>
                <input type="text" id="new-price-tradi-3rd" class="form-control" name="new-price-tradi-3rd" value="<?= $award[0]['AWARD_NAME']; ?>">

                <label for="tradi-send-form">Lựa chọn mẫu thông báo:</label>
                <select name="tradi-send-form" id="tradi-notifi-form" class="black form-control notifi-form" onchange="selectNoti();">
                  <option value="0" class="black">Xin mời chọn thông báo:</option>
                  <?php
                    foreach ($lNoti as $value) {
                      ?>
                        <option value="<?php echo $value['NOTICE_ID']; ?>" class="black"><?php echo $value['TITLE']; ?></option>
                      <?php
                    }
                  ?>
                </select>

                <label for="tradi-gift-notifi">Thông báo:</label>
                <div class="send-notifi">
                  <textarea name="tradi-gift-notifi" id="tradi-gift-notifi" class="custome-textarea" readonly></textarea>
                </div>
                <div class="text-center m-update-btn-area">
                  <button type="button" class="btn create cursor-pointer color-white" name="gift-tradi-btn">Lưu</button>
                </div>
              </form>
            </div>         
          </div>        
        </div>
        <div id="dialog-confirm" class="black"></div>
      </div>
    </div>
    
  </div><!-- /.right side hand -->
</div><!-- /.manager content -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/jquery/jquery-1.12.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>assets/popper/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.js"></script>

<script src="<?php echo base_url(); ?>js/forgotPass.js"></script>
<script src="<?php echo base_url(); ?>js/checkData.js"></script>
<script src="<?php echo base_url(); ?>js/ui.js"></script>
<script src="<?php echo base_url(); ?>js/changeGift.js"></script>
</body>
</html>

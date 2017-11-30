<!DOCTYPE html>
<html>
<head>
  <title>Tổng quát</title>
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
        <!-- user function -->
        <div class="total-user-area animated pulse col-sm-12 col-md-4 col-xl-3">
          <div class="function-content">
            <div class="function-title">
              <p class="title"><a href="<?php echo base_url().'Notification/'; ?>">Số lượng thành viên</a></p>
            </div>
            <div class="total-user">
              <a href="<?php echo base_url().'Notification/'; ?>" class="user-num cursor-pointer">
                <span class="num"><?php echo $allMember?></span>
                <span class="sub">thành viên</span>
                <img src="<?php echo base_url().'img/1user.jpg'; ?>" alt="total-user">
              </a>
            </div>
            <div class="new-user">
              <a href="<?php echo base_url().'Notification/'; ?>" class="user-num-new cursor-pointer">
                <span class="num new-color"><?php echo $newMember ?></span>
                <span class="sub">thành viên</span>
                <img src="<?php echo base_url().'img/1user-growth.jpg'; ?>" alt="new-user">
              </a>
            </div>
          </div>
        </div>
        <div class="total-user-area animated pulse col-sm-12 col-md-4 col-xl-3">
          <div class="function-content">
            <div class="function-title">
              <p class="title"><a href="<?php echo base_url().'Notification/'; ?>">Danh sách trúng thưởng</a></p>
            </div>
            <div class="trophy">
              <div class="third"><img src="<?php echo base_url().'img/3rd.png'; ?>" alt="3rd"></div>
              <div class="second"><img src="<?php echo base_url().'img/2nd.png'; ?>" alt="2nd"></div>
              <div class="first"><img src="<?php echo base_url().'img/1st.png'; ?>" alt="1st"></div>
            </div>
          </div>
        </div>
        <div class="total-user-area animated pulse col-sm-12 col-md-4 col-xl-3">
          <div class="function-content">
            <div class="function-title">
              <p class="title"><a href="#!">Lịch sử game</a></p>
            </div>
            <div class="history">
              <div class="history-item">
                <span class="num first-color"><?php echo $allSystemGame ?></span>
                <span class="sub-game-name">Game truyền thống</span>
              </div>
              <div class="history-item">
                <span class="num second-color"><?php echo $allYNGame ?></span>
                <span class="sub-game-name">Yes/no game</span>
              </div>
              <div class="history-item">
                <span class="num third-color"><?php echo $allMCGame ?></span>
                <span class="sub-game-name">Multiple game</span>
              </div>
            </div>
          </div>
        </div><!-- /.user function -->  
      </div>
    </div>

    <div class="right-side-hand col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 chart-content">
      <!-- chart -->
<!-- ****************MỚI 3/11**************** -->
      <div class="chart-panel">
        <div id="chart" data-user="<?php echo $array ?>"></div>
      </div><!-- /.chart -->
<!-- ****************MỚI 3/11**************** -->
      <!-- top active user -->
      <div class="top-active-user-panel">
        <div class="row">
          <div class="top-rank col-sm-12 col-md-6 col-xl-6 form-in-list">
            <div class="function-title no-border">
              <p class="title first-color">TOP NGƯỜI CHƠI CÓ NHIỀU POINT NHẤT</p>
            </div>
<!-- ********************* MỚI 3/11/2017 ******************* -->
            <div class="sub-title">
              <p class="top-10-in-month">*10 người chơi có nhiều point nhất tháng trước</p>
            </div>
<!-- ********************* MỚI 3/11/2017 ******************* -->            
            <div class="pre-scrollable pre-padding">
              <!-- top-rank-list -->
              <ul class="top-rank-list user-list">

                <?php
                  $count = 1;


                  foreach ($topPoint as $key) {
                ?>
                    <li class="user">
                      <div class="user-ava">
                        <img class="img-in-list" src="<?php echo base_url().'img/ava-default.png'; ?>" alt="Ảnh đại diện">
                        <p class="user-name ellipsis cursor-pointer" data-toggle="tooltip" data-placement="top" title="Ashanti Heisler"><a href="#!"><?php echo $key['USER_NAME']; ?></a></p>
                        <p class="user-point"><?php echo $key['USER_POINT']; ?> point</p>
                        <img class="img-in-list rank" 
                          src="
                            <?php 
                              if ($count == 1) {
                                echo base_url().'img/1st.png';
                              } else if ($count == 2) {
                                echo base_url().'img/2nd.png';
                              } else if ($count == 3) {
                                echo base_url().'img/3rd.png';
                              } else {
                                echo base_url().'img/dash.png';
                              } 
                            ?>" 
                          alt="TOP-1">
                      </div>                  
                    </li>
                <?php
                    $count++;
                  }
                ?>                                               

              </ul><!-- /.top-rank-list -->   
            </div>
          </div>
<!-- ************** MỚI 3/11/2017 ****************** -->
          <div class="top-game col-sm-12 col-md-6 col-xl-6 form-in-list">
            <div class="function-title no-border">
              <p class="title in-blk">TOP GAME</p>
              <input type="text" placeholder="Tìm kiếm" name="top-game-search" id="txt-top-game-search">
              <button class="btn search-btn" name="search-btn" onclick="search();"><i class="fa fa-search search-icon" aria-hidden="true"></i></button>
            </div>
            <!-- nav game list -->
            <ul id="nav-game-list" class="nav nav-tabs no-border">
              <li class="nav-item">
                <a class="c-yn-game-list nav-link c-avtive active" href="#yes-no-game-list">Yes/No</a>
              </li>
              <li class="nav-item">
                <a class="c-mul-game-list nav-link c-avtive " href="#multi-choice-game-list">Q/A</a>
              </li>        
            </ul><!-- /.nav game list  --> 
            <div class="pre-scrollable pre-padding">
              <div class="tab-content">
                <!-- top-yn-game-list -->
                <ul role="tabpanel" id="yes-no-game-list" class="tab-pane active top-game-list user-list">
                  
                  <?php 
                    foreach ($topYNGame as $key) {
                  ?>
                    <!-- quanth add id -->
                    <li id="game" class="user">
                      <div class="user-ava">
                        <p class="game-name cursor-pointer" data-toggle="tooltip" data-placement="top" title="Ashanti Heisler" id="title"><a href="<?php echo base_url().'GameDetail/index/YN/'.$key['GAME_ID']; ?>"><?php echo $key['TITLE'] ?></a></p>
                        <p class="user-tran cursor-pointer" data-toggle="tooltip" data-placement="top" title="point đã giao dịch"><?php echo $key['TOTAL_AMOUNT'] ?><i class="fa fa-gavel" aria-hidden="true"></i></p>
                        <p class="user-join cursor-pointer" data-toggle="tooltip" data-placement="top" title="người tham gia"><?php echo $key['PLAYER_COUNT'] ?><i class="fa fa-user" aria-hidden="true"></i></p>
                        <p class="tag open-tag no-float"><?php if ($key['ACTIVE'] == 1) { echo "Đang mở"; } else { echo "Đã đóng"; }?></p>
                      </div>                  
                    </li>

                  <?php 
                    }
                  ?>
                </ul><!-- /.top-yn-game-list -->
                <!-- top-mul-game-list -->
                <ul role="tabpanel" id="multi-choice-game-list" class="tab-pane top-game-list user-list">

                  <?php 
                    foreach ($topMCGame as $key) {
                  ?>
                    <!-- quanth add id -->

                    <li id="game" class="user">
                      <div class="user-ava">
                        <p class="game-name cursor-pointer" data-toggle="tooltip" data-placement="top" title="Ashanti Heisler" id="title"><a href="<?php echo base_url().'GameDetail/index/MC/'.$key['GAME_ID']; ?>"><?php echo $key['TITLE'] ?></a></p>
                        <p class="user-tran cursor-pointer" data-toggle="tooltip" data-placement="top" title="point đã giao dịch"><?php echo $key['TOTAL_AMOUNT'] ?><i class="fa fa-gavel" aria-hidden="true"></i></p>
                        <p class="user-join cursor-pointer" data-toggle="tooltip" data-placement="top" title="người tham gia"><?php echo $key['PLAYER_COUNT'] ?><i class="fa fa-user" aria-hidden="true"></i></p>
                        <p class="tag open-tag no-float"><?php if ($key['ACTIVE'] == 1) { echo "Đang mở"; } else { echo "Đã đóng"; }?></p>
                      </div>                  
                    </li>

                  <?php 
                    }
                  ?>
                </ul><!-- /.top-mul-game-list -->
              </div>
            </div>
          </div>
<!-- ************** MỚI 3/11/2017 ****************** -->          
        </div>
      </div><!-- /.top active user -->
  
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

<!-- Highchart -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<!-- Chart Manager -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/chartManager.js"></script>
<!-- Custom JS -->
<script src="<?php echo base_url(); ?>js/ui.js"></script>
<script src="<?php echo base_url(); ?>js/home.js"></script>
</body>
</html>

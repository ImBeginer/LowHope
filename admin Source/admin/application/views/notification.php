<!DOCTYPE html>
<html>
<head>
  <title>Thông báo</title>
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
        <li class="cursor-pointer c-active" data-toggle="tooltip" data-placement="top" title="Gửi thông báo đến người chơi"><a href="<?php echo base_url().'Notification/'; ?>">Gửi thông báo</a></li>
        <li class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="Lịch sử game"><a href="<?php echo base_url().'CultureGame/'; ?>">Lịch sử</a></li>
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
    <div id="user-notifi-send-panel" class="right-side-hand col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 user-content">
      <div class="main-function">
        
        <div class="row">

          <!-- user list panel -->
          <div class="user-list-panel col-sm-12 col-md-5 col-xl-5">
            <div class="function-title no-border">
              <p class="title">Danh sách thành viên</p>
            </div>
            <!-- search form -->
            <div class="search-form-panel">
              <div class="form-group user-search-form">
                <label for="user-search">
                  <i class="fa fa-search search-icon" aria-hidden="true"></i>
                  <span class="sr-only">Tìm kiếm</span>
                </label>
                <div class="full-width input-group">
                  <input type="text" class="form-control" id="user-search" placeholder="Tìm kiếm">
                </div>
              </div>
            </div><!-- /.search form -->

            <!-- user list content -->
            <div class="user-list-content">
              <div class="user-list-head">
                <ul id="user-nav" class="nav nav-tabs">
                  <li class="nav-item active">
                    <a class="nav-link" href="#all-user">Tất cả</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#new-user">Mới</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#top-user">TOP 3 dự đoán</a>
                  </li>
                </ul>
              </div>
              <div class="tab-content">
                <!-- all user tab -->
                <div id="all-user" class="tab-pane active" role="tabpanel" >
                  <div class="user-list-subhead">
                    <span class="sub">* Danh sách tất cả người chơi</span>
                  </div>
                  <div class="pre-scrollable pre-height">
                    <!-- all user list -->
                    <ul id="all-user-list" class="user-list">

                      <?php 
                        foreach ($lAllMember as $key) {
                      ?>
                        <li id="users" class="users">
                          <div class="user-ava">
                            <img class="img-in-list" src="<?php echo base_url().'img/ava-default.png' ?>" alt="Ảnh đại diện">
                            <p class="user-name ellipsis cursor-pointer" id="user-name" onclick="getInformationById(<?php echo $key['USER_ID'] ?>);"><?php echo $key['USER_NAME'] ?></p>
                            <p class="text-right tag user-tag">USER</p>
                            <p class="user-date text-right"><?php echo $key['CREATE_DATE'] ?></p>
                            <input type="checkbox" name="users-id" value="<?php echo $key['USER_ID']; ?>" class="user-check-box d-inline-block custome-checkbox">
                          </div>
                        </li>
                      <?php
                        }
                      ?>                   -->                                                           
                    </ul><!-- /.all user list -->
                  </div>
                  <div class="select-all black">
                    <input type="checkbox" name="all-users" value="-1" class="user-check-all-box d-inline-block custome-checkbox" data-panel="all-user">&nbsp;<span>Chọn tất</span>
                  </div>
                </div><!-- /.all user tab -->

                <!-- new user tab -->
                <div id="new-user" class="tab-pane" role="tabpanel" >
                  <div class="user-list-subhead">
                    <span class="sub">* Danh sách thành viên mới trong tháng</span>
                  </div>
                  <div class="pre-scrollable pre-height">
                    <!-- new use list -->
                    <ul id="new-user-list" class="user-list">

                      <?php 
                        foreach ($lNewMember   as $key) {
                      ?>
                        <li id="users" class="users">
                          <div class="user-ava">
                            <img class="img-in-list" src="<?php echo base_url().'img/ava-default.png' ?>" alt="Ảnh đại diện">
                            <p class="user-name ellipsis cursor-pointer" id="user-name" onclick="getInformationById(<?php echo $key['USER_ID'] ?>);"><?php echo $key['USER_NAME'] ?></p>
                            <p class="text-right tag user-tag">USER</p>
                            <p class="user-date text-right"><?php echo $key['CREATE_DATE'] ?></p>
                            <input type="checkbox" name="users-id" value="<?php echo $key['USER_ID']; ?>" class="user-check-box d-inline-block custome-checkbox">
                          </div>
                        </li>
                      <?php
                        }
                      ?>                -->                                                          
                    </ul><!-- /.new use list -->
                  </div>
                  <div class="select-all black">
                    <input type="checkbox" name="new-users" value="-1" class="user-check-all-box d-inline-block custome-checkbox" data-panel="new-user">&nbsp;<span>Chọn tất</span>
                  </div>      
                </div><!-- /.new user tab --> 

                <!-- top user tab -->  
                <div id="top-user" class="tab-pane" role="tabpanel" >
                  <div class="user-list-subhead">
                    <span class="sub">* Danh sách người chơi thắng cuộc game truyền thống gần nhất</span>
                  </div>
                  <div class="user-list pre-scrollable pre-height">
                    <!-- top user list -->
                    <ul id="top-user-list" class="user-list">

                      <?php 
                        foreach ($lChampions   as $key) {
                      ?>

                        <li id="users" class="users">
                          <div class="user-ava">
                            <img class="img-in-list" src="<?php echo base_url().'img/ava-default.png' ?>" alt="Ảnh đại diện">
                            <p class="user-name ellipsis cursor-pointer" id="user-name" onclick="getInformationById(<?php echo $key['USER_ID'] ?>);"><?php echo $key['USER_NAME'] ?></p>
                            <p class="text-right tag user-tag">USER</p>
                            <p class="user-date text-right"><?php echo $key['CREATE_DATE'] ?></p>
                            <input type="checkbox" name="users-id" value="1" class="user-check-box d-inline-block custome-checkbox">
                          </div>
                        </li>
                      <?php
                        }
                      ?>                                                        
                    </ul><!-- /.top user list -->
                  </div>
                  <div class="select-all black">
                    <input type="checkbox" name="top-users" value="-1" class="user-check-all-box d-inline-block custome-checkbox" data-panel="top-user">&nbsp;<span>Chọn tất</span>
                  </div>                    
                </div><!-- /.top user tab --> 

              </div>
            </div><!-- user list content -->
          </div><!-- /.user list panel-->

          <!-- notifi panel -->
          <div class="notifi-panel col-sm-12 col-md-7 col-xl-7">
            <div class="top-panel">
               <div class="user-pop">
                  <div class="user-detail-panel col-sm-12 col-md-12 col-xl-12">
                    <div class="function-title no-border">
                      <p class="title">Thông tin chi tiết</p>
                    </div>

                    <!-- user detail -->
                    <div class="user-detail animated flipInX">
                      <!-- user percent -->
                      <div class="percent-panel mt-3">
                        <p class="percent-panel-title">Tỷ lệ thắng thua:</p>
                        <div id="increase" class="user-percent" data-toggle="tooltip" data-placement="top" title="Thắng">
                          <span class="in-num-percent">50%</span>
                        </div>
                        <div id="decrease" class="user-percent" data-toggle="tooltip" data-placement="top" title="Thua">
                          <span class="de-num-percent">50%</span>
                        </div>
                      </div><!-- /.user percent -->                     
                      <table class="user-detail-info">
                        <tr>
                          <td>Họ tên: </td>
                          <!-- TODO -->
                          <td id="name"></td>
                        </tr>
                        <tr>
                          <td>Số điện thoại:</td>
                          <td id='phone'></td>
                        </tr>
                        <tr>
                          <td>Địa chỉ:</td>
                          <td id='address'></td>
                        </tr>
                        <tr>
                          <td>Email:</td>
                          <td id='email'></td>
                        </tr>                      
                        <tr>
                          <td>Vô địch:</td>
                          <td id="champions"></td> 
                        </tr>
                        <tr>
                          <td>Thắng thử thách:</td>
                          <td id="win"></td> 
                        </tr>
                        <tr>
                          <td>Thua thử thách:</td>
                          <td id="lose"></td>
                        </tr>
                        <tr>
                          <td>Tổng số thử thách:</td>
                          <td id="sum"></td>
                        </tr>
                      </table>                     
                    </div><!-- /.user detail -->

                  </div>
               </div>
            </div>
          </div><!-- /.notifi panel -->
          <div class="send-notifi-panel col-sm-12 col-md-7 col-xl-7">

            <div class="bottom-panel">
              <div class="send-notifi">
                <textarea name="notifi-content" id="notifi-panel" class="custome-textarea" placeholder="Thông báo..." readonly></textarea>
                <select id="notifi-form" name="notifi-content" class="black notifi-form" onchange="selectNoti();">
                  <option value="0" class="black">Xin mời chọn thông báo:</option>
                  <?php
                    foreach ($lNoti as $value) {
                      ?>
                        <option value="<?php echo $value['NOTICE_ID']; ?>" class="black"><?php echo $value['TITLE']; ?></option>
                      <?php
                    }
                  ?>
                </select>
                <div class="send-option">
                  <label class="form-check-label">
                    <input id="notifi-radio" class="form-check-input radio-cus" type="radio" name="send-option" value="0" checked>Thông báo
                  </label>
                  <label class="form-check-label">  
                    <input id="mail-radio" class="form-check-input radio-cus" type="radio" name="send-option" value="1">Mail
                  </label> 
                  <label class="form-check-label">  
                    <input id="both-radio" class="form-check-input radio-cus" type="radio" name="send-option" value="1">Cả hai
                  </label>                                   
                </div>
                <div class="btn-area">
                  <button id="btn-send-notifi" class="btn btn-notifi cursor-pointer">Gửi</button>
                  <button id="btn-add-notifi" class="btn btn-add-notifi cursor-pointer">Thêm thông báo</button>
                </div>
              </div>
              <div class="message">
                <!-- <p class="animated bounceIn">ASDme q asdQE dxcvsdf e</p> -->
              </div>
            </div>            
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
</div><!-- /.notification content -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/jquery/jquery-1.12.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>assets/popper/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.js"></script>

<!-- Pusher -->
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>

<script src="<?php echo base_url(); ?>js/nofiti.js"></script>
<script src="<?php echo base_url(); ?>js/notification.js"></script>
<script src="<?php echo base_url(); ?>js/checkData.js"></script>
<script src="<?php echo base_url(); ?>js/ui.js"></script>
</body>
</html>

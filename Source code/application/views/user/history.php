<!DOCTYPE html>
<html lang="en">
<head>
  <title>Website dự đoán giá bitcoin</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <style>
      @keyframes changewidth {
        from {
          -webkit-transform: translate(50px);
          -ms-transform: translate(50px);
          transform: translate(50px);
        }
        to {}
      }
      @keyframes radioClick {
        from {
          height: 0px;
          width: 0px;
          opacity: 1;
        }
        to {
          height: 50px;
          width: 50px;
          opacity: 0;
          margin-left: -19px;
          margin-top: -18px;
        }
      }

      .border {border: 1px solid #777}
    </style>
  <!-- jQuery UI css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.min.css">
  <!-- bootstrap css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.css">
  <!-- font awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/animation/animate.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.css">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
  <!-- custom css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/client/main.css">
</head>
<body onload="infinitySlideShow(); user_percent_in_de(winners,losers);">
  <script>
    var base_url = "<?php echo base_url(); ?>";
    <?php if(isset($user_id)){ ?>
      var user_id = <?php echo json_encode($user_id); ?>;
      var is_related_YN = <?php echo json_encode($is_related_YN); ?>;
      var is_related_MUL = <?php echo json_encode($is_related_MUL); ?>;
      var winners = <?php echo json_encode($user_view_total_game_win); ?>;
      var losers = <?php echo json_encode($user_view_total_game) - json_encode($user_view_total_game_win); ?>;
    <?php } ?>
  </script>
  <!-- body -->
  <div class="container-fluid">
    <div class="row">
      <!-- infinite slideshow -->
      <section id="hot-mini-game-area">
        <?php if (empty($ALL_GAME_ACTIVE)) { ?>
        <marquee behavior="scroll" direction="left">Các thử thách đang được hệ thống cập nhật. Hãy tạo nhiều thử thách cho người khác để kiếm nhiều point nào <span><i class="fa fa-smile-o" aria-hidden="true" style="color:pink"></i></span></marquee>
        <?php }else{?>
        <?php shuffle($ALL_GAME_ACTIVE) ?>
        <div id="hot-mini-game-content" class="hot-minigame slider autoplay">
          <?php foreach ($ALL_GAME_ACTIVE as $value): ?>
            <div class="hot-item" data-gameID="<?php echo $value['GAME_ID']; ?>" data-gameType="<?php if($value['TYPE'] == 'YN'){echo 1;}else if($value['TYPE'] == 'MUL'){echo 2;} ?>">
              <?php if($value['TYPE'] == 'YN'){ ?>
              <a href="<?php echo base_url().'gamect/yn/'.$value['GAME_ID']; ?>" title="<?php echo $value['TITLE']; ?>">
              <?php }else if($value['TYPE'] == 'MUL'){ ?>
              <a href="<?php echo base_url().'gamect/mul/'.$value['GAME_ID']; ?>" title="<?php echo $value['TITLE']; ?>">
              <?php } ?>
                <div class="title"><?php echo $value['TITLE']; ?></div>
                <div class="runner"><?php echo $value['USER_NAME']; ?></div>
                <div class="prob">
                  <span class="icon-arrow-up"><i class="fa fa-angle-up" aria-hidden="true"></i></span>
                  <span><?php echo $value['TOTAL_AMOUNT'] ?></span>
                </div>
              </a>
            </div>
          <?php endforeach?>
        </div>
        <?php } ?>
      </section>
      <!-- /.infinite slideshow -->

      <!-- navbar -->
      <nav id="my-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?php 
          if($this->session->userdata('loggedInGooge')){
            echo base_url().'login/user';
          }else if($this->session->userdata('loggedInFB')) {
            echo base_url().'login/fb_goHome';
          }else if($this->session->userdata('loggedOther')){
            echo base_url() . 'userct/home';
          }else{
            echo base_url();
          }
         ?>">Logo</a>

        <?php if($this->session->userdata('loggedInGooge') || $this->session->userdata('loggedInFB') || $this->session->userdata('loggedOther')){ ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          <ul class="nav navbar-nav navbar-right">
            <li class="func-items nav-item" data-toggle="modal" data-target="#create-game">
              <a href="javascript:void(0);" class="nav-link">Tạo thử thách</a>
            </li>

            <!-- top rank point -->
            <li class="nav-item active top-bar-items" data-toggle="tooltip"
            data-placement="top" title="TOP point">
            <a class="nav-link" data-toggle="modal" data-target=".world-rank" href="#!"><i class="fa fa-trophy" aria-hidden="true"></i></a>
            </li>            
            <!-- end top rank point -->

            <!-- rank popup -->
            <div class="modal fade world-rank" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title col-centered" id="world-rank-title">TOP thành viên có nhiều point nhất</h5>
                    <button type="button" class="close cursor-pointer" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true" title="Đóng">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="top-user text-center">
                      <div class="second d-inline-block text-center">
                        <figure>
                          <img src="<?php echo base_url(); ?>images/client/2nd.png" alt="2nd">
                          <figcaption class="top-user-name">
                            <a href="<?php echo base_url().'userct/profile/'.$top_point[1]['USER_ID']; ?>">
                            <?php echo $top_point[1]['USER_NAME']; ?></a>
                          </figcaption>
                          <figcaption class="top-user-point"><span class="second-point"><?php echo $top_point[1]['USER_POINT']; ?></span></figcaption>
                        </figure>
                      </div>
                      <div class="first d-inline-block text-center">
                        <figure>
                          <img src="<?php echo base_url(); ?>images/client/1st.png" alt="1st">
                          <figcaption class="top-user-name">
                            <a href="<?php echo base_url().'userct/profile/'.$top_point[0]['USER_ID']; ?>">
                            <?php echo $top_point[0]['USER_NAME']; ?></a>
                          </figcaption>
                          <figcaption class="top-user-point"><span class="first-point"><?php echo $top_point[0]['USER_POINT']; ?></span></figcaption>
                        </figure>
                      </div>
                      <div class="third d-inline-block text-center">
                        <figure>
                          <img src="<?php echo base_url(); ?>images/client/3rd.png" alt="3rd">
                          <figcaption class="top-user-name">
                            <a href="<?php echo base_url().'userct/profile/'.$top_point[2]['USER_ID']; ?>">
                            <?php echo $top_point[2]['USER_NAME']; ?></a>
                            </figcaption>
                          <figcaption class="top-user-point"><span class="third-point"><?php echo $top_point[2]['USER_POINT']; ?></span></figcaption>
                        </figure>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.rank popup -->

            <!-- notifications of user -->
            <li class="nav-item top-bar-items cursor-pointer" data-toggle="tooltip"
            data-placement="top" title="Thông báo">
              <div class="dropdown">
                <button id="notifi-btn" class="notifi btn btn-primary dropdown-toggle cursor-pointer" type="button" data-toggle="dropdown">
                  <i class="fa fa-bell notifi-icon" aria-hidden="true"></i>
                  <div class="notifi-num">
                    <p><?php echo $noti->noti_not_seen; ?></p>
                  </div>
                </button>
                <!-- notification list -->
                <ul id="user-notifi" class="dropdown-menu dropdown-menu-right pre-scrollable">
                <?php if($noti->all_noti){ ?>
                  <?php foreach ($noti->all_noti as $value): ?>
                    <li class="noti-items" data-noID="<?php echo $value['NOTICE_ID']; ?>" data-seen="<?php if($value['SEEN'] == 0){echo 0;}else{ echo 1;} ?>" data-gameType="<?php echo $value['TYPE_ID']; ?>" data-gameID="<?php echo $value['GAME_ID']; ?>" class="btn btn-primary" data-toggle="modal" data-target="#notifi-popup">
                      <div class="noti-content ellipsis">
                        <a href="#!">
                          <p class="notifi-title notifi-1" class="ellipsis">
                            <div class="green-circle <?php if($value['SEEN'] == 0){echo '';}else{ echo 'already-read';} ?> d-inline-block"></div>
                            <?php echo $value['TITLE']; ?>
                            <div class="time-area">
                              <span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                              <span class="send-date">
                                <?php 
                                    $date = $value['SEND_DATE'];
                                    $date = new DateTime($date);
                                    $send_time = $date->format('H:i:s d-m-Y');
                                    echo $send_time;
                                  ?>
                                </span>
                            </div>
                          </p>
                        </a>
                      </div>
                    </li>
                  <?php endforeach ?>
                <?php }else{ ?>
                  <li class="noti-nothing">Không có Thông báo</li>
                <?php } ?>
                </ul><!-- /.notification list -->

                <!-- popup notifi -->
                <div class="modal" id="notifi-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header" id="notifi-title">
                        
                        <button type="button" class="close cursor-pointer" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" id="notifi-content">
                        
                      </div>
                    </div>
                  </div>
                </div><!-- /.popup notifi -->
              </div>
            </li>
            <!-- end notifications of user -->

            <!-- total point of user -->
            <li class="nav-item active top-bar-items cursor-pointer" data-toggle="tooltip"
            data-placement="top" title="Số point hiện tại">
              <div class="user-point-area">
                <p class="user-point"> <span id="user-point"><?php echo $USER_POINT; ?></span><span class="point-title">(P)</span></p>
              </div>
            </li>
            <!-- end total point of user -->
            
            <!-- avatar -->
            <li class="nav-item">
              <div class="user-avatar">
                <img src="<?php if($this->session->userdata('userData')['USER_AVATAR']){echo $this->session->userdata('userData')['USER_AVATAR'];}else{echo base_url().'images/client/ava-default.png';} ?>" alt="user default">
              </div>
            </li>
            <!-- end avatar -->

            <!-- information of user -->
            <li class="nav-item" id="tooltip-username" data-toggle="tooltip" data-placement="top" title="<?php echo $USER_NAME; ?>">
              <!-- user dropdown button -->
              <div class="dropdown">
                <button id="username-btn" class="user-name btn btn-primary dropdown-toggle cursor-pointer ellipsis" type="button" data-toggle="dropdown">
                  <?php echo $USER_NAME; ?>
                  <span class="angle-down"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                </button>
                <ul id="user-func-dropdown" class="dropdown-menu dropdown-menu-right">
                  <li class="func-items user-name-btn">
                    <button class="btn btn-primary user-name cursor-pointer" data-toggle="modal" data-target="#user-update-info">
                      Sửa thông tin
                    </button>     
                  </li>

                  <li class="func-items"><a href="<?php echo base_url().'userct/history'; ?>" target="_self">Lịch sử</a></li>

                  <?php if($this->session->userdata('loggedInGooge')){ ?>
                    <li class="func-items"><a href="<?php echo base_url().'login/logoutGoogle'; ?>">Đăng xuất</a></li>
                  <?php }else if($this->session->userdata('loggedInFB')) { ?> 
                    <li class="func-items"><a href="javascript:void(0);" onclick="logoutFB()">Đăng xuất</a></li>
                  <?php }else if($this->session->userdata('loggedOther')){ ?>
                    <li class="func-items"><a href="<?php echo base_url() . 'userct/logout'; ?>">Đăng xuất</a></li>
                  <?php } ?>
                </ul>
              </div> <!-- /.user dropdown button -->
              
              <!-- create game popup -->
              <div id="create-game" class="modal fade" tabindex="-1" role="dialog"
              aria-labelledby="createGame" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="create-mini-game">Thử thách</h5>
                      <button type="button" class="close cursor-pointer" data-dismiss="modal" aria-label="Close" title="Đóng">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">      
                      <!-- nav creat game -->
                      <ul id="nav-game" class="nav nav-tabs">
                        <li class="nav-item">
                          <a class="nav-link active" href="#yes-no-game">Đúng sai</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#multi-choice-game">Lựa chọn</a>
                        </li>        
                      </ul><!-- /.nav create game --> 
                    </div>
                    <!-- tab game -->
                    <div class="tab-content game-tab-content">
                      <!-- yes/no game -->
                      <div role="tabpanel" class="tab-pane active" id="yes-no-game">
                        <div class="user-form form" action="#!">
                          <div class="message"></div>
                          <div class="form-group">
                            <label for="game-title">Tên game</label>
                            <input type="text" class="form-control d-inline-block" id="game-title" pattern="^.{6,}$" required data-toggle="tooltip" data-placement="bottom" title="Tên game ít nhất phải chứa từ 6 ký tự.">
                          </div>
                          <div class="form-group d-inline-block">
                            <label for="game-date">Vào ngày</label>
                            <input type="text" class="form-control d-inline-block" id="game-date-yn" readonly required data-toggle="tooltip" data-placement="left" title="Ngày kết thúc bắt đầu từ hôm nay.">
                          </div>
                          <div class="form-group d-inline-block">
                            <label for="game-time">Kết thúc vào lúc</label>
                            <input type="time" class="form-control d-inline-block" id="game-time" placeholder="1" required data-toggle="tooltip" data-placement="bottom" title="Thời gian kết thúc phải lớn hơn thời gian hiện tại.">
                          </div>
                          <div class="form-group">
                            <label for="game-bitcoin-price">Giá Bitcoin trên (Đơn vị: USD)</label>
                            <input type="number" class="form-control" id="game-bitcoin-price" placeholder="0" pattern="/^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/" min="0" step="0.01" required data-toggle="tooltip" data-placement="bottom" title="Giá bitcoin phải lớn hơn 0 và tối đa 2 chữ số hàng thập phân !(6,00 = 6.00 USD)">
                          </div>
                          <div class="form-group submit-area">
                            <button type="button" class="game-btn-yes-no btn-height cursor-pointer" id="create-game-btn-yes-no" name="game-btn-yes-no">Tạo</button>
                            <button type="button" class="btn-height close-update cursor-pointer" data-dismiss="modal">Đóng</button>
                          </div>
                        </div>
                      </div>
                      <!-- end yes/no game -->

                      <!-- create game multi -->
                      <div role="tabpanel" class="tab-pane" id="multi-choice-game">
                        <div class="user-form form" action="#!">
                          <div class="message"></div>
                          <div class="form-group">
                            <label for="game-title">Tên game</label>
                            <input type="text" class="form-control d-inline-block" id="game-title-mul" pattern="^.{6,}$" required data-toggle="tooltip" data-placement="bottom" title="Tên game ít nhất phải chứa từ 6 ký tự.">
                          </div>
                          <div class="form-group d-inline-block">
                            <label for="game-date">Vào ngày</label>
                            <input type="text" class="form-control d-inline-block" id="game-date-mul" readonly required data-toggle="tooltip" data-placement="left" title="Ngày kết thúc bắt đầu từ hôm nay.">
                          </div>
                          <div class="form-group d-inline-block">
                            <label for="game-time">Kết thúc vào lúc</label>
                            <input type="time" class="form-control d-inline-block" id="game-time-mul" min="1" max="24" placeholder="1" required data-toggle="tooltip" data-placement="bottom" title="Thời gian kết thúc phải lớn hơn thời gian hiện tại.">
                          </div>
                          <div class="form-group">
                            <label for="">Giá Bitcoin ? (Đơn vị: USD)</label>
                          </div>
                          <div class="form-group d-inline-block mr-3">
                            <label class="d-block" for="game-bitcoin-price-lower">Dưới</label>
                            <input type="number" class="form-control d-inline-block" id="game-bitcoin-price-lower" pattern="/^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/" placeholder="0.01" min="0" step="0.01" required data-toggle="tooltip" data-placement="bottom" title="Giá bitcoin phải lớn hơn 0 và tối đa 2 chữ số hàng thập phân !(6,00 = 6.00 USD)">
                          </div>
                          <div class="form-group d-inline-block mr-3">
                            <label class="d-block" for="game-bitcoin-price-upper">Trên</label>
                            <input type="number" class="form-control d-inline-block" id="game-bitcoin-price-upper" pattern="/^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/" placeholder="0.01" min="1"  step="0.01" required data-toggle="tooltip" data-placement="bottom" title="Giá bitcoin phải lớn hơn 0 và tối đa 2 chữ số hàng thập phân !(6,00 = 6.00 USD)">
                          </div>
                          <div class="form-group d-inline-block mr-3">
                            <label class="d-block" for="game-bitcoin-price-between">Nằm giữa</label>
                            <input type="number" class="form-control d-inline-block" id="game-bitcoin-price-between-upper" pattern="/^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/" placeholder="0.01" min="0" step="0.01" disabled>
                          </div>
                          <div class="form-group d-inline-block mr-3">
                            <input type="number" class="form-control d-inline-block" id="game-bitcoin-price-between-lower" pattern="/^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/" placeholder="0.01" min="0" step="0.01" disabled>
                          </div>
                          <div class="form-group submit-area">
                            <button type="button" class="game-btn-yes-no btn-height cursor-pointer" id="create-game-btn-mul" name="game-btn-mul">Tạo</button>
                            <button type="button" class="btn-height close-update cursor-pointer" data-dismiss="modal">Đóng</button>
                          </div>
                        </div>
                      </div>
                      <!-- end create game multi -->
                    </div><!-- /.tab game -->            
                  </div>
                </div>
              </div><!-- /.create game popup -->          

              <!-- user update form -->
              <div id="user-update-info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog">                  
                  <!-- modal content -->
                  <div id="user-update-info" class="modal-content">
                    <div class="modal-header user-header">
                      <h5 class="user-func-title">Cập nhật thông tin</h5>
                      <button type="button" class="close user-btn-close cursor-pointer" data-dismiss="modal" aria-label="Close" title="Đóng">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="message"></div>
                    <!-- user update info -->
                    <div class="user-form form">
                      <div class="row">
                        <div class="user-info-left col-3 form-group">
                          <!-- user avatar -->
                          <div class="user-ava-area">
                            <img class="user-avatar" src="<?php if($this->session->userdata('userData')['USER_AVATAR']){echo $this->session->userdata('userData')['USER_AVATAR'];}else{echo base_url().'images/client/ava-default.png';} ?>" alt="User's avatar">
                            <p class="username ellipsis"><?php echo $USER_NAME; ?></p>
                          </div><!-- /.user avatar -->
                        </div>
                        <!-- user info -->
                        <div class="user-info-right col-8 col-centered">
                          <div class="form-group">
                            <label for="username">Họ và tên</label>
                            <input id="username" class="form-control" type="text" name='username' value="" required="">
                          </div>
                          <div class="form-group">
                            <label for="userphone">Số điện thoại</label>
                            <input id="userphone" class="form-control" type="text" name='userphone' pattern="^(\+84|0)\d{9,10}$" value="" required="" placeholder="(+84)123456789">
                          </div>
                          <div class="form-group">
                            <label for="useraddress">Địa chỉ</label>
                            <input id="useraddress" class="form-control" type="text" name='useraddress' value="" required="">
                          </div>
                        </div><!-- /.user info -->
                      </div>
                      <div class="submit-area form-group">
                        <button type="submit" class="btn-height update-btn cursor-pointer" id="update-btn">Cập nhật</button>
                        <button type="button" class="btn-height close-update cursor-pointer" data-dismiss="modal">Đóng</button>
                      </div>                     
                    </div><!-- /.user update info -->

                  </div><!-- /.modal content -->

                </div>
              </div>
              <!-- /.user update form -->
            </li>
            <!-- end information of user --> 
          </ul>
        </div>
        <?php }else{ ?>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          <ul class="nav navbar-nav navbar-right">
            <li class="func-items nav-item" data-toggle="modal" data-target="#create-game">
              <a href="<?php echo base_url(); ?>" class="nav-link">Đăng Nhập</a>
            </li>
          </ul>
        </div>
        <?php } ?>
      </nav><!-- /.navbar -->  

      <!-- top users achievement -->
      <div class="container-fluid" id="top_users_achievement">
        <?php if(!empty($top_users_achievement)){ ?>
        <marquee behavior="scroll" direction="left">
          Chúc mừng người chơi: <span style="color: #ffbf01;"><?php echo $top_users_achievement[0]['USER_NAME']; ?></span> giành GIẢI NHẤT, <span style="color: #ffbf01;"><?php echo $top_users_achievement[1]['USER_NAME']; ?></span> giành GIẢI NHÌ, <span style="color: #ffbf01;"><?php echo $top_users_achievement[2]['USER_NAME']; ?></span> giành GIẢI BA trong game hệ thống tuần trước. Game hệ thống mới đã được cập nhật, mọi người nhanh tay đặt cược để nhận những giải thưởng giá trị khác.
        </marquee>
        <?php } ?>
      </div>
      <!-- end top users achievement -->

      <div id="history-content-area" class="content-area">
        <div class="col-12 col-centered">
          <h6 id="game-history-title">Lịch sử chơi game của: <?php echo $user_view_name; ?> </h6>
        </div>
        <!-- content -->
        <div class="content" style="display: flex;">
            <div class="col-9 col-sm-9 col-md-9 col-lg-9">
              <!-- game history popup -->
              <div id="game-history-popup">
                <!-- nav game -->
                <ul id="nav-game" class="nav nav-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" href="#tranditional-game">Game Hệ Thống</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#mini-game">Thử Thách</a>
                  </li>
                </ul><!-- /.nav game --> 

                <!-- tab game -->
                <div class="tab-content game-tab-content pre-scrollable">
                  <div role="tabpanel" class="tab-pane active" id="tranditional-game">
                    <table id="traditional-game-table" class="table table-sm">
                      <thead class="thead-default">
                        <tr>
                          <th>STT</th>
                          <th>Bắt đầu</th>
                          <th>Kết thúc</th>
                          <th>Kết quả</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php if(!empty($user_view['achievements_system'])){ ?>  
                        <?php foreach ($user_view['achievements_system'] as $key => $value): ?>
                          <tr>
                            <th scope="row"><?php echo $key+1; ?></th>
                            <td>
                              <?php 
                                $start_date_system = $value['START_DATE'];
                                $start_date_system = new DateTime($start_date_system);
                                $start_date_system = $start_date_system->format('d-m-Y');
                                echo $start_date_system;
                              ?>
                            </td>
                            <td>
                              <?php 
                                $end_date_system = $value['END_DATE'];
                                $end_date_system = new DateTime($end_date_system);
                                $end_date_system = $end_date_system->format('d-m-Y');
                                echo $end_date_system;
                              ?>
                            </td>
                            <td>
                              <?php if($value['PRIZE'] == 1){ ?>
                                <img src="../images/client/1st.png" alt="Giải nhất" title="Giải nhất">
                              <?php }else if($value['PRIZE'] == 2){ ?>
                                <img src="../images/client/2nd.png" alt="Giải nhì" title="Giải nhì">
                              <?php }else if($value['PRIZE'] == 3){ ?>
                                <img src="../images/client/3rd.png" alt="Giải ba" title="Giải ba">
                              <?php } ?>
                            </td>
                          </tr>
                        <?php endforeach ?>
                      <?php }else{ ?>
                        <tr>
                          <td>Chưa giành được giải thưởng nào.</td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                      <?php } ?>                            
                      </tbody>
                    </table>            
                  </div>
                  <div role="tabpanel" class="tab-pane pre-scrollable" id="mini-game">
                    <table id="mini-game-table" class="table table-sm">
                      <thead class="thead-default">
                        <tr>
                          <th>STT</th>
                          <th>Tên Thử Thách</th>
                          <th>Loại Thử Thách</th>
                          <th>Kết quả</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php if(!empty($user_view['result_bet_mini_game'])){ ?>
                        <?php foreach ($user_view['result_bet_mini_game'] as $key => $value): ?>
                          <tr>
                            <th scope="row"><?php echo $key+1; ?></th>
                            <td data-toggle="tooltip" data-placement="top" title="<?php echo $value['TITLE']; ?>"><div class="table-game-title ellipsis"><?php echo $value['TITLE']; ?></div></td>
                            <td>
                              <?php if($value['TYPE'] == 'YN'){echo 'Đúng/Sai';}else if($value['TYPE'] == 'MUL'){echo 'Lựa Chọn';} ?>
                            </td>
                            <td><?php if($value['IS_WINNER'] == 1){echo 'Thắng';}else if($value['IS_WINNER'] == 0){echo 'Thua';}else{echo 'Đang chơi';} ?></td>
                          </tr>
                        <?php endforeach ?>
                      <?php }else{ ?>
                        <tr>
                          <td>Chưa tham gia thử thách nào.</td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                      <?php } ?>
                      </tbody>
                    </table>  
                  </div>
                </div><!-- /.tab game --> 
              </div><!-- /.game history popup -->

              <?php if($this->session->userdata('loggedInGooge') || $this->session->userdata('loggedInFB') || $this->session->userdata('loggedOther')){ ?>
                <?php if($is_history) {?>
                    <div class="row mt-3">
                      <div class="col-12">Game của tôi</div>
                      <div class="col-12 mt-3">
                        <table id="mini-game-table" class="table table-bordered">
                          <thead class="thead-default">
                            <tr>
                              <th>STT</th>
                              <th>Tên game</th>
                              <th>Loại game</th>
                              <th>Trạng thái</th>
                              <th>Kết quả</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php if(!empty($user_history)){ ?>
                            <?php foreach ($user_history as $key => $value): ?>
                              <tr>
                                <td><?php echo $key+1; ?></td>
                                <td data-toggle="tooltip" data-placement="top" title="<?php echo $value['TITLE']; ?>"><?php echo $value['TITLE']; ?></td>
                                <td><?php if($value['TYPE'] == 'YN'){echo 'Đúng/Sai';}else if($value['TYPE'] = 'MUL'){echo 'Lựa Chọn';} ?></td>
                                <td><?php if($value['ACTIVE'] == 0){echo 'Đã đóng';}else{echo 'Đang mở';} ?></td>
                                <td><?php echo $value['TOTAL_AMOUNT']-$value['WINNERS']*20 ?>p</td>
                                <td><a href="<?php if($value['TYPE'] == 'YN'){echo '#'.$value['GAME_ID'].'-YN';}else{echo '#'.$value['GAME_ID'].'-MUL';} ?>" data-toggle="collapse">Chi tiết</a></td>
                              </tr>
                              <tr id="<?php if($value['TYPE'] == 'YN'){echo $value['GAME_ID'].'-YN';}else{echo $value['GAME_ID'].'-MUL';} ?>" class="collapse" >
                                <td colspan="6">
                                  <div>Tên game: <?php echo $value['TITLE']; ?></div>
                                  <div>Ngày tạo: <?php echo $value['START_DATE']; ?></div>
                                  <div>Ngày kết thúc: <?php echo $value['END_DATE']; ?></div>
                                  <div>Tổng số người chơi: <?php echo $value['TOTAL_AMOUNT']/10; ?></div>
                                  <div>Người thắng: <?php echo $value['WINNERS']; ?></div>
                                  <div>Người thua: <?php echo $value['LOSERS']; ?></div>
                                </td>
                              </tr>
                            <?php endforeach ?>
                          <?php }else{ ?>
                            <tr>
                              <td colspan="6">Bạn chưa tạo game nào.</td>
                            </tr>
                          <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                <?php } ?>
              <?php } ?>


            </div>

            <div id="history-user-info" class="col-3 col-sm-3 col-md-3 col-lg-3" style="height: 400px">
              <div class="user-info-area">
                <!-- user avatar -->
                <div id="history-username-area" class="user-ava-area">
                  <img class="user-avatar d-inline-block" src="" alt="User's avatar">
                  <p id="history-username" class="username ellipsis d-inline-block"><?php echo $user_view_name; ?></p>
                </div><!-- /.user avatar -->

                <!-- user percent -->
                <div class="percent-panel center mt-3">
                  <p class="percent-panel-title">Tỷ lệ thắng thua</p>
                  <div id="increase" class="user-percent" data-toggle="tooltip" data-placement="top" title="Thắng">
                    <span class="in-num-percent">50%</span>
                  </div>
                  <div id="decrease" class="user-percent" data-toggle="tooltip" data-placement="top" title="Thua">
                    <span class="de-num-percent">50%</span>
                  </div>
                  <p class="game-des mt-5">Tham gia: <span class="total-game"><?php echo $user_view_total_game; ?> game</span>,<span class="win"><?php echo $user_view_total_game_win; ?> thắng</span>,<span class="lose"><?php echo $user_view_total_game-$user_view_total_game_win; ?> thua.</span></p>
                </div><!-- /.user percent -->
                <div class="user-info">
                  <p class="user-point">Point: <?php echo $user_view_point; ?></p>
                  <p class="user-phone">SĐT: <?php echo $user_view_phone; ?></p>
                  <p class="user-email">Email: <?php echo $user_view_email; ?></p>
                  <p class="user-address">Địa chỉ: <?php echo $user_view_address; ?></p>
                </div>
              </div>
            </div>
        </div><!-- /.content -->
      </div>
    </div>
  </div><!-- /.body -->

  <footer>
    <span>&copy; 2017</span>
  </footer>  

  <script src="<?php echo base_url(); ?>assets/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/jquery/jquery-migrate-1.2.1.min.js"></script>
  <!-- popper js -->
  <script src="<?php echo base_url(); ?>assets/popper/popper.min.js"></script>
  <!-- bootstrap js -->
  <script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.js"></script>

  <!-- Pusher -->
  <script src="https://js.pusher.com/4.1/pusher.min.js"></script>

  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap-confirmation.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/jquery/moment.js"></script>

  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/fb.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/user.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/yesNoGame.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/mulGame.js"></script>

  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/pusher.js"></script>

  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/ui.js"></script> 
  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/app.js"></script>
</body>
</html>
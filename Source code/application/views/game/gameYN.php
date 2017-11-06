<!DOCTYPE html>
<html lang="en">
<head>
  <title>Website dự đoán giá bitcoin</title>
  <!-- Required meta tags --> 
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

  <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->

  <script src="<?php echo base_url(); ?>assets/jquery/jquery.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.js"></script>

  <!-- Pusher -->
  <!-- <script src="https://js.pusher.com/4.1/pusher.min.js"></script> -->

</head>
<body onload="countDown_End_Date(end_date_game_mini,1);user_percent_in_de(ans_yes,ans_no);loadTable(list_bet_log);infinitySlideShow();"> 
  <script>
    var base_url = "<?php echo base_url(); ?>";
    var end_date_game_mini = "<?php echo $game_data->END_DATE; ?>";
    var ans_yes = "<?php echo $ans_yes; ?>"||0;
    var ans_no = "<?php echo $ans_no; ?>"||0;
    <?php if(isset($list_bet_log)){ ?>
    var list_bet_log = <?php echo json_encode($list_bet_log); ?>;
    <?php }else{?>
    var list_bet_log = [];
    <?php  }?>
  </script>
  <!-- body -->
  <div class="container-fluid">
    <div class="row">
      <!-- infinite slideshow -->
      <section id="hot-mini-game-area">
        <div id="hot-mini-game-content" class="hot-minigame slider autoplay"> 
          <?php foreach ($YN as $value): ?>
            <div class="hot-item" data-gameID="<?php echo $value['GAME_ID']; ?>" data-gameType="1">
              <a href="#!" title="<?php echo $value['TITLE']; ?>">
                <div class="title"><?php echo $value['TITLE']; ?></div>
                <div class="runner"><?php echo $value['USER_NAME']; ?></div>
                <div class="prob">
                  <span class="icon-arrow-up"><i class="fa fa-angle-up" aria-hidden="true"></i></span>
                  <span><?php echo $value['TOTAL_AMOUNT'] ?></span>
                </div>
              </a>
            </div>            
          <?php endforeach ?>
          
          <?php foreach ($MUL as $value): ?>
            <div class="hot-item" data-gameID="<?php echo $value['GAME_ID']; ?>" data-gameType="2">
              <a href="#!" title="<?php echo $value['TITLE']; ?>">
                <div class="title"><?php echo $value['TITLE']; ?></div>
                <div class="runner"><?php echo $value['USER_NAME']; ?></div>
                <div class="prob">
                  <span class="icon-arrow-up"><i class="fa fa-angle-up" aria-hidden="true"></i></span>
                  <span><?php echo $value['TOTAL_AMOUNT'] ?></span>
                </div>
              </a>
            </div>
          <?php endforeach ?>  
        </div>
      </section>    
      <!-- /.infinite slideshow -->
      <!-- navbar -->
      <nav id="my-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?php 
          if($this->session->userdata('loggedInGooge')){
            echo base_url().'login/user';
          }else if($this->session->userdata('loggedInFB')) {
            echo base_url().'login/fb_goHome';
          }else{
            echo base_url();
          }
         ?>">Logo</a>

        <?php if($this->session->userdata('loggedInGooge') || $this->session->userdata('loggedInFB')){ ?>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          <ul class="nav navbar-nav navbar-right">
            <!-- TODO tao mini game -->
            <li class="func-items nav-item" data-toggle="modal" data-target="#create-game">
              <a href="javascript:void(0);" class="nav-link">Tạo mini game</a>
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
                    <h5 class="modal-title col-centered" id="world-rank-title">TOP những thành viên có nhiều point nhất</h5>
                    <button type="button" class="close cursor-pointer" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true" title="Đóng">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">   
                    <div class="top-user text-center">
                      <div class="second d-inline-block text-center">
                        <figure>
                          <img src="<?php echo base_url(); ?>images/client/2nd.png" alt="2nd">
                          <figcaption class="top-user-name">Adam Smith</figcaption>
                          <figcaption class="top-user-point"><span class="second-point">171717</span></figcaption>
                        </figure>          
                      </div>
                      <div class="first d-inline-block text-center">
                        <figure>
                          <img src="<?php echo base_url(); ?>images/client/1st.png" alt="1st">
                          <figcaption class="top-user-name">Godon Jams</figcaption>
                          <figcaption class="top-user-point"><span class="first-point">272727</span></figcaption>
                        </figure>
                      </div>
                      <div class="third d-inline-block text-center">
                        <figure>
                          <img src="<?php echo base_url(); ?>images/client/3rd.png" alt="3rd">
                          <figcaption class="top-user-name">Ketty Prery</figcaption>
                          <figcaption class="top-user-point"><span class="third-point">5236</span></figcaption>              
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
                    <p>8</p>
                  </div>
                </button>
                <!-- notification list -->
                <ul id="user-notifi" class="dropdown-menu dropdown-menu-right pre-scrollable">
                  <li class="noti-items" class="btn btn-primary" data-toggle="modal" data-target="#notifi-popup">
                    <div class="noti-content ellipsis">
                      <a href="#!">
                        <p class="notifi-title notifi-1" class="ellipsis">
                          <div id="circle-read-1" class="green-circle d-inline-block" data-is-read="false"></div>
                          Notifi 1
                          <div class="time-area">
                            <span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                            <span class="send-date">15:37 - 10/7</span>
                          </div>
                        </p>
                      </a>
                    </div>
                  </li>                                                                      
                  <li class="noti-items" class="btn btn-primary" data-toggle="modal" data-target="#notifi-popup">
                    <div class="noti-content ellipsis">
                      <a href="#!">
                        <p class="notifi-title notifi-2" class="ellipsis">
                          <div id="circle-read-2" class="green-circle d-inline-block" data-is-read="false"></div>
                          Notifi 2
                          <div class="time-area">
                            <span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                            <span class="send-date">15:37 - 10/7</span>
                          </div>
                        </p>
                      </a>
                    </div>
                  </li>    
                  <li class="noti-items" class="btn btn-primary" data-toggle="modal" data-target="#notifi-popup">
                    <div class="noti-content ellipsis">
                      <a href="#!">
                        <p class="notifi-title notifi-3" class="ellipsis">
                          <div id="circle-read-3" class="green-circle d-inline-block" data-is-read="false"></div>
                          Notifi 3
                          <div class="time-area">
                            <span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                            <span class="send-date">15:37 - 10/7</span>
                          </div>
                        </p>
                      </a>
                    </div>
                  </li> 
                  <li class="noti-items" class="btn btn-primary" data-toggle="modal" data-target="#notifi-popup">
                    <div class="noti-content ellipsis">
                      <a href="#!">
                        <p class="notifi-title notifi-4" class="ellipsis">
                          <div id="circle-read-4" class="green-circle d-inline-block" data-is-read="false"></div>
                          Notifi 4
                          <div class="time-area">
                            <span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                            <span class="send-date">15:37 - 10/7</span>
                          </div>
                        </p>
                      </a>
                    </div>
                  </li>    
                  <li class="noti-items" class="btn btn-primary" data-toggle="modal" data-target="#notifi-popup">
                    <div class="noti-content ellipsis">
                      <a href="#!">
                        <p class="notifi-title notifi-5" class="ellipsis">
                          <div id="circle-read-5" class="green-circle d-inline-block" data-is-read="false"></div>
                          Notifi 5
                          <div class="time-area">
                            <span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                            <span class="send-date">15:37 - 10/7</span>
                          </div>
                        </p>
                      </a>
                    </div>
                  </li>    
                  <li class="noti-items" class="btn btn-primary" data-toggle="modal" data-target="#notifi-popup">
                    <div class="noti-content ellipsis">
                      <a href="#!">
                        <p class="notifi-title notifi-6" class="ellipsis">
                          <div id="circle-read-6" class="green-circle d-inline-block" data-is-read="false"></div>
                          Notifi 6
                          <div class="time-area">
                            <span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                            <span class="send-date">15:37 - 10/7</span>
                          </div>
                        </p>
                      </a>
                    </div>
                  </li>                                                                                                 
                </ul><!-- /.notification list -->
                <!-- popup notifi -->
                <div class="modal" id="notifi-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="notifi-popup-title">Notifi title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p class="notifi-message">...</p>
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
                <img src="<?php echo $this->session->userdata('userData')['USER_AVATAR']; ?>" alt="user default">
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
                  <?php } ?>
                </ul>
              </div> <!-- /.user dropdown button -->
              
              <!-- create game popup -->
              <div id="create-game" class="modal fade" tabindex="-1" role="dialog"
              aria-labelledby="createGame" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="create-mini-game">Tạo mini game</h5>
                      <button type="button" class="close cursor-pointer" data-dismiss="modal" aria-label="Close" title="Đóng">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">      
                      <!-- nav creat game -->
                      <ul id="nav-game" class="nav nav-tabs">
                        <li class="nav-item">
                          <a class="nav-link active" href="#yes-no-game">Yes/No</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#multi-choice-game">Q/A</a>
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
                            <input type="text" class="form-control d-inline-block" id="game-title" pattern="^.{6,35}$" required>                
                          </div>
                          <div class="form-group d-inline-block">
                            <label for="game-date">Vào ngày</label>
                            <input type="text" class="form-control d-inline-block" id="game-date-yn" readonly required>
                          </div>
                          <div class="form-group d-inline-block">
                            <label for="game-time">Kết thúc vào lúc</label>
                            <input type="time" class="form-control d-inline-block" id="game-time" placeholder="1" required>
                          </div>
                          <div class="form-group">
                            <label for="game-bitcoin-price">Giá Bitcoin trên (Đơn vị: USD)</label>
                            <input type="number" class="form-control" id="game-bitcoin-price" placeholder="1" min="1" pattern="^\d{1,10}$" step="0.01" required>
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
                            <input type="text" class="form-control d-inline-block" id="game-title-mul" pattern="^.{6,35}$" required>                
                          </div>              
                          <div class="form-group d-inline-block">
                            <label for="game-date">Vào ngày</label>
                            <input type="text" class="form-control d-inline-block" id="game-date-mul" readonly required>
                          </div>
                          <div class="form-group d-inline-block">
                            <label for="game-time">Kết thúc vào lúc</label>
                            <input type="time" class="form-control d-inline-block" id="game-time-mul" min="1" max="24" placeholder="1" required>
                          </div>
                          <div class="form-group">
                            <label for="">Giá Bitcoin ? (Đơn vị: USD)</label>
                          </div>              
                          <div class="form-group d-inline-block mr-3">
                            <label class="d-block" for="game-bitcoin-price-lower">Dưới</label>
                            <input type="number" class="form-control d-inline-block" id="game-bitcoin-price-lower" placeholder="1" min="1" pattern="^\\d{1,10}$" required>     
                          </div>            
                          <div class="form-group d-inline-block mr-3">
                            <label class="d-block" for="game-bitcoin-price-upper">Trên</label>
                            <input type="number" class="form-control d-inline-block" id="game-bitcoin-price-upper" placeholder="1" min="1" pattern="^\\d{1,10}$" required>
                          </div> 
                          <div class="form-group d-inline-block mr-3">  
                            <label class="d-block" for="game-bitcoin-price-between">Nằm giữa</label>
                            <input type="number" class="form-control d-inline-block" id="game-bitcoin-price-between-upper" placeholder="1" min="1" pattern="^\\d{1,10}$" disabled>
                          </div>
                          <div class="form-group d-inline-block mr-3">
                            <input type="number" class="form-control d-inline-block" id="game-bitcoin-price-between-lower" placeholder="1" min="1" pattern="^\\d{1,10}$" disabled>    
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
                            <img class="user-avatar" src="<?php echo $this->session->userdata('userData')['USER_AVATAR']; ?>" alt="User's avatar">
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

      <div id="mgyn-content-area" class="content-area">
        <!-- content -->
        <div class="content">
          <div class="row">

            <div class="col-6 col-sm-6 col-md-6 col-lg-6">
              <div class="mini-game-panel">
                <div class="mini-game-des">
                  <span class="mini-game-status game-opening">ĐANG MỞ</span>
                  <p class="mini-game-title"><?php echo $game_data->TITLE; ?></p>
                  <p class="mini-game-transaction"><?php echo 'Point hiện tại: '.$game_data->TOTAL_AMOUNT; ?></p>
                </div>
                <div class="mini-game-content mb-5" data-gameID="<?php echo $game_data->GAME_ID; ?>">
                  <table class="mini-game-conten-info">
                    <tr>
                      <td>
                        <p class="user-create">Người tạo game:</p>
                      </td>
                      <td>
                        <p class="user-create"><?php echo $game_data->USER_NAME; ?></p>
                      </td>                      
                    </tr>
                    <tr>
                      <td>
                        <p class="close-date">Đóng trong:</p>
                      </td>
                      <td>
                        <p class="close-date" id="game_mini_countdown"></p>
                      </td>                      
                    </tr> 
                    <tr>
                      <td>
                        <p class="create-date">Ngày tạo:</p>
                      </td>
                      <td>
                        <p class="create-date"><?php echo $game_data->START_DATE; ?></p>
                      </td>                      
                    </tr>                                       
                  </table>

                  <!-- bet percent -->
                  <div class="percent-panel center">
                    <p class="percent-panel-title">Tỷ lệ đặt cược</p>
                    <div id="increase" class="user-percent" data-toggle="tooltip" data-placement="top" title="Yes">
                      <span class="in-num-percent">50%</span>
                    </div>
                    <div id="decrease" class="user-percent" data-toggle="tooltip" data-placement="top" title="No">
                      <span class="de-num-percent">50%</span>
                    </div>
                  </div><!-- /.bet percent -->
                </div>

                <?php if($this->session->userdata('loggedInGooge') || $this->session->userdata('loggedInFB')){ ?>
                <div class="mini-game-bet mt-5">
                  <form name="mini-yn-bet">
                    <div class="form-group d-inline-block">
                      <label class="no-margin">Lựa chọn của bạn ?</label>
                    </div>
                    <div class="form-group d-inline-block">  
                      <label class="form-check-label">
                        <input id="yes-radio" class="form-check-input radio-cus" type="radio" name="yes-or-no" value="1">Yes
                      </label>
                      <label class="form-check-label">  
                        <input id="no-radio" class="form-check-input radio-cus" type="radio" name="yes-or-no" value="0">No
                      </label>
                    </div>
                    <div class="form-group">
                      <p class="caution">Lưu ý: Bạn chỉ được đặt cược duy nhất 1 lần, chi phí là 10 point. Hãy cân nhắc</p> 
                    </div> 
                    <div class="form-group submit-area">
                      <button type="button" class="game-btn-yes-no btn-height cursor-pointer" id="bet-game-yes-no" name="">Đặt cược</button>
                    </div>                       
                  </form>                  
                </div>
                <?php }else{ ?>
                <p class="no-margin">Bạn cần <a href="<?php echo base_url(); ?>">Đăng nhập </a> để đặt cược trò chơi !</p> 
                <?php } ?>
              </div>
            </div> <!-- end content game -->

            <div id="mgyn-contact-area" class="col-6 col-sm-6 col-md-6 col-lg-6">
              <a data-toggle="collapse" href="#game-transaction" aria-expanded="true" aria-controls="game-transaction">
                <i class="fa fa-gavel" aria-hidden="true"></i> Lịch sử đặt cược 
              </a>
              <div class="collapse show" id="game-transaction">
                <div class="card card-body">
                  <table id="list-bet-log" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Thời gian</th>
                        <th>Người chơi</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>                          
            </div> <!-- end lich su dat cuoc -->
          </div> <!-- end row -->
        </div><!-- /.content -->
      </div>
    </div> <!-- end row -->
  </div><!-- /.container-fluid -->

  <footer>
    <div>LowHope &copy; 2017. All Right Reserved.</div>
    <div>Mọi hình thức sao chép nội dung trên website này mà chưa được sự đồng ý đều là trái phép.</div>
  </footer>


  <script src="<?php echo base_url(); ?>assets/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/jquery/jquery-migrate-1.2.1.min.js"></script>
  <!-- popper js -->
  <script src="<?php echo base_url(); ?>assets/popper/popper.min.js"></script>
  <!-- bootstrap js -->
  <script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.js"></script>
  
  <script src="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.js"></script>
  <!-- high chart js -->
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>

  <!-- high chart display -->
  <!-- <script type="text/javascript" src="<?php echo base_url(); ?>js/client/chartBasicLine.js"></script> -->

  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/fb.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/user.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/yesNoGame.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/mulGame.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/ui.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/client/app.js"></script>
</body>
</html>
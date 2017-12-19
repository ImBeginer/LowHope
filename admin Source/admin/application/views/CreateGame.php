<!DOCTYPE html>
<html>
<head>
  <title>Create game</title>
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
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.css">
  <!-- custom css -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/main.css">
</head>
<body>
  <script>
    var base_url = '<?php echo base_url(); ?>';
  </script>
<!-- manager content -->
<div id="manager-create-game" class="container-fluid">
  <!-- side bar -->
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
      <ul class="sidebar-content nav nav-sidebar">
        <li class="manager-avatar c-active">
          <a class="manager-link" href="#!"><img src="<?php echo base_url().'img/ava-default.png'; ?>" alt="avatar"></a>
          <div class="manager-name ellipsis collapsed cursor-pointer" data-toggle="collapse" data-target="#user-option"><?php echo $userName ?></div>
          <ul class="sub-menu collapse" id="user-option">
            <li class="cursor-pointer"><a href="<?php echo base_url().'ManagerInfo/'; ?>">Thông tin cá nhân</a></li>
            <li class="cursor-pointer"><a href="<?php echo base_url().'EditManagerInfo/'; ?>">S?a thông tin</a></li>
            <li class="cursor-pointer"><a href="<?php echo base_url().'ChangePassword/'; ?>">Ð?i m?t kh?u</a></li>
          </ul>             
        </li>
        <li class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="T?ng quát v? website" ><a href="<?php echo base_url().'Home/'; ?>">T?ng quát</a></li>        
        <li class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="G?i thông báo d?n ngu?i choi"><a href="<?php echo base_url().'Notification/'; ?>">G?i thông báo</a></li>
        <li class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="L?ch s? game"><a href="<?php echo base_url().'CultureGame/'; ?>">L?ch s?</a></li>
        <li class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="T?o game cho ngu?i choi"><a href="#!">T?o game</a></li>

        <li data-toggle="collapse" data-target="#admin-option" class="cursor-pointer c-active" aria-expanded="true">
          <a>Qu?n lý</a>
        </li>
        <ul class="sub-menu collapse" id="admin-option">
          <li class=""><a href="<?php echo base_url().'ChangeManager'; ?>">Block or Unblock Manager</a></li>
          <li class="c-active"><a href="<?php echo base_url().'ChangeGift'; ?>">Gi?i thu?ng</a></li>
        </ul>      
      </ul>
      <div class="manager-option-area c-active" title="Ðang xu?t">
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
          <p class="title">T?o th? thách</p>
        </div>
        <div class="create-game-option col-md-6 col-md-offset-3">
          <!-- nav creat game -->
          <ul id="nav-game" class="nav nav-tabs">
            <li class="nav-item">
              <a class="c-yn-game nav-link c-avtive active" href="#yes-no-game">Ðúng/Sai</a>
            </li>
            <li class="nav-item">
              <a class="c-mul-game nav-link c-avtive " href="#multi-choice-game">L?a ch?n</a>
            </li>        
          </ul><!-- /.nav create game --> 
          <!-- tab game -->
          <div class="tab-content game-tab-content">
            <div role="tabpanel" class="tab-pane active" id="yes-no-game">
              <div class="message"></div>
              <div class="user-form form" action="#!">
                <form action="#!" name="m-create-yn-game">
                  <div class="form-group">
                    <label for="game-title">Tên game</label>
                    <input type="text" class="form-control d-inline-block" id="game-title" pattern="^.{6,}$" required data-toggle="tooltip" data-placement="bottom" title="Tên game ít nh?t ph?i ch?a t? 6 ký t?.">
                  </div>
                  <div class="form-group d-inline-block">
                    <label for="game-date">Vào ngày</label>
                    <input type="text" class="form-control d-inline-block" id="game-date-yn" readonly required data-toggle="tooltip" data-placement="left" title="Ngày k?t thúc b?t d?u t? hôm nay.">
                  </div>
                  <div class="form-group d-inline-block">
                    <label for="game-time">K?t thúc vào lúc</label>
                    <input type="time" class="form-control d-inline-block" id="game-time" placeholder="1" required data-toggle="tooltip" data-placement="bottom" title="Th?i gian k?t thúc ph?i l?n hon th?i gian hi?n t?i.">
                  </div>
                  <div class="form-group">
                    <label for="game-bitcoin-price">Giá Bitcoin trên (Ðon v?: USD)</label>
                        <input type="number" class="form-control" id="game-bitcoin-price" placeholder="0" pattern="/^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/" min="0" step="0.01" required data-toggle="tooltip" data-placement="bottom" title="Giá bitcoin ph?i l?n hon 0 và t?i da 2 ch? s? hàng th?p phân !(6,00 = 6.00 USD)">
                  </div> 
                  <div class="form-group submit-area">
                    <button type="reset" class="btn btn-height close-update cursor-pointer color-white">Xóa</button>
                    <button type="button" class="btn game-btn-yes-no create btn-height cursor-pointer color-white" id="create-game-btn-yes-no" name="m-create-yn-game">T?o</button>
                  </div>
                </form>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="multi-choice-game">
              <div class="user-form form" action="#!">
                <div class="message"></div>
                <form action="#!" name="m-create-mul-game">
                  <div class="form-group">
                    <label for="game-title">Tên game</label>
                    <input type="text" class="form-control d-inline-block" id="game-title-mul" pattern="^.{6,}$" required data-toggle="tooltip" data-placement="bottom" title="Tên game ít nh?t ph?i ch?a t? 6 ký t?.">
                  </div>              
                  <div class="form-group d-inline-block">
                    <label for="game-date">Vào ngày</label>
                    <input type="text" class="form-control d-inline-block" id="game-date-mul" readonly required data-toggle="tooltip" data-placement="left" title="Ngày k?t thúc b?t d?u t? hôm nay.">
                  </div>
                  <div class="form-group d-inline-block">
                    <label for="game-time">K?t thúc vào lúc</label>
                    <input type="time" class="form-control d-inline-block" id="game-time-mul" min="1" max="24" placeholder="1" required data-toggle="tooltip" data-placement="bottom" title="Th?i gian k?t thúc ph?i l?n hon th?i gian hi?n t?i.">
                  </div>
                  <div class="form-group">
                    <label for="">Giá Bitcoin ? (Ðon v?: USD)</label>
                  </div>              
                  <div class="form-group d-inline-block mr-3">
                    <label class="d-block" for="game-bitcoin-price-lower">Du?i</label>
                    <input type="number" class="form-control d-inline-block" id="game-bitcoin-price-lower" pattern="/^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/" placeholder="0.01" min="0" step="0.01" required data-toggle="tooltip" data-placement="bottom" title="Giá bitcoin ph?i l?n hon 0 và t?i da 2 ch? s? hàng th?p phân !(6,00 = 6.00 USD)">
                  </div> 
                  <div class="form-group d-inline-block mr-3">
                    <label class="d-block" for="game-bitcoin-price-upper">Trên</label>
                    <input type="number" class="form-control d-inline-block" id="game-bitcoin-price-upper" pattern="/^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/" placeholder="0.01" min="1"  step="0.01" required data-toggle="tooltip" data-placement="bottom" title="Giá bitcoin ph?i l?n hon 0 và t?i da 2 ch? s? hàng th?p phân !(6,00 = 6.00 USD)">    
                  </div>            
                  <div class="form-group d-inline-block mr-3">  
                    <label class="d-block" for="game-bitcoin-price-between">N?m gi?a</label>
                    <input type="number" class="form-control d-inline-block" id="game-bitcoin-price-between-upper" pattern="/^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/" placeholder="0.01" min="0" step="0.01" disabled>
                  </div>
                  <div class="form-group d-inline-block mr-3">
                    <input type="number" class="form-control d-inline-block" id="game-bitcoin-price-between-lower" pattern="/^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/" placeholder="0.01" min="0" step="0.01" disabled>    
                  </div>                              
                  <div class="form-group submit-area">
                    <button type="reset" class="btn btn-height close-update cursor-pointer color-white">Xóa</button>
                    <button type="button" class="btn game-btn-mul create btn-height cursor-pointer color-white" id="create-game-btn-mul" name="m-create-mul-game">T?o</button>
                  </div>
                </form>
              </div>
            </div>
          </div><!-- /.tab game -->
        </div>
      </div>
    </div>
  </div><!-- /.right side hand -->
  <!-- footer -->
  <footer>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 footer-content medium-font-size">
      &copy; 2017
      <div class="about-us">
        <a class="black medium-font-size" href="#!">V? chúng tôi</a>
        <a class="black medium-font-size" href="#!">Các di?u kho?n và chính sách</a>
        <a class="black medium-font-size" href="#!">Hu?ng d?n s? d?ng</a>
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
<script src="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.js"></script>

<script src="<?php echo base_url(); ?>js/mulGame.js"></script>
<script src="<?php echo base_url(); ?>js/yesNoGame.js"></script>
<script src="<?php echo base_url(); ?>js/checkData.js"></script>
<script src="<?php echo base_url(); ?>js/ui.js"></script>
<script src="<?php echo base_url(); ?>js/createGame.js"></script>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
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
    var base_url = "<?php echo base_url(); ?>";
  </script>

  <!-- login content -->
  <div id="login" class="login-content container-fluid">
    <div class="row">
      <div class="login-panel animated fadeInDown col-sm-6 col-md-6 col-xl-6 col-sm-offset-3 col-md-offset-3 col-xl-offset-3">
        <div class="avtar">
          <img class="user-ava text-center" src="<?php echo base_url().'img/lhp.png'; ?>" alt="avatar">
        </div>
        <div class="component">
          <div class="message"></div>
            <div class="form-group">
              <input type="text" class="form-control" id="username" placeholder="Email">
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="password" placeholder="Mật khẩu">
            </div>          
            <button type="submit" name="login-info" class="btn login-btn cursor-pointer">Đăng nhập</button>
            <p class="forgot-password in-blk"><a href="<?php echo base_url().'ForgotPassword'; ?>" class="forgot-password-link"><i class="fa fa-unlock-alt" aria-hidden="true"></i>Quên mật khẩu</a></p>
        </div>
      </div>
    </div>
  </div>
  <!-- login content -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/jquery/jquery-1.12.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jquery/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>assets/popper/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jquery/jquery.toast.min.js"></script>

<!-- Custom JS -->
<script src="<?php echo base_url(); ?>js/checkLogin.js"></script>
<script src="<?php echo base_url(); ?>js/nofiti.js"></script>
<script src="<?php echo base_url(); ?>js/checkData.js"></script>
<script src="<?php echo base_url(); ?>js/login.js"></script>
<script src="<?php echo base_url(); ?>js/ui.js"></script>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
  <title>Quên mật khẩu</title>
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
<div id="manager-forgot-pass" class="container-fluid">
  <!-- right side hand -->
  <div class="row">
    <div class="right-side-hand col-sm-12 col-md-12 col-xl-12 col-12 main-content">
      <div class="main-function">      
        <div class="function-title">
          <p class="title">Quên mật khẩu</p>
        </div>
        <div class="manager-info">
          <div class="message"></div>
          <form action="#!" name="m-forgot-pass">

            <label for="newpass">Nhập Email</label>
            <input type="email" id="fgemail" class="form-control" name="email" placeholder="abc@gmail.com">

            <div class="text-center m-update-btn-area">
              <a href="<?php echo base_url().'Login';  ?>" class="signin-link"><i class="fa fa-sign-in" aria-hidden="true"></i>Đăng nhập</a>
              <button type="button" class="btn m-forgot-pass-btn" name="m-forgot-pass-btn">Gửi mật khẩu về email</button>
            </div>
          </form>
        </div>
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
<script src="<?php echo base_url(); ?>js/ForgotPassword.js"></script>

</body>
</html>

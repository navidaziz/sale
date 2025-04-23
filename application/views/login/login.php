<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="Quick Sale - Track Every Sale, Every Day">
  <meta name="author" content="">

  <title>Quick Sale</title>

  <!-- Stylesheets -->
  <!--[if lt IE 9]>
    <script src="js/flot/excanvas.min.js"></script>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
  <![endif]-->
  <link rel="stylesheet" href="<?php echo site_url("assets/"); ?>/css/cloud-admin.css">
  <link href="<?php echo site_url("assets/"); ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="//fonts.googleapis.com/earlyaccess/notonastaliqurdudraft.css">

  <script src="https://www.google.com/recaptcha/api.js"></script>

  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-151551956-1');
  </script>
</head>
<!-- Add this CSS for the blurred background -->
<style>
  body::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('<?php echo site_url("assets/img/background2.jpg"); ?>');
    background-size: cover;
    filter: blur(2px);
    z-index: -1;
    /* Ensures that the content remains in front of the blurred background */
  }
</style>

<body class="log in" style="position: relative; height: 100%; background-size: cover;">


  <section id="page">

    <!-- Login Section -->
    <section id="login_bg" <?php if ($this->input->get('register') != 1) echo 'class="visible"'; ?>>
      <div class="container">
        <div class="row" id="hidden-mobile" style="margin: 10px; margin-top: 70px;">
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-12 text-center" style="color: white; ">
                <?php if (!preg_match('/mobile/i', $_SERVER['HTTP_USER_AGENT'])) { ?>
                  <img id="log" src="<?php echo site_url('assets/img/logo.png'); ?>" alt="Quick Sale" title="Quick Sale" style="width:500px !important;">
                  <h2>Quick Sale</h2>
                  <h4>Track Every Sale, Every Day</h4>
                  <h5>Contact Us: Email: quicksale@chitral.com.pk | Mobile: 0324 4424414</h5>
                  <h5>Powered By ATS Chitral</h5>
                <?php } else { ?>
                  <h2> <img id="log" src="<?php echo site_url('assets/img/logo.png'); ?>" alt="Quick Sale" title="Quick Sale" style="width:50px !important;">
                    Quick Sale</h2>
                <?php   } ?>

              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="login-box" style="background-color:#5C9CCC; margin: 5px auto; padding-top: 0px; padding-top:20px">
              <h2 class="bigintro">Sign In</h2>
              <div class="divide-20"></div>

              <?php if ($this->session->flashdata("msg") || $this->session->flashdata("msg_error") || $this->session->flashdata("msg_success")): ?>
                <?php
                $msg_type = "";
                $msg = "";
                if ($this->session->flashdata("msg_success")) {
                  $msg_type = "success";
                  $msg = $this->session->flashdata("msg_success");
                } elseif ($this->session->flashdata("msg_error")) {
                  $msg_type = "danger";
                  $msg = $this->session->flashdata("msg_error");
                } else {
                  $msg_type = "info";
                  $msg = $this->session->flashdata("msg");
                }
                ?>
                <div class="alert alert-<?php echo $msg_type; ?>" role="alert" style="font-family: 'Noto Nastaliq Urdu Draft', serif; line-height: 22px;">
                  <i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $msg; ?>
                </div>
              <?php endif; ?>

              <?php if (validation_errors()): ?>
                <div class="alert alert-danger">
                  <?php echo validation_errors(); ?>
                </div>
              <?php endif; ?>

              <form onsubmit="return validate()" role="form" method="post" action="<?php echo site_url("login/validate_user"); ?>">
                <div class="form-group">
                  <label for="userName">User Name</label>
                  <i class="fa fa-user"></i>
                  <input type="text" name="userName" class="form-control" id="userName" value="<?php echo set_value('userName'); ?>" required>
                </div>
                <div class="form-group">
                  <label for="userPassword">Password</label>
                  <i class="fa fa-lock"></i>
                  <input type="password" name="userPassword" class="form-control" id="userPassword" value="" required>
                </div>

                <div>
                  <button type="submit" class="btn btn-danger">Login</button>
                  <a class="btn btn-link btn-sm" href="<?php echo site_url('register/password_reset'); ?>" style="text-decoration: none; margin-bottom:5px;">Forgot Password?</a>
                </div>
              </form>

              <div class="divide-20"></div>

              <h4>Create Account For Shop / Restaurant</h4>
              <a class="btn btn-primary" href="<?php echo site_url('register/index'); ?>" style="text-decoration: none; width:100%;">Create Account</a>
            </div>
          </div>
        </div>
      </div>
    </section>



  </section>

  <!-- JavaScript -->
  <script src="<?php echo site_url('assets/'); ?>/js/jquery/jquery-2.0.3.min.js"></script>
  <script src="<?php echo site_url('assets/'); ?>/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
  <script src="<?php echo site_url('assets/'); ?>/bootstrap-dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo site_url('assets/'); ?>/js/uniform/jquery.uniform.min.js"></script>
  <script type="text/javascript" src="<?php echo site_url('assets/'); ?>/js/backstretch/jquery.backstretch.min.js"></script>
  <script src="<?php echo site_url('assets/'); ?>/js/script.js"></script>

  <script>
    function validate() {

      // const recaptchaResponse = document.getElementById('g-recaptcha-response').value;
      // if (recaptchaResponse === "") {
      //   $('.validation_message').show().html('<div style="border:1px solid #D1322C; padding:5px; border-radius:5px;">Please Click on "I\'m not a robot"</div>').delay(1000).fadeOut('slow');
      //   return false;
      // }
    }
  </script>

</body>

</html>
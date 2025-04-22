<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title>Account Registration</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- STYLESHEETS -->
  <!--[if lt IE 9]><script src="js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/"); ?>/css/cloud-admin.css">
  <link href="<?php echo site_url("assets/"); ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet">

  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-151551956-1');
  </script>
</head>

<body class="log in" style="position: relative;
    height: 100%;
    background-image: url(<?php echo site_url("assets//img/background.jpg"); ?>);
    background-size: cover;
    ">
  <!-- PAGE -->
  <section id="page">
    <style>
      @media (max-width:629px) {
        #log {
          display: none;
        }
      }

      @media (max-width: 629px) {
        #hidden-mobile {
          margin-top: 0px !important;
        }
      }
    </style>

    <section id="registe r_bg" class="font-400" class="font-400 visible animated fadeInUp">
      <div class="container">
        <div class="row" style="margin: 10px; margin-top: 70px;">
          <div id="log" class="col-md-7">
            <div id="logo">
              <div style=" width:100%; text-align: center; margin:0px auto; color:black; ">
                <img src=" <?php echo site_url("assets/img/logo.png"); ?>" alt="Quick Sale" title="Quick Sale" style="width:350px !important;" />

                <h2>Private businesses Regulatory Authority</h2>
                <h4>Government Of Khyber Pakhtunkhwa</h4>
                <address><i class="fa fa-envelope"></i> psra.pmdu@gmail.com
                  <span style="margin-left: 10px;"></span>
                  <a style="font-weight: bold; color:red" href="tel:+92091-9216205">
                    <i class="fa fa-phone" aria-hidden="true"></i>
                    091-9216205 </a>

                  <br />


                  <i class="fa fa-map-marker" aria-hidden="true"></i> 18-E Jamal Ud Din Afghani Road, University Town, Peshawar
                </address>

              </div>
              <div style="clear:both;"></div>

            </div>
          </div>
          <div class="col-md-4">
            <div class="login-box" style="background-color:#5C9CCC; opacity:.9; margin: 5px auto; padding-top:10px !important;">
              <h2 class="bigintro" style="font-size: 25px;">Create Institute Account</h2>
              <div class="divide-10"></div>
              <form onsubmit="return validate()" role="form" method="post" action="<?php echo site_url("register/signup"); ?>">
                <div class="form-group">
                  <label for="username">User Name</label>
                  <i class="fa fa-user"></i>
                  <input required type="text" class="form-control" id="userName" name="userName" value="<?php echo set_value('userName', $userName); ?>" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <i class="fa fa-lock"></i>
                  <input required type="password" class="form-control" id="userPassword" name="userPassword" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword2">Confirm Password</label>
                  <i class="fa fa-check-square-o"></i>
                  <input required type="password" class="form-control" id="c_userPassword" name="c_userPassword" />
                </div>
                <div class="form-group">
                  <label for="email">Email Address</label>
                  <i class="fa fa-envelope"></i>
                  <input required type="email" class="form-control" id="email_address" name="email_address" value="<?php echo set_value('email_address', $email_address); ?>">
                </div>
                <div class="form-group">
                  <div class="g-recaptcha" data-sitekey="6Leuqa4ZAAAAAEBURd3DWqmwV4cdzXi5zzcljMLR" style="height: 100px;">
                  </div>
                  <div class="validation_message" style="font-weight: bold;"></div>
                </div>
                <div>

                  <button type="submit" class="btn btn-success">Create Account</button>

                </div>
              </form>
              <!-- SOCIAL REGISTER -->
              <div class="divide-20"></div>

              <?php if (validation_errors()) { ?>
                <div class="alert alert-block alert-danger fade in">
                  <?php echo validation_errors(); ?>
                </div>
              <?php } ?>


              <!-- /SOCIAL REGISTER -->
              <div class="login-helpers" style="text-align: center;">
                <a class="btn btn-danger" href="<?php echo site_url('login'); ?>"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Login</a>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </section>
  <!--/PAGE -->
  <!-- JAVASCRIPTS -->
  <!-- Placed at the end of the document so the pages load faster -->
  <!-- JQUERY -->
  <script src="<?php echo site_url("assets/"); ?>/js/jquery/jquery-2.0.3.min.js"></script>
  <!-- JQUERY UI-->
  <script src="<?php echo site_url("assets/"); ?>/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
  <!-- BOOTSTRAP -->
  <script src="<?php echo site_url("assets/"); ?>/bootstrap-dist/js/bootstrap.min.js"></script>

  <script>
    function validate() {

      emp = document.getElementById('g-recaptcha-response').value;
      if (emp == "") {
        $('.validation_message').show();
        $('.validation_message').html('<div style="border:1px solid #D1322C; padding:5px; border-radius:5px;">Please Click on I\'m not a robot<div>');
        $('.validation_message').delay(1000).fadeOut('slow');
        return false;
      }

    }
  </script>

</body>

</html>
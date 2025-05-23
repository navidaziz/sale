﻿<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- STYLESHEETS -->
	<!--[if lt IE 9]><script src="js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/"); ?>/css/cloud-admin.css">
	<link href="<?php echo site_url("assets/"); ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- DATE RANGE PICKER -->
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/"); ?>/js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
	<!-- UNIFORM -->
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/"); ?>/js/uniform/css/uniform.default.min.css" />
	<!-- ANIMATE -->
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/"); ?>/css/animatecss/animate.min.css" />
	<!-- FONTS -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
</head>

<body class="log in" style="position: relative;
    height: 100%;
    background-image: url(<?php echo site_url("assets//img/background.jpg"); ?>);
    background-size: cover;
    ">
	<!-- PAGE -->
	<section id="page">
		<!-- HEADER -->

		<section id="forgot _bg">




			<div class="container">
				<div class="row">
					<div class="col-md-5 col-md-offset-3">
						<div class="login-box-plain">
							<h2 class="bigintro">Recover Account Detail</h2>
							<div class="divide-40"></div>
							<form style="display: none;" role="form" method="post" action="<?php echo site_url("register/password_reset_submit"); ?>">
								<?php if (validation_errors()) { ?>
									<div class="alert alert-block alert-danger fade in">
										<?php echo validation_errors(); ?>
									</div>
								<?php } ?>

								<!-- <div class="form-group">
									<label for="user_email">Enter Institute ID</label>

									<i class="fa fa-id-card"></i>
									<input type="number" class="form-control" name="school_id" id="school_id">
								</div> -->

								<div class="form-group">
									<label for="user_email">Enter your Email address</label>

									<i class="fa fa-envelope"></i>
									<input type="email" class="form-control" name="user_email" id="user_email">
								</div>

								<div class="form-ac tions">
									<button type="submit" class="btn btn-danger">Send me Account Detail</button>
								</div>
							</form>
							<div>
								<p style="">
									If you need to retrieve your account username or password, please contact the MIS Section at <a style="font-weight: bold; color:red" href="tel:+920324-4424414">
										<i class="fa fa-phone" aria-hidden="true"></i>
										0324-4424414 </a>. Please keep in mind that account details will only be shared after verification of the institute owner.</p>
							</div>
							<div class="login-helpers">
								<a href="<?php echo site_url(); ?>">Back to Login</a>
							</div>
						</div>


					</div>
				</div>
			</div>










		</section>
		<!-- FORGOT PASSWORD -->
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

	<!-- UNIFORM -->
	<script type="text/javascript" src="<?php echo site_url("assets/"); ?>/js/uniform/jquery.uniform.min.js"></script>
	<!-- BACKSTRETCH -->
	<script type="text/javascript" src="<?php echo site_url("assets/"); ?>/js/backstretch/jquery.backstretch.min.js"></script>
	<!-- CUSTOM SCRIPT -->
	<script src="<?php echo site_url("assets/"); ?>/js/script.js"></script>
	<script>
		jQuery(document).ready(function() {
			App.setPage("login_bg"); //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>
	<script type="text/javascript">
		function swapScreen(id) {
			jQuery('.visible').removeClass('visible animated fadeInUp');
			jQuery('#' + id).addClass('visible animated fadeInUp');
		}
	</script>

	<!-- /JAVASCRIPTS -->
</body>

</html>
 <!DOCTYPE html>
 <html lang="en">

 <head>
   <meta charset="UTF-8">
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
   <meta name="description" content="Quick Sale - Track Every Sale, Every Day">
   <meta name="author" content="">

   <title>Quick Sale Account Registraion</title>

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

             <div class="login-box" style="background-color:#5C9CCC; opacity:.9; margin: 5px auto; padding-top:-10px !important;">
               <h5 class="bigi ntro">Create Institute Account</h5>
               <div class="divide-10"></div>
               <form onsubmit="return validate()" role="form" method="post" action="<?php echo site_url("register/signup"); ?>">
                 <div class="form-group">
                   <label for="username">User Name</label>
                   <i class="fa fa-user"></i>
                   <input required type="text" class="form-control" id="userName" name="userName" value="<?php echo set_value('userName', @$userName); ?>" />
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
                   <input required type="email" class="form-control" id="email_address" name="email_address" value="<?php echo set_value('email_address', @$email_address); ?>">
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

   <!-- JavaScript -->
   <script src="<?php echo site_url('assets/'); ?>/js/jquery/jquery-2.0.3.min.js"></script>
   <script src="<?php echo site_url('assets/'); ?>/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
   <script src="<?php echo site_url('assets/'); ?>/bootstrap-dist/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="<?php echo site_url('assets/'); ?>/js/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="<?php echo site_url('assets/'); ?>/js/backstretch/jquery.backstretch.min.js"></script>
   <script src="<?php echo site_url('assets/'); ?>/js/script.js"></script>

   <script>
     function validate() {
       const recaptchaResponse = document.getElementById('g-recaptcha-response').value;
       if (recaptchaResponse === "") {
         $('.validation_message').show().html('<div style="border:1px solid #D1322C; padding:5px; border-radius:5px;">Please Click on "I\'m not a robot"</div>').delay(1000).fadeOut('slow');
         return false;
       }
     }
   </script>

 </body>

 </html>
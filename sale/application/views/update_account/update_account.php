<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="Quick Sale - Track Every Sale, Every Day">
  <meta name="author" content="">

  <title>Quick Sale - Update Account</title>

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


          <div class="col-md-6 col-md-offset-3">
            <div class="login-box" style="background-color:#5C9CCC; margin: 5px auto; padding: 55px 40px 40px;">
              <h2 class="bigintro">Shop / Restaurant Detail</h2>
              <div class="divide-20"></div>
              <form id="businesses" class="form-horizontal" enctype="multipart/form-data" method="post">
                <input type="hidden" name="business_id" value="<?php echo $input->business_id; ?>" />
                <div class="form-group row">
                  <label for="name" class="col-sm-4 col-form-label">Name</label>
                  <div class="col-sm-8">
                    <input type="text" required id="name" name="name" value="<?php echo $input->name; ?>" class="form-control">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="type" class="col-sm-4 col-form-label">Type</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="type" id="type" required>
                      <option value="">Select Type</option>
                      <option value="Shop" <?php if ($input->type == 'Shop') echo 'selected'; ?>>Shop</option>
                      <option value="Restaurant" <?php if ($input->type == 'Restaurant') echo 'selected'; ?>>Restaurant</option>
                    </select>
                  </div>
                </div>


                <div class="form-group row">
                  <label for="category" class="col-sm-4 col-form-label">Category</label>
                  <div class="col-sm-8">
                    <input type="text" required id="category" name="category" value="<?php echo $input->category; ?>" class="form-control">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="contact_no" class="col-sm-4 col-form-label">Contact No</label>
                  <div class="col-sm-8">
                    <input type="number" required id="contact_no" name="contact_no" value="<?php echo $input->contact_no; ?>" class="form-control">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="city" class="col-sm-4 col-form-label">City</label>
                  <div class="col-sm-8">
                    <input type="text" required id="city" name="city" value="<?php echo $input->city; ?>" class="form-control">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="district" class="col-sm-4 col-form-label">District</label>
                  <div class="col-sm-8">
                    <input type="text" required id="district" name="district" value="<?php echo $input->district; ?>" class="form-control">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="latitude" class="col-sm-4 col-form-label">Latitude</label>
                  <div class="col-sm-8">
                    <input type="text" required id="latitude" name="latitude" value="<?php echo $input->latitude; ?>" class="form-control">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="longitude" class="col-sm-4 col-form-label">Longitude</label>
                  <div class="col-sm-8">
                    <input type="text" required id="longitude" name="longitude" value="<?php echo $input->longitude; ?>" class="form-control">
                  </div>
                </div>


                <div class="form-group row" style="text-align:center">
                  <div id="result_response"></div>
                  <button type="submit" class="btn btn-success">Update Account Detail</button>

                </div>
              </form>
            </div>



            <div class="divide-20"></div>
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
    $('#businesses').submit(function(e) {
      e.preventDefault();
      var formData = $(this).serialize();
      $.ajax({
        type: 'POST',
        url: '<?php echo site_url("update_account/update_account"); ?>', // URL to submit form data
        data: formData,
        success: function(response) {
          // Display response
          if (response === 'success') {
            window.location.href = '<?php echo site_url("sale_point"); ?>';
          } else {
            $('#result_response').html(response);
          }


        }
      });
    });
  </script>

</body>

</html>
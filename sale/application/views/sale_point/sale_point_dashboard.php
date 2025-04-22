  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <h2>
              <?php echo @ucfirst($title); ?>
          </h2>
          <small><?php echo @$description; ?></small>
          <ol class="breadcrumb">
              <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
              <!-- <li><a href="#">Examples</a></li> -->
              <li class="active"><?php echo @$title; ?></li>
          </ol>
      </section>

      <!-- Main content -->
      <section class="content">

          <div class="box box-primary box-solid">
              <div class="box-header with-border">
                  <h3 class="box-title"><?php echo @ucfirst($title); ?>s list</h3>
                  <!-- /.box-tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                  <div class="pull-right">
                      <a href="<?php echo base_url('user/create_form'); ?>" class="btn btn-flat btn-primary">Add new <?php echo $title; ?></a>
                  </div>

                  <br>
                  <p>Showing &nbsp; <?php echo $offset; ?> &nbsp; to &nbsp;<?php echo $offset + 10; ?> &nbsp; of &nbsp;<?php echo $number_of_rows; ?></p>
                  <?= $this->pagination->create_links(); ?>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                  <!-- Footer -->
              </div>
              <!-- /.box-footer-->
          </div>
          <!-- /.box -->

      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  </div>
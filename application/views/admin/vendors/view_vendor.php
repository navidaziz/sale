<!-- PAGE HEADER-->
<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <!-- STYLER -->

            <!-- /STYLER -->
            <!-- BREADCRUMBS -->
            <ul class="breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
                </li>
                <li>
                    <i class="fa fa-table"></i>
                    <a href="<?php echo site_url(ADMIN_DIR . "vendors/view/"); ?>"><?php echo $this->lang->line('Vendors'); ?></a>
                </li>
                <li><?php echo $title; ?></li>
            </ul>
            <!-- /BREADCRUMBS -->
            <div class="row">

                <div class="col-md-6">
                    <div class="clearfix">
                        <h3 class="content-title pull-left"><?php echo $title; ?></h3>
                    </div>
                    <div class="description"><?php echo $title; ?></div>
                </div>

                <div class="col-md-6">
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR . "vendors/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR . "vendors/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row">
    <!-- MESSENGER -->
    <div class="col-md-12">
        <div class="box border blue" id="messenger">
            <div class="box-title">
                <h4><i class="fa fa-bell"></i> <?php echo $title; ?></h4>
                <!--<div class="tools">
            
				<a href="#box-config" data-toggle="modal" class="config">
					<i class="fa fa-cog"></i>
				</a>
				<a href="javascript:;" class="reload">
					<i class="fa fa-refresh"></i>
				</a>
				<a href="javascript:;" class="collapse">
					<i class="fa fa-chevron-up"></i>
				</a>
				<a href="javascript:;" class="remove">
					<i class="fa fa-times"></i>
				</a>
				

			</div>-->
            </div>
            <div class="box-body">

                <div class="table-responsive">

                    <table class="table">
                        <thead>

                        </thead>
                        <tbody>
                            <?php foreach ($vendors as $vendor) : ?>


                                <tr>
                                    <th><?php echo $this->lang->line('Vendor_Type'); ?></th>
                                    <td>
                                        <?php echo $vendor->Vendor_Type; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('TaxPayer_NTN'); ?></th>
                                    <td>
                                        <?php echo $vendor->TaxPayer_NTN; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('TaxPayer_CNIC'); ?></th>
                                    <td>
                                        <?php echo $vendor->TaxPayer_CNIC; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('TaxPayer_Name'); ?></th>
                                    <td>
                                        <?php echo $vendor->TaxPayer_Name; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('TaxPayer_City'); ?></th>
                                    <td>
                                        <?php echo $vendor->TaxPayer_City; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('TaxPayer_Address'); ?></th>
                                    <td>
                                        <?php echo $vendor->TaxPayer_Address; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('TaxPayer_Status'); ?></th>
                                    <td>
                                        <?php echo $vendor->TaxPayer_Status; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('TaxPayer_Business_Name'); ?></th>
                                    <td>
                                        <?php echo $vendor->TaxPayer_Business_Name; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('Focal_Person'); ?></th>
                                    <td>
                                        <?php echo $vendor->Focal_Person; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('Contact_No'); ?></th>
                                    <td>
                                        <?php echo $vendor->Contact_No; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('industery'); ?></th>
                                    <td>
                                        <?php echo $vendor->industery; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('business_category'); ?></th>
                                    <td>
                                        <?php echo $vendor->business_category; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('nature_of_business'); ?></th>
                                    <td>
                                        <?php echo $vendor->nature_of_business; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('registration_no'); ?></th>
                                    <td>
                                        <?php echo $vendor->registration_no; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('registration_date'); ?></th>
                                    <td>
                                        <?php echo $vendor->registration_date; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('year_of_active'); ?></th>
                                    <td>
                                        <?php echo $vendor->year_of_active; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('fee'); ?></th>
                                    <td>
                                        <?php echo $vendor->fee; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('Status'); ?></th>
                                    <td>
                                        <?php


                                        if ($vendor->status == 0) {
                                            echo "<strong style='color:red'>Dormant</strong>";
                                        }
                                        if ($vendor->status == 1) {
                                            echo "<strong style='color:green'>Active</strong>";
                                        }
                                        // 
                                        ?>
                                        <br />
                                        <br />

                                        <?php

                                        //set uri segment
                                        if (!$this->uri->segment(4)) {
                                            $page = 0;
                                        } else {
                                            $page = $this->uri->segment(4);
                                        }

                                        if ($vendor->status == 0) {
                                            echo "<a class='btn btn-success' href='" . site_url(ADMIN_DIR . "vendors/publish/" . $vendor->vendor_id . "/" . $page) . "'>Mark as Active</a>";
                                        } elseif ($vendor->status == 1) {
                                            echo "<a class='btn btn-danger' href='" . site_url(ADMIN_DIR . "vendors/draft/" . $vendor->vendor_id . "/" . $page) . "'>Mark as Dormant</a>";
                                        }
                                        ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>




                </div>


            </div>

        </div>
    </div>
    <!-- /MESSENGER -->
</div>
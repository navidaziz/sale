<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <!-- STYLER -->

            <!-- /STYLER -->
            <!-- BREADCRUMBS -->

            <!-- /BREADCRUMBS -->
            <div class="row">

                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a
                                href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
                        </li>
                        <li>
                            <i class="fa fa-home"></i>
                            <a
                                href="<?php echo site_url('reports/index'); ?>">Reports Dashbaord</a>
                        </li>
                        <li><?php echo $title; ?></li>
                    </ul>
                    <div class="clearfix">
                        <h4 class="content-title pull-left" style="font-size: 20px;"><?php echo $title; ?></h3>
                    </div>
                    <div class="description"><?php echo $description; ?></div>
                </div>

                <div class="col-md-9">

                </div>

            </div>


        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box border blue" id="messenger">
            <div class="box-title">
                <h4><?php echo $title; ?></h4>
            </div>
            <div class="box-body">
                <?php
                $business_id = $this->session->userdata("business_id");
                $query = "SELECT `item_id`, `item_name`, 
                 SUM(`quantity`) AS `most_sale`
                FROM `sales_items`
                WHERE `business_id` = ?
                GROUP BY `item_id`, `item_name`
                ORDER BY `most_sale` DESC";
                $rows = $this->db->query($query, [$business_id])->result();
                ?>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>#</th>
                        <th>ITEMS NAME</th>
                        <th>SALE</th>
                    </tr>
                    <?php
                    $count = 1;
                    foreach ($rows as $row) { ?>
                        <tr>
                            <th><?php echo $count++; ?></th>
                            <th><?php echo $row->item_name; ?></th>
                            <th><?php echo $row->most_sale; ?></th>
                        </tr>
                    <?php } ?>
                </table>

            </div>


        </div>

    </div>





</div>
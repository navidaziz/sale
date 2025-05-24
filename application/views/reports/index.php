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
                <h4>Financial Reports</h4>

            </div>
            <div class="box-body">
                <h4>Sale Report</h4>
                <ol>
                    <li>
                        <a href="<?php echo site_url('reports/most_sale_items') ?>">Most Sale Items</a>
                    </li>

                </ol>
            </div>


        </div>

    </div>





</div>
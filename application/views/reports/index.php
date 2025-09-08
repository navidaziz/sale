<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header">
                <ul class="breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>">
                            <?php echo $this->lang->line('Home'); ?>
                        </a>
                    </li>
                    <li><?php echo $title; ?></li>
                </ul>

                <h4 class="content-title" style="font-size: 20px;"><?php echo $title; ?></h4>
                <p class="description"><?php echo $description; ?></p>
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
                    <ol class="list-unstyled">
                        <li><a href="<?php echo site_url('reports/most_sale_items'); ?>">Most Sale Items</a></li>
                        <li>
                            <a class="text-primary" target="_blank" href="<?php echo site_url("reports/today_items_sale_report"); ?>">
                                Print Today Sale Report
                            </a>
                        </li>
                        <li>
                            <a class="text-primary" target="_blank" href="<?php echo site_url("reports/print_stock_report"); ?>">
                                Print Stock Report
                            </a>
                        </li>
                        <li>
                            <a class="text-primary" target="_blank" href="<?php echo site_url("reports/low_stock_items"); ?>">
                                Low Stock Report
                            </a>
                        </li>
                        <li>
                            <a class="text-primary" target="_blank" href="<?php echo site_url("reports/year_month_wise_sale_report"); ?>">
                                Year and Monthly Report
                            </a>
                        </li>
                        <li>
                            <form target="_blank" method="get" action="items_sale_report" class="form-inline">
                                <div class="form-group">
                                    <label>Start Date:</label>
                                    <input type="date" name="start_date" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label>End Date:</label>
                                    <input type="date" name="end_date" class="form-control" required value="<?php echo date('Y-m-d'); ?>" />
                                </div>
                                <div class="form-group">
                                    <label>Item Sale Report</label><br />
                                    <button type="submit" class="btn btn-primary">Item Sale Report</button>
                                </div>
                            </form>
                        </li>
                        <li>
                            <form target="_blank" method="get" action="day_wise_sale_report" class="form-inline">
                                <div class="form-group">
                                    <label>Start Date:</label>
                                    <input type="date" name="start_date" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label>End Date:</label>
                                    <input type="date" name="end_date" class="form-control" required value="<?php echo date('Y-m-d'); ?>" />
                                </div>
                                <div class="form-group">
                                    <label>Day Wise Report</label><br />
                                    <button type="submit" class="btn btn-success">Day Wise Report</button>
                                </div>
                            </form>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
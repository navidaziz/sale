<div class="row">
    <!-- Sale Card -->



    <div class="col-md-12">
        <div class="box border primary">
            <div class="box-title">
                <h4><i class="fa fa-money"></i> Today Sales Summary</h4>
            </div>
            <div class="box-body">

                <!-- Sale and Profit Panels -->
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="panel panel-primary text-center" style="border-radius: 6px;">
                            <div class="panel-heading" style="font-size: 18px; font-weight: bold;">
                                <i class="fa fa-shopping-cart"></i> Current Month Sale
                            </div>
                            <div class="panel-body">
                                <h2 style="color: green; font-weight: bold; margin: 0;">
                                    <?php echo number_format($today_sale_profit->total_sale, 2); ?> PKR
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="panel panel-success text-center" style="border-radius: 6px;">
                            <div class="panel-heading" style="font-size: 18px; font-weight: bold;">
                                <i class="fa fa-line-chart"></i> Current Month Net Profit (After Tax & Discount)
                            </div>
                            <div class="panel-body">
                                <h2 style="color: #337ab7; font-weight: bold; margin: 0;">
                                    <?php echo number_format($today_sale_profit->total_profit, 2); ?> PKR
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Breakdown Summary -->
                <div class="table-responsive" style="margin-top: 15px;">
                    <table class="table table-bordered table-striped table-hover" style="font-size: 13px;">
                        <thead>
                            <tr class="active text-center">
                                <th>Component</th>
                                <th>Amount (PKR)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="fa fa-cube text-info"></i> Items Sale Amount</td>
                                <td class="text-right">Rs: <?php echo number_format($today_sale_summary->items_price, 2); ?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-percent text-warning"></i> Taxes Applied</td>
                                <td class="text-right">Rs: <?php echo number_format($today_sale_summary->total_tax, 2); ?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-tag text-danger"></i> Discounts Given</td>
                                <td class="text-right">Rs: <?php echo number_format($today_sale_summary->discount, 2); ?></td>
                            </tr>
                            <tr class="success">
                                <td><strong><i class="fa fa-calculator"></i> Total Sale <!--(Including Tax - Discount)--> </strong></td>
                                <td class="text-right"><strong>Rs: <?php echo number_format($today_sale_summary->total_sale, 2); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


    <div class="col-md-12">
        <div class="box border primary">
            <div class="box-title">
                <h4><i class="fa fa-money"></i> Current Month Sales Summary</h4>
            </div>
            <div class="box-body">

                <!-- Sale and Profit Panels -->
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="panel panel-primary text-center" style="border-radius: 6px;">
                            <div class="panel-heading" style="font-size: 18px; font-weight: bold;">
                                <i class="fa fa-shopping-cart"></i> Today's Sale
                            </div>
                            <div class="panel-body">
                                <h2 style="color: green; font-weight: bold; margin: 0;">
                                    <?php echo number_format($today_sale_profit->total_sale, 2); ?> PKR
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="panel panel-success text-center" style="border-radius: 6px;">
                            <div class="panel-heading" style="font-size: 18px; font-weight: bold;">
                                <i class="fa fa-line-chart"></i> Net Profit (After Tax & Discount)
                            </div>
                            <div class="panel-body">
                                <h2 style="color: #337ab7; font-weight: bold; margin: 0;">
                                    <?php echo number_format($today_sale_profit->total_profit, 2); ?> PKR
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Breakdown Summary -->
                <div class="table-responsive" style="margin-top: 15px;">
                    <table class="table table-bordered table-striped table-hover" style="font-size: 13px;">
                        <thead>
                            <tr class="active text-center">
                                <th>Component</th>
                                <th>Amount (PKR)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="fa fa-cube text-info"></i> Items Sale Amount</td>
                                <td class="text-right">Rs: <?php echo number_format($current_month_sale_summary->items_price, 2); ?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-percent text-warning"></i> Taxes Applied</td>
                                <td class="text-right">Rs: <?php echo number_format($current_month_sale_summary->total_tax, 2); ?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-tag text-danger"></i> Discounts Given</td>
                                <td class="text-right">Rs: <?php echo number_format($current_month_sale_summary->discount, 2); ?></td>
                            </tr>
                            <tr class="success">
                                <td><strong><i class="fa fa-calculator"></i> Total Sale <!--(Including Tax - Discount)--> </strong></td>
                                <td class="text-right"><strong>Rs: <?php echo number_format($current_month_sale_summary->total_sale, 2); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


    <div class="col-sm-6 font-900">
        <h4>Reports</h4>
        <ol>
            <li class="text-primary"> <a class="text-primary" target="_new" href="<?php echo  site_url("sale_point/today_items_sale_report"); ?>">
                    Print Today Sale Report</a></li>
            <li class="text-primary"> <a class="text-primary" target="_new" href="<?php echo  site_url("sale_point/print_stock_report"); ?>">
                    Print Stock Report</a></li>
            <li>
                <form target="_blank" method="get" action="items_sale_report">
                    <table>
                        <tr>
                            <th colspan="3">
                                Items Wise Sale Report
                            </th>
                        </tr>
                        <tr>
                            <th> Start Date: </th>
                            <td> <input type="date" value="" name="start_date" /> </td>
                            <th> End Date </th>
                            <td><input required placeholder="dd-mm-yyyy" type="date" value="<?php echo date("d/m/Y") ?>" name="end_date" /></td>
                            <th colspan="2">
                                <input required placeholder="dd-mm-yyyy" type="submit" value="Sale Report" name="Sale Report" />
                            </th>
                        </tr>
                    </table>
                </form>
            </li>

            <li>
                <form target="_blank" method="get" action="day_wise_sale_report">
                    <table>
                        <tr>
                            <th colspan="3">
                                Day Wise Sale Report
                            </th>
                        </tr>
                        <tr>
                            <th> Start Date: </th>
                            <td> <input type="date" value="" name="start_date" /> </td>
                            <th> End Date </th>
                            <td><input required placeholder="dd-mm-yyyy" type="date" value="<?php echo date("d/m/Y") ?>" name="end_date" /></td>
                            <th colspan="2">
                                <input required placeholder="dd-mm-yyyy" type="submit" value="Sale Report" name="Sale Report" />
                            </th>
                        </tr>
                    </table>
                </form>
            </li>

        </ol>
    </div>

</div>
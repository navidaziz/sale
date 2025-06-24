<div class="row">
    <!-- Sale Card -->



    <div class="col-md-12">
        <div class="box border primary">
            <div class="box-title">
                <h4><i class="fa fa-money"></i>Sale Summary</h4>
            </div>
            <div class="box-body">

                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Report Metric</th>
                            <th>Today</th>
                            <th>This Month</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Items Price</td>
                            <td><?php echo number_format($sale_summary->today_items_price, 2); ?></td>
                            <td><?php echo number_format($sale_summary->month_items_price, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Tax</td>
                            <td><?php echo number_format($sale_summary->today_tax, 2); ?></td>
                            <td><?php echo number_format($sale_summary->month_tax, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Discount</td>
                            <td><?php echo number_format($sale_summary->today_discount, 2); ?></td>
                            <td><?php echo number_format($sale_summary->month_discount, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Total Sale</td>
                            <td><?php echo number_format($sale_summary->today_total_sale, 2); ?></td>
                            <td><?php echo number_format($sale_summary->month_total_sale, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Total Profit</td>
                            <td><?php echo number_format($profit_summary->today_profit, 2); ?></td>
                            <td><?php echo number_format($profit_summary->month_profit, 2); ?></td>
                        </tr>
                    </tbody>
                </table>



            </div>
        </div>
    </div>




</div>
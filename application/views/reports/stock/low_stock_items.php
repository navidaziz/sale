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
                <li><?php echo $title; ?></li>
            </ul>
            <div class="row">

                <div class="col-md-3">
                    <div class="clearfix">
                        <h3 class="content-title pull-left"><?php echo $title; ?></h3>
                    </div>
                    <div class="description"><?php echo $title; ?></div>
                </div>

                <div class="col-md-9">

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

            </div>
            <div class="box-body">
                <div class="table-responsive">

                    <table id="item_table" class="table table-bordered" style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th>S/No</th>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th>Item Code</th>
                                <th>Cost Price</th>
                                <th>Sale Price (Unit)</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $grand_total_cost = 0;
                            $grand_total_sale = 0;
                            $grand_expected_profit = 0;

                            foreach ($items as $item) :
                                $stock_total = $item->cost_price * $item->total_quantity;
                                $sale_total = $item->sale_price * $item->total_quantity;
                                $expected_profit = $sale_total - $stock_total;

                                $grand_total_cost += $stock_total;
                                $grand_total_sale += $sale_total;
                                $grand_expected_profit += $expected_profit;
                            ?>
                                <tr>
                                    <td><?= $count++; ?></td>
                                    <td><?= $item->name; ?></td>
                                    <td><?= $item->category; ?></td>
                                    <td><?= $item->unit; ?></td>
                                    <td><?= $item->item_code_no; ?></td>
                                    <td><?= $item->cost_price; ?></td>

                                    <td><?= $item->sale_price; ?></td>
                                    <td><?= $item->total_quantity; ?></td>
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

<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" .  "other_files/jq uery.dataTables.css") ?>">

<script type="text/javascript" charset="utf8" src="<?php echo site_url("assets/" .  "other_files/jquery.dataTables.js") ?>"></script>
<!-- <script type="text/javascript" language="javascript" src="<?php echo site_url("assets/" .  "other_files/dataTables.buttons.min.js") ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo site_url("assets/" .  "other_files/jszip.min.js") ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo site_url("assets/" .  "other_files/pdfmake.min.js") ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo site_url("assets/" .  "other_files/vfs_fonts.js") ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo site_url("assets/" .  "other_files/buttons.html5.min.js") ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo site_url("assets/" .  "other_files/buttons.print.min.js") ?>"></script> -->
<style>
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #aaa;
        border-radius: 3px;
        padding: 5px;
        background-color: #fffdfd00;
        margin-left: 3px;
        background: white;
        margin-top: -10px;
    }
</style>
<script>
    $(document).ready(function() {
        $('#item_table').DataTable({
            paging: false,
            lengthChange: false,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                title: 'Item Report',
                exportOptions: {
                    columns: ':not(:last-child):not(:nth-last-child(2))' // exclude last 2 columns (Action, Inventory)
                }
            }]
        });
    });
</script>
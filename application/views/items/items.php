<!-- Modal -->

<script>
    function get_item_detail(item_id) {
        $('#inventory_model_body').html('<p style="text-align:center"><strong>Please Wait...... Loading</strong></p>');
        $.ajax({
            type: "POST",
            url: "<?php echo site_url("items/get_item_detail") ?>",
            data: {
                item_id: item_id
            }
        }).done(function(data) {
            $('#inventory_model_body').html(data);
        });


    }

    function update_item_unit_price(item_id) {
        unit_price = $('#unit_price_' + item_id).val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url("items/update_unit_price") ?>",
            data: {
                item_id: item_id,
                unit_price: unit_price
            }
        }).done(function(data) {
            //alert(data);
            $('#unitPrice_' + item_id).html(data);
        });

    }



    function update_item_cost_price(item_id) {
        cost_price = $('#cost_price_' + item_id).val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url("items/update_cost_price") ?>",
            data: {
                item_id: item_id,
                cost_price: cost_price
            }
        }).done(function(data) {
            //alert(data);
            $('#costPrice_' + item_id).html(data);
        });

    }
</script>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="inventory_model" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="display: inline;">Item Inventory</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="inventory_model_body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
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


            <?php if (!preg_match('/mobile/i', $_SERVER['HTTP_USER_AGENT'])) { ?>
                <!-- /BREADCRUMBS -->
                <div class="row">

                    <div class="col-md-3">
                        <div class="clearfix">
                            <h3 class="content-title pull-left"><?php echo $title; ?></h3>
                        </div>
                        <div class="description"><?php echo $title; ?></div>
                    </div>

                    <div class="col-md-9">
                        <div class="pull-right">
                            <div style="text-align: center;">
                                <button onclick="get_item_form('0')" class="btn btn-primary">Add New Item</button>
                            </div>
                            <script>
                                function get_item_form(item_id) {
                                    $.ajax({
                                            method: "POST",
                                            url: "<?php echo site_url('items/get_item_form'); ?>",
                                            data: {
                                                item_id: item_id
                                            },
                                        })
                                        .done(function(respose) {
                                            $('#modal').modal('show');
                                            $('#modal_title').html('Items');
                                            $('#modal_body').html(respose);
                                        });
                                }
                            </script>
                            <a class="btn btn-danger btn-sm" href="<?php echo site_url("items/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
                        </div>
                    </div>

                </div>
            <?php } else { ?>
                <div style="text-align: center;">
                    <div style="text-align: center;">
                        <button onclick="get_item_form('0')" class="btn btn-primary">Add New Item</button>
                    </div>
                    <script>
                        function get_item_form(item_id) {
                            $.ajax({
                                    method: "POST",
                                    url: "<?php echo site_url('items/get_item_form'); ?>",
                                    data: {
                                        item_id: item_id
                                    },
                                })
                                .done(function(respose) {
                                    $('#modal').modal('show');
                                    $('#modal_title').html('Items');
                                    $('#modal_body').html(respose);
                                });
                        }
                    </script>
                    <a class="btn btn-danger btn-sm" href="<?php echo site_url("items/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
                </div>
            <?php } ?>


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
                <?php if (preg_match('/mobile/i', $_SERVER['HTTP_USER_AGENT'])) { ?>

                    <div class="table-responsive">

                        <table id="item_table" class="table table-bordered table_small" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th>Items Detail</th>
                                    <th>In Stock</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($items as $item) : ?>
                                    <tr>
                                        <td>
                                            S/No: <?php echo $count++; ?>
                                            <?php echo $item->name; ?><br />
                                            <small><?php echo $item->category; ?></small><br />
                                            <small><strong><?php echo $item->item_code_no; ?></strong></small>
                                            <table class="table table-bordered table-condensed text-center table_small" style="font-size: 13px; margin-bottom: 10px;">
                                                <thead>
                                                    <tr>
                                                        <th>Cost Price</th>
                                                        <th>Unit Price</th>
                                                        <th>Profit %</th>
                                                        <th>Discount</th>
                                                        <th>Sale Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo $item->cost_price; ?></td>
                                                        <td><?php echo $item->unit_price; ?></td>
                                                        <td>
                                                            <?php
                                                            if ($item->cost_price > 0) {
                                                                echo @round((($item->unit_price - $item->cost_price) * 100 / $item->cost_price), 1);
                                                            } else {
                                                                echo "N/A";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $item->discount; ?></td>
                                                        <td><?php echo $item->sale_price; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>


                                            Status: <?php echo status($item->status,  $this->lang); ?>
                                            <?php

                                            //set uri segment
                                            if (!$this->uri->segment(4)) {
                                                $page = 0;
                                            } else {
                                                $page = $this->uri->segment(4);
                                            }

                                            if ($item->status == 0) {
                                                echo "<a href='" . site_url("items/publish/" . $item->item_id . "/" . $page) . "'> &nbsp;" . $this->lang->line('Publish') . "</a>";
                                            } elseif ($item->status == 1) {
                                                echo "<a href='" . site_url("items/draft/" . $item->item_id . "/" . $page) . "'> &nbsp;" . $this->lang->line('Draft') . "</a>";
                                            }
                                            ?>

                                            <div class="actions" style="margin-top: 5px;">
                                                <?php
                                                $page = $this->uri->segment(4) ?: 0;
                                                if ($item->status == 0) {
                                                    echo "<a href='" . site_url("items/publish/" . $item->item_id . "/" . $page) . "' class='btn btn-xs btn-success'>" . $this->lang->line('Publish') . "</a> ";
                                                } elseif ($item->status == 1) {
                                                    echo "<a href='" . site_url("items/draft/" . $item->item_id . "/" . $page) . "' class='btn btn-xs btn-warning'>" . $this->lang->line('Draft') . "</a> ";
                                                }
                                                ?>
                                                <a class="btn btn-xs btn-info" href="<?php echo site_url("items/view_item/" . $item->item_id . "/" . $page); ?>"><i class="fa fa-eye"></i></a>
                                                <button class="btn btn-success btn-xs" onclick="get_item_form('<?php echo $item->item_id ?>')">Edit</button>

                                                <a class="btn btn-xs btn-danger" href="<?php echo site_url("items/trash/" . $item->item_id . "/" . $page); ?>"><i class="fa fa-trash-o"></i></a>
                                                <a class="btn btn-xs btn-default" onclick="get_item_detail('<?php echo $item->item_id; ?>')" href="#" data-toggle="modal" data-target="#exampleModal">Inventory</a>
                                            </div>
                                        </td>
                                        <td><?php echo $item->total_quantity ?> - <?php echo $item->unit; ?></td>
                                        <!-- <td title="<?php echo $item->expiry_date; ?>"> <?php
                                                                                            if ($item->total_quantity > 0) {
                                                                                                $current_date = new DateTime('today');  //current date or any date
                                                                                                $expiry_date = new DateTime($item->expiry_date);   //Future date
                                                                                                $diff = $expiry_date->diff($current_date)->format("%a");  //find difference
                                                                                                $days = intval($diff);   //rounding days
                                                                                                echo $days . " - days";
                                                                                                // 
                                                                                            } ?> </td> -->

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>




                    </div>

                <?php } else { ?>


                    <div class="box-body">
                        <div class="row">
                            <!-- Vertical Tabs -->
                            <div class="col-md-3">
                                <ul class="nav nav-pills nav-stacked">
                                    <?php
                                    $business_id = $this->session->userdata('business_id');
                                    $query = "SELECT category, COUNT(*) as total FROM `items` 
                                        WHERE status=1 
                                        AND business_id = $business_id GROUP BY category ORDER BY TRIM(category) ASC;";
                                    $categories = $this->db->query($query)->result();
                                    $item_category = $this->input->get('category');
                                    foreach ($categories as $category) {
                                    ?>
                                        <li class="list-group-item" <?php if ($item_category == $category->category) {
                                                                        echo ' class="active" ';
                                                                    } ?>>
                                            <a href="<?php echo site_url(ADMIN_DIR . "items/view") ?>?category=<?php echo $category->category; ?>"
                                                style="cursor: pointer; padding: 0px;">
                                                <?php echo $category->category; ?> (<?php echo $category->total; ?>)
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>

                            <!-- Tab Content -->
                            <div class="col-md-9">
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="box_tab3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">

                                                    <table id="item_table" class="table table-bordered table_small" style="font-size: 12px;">
                                                        <thead>
                                                            <tr>
                                                                <th>S/No</th>
                                                                <th>Item Name</th>
                                                                <th>Category</th>
                                                                <th>Unit</th>
                                                                <th>Bar Code</th>
                                                                <th>Cost Price</th>
                                                                <th>Unit Price</th>
                                                                <th>Profit</th>
                                                                <th>Profit %</th>
                                                                <th>Discount</th>
                                                                <th>Sale Price (Unit)</th>
                                                                <th>In Stock</th>
                                                                <th>Total Cost</th>
                                                                <th>Total Sale</th>
                                                                <th>Expected Profit</th>
                                                                <th>Item Saled</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                                <th>Inventory</th>
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
                                                                    <td><span id="costPrice_<?= $item->item_id; ?>"><?= $item->cost_price; ?></span></td>
                                                                    <td><span id="unitPrice_<?= $item->item_id; ?>"><?= $item->unit_price; ?></span></td>
                                                                    <td>
                                                                        <?php
                                                                        if ($item->cost_price > 0) {
                                                                            echo ($item->unit_price - $item->cost_price);
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if ($item->cost_price > 0) {
                                                                            echo round((($item->unit_price - $item->cost_price) * 100 / $item->cost_price), 1) . "%";
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td><?= $item->discount; ?></td>
                                                                    <td><?= $item->sale_price; ?></td>
                                                                    <td><?= $item->total_quantity; ?></td>
                                                                    <td><?= $stock_total; ?></td>
                                                                    <td><?= $sale_total; ?></td>
                                                                    <td><?= $expected_profit; ?></td>
                                                                    <td><?php echo $item->item_saled; ?></td>
                                                                    <td>
                                                                        <?= status($item->status, $this->lang); ?>
                                                                        <?php
                                                                        $page = $this->uri->segment(4) ?: 0;
                                                                        if ($item->status == 0) {
                                                                            echo "<a href='" . site_url("items/publish/{$item->item_id}/{$page}") . "'> &nbsp;" . $this->lang->line('Publish') . "</a>";
                                                                        } elseif ($item->status == 1) {
                                                                            echo "<a href='" . site_url("items/draft/{$item->item_id}/{$page}") . "'> &nbsp;" . $this->lang->line('Draft') . "</a>";
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-success btn-xs" onclick="get_item_form('<?= $item->item_id ?>')">Edit</button>
                                                                        <a class="llink llink-trash" href="<?= site_url("items/trash/{$item->item_id}/" . $this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a>
                                                                    </td>
                                                                    <td>
                                                                        <a onclick="get_item_detail('<?= $item->item_id; ?>')" href="#" data-toggle="modal" data-target="#exampleModal">
                                                                            Inventory
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="13" style="text-align:right">Grand Totals:</th>
                                                                <th><?= number_format($grand_total_cost, 2); ?></th>
                                                                <th><?= number_format($grand_total_sale, 2); ?></th>
                                                                <th><?= number_format($grand_expected_profit, 2); ?></th>
                                                                <th colspan="3"></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>




                                                </div>
                                            </div>
                                        </div>
                                        <hr class="margin-bottom-0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                <?php } ?>

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
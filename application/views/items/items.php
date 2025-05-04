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
            <?php if (preg_match('/mobile/i', $_SERVER['HTTP_USER_AGENT'])) { ?>
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
                            <a class="btn btn-primary btn-sm" href="<?php echo site_url("items/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                            <a class="btn btn-danger btn-sm" href="<?php echo site_url("items/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
                        </div>
                    </div>

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
                    <div style="text-align: center;">
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url("items/add"); ?>"><i class="fa fa-plus"></i> Add New Item</a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url("items/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
                    </div>
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
                                                <a class="btn btn-xs btn-primary" href="<?php echo site_url("items/edit/" . $item->item_id . "/" . $page); ?>"><i class="fa fa-pencil-square-o"></i></a>
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
                    <div class="table-responsive">

                        <table id="item_table" class="table table-bordered" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th>S/No</th>
                                    <th><?php echo $this->lang->line('name'); ?></th>
                                    <th><?php echo $this->lang->line('category'); ?></th>
                                    <!-- <th><?php echo $this->lang->line('unit'); ?></th>-->
                                    <th>Bar Code</th>
                                    <!-- <th><?php echo $this->lang->line('description'); ?></th> -->
                                    <th><?php echo $this->lang->line('cost_price'); ?></th>
                                    <th><?php echo $this->lang->line('unit_price'); ?></th>
                                    <?php //if ($this->session->userdata("role_id") == 1) { 
                                    ?>
                                    <th>Profit %</th>
                                    <th>Discount</th>
                                    <th>Sale Price</th>
                                    <th>In Stock</th>
                                    <!-- <th>Expire After</th> -->
                                    <!-- <th><?php echo $this->lang->line('reorder_level'); ?></th> -->
                                    <!-- <th><?php echo $this->lang->line('location'); ?></th> -->
                                    <th><?php echo $this->lang->line('Status'); ?></th>
                                    <th><?php echo $this->lang->line('Action'); ?></th>
                                    <th>Inventory</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($items as $item) : ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td> <?php echo $item->name; ?> </td>
                                        <td> <?php echo $item->category; ?> </td>
                                        <!-- <td> <?php echo $item->unit; ?> </td> -->
                                        <td> <?php echo $item->item_code_no; ?> </td>
                                        <!-- <td> <?php echo $item->description; ?> </td> -->
                                        <td> <span id="costPrice_<?php echo $item->item_id; ?>"><?php echo $item->cost_price; ?></span>
                                            <!-- <br />
                                        <input style="width: 60px;" value="<?php echo $item->cost_price; ?>" name="cost_price" id="cost_price_<?php echo $item->item_id; ?>" onkeyup="update_item_cost_price('<?php echo $item->item_id; ?>')" />
                                    </td> -->
                                        <td> <span id="unitPrice_<?php echo $item->item_id; ?>"><?php echo $item->unit_price; ?></span>
                                            <!-- <br /><input style="width: 60px;" value="<?php echo $item->unit_price; ?>" name="unit_price" id="unit_price_<?php echo $item->item_id; ?>" onkeyup="update_item_unit_price('<?php echo $item->item_id; ?>')" /> -->

                                            </span>
                                        </td>
                                        <?php //if ($this->session->userdata("role_id") == 1) { 
                                        ?>
                                        <td> <?php
                                                if ($item->cost_price > 0) {
                                                    echo @round((($item->unit_price - $item->cost_price) * 100 / $item->cost_price), 1);
                                                }
                                                ?> </td>
                                        <?php //} 
                                        ?>
                                        <td> <?php echo $item->discount; ?> </td>
                                        <td> <?php echo $item->sale_price; ?> </td>
                                        <td><?php echo $item->total_quantity ?></td>
                                        <!-- <td title="<?php echo $item->expiry_date; ?>"> <?php
                                                                                            if ($item->total_quantity > 0) {
                                                                                                $current_date = new DateTime('today');  //current date or any date
                                                                                                $expiry_date = new DateTime($item->expiry_date);   //Future date
                                                                                                $diff = $expiry_date->diff($current_date)->format("%a");  //find difference
                                                                                                $days = intval($diff);   //rounding days
                                                                                                echo $days . " - days";
                                                                                                // 
                                                                                            } ?> </td> -->
                                        <!-- <td> <?php echo $item->reorder_level; ?> </td> -->
                                        <!-- <td> <?php echo $item->location; ?> </td> -->
                                        <td> <?php echo status($item->status,  $this->lang); ?>
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
                                            ?> </td>
                                        <td> <a class="llink llink-view" href="<?php echo site_url("items/view_item/" . $item->item_id . "/" . $this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a>
                                            <a class="llink llink-edit" href="<?php echo site_url("items/edit/" . $item->item_id . "/" . $this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a>
                                            <a class="llink llink-trash" href="<?php echo site_url("items/trash/" . $item->item_id . "/" . $this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                        <td><a onclick="get_item_detail('<?php echo $item->item_id; ?>')" href="#" data-toggle="modal" data-target="#exampleModal">
                                                Inventory
                                            </a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>




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
            "paging": false,
            "lengthChange": false,
        });
    });
</script>
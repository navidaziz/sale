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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url("items/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url("items/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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

            </div>
            <div class="box-body">

                <div class="table-responsive">

                    <table id="item_t able" class="table table-bordered" style="font-size: 11px;">
                        <thead>
                            <tr>

                                <th><?php echo $this->lang->line('name'); ?></th>
                                <th><?php echo $this->lang->line('category'); ?></th>
                                <th><?php echo $this->lang->line('unit'); ?></th>
                                <th><?php echo $this->lang->line('item_code_no'); ?></th>
                                <!-- <th><?php echo $this->lang->line('description'); ?></th> -->
                                <th><?php echo $this->lang->line('cost_price'); ?></th>
                                <th><?php echo $this->lang->line('unit_price'); ?></th>
                                <th>Discount</th>
                                <th>Sale Price</th>
                                <th>In Stock</th>

                                <th><?php echo $this->lang->line('reorder_level'); ?></th>
                                <!-- <th><?php echo $this->lang->line('location'); ?></th> -->
                                <th><?php echo $this->lang->line('Status'); ?></th>
                                <th><?php echo $this->lang->line('Action'); ?></th>
                                <th>Inventory</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item) : ?>

                                <tr>


                                    <td>
                                        <?php echo $item->name; ?>
                                    </td>
                                    <td>
                                        <?php echo $item->category; ?>
                                    </td>
                                    <td>
                                        <?php echo $item->unit; ?>
                                    </td>
                                    <td>
                                        <?php echo $item->item_code_no; ?>
                                    </td>
                                    <!-- <td>
                                        <?php echo $item->description; ?>
                                    </td> -->
                                    <td>
                                        <?php echo $item->cost_price; ?>
                                    </td>
                                    <td>
                                        <?php echo $item->unit_price; ?>
                                    </td>
                                    <td>
                                        <?php echo $item->discount; ?>
                                    </td>
                                    <td>
                                        <?php echo $item->sale_price; ?>
                                    </td>
                                    <td><?php echo $item->total_quantity ?></td>

                                    <td>
                                        <?php echo $item->reorder_level; ?>
                                    </td>
                                    <!-- <td>
                                        <?php echo $item->location; ?>
                                    </td> -->
                                    <td>
                                        <?php echo status($item->status,  $this->lang); ?>
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
                                    </td>
                                    <td>
                                        <a class="llink llink-view" href="<?php echo site_url("items/view_item/" . $item->item_id . "/" . $this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a>
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


            </div>

        </div>
    </div>
    <!-- /MESSENGER -->
</div>

<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" .  "other_files/jquery.dataTables.css") ?>">

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
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
                <li><?php echo $title; ?></li>
            </ul>
            <!-- /BREADCRUMBS -->
            <?php if (!preg_match('/mobile/i', $_SERVER['HTTP_USER_AGENT'])) { ?>
                <div class="row">

                    <div class="col-md-6">
                        <div class="clearfix">
                            <h3 class="content-title pull-left"><?php echo $title; ?></h3>
                        </div>
                        <div class="description"><?php echo $title; ?></div>
                    </div>

                    <div class="col-md-6">
                        <!-- <div class="pull-right">
                            <a class="btn btn-primary btn-sm" href="<?php echo site_url("suppliers/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                            <a class="btn btn-danger btn-sm" href="<?php echo site_url("suppliers/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
                        </div> -->
                        <?php
                        $query = "SELECT SUM(item_cost_price*inventory_transaction) as `amount` 
						FROM `inventory`
						WHERE `business_id` = ?";
                        $purchased = $this->db->query($query, [$this->session->userdata("business_id")])->row();
                        $query = "SELECT SUM(amount) as `amount` 
						FROM `supplier_payments`
						WHERE `business_id` = ?";
                        $paid = $this->db->query($query, [$this->session->userdata("business_id")])->row();
                        $query = "SELECT sum(liabilities) as total FROM `suppliers` WHERE business_id=?";
                        $liabilities = $this->db->query($query, [$this->session->userdata("business_id")])->row();


                        ?>
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Liabilities</th>
                                <th>Purchased Amount</th>
                                <th>Amount Paid</th>
                                <th>Remaining</th>
                            </tr>
                            <tr>
                                <td><?php echo number_format($liabilities->total, 2); ?></td>
                                <td><?php echo number_format($purchased->amount, 2); ?></td>
                                <td><?php echo number_format($paid->amount, 2); ?></td>
                                <td><?php echo number_format((($liabilities->total + $purchased->amount) - $paid->amount), 2); ?></td>

                        </table>

                    </div>

                </div>
            <?php } else { ?>
                <div style="text-align: center;">
                    <a class="btn btn-primary btn-sm" href="<?php echo site_url("suppliers/add"); ?>"><i class="fa fa-plus"></i> Add New Suppliers</a>
                    <a class="btn btn-danger btn-sm" href="<?php echo site_url("suppliers/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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

                <div class="table-responsive">
                    <?php if (preg_match('/mobile/i', $_SERVER['HTTP_USER_AGENT'])) { ?>

                        <div class="table-responsive">
                            <table class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <th>Supplier Details</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($suppliers as $index => $supplier): ?>
                                        <tr>
                                            <td>
                                                <strong>#<?php echo $index + 1; ?> - <?php echo $supplier->supplier_name; ?></strong> <br />
                                                <small>📞 <?php echo $supplier->supplier_contact_no; ?></small> <br />
                                                <small>🏢 <?php echo $supplier->company_name; ?></small> <br />
                                                <small>💳 <?php echo $supplier->account_number; ?></small>
                                                <br />
                                                <?php if ($supplier->supplier_name != 'Opening Stock') { ?>
                                                    <a class="btn btn-xs btn-danger" href="<?php echo site_url("suppliers/trash/" . $supplier->supplier_id . "/" . $page); ?>"><i class="fa fa-trash-o"></i></a>
                                                    <span style="margin-left: 5px;"></span>
                                                <?php } ?>

                                                <a class="btn btn-primary btn-xs" href="<?php echo site_url("suppliers/print_supplier_invoices/" . $supplier->supplier_id); ?>" target="_new">
                                                    <span class="fa fa-print"></span> Print
                                                </a>

                                                <?php if ($supplier->supplier_name != 'Opening Stock') {
                                                    echo status($supplier->status, $this->lang);
                                                    $page = $this->uri->segment(4) ?: 0;
                                                    if ($supplier->status == 0) {
                                                        echo "<a class='btn btn-warning btn-xs' href='" . site_url("suppliers/publish/" . $supplier->supplier_id . "/" . $page) . "'>" . $this->lang->line('Publish') . "</a>";
                                                    } elseif ($supplier->status == 1) {
                                                        echo "<a class='btn btn-danger btn-xs' href='" . site_url("suppliers/draft/" . $supplier->supplier_id . "/" . $page) . "'>" . $this->lang->line('Draft') . "</a>";
                                                    }
                                                } ?>
                                                <a class="btn btn-xs btn-success" href="<?php echo site_url("suppliers/view_supplier/" . $supplier->supplier_id . "/" . $page); ?>"><i class="fa fa-eye"></i> View</a>
                                                <?php if ($supplier->supplier_name != 'Opening Stock') { ?>
                                                    <a class="btn btn-xs btn-primary" href="<?php echo site_url("suppliers/edit/" . $supplier->supplier_id . "/" . $page); ?>"><i class="fa fa-pencil-square-o"></i> Edit</a>
                                                <?php } ?>

                                            </td>
                                            <td>
                                                <?php
                                                $query = "SELECT ROUND(SUM(`inventory`.`item_cost_price` * `inventory`.`inventory_transaction`), 2) AS total 
                                  FROM `inventory` 
                                  WHERE `inventory`.`supplier_id` = '" . $supplier->supplier_id . "'";
                                                $total_amount = $this->db->query($query)->result()[0]->total;
                                                echo $total_amount;
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>


                    <?php } else { ?>

                        <div class="col-md-12">



                            <table class="table table-bordered table-striped" style="width: 100%;" id="sample-table-1">
                                <thead>
                                    <tr>
                                        <th>Supplier Name</th>
                                        <th>Contact No</th>
                                        <th>Company Name</th>
                                        <th>Account No.</th>
                                        <th>Liabilities</th>
                                        <th>Purchased Amount</th>
                                        <th>Amount Paid</th>
                                        <th>Remaining</th>
                                        <!-- <th>Status</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $total_liabilities = 0;
                                    $total_purchased = 0;
                                    $total_paid = 0;
                                    $total_remaining = 0;
                                    foreach ($suppliers as $supplier) :
                                        $query = "SELECT SUM(item_cost_price*inventory_transaction) as `amount` 
                                        FROM `inventory`
                                        WHERE `business_id` = ?
                                        AND `supplier_id` = ?";
                                        $purchased = $this->db->query($query, [$this->session->userdata("business_id"), $supplier->supplier_id])->row();
                                        $query = "SELECT SUM(amount) as `amount` 
                                        FROM `supplier_payments`
                                        WHERE `business_id` = ?
                                        AND `supplier_id` = ?";
                                        $paid = $this->db->query($query, [$this->session->userdata("business_id"), $supplier->supplier_id])->row();

                                        // Sum up
                                        $total_liabilities += $supplier->liabilities;
                                        $total_purchased += $purchased->amount;
                                        $total_paid += $paid->amount;
                                        $remaining = (($supplier->liabilities + $purchased->amount) - $paid->amount);
                                        $total_remaining += $remaining;
                                    ?>

                                        <tr>
                                            <td>
                                                <?php echo $supplier->supplier_name; ?>
                                            </td>
                                            <td>
                                                <?php echo $supplier->supplier_contact_no; ?>
                                            </td>
                                            <td>
                                                <?php echo $supplier->company_name; ?>
                                            </td>
                                            <td>
                                                <?php echo $supplier->account_number; ?>
                                            </td>

                                            <td><?php echo number_format($supplier->liabilities, 2); ?></td>
                                            <td><?php echo number_format($purchased->amount, 2); ?></td>
                                            <td><?php echo number_format($paid->amount, 2); ?></td>
                                            <td><?php echo number_format((($supplier->liabilities + $purchased->amount) - $paid->amount), 2); ?></td>


                                            <!-- <td>
                                                <?php if ($supplier->supplier_name != 'Opening Stock') {  ?>
                                                    <?php echo status($supplier->status,  $this->lang); ?>
                                                    <?php

                                                    //set uri segment
                                                    if (!$this->uri->segment(4)) {
                                                        $page = 0;
                                                    } else {
                                                        $page = $this->uri->segment(4);
                                                    }

                                                    if ($supplier->status == 0) {
                                                        echo "<a href='" . site_url("suppliers/publish/" . $supplier->supplier_id . "/" . $page) . "'> &nbsp;" . $this->lang->line('Publish') . "</a>";
                                                    } elseif ($supplier->status == 1) {
                                                        echo "<a href='" . site_url("suppliers/draft/" . $supplier->supplier_id . "/" . $page) . "'> &nbsp;" . $this->lang->line('Draft') . "</a>";
                                                    }
                                                    ?>
                                                <?php } ?>
                                            </td> -->

                                            <td>
                                                <a class="llink llink-view" href="<?php echo site_url("suppliers/view_supplier/" . $supplier->supplier_id . "/" . $this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a>
                                                <span style="margin-left: 10px;"></span>
                                                <?php if ($supplier->supplier_name != 'Opening Stock') {  ?>
                                                    <a class="llink llink-edit" href="<?php echo site_url("suppliers/edit/" . $supplier->supplier_id . "/" . $this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a>
                                                    <span style="margin-left: 10px;"></span>
                                                    <a class="llink llink-trash"
                                                        href="<?php echo site_url("suppliers/trash/" . $supplier->supplier_id . "/" . $this->uri->segment(4)); ?>"
                                                        onclick="return confirm('Are you sure you want to move this supplier to trash?');">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>

                                                <?php } ?>
                                                <span style="margin-left: 10px;"></span>
                                                <a href="<?php echo site_url("suppliers/print_supplier_invoices/" . $supplier->supplier_id); ?>" target="_new">
                                                    <span class="fa fa-print"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" style="text-align: right;">Total:</th>
                                        <th><?php echo number_format($total_liabilities, 2); ?></th>
                                        <th><?php echo number_format($total_purchased, 2); ?></th>
                                        <th><?php echo number_format($total_paid, 2); ?></th>
                                        <th><?php echo number_format($total_remaining, 2); ?></th>
                                        <th></th>
                                    </tr>
                                </tfoot>

                            </table>

                            <div style="text-align: center;">
                                <a class="btn btn-primary btn-sm" href="<?php echo site_url("suppliers/add"); ?>"><i class="fa fa-plus"></i> Add New Suppliers</a>
                                <a class="btn btn-danger btn-sm" href="<?php echo site_url("suppliers/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
                            </div>

                            <?php echo $pagination; ?>
                        <?php } ?>


                        </div>


                </div>

            </div>
        </div>
        <!-- /MESSENGER -->
    </div>
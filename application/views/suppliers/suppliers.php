<div class="row">
    <!-- MESSENGER -->
    <div class="col-md-12">
        <div class="box border blue" id="messenger">
            <div class="box-title">
                <h4><i class="fa fa-bell"></i> <?php echo $title; ?></h4>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><?php echo $this->lang->line('supplier_name'); ?></th>
                                <th><?php echo $this->lang->line('supplier_contact_no'); ?></th>
                                <th><?php echo $this->lang->line('company_name'); ?></th>
                                <th><?php echo $this->lang->line('account_number'); ?></th>
                                <th>Total Amount</th>
                                <th>Print Invoices</th>
                                <th><?php echo $this->lang->line('Status'); ?></th>
                                <th><?php echo $this->lang->line('Action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($suppliers as $supplier) : ?>
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
                                    <td>
                                        <?php
                                        $query = "SELECT  ROUND(SUM( `inventory`.`item_cost_price`*`inventory`.`inventory_transaction`),2) AS total 
                                                FROM   `inventory` WHERE `inventory`.`supplier_id`='" . $supplier->supplier_id . "';";
                                        $result = $this->db->query($query)->row();
                                        $total_amount = $result->total;
                                        echo $total_amount;
                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo site_url("suppliers/print_supplier_invoices/" . $supplier->supplier_id); ?>" target="_new">
                                            <span class="fa fa-print"></span>
                                            Print
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo status($supplier->status, $this->lang); ?>
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
                                    </td>
                                    <td>
                                        <a class="llink llink-view" href="<?php echo site_url("suppliers/view_supplier/" . $supplier->supplier_id . "/" . $this->uri->segment(4)); ?>">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a class="llink llink-edit" href="<?php echo site_url("suppliers/edit/" . $supplier->supplier_id . "/" . $this->uri->segment(4)); ?>">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        <a class="llink llink-trash" href="<?php echo site_url("suppliers/trash/" . $supplier->supplier_id . "/" . $this->uri->segment(4)); ?>">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <?php echo $pagination; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /MESSENGER -->
</div>
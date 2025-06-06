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
                <li>
                    <i class="fa fa-table"></i>
                    <a href="<?php echo site_url("items/view/"); ?>"><?php echo $this->lang->line('Items'); ?></a>
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
                <!--<div class="tools">
            
				<a href="#box-config" data-toggle="modal" class="config">
					<i class="fa fa-cog"></i>
				</a>
				<a href="javascript:;" class="reload">
					<i class="fa fa-refresh"></i>
				</a>
				<a href="javascript:;" class="collapse">
					<i class="fa fa-chevron-up"></i>
				</a>
				<a href="javascript:;" class="remove">
					<i class="fa fa-times"></i>
				</a>
				

			</div>-->
            </div>
            <div class="box-body">

                <div class="table-responsive">

                    <table class="table">
                        <thead>

                        </thead>
                        <tbody>
                            <?php foreach ($items as $item) : ?>


                                <tr>
                                    <th><?php echo $this->lang->line('name'); ?></th>
                                    <td>
                                        <?php echo $item->name; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('category'); ?></th>
                                    <td>
                                        <?php echo $item->category; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('item_code_no'); ?></th>
                                    <td>
                                        <?php echo $item->item_code_no; ?>
                                        <?php if ($barcode) { ?>
                                            <div style="padding: 10px; margin:10px; ">

                                                <img src="<?php echo $barcode; ?>">

                                            </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('description'); ?></th>
                                    <td>
                                        <?php echo $item->description; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('cost_price'); ?></th>
                                    <td>
                                        <?php echo $item->cost_price; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('unit_price'); ?></th>
                                    <td>
                                        <?php echo $item->unit_price; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('unit'); ?></th>
                                    <td>
                                        <?php echo $item->unit; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('reorder_level'); ?></th>
                                    <td>
                                        <?php echo $item->reorder_level; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('location'); ?></th>
                                    <td>
                                        <?php echo $item->location; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('Status'); ?></th>
                                    <td>
                                        <?php echo status($item->status); ?>
                                    </td>
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
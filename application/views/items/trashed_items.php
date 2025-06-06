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

					<table class="table table-table-bordered">
						<thead>
							<tr>
								<th><?php echo $this->lang->line('name'); ?></th>
								<th><?php echo $this->lang->line('category'); ?></th>
								<th><?php echo $this->lang->line('item_code_no'); ?></th>
								<th><?php echo $this->lang->line('description'); ?></th>
								<th><?php echo $this->lang->line('cost_price'); ?></th>
								<th><?php echo $this->lang->line('unit_price'); ?></th>
								<th><?php echo $this->lang->line('unit'); ?></th>
								<th><?php echo $this->lang->line('reorder_level'); ?></th>
								<th><?php echo $this->lang->line('location'); ?></th>
								<th><?php echo $this->lang->line('Action'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($items as $item): ?>
								<tr>


									<td>
										<?php echo $item->name; ?>
									</td>
									<td>
										<?php echo $item->category; ?>
									</td>
									<td>
										<?php echo $item->item_code_no; ?>
									</td>
									<td>
										<?php echo $item->description; ?>
									</td>
									<td>
										<?php echo $item->cost_price; ?>
									</td>
									<td>
										<?php echo $item->unit_price; ?>
									</td>
									<td>
										<?php echo $item->unit; ?>
									</td>
									<td>
										<?php echo $item->reorder_level; ?>
									</td>
									<td>
										<?php echo $item->location; ?>
									</td>

									<td>
										<a class="llink llink-view" href="<?php echo site_url("items/view_item/" . $item->item_id . "/" . $this->uri->segment(3)); ?>"><i class="fa fa-eye"></i> </a>
										<a class="llink llink-restore" href="<?php echo site_url("items/restore/" . $item->item_id . "/" . $this->uri->segment(3)); ?>"><i class="fa fa-undo"></i></a>
										<a class="llink llink-delete" href="<?php echo site_url("items/delete/" . $item->item_id . "/" . $this->uri->segment(3)); ?>"><i class="fa fa-times"></i></a>
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
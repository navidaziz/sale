<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- PAGE HEADER-->
<script>
	function update_stock(id) {
		stock = $('#stock_' + id).val();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("suppliers/update_supplier_item_stock") ?>",
			data: {
				inventory_id: id,
				stock: stock
			}
		}).done(function(data) {
			//alert(data);
			$('#stock_view_' + id).html(data);
		});

	}
</script>

<script>
	function update_cost_price(id) {
		item_cost_price = $('#item_cost_price_' + id).val();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("suppliers/update_supplier_item_cost_price") ?>",
			data: {
				inventory_id: id,
				item_cost_price: item_cost_price
			}
		}).done(function(data) {
			//alert(data);
			$('#item_cost_price_stock_view_' + id).html(data);
		});

	}
</script>

<script>
	function update_unit_price(id) {
		item_unit_price = $('#item_unit_price_' + id).val();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("suppliers/update_supplier_item_unit_price") ?>",
			data: {
				inventory_id: id,
				item_unit_price: item_unit_price
			}
		}).done(function(data) {
			$('#item_unit_price_view_' + id).html(data);
		});

	}
</script>

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
					<a href="<?php echo site_url("suppliers/view/"); ?>"><?php echo $this->lang->line('Suppliers'); ?></a>
				</li>
				<li>
					<a href="<?php echo site_url("suppliers/view_supplier/" . $suppliers[0]->supplier_id); ?>">
						<?php echo $title; ?>
					</a>
				</li>
				<li>Invoice-<?php echo $suppliers_invoices->supplier_invoice_number; ?></li>
			</ul>
			<!-- /BREADCRUMBS -->
			<div class="row">

				<div class="col-md-6">
					<div class="clearfix">
						<h3 class="content-title pull-left"><?php echo $title; ?> - Invoice No: <?php echo $suppliers_invoices->supplier_invoice_number; ?></h3>
					</div>
					<div class="description">
						Invoice-<?php echo $suppliers_invoices->supplier_invoice_number; ?> -
						Date - <?php echo $suppliers_invoices->invoice_date; ?>
					</div>
				</div>

				<div class="col-md-6">

					<!-- <button onclick="add_stock_form()" class="btn btn-success">Add Item Inventory</button> -->
					<script>
						function add_stock_form() {
							$.ajax({
									method: "POST",
									url: "<?php echo site_url('suppliers/add_stock_form'); ?>",
									data: {
										supplier_id: '<?php echo  $suppliers[0]->supplier_id; ?>',
										supplier_invoice_id: '<?php echo  $suppliers_invoices->supplier_invoice_id; ?>'

									},
								})
								.done(function(respose) {
									$('#modal').modal('show');
									$('#modal_title').html('Items Inventory');
									$('#modal_body').html(respose);
									$('.item_list').select2();
								});
						}
					</script>
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
				<h4><i class="fa fa-files-o"></i> Invoice No: <?php echo $suppliers_invoices->supplier_invoice_number; ?> Items List</h4>
			</div>
			<div class="box-body">

				<div class="table-responsive">

					<h4>
						New Stock (Inverntroy)
					</h4>
					<script>
						function stock_in() {
							$('#stock_in').show();
							$('#stock_return').hide();
						}

						function stock_return() {
							$('#stock_in').hide();
							$('#stock_return').show();
						}

						function get_item_prices(id) {
							item_id = $('#' + id + ' option:selected').val();
							$.ajax({
								type: "POST",
								url: "<?php echo site_url("suppliers/get_item_prices") ?>",
								data: {
									item_id: item_id,
								}
							}).done(function(data) {

								var data = jQuery.parseJSON(data);

								$('#cost_price1').val(data.cost_price);
								$('#unit_price1').val(data.sale_price);
								//get_user_sale_summary();

							});
						}

						function get_item_prices2(id) {
							item_id = $('#' + id + ' option:selected').val();
							$.ajax({
								type: "POST",
								url: "<?php echo site_url("suppliers/get_item_prices") ?>",
								data: {
									item_id: item_id,
								}
							}).done(function(data) {

								var data = jQuery.parseJSON(data);

								$('#cost_price2').val(data.cost_price);
								$('#unit_price2').val(data.sale_price);
								//get_user_sale_summary();

							});
						}
					</script>
					<?php if ($suppliers_invoices->supplier_invoice_id != 1) { ?>
						<form method="post" action="<?php echo  site_url("suppliers/add_item_stocks") ?>">
							<!-- Stock In: <input type="radio" value="stock_in" name="traction_type" onclick="stock_in()" checked="checked" />
							Stock Return: <input type="radio" value="stock_return" onclick="stock_return()" name="traction_type" />-->
							<table class="table table-bordered table2" style="line-height: 0.5px; display:no ne" id="stock_in">
								<input type="hidden" value="<?php echo  $suppliers[0]->supplier_id; ?>" name="supplier_id" />
								<input type="hidden" value="<?php echo  $suppliers_invoices->supplier_invoice_id; ?>" name="supplier_invoice_id" />
								<input type="hidden" name="unit_price" value="0" />
								<tr>
									<td>
										<strong>Items</strong>
										<?php
										echo form_dropdown("item_id", array("" => "Seelect Item") + $items, "", "id = \"item_id1\" class=\"js-example-basic-single\" onchange=\"get_item_prices('item_id1')\" required style=\"width:150px\"");
										?>
										<div style="text-align: center;">
											<div style="text-align: center; margin:10px">
												<button type="button" onclick="get_item_form('0')" class="btn btn-primary btn-xs">Add New Item</button>
											</div>
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
									</td>
									<td>
										<strong>New Stock (Quantity)</strong><br />
										<input type="number" name="transaction" value="" id="transaction" class="form-control" title="New Stock" placeholder="New Stock">
									</td>

									<td>
										<strong>Total Price</strong><br />
										<input onkeyup="calculate_cost_price()" type="number" name="total_price" value="" id="total_price" class="form-control" title="Total Price" placeholder="Total Price">
									</td>

									<td>
										<strong>Cost Price</strong><br />
										<input type="number" step="any" id="cost_price" name="cost_price" value="" class="form-control" required title="Cost Price" placeholder="Cost Price">
									</td>

									<td>
										<strong>Unit Price</strong><br />
										<input step="any" type="number" name="unit_price" value="" id="unit_price1" class="form-control" title="Unit Price" placeholder="Unit Price">
									</td>

									<script>
										function calculate_cost_price() {
											var transaction = parseFloat($('#transaction').val());
											var total_price = parseFloat($('#total_price').val());

											if (!isNaN(transaction) && transaction > 0 && !isNaN(total_price)) {
												var cost_price = total_price / transaction;
												$('#cost_price').val(cost_price.toFixed(2)); // rounded to 2 decimals
											}
										}
									</script>


									<!-- <td>
										<strong>Date</strong>
										<input style="width: 130px;" type="date" name="date" value="" id="date" class="form - control" title="date" placeholder="date" />
									</td> -->
									<input type="hidden" name="date" value="<?php echo date("Y-m-d") ?>" />

									<td>

										<input class="btn btn-primary btn-sm" type="submit" name="add_stock" value="Add Stock" />
									</td>
								</tr>
							</table>
						</form>

					<?php } ?>

					<?php if ($this->session->flashdata("msg") || $this->session->flashdata("msg_error") || $this->session->flashdata("msg_success")) {

						$type = "";
						if ($this->session->flashdata("msg_success")) {
							$type = "success";
							$msg = $this->session->flashdata("msg_success");
						} elseif ($this->session->flashdata("msg_error")) {
							$type = "danger";
							$msg = $this->session->flashdata("msg_error");
						} else {
							$type = "info";
							$msg = $this->session->flashdata("msg");
						}
					?>
						<div class="alert alert-<?php echo $type; ?> " role="alert">
							<strong>Note!</strong>
							<?php echo $msg; ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

					<?php } ?>

					<h4> Invoice No: <?php echo $suppliers_invoices->supplier_invoice_number; ?>
						- Dated: <?php echo $suppliers_invoices->invoice_date; ?> Items List</h4>
					</h4>
					<table class="table table-bordered table2">
						<thead>
							<th>#</th>
							<th>Item Name</th>
							<th>Item Code</th>
							<th>Cost Price</th>
							<th>Unit Price</th>
							<th>Quantity</th>
							<th>Transaction Type</th>
							<th>Total</th>
							<th>Created By</th>
							<th>Action</th>
						</thead>
						<tbody>
							<?php
							$count = 1;
							$net_total = 0;
							foreach ($inventories as $inventory) :
								$net_total += $inventory->item_cost_price * $inventory->inventory_transaction;
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo $inventory->name; ?></td>
									<td><?php echo $inventory->item_code_no; ?></td>
									<td><?php echo $inventory->item_cost_price; ?></td>
									<td><?php echo $inventory->item_unit_price; ?></td>
									<td><?php echo $inventory->inventory_transaction; ?></td>

									<td><strong><?php echo $inventory->transaction_type; ?></strong>
										<?php if ($inventory->return_date) { ?>
											<small><?php echo date('d M, Y', strtotime($inventory->return_date)); ?></small>
										<?php } ?>
									</td>
									<td><?php echo $inventory->item_cost_price * $inventory->inventory_transaction; ?></td>

									<td><?php echo $inventory->userTitle; ?></td>
									<td>
										<a class="btn btn-danger btn-xs" href="<?php echo site_url("suppliers/remove_supplier_item/" . $inventory->supplier_id . "/" . $inventory->supplier_invoice_id . "/" . $inventory->inventory_id) ?>">Remove</a>
										<button onclick="update_stock_form('<?php echo $inventory->inventory_id; ?>')" class="btn btn-success btn-xs">Edit</button>
									</td>

								</tr>

							<?php endforeach; ?>
							<tr>
								<td colspan="6">Total</td>
								<th><?php echo $net_total; ?></th>
								<td colspan="4"></td>
							</tr>
						</tbody>
					</table>




				</div>


			</div>

		</div>
	</div>
	<!-- /MESSENGER -->
</div>
<script>
	$(document).ready(function() {
		$('.js-example-basic-single').select2();
	});
	$(document).ready(function() {
		$('.js-example-basic-single2').select2();
	});
</script>


<script>
	function update_stock_form(inventory_id) {
		$.ajax({
				method: "POST",
				url: "<?php echo site_url('suppliers/update_stock_form'); ?>",
				data: {
					inventory_id: inventory_id
				},
			})
			.done(function(respose) {
				$('#modal').modal('show');
				$('#modal_title').html('Items Inventory');
				$('#modal_body').html(respose);
			});
	}
</script>
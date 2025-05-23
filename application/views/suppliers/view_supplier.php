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
					<a href="<?php echo site_url("suppliers/view/"); ?>"><?php echo $this->lang->line('Suppliers'); ?></a>
				</li>
				<li><?php echo $title; ?></li>
			</ul>
			<!-- /BREADCRUMBS -->
			<div class="row">

				<div class="col-md-6">
					<div class="clearfix">
						<h3 class="content-title pull-left"><?php echo $title; ?></h3>
					</div>
					<div class="description"><?php echo $detail; ?></div>
				</div>

				<div class="col-md-6">

					<?php
					$query = "SELECT SUM(item_cost_price*inventory_transaction) as `amount` 
						FROM `inventory`
						WHERE `business_id` = ?
						AND `supplier_id` = ?";
					$purchased = $this->db->query($query, [$this->session->userdata("business_id"), $suppliers[0]->supplier_id])->row();
					$query = "SELECT SUM(amount) as `amount` 
						FROM `supplier_payments`
						WHERE `business_id` = ?
						AND `supplier_id` = ?";
					$paid = $this->db->query($query, [$this->session->userdata("business_id"), $suppliers[0]->supplier_id])->row();


					?>
					<table class="table table-bordered table-striped">
						<tr>
							<th>Liabilities</th>
							<th>Purchased Amount</th>
							<th>Amount Paid</th>
							<th>Remaining</th>
						</tr>
						<tr>
							<td><?php echo $suppliers[0]->liabilities; ?></td>
							<td><?php echo $purchased->amount; ?></td>
							<td><?php echo $paid->amount; ?></td>
							<td><?php echo number_format((($suppliers[0]->liabilities + $purchased->amount) - $paid->amount), 2); ?></td>
					</table>


				</div>

			</div>


		</div>
	</div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row">
	<!-- MESSENGER -->
	<div class="col-md-7">
		<div class="box border blue" id="messenger">
			<div class="box-title">
				<h4><i class="fa fa-file"></i> Stock Invoices</h4>
			</div>
			<div class="box-body">

				<div class="table-responsive">




					<strong>Stock In Invoices and Return Receipt List</strong>
					<hr />

					<table class="table table-bordered table-striped table_small">
						<thead>
							<tr>
								<th>#</th>
								<th>Type</th>
								<th>Invoice no</th>
								<th>Date</th>
								<th>Total Items</th>
								<th>Total Amount</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php

							$count = 1;
							foreach ($supplier_invoices as $count => $si): ?>
								<tr>
									<td><?= $count + 1 ?></td>
									<td><?= ($si->return_receipt == 0) ? 'Return' : 'Stock-In' ?></td>
									<td><?= $si->supplier_invoice_number ?></td>
									<td><?= date('M d, Y', strtotime($si->invoice_date)) ?></td>
									<td><?= $si->total_items ?></td>
									<td><?= $si->total_cost ?></td>
									<td>
										<?php if ($si->return_receipt == 0) { ?>
											<a class="btn btn-danger btn-xs" href="<?= site_url("suppliers/supplier_return_view/{$si->supplier_id}/{$si->supplier_invoice_id}") ?>"><i class="fa fa-undo" style="font-size: 9px;" aria-hidden="true"></i> Return Detail</a>
										<?php } else { ?>
											<a class="btn btn-success btn-xs" href="<?= site_url("suppliers/supplier_invoice_view/{$si->supplier_id}/{$si->supplier_invoice_id}") ?>"><i class="fa fa-eye" style="font-size: 9px;" aria-hidden="true"></i> Invoice Detail</a>
										<?php } ?>
										<a class="btn btn-warning btn-xs" href="<?= site_url("suppliers/print_supplier_item_lists/{$si->supplier_id}/{$si->supplier_invoice_id}") ?>" target="_blank">
											<span class="fa fa-print"></span> Print
										</a>
										<a class="btn btn-warning btn-xs" href="<?= site_url("suppliers/print_supplier_receipt/{$si->supplier_id}/{$si->supplier_invoice_id}") ?>" target="_blank">
											<span class="fa fa-print"></span> Supplier Receipt
										</a>
									</td>
								</tr>
							<?php endforeach; ?>

						</tbody>
					</table>

					<div style="text-align: center;">
						<?php if ($title != 'Opening Stock') {  ?>
							<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#exampleModal">
								Add Stock In Invoice or Return Receipt
							</button>
						<?php } ?>
						<!-- Modal -->
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header" style="text-align: left;">
										<h5 class="modal-title " id="exampleModalLabel">Return Receipt / Stock In Invoice

											<button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</h5>

									</div>
									<div class="modal-body">
										<form method="post" action="<?php echo site_url('suppliers/add_supplier_invoice'); ?>" class="container">
											<div class="row">
												<!-- Invoice Type (inline radio buttons) -->
												<div class="col-md-12 col-sm-12 form-group row align-items-center">
													<label for="supplier_invoice_number" class="col-sm-6 col-form-label">Invoice Type:</label>

													<div class="form-check form-check-inline">

														<input class="form-check-input" type="radio" name="return_receipt" id="stock_in_invoice" value="1" checked>
														<label class="form-check-label" for="stock_in_invoice">Stock In Invoice</label>
														<span class="ml-3"></span>
														<input class="form-check-input" type="radio" name="return_receipt" id="return_receipt" value="0">
														<label class="form-check-label" for="return_receipt">Return Receipt</label>

													</div>
												</div>

												<!-- Invoice Number (inline label and input) -->
												<div class="col-md-12 col-sm-12 form-group row align-items-center">
													<label for="supplier_invoice_number" class="col-sm-6 col-form-label">Invoice No.</label>
													<div class="col-sm-6">
														<input type="text" name="supplier_invoice_number" id="supplier_invoice_number" class="form-control">
														<input type="hidden" name="supplier_id" value="<?php echo $suppliers[0]->supplier_id; ?>">
														<?php echo form_error("supplier_invoice_number", "<p class=\"text-danger\">", "</p>"); ?>
													</div>
												</div>

												<!-- Invoice Date (inline label and input) -->
												<div class="col-md-12 col-sm-12 form-group row align-items-center">
													<label for="invoice_date" class="col-sm-6 col-form-label">Invoice Date</label>
													<div class="col-sm-6">
														<input type="date" name="invoice_date" id="invoice_date" class="form-control">
														<?php echo form_error("invoice_date", "<p class=\"text-danger\">", "</p>"); ?>
													</div>
												</div>

												<!-- Submit Button -->
												<div class="col-md-12 col-sm-12 form-group">
													<input type="submit" name="Save" value="Add Invoice / Receipt" class="btn btn-primary btn-block">

												</div>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>
					</div>



				</div>


			</div>

		</div>
	</div>

	<div class="col-md-5">
		<div class="box border blue" id="messenger">
			<div class="box-title">
				<h4><i class="fa fa-file"></i> Payment Detail</h4>
			</div>
			<div class="box-body">

				<div class="table-responsive">




					<strong>List of payments</strong>
					<hr />

					<div class="table-responsive">
						<table class="table table-bordered table_striped table_small" id="supplier_payments">
							<thead>
								<tr>
									<th></th>
									<th>#</th>
									<th>Payment Date</th>
									<th>Payment Mode</th>
									<th>Amount</th>
									<th>Reference No</th>
									<th>Remarks</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$count = 1;
								$business_id = $this->session->userdata("business_id");
								$query = "SELECT * FROM supplier_payments 
								WHERE business_id = ?
								AND supplier_id  = ?
								
								";
								$rows = $this->db->query($query, [$business_id, $suppliers[0]->supplier_id])->result();
								foreach ($rows as $row) { ?>
									<tr>
										<td><a href="<?php echo site_url('suppliers/delete_supplier_payment/' . $row->payment_id); ?>" onclick="return confirm('Are you sure? you want to delete the record.')">Delete</a> </td>
										<td><?php echo $count++ ?></td>
										<td><?php echo $row->payment_date; ?></td>
										<td><?php echo $row->payment_mode; ?></td>
										<td><?php echo $row->amount; ?></td>
										<td><?php echo $row->reference_no; ?></td>
										<td><?php echo $row->remarks; ?></td>

										<td><button onclick="get_supplier_payment_form('<?php echo $row->payment_id; ?>')">Edit<botton>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						<div style="text-align: center;">
							<button onclick="get_supplier_payment_form('0')" class="btn btn-primary btn-xs">Add Payment</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		function get_supplier_payment_form(payment_id) {
			$.ajax({
					method: "POST",
					url: "<?php echo site_url('suppliers/get_supplier_payment_form'); ?>",
					data: {
						payment_id: payment_id,
						supplier_id: <?php echo $suppliers[0]->supplier_id; ?>
					},
				})
				.done(function(respose) {
					$('#modal').modal('show');
					$('#modal_title').html('Supplier Payments');
					$('#modal_body').html(respose);
				});
		}
	</script>
</div>

</div>
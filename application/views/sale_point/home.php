<style>
	.btn {
		margin: 1px !important;
	}

	<?php if (preg_match('/mobile/i', $_SERVER['HTTP_USER_AGENT'])) { ?>.col-xs-1,
	.col-sm-1,
	.col-md-1,
	.col-lg-1,
	.col-xs-2,
	.col-sm-2,
	.col-md-2,
	.col-lg-2,
	.col-xs-3,
	.col-sm-3,
	.col-md-3,
	.col-lg-3,
	.col-xs-4,
	.col-sm-4,
	.col-md-4,
	.col-lg-4,
	.col-xs-5,
	.col-sm-5,
	.col-md-5,
	.col-lg-5,
	.col-xs-6,
	.col-sm-6,
	.col-md-6,
	.col-lg-6,
	.col-xs-7,
	.col-sm-7,
	.col-md-7,
	.col-lg-7,
	.col-xs-8,
	.col-sm-8,
	.col-md-8,
	.col-lg-8,
	.col-xs-9,
	.col-sm-9,
	.col-md-9,
	.col-lg-9,
	.col-xs-10,
	.col-sm-10,
	.col-md-10,
	.col-lg-10,
	.col-xs-11,
	.col-sm-11,
	.col-md-11,
	.col-lg-11,
	.col-xs-12,
	.col-sm-12,
	.col-md-12,
	.col-lg-12 {
		position: relative;
		min-height: 1px;
		padding-left: 5px;
		padding-right: 5px;
	}



	<?php } ?>
</style>
<div class="content-wrapper" style="padding-top: 5px;">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<section class="content">

			<div class="row" id="sale_summary_div">

				<?php if (!preg_match('/mobile/i', $_SERVER['HTTP_USER_AGENT'])) { ?>
					<div class="col-md-7">
						<div class="panel panel-primary">

							<div class="panel-heading">
								<h5><i class="fa fa-shopping-cart"></i> Sale Item List</h5>
							</div>
							<div style="padding: 5px; margin:2px">
								<div style="height:400px" id="category_items_list"></div>
								<hr />
								<div style="min-height:90px;" class="categories_list">

									<?php
									$business_id = $this->session->userdata("business_id");
									$query = "SELECT category FROM items WHERE business_id = ? AND status=1 GROUP BY category ORDER BY category ASC";
									$categories = $this->db->query($query, [$business_id])->result();
									foreach ($categories as $category) { ?>
										<button onclick="get_items_by_category('<?php echo $category->category ?>')" class="btn btn-success"><?php echo $category->category ?></button>
									<?php } ?>

								</div>
							</div>
						</div>
					</div>
				<?php } ?>


				<!-- Right Side -->
				<div class="col-md-5">
					<div class="panel panel-primary">

						<?php if (!preg_match('/mobile/i', $_SERVER['HTTP_USER_AGENT'])) { ?>
							<div class="panel-heading">
								<div style=" display: inline-block; vertical-align: left; text-align:right !important">
									<label for="tags" style="display: inline-block; margin-right: 5px;">Search Item</label>
									<input id="tags" name="search_sale_item" placeholder="Search Sale Item" class="form-control" style="display: inline-block; width: auto;" />
								</div>
							</div>
						<?php } else { ?>

						<?php } ?>


						<div class="panel-body">
							<div class="panel-body" style="border:1px dashed gray; padding:1px; border-radius:5px; height:230px; overflow-x: auto;">
								<div id="item_list"><?php echo $user_items_list; ?></div>
							</div>
							<style>
								#item_sale_summary>table {
									font-size: 13px;
								}
							</style>
							<div id="item_sale_summary"><?php echo $items_sale_summary; ?></div>

							<?php if (preg_match('/mobile/i', $_SERVER['HTTP_USER_AGENT'])) { ?>
								<div style="padding: 5px; margin:2px">
									<div id="category_items_list"></div>
									<hr />
									<div class="categories_list">

										<?php
										$business_id = $this->session->userdata("business_id");
										$query = "SELECT category FROM items WHERE business_id = ? GROUP BY category ORDER BY category ASC";
										$categories = $this->db->query($query, [$business_id])->result();
										foreach ($categories as $category) { ?>
											<button onclick="get_items_by_category('<?php echo $category->category ?>')" class="btn btn-success"><?php echo $category->category ?></button>
										<?php } ?>

									</div>
								</div>
							<?php } ?>
							<?php if (preg_match('/mobile/i', $_SERVER['HTTP_USER_AGENT'])) { ?>
								<div class="mobile_menu">
								<?php } ?>



								<!-- Remarks (Initially Hidden) -->
								<div class="form-group" id="remarks_tr" style="display: none;">
									<label>Remarks</label>
									<input type="text" name="remarks" id="remarks" class="form-control" />
								</div>

								<!-- Discount, Cash, Cash Back -->
								<div class="row">
									<div style="margin: 3px;">
										<div class="col-xs-3">
											<label for="payment_type">Pay. Type</label>
											<select name="payment_type" id="payment_type" class="form-control" onchange="toggleRemarks(this)">
												<option value="cash" selected>Cash</option>
												<option value="cheque">Cheque</option>
												<option value="debit_card">Deb-Card</option>
												<option value="credit_card">Cre-Card</option>
											</select>
										</div>
										<div class="col-xs-3">
											<label>Discount</label>
											<input type="number" name="discount" id="discount" class="form-control" value="0" onkeyup="add_discount()" />
										</div>
										<div class="col-xs-3">
											<label>Paid</label>
											<input type="number" name="cash_amount" id="cash_amount" class="form-control" value="0" onkeyup="cash_calulator()" />
										</div>
										<div class="col-xs-3">
											<label>Return: <span id="cash_back">0.00</span></label>
											<button id="save_sale_button" onclick="save_data()" class="btn btn-success btn-block">Sale</button>
										</div>
									</div>
								</div>

								<!-- Customer Info -->
								<div class="row mt-3" style="display:none">
									<div class="col-12 col-sm-6">
										<label>Customer Mobile No</label>
										<input type="text" name="customer_mobile_no" id="customer_mobile_no" class="form-control" />
									</div>
									<div class="col-12 col-sm-6">
										<label>Customer Name</label>
										<input type="text" name="customer_name" id="customer_name" class="form-control" />
									</div>
								</div>


								<?php if (!preg_match('/mobile/i', $_SERVER['HTTP_USER_AGENT'])) { ?>
									<!-- Return Items Button -->
									<div class="row mt-2">
										<div class="col-xs-4">
											<a href="<?php echo site_url("return_point") ?>" class="btn btn-danger btn-block">Return Items</a>
										</div>
										<div class="col-xs-4">
											<button onclick="get_sale_reports()" data-toggle="modal" data-target="#sale_report_mode" class="btn btn-primary btn-block">Sale Reports</button>
										</div>
										<div class="col-xs-4">
											<button onclick="get_sale_receipts()" data-toggle="modal" data-target="#item_return_modal" class="btn btn-warning btn-block">Reprint Receipt</button>
										</div>
									</div>
								<?php } ?>

								<?php if (preg_match('/mobile/i', $_SERVER['HTTP_USER_AGENT'])) { ?>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>

			</div>
			<div class="box-footer"></div>
		</section>
	</section>


</div>







<div class="modal fade" id="sale_report_mode" tabindex="-1" role="dialog" aria-labelledby="inventory_model" aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: 90%;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel" style="display: inline;">Sale Report</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="sale_report_mode_body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="item_return_modal" tabindex="-1" role="dialog" aria-labelledby="inventory_model" aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: 90%;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel" style="display: inline;">Sale / Return Receipts</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="sale_return_receipt_body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			</div>
		</div>
	</div>
</div>


<script>
	function get_sale_reports() {
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("sale_point/get_sale_reports") ?>",
			data: {}
		}).done(function(data) {
			$('#sale_report_mode_body').html(data);

		});
	}

	function get_sale_receipts() {
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("sale_point/get_sale_receipts") ?>",
			data: {}
		}).done(function(data) {
			$('#sale_return_receipt_body').html(data);

		});

	}

	function save_data() {

		var tax_ids = $("#tax_ids").val();
		var payment_type = $("input[name='payment_type']:checked").val();
		remarks = $('#remarks').val();
		discount = parseFloat($('#discount').val());
		if (!$('#discount').val()) {
			//alert('Discount Field is empty');
			$('#discount').val(0);
			return;
		}
		cash_amount = parseFloat($('#cash_amount').val());
		customer_name = $('#customer_name').val();
		customer_mobile_no = $('#customer_mobile_no').val();
		pay_able_total = parseFloat($('#pay_able_total').html());
		cash_back = parseFloat($('#cash_back').html());
		if (cash_amount == 0) {
			alert("Cash Amout is Zero");
			return false;
		}
		if (cash_amount < pay_able_total) {
			alert("Cash Amout is less the Payable total amount");
			return false;
		}

		$.ajax({
			type: "POST",
			url: "<?php echo site_url("sale_point/add_sale_data") ?>",
			data: {
				payment_type: payment_type,
				remarks: remarks,
				discount: discount,
				cash_amount: cash_amount,
				customer_name: customer_name,
				customer_mobile_no: customer_mobile_no,
				pay_able_total: pay_able_total,
				cash_back: cash_back,
				tax_ids: tax_ids
			}
		}).done(function(data) {

			$('#print_area').html(data);
			get_user_sale_summary();
			$('#cash_amount').val(0);
			$('#customer_name').val("");
			$('#customer_mobile_no').val("");
			$('#pay_able_total').html("0.00");
			$('#cash_back').html("0.00");
			$('#discount').val(0);
			$('#item_list').html('');
			//$('#print_area').html(data);
			//Print2(data);
			window.print();
		});



	}



	function add_discount() {
		discount = parseFloat($('#discount').val());
		pay_able = parseFloat($('#pay_able').html());
		$('#payment_discount').html(discount);
		$('#pay_able_total').html(pay_able - discount);
		cash_calulator();

	}

	function cash_calulator() {
		cash_amount = parseFloat($('#cash_amount').val());
		pay_able_total = parseFloat($('#pay_able_total').val());
		$('#cash_back').html(cash_amount - pay_able_total);
	}

	$(function() {
		var availableTags = [
			<?php foreach ($sale_items as $sale_item) {
				echo '"' . $sale_item->name . '", ';
				if ($sale_item->name != "") {
					echo '"' . $sale_item->item_code_no . '", ';
				}
			} ?>
		];
		$("#tags").autocomplete({
			source: availableTags
		});
	});

	$('#tags').on('keydown', function(e) {
		if (e.keyCode == 13) {
			var search_item = $('#tags').val();
			if (search_item == "") {
				return false;
			}
			addItems(search_item);

		}

	});

	function addItems(item_name) {

		$('#item_list').html('<p style="text-align:center"><strong>Please Wait...... Loading</strong></p>');
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("sale_point/get_search_item") ?>",
			data: {
				search_item: item_name
			}
		}).done(function(data) {
			$('#item_list').html(data);
			get_user_sale_summary();
			$('#error_message_sale').delay(5000).fadeOut('slow');
		});

	}

	function update_user_item_quantity(user_item_id) {
		//item_quantity: item_quantity.replace(/[^a-zA-Z0-9]/g, ''),
		if (event.key === 'Enter') {
			var item_quantity = $('#user_item_' + user_item_id).val();
			$('#item_list').html('<p style="text-align:center"><strong>Please Wait...... Loading</strong></p>');
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("sale_point/update_user_item_quantity") ?>",
				data: {
					user_item_id: user_item_id,
					item_quantity: item_quantity,
				}
			}).done(function(data) {
				$('#item_list').html(data);
				get_user_sale_summary();

			});
		}

	}

	function update_user_item_discount(user_item_id) {
		//item_quantity: item_quantity.replace(/[^a-zA-Z0-9]/g, ''),
		if (event.key === 'Enter') {
			var item_discount = $('#user_item_discount_' + user_item_id).val();
			$('#item_list').html('<p style="text-align:center"><strong>Please Wait...... Loading</strong></p>');
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("sale_point/update_user_item_discount") ?>",
				data: {
					user_item_id: user_item_id,
					item_discount: item_discount,
				}
			}).done(function(data) {
				$('#item_list').html(data);
				get_user_sale_summary();

			});
		}

	}

	function get_user_sale_summary() {

		//$('#item_sale_summary').html('<p style="text-align:center"><strong>Please Wait...... Loading</strong></p>');
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("sale_point/user_items_sale_summary") ?>",
			data: {}
		}).done(function(data) {
			$('#item_sale_summary').html(data);
		});


	}
</script>

<script>
	function get_items_by_category(category) {
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("sale_point/get_items_by_category") ?>",
			data: {
				category: category
			}
		}).done(function(data) {
			$('#category_items_list').html(data);

		});
	}
</script>



<style>
	.mobile_menu {
		position: fixed;
		bottom: 0;
		left: 0;
		width: 100%;
		background-color: #5E87AF;
		color: white;
		text-align: center;
		padding: 10px;
	}
</style>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Invoice</title>
	<link rel="stylesheet" href="style.css">
	<link rel="license" href="http://www.opensource.org/licenses/mit-license/">
	<script src="script.js"></script>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>CCML</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/cloud-admin.css" media="screen,print" />
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/themes/default.css" media="screen,print" id="skin-switcher" />
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/responsive.css" media="screen,print" />
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/custom.css" media="screen,print" />


	<style>
		body {
			background: rgb(204, 204, 204);
		}

		page {
			background: white;
			display: block;
			margin: 0 auto;
			margin-bottom: 0.5cm;
			box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
		}

		page[size="A4"] {
			width: 21cm;
			/* height: 29.7cm;  */
			height: auto;
		}

		page[size="A4"][layout="landscape"] {
			width: 29.7cm;
			height: 21cm;
		}

		page[size="A3"] {
			width: 29.7cm;
			height: 42cm;
		}

		page[size="A3"][layout="landscape"] {
			width: 42cm;
			height: 29.7cm;
		}

		page[size="A5"] {
			width: 14.8cm;
			height: 21cm;
		}

		page[size="A5"][layout="landscape"] {
			width: 21cm;
			height: 14.8cm;
		}

		@media print {

			body,
			page {
				margin: 0;
				box-shadow: 0;
				color: black;
			}

		}


		.table>thead>tr>th,
		.table>tbody>tr>th,
		.table>tfoot>tr>th,
		.table>thead>tr>td,
		.table>tbody>tr>td,
		.table>tfoot>tr>td {
			padding: 8px;
			line-height: 1;
			vertical-align: top;
			border-top: 1px solid #ddd;
			font-size: 15px !important;
		}
	</style>
</head>

<body>
	<page size='A4'>
		<div style="padding: 5px;  padding-left:20px; padding-right:20px; " contenteditable="true">
			<table class="table" style="font-size: 12px; width`: 100%;">
				<tr>
					<td>
						<h3 style="text-align: center;"> <?php echo $this->session->userdata("business_name"); ?> </h3>
						<h5 style="text-align: center;"></h5>
						<h4 style="text-align: center;">Item Stock In</h4>
					</td>
					<td>
						<h5 style="margin-top: 30px;">
							Supplier Name: <?php echo $title; ?>
							<br /><br />Return Receipt No: <?php echo $suppliers_invoices->supplier_invoice_number; ?>
							<br /><br />Receipt Dated: <?php echo date("d F, Y ", strtotime($suppliers_invoices->invoice_date))  ?>
						</h5>
					</td>
				</tr>
			</table>

			<hr />

			<h4>Items List</h4>

			<table class="table table-bordered" style="font-size: 12px;">
				<thead>
					<th>#</th>
					<th>Item Name</th>
					<th>Quantity</th>
					<th>Cost Price</th>
					<th>Total Cost</th>
					<th>Sale Price</th>
					<th>Sale Total</th>
					<th>Expected Profit</th>
					<th>Remarks</th>
				</thead>
				<tbody>
					<?php
					$count = 1;
					$net_total = 0;
					foreach ($inventories as $inventory) :
						$net_cost_total += $inventory->item_cost_price * $inventory->inventory_transaction;
						$net_sale_total += $inventory->item_unit_price * $inventory->inventory_transaction;
					?>
						<tr>
							<td><?php echo $count++; ?></td>
							<td><?php echo $inventory->name; ?></td>
							<td><?php echo $inventory->inventory_transaction; ?></td>
							<td><?php echo $inventory->item_cost_price; ?></td>
							<td><?php echo $inventory->item_cost_price * $inventory->inventory_transaction; ?></td>
							<td><?php echo $inventory->item_unit_price; ?></td>
							<td><?php echo $inventory->item_unit_price * $inventory->inventory_transaction; ?></td>
							<td><?php echo (($inventory->item_unit_price * $inventory->inventory_transaction) - ($inventory->item_cost_price * $inventory->inventory_transaction)) ?></td>
							<td></td>
						</tr>

					<?php endforeach; ?>
					
				</tbody>
			</table>

			<br />

			<br />
			<?php

			$query = "SELECT
                  `roles`.`role_title`,
                  `users`.`userTitle`  
              FROM `roles`,
              `users` 
              WHERE `roles`.`role_id` = `users`.`role_id`
              AND `users`.`user_id`='" . $this->session->userdata('user_id') . "'";
			$user_data = $this->db->query($query)->result()[0];
			?> </p>

			<p class="divFooter" style="text-align: right;"><b><?php echo $user_data->userTitle; ?> <?php echo $user_data->role_title; ?></b>
				<br /><?php echo $this->session->userdata("business_name"); ?> <br />
				<strong>Printed at: <?php echo date("d, F, Y h:i:s A", time()); ?></strong>
			</p>


		</div>

	</page>
</body>



</html>
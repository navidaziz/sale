<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Invoice</title>
	<link rel="license" href="http://www.opensource.org/licenses/mit-license/">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<style>
		body {
			background: rgb(204, 204, 204);
			font-family: Arial, sans-serif;
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
			height: auto;
			padding: 1.5cm;
		}

		@media print {

			body,
			page {
				margin: 0;
				box-shadow: 0;
				color: black;
			}
		}

		.table {
			width: 100%;
			max-width: 100%;
			margin-bottom: 20px;
			border-collapse: collapse;
		}

		.table th {
			text-align: left;
			background-color: #f5f5f5;
			font-weight: bold;
		}

		.table>thead>tr>th,
		.table>tbody>tr>th,
		.table>tfoot>tr>th,
		.table>thead>tr>td,
		.table>tbody>tr>td,
		.table>tfoot>tr>td {
			padding: 8px;
			line-height: 1.42857143;
			vertical-align: top;
			border-top: 1px solid #ddd;
			font-size: 12px;
		}

		.table-bordered {
			border: 1px solid #ddd;
		}

		.table-bordered>thead>tr>th,
		.table-bordered>tbody>tr>th,
		.table-bordered>tfoot>tr>th,
		.table-bordered>thead>tr>td,
		.table-bordered>tbody>tr>td,
		.table-bordered>tfoot>tr>td {
			border: 1px solid #ddd;
		}

		.text-right {
			text-align: right;
		}

		.text-center {
			text-align: center;
		}

		.text-bold {
			font-weight: bold;
		}

		.totals-row {
			background-color: #f9f9f9;
			font-weight: bold;
		}

		.header-info {
			margin-bottom: 20px;
		}

		.company-name {
			font-size: 18px;
			font-weight: bold;
			margin-bottom: 5px;
		}

		.report-title {
			font-size: 16px;
			margin-bottom: 15px;
		}

		.supplier-info {
			margin-top: 10px;
		}

		.footer {
			margin-top: 30px;
			padding-top: 10px;
			border-top: 1px solid #eee;
			font-size: 11px;
		}

		.page-break {
			page-break-after: always;
		}
	</style>
</head>

<body>
	<page size='A4'>
		<div class="header-info">
			<div class="text-center company-name"><?php echo $this->session->userdata("business_name"); ?></div>
			<div class="text-center report-title">Purchased List</div>

			<table class="table">
				<tr>
					<td style="width: 60%;">
						<div class="supplier-info">
							<strong>Supplier Name:</strong> <?php echo $title; ?><br>
						</div>
					</td>
					<td style="width: 40%; text-align: right;">
						<strong>Printed at:</strong> <?php echo date("d F, Y h:i A", time()); ?>
					</td>
				</tr>
			</table>
		</div>

		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Type</th>
					<th>Invoice Number</th>
					<th>Invoice Date</th>
					<th>Total Amount</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$count = 1;
				foreach ($suppliers_invoices as $suppliers_invoice) : ?>


					<tr>
						<td><?php echo $count++; ?></td>
						<td>
							<?php if ($suppliers_invoice->return_receipt == 1) {
								echo "Return";
							}
							?>
						</td>
						<td><?php echo $suppliers_invoice->supplier_invoice_number; ?> </td>
						<td><?php echo date('d M, Y', strtotime($suppliers_invoice->invoice_date)); ?> </td>
						<td><?php
							$query = "SELECT  ROUND(SUM( `inventory`.`item_cost_price`*`inventory`.`inventory_transaction`),2) AS total 
									        FROM   `inventory` WHERE `inventory`.`supplier_invoice_id`='" . $suppliers_invoice->supplier_invoice_id . "';";
							$total_amount = $this->db->query($query)->result()[0]->total;
							echo $total_amount; ?> </td>


					</tr>


				<?php endforeach; ?>
				<tr>
					<th colspan="4" style="text-align: right;">Total</th>
					<th>
						<?php
						$query = "SELECT  ROUND(SUM( `inventory`.`item_cost_price`*`inventory`.`inventory_transaction`),2) AS total 
									        FROM   `inventory` WHERE `inventory`.`supplier_id`='" . $suppliers_invoice->supplier_id . "';";
						$total_amount = $this->db->query($query)->result()[0]->total;
						echo $total_amount; ?>
					</th>
				</tr>
			</tbody>
		</table>
		<div class="footer text-right">
			<?php
			$query = "SELECT `roles`.`role_title`, `users`.`userTitle`  
				  FROM `roles`, `users` 
				  WHERE `roles`.`role_id` = `users`.`role_id`
				  AND `users`.`user_id`='" . $this->session->userdata('user_id') . "'";
			$user_data = $this->db->query($query)->result()[0];
			?>
			<p>
				<strong><?php echo $user_data->userTitle; ?> <?php echo $user_data->role_title; ?></strong><br>
				<?php echo $this->session->userdata("business_name"); ?>
			</p>
		</div>
	</page>
</body>

</html>
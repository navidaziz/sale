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
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/"); ?>/css/cloud-admin.css" media="screen,print" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/"); ?>/css/themes/default.css" media="screen,print" id="skin-switcher" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/"); ?>/css/responsive.css" media="screen,print" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/"); ?>/css/custom.css" media="screen,print" />


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
      font-size: 12px !important;
    }
  </style>
</head>

<body>
  <page size='A4'>
    <div style="padding: 5px;  padding-left:20px; padding-right:20px; " contenteditable="true">
      <h3 style="text-align: center;"> <?php echo $this->session->userdata("business_name"); ?> </h3>
      <h4 style="text-align: center;">Yearly and Monthly Report</h4>



      <table class="table table-bordered" id="year_month_wise_report">
        <thead>
          <tr>
            <th>#</th>
            <th>Year</th>
            <th>Month</th>
            <th>Total Sale</th>
            <th>Items Amount</th>
            <th>Profit</th>
            <th>Expenses</th>
            <th>Net Income</th>

            <th>Items Payments</th>
            <th>Item Cash In Hand</th>
            <th>Liabilities Payment</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $count = 1;
          $total_sale = 0.00;
          $total_profit = 0.00;
          $total_expense = 0.00;
          $net_profit_total = 0.00;

          foreach ($year_month_sales as $report) {
            $sale   = round($report->item_sale_total, 2);
            $cost   = round($report->item_cost_total, 2);
            $profit = $sale - $cost;

            $total_sale   += $sale;
            $total_profit += $profit;

            // Get total expenses for this year & month
            $query = "
                SELECT SUM(expense_amount) AS total_expense
                FROM expenses 
                WHERE YEAR(expense_date) = " . (int)$report->sale_year . "
                  AND MONTH(expense_date) = " . (int)$report->sale_month . "
            ";
            $expense = $this->db->query($query)->row()->total_expense;
            $expense = $expense ? $expense : 0.00;

            $total_expense += $expense;
            $net_profit = $profit - $expense;
            $net_profit_total += $net_profit;

            // Row-wise margin
            $row_margin = ($sale > 0) ? round(($profit / $sale) * 100, 2) : 0;
          ?>
            <tr>
              <td><?php echo $count++; ?></td>
              <td><?php echo $report->sale_year; ?></td>
              <td><?php echo date("F", mktime(0, 0, 0, $report->sale_month, 1)); ?></td>
              <td><?php echo number_format($sale, 2); ?></td>
              <td><?php echo number_format($cost, 2); ?></td>
              <td>
                <?php echo number_format($profit, 2); ?>
                <br>
                <small>Margin ≈ <?php echo $row_margin; ?> %</small>
              </td>
              <td><?php echo number_format($expense, 2); ?></td>
              <td><?php echo number_format($net_profit, 2); ?></td>
              <th><?php
                  $query = "SELECT SUM(amount) AS paid_amount FROM supplier_payments 
                WHERE  YEAR(payment_date) = " . (int)$report->sale_year . "
                  AND MONTH(payment_date) = " . (int)$report->sale_month . "
                  AND payment_of = 'Purchase'";
                  echo $item_paid_amount = $this->db->query($query)->row()->paid_amount;
                  ?></th>
              <th><?php echo $cost - $item_paid_amount; ?></th>
              <th>

                <?php
                $query = "SELECT SUM(amount) AS paid_amount FROM supplier_payments 
                WHERE  YEAR(payment_date) = " . (int)$report->sale_year . "
                  AND MONTH(payment_date) = " . (int)$report->sale_month . "
                  AND payment_of = 'Liabilities'";
                echo $this->db->query($query)->row()->paid_amount;
                ?></th>
            </tr>
          <?php } ?>

          <tr>
            <th colspan="3" style="text-align: right;">Total (Rs)</th>
            <th><?php echo number_format($total_sale, 2); ?></th>
            <th><?php echo number_format($total_sale - $total_profit, 2); ?></th>

            <th>
              <?php echo number_format($total_profit, 2); ?>
              <br />
              <small>
                <?php
                $profit_margin = ($total_sale > 0) ? ($total_profit / $total_sale) * 100 : 0;
                echo 'Margin ≈ ' . round($profit_margin, 2) . ' %';
                ?>
              </small>
            </th>
            <th><?php echo number_format($total_expense, 2); ?></th>
            <th><?php echo number_format($net_profit_total, 2); ?></th>
            <th></th>
            <th></th>
          </tr>
        </tbody>
      </table>


      <br />

      <br />
      <?php

      $query = "SELECT
                  `roles`.`role_title`,
                  `users`.`userName`  
              FROM `roles`,
              `users` 
              WHERE `roles`.`role_id` = `users`.`role_id`
              AND `users`.`user_id`='" . $this->session->userdata('user_id') . "'";
      $user_data = $this->db->query($query)->result()[0];
      ?> </p>

      <p class="divFooter" style="text-align: right;"><b><?php echo $user_data->userName; ?> <?php echo $user_data->role_title; ?></b>
        <br /><?php echo $this->session->userdata("business_name"); ?> <br />
        <strong>Printed at: <?php echo date("d, F, Y h:i:s A", time()); ?></strong>
      </p>


    </div>

  </page>
</body>



</html>
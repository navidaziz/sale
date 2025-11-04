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
            <th>Month<br><small>Opening Balance</small></th>
            <th>Total Sale</th>
            <th>Item Cost<br><small>(Paid / Unpaid / Total Paid)</small></th>
            <th>Gross Profit<br><small>(Margin %)</small></th>
            <th>Expenses</th>
            <th>Net Income</th>
            <th>Item Payments</th>
            <th>Item Cash In Hand</th>
            <th>Liabilities Paid</th>
          </tr>
        </thead>

        <tbody>
          <!-- Loop through $year_month_sales -->
          <!-- Each row reflects sales data for a month -->
          <?php
          $business_id = (int) $this->session->userdata('business_id');

          // Fetch year-month wise sales summary
          $sql = "
            SELECT
                YEAR(si.created_date) AS sale_year,
                MONTH(si.created_date) AS sale_month,
                SUM(si.cost_price * si.sale_items) AS item_cost_total,
                SUM(si.sale_price * si.sale_items) AS item_sale_total
            FROM sales_items AS si
            WHERE si.business_id = ?
            GROUP BY YEAR(si.created_date), MONTH(si.created_date)
            ORDER BY sale_year, sale_month
            ";

          $query = $this->db->query($sql, [$business_id]);
          $year_month_sales = $query->result();

          $count = 1;
          $total_sale = $total_profit = $total_expense = $net_profit_total = 0.00;

          $count = 1;
          foreach ($year_month_sales as $report): ?>
            <?php
            $sale = round($report->item_sale_total, 2);
            $cost = round($report->item_cost_total, 2);
            $profit = $sale - $cost;
            $margin = $sale > 0 ? round(($profit / $sale) * 100, 2) : 0;

            $expense = (float) $this->db->query("
          SELECT SUM(expense_amount) AS total_expense
          FROM expenses
          WHERE YEAR(expense_date) = {$report->sale_year}
          AND MONTH(expense_date) = {$report->sale_month}
          AND business_id = {$business_id}
        ")->row()->total_expense ?: 0;

            $net_income = $profit - $expense;

            $openning_balance = (float) $this->db->query("
          SELECT openning_balance 
          FROM openning_balance 
          WHERE YEAR(date) = {$report->sale_year}
          AND MONTH(date) = {$report->sale_month}
          AND business_id = {$business_id}
        ")->row()->openning_balance ?: 0;

            $item_paid = (float) $this->db->query("
          SELECT SUM(amount) AS paid_amount
          FROM supplier_payments
          WHERE YEAR(payment_date) = {$report->sale_year}
          AND MONTH(payment_date) = {$report->sale_month}
          AND payment_of = 'Purchase'
          AND business_id = {$business_id}
        ")->row()->paid_amount ?: 0;

            $overall_paid = (float) $this->db->query("
          SELECT SUM(amount) AS paid_amount
          FROM supplier_payments
          WHERE YEAR(payment_date) = {$report->sale_year}
          AND MONTH(payment_date) = {$report->sale_month}
          AND business_id = {$business_id}
        ")->row()->paid_amount ?: 0;

            $liabilities_paid = (float) $this->db->query("
          SELECT SUM(amount) AS paid_amount
          FROM supplier_payments
          WHERE YEAR(payment_date) = {$report->sale_year}
          AND MONTH(payment_date) = {$report->sale_month}
          AND payment_of = 'Liabilities'
          AND business_id = {$business_id}
        ")->row()->paid_amount ?: 0;

            $cash_in_hand = $cost - $item_paid;
            ?>
            <tr>
              <td><?= $count++; ?></td>
              <td><?= $report->sale_year; ?></td>
              <td>
                <?= date("F", mktime(0, 0, 0, $report->sale_month, 1)); ?><br>
                <small><?= number_format($openning_balance, 2); ?></small>
              </td>
              <td><?= number_format($sale, 2); ?></td>
              <td>
                <?= number_format($cost, 2); ?><br>
                <small>
                  <?= number_format($item_paid, 2); ?> /
                  <?= number_format($cash_in_hand, 2); ?> /
                  <?= number_format($overall_paid, 2); ?>
                </small>
              </td>
              <td>
                <?= number_format($profit, 2); ?><br>
                <small>≈ <?= $margin; ?>%</small>
              </td>
              <td><?= number_format($expense, 2); ?></td>
              <td><?= number_format($net_income, 2); ?></td>
              <td><?= number_format($item_paid, 2); ?></td>
              <td><?= number_format($cash_in_hand, 2); ?></td>
              <td><?= number_format($liabilities_paid, 2); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>

        <!-- Footer Totals -->
        <tfoot>
          <?php
          // You can calculate totals and assign them as variables
          $total_sale = $total_item_cost = $total_item_paid = $total_cash_in_hand = $total_net_income = $total_liabilities = 0;
          foreach ($year_month_sales as $r) {
            // Accumulate totals...
          }
          ?>
          <tr style="font-weight: bold; background: #f9f9f9;">
            <td colspan="3">TOTAL</td>
            <td><?= number_format($total_sale, 2); ?></td>
            <td><?= number_format($total_item_cost, 2); ?></td>
            <td colspan="2"></td>
            <td><?= number_format($total_net_income, 2); ?></td>
            <td><?= number_format($total_item_paid, 2); ?></td>
            <td><?= number_format($total_cash_in_hand, 2); ?></td>
            <td><?= number_format($total_liabilities, 2); ?></td>
          </tr>
        </tfoot>
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
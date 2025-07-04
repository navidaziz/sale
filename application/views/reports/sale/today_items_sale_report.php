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
      <h4 style="text-align: center;">Daily Sale Report ( Date: <?php echo date("d F, Y ", time()) ?>)</h4>

      <h5>Today Item Sale</h5>

      <table class="table table-bordered" id="today_categories_wise_report">
        <thead>

          <tr>
            <th>#</th>
            <th>Item Name</th>
            <th>Cost Price</th>
            <th>Unit Price</th>
            <th>Discount</th>
            <th>Sale Price</th>
            <th>Qyt</th>
            <th>Net Total</th>
            <th>Profit</th>
          </tr>

        </thead>
        <tbody>

          <?php
          $count = 1;
          foreach ($today_items_sales as $report) { ?>
            <tr>
              <td><?php echo $count++; ?></td>
              <td><?php echo $report->item_name; ?></td>
              <td><?php echo $report->cost_price; ?></td>
              <td><?php echo $report->unit_price; ?></td>
              <td><?php echo $report->item_discount; ?></td>
              <td><?php echo $report->sale_price; ?></td>
              <td><?php echo $report->qty; ?></td>
              <td><?php echo round($report->net_total, 2); ?></td>
              <td><?php
                  if ($report->qty > 0) { ?>
                  <?php echo round($report->net_total - ($report->cost_price * $report->qty), 2); ?>
                <?php } else { ?>
                  <span style="color:red">
                    <?php echo round($report->net_total - ($report->cost_price * $report->qty), 2); ?> R
                  </span>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>


          <tr>
            <?php
            $query = "SELECT  
                      SUM(si.total_price) as net_total,
                      SUM(si.cost_price*si.sale_items) as cost_items_total 
                      FROM `sales_items` as si 
                      WHERE DATE(`created_date`) = DATE(NOW())";
            $today_items_sale = $this->db->query($query);

            ?>
            <th colspan="7" style="text-align: right;">Total (Rs)</th>
            <th><?php

                if ($today_items_sale) {
                  echo round($today_items_sale->result()[0]->net_total, 2);
                }
                ?></th>

            <th><?php

                if ($today_items_sale) {
                  echo round($today_items_sale->result()[0]->net_total - $today_items_sale->result()[0]->cost_items_total, 2);
                }
                ?></th>
          </tr>



        </tbody>
      </table>

      <?php if ($today_sale_summary->items_price != $today_items_sale->result()[0]->net_total) { ?>
        <div class="alert alert-danger">Some Thing Wrong.</div>
      <?php } ?>






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
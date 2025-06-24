<table class="table ">
    <tr>
        <th>#</th>
        <th>Sale ID</th>
        <th>Date</th>
        <th>Total Amount (Rs)</th>
        <th>Receipts</th>
    </tr>
    <?php
    $count = 1;
    foreach ($sales as $sale) { ?>
        <tr>
            <td><?php echo $count++ ?></td>
            <td><?php echo $sale->sale_id ?></td>
            <td>
                <small><?php echo date("dM,y", strtotime($sale->created_date)) ?></small>
            </td>
            <td><?php echo $sale->total_payable; ?></td>
            <td><a href="javascript: return 0;" onclick="search_by_receipt_no('<?php echo $sale->sale_id ?>')">Receipt</a></td>
        </tr>
    <?php } ?>

</table>
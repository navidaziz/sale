<?php $this->load->view("sale_point/recepit");  ?>
<div style="margin: 5px; text-align: center;">
    <a target="new" href="<?php echo site_url("sale_point/print_receipt/" . $sale->sale_id) ?>">Print Receipt</a>
</div>
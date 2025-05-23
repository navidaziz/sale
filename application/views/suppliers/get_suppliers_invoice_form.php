<form id="suppliers_invoices" class="form-horizontal" enctype="multipart/form-data" method="post">
    <input type="hidden" name="supplier_invoice_id" value="<?php echo $input->supplier_invoice_id; ?>" />
    <input type="hidden" required id="business_id" name="business_id" value="<?php echo $input->business_id; ?>" class="form-control">
    <input type="hidden" required id="supplier_id" name="supplier_id" value="<?php echo $input->supplier_id; ?>" class="form-control">

    <div class="form-group row">
        <label for="return_receipt" class="col-sm-4 col-form-label">Invoice Type</label>
        <div class="col-sm-8">

            <input class="form-check-input" type="radio" name="return_receipt" id="stock_in_invoice" value="1" <?php if ($input->return_receipt == 1) {
                                                                                                                    echo 'checked';
                                                                                                                } ?>>
            <label class="form-check-label" for="stock_in_invoice">Stock In Invoice</label>
            <span class="ml-3"></span>
            <input class="form-check-input" type="radio" name="return_receipt" id="return_receipt" value="0" <?php if ($input->return_receipt == 0) {
                                                                                                                    echo 'checked';
                                                                                                                } ?>>
            <label class="form-check-label" for="return_receipt">Return Receipt</label>

        </div>
    </div>

    <div class="form-group row">
        <label for="supplier_invoice_number" class="col-sm-4 col-form-label">Supplier Invoice Number</label>
        <div class="col-sm-8">
            <input type="text" required id="supplier_invoice_number" name="supplier_invoice_number" value="<?php echo $input->supplier_invoice_number; ?>" class="form-control">
        </div>
    </div>

    <div class="form-group row">
        <label for="invoice_date" class="col-sm-4 col-form-label">Invoice Date</label>
        <div class="col-sm-8">
            <input type="date" required id="invoice_date" name="invoice_date" value="<?php echo $input->invoice_date; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="transport_cost" class="col-sm-4 col-form-label">Transport Cost</label>
        <div class="col-sm-8">
            <input type="text" required id="transport_cost" name="transport_cost" value="<?php echo $input->transport_cost; ?>" class="form-control">
        </div>
    </div>


    <div class="form-group row" style="text-align:center">
        <div id="result_response"></div>
        <?php if ($input->supplier_invoice_id == 0) { ?>
            <button type="submit" class="btn btn-primary">Add Invoice / Receipt</button>
        <?php } else { ?>
            <button type="submit" class="btn btn-primary">Update Invoice / Receipt</button>
        <?php } ?>
    </div>
</form>
</div>

<script>
    $('#suppliers_invoices').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url("suppliers/add_suppliers_invoice"); ?>', // URL to submit form data
            data: formData,
            success: function(response) {
                // Display response
                if (response == 'success') {
                    location.reload();
                } else {
                    $('#result_response').html(response);
                }

            }
        });
    });
</script>
<form id="supplier_payments" class="form-horizontal" enctype="multipart/form-data" method="post">
    <input type="hidden" name="payment_id" value="<?php echo $input->payment_id; ?>" />
    <input type="hidden" required id="business_id" name="business_id" value="<?php echo $input->business_id; ?>" class="form-control">
    <input type="hidden" required id="supplier_id" name="supplier_id" value="<?php echo $input->supplier_id; ?>" class="form-control">

    <div class="form-group row">
        <label for="payment_date" class="col-sm-4 col-form-label">Payment Date</label>
        <div class="col-sm-8">
            <input type="date" required id="payment_date" name="payment_date" value="<?php echo $input->payment_date; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label for="payment_mode" class="col-sm-4 control-label">Payment Mode</label>
        <div class="col-sm-8">
            <select id="payment_mode" name="payment_mode" class="form-control" required>
                <option value="">-- Select Payment Mode --</option>
                <option value="Cash" <?php echo ($input->payment_mode == 'Cash') ? 'selected' : ''; ?>>Cash</option>
                <option value="Bank Transfer" <?php echo ($input->payment_mode == 'Bank Transfer') ? 'selected' : ''; ?>>Bank Transfer</option>
                <option value="Cheque" <?php echo ($input->payment_mode == 'Cheque') ? 'selected' : ''; ?>>Cheque</option>
                <option value="Other" <?php echo ($input->payment_mode == 'Other') ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="payment_of" class="col-sm-4 col-form-label">Payment Of</label>
        <div class="col-sm-8">
            <input type="radio" required id="payment_of" name="payment_of" value="Liabilities" <?php echo ($input->payment_of == 'Liabilities') ? 'checked' : ''; ?>> Liabilities
            <input type="radio" required id="payment_of" name="payment_of" value="Purchase" <?php echo ($input->payment_of == 'Purchase') ? 'checked' : ''; ?>> Purchase

        </div>
    </div>
    <div class="form-group row">
        <label for="amount" class="col-sm-4 col-form-label">Amount</label>
        <div class="col-sm-8">
            <input type="text" required id="amount" name="amount" value="<?php echo $input->amount; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="reference_no" class="col-sm-4 col-form-label">Reference No</label>
        <div class="col-sm-8">
            <input type="number" required id="reference_no" name="reference_no" value="<?php echo $input->reference_no; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="remarks" class="col-sm-4 col-form-label">Remarks</label>
        <div class="col-sm-8">
            <input type="text" required id="remarks" name="remarks" value="<?php echo $input->remarks; ?>" class="form-control">
        </div>
    </div>


    <div class="form-group row" style="text-align:center">
        <div id="result_response"></div>
        <?php if ($input->payment_id == 0) { ?>
            <button type="submit" class="btn btn-primary">Add Payment</button>
        <?php } else { ?>
            <button type="submit" class="btn btn-primary">Update Payment</button>
        <?php } ?>
    </div>
</form>
</div>

<script>
    $('#supplier_payments').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url("suppliers/add_supplier_payment"); ?>', // URL to submit form data
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
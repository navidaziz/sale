<form id="payment_notesheet_schemes" class="form-horizontal" enctype="multipart/form-data" method="post">
    <input type="hidden" name="id" value="<?php echo $input->id; ?>" />
    <input type="hidden" name="scheme_id" value="<?php echo $input->scheme_id; ?>" />

    <?php
    $query = "SELECT * FROM schemes WHERE scheme_id = ?";
    $scheme = $this->db->query($query, $input->scheme_id)->row();

    ?>

    <h4>
        Scheme ID: <strong><?php echo $scheme->scheme_code; ?></strong><br />
        Scheme Name: <strong><?php echo $scheme->scheme_name; ?></strong><br />
    </h4>
    <table class="table table-bordered table-striped">
        <tr>
            <th>Estimated Cost</th>
            <th>Approved Cost</th>
            <th>Revised Cost</th>
            <th>Completion Cost</th>
            <th>Current Sanctioned Cost</th>
        </tr>
        <tr>
            <td><?php echo number_format($scheme->{'estimated_cost'}, 0); ?></td>
            <td><?php echo number_format($scheme->{'approved_cost'}, 0); ?></td>
            <td><?php echo number_format($scheme->{'revised_cost'}, 0); ?></td>
            <td><?php echo number_format($scheme->{'completion_cost'}, 0); ?></td>
            <td><?php echo number_format($scheme->{'sanctioned_cost'}, 0); ?></td>
        </tr>
    </table>
    <strong>Payment History</strong>
    <table class="table table-bordered table_small" id="wua_scheme_payment">
        <thead>

            <th>#</th>
            <th>Cat.</th>
            <th>Cheque</th>
            <th>Date</th>
            <th>Payee Name</th>
            <th>Gross Paid</th>
            <th>WHIT</th>
            <th>WHST</th>
            <th>St.Duty</th>
            <th>RDP</th>
            <th>KPRA</th>
            <th>GUR.RET.</th>
            <th>Misc.Dedu.</th>
            <th>Net Paid</th>
            <th>%</th>
            <th>Install.</th>
        </thead>
        <tbody>

            <?php
            $query = "SELECT
            e.payee_name,
            e.date,
            e.cheque, 
            e.gross_pay,
            e.whit_tax,
            e.whst_tax,
            e.st_duty_tax,
            e.rdp_tax,
            e.kpra_tax,
            e.gur_ret,
            e.misc_deduction,
            e.net_pay,
            e.installment,
            cc.category  
            FROM expenses as e 
            INNER JOIN component_categories as cc ON(cc.component_category_id = e.component_category_id)
                            WHERE scheme_id = $scheme->scheme_id";
            $expenses = $this->db->query($query)->result();

            $count = 1;
            foreach ($expenses as $expense) { ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $expense->category; ?></td>
                    <td><?php echo $expense->cheque; ?></td>
                    <td><?php echo date('d M, Y', strtotime($expense->date)); ?></td>
                    <td><small><i><?php echo $expense->payee_name; ?></i></small></td>
                    <td><?php echo number_format($expense->{'gross_pay'}, 0); ?></td>
                    <td><?php echo number_format($expense->{'whit_tax'}, 0); ?></td>
                    <td><?php echo number_format($expense->{'whst_tax'}, 0); ?></td>
                    <td><?php echo number_format($expense->{'st_duty_tax'}, 0); ?></td>
                    <td><?php echo number_format($expense->{'rdp_tax'}, 0); ?></td>
                    <td><?php echo number_format($expense->{'kpra_tax'}, 0); ?></td>
                    <td><?php echo number_format($expense->{'gur_ret'}, 0); ?></td>
                    <td><?php echo number_format($expense->{'misc_deduction'}, 0); ?></td>
                    <td><?php echo number_format($expense->{'net_pay'}, 0); ?></td>
                    <th><?php if ($scheme->sanctioned_cost) echo round(($expense->gross_pay * 100) / $scheme->sanctioned_cost, 2) . " %"   ?></th>
                    <th><?php echo $expense->installment; ?></th>
                </tr>
            <?php } ?>



        </tbody>
        <tfoot>
            <?php
            $query = "SELECT
                SUM(e.gross_pay) as gross_pay,
                SUM(e.whit_tax) as whit_tax,
                SUM(e.whst_tax) as whst_tax,
                SUM(e.st_duty_tax) as st_duty_tax,
                SUM(e.rdp_tax) as rdp_tax,
                SUM(e.kpra_tax) as kpra_tax,
                SUM(e.gur_ret) as gur_ret,
                SUM(e.misc_deduction) as misc_deduction,
                SUM(e.net_pay) as net_pay
                FROM expenses as e WHERE e.scheme_id = $scheme->scheme_id";
            $expenses_all = $this->db->query($query)->row();
            ?>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Total:</th>
                <th><?php echo number_format($expenses_all->{'gross_pay'}, 0); ?></th>
                <th><?php echo number_format($expenses_all->{'whit_tax'}, 0); ?></th>
                <th><?php echo number_format($expenses_all->{'whst_tax'}, 0); ?></th>
                <th><?php echo number_format($expenses_all->{'st_duty_tax'}, 0); ?></th>
                <th><?php echo number_format($expenses_all->{'rdp_tax'}, 0); ?></th>
                <th><?php echo number_format($expenses_all->{'kpra_tax'}, 0); ?></th>
                <th><?php echo number_format($expenses_all->{'gur_ret'}, 0); ?></th>
                <th><?php echo number_format($expenses_all->{'misc_deduction'}, 0); ?></th>
                <th><?php echo number_format($expenses_all->{'net_pay'}, 0); ?></th>
                <th><?php if ($scheme->sanctioned_cost) echo round(($expenses_all->gross_pay * 100) / $scheme->sanctioned_cost, 2) . " %"   ?></th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Sactioned Cost:</th>
                <th><?php echo number_format($scheme->{'sanctioned_cost'}, 0); ?></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Balance:</th>
                <th><?php
                    $balance = ($scheme->sanctioned_cost - $expenses_all->gross_pay);
                    echo number_format($balance, 0); ?></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
    </table>


    <?php
    $query = "SELECT pn.id, pn.payment_notesheet_code, 
            pn.puc_tracking_id, pn.puc_date, 
            pns.payment_type,
            pns.payment_amount
            FROM `payment_notesheet_schemes` as pns 
            INNER JOIN payment_notesheets as pn ON(pn.id = pns.payment_notesheet_id)
            WHERE scheme_id =? 
            AND pns.id != ?";
    $previous_pucs = $this->db->query($query, [$scheme->scheme_id, $input->id])->result();
    if ($previous_pucs) { ?>
        <div style="border: 1px solid gray; border-radius: 5px; padding: 5px; margin-bottom: 10px;">
            <strong>Previous PUCs</strong>
            <table class="table table-bordered table_small" id="wua_scheme_payment">
                <thead>
                    <th>#</th>
                    <th>PUC Code</th>
                    <th>PUC Tacking ID</th>
                    <th>PUC Date</th>
                    <th>Payment Type</th>
                    <th>Pay Amount</th>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($previous_pucs as $puc) { ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><a target="_blank" href="<?php echo site_url(ADMIN_DIR . 'payment_notesheets/print_payment_notesheet/' . $puc->id) ?>"><?php echo $puc->payment_notesheet_code; ?></a></td>
                            <td><?php echo $puc->puc_tracking_id; ?></td>
                            <td><?php echo date('d M, Y', strtotime($puc->puc_date)); ?></td>
                            <td><?php echo $puc->payment_type; ?></td>
                            <td><?php echo $puc->payment_amount; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>



    <table class="table table-bordered table_small" id="vendors_taxes" style="background-color: white;">
        <thead>
        </thead>
        <tbody>


            <tr>
                <th></th>
                <th>#</th>
                <th>Voucher ID</th>
                <th>Gross Total</th>
                <th>WHIT</th>
                <th>ST Charged</th>
                <th>WHST</th>
                <th>St.Duty</th>
                <th>RDP</th>
                <th>KPRA</th>
                <th>Misc.Dedu.</th>
                <th>Total Deduction</th>
            </tr>

            <?php
            $query = "SELECT voucher_id, SUM(`invoice_gross_total`) as invoice_gross_total,
                                        SUM(`whit_tax`) as whit_tax,
                                        SUM(`whst_tax`) as whst_tax,
                                        SUM(`st_charged`) as st_charged,
                                        SUM(`st_duty_tax`) as st_duty_tax,
                                        SUM(`rdp_tax`) as rdp_tax,
                                        SUM(`kpra_tax`) as kpra_tax,
                                        SUM(`misc_deduction`) as misc_deduction,
                                        SUM(`total_deduction`) as total_deduction
                                        FROM vendors_taxes 
                                        WHERE scheme_id = '" . $scheme->scheme_id . "'
                                        GROUP BY voucher_id";
            $rows = $this->db->query($query)->result();
            $count = 1;
            foreach ($rows as $row) { ?>
                <tr>
                    <td><input type="radio" value="<?php echo $row->voucher_id; ?>" name="voucher_id" /> </td>
                    <td><?php echo $count++; ?></td>
                    <th><?php echo $row->voucher_id; ?></th>
                    <td><?php echo number_format($row->invoice_gross_total, 2); ?></td>
                    <td><?php echo number_format($row->whit_tax, 2); ?></td>
                    <td><?php echo number_format($row->st_charged, 2); ?></td>
                    <td><?php echo number_format($row->whst_tax, 2); ?></td>
                    <td><?php echo number_format($row->st_duty_tax, 2); ?></td>
                    <td><?php echo number_format($row->rdp_tax, 2); ?></td>
                    <td><?php echo number_format($row->kpra_tax, 2); ?></td>
                    <td><?php echo number_format($row->misc_deduction, 2); ?></td>
                    <td><?php echo number_format($row->total_deduction, 2); ?></td>
                </tr>
            <?php } ?>




            <?php
            $query = "SELECT SUM(`invoice_gross_total`) as invoice_gross_total,
                                SUM(`whit_tax`) as whit_tax,
                                SUM(`whst_tax`) as whst_tax,
                                SUM(`st_charged`) as st_charged,
                                SUM(`st_duty_tax`) as st_duty_tax,
                                SUM(`rdp_tax`) as rdp_tax,
                                SUM(`kpra_tax`) as kpra_tax,
                                SUM(`misc_deduction`) as misc_deduction,
                                SUM(`total_deduction`) as total_deduction
                                FROM vendors_taxes
                                WHERE scheme_id = '" . $scheme->scheme_id . "'";
            $row = $this->db->query($query)->row(); ?>

            <tr>
                <th></th>
                <th></th>
                <th>Grand Total:</th>
                <th><?php echo number_format($row->invoice_gross_total, 2); ?></th>
                <th><?php echo number_format($row->whit_tax, 2); ?></th>
                <th><?php echo number_format($row->st_charged, 2); ?></th>
                <th><?php echo number_format($row->whst_tax, 2); ?></th>
                <th><?php echo number_format($row->st_duty_tax, 2); ?></th>
                <th><?php echo number_format($row->rdp_tax, 2); ?></th>
                <th><?php echo number_format($row->kpra_tax, 2); ?></th>
                <th><?php echo number_format($row->misc_deduction, 2); ?></th>
                <th><?php echo number_format($row->total_deduction, 2); ?></th>

            </tr>
        </tbody>
    </table>




    <?php
    $query = "SELECT COUNT(*) as total FROM expenses as e WHERE e.scheme_id = ? and e.installment = 'Final'";
    $final_count = $this->db->query($query, [$scheme->scheme_id])->row()->total;
    if ($final_count == 0) {
    ?>

        <div class="form-group row">
            <label for="payment_type" class="col-sm-4 col-form-label">Payment Type <span style="color: red;">*</span></label>
            <div class="col-sm-8">
                <?php
                $payment_type = array(
                    "ICR-I" => "ICR-I",
                    "ICR-II" => "ICR-II",
                    "ICR-I&II" => "ICR-I&II",
                    "FINAL" => "FINAL"
                );
                foreach ($payment_type as $key => $value): ?>

                    <input <?php if ($key == 'FINAL') { ?> onclick="$('#completion_cost').val('');$('#completion_cost_div').show();$('#completion_cost').attr('required', true);" <?php } else { ?> onclick="$('#completion_cost').val('');$('#completion_cost_div').hide();$('#completion_cost').attr('required', false);" <?php } ?> <?php if ($input->payment_type == $key) { ?> checked <?php } ?> class="form-check-input" type="radio" name="payment_type" id="payment_type_<?php echo $key; ?>" value="<?php echo $key; ?>">
                    <label class="form-check-label" style="margin-right: 10px;" for="payment_type_<?php echo $key; ?>">
                        <?php echo $value; ?>
                    </label>

                <?php endforeach; ?>
            </div>
        </div>








        <div class="form-group row" <?php if ($input->payment_type != 'FINAL') { ?> style="display: none;" <?php } ?> id="completion_cost_div">
            <label for="completion_cost" class="col-sm-4 col-form-label">Final Completion Cost <span style="color: red;">*</span></label>
            <div class="col-sm-8">
                <input <?php if ($input->payment_type == 'FINAL') { ?> required <?php } ?> min="0" max="<?php echo $scheme->sanctioned_cost; ?>" type="number" step="any" id="completion_cost" name="completion_cost" value="<?php echo $scheme->completion_cost; ?>" class="form-control">
            </div>
        </div>

        <table class="table table-bordered table_small">
            <thead>
                <tr>
                    <th>Gross Pay</th>
                    <th>WHIT</th>
                    <th>WHST</th>
                    <th>St.Duty</th>
                    <th>RDP</th>
                    <th>KPRA</th>
                    <th>GUR.RET.</th>
                    <th>Misc.Dedu.</th>
                    <th>Net Pay</th>
                </tr>
            </thead>
            <tbody>
                <tr>


                    <!-- WHIT Tax -->
                    <td>
                        <input onkeyup="calculateNetPay()" min="0" type="number" step="any" required id="whit_tax" name="whit_tax" value="<?php echo $input->whit_tax; ?>" class="form- control">
                    </td>

                    <!-- WHST Tax -->
                    <td>
                        <input onkeyup="calculateNetPay()" min="0" type="number" step="any" required id="whst_tax" name="whst_tax" value="<?php echo $input->whst_tax; ?>" class="form- control">
                    </td>

                    <!-- ST Duty Tax -->
                    <td>
                        <input onkeyup="calculateNetPay()" min="0" type="number" step="any" required id="st_duty_tax" name="st_duty_tax" value="<?php echo $input->st_duty_tax; ?>" class="form- control">
                    </td>

                    <!-- RDP Tax -->
                    <td>
                        <input onkeyup="calculateNetPay()" min="0" type="number" step="any" required id="rdp_tax" name="rdp_tax" value="<?php echo $input->rdp_tax; ?>" class="form- control">
                    </td>

                    <!-- KPRA Tax -->
                    <td>
                        <input onkeyup="calculateNetPay()" min="0" type="number" step="any" required id="kpra_tax" name="kpra_tax" value="<?php echo $input->kpra_tax; ?>" class="form- control">
                    </td>

                    <!-- Guaranteed Retirement -->
                    <td>
                        <input onkeyup="calculateNetPay()" min="0" type="number" step="any" required id="gur_ret" name="gur_ret" value="<?php echo $input->gur_ret; ?>" class="form- control">
                    </td>

                    <!-- Miscellaneous Deduction -->
                    <td>
                        <input onkeyup="calculateNetPay()" min="0" type="number" step="any" required id="misc_deduction" name="misc_deduction" value="<?php echo $input->misc_deduction; ?>" class="form- control">
                    </td>

                </tr>
            </tbody>
        </table>


        <div class="form-group row">
            <label for="payment_amount" class="col-sm-4 col-form-label">Payment Amount <span style="color: red;">*</span></label>
            <div class="col-sm-8">
                <input onkeyup="calculateNetPay()" min="0" type="number" step="any" required id="payment_amount" name="payment_amount" value="<?php echo $input->payment_amount; ?>" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="whit" class="col-sm-4 col-form-label">WHIT <span style="color: red;">*</span></label>
            <div class="col-sm-8">
                <input onkeyup="calculateNetPay()" min="0" type="number" step="any" required id="whit" name="whit" value="<?php echo $input->whit; ?>" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="whst" class="col-sm-4 col-form-label">WHST <span style="color: red;">*</span></label>
            <div class="col-sm-8">
                <input onkeyup="calculateNetPay()" min="0" type="number" step="any" required id="whst" name="whst" value="<?php echo $input->whst; ?>" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="net_pay" class="col-sm-4 col-form-label">Net Pay <span style="color: red;">*</span></label>
            <div class="col-sm-8">
                <input readonly type="number" min="0" required id="net_pay" name="net_pay" value="<?php echo $input->net_pay; ?>" class="form-control">
            </div>
        </div>
        <div class="form-group row" style="text-align:center">
            <div id="result_response"></div>
            <button type="submit" class="btn btn-primary">Update Data</button>
        </div>
    <?php } else { ?>
        <div class="alert alert-warning" style="text-align: center;">
            Scheme Final Payment Completed.
        </div>
    <?php } ?>
</form>

<script>
    function calculateNetPay() {

        const paymentAmount = parseFloat($('#payment_amount').val()) || 0;
        const whit = parseFloat($('#whit').val()) || 0;
        const whst = parseFloat($('#whst').val()) || 0;

        // Calculate net pay
        const netPay = paymentAmount - (whst + whit);
        $('#net_pay').val(netPay.toFixed(2));

    }
</script>


<script>
    $('#payment_notesheet_schemes').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(ADMIN_DIR . "payment_notesheets/add_payment_amount"); ?>', // URL to submit form data
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
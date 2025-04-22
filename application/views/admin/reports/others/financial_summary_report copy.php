<style>
.table_small>thead>tr>th,
.table_small>tbody>tr>th,
.table_small>tfoot>tr>th,
.table_small>thead>tr>td,
.table_small>tbody>tr>td,
.table_small>tfoot>tr>td {
    padding: 3px;
    line-height: 1;
    vertical-align: top;
    border-top: 1px solid #ddd;
    font-size: 12px !important;
    color: black;
    margin: 0px !important;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="box border blue" id="messenger">
            <div class="box-body">

                <div class="table-responsive">
                    <div style="text-align: center;">
                        <h4> Khyber Pakhtunkhwa, Irrigated Agriculture Improvement Project (KP-IAIP) P163474</h4>
                        <h5>FINANCIAL PROGRESS -REALTIME</h5>
                    </div>
                    <table class="table table_small table-bordered" id="real_time_summary">
                        <thead>



                        </thead>
                        <tbody>


                            <tr>
                                <th></th>
                                <th>FY</th>

                                <th>Net Paid</th>
                                <th>WHST</th>
                                <th>WHIT</th>
                                <th>KPRA</th>
                                <th>St.Duty</th>
                                <th>RDP</th>
                                <th>WHT</th>
                                <th>GUR.RET.</th>
                                <th>Misc.Dedu.</th>
                                <th>Deduction</th>
                                <th>Inclusive</th>
                                <th>Gross Paid</th>
                                <th>Reconciliation</th>
                                <th>Tax Paid</th>
                                <th>Remaining Taxes</th>
                            </tr>
                            <?php
                            $count = 1;
                                        $query = "SELECT 
                                    f.financial_year_id AS fy_id, -- ID of the financial year
                                    f.financial_year AS fy,        -- Name of the financial year
                                    f.status AS fy_status,         -- Status of the financial year
                                    SUM(e.net_pay) AS net_pay,    -- Total Net Paidment
                                    SUM(e.whit_tax) AS whit_tax,   -- Total withholding tax
                                    SUM(e.whst_tax) AS whst_tax,   -- Total withholding tax on salary
                                    SUM(e.st_duty_tax) AS st_duty_tax, -- Total stamp duty tax
                                    SUM(e.rdp_tax) AS rdp_tax,     -- Total RDP tax
                                    SUM(e.kpra_tax) AS kpra_tax,   -- Total KPRA tax
                                    SUM(e.gur_ret) AS gur_ret,     -- Total government retention
                                    SUM(e.misc_deduction) AS misc_deduction, -- Total miscellaneous deductions
                                    SUM(e.whit_tax + e.whst_tax + e.st_duty_tax + e.rdp_tax + e.kpra_tax + e.gur_ret + e.misc_deduction) AS deduction, -- Total deductions
                                    SUM(e.whit_tax + e.whst_tax + e.st_duty_tax + e.rdp_tax + e.kpra_tax + e.gur_ret + e.misc_deduction + e.net_pay) AS inclusive, -- Total including Net Paid
                                    SUM(e.gross_pay) AS gross_pay,  -- Total Gross Paidment
                                    SUM(e.whit_tax + e.whst_tax + e.st_duty_tax + e.rdp_tax + e.kpra_tax + e.gur_ret + e.misc_deduction + e.net_pay - e.gross_pay) AS reconciliation, -- Reconciliation of payments
                                    (
                                    SELECT SUM(ex.net_pay) 
                                    FROM expenses AS ex 
                                    WHERE ex.component_category_id IN (
                                    SELECT cat.component_category_id 
                                    FROM component_categories AS cat 
                                    WHERE cat.sub_component_id = 22
                                    ) 
                                    AND ex.financial_year_id = f.financial_year_id
                                    ) AS tax_paid, -- Total taxes paid for specific component categories

                                    SUM(e.whit_tax + e.whst_tax + e.st_duty_tax + e.rdp_tax + e.kpra_tax + e.gur_ret + e.misc_deduction) - (
                                    SELECT SUM(ex.net_pay) 
                                    FROM expenses AS ex 
                                    WHERE ex.component_category_id IN (
                                    SELECT cat.component_category_id 
                                    FROM component_categories AS cat 
                                    WHERE cat.sub_component_id = 22
                                    ) 
                                    AND ex.financial_year_id = f.financial_year_id
                                    ) AS remaining_taxes -- Remaining taxes after accounting for paid taxes

                                    FROM 
                                    expenses AS e 
                                    INNER JOIN 
                                    financial_years AS f ON f.financial_year_id = e.financial_year_id -- Joining expenses with financial years
                                    GROUP BY 
                                    f.financial_year_id; -- Grouping results by financial year ID, name, and status";
                                $total_taxes=0;
                            $f_years = $this->db->query($query)->result();
                            foreach ($f_years as $f_year) {  ?>
                            <tr <?php if ($f_year->fy_status == 1) { ?>
                                style="background-color:#CAF7B7; font-weight:bold;" <?php } ?>>
                                <th><?php echo $count++; ?></th>
                                <th nowrap>
                                    <?php echo $f_year->fy; ?><?php if ($f_year->fy_status == 1) { ?> *
                                    <?php } ?></th>

                                <td><?php if($f_year->net_pay>0){ echo number_format($f_year->net_pay, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->whst_tax>0){ echo number_format($f_year->whst_tax, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->whit_tax>0){ echo number_format($f_year->whit_tax, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->kpra_tax>0){ echo number_format($f_year->kpra_tax, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->st_duty_tax>0){ echo number_format($f_year->st_duty_tax, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->rdp_tax>0){ echo number_format($f_year->rdp_tax, 2); }else{ echo 0; }?>
                                </td>
                                <td></td>
                                <td><?php if($f_year->gur_ret>0){ echo number_format($f_year->gur_ret, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->misc_deduction>0){ echo number_format($f_year->misc_deduction, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->deduction>0){ echo number_format($f_year->deduction, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->inclusive>0){ echo number_format($f_year->inclusive, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->gross_pay>0){ echo number_format($f_year->gross_pay, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->reconciliation>0){ echo number_format($f_year->reconciliation, 2); }else{ echo 0; }?>
                                <td>
                                <td><?php if($f_year->tax_paid>0){ echo number_format($f_year->tax_paid, 2); }else{ echo 0; }?>
                                <td>
                                <td><?php if($f_year->misc_deduction>0){ echo number_format($f_year->remaining_taxes, 2); }else{ echo 0; }?>

                            </tr>

                            <?php } ?>

                        </tbody>
                        <tfoot>
                            <?php 
                               $count = 1;
                                        $query = "SELECT 
                                    SUM(e.net_pay) AS net_pay,    -- Total Net Paidment
                                    SUM(e.whit_tax) AS whit_tax,   -- Total withholding tax
                                    SUM(e.whst_tax) AS whst_tax,   -- Total withholding tax on salary
                                    SUM(e.st_duty_tax) AS st_duty_tax, -- Total stamp duty tax
                                    SUM(e.rdp_tax) AS rdp_tax,     -- Total RDP tax
                                    SUM(e.kpra_tax) AS kpra_tax,   -- Total KPRA tax
                                    SUM(e.gur_ret) AS gur_ret,     -- Total government retention
                                    SUM(e.misc_deduction) AS misc_deduction, -- Total miscellaneous deductions
                                    SUM(e.whit_tax + e.whst_tax + e.st_duty_tax + e.rdp_tax + e.kpra_tax + e.gur_ret + e.misc_deduction) AS deduction, -- Total deductions
                                    SUM(e.whit_tax + e.whst_tax + e.st_duty_tax + e.rdp_tax + e.kpra_tax + e.gur_ret + e.misc_deduction + e.net_pay) AS inclusive, -- Total including Net Paid
                                    SUM(e.gross_pay) AS gross_pay,  -- Total Gross Paidment
                                    SUM(e.whit_tax + e.whst_tax + e.st_duty_tax + e.rdp_tax + e.kpra_tax + e.gur_ret + e.misc_deduction + e.net_pay - e.gross_pay) AS reconciliation, -- Reconciliation of payments
                                    (
                                    SELECT SUM(ex.net_pay) 
                                    FROM expenses AS ex 
                                    WHERE ex.component_category_id IN (29) )AS tax_paid, -- Total taxes paid for specific component categories

                                    SUM(e.whit_tax + e.whst_tax + e.st_duty_tax + e.rdp_tax + e.kpra_tax + e.gur_ret + e.misc_deduction) - (
                                    SELECT SUM(ex.net_pay) 
                                    FROM expenses AS ex 
                                    WHERE ex.component_category_id IN (29)) AS remaining_taxes -- Remaining taxes after accounting for paid taxes

                                    FROM 
                                    expenses AS e -- Grouping results by financial year ID, name, and status";
                                
                            $f_year = $this->db->query($query)->row();
                            ?>
                            <tr>
                                <th></th>
                                <th nowrap>Total</th>

                                <td><?php if($f_year->net_pay>0){ echo number_format($f_year->net_pay, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->whst_tax>0){ echo number_format($f_year->whst_tax, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->whit_tax>0){ echo number_format($f_year->whit_tax, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->kpra_tax>0){ echo number_format($f_year->kpra_tax, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->st_duty_tax>0){ echo number_format($f_year->st_duty_tax, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->rdp_tax>0){ echo number_format($f_year->rdp_tax, 2); }else{ echo 0; }?>
                                </td>
                                <td></td>
                                <td><?php if($f_year->gur_ret>0){ echo number_format($f_year->gur_ret, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->misc_deduction>0){ echo number_format($f_year->misc_deduction, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->deduction>0){ echo number_format($f_year->deduction, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->inclusive>0){ echo number_format($f_year->inclusive, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->gross_pay>0){ echo number_format($f_year->gross_pay, 2); }else{ echo 0; }?>
                                </td>
                                <td><?php if($f_year->reconciliation>0){ echo number_format($f_year->reconciliation, 2); }else{ echo 0; }?>
                                <td>
                                <td><?php if($f_year->tax_paid>0){ echo number_format($f_year->tax_paid, 2); }else{ echo 0; }?>
                                <td>
                                <td><?php if($f_year->misc_deduction>0){ echo number_format($f_year->remaining_taxes, 2); }else{ echo 0; }?>

                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Taxpaid</td>
                                <th><?php  echo taxPaid('29') ?></th>
                                <th><?php  echo taxPaid('30') ?></th>
                                <th><?php  echo taxPaid('31') ?></th>
                                <th><?php  echo taxPaid('33') ?></th>
                                <th><?php  echo taxPaid('235') ?></th>
                                <th><?php  echo taxPaid('256') ?></th>
                                <th><?php  echo taxPaid('274') ?></th>
                                <th><?php  echo taxPaid('275') ?></th>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Tax Remaining</td>
                                <th><?php  echo str_replace(',', '',$f_year->whst_tax)-str_replace(',', '',taxPaid('29')); ?>
                                </th>
                                <th><?php  echo str_replace(',', '',$f_year->whit_tax)-str_replace(',', '',taxPaid('30')); ?>
                                </th>
                                <th><?php  echo str_replace(',', '',$f_year->kpra_tax)-str_replace(',', '',taxPaid('31')); ?>
                                </th>
                                <th><?php  echo str_replace(',', '',$f_year->st_duty_tax)-str_replace(',', '',taxPaid('33')); ?>
                                </th>
                                <th><?php  echo str_replace(',', '',$f_year->rdp_tax)-str_replace(',', '',taxPaid('235')); ?>
                                </th>
                                <th><?php  echo str_replace(',', '',taxPaid('256')); ?>
                                </th>
                                <th><?php  echo str_replace(',', '',$f_year->gur_ret)-str_replace(',', '',taxPaid('274')); ?>
                                </th>
                                <th><?php  echo str_replace(',', '',$f_year->misc_deduction)-str_replace(',', '',taxPaid('275')); ?>
                                </th>
                                <th><?php  echo str_replace(',', '',$f_year->deduction)-(taxPaid('275')+taxPaid('274')+taxPaid('256')+taxPaid('235')+taxPaid('33')+taxPaid('31')+taxPaid('30')+taxPaid('29')); ?>
                                </th>
                            </tr>
                            <?php $query='SELECT * FROM financial_years';
                            $fyears = $this->db->query($query)->result();
                            foreach($fyears as $fyear){ ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><?php echo $fyear->financial_year; ?></td>
                                <td><?php  echo taxPaid('29', $fyear->financial_year_id) ?></td>
                                <td><?php  echo taxPaid('30', $fyear->financial_year_id) ?></td>
                                <td><?php  echo taxPaid('31', $fyear->financial_year_id) ?></td>
                                <td><?php  echo taxPaid('33', $fyear->financial_year_id) ?></td>
                                <td><?php  echo taxPaid('235', $fyear->financial_year_id) ?></td>
                                <td><?php  echo taxPaid('256', $fyear->financial_year_id) ?></td>
                                <td><?php  echo taxPaid('274', $fyear->financial_year_id) ?></td>
                                <td><?php  echo taxPaid('275', $fyear->financial_year_id) ?></td>
                                <td><?php  echo taxPaid('29', $fyear->financial_year_id)+taxPaid('30', $fyear->financial_year_id)+taxPaid('31', $fyear->financial_year_id)+taxPaid('33', $fyear->financial_year_id)+taxPaid('235', $fyear->financial_year_id)+taxPaid('256', $fyear->financial_year_id)+taxPaid('275', $fyear->financial_year_id)+taxPaid('274', $fyear->financial_year_id)+taxPaid('275', $fyear->financial_year_id) ?>
                                </td>
                            </tr>
                            <?php } ?>




                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>


</div>

<?php 

function taxPaid($tax_id, $f_year_id=NULL) {
    $CI = &get_instance();
    $query="SELECT SUM(net_pay) as tax_paid FROM expenses as e 
                                            WHERE e.component_category_id='".$tax_id."'";
    if($f_year_id){
        $query.=" AND financial_year_id ='".$f_year_id."' ";
    }                                        
    $tax_paid = $CI->db->query($query)->row(); 
    if ($tax_paid) {
        if($tax_paid->tax_paid){
            return number_format($tax_paid->tax_paid,2);
        }else{
            return (double) 0.00;
        }
        
    } else {
        return (double) 0.00;
    }
}

function tax_paid($tax_head) {
// Get the CI instance to access the database
$CI = &get_instance();

// Build and execute the query
$query = "SELECT SUM(net_pay) as tax_paid FROM `expenses` as e
INNER JOIN component_categories as cc
ON cc.component_category_id = e.component_category_id
WHERE cc.category = ?";
$taxPaid = $CI->db->query($query, array($tax_head))->row();

// Return the result or 0.00 if not found
if ($taxPaid) {
return $taxPaid->tax_paid;
} else {
return 0.00;
}
}
?>
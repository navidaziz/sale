<style>
    .table_small>thead>tr>th,
    .table_small>tbody>tr>th,
    .table_small>tfoot>tr>th,
    .table_small>thead>tr>td,
    .table_small>tbody>tr>td,
    .table_small>tfoot>tr>td {
        padding: 4px;
        line-height: 1;
        vertical-align: top;
        border-top: 1px solid #ddd;
        font-size: 10px !important;
        color: black;
        margin: 0px !important;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <!-- STYLER -->

            <!-- /STYLER -->
            <!-- BREADCRUMBS -->
            <ul class="breadcrumb">
                <li>
                    <i class="fa fa-home"></i>

                    <a
                        href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
                </li>
                <li>
                    <i class="fa fa-list"></i>

                    <a href="<?php echo site_url(ADMIN_DIR . "/expenses"); ?>">Expenses Dashboard</a>
                </li>

                <li><?php echo $title; ?></li>
            </ul>
            <!-- /BREADCRUMBS -->
            <div class="row">

                <div class="col-md-4">
                    <div class="clearfix">

                        <h3 class="content-title pull-left"><?php echo $title ?></h3>
                    </div>
                    <div class="description"> <?php echo $description; ?></div>
                </div>

                <div class="col-md-8">

                </div>

            </div>


        </div>
    </div>
</div>

<div class="table-responsive" style=" overflow-x:auto;">

    <h4>Remaining Cheques</h4>
    <hr />
    <table class="table table-bordered table_small" id="db_table">
        <thead>
            <th>#</th>
            <th class="region">Region</th>
            <th class="district">District</th>
            <th class="category">Component Category</th>
            <th>Category Detail</th>
            <th class="purpose">Purpose</th>
            <th>WUA Reg.</th>
            <th>WUA Asso.</th>
            <th>Scheme</th>
            <th>FY</th>
            <th>Voucher Number</th>
            <th>Cheque</th>
            <th class="date">Date</th>
            <th>Payee Name</th>
            <th>Scheme Reference</th>
            <th>Gross Paid</th>
            <th>WHIT</th>
            <th>WHST</th>
            <th>KPRA</th>
            <th>St.Duty</th>
            <th>RDP</th>
            <th>GUR.RET.</th>
            <th>Misc.Dedu.</th>
            <th>Net Paid</th>
            <th>Installment</th>
        </thead>
        <tbody>
            <?php $count = 1;
            $query = "SELECT  
            e.*, 
            e.SchemeName as scheme_name_ref,
            fy.financial_year, 
            cc.category, 
            cc.category_detail, 
            s.scheme_name,
            s.scheme_code,
            wua.wua_registration_no,
            wua.wua_name,
            d.district_name, 
            d.region  
            FROM 
            expenses AS e
            INNER JOIN 
            financial_years AS fy ON fy.financial_year_id = e.financial_year_id
            INNER JOIN 
            districts AS d ON d.district_id = e.district_id
            LEFT JOIN 
            component_categories AS cc ON cc.component_category_id = e.component_category_id
            LEFT JOIN schemes AS s ON(s.scheme_id = e.scheme_id)
            LEFT JOIN water_user_associations as wua on(wua.water_user_association_id = s.water_user_association_id)
            WHERE e.scheme_id IS NULL AND e.component_category_id IN (1,2,3,4,5,6,7,8,9,10,11,12) 
            LIMIT 500
            ";

            if ($district_id) {
                $query .= " AND e.district_id = $district_id";
            }
            $expenses = $this->db->query($query)->result();

            foreach ($expenses as $expense) : ?>
                <tr>

                    <td><?php echo $count++; ?></td>
                    <td class="region"><?php echo $expense->region; ?></td>
                    <td class="district"><?php echo $expense->district_name; ?></td>
                    <td class="category"><?php echo $expense->category; ?></td>
                    <td><?php echo $expense->category_detail; ?></td>
                    <td class="purpose"><?php echo $expense->purpose; ?></td>
                    <td><?php echo $expense->wua_registration_no; ?></td>
                    <td><?php echo $expense->wua_name; ?></td>
                    <td><?php echo $expense->scheme_name; ?></td>
                    <td><?php echo $expense->financial_year; ?></td>
                    <td><?php echo $expense->voucher_number; ?></td>
                    <td><?php echo $expense->cheque; ?></td>
                    <td class="date"><?php echo date('d-m-Y', strtotime($expense->date)); ?>
                    </td>
                    <td><small><i><?php echo $expense->payee_name; ?></i></small></td>
                    <td><small><i><?php echo $expense->scheme_name_ref; ?></i></small></td>
                    <td><?php echo $expense->gross_pay != 0 ? number_format($expense->gross_pay, 2) : 0; ?>
                    </td>
                    <td><?php echo $expense->whit_tax != 0 ? number_format($expense->whit_tax, 2) : 0; ?>
                    </td>
                    <td><?php echo $expense->whst_tax != 0 ? number_format($expense->whst_tax, 2) : 0; ?>
                    </td>
                    <td><?php echo $expense->kpra_tax != 0 ? number_format($expense->kpra_tax, 2) : 0; ?>
                    </td>
                    <td><?php echo $expense->st_duty_tax != 0 ? number_format($expense->st_duty_tax, 2) : 0; ?>
                    </td>
                    <td><?php echo $expense->rdp_tax != 0 ? number_format($expense->rdp_tax, 2) : 0; ?>
                    </td>
                    <td><?php echo $expense->gur_ret != 0 ? number_format($expense->gur_ret, 2) : 0; ?>
                    </td>
                    <td><?php echo $expense->misc_deduction != 0 ? number_format($expense->misc_deduction, 2) : 0; ?>
                    </td>
                    <td><?php echo $expense->net_pay != 0 ? number_format($expense->net_pay, 2) : 0; ?>
                    </td>
                    <td><?php echo $expense->installment; ?>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        title = "Remaining Cheques List";
        $(document).ready(function() {
            $('#db_table').DataTable({
                dom: 'Bfrtip',
                paging: false,
                title: title,
                "order": [],
                "ordering": true,
                searching: true,
                buttons: [

                    {
                        extend: 'print',
                        title: title,
                        messageTop: ''

                    },
                    {
                        extend: 'excelHtml5',
                        title: title,
                        messageTop: ''

                    },
                    {
                        extend: 'pdfHtml5',
                        title: title,
                        pageSize: 'A4',
                        orientation: 'landscape',
                        messageTop: ''

                    }
                ]
            });
        });
    </script>
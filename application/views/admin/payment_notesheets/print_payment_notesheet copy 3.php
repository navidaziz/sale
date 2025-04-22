<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>
        SC: <?php echo $scheme->scheme_code; ?>
    </title>
    <link rel="stylesheet" href="style.css">
    <link rel="license" href="http://www.opensource.org/licenses/mit-license/">
    <script src="script.js"></script>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.24.0/dist/bootstrap-table.min.css">

    <style>
        body {
            background: rgb(204, 204, 204);

            font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;

        }



        element.style {
            color: black;
            font-weight: bold;
        }


        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);

        }

        /* Styles go here */
        @media screen {


            page[size="A4"] {
                width: 100%;
                /* height: 29.7cm; */
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

        }

        @media print {

            body,
            page {
                margin: 0;
                box-shadow: 0;
                color: black;

            }



        }




        /* Styles go here */
        @media screen {
            .print-page-header {
                height: auto;
                display: none;
            }
        }




        @media screen {
            .page-footer {
                height: 25px;
                display: none;
            }
        }



        @media print {
            .page-footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                border-top: 1px solid gray;
                /* for demo */
                content: counter(page) " of " counter(pages);
                /* for demo */
            }

            .page-footer-space {
                height: 80px;

            }
        }

        @media screen {
            .page-footer {
                position: relative;

                width: 100%;
                border-top: 1px solid gray;
                /* for demo */
                display: block;
                /* for demo */
            }

            .page-footer-space {
                height: 80px;
                display: none;
            }
        }

        @media print {
            .print-page-header {
                position: fixed;
                top: 0mm;
                width: 100%;
                background: yellow;
                /* for demo */
                /* for demo */
            }

            .print-page-header-space {
                height: 90px;
            }
        }

        @media screen {
            .print-page-header {
                position: relative;
                top: 0mm;
                width: 100%;
                display: block;
                /* for demo */
                /* for demo */
            }

            .print-page-header-space {
                height: 0px;
                display: none;
            }
        }




        .page {
            page-break-after: always;
        }



        @page {
            margin-top: 5mm;
        }

        @media print {
            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

            button {
                display: none;
            }

            body {
                margin: 0;
                background-color: white !important;
            }

            page {
                background: white;
                display: block;
                margin: 0 auto;
                margin-bottom: 0.5cm;
                box-shadow: none !important;

            }
        }
    </style>
    <style>
        .table_small>thead>tr>th,
        .table_small>tbody>tr>th,
        .table_small>tfoot>tr>th,
        .table_small>thead>tr>td,
        .table_small>tbody>tr>td,
        .table_small>tfoot>tr>td {
            padding: 2px;
            line-height: 1;
            vertical-align: top;
            border-top: 1px solid #ddd;
            font-size: 12px !important;
            color: black;
            margin: 0px !important;
            border-color: black;
        }
    </style>
</head>

<body>
    <page size='A4'>



        <div>
            <table style="width: 100%;">
                <tr>
                    <td></td>
                    <td>
                        <h4 style="text-align: center;">DIRECTORATE GENERAL ON FARM WATERMANAGEMENT</h4>
                        <p style="text-align: center; font-size:10px">
                            (Wing of Agri. Department) Govt. of Khyber Pakhtunkhwa<br />
                            19-Jamrud Road, ATI Campus Peshawar<br />
                            (Ph: 091-9224307-8, Fax: 091-9224370, Email: kpiaipofwm@gmail.com)
                        </p>


                    </td>
                    <td> </td>

                </tr>

            </table>
            <hr />
            <p style="font-size: 12;"><?php echo $payment_notesheet->puc_title; ?></p>
            <br />
            <table class="table table-bordered table_small">
                <thead style="margin-top: 30px;">
                    <tr>
                        <th>#</th>
                        <th>Scheme ID</th>
                        <th>Scheme Name</th>
                        <th>Title of A/C (as per record)</th>
                        <th>Cat:</th>
                        <th>FY</th>
                        <th>Sanctioned Cost</th>
                        <th>Payment Count</th>
                        <th>1st</th>
                        <th>2nd</th>
                        <th>1st_2nd</th>
                        <th>Final</th>
                        <th>Other</th>
                        <th>Total Paid</th>
                        <th>Remaining Amount</th>
                        <th>Payment Request</th>
                        <th>Payment Amount</th>
                        <th>WHIT</th>
                        <th>WHST</th>
                        <th>Net Rs.</th>

                    </tr>
                </thead>
                <tbody>
                    <?php

                    $query = "
                            SELECT 
                                s.scheme_id,
                                s.scheme_code,
                                s.scheme_name,
                                e.payee_name,
                                fy.financial_year,
                                cc.category,
                                wua.bank_account_title,
                                pns.id as pns_id,
                                pns.payment_amount,
                                pns.whit,
                                pns.whst,
                                pns.net_pay,
                                s.lining_length,
                                SUM(e.gross_pay) as `total_paid`,
                                COUNT(e.expense_id) as `payment_count`,
                                (s.sanctioned_cost- SUM(e.gross_pay)) as `Payable Rs`,
                                (s.sanctioned_cost) as `Sanctioned Cost`,
                                SUM(CASE WHEN e.installment = '1st' THEN e.gross_pay END) AS `1st`,
                                SUM(CASE WHEN e.installment = '2nd' THEN e.gross_pay END) AS `2nd`,
                                SUM(CASE WHEN e.installment = '1st_2nd' THEN e.gross_pay END) AS `1st_2nd`,
                                SUM(CASE WHEN e.installment = 'final' THEN e.gross_pay END) AS `final`,
                                SUM(CASE WHEN e.installment IS NULL THEN e.gross_pay END) AS `other`,
                                GROUP_CONCAT(e.cheque ORDER BY e.installment SEPARATOR ', ') AS `cheques`
                            FROM 
                                schemes s
                                INNER JOIN component_categories as cc ON cc.component_category_id = s.component_category_id
                                INNER JOIN payment_notesheet_schemes as pns ON(pns.scheme_id = s.scheme_id)
                                INNER JOIN financial_years as fy ON(fy.financial_year_id = s.financial_year_id)
                                LEFT JOIN expenses e ON s.scheme_id = e.scheme_id
                                INNER JOIN water_user_associations as wua ON(wua.water_user_association_id = s.water_user_association_id)
                                WHERE pns.payment_notesheet_id = '" . $payment_notesheet_id . "'
                            GROUP BY 
                                s.scheme_id, s.scheme_name
                            ORDER BY id ASC    
                                ";
                    $schemes = $this->db->query($query)->result();

                    if (!empty($schemes)): ?>
                        <?php
                        $count = 1;
                        foreach ($schemes as $scheme): ?>
                            <tr>

                                <td><?php echo $count++ ?></td>
                                <td><?php echo $scheme->scheme_code; ?></td>
                                <td><?php echo $scheme->scheme_name; ?></td>
                                <td><?php
                                    if ($scheme->payee_name) {
                                        echo $scheme->payee_name;
                                    } else {
                                        echo $scheme->bank_account_title;
                                    }
                                    ?></td>
                                <td><?php echo $scheme->category; ?></td>
                                <td><?php echo $scheme->financial_year; ?></td>
                                <td><?php echo number_format($scheme->{'Sanctioned Cost'}, 0); ?></td>
                                <td><?php echo $scheme->payment_count ?></td>
                                <td><?php echo number_format($scheme->{'1st'}, 0); ?></td>
                                <td><?php echo number_format($scheme->{'2nd'}, 0); ?></td>
                                <td><?php echo number_format($scheme->{'1st_2nd'}, 0); ?></td>
                                <td><?php echo number_format($scheme->{'final'}, 0); ?></td>
                                <td><?php echo number_format($scheme->{'other'}, 0); ?></td>
                                <td><?php echo number_format($scheme->{'total_paid'}, 0); ?></td>

                                <td><?php echo number_format($scheme->{'Payable Rs'}, 0); ?></td>

                                <td><?php echo getOrdinal($scheme->payment_count + 1) ?></td>

                                <td> <?php echo $scheme->payment_amount; ?>

                                </td>
                                <td><?php echo $scheme->whit; ?></td>
                                <td><?php echo $scheme->whst; ?></td>
                                <td><?php echo $scheme->net_pay; ?></td>


                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>

                    <?php endif; ?>
                </tbody>
            </table>
            <br />
            <br />
            <p style="font-size: 12;"><?php echo $payment_notesheet->puc_detail; ?></p>

        </div>







        </div>
    </page>
</body>



</html>
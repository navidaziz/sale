<!-- PAGE HEADER-->
<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <!-- STYLER -->

            <!-- /STYLER -->
            <!-- BREADCRUMBS -->
            <ul class="breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
                </li>
                <li>
                    <i class="fa fa-list"></i>
                    <a href="<?php echo site_url(ADMIN_DIR . "payment_notesheets/index"); ?>">Payment Notsheets</a>
                </li>
                <li><?php echo $title; ?></li>
            </ul>
            <!-- /BREADCRUMBS -->
            <div class="row">

                <div class="col-md-6">
                    <div class="clearfix">
                        <h3 class="content-title pull-left">Payment Notesheet <?php echo $title; ?></h3>
                    </div>
                    <div class="description"><?php echo $title; ?> - <?php echo $payment_notesheet->district_name ?> - <?php echo $payment_notesheet->puc_date; ?></div>
                </div>

                <div class="col-md-6">
                    <div class="pull-right">
                        <a target="_blank" href="<?php echo site_url(ADMIN_DIR . 'reports/download_payment_notesheet_csv/' . $payment_notesheet->id); ?>" class="btn btn-warning"><i class="fa fa-download"></i> Download</a>

                        <button onclick="get_payment_notesheet_form('<?php echo $payment_notesheet->id ?>')" class="btn btn-primary">Edit Payment Note Sheet</button>
                        <a target="_blank" href="<?php echo site_url(ADMIN_DIR . "payment_notesheets/print_payment_notesheet/" . $payment_notesheet->id); ?>" class="btn btn-danger">Print Payment Note Sheet</a>

                        <script>
                            function get_payment_notesheet_form(id) {
                                $.ajax({
                                        method: "POST",
                                        url: "<?php echo site_url(ADMIN_DIR . 'payment_notesheets/get_payment_notesheet_form'); ?>",
                                        data: {
                                            id: id
                                        },
                                    })
                                    .done(function(respose) {
                                        $('#modal').modal('show');
                                        $('#modal_title').html('Payment Notesheets');
                                        $('#modal_body').html(respose);
                                    });
                            }
                        </script>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row">
    <!-- MESSENGER -->
    <div class="col-md-12">
        <div class="box border blue" id="messenger">

            <div class="box-body">
                <details style="cursor: pointer;">
                    <summary>PUC Header Detail ....</summary>
                    <p><?php echo nl2br($payment_notesheet->puc_title); ?></p>
                </details>

                <div id="errorDiv" style="text-align: center;">
                    <div style="display: block;">
                        <label for="scheme_id">Add Scheme In PUC using Scheme ID:</label>
                        <input
                            class="form-control"
                            style="width: 200px; display: inline;"
                            type="text"
                            id="scheme_id"
                            placeholder="Scheme ID"
                            autofocus />
                    </div>
                    <div style="margin-top:2px" id="scheme_id_response"></div>
                </div>

                <div>
                    <strong>Payment List</strong>
                    <div class="table-responsive">
                        <div id="puc_list"></div>
                    </div>
                </div>
                <details style="cursor: pointer;">
                    <summary>PUC Footer Detail ....</summary>
                    <p><?php echo nl2br($payment_notesheet->puc_detail); ?></p>
                </details>

                <script>
                    // Function to handle the barcode data
                    function handleBarcode(barcode) {
                        alert("Barcode Scanned: " + barcode);
                        // Additional processing can be added here
                    }

                    // Add event listener for the input field
                    const barcodeInput = document.getElementById('scheme_id');
                    barcodeInput.addEventListener('keyup', function(event) {
                        $('#scheme_id_response').html('');
                        if (event.key === 'Enter') {
                            var scheme_id = $('#scheme_id').val();
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo site_url(ADMIN_DIR . "payment_notesheets/seacrch_by_scheme_id"); ?>', // URL to submit form data
                                data: {
                                    scheme_id: scheme_id,
                                    payment_notesheet_id: '<?php echo $payment_notesheet->id ?>'
                                },
                                success: function(response) {

                                    if (response != 'not_found') {

                                        if (response == 'success') {
                                            get_payment_notesheet_list();
                                        }
                                        $('#scheme_id').val('');
                                        $('#scheme_id_response').fadeOut(200, function() {
                                            $(this).html(response).fadeIn(200);
                                        });
                                    } else {

                                        $('#scheme_id_response').fadeOut(200, function() {
                                            $(this).html('<div class="alert alert-danger">Tracking No: <strong>' + scheme_id + '</strong> Not Found. Try Again</div>').fadeIn(200);
                                        });
                                        triggerBuzz('errorDiv');
                                    }


                                }
                            });
                        }
                    });
                </script>
                <script>
                    function get_payment_notesheet_list() {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo site_url(ADMIN_DIR . "payment_notesheets/get_payment_notesheet_list"); ?>', // URL to submit form data
                            data: {
                                payment_notesheet_id: '<?php echo $payment_notesheet->id ?>'
                            },
                            success: function(response) {
                                $('#puc_list').html(response);
                            }
                        });
                    }

                    get_payment_notesheet_list();
                </script>


            </div>


        </div>

    </div>
</div>
<!-- /MESSENGER -->
</div>
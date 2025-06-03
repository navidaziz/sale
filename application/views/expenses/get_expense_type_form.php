<form id="expense_types" class="form-horizontal" enctype="multipart/form-data" method="post">
    <input type="hidden" name="expense_type_id" value="<?php echo $input->expense_type_id; ?>" />

    <div class="form-group row">
        <label for="expense_type" class="col-sm-4 col-form-label">Expense Type</label>
        <div class="col-sm-8">
            <input type="text" required id="expense_type" name="expense_type" value="<?php echo $input->expense_type; ?>" class="form-control">
        </div>
    </div>

    <div class="form-group row" style="text-align:center">
        <div id="result_response"></div>
        <?php if ($input->expense_type_id == 0) { ?>
            <button type="submit" class="btn btn-primary">Add Data</button>
        <?php } else { ?>
            <button type="submit" class="btn btn-primary">Update Data</button>
        <?php } ?>
    </div>
</form>
</div>
<div class="table-responsive">
    <table class="table table-bordered" id="expenses">
        <thead>
            <tr>
                <!-- <th></th> -->
                <th>#</th>
                <th>Expense Type</th>
                <!-- <th>Action</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $business_id = $this->session->userdata("business_id");
            $query = "SELECT * FROM expense_types WHERE business_id = ?";
            $rows = $this->db->query($query, [$business_id])->result();
            foreach ($rows as $row) { ?>
                <tr>
                    <!-- <td><a href="<?php echo site_url('expenses/delete_expense_types/' . $row->expense_type_id); ?>" onclick="return confirm('Are you sure? you want to delete the record.')">Delete</a> </td> -->
                    <td><?php echo $count++ ?></td>
                    <td><?php echo $row->expense_type; ?></td>
                    <!-- <td><button onclick="get_expense_type_form('<?php echo $row->expense_type_id; ?>')">Edit<botton> -->
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        $('#expense_types').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url("expenses/add_expense_type"); ?>', // URL to submit form data
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
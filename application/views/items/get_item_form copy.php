 <form id="items" class="form-horizontal" enctype="multipart/form-data" method="post">
     <input type="hidden" name="item_id" value="<?php echo $input->item_id; ?>" />

     <div class="form-group row">
         <label for="name" class="col-sm-4 col-form-label">Item Name</label>
         <div class="col-sm-8">
             <input type="text" required id="name" name="name" value="<?php echo $input->name; ?>" class="form-control">
         </div>
     </div>

     <div class="form-group row">
         <label for="category" class="col-sm-4 col-form-label">Category</label>
         <div class="col-sm-8">
             <input type="text" required id="category" name="category" value="<?php echo $input->category; ?>" class="form-control">
         </div>
     </div>

     <div class="form-group row">
         <label for="cost_price" class="col-sm-4 col-form-label">Cost Price</label>
         <div class="col-sm-8">
             <input type="text" required id="cost_price" name="cost_price" value="<?php echo $input->cost_price; ?>" class="form-control">
         </div>
     </div>
     <div class="form-group row">
         <label for="unit_price" class="col-sm-4 col-form-label">Unit Price</label>
         <div class="col-sm-8">
             <input type="text" required id="unit_price" name="unit_price" value="<?php echo $input->unit_price; ?>" class="form-control">
         </div>
     </div>

     <div class="form-group row">
         <label for="stock" class="col-sm-4 col-form-label">Opening Stock</label>
         <div class="col-sm-8">
             <input type="text" required id="stock" name="stock" value="<?php echo $input->stock; ?>" class="form-control">
         </div>
     </div>

     <div class="form-group row">
         <label for="discount" class="col-sm-4 col-form-label">Discount</label>
         <div class="col-sm-8">
             <input type="text" required id="discount" name="discount" value="<?php echo $input->discount; ?>" class="form-control">
         </div>
     </div>
     <div class="form-group row">
         <label for="unit" class="col-sm-4 col-form-label">Unit</label>
         <div class="col-sm-8">
             <input type="text" required id="unit" name="unit" value="<?php echo $input->unit; ?>" class="form-control">
         </div>
     </div>
     <div class="form-group row">
         <label for="item_code_no" class="col-sm-4 col-form-label">Item Code No</label>
         <div class="col-sm-8">
             <input type="number" required id="item_code_no" name="item_code_no" value="<?php echo $input->item_code_no; ?>" class="form-control">
         </div>
     </div>
     <div class="form-group row">
         <label for="reorder_level" class="col-sm-4 col-form-label">Reorder Level</label>
         <div class="col-sm-8">
             <input type="text" required id="reorder_level" name="reorder_level" value="<?php echo $input->reorder_level; ?>" class="form-control">
         </div>
     </div>
     <div class="form-group row">
         <label for="location" class="col-sm-4 col-form-label">Location</label>
         <div class="col-sm-8">
             <input type="text" required id="location" name="location" value="<?php echo $input->location; ?>" class="form-control">
         </div>
     </div>
     <div class="form-group row">
         <label for="description" class="col-sm-4 col-form-label">Description</label>
         <div class="col-sm-8">
             <input type="text" required id="description" name="description" value="<?php echo $input->description; ?>" class="form-control">
         </div>
     </div>

     <div class="form-group row" style="text-align:center">
         <div id="result_response"></div>
         <?php if ($input->item_id == 0) { ?>
             <button type="submit" class="btn btn-primary">Add Data</button>
         <?php } else { ?>
             <button type="submit" class="btn btn-primary">Update Data</button>
         <?php } ?>
     </div>
 </form>
 </div>

 <script>
     $('#items').submit(function(e) {
         e.preventDefault();
         var formData = $(this).serialize();
         $.ajax({
             type: 'POST',
             url: '<?php echo site_url("items/add_item"); ?>', // URL to submit form data
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
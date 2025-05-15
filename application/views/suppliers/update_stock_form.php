 <form id="inventory_items" class="form-horizontal" enctype="multipart/form-data" method="post">
     <input type="hidden" name="inventory_id" value="<?php echo $inventory->inventory_id; ?>" />
     <input type="hidden" name="item_id" value="<?php echo $inventory->item_id; ?>" />

     <div class="form-group row">
         <label for="name" class="col-sm-4 col-form-label">Item Name</label>
         <div class="col-sm-8">
             <strong><?php echo $inventory->name; ?></strong>
         </div>
     </div>

     <div class="form-group row">
         <label for="item_cost_price_<?php echo $inventory->inventory_id; ?>" class="col-sm-4 col-form-label">Cost Price</label>
         <div class="col-sm-8">
             <input type="text" name="item_cost_price" value="<?php echo $inventory->item_cost_price; ?>" id="item_cost_price_<?php echo $inventory->inventory_id; ?>" onkeyup="update_cost_price('<?php echo $inventory->inventory_id; ?>')" class="form-control">
         </div>
     </div>

     <div class="form-group row">
         <label for="item_unit_price_<?php echo $inventory->inventory_id; ?>" class="col-sm-4 col-form-label">Unit Price</label>
         <div class="col-sm-8">
             <input type="text" name="item_unit_price" value="<?php echo $inventory->item_unit_price; ?>" id="item_unit_price_<?php echo $inventory->inventory_id; ?>" onkeyup="update_unit_price('<?php echo $inventory->inventory_id; ?>')" class="form-control">
         </div>
     </div>

     <div class="form-group row">
         <label for="stock_<?php echo $inventory->inventory_id; ?>" class="col-sm-4 col-form-label">Quantity</label>
         <div class="col-sm-8"><input type="text" name="inventory_transaction" value="<?php echo $inventory->inventory_transaction; ?>" id="inventory_transaction_<?php echo $inventory->inventory_id; ?>" onkeyup="update_stock('<?php echo $inventory->inventory_id; ?>')" class="form-control">

         </div>
     </div>
     <div style="text-align: center;">
         <div id="result_response"></div>
         <button class="btn btn-success">Update</button>
     </div>




 </form>
 </div>

 <script>
     $('#inventory_items').submit(function(e) {
         e.preventDefault();
         var formData = $(this).serialize();
         $.ajax({
             type: 'POST',
             url: '<?php echo site_url("suppliers/update_inventory_item"); ?>', // URL to submit form data
             data: formData,
             success: function(response) {
                 //alert(response);
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
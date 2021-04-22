<div class="row">
  <div class="col-sm-12 col-md-6">
    <!-- <form action="<?php //echo admin_url('admin.php?page='.$admin_page);?>" method="POST" name="start-order">
      <input type="hidden" name="order_id" value="<?php echo $order_id;?>">
      <input type="hidden" name="_method" value="working">
      <input type="hidden" name="redirect" value="<?php echo $redirect;?>">
      <div class="form-group">
          <button type="submit" class="btn btn-primary mb-2">Start Order</button>
      </div>
    </form> -->
  </div>
    <div class="col-sm-12 col-md-6">
      <?php WA_Orders_ListPart_CompleteOrder::get_instance()->finish([
        'order_id'=>$order_id, 'page' => $admin_page, 'redirect' => $redirect, 'status' => $status
      ]); ?>
    </div>
</div>

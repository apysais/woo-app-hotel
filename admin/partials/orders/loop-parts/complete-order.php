<form action="<?php echo admin_url('admin.php?page='.$admin_page);?>" method="POST" name="finish-order">
  <input type="hidden" name="order_id" value="<?php echo $order_id;?>">
  <input type="hidden" name="_method" value="complete">
  <input type="hidden" name="redirect" value="<?php echo $redirect;?>">
  <div class="form-group">
      <button type="submit" class="btn btn-primary mb-2">Complete Order</button>
  </div>
</form>

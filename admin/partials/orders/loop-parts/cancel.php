<div class="row">
  <div class="col-sm-12 col-md-6">
    <form action="<?php echo admin_url('admin.php?page='.$admin_page);?>" method="POST" name="cancel-order">
      <input type="hidden" name="order_id" value="<?php echo $order_id;?>">
      <input type="hidden" name="_method" value="cancel-order">
      <input type="hidden" name="redirect" value="<?php echo $redirect;?>">

      <button type="submit" class="btn btn-danger"><?php echo wa_verbage('cancel'); ?></button>
    </form>
  </div>
</div>

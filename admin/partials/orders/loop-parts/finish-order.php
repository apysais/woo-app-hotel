<form action="<?php echo admin_url('admin.php?page='.$admin_page);?>" method="POST" name="finish-order">
  <?php //echo $status; ?>
  <input type="hidden" name="order_id" value="<?php echo $order_id;?>">
  <?php //if ( wa_is_warehouse() && $status == 'released' ) : ?>
    <!-- <input type="hidden" name="_method" value="ready"> -->
  <?php //elseif( wa_store_office_access() || wa_is_local_pickup() ): ?>
    <!-- <input type="hidden" name="_method" value="done"> -->
  <?php //else : ?>
    <input type="hidden" name="_method" value="done">
  <?php //endif; ?>
  <input type="hidden" name="redirect" value="<?php echo $redirect;?>">

  <?php //endif; ?>
  <?php //if ( wa_is_warehouse() || wa_is_local_pickup() ) : ?>
    <div class="form-group">
        <button type="submit" class="btn btn-primary xmb-2 btn-sm"><?php echo wa_verbage('finish_order'); ?></button>
    </div>
  <?php //endif; ?>
</form>

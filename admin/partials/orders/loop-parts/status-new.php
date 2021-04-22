<div class="row">
  <div class="col-sm-12 col-md-6">
    <form action="<?php echo admin_url('admin.php?page='.$admin_page);?>" method="POST" name="release-order">
      <input type="hidden" name="order_id" value="<?php echo $order_id;?>">
      <input type="hidden" name="_method" value="set-release">
      <input type="hidden" name="redirect" value="<?php echo $redirect;?>">
      <!-- <div class="form-group">
          <label for="commentWarehouse"><?php //echo wa_verbage('comment_to_warehouse'); ?></label>
          <textarea class="form-control" name="commentWarehouse" id="commentWarehouse" rows="3"></textarea>
      </div>
      <div class="form-group form-check">
        <input class="form-check-input" type="checkbox" name="importantOrder" value="1" id="defaultCheck1">
        <label class="form-check-label" for="defaultCheck1">
          <?php //echo wa_verbage('mark_as_important'); ?>
        </label>
      </div> -->
      <div class="form-group">
          <button type="submit" class="btn btn-primary btn-sm xmb-2"><?php echo wa_verbage('released_orders'); ?></button>
      </div>
    </form>
  </div>
  <!-- <div class="col-sm-12 col-md-6"> -->
    <?php //WA_Orders_ListPart_CompleteOrder::get_instance()->finish(['order_id'=>$order_id, 'page' => $admin_page, 'redirect' => $redirect]); ?>
  <!-- </div> -->
</div>

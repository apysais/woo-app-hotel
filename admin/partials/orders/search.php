<div style="padding:20px 0;">
<form action="<?php echo admin_url('admin.php?page=search-orders');?>" method="GET" name="dashboard" class="float-right">
  <input type="hidden" name="page" value="search-orders">
  <div class="form-row">
    <div class="col">
      <input type="text" class="form-control form-control-sm" name="search" value="<?php echo $search_orders;?>" placeholder="<?php echo wa_verbage('search_order'); ?>" style="width:500px;height:32px;">
    </div>
    <div class="col">
      <button type="submit" class="btn btn-primary btn-sm"><?php echo wa_verbage('search'); ?></button>
    </div>
  </div>
</form>
</div>

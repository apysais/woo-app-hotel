<div class="row">
  <div class="col-sm-12 col-md-6">
    <?php
    WA_Orders_ListPart_CompleteOrder::get_instance()->finish([
      'order_id'=>$order_id, 'page' => $admin_page, 'redirect' => $redirect, 'status' => $status
    ]);
    ?>
  </div>
</div>

<div class="row">
  <div class="col-sm-12 col-md-12">
    <?php WA_Orders_ListPart_CompleteOrder::get_instance()->complete(['order_id'=>$order_id, 'page' => $admin_page, 'redirect' => $redirect]); ?>
  </div>
</div>

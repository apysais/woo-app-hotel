<?php if ( $orders ) : ?>
  <ul class="list-group accordion" id="<?php echo $status.'-orders';?>">
    <?php foreach ( $orders as $order ) : ?>
      <?php
        $order_id = $order->get_id();

        $important = WA_Orders_Meta::get_instance()->important(['post_id' => $order_id, 'action' => 'r', 'single' => true ]);
        $delivery_method = wa_get_shipping_methods($order);
        $bg = 'bg-light';
        $status_bg = 'bg-light';
        if ( $status == 'released' ) {
          $status_bg = 'bg-primary';
        } elseif ( $status == 'working' ) {
          $status_bg = 'bg-danger';
        } elseif ( $status == 'ready' ) {
          $status_bg = 'bg-info';
        } elseif ( $status == 'new' ) {
          $status_bg = 'bg-success';
        } elseif ( $status == 'done' ) {
          $status_bg = 'bg-info';
        }
      ?>
      <?php //if ( isset($delivery_method['shipping_method_id']) && $delivery_method['shipping_method_id'] == 'local_pickup' ) : ?>
        <?php
          $action_args = [
            'order' => $order,
            'bg' => $bg,
            'status_bg' => $status_bg,
            'order_id' => $order_id,
            'redirect' => $redirect,
            'status' => $status,
            'admin_page' => $admin_page,
          ];
          //_dd($action_args);
          //do_action('order-loop-items', $action_args);
          WA_Orders_Index::get_instance()->loop_order_item($action_args);
        ?>
      <?php //endif; ?>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php if ( $orders ) : ?>
  <?php
    $obj_orders = $orders;
    if( isset( $orders['orders'] ) ) {
      $obj_orders = $orders['orders'];
    }
    //_dd($orders);
    if ($status == 'orders-ready'){

    }
  ?>
  <ul class="list-group accordion" id="<?php echo $status.'-orders';?>">
    <?php foreach ( $obj_orders as $order ) : ?>
      <?php
        $order_id = $order->get_id();
        $important = WA_Orders_Meta::get_instance()->important(['post_id' => $order_id, 'action' => 'r', 'single' => true ]);
        $delivery_method = wa_get_shipping_methods($order);
        $status = WA_Orders_WareHouseStatus::get_instance()->order_status(['post_id'=>$order_id, 'single'=>true]);
        $status = $status ? $status : 'new';
        $bg = 'bg-light';
        $status_bg = 'bg-info';
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
        if( wa_page_complete() ) {
          $status_bg = 'bg-info';
        }
      ?>

      <?php
        $action_args = [
          'paginage' => false,
          'order' => $order,
          'bg' => $bg,
          'status_bg' => $status_bg,
          'order_id' => $order_id,
          'redirect' => $redirect,
          'status' => $status,
          'admin_page' => $admin_page,
        ];

        //do_action('order-loop-items', $action_args);
        WA_Orders_Index::get_instance()->loop_order_item($action_args);
      ?>

    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php if( isset($paginate) && $paginate ) : ?>
  <?php wa_bootstrap_pagination($order_raw); ?>
<?php endif; ?>

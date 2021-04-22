<div class="wa-delivery-list-orders-container ">
  <?php WA_View::get_instance()->admin_partials( 'nav.php', [] ); ?>

  <div class="row">
    <div class="col">
      <?php do_action('wa-loop-list-after-nav'); ?>
    </div>
  </div>

  <div class="wa-delivery-list-orders">
    <div class="row">

      <?php if ( wa_store_office_access() || wa_is_local_pickup() ) : ?>
        <?php if ( $new_orders ) : ?>
          <div class="<?php echo $class;?>">
            <h5><?php echo wa_verbage('new_orders'); ?></h5>
            <?php
              WA_View::get_instance()->admin_partials( 'orders/part-loop-pickup.php', [
                'orders'=>$new_orders,
                'status' => 'new' ,
                'admin_page' => $admin_page,
                'redirect' => $redirect,
              ]);
            ?>
          </div>
        <?php endif; ?>
      <?php endif; ?>

      <?php if ( $released_orders ) : ?>
        <div class="<?php echo $class;?>">
          <h5><?php echo wa_verbage('released_orders'); ?></h5>
          <?php

            WA_View::get_instance()->admin_partials( 'orders/part-loop-pickup.php', [
              'orders' => $released_orders,
              'status' => 'released',
              'admin_page' => $admin_page,
              'redirect' => $redirect,
            ]);
          ?>
        </div>
      <?php endif; ?>

      <?php if ( $working_orders ) : ?>
        <div class="<?php echo $class;?>">
          <h5>Working Orders</h5>
          <?php
            WA_View::get_instance()->admin_partials( 'orders/part-loop-pickup.php', [
              'orders' => $working_orders,
              'status' => 'working',
              'admin_page' => $admin_page,
              'redirect' => $redirect,
            ]);
          ?>
        </div>
      <?php endif; ?>

      <?php if ( $ready_orders ) : ?>
        <div class="<?php echo $class;?>">
          <h5><?php echo wa_verbage('ready_orders'); ?></h5>
          <?php
            WA_View::get_instance()->admin_partials( 'orders/part-loop-pickup.php', [
              'orders' => $ready_orders,
              'status' => 'ready',
              'admin_page' => $admin_page,
              'redirect' => $redirect,
            ]);
          ?>
        </div>
      <?php endif; ?>

    </div>
  </div>
</div>
<script>
var _redirect = '<?php echo isset($_GET['redirect']) ? $_GET['redirect'] : $_GET['page']; ?>';
var _page = '<?php echo isset($_GET['page']) ? $_GET['page'] : ''; ?>';
function _get_local_orders_ajax() {
  jQuery('.wa-delivery-list-orders-container').html('<h6> Getting Orders...</h6>');
  var _get_orders = jQuery.ajax({
      type: "POST",
      url: ajaxurl,
      data: {
        action: 'wa_refresh_local_orders',
        redirect: _redirect,
        page: _page,
      },
      async: false
  });
  _get_orders.done(function( msg ) {
    jQuery('.wa-delivery-list-orders-container').html(msg);
  });
}
jQuery( window ).load(function() {
  // Enable pusher logging - don't include this in production
  //Pusher.logToConsole = true;
  var pusher = new Pusher('c3196416bf9c13613678', {
    cluster: 'eu'
  });
  //per client has its own channel
  //subscribe: warehouse
  var channel = pusher.subscribe('warehouse');

  if ( _page == 'orders-pickup' ) {
    channel.bind('order', function(data) {
      if ( data.order == 'notify' ) {
        _get_local_orders_ajax();
      }
    });
  }
});
</script>

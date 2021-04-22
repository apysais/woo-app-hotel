<?php WA_View::get_instance()->admin_partials( 'nav.php', [] ); ?>

<div class="row">
  <div class="col">
    <?php do_action('wa-loop-list-after-nav'); ?>
  </div>
</div>

<div class="row">
  <?php if ( $complete_orders ) : ?>
    <div class="<?php echo $class;?>">
      <h5>Complete Orders</h5>
      <?php
        WA_View::get_instance()->admin_partials( 'orders/part-loop-list.php', [
          'new_orders' => false,
    			'released_orders' => false,
    			'working_orders' => false,
    			'ready_orders' => false,
    			'done_orders' => false,
          'orders'=> $complete_orders->orders,
          'class' => 'col-sm-12 col-md-12',
    			'admin_page' => $admin_page,
    			'redirect' => $redirect,
          'status' => 'done'
        ]);
      ?>
    </div>
  <?php endif; ?>

  <?php wa_bootstrap_pagination($complete_orders); ?>

</div>

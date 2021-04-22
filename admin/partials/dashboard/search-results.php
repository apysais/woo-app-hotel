<?php WA_View::get_instance()->admin_partials( 'nav.php', [] ); ?>

<div class="row">
  <div class="col">
    <?php do_action('wa-loop-list-after-nav'); ?>
  </div>
</div>

<div class="row">
  <?php if ( $orders ) : ?>
    <div class="<?php echo $class;?>">
      <h5><?php echo wa_verbage('search_results'); ?></h5>
      <?php
        WA_View::get_instance()->admin_partials( 'orders/part-loop-list.php', [
          'orders'=> $orders,
          'admin_page' => $admin_page,
          'redirect' => $redirect,
          'status' => 'search'
        ] );
      ?>
    </div>
  <?php endif; ?>
</div>

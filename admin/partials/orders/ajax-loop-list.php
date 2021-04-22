<div class="wa-dashboard-list-orders">
  <div class="row">
    
    <?php if ( wa_store_office_access() || wa_is_local_pickup() ) : ?>
      <?php if ( $new_orders ) : ?>
        <div class="<?php echo $class;?>">
          <h5><?php echo wa_verbage('new_orders'); ?></h5>
          <?php
            WA_View::get_instance()->admin_partials( 'orders/part-loop-list.php', [
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

          WA_View::get_instance()->admin_partials( 'orders/part-loop-list.php', [
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
          WA_View::get_instance()->admin_partials( 'orders/part-loop-list.php', [
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
          WA_View::get_instance()->admin_partials( 'orders/part-loop-list.php', [
            'orders' => $ready_orders,
            'status' => 'ready',
            'admin_page' => $admin_page,
            'redirect' => $redirect,
          ]);
        ?>
      </div>
    <?php endif; ?>

    <?php if ( $complete_orders ) : ?>
      <div class="<?php echo $class;?>">
        <h5>Complete Orders</h5>
        <?php
          WA_View::get_instance()->admin_partials( 'orders/part-loop-list.php', [
            'orders' => $complete_orders,
            'status' => 'complete',
            'admin_page' => $admin_page,
            'redirect' => $redirect,
          ]);
        ?>
      </div>
    <?php endif; ?>

    <?php if ( $done_orders ) : ?>
      <div class="<?php echo $class;?>">
        <h5>Done Orders</h5>
        <?php
          WA_View::get_instance()->admin_partials( 'orders/part-loop-list.php', [
            'orders' => $done_orders,
            'status' => 'done',
            'admin_page' => $admin_page,
            'redirect' => $redirect,
          ]);
        ?>
      </div>
    <?php endif; ?>

  </div>
</div>

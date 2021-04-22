<li class="list-group-item bg-light text-dark">
  <?php
  //$status = WA_Orders_WareHouseStatus::get_instance()->order_status(['post_id'=>$order_id, 'single'=>true]);
  //$status = $status ? $status : 'new';
  $woo_status = $order->get_status();
  if ( $woo_status == 'completed') {
    $status = 'complete';
  }
  ?>
  <div class="row <?php echo $bg;?> text-dark " >
    <div class="col-md-2">
      <a
        href="#"
        class="collpase-order btn btn-success btn-sm text-white"
        data-toggle="collapse"
        data-target="#collapse<?php echo $order_id;?>"
        aria-expanded="true"
        aria-controls="collapse<?php echo $order_id;?>">
          <?php echo wa_verbage('order'); ?> # <?php echo $order_id;?>
          <?php wa_shipping_icon($order); ?>
          <?php wa_important_icon($order_id); ?>
      </a>

    </div>
    <?php if ( wa_is_warehouse() || wa_store_office_access() && $status == 'new' ) : ?>
      <div class="col-md-2">
        <a
          href="#"
          class="btn btn-dark btn-sm print-order" data-order-id="<?php echo $order_id;?>">
          <?php echo wa_verbage('print'); ?>
        </a>
      </div>
    <?php endif; ?>
    <div class="col-md-2"><?php echo wa_verbage('customer'); ?> : <span class="text-uppercase font-weight-bold customer"><?php echo $order->get_billing_first_name() .' '. $order->get_billing_last_name();?></span></div>
    <div class="col-md-2"><?php echo wa_verbage('items'); ?> : <span class="text-uppercase font-weight-bold"><?php echo $order->get_item_count(); ?></span></div>
    <div class="col-md-4">

      <div class="form-inline">
        <div class="my-1 mr-sm-2">
          <?php if ( ! wa_is_local_pickup() ) : ?>
            <a
              href="<?php echo admin_url('admin.php?page=orders&_method=edit-order&order-id='.$order_id);?>"
              class="btn btn-dark btn-sm btn-edit">
              <?php echo wa_verbage('edit'); ?>
            </a>
          <?php endif; ?>
        </div>
        <div class="my-1 mr-sm-2">
          <?php if ( $status == 'search' ) : ?>
            <?php
              $status = WA_Orders_WareHouseStatus::get_instance()->order_status(['post_id'=>$order_id, 'single'=>true]);
              $status = $status ? $status : 'new';
            ?>
          <?php endif; ?>
        </div>
        <?php if ( ( wa_is_warehouse() || wa_store_office_access() || wa_is_local_pickup() ) && ('released' == $status) ) : ?>
          <div class="my-1 mr-sm-2 local-pickup-finish-order">
            <?php
               WA_Orders_ListPart_CompleteOrder::get_instance()->finish([
                 'order_id' => $order_id,
                 'page' => $admin_page,
                 'redirect' => $redirect
               ]);
            ?>
          </div>
        <?php endif; ?>
        <?php if ( wa_is_local_pickup() && ('done' == $status) ) : ?>
          <div class="my-1 mr-sm-2 local-pickup-finish-done">
            <?php
            WA_Orders_ListPart_StatusDone::get_instance()->show([
              'order_id' => $order_id,
              'order' => $order,
              'page' => $admin_page,
              'redirect' => $redirect,
              'status' => $status
             ]);
            ?>
          </div>
        <?php endif; ?>
        <?php if ( wa_is_warehouse() || wa_store_office_access() && $status == 'new' ) : ?>
          <div class="my-1 mr-sm-2 processed-order">
            <?php
            WA_Orders_ListPart_StatusNew::get_instance()->show([
              'order_id' => $order_id ,
              'order' => $order,
              'page' => $admin_page,
              'redirect' => $redirect,
              'status' => $status
            ]);
            ?>
          </div>
      <?php endif; ?>
      </div>

      <p class="text-uppercase font-weight-bold">
      <?php //echo \Carbon\Carbon::parse($order->get_date_created())->diffForHumans();?>
      <?php echo wa_verbage('ordered_on'); ?> : <?php echo wa_order_date($order->get_date_created())?>
      </p>
    </div>
  </div>
  <?php
    if ( isset($_GET['search']) && isset($_GET['page']) == 'search-orders' ) {
      $status = 'search';
    }
  ?>
  <div id="collapse<?php echo $order_id;?>" class="collapse" data-parent="#<?php echo $status.'-orders';?>">
    <div class="bg-light  text-dark">
      <div class="card-body order-list-details">
        <div class="row">
          <div class="col-md-4 col-sm-12">

            <h6>Status : <span class="xtext-uppercase font-weight-bold"><?php echo wa_verbage( strtolower( $order->get_status() ) ); ?></span></h6>
            <h6>Items : <?php echo $order->get_item_count(); ?></h6>

            <?php //if ( wa_store_office_access() ) : ?>
              <h6>Total : <span class="text-uppercase font-weight-bold"><?php echo $order->get_formatted_order_total(); ?></span></h6>
            <?php //endif; ?>

            <?php if ( wa_woo_delivery_get_delivery_type($order_id) == 'pickup' ) : ?>
              <h6>Pickup Date : <span class="pickup-date"><?php echo date('l, d-m-Y', strtotime(wa_woo_delivery_get_pickup_date($order_id))); ?></h6>
              <h6>Pickup Time : <span class="pickup-time"><?php echo wa_woo_delivery_get_pickup_time($order_id); ?></h6>
            <?php endif; ?>
            <h6><?php echo wa_verbage('notes_from_customer'); ?>:
              <span class=" font-weight-bold customer-notes"><?php echo $order->get_customer_note(); ?></span>
            </h6>
            <hr/>
            <?php if ( $status == 'released' ) : ?>
              <?php WA_Orders_ListPart_WarehouseNotes::get_instance()->show(['order_id'=>$order_id]); ?>
            <?php endif; ?>

            <!-- Log Status -->
            <?php
              wa_show_db_log_timeline([
                'status' => $status,
                'post_id' => $order_id,
              ]);
            ?>
            <!-- Log Status -->

          </div>
          <div class="col-md-4 col-sm-12">
            <?php WA_Orders_ListPart_OrderItems::get_instance()->show([ 'order_id' => $order_id , 'order' => $order ]); ?>
          </div>
          <div class="col-sm-12 col-md-4">
            <?php WA_Orders_ListPart_CustomerInfo::get_instance()->show([ 'order_id' => $order_id , 'order' => $order ]); ?>
          </div>
        </div>
        <div class="row row-list-actions">
          <div class="col-sm-12">
              <?php
                $status = WA_Orders_WareHouseStatus::get_instance()->order_status([
                  'post_id' => $order_id,
                  'single' => true
                ]);
                if ( $status == '' || !$status ) {
                  $status = 'new';
                }
                if ( $woo_status != 'completed' ) {
                  //echo $status;
                  switch ( $status ) {
                    case 'new' :
                      WA_Orders_ListPart_StatusNew::get_instance()->show([
                        'order_id' => $order_id ,
                        'order' => $order,
                        'page' => $admin_page,
                        'redirect' => $redirect,
                        'status' => $status
                      ]);
                      break;
                    case 'released' :
                      WA_Orders_ListPart_StatusReleased::get_instance()->show([
                        'order_id' => $order_id,
                        'order' => $order,
                        'page' => $admin_page,
                        'redirect' => $redirect,
                        'status' => $status
                      ]);
                      break;
                    case 'working' :
                      WA_Orders_ListPart_StatusWorking::get_instance()->show([
                        'order_id' => $order_id,
                        'order' => $order,
                        'page' => $admin_page,
                        'redirect' => $redirect,
                        'status' => $status
                       ]);
                      break;
                    case 'ready' :
                      if ( wa_is_warehouse() || wa_is_local_pickup() ){

                      WA_Orders_ListPart_StatusReady::get_instance()->show([
                        'order_id' => $order_id,
                        'order' => $order,
                        'page' => $admin_page,
                        'redirect' => $redirect,
                        'status' => $status
                       ]);
                      }
                      break;
                    case 'done' :
                      //if ( wa_is_warehouse() || wa_is_local_pickup() ){
                        WA_Orders_ListPart_StatusDone::get_instance()->show([
                          'order_id' => $order_id,
                          'order' => $order,
                          'page' => $admin_page,
                          'redirect' => $redirect,
                          'status' => $status
                         ]);
                      //}
                      break;
                    case 'completed' :

                      break;
                  }
                }//if ! completed
              ?>
              <?php
                if ( ( wa_store_office_access() || wa_is_local_pickup() ) && 'complete' != $status ) :
                  WA_Orders_ListPart_CancelOrder::get_instance()->show(['order_id'=>$order_id, 'page' => $admin_page, 'redirect' => $redirect]);
                endif;
              ?>
          </div>

        </div>
      </div>
    </div>
  </div>
</li>

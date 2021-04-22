<?php if ( $delivery ) : ?>
  <ul class="list-group accordion" id="<?php echo $status.'-orders';?>">
    <?php foreach ( $delivery['orders'] as $order ) : ?>
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
        }
      ?>
      <?php if ( isset($delivery_method['shipping_method_id']) && ( $delivery_method['shipping_method_id'] == 'free_shipping' || $delivery_method['shipping_method_id'] == 'flat_rate' ) ) : ?>
        <li class="list-group-item ">
          <div class="row <?php echo $bg;?> text-dark " >
            <div class="col-md-2 ">
              <a
                href="#"
                class="collpase-order btn btn-success btn-sm text-white"
                data-toggle="collapse"
                data-target="#collapse<?php echo $order_id;?>"
                aria-expanded="true"
                aria-controls="collapse<?php echo $order_id;?>">
                  Order # <?php echo $order_id;?>
                  <?php wa_shipping_icon($order); ?>
                  <?php wa_important_icon($order_id); ?>
              </a>
            </div>
            <?php if ( wa_store_office_access() ) : ?>
            <div class="col-md-2">
              <a href="<?php echo admin_url('admin.php?page=orders&redirect='.$redirect.'&_method=view-order&order-id='.$order_id);?>" class="btn btn-dark btn-sm">
                <?php echo wa_verbage('view_details'); ?></a>
            </div>
            <?php endif ;?>
            <div class="col-md-2"><?php echo wa_verbage('customer'); ?> : <span class="text-uppercase font-weight-bold customer"><?php echo $order->get_billing_first_name() .' '. $order->get_billing_last_name();?></span></div>
            <div class="col-md-2"><?php echo wa_verbage('items'); ?> : <span class="text-uppercase font-weight-bold"><?php echo $order->get_item_count(); ?></span></div>
            <div class="col-md-4">

              <div class="form-inline">
                <div class="my-1 mr-sm-2">
                  <?php //if ( ! wa_is_local_pickup() ) : ?>
                    <a
                      href="<?php echo admin_url('admin.php?page=orders&_method=edit-order&order-id='.$order_id);?>"
                      class="btn btn-dark btn-sm btn-edit">
                      <?php echo wa_verbage('edit'); ?>
                    </a>
                  <?php //endif; ?>
                </div>
                <div class="my-1 mr-sm-2">
                  <span
                    class="text-uppercase btn-<?php echo $status;?> <?php echo $status_bg;?> p-1 text-light">
                    <?php if ( $status == 'search' ) : ?>
                      <?php
                        $status = WA_Orders_WareHouseStatus::get_instance()->order_status(['post_id'=>$order_id, 'single'=>true]);
                        $status = $status ? $status : 'new';
                      ?>
                    <?php endif; ?>
                    <?php //echo $status; ?>
                  </span>
                </div>
              </div>

              <?php echo wa_verbage('ordered_on'); ?> : <span class="text-uppercase font-weight-bold">
              <?php //echo \Carbon\Carbon::parse($order->get_date_created())->diffForHumans();?>
              <?php echo wa_order_date($order->get_date_created())?>
              </span>
              <?php if ( wa_get_colli($order_id) ) : ?>
                <p class="text-uppercase font-weight-bold">Colli : <?php echo wa_get_colli($order_id);?></p>
              <?php endif; ?>
              <?php if ( wa_get_placement($order_id) ) : ?>
              <p class="text-uppercase font-weight-bold"><?php echo wa_verbage('placement'); ?> : <?php echo wa_get_placement($order_id);?></p>
              <?php endif; ?>
            </div>
          </div>
          <div id="collapse<?php echo $order_id;?>" class="collapse" data-parent="#<?php echo $status.'-orders';?>">
          <div class="bg-light  text-dark">
            <div class="card-body order-list-details">
              <div class="row">
                <div class="col-md-4 col-sm-12">
                  <h6>Status : <span class="xtext-uppercase font-weight-bold"><?php echo wa_verbage( strtolower( $order->get_status() ) ); ?></span></h6>
                  <h6>Items : <?php echo $order->get_item_count(); ?></h6>
                  <h6>Total : <span class="text-uppercase font-weight-bold"><?php echo $order->get_formatted_order_total(); ?></span></h6>
                  <h6><?php echo wa_verbage('notes_from_customer'); ?>:
                    <span class=" font-weight-bold"><?php echo $order->get_customer_note(); ?></span>
                  </h6>
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
                  <?php WA_Orders_ListPart_CompleteOrder::get_instance()->complete(['order_id'=>$order_id, 'page' => $admin_page, 'status' => $status]); ?>
                  <?php
                    if ( wa_store_office_access() ) :
                      WA_Orders_ListPart_CancelOrder::get_instance()->show(['order_id'=>$order_id, 'page' => $admin_page]);
                    endif;
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<div class="xbootstrap-iso">
  <?php WA_View::get_instance()->admin_partials( 'nav.php', [] ); ?>

  <div class="row">
    <div class="col">
      <?php do_action('wa-loop-list-after-nav'); ?>
    </div>
  </div>

  <?php $order = wc_get_order( $order_id ); ?>

  <h2><?php echo wa_verbage('order'); ?> #<?php echo $order_id; ?></h2>
  <h3>
    <?php echo wa_verbage('ordered_on'); ?> : <?php echo wa_order_date($order->get_date_created())?>
  </h3>
  <?php if ( wa_store_office_access() ) : ?>
    <h3>Total : <?php echo $order->get_formatted_order_total(); ?></h3>
  <?php endif; ?>
  <!-- Log Status -->
  <?php
    wa_show_db_log_timeline([
      'status' => $status,
      'post_id' => $order_id,
    ]);
  ?>
  <!-- Log Status -->
  <div class="col-sm-6 col-md-2">
    <a class="btn btn-primary" href="#" onclick="window.history.go(-1); return false;" role="button">
      Back
    </a>
  </div>
  <p/><p/>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Product</th>
        <th scope="col">Height</th>
        <th scope="col">Width</th>
        <th scope="col">Length</th>
        <th scope="col">STK</th>
      </tr>
    </thead>
    <tbody>
      <?php if ( $order ) : ?>
        <?php foreach ( $order->get_items() as $item ) : ?>
                <?php
                  //$product = $item->get_product();
                  //wwh_dd($item);
                ?>
                <tr>
                  <th scope="row"><?php echo $item->get_product_id();?></th>
                  <td>
                    <?php echo $item->get_name();?>
                    <?php
                      $formatted_meta_data = $item->get_formatted_meta_data();
                      //wwh_dd($formatted_meta_data);
                    ?>
                    <?php if ( $formatted_meta_data ) : ?>
                      <?php foreach( $formatted_meta_data as $data) : ?>
                            <td><?php echo $data->display_value;?></td>
                      <?php endforeach;?>
                    <?php else:?>
                      <td></td>
                      <td></td>
                      <td></td>
                    <?php endif;?>
                    <td><?php echo $item->get_quantity(); ?></td>
                  </td>

                </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>

  <div class="container">
    <?php //WWH_Orders_Release::get_instance()->show(['order_id'=>$order_id]); ?>
    <?php //WWH_Orders_Release::get_instance()->showReleased(['order_id'=>$order_id]); ?>
    <?php //if ( wwh_is_admin() ) : ?>
      <div class="jumbotron" style="padding:20px !important;">
        <?php
          switch ( $status ) {
            case 'new' :
              WA_Orders_ListPart_StatusNew::get_instance()->show([ 'order_id' => $order_id , 'order' => $order ]);
              break;
            case 'released' :
              WA_Orders_ListPart_StatusReleased::get_instance()->show([ 'order_id' => $order_id , 'order' => $order ]);
              break;
            case 'working' :
              WA_Orders_ListPart_StatusWorking::get_instance()->show([ 'order_id' => $order_id , 'order' => $order ]);
              break;
            case 'ready' :
              if ( wa_store_office_access() ){
                WA_Orders_ListPart_StatusReady::get_instance()->show([ 'order_id' => $order_id , 'order' => $order ]);
              }
              break;
          }
        ?>
        <div class="">
          <?php
            if ( wa_store_office_access() && 'complete' != $status ) :
              WA_Orders_ListPart_CancelOrder::get_instance()->show(['order_id'=>$order_id]);
            endif;
          ?>

        </div>
      </div>
    <?php //endif; ?>
  </div>

  <div class="container">
    <div class="jumbotron">
      <div class="release-notes-container">
      <!-- <h5>Notes</h5> -->
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <h5><?php echo wa_verbage('notes'); ?></h5>
            <?php if ( $status == 'released' ) : ?>
              <?php WA_Orders_ListPart_WarehouseNotes::get_instance()->show(['order_id'=>$order_id]); ?>
            <?php endif; ?>
          </div>
          <div class="col-sm-12 col-md-6">
            <h5><?php echo wa_verbage('customer'); ?></h5>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <?php echo $order->get_customer_note(); ?>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="container">
    <div class="jumbotron">
      <div class="row">
        <div class="col-sm-12 col-md-6">
          <h6><?php echo wa_verbage('customer_info'); ?> : </h6>
          <?php //echo $order->get_customer_id();?>
          <?php //echo $order->get_user_id();?>
          <address>
            <p><?php echo $order->get_formatted_billing_address(); ?></p>
            <p><span class="font-weight-bold">E-mailadresse : </span><?php echo $order->get_billing_email(); ?></p>
            <p><span class="font-weight-bold">Telefon : </span><?php echo $order->get_billing_phone(); ?></p>
          </address>
        </div>
        <div class="col-sm-12 col-md-6">
          <?php
            $shipping = wa_get_shipping_methods($order);
            $local = false;
            if ( $shipping && isset($shipping['shipping_method_id']) ) {
              $local = $shipping['shipping_method_id'];
            }
          ?>
          <?php if ( $local != 'local_pickup' ) : ?>
            <h6><?php //echo wa_verbage('delivery_address'); ?></h6>
            <address>
              <p><?php echo $order->get_formatted_shipping_address(); ?></p>
            </address>
          <?php endif;?>
        </div>
      </div>
    </div>
  </div>
</div>

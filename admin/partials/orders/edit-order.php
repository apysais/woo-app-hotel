<div class="xbootstrap-iso">
  <?php WA_View::get_instance()->admin_partials( 'nav.php', [] ); ?>

  <div class="row">
    <div class="col">
      <?php do_action('wa-loop-list-after-nav'); ?>
    </div>
  </div>

  <?php $order = wc_get_order( $order_id ); ?>

  <h2><?php echo wa_verbage('order'); ?> #<?php echo $order_id; ?></h2>
  <?php if ( wa_store_office_access() ) : ?>
    <h3>Total : <?php echo $order->get_formatted_order_total(); ?></h3>
  <?php endif; ?>
  <div class="col-sm-6 col-md-2">
    <a class="btn btn-primary btn-sm" href="<?php echo admin_url('admin.php?page=app-dashboard');?>" role="button">
      Back to Order dashboard
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
  <form action="<?php echo admin_url('admin.php?page=orders');?>" method="POST" name="update-order">
    <input type="hidden" name="order_id" value="<?php echo $order_id;?>">
    <input type="hidden" name="_method" value="update-order">

    <div class="container">
      <button type="submit" class="btn btn-primary">Update</button>
      <div class="jumbotron">
        <div class="release-notes-container">
        <!-- <h5>Notes</h5> -->
          <div class="row">
            <div class="col">
              <h5>Status</h5>
              <?php $sel_status = wa_status(); ?>
              <select name="status" class="form-control form-control-sm" id="status">
                <?php foreach( $sel_status as $k_status => $v_status) : ?>
                    <option value="<?php echo $k_status;?>" <?php echo ($k_status == $status) ? 'selected' : '';?>><?php echo $v_status;?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="container">
      <div class="jumbotron">
        <div class="release-notes-container">
        <!-- <h5>Notes</h5> -->
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <h5><?php echo wa_verbage('notes'); ?></h5>
              <?php
                $warehouse_note = WA_Warehouse_Notes::get_instance()->getOrderNote(['order_id'=>$order_id]);
                if ( $warehouse_note ) :
              ?>
                <input type="hidden" value="<?php echo $warehouse_note[0]->comment_ID;?>" name="warehouse_comment_id">
                <textarea name="warehouse_note" class="form-control" rows="3"><?php echo $warehouse_note[0]->comment_content;?></textarea>
              <?php endif; ?>
            </div>
            <?php if ( wa_store_office_access() ) : ?>
            <div class="col-sm-12 col-md-6">
              <h5><?php echo wa_verbage('customer'); ?></h5>
              <textarea name="customer_note" class="form-control" rows="3"><?php echo $order->get_customer_note();?></textarea>
            </div>
          <?php endif; ?>
          </div>
        </div>
      </div>

    </div>

    <div class="container">
      <?php if ( wa_store_office_access() ) : ?>
      <div class="jumbotron">
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <h6><?php //echo wa_verbage('customer_info'); ?> : </h6>
            <!-- <div class="form-row">
              <div class="col">
                <label for="bill_firstname">First Name</label>
                <input type="text" name="bill_firstname" class="form-control form-control-sm" id="bill_firstname" value="<?php echo get_post_meta($order_id, '_billing_first_name', true);?>">
              </div>
              <div class="col">
                <label for="bill_lastname">last Name</label>
                <input type="text" name="bill_lastname" class="form-control form-control-sm" id="bill_lastname" value="<?php echo get_post_meta($order_id, '_billing_last_name', true);?>">
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <label for="bill_company">Company</label>
                <input type="text" name="bill_company" class="form-control form-control-sm" id="bill_company" value="<?php echo get_post_meta($order_id, '_billing_company', true);?>">
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <label for="bill_address1">Address 1</label>
                <input type="text" name="bill_address1" class="form-control form-control-sm" id="bill_address1" value="<?php echo get_post_meta($order_id, '_billing_address_1', true);?>">
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <label for="bill_address2">Address 2</label>
                <input type="text" name="bill_address2" class="form-control form-control-sm" id="bill_address2" value="<?php echo get_post_meta($order_id, '_billing_address_2', true);?>">
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <label for="bill_city">City</label>
                <input type="text" name="bill_city" class="form-control form-control-sm" id="bill_city" value="<?php echo get_post_meta($order_id, '_billing_city', true);?>">
              </div>
              <div class="col">
                <label for="bill_postcode">Post Code</label>
                <input type="text" name="bill_postcode" class="form-control form-control-sm" id="bill_postcode" value="<?php echo get_post_meta($order_id, '_billing_postcode', true);?>">
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <label for="bill_email">E-mailadresse</label>
                <input type="text" name="bill_email" class="form-control form-control-sm" id="bill_email" value="<?php echo get_post_meta($order_id, '_billing_email', true);?>">
              </div>
              <div class="col">
                <label for="bill_telefon">Telefon</label>
                <input type="text" name="bill_telefon" class="form-control form-control-sm" id="bill_telefon" value="<?php echo get_post_meta($order_id, '_billing_phone', true);?>">
              </div>
            </div> -->
          </div>
          <div class="col-sm-12 col-md-6">
            <?php
              $shipping = wa_get_shipping_methods($order);
              $local = false;
              if ( $shipping && isset($shipping['shipping_method_id']) ) {
                $local = $shipping['shipping_method_id'];
              }
            ?>
            <h6><?php echo wa_verbage('delivery_address'); ?></h6>
            <div class="form-row">
              <div class="col">
                <label for="ship_firstname">First Name</label>
                <input type="text" name="ship_firstname" class="form-control form-control-sm" id="ship_firstname" value="<?php echo get_post_meta($order_id, '_shipping_first_name', true);?>">
              </div>
              <div class="col">
                <label for="ship_lastname">last Name</label>
                <input type="text" name="ship_lastname" class="form-control form-control-sm" id="ship_lastname" value="<?php echo get_post_meta($order_id, '_shipping_last_name', true);?>">
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <label for="ship_company">Company</label>
                <input type="text" name="ship_company" class="form-control form-control-sm" id="ship_company" value="<?php echo get_post_meta($order_id, '_shipping_company', true);?>">
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <label for="ship_address1">Address 1</label>
                <input type="text" name="ship_address1" class="form-control form-control-sm" id="ship_address1" value="<?php echo get_post_meta($order_id, '_shipping_address_1', true);?>">
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <label for="ship_address2">Address 2</label>
                <input type="text" name="ship_address2" class="form-control form-control-sm" id="ship_address2" value="<?php echo get_post_meta($order_id, '_shipping_address_2', true);?>">
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <label for="ship_city">City</label>
                <input type="text" name="ship_city" class="form-control form-control-sm" id="ship_city" value="<?php echo get_post_meta($order_id, '_shipping_city', true);?>">
              </div>
              <div class="col">
                <label for="ship_postcode">Post Code</label>
                <input type="text" name="ship_postcode" class="form-control form-control-sm" id="ship_postcode" value="<?php echo get_post_meta($order_id, '_shipping_postcode', true);?>">
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>
      <button type="submit" class="btn btn-primary">Update</button>
    </div>

  </form>
</div>

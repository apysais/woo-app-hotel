<h6><?php echo wa_verbage('customer_info'); ?> : </h6>
<address>
  <p class="customer-billing"><?php echo $order->get_formatted_billing_address(); ?></p>
  <p><span class="font-weight-bold">E-mailadresse : </span><span class="customer-email"><?php echo $order->get_billing_email(); ?></span></p>
  <p><span class="font-weight-bold">Telefon : </span><span class="customer-phone"><?php echo $order->get_billing_phone(); ?></span></p>
</address>
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

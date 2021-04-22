<h6><?php echo wa_verbage('order_items'); ?></h6>
<ul class="list-group list-group-flush" id="list-order-<?php echo $order_id;?>" style="padding:10px;">
  <?php $num = 1; ?>
  <?php foreach ( $order->get_items() as $item ): ?>
    <?php $formatted_meta_data = $item->get_formatted_meta_data(); ?>
    <?php //_dd($item); ?>
    <li class="list-group-item"><?php echo $item->get_name();?></li>
    <?php if ( $formatted_meta_data ) : ?>
      <li class="list-group-item">
        <ul class="list-unstyled">
          <small class="text-muted">Attributes</small>
          <?php foreach( $formatted_meta_data as $data) : ?>
                <div class="attribute-products-item">
                  <p><?php echo $data->display_key . ' : ' . wp_strip_all_tags($data->display_value);?></p>
                </div>
          <?php endforeach;?>
        </ul>
      </li>
    <?php endif; ?>
    <li class="list-group-item"><span class="order-qty">STK</span> : <?php echo $item->get_quantity(); ?></li>
    <li><hr></li>
    <?php $num++; ?>
  <?php endforeach; ?>
</ul>

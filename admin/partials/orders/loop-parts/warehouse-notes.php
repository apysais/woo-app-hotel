<h6>Ordreinfo : </h6>
<?php
  $to_warehouse = WA_Warehouse_Notes::get_instance()->getOrderNote(['order_id' => $order_id]);
?>
<?php if ( $to_warehouse ) : ?>
  <ul>
  <?php foreach( $to_warehouse as $key => $note ) : ?>
      <li class="xlist-group-item">
        <h6>
          <?php echo wpautop( wptexturize( wp_kses_post(  $note->comment_content ) ) ); ?>
        </h6>
        <small class=" font-weight-bold">
        <?php
          //echo 'Added on, ' . \Carbon\Carbon::parse($note->comment_date)->diffForHumans();
          echo 'Added on, ' . $note->comment_date;
        ?>
        </small>
      </li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

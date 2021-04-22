<div class="log-status-container">
  <ul>
    <?php foreach( $content as $key => $val ) : ?>
        <li>
          <p>From : <b><?php echo wa_verbage($val['previous_status']); ?></b> To <b><?php echo wa_verbage($val['status']); ?></b></p>
          <p>Time : <?php echo date( 'M d (D) Y, h:i A', $val['time']); ?></p>
          <p>By : <?php echo $val['user_info']->user_login; ?></p>
        </li>
    <?php endforeach; ?>
  </ul>

</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav nav-pills">
      <?php if ( wa_has_access('dashboard') || wa_store_office_access() ): ?>
        <li class="nav-item">
          <a class="nav-link <?php echo wa_current_nav('app-dashboard');?>" href="<?php echo wa_route_dashboard();?>"><?php echo wa_verbage('dashboard'); ?></a>
        </li>
      <?php endif; ?>
      <?php if ( wa_has_access('local') ): ?>
        <li class="nav-item">
          <a class="nav-link <?php echo wa_current_nav('orders-pickup');?>" href="<?php echo wa_route_local();?>"> <?php echo wa_verbage('local'); ?></a>
        </li>
      <?php endif; ?>
      <?php if ( wa_has_access('ready') ): ?>
        <!-- <li class="nav-item">
          <a class="nav-link <?php //echo wa_current_nav('orders-ready');?>" href="<?php //echo wa_route_ready();?>"><?php //echo wa_verbage('ready'); ?></a>
        </li> -->
      <?php endif; ?>
      <?php if ( wa_has_access('done') ): ?>
      <li class="nav-item">
        <a class="nav-link <?php echo wa_current_nav('orders-done');?>" href="<?php echo wa_route_done();?>"><?php echo wa_verbage('done'); ?></a>
      </li>
      <?php endif; ?>
      <?php if ( wa_has_access('complete') || wa_is_local_pickup() ): ?>
      <li class="nav-item">
        <a class="nav-link <?php echo wa_current_nav('orders-complete');?>" href="<?php echo wa_route_complete();?>"><?php echo wa_verbage('complete'); ?></a>
      </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

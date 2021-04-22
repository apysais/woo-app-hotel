<div class="wrap">
  <div class="bootstrap-iso">
    <div class="container-fluid">
      <h1>Orders</h1>

      <div class="dashboard-container">

        <div class="dashboard-top-container-full-width">
          <div class="row">
            <div class="col-sm-12 col-md-12">
              <div class="wa-top-dashboard-full-width">
                <?php do_action('wa-top-dashboard-full-width'); ?>
              </div>
            </div>
          </div>
        </div><!-- .dashboard-top-container-full-width -->

        <div class="dashboard-mid-container-half">
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <div class="wa-mid-dashboard-left-container">
                <?php do_action('wa-mid-dashboard-left-container'); ?>
              </div>
            </div>
            <div class="col-sm-12 col-md-6">
              <div class="wa-mid-dashboard-right-container">
                <?php do_action('wa-mid-dashboard-right-container'); ?>
              </div>
            </div>
          </div>
        </div><!-- .dashboard-mid-container-half -->

        <div class="dashboard-bottom-container-full-width">
          <div class="row">
            <div class="col-sm-12 col-md-12">
              <div class="wa-bottom-dashboard-full-width'">
                <?php do_action('wa-bottom-dashboard-full-width'); ?>
              </div>
            </div>
          </div>
        </div><!-- .dashboard-bottom-container-full-width -->

      </div><!-- .dashboard-container -->
    </div><!-- .container-fluid -->
  </div><!-- .bootstrap-iso -->
</div><!-- .wrap -->
<script>
var _redirect = '<?php echo isset($_GET['redirect']) ? $_GET['redirect'] : $_GET['page']; ?>';
var _page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'app-dashboard'; ?>';

function _get_orders_ajax() {
  jQuery('.orders-list').html('<h6> Getting Orders...</h6>');
  var _get_orders = jQuery.ajax({
      type: "POST",
      url: ajaxurl,
      data: {
        action: 'wa_refresh_orders',
        redirect: _redirect,
        page: _page,
      },
      async: false
  });
  _get_orders.done(function( msg ) {
    //console.log(msg);
    jQuery('.orders-list').html(msg);
  });
}
function _get_ready_orders_ajax() {
  jQuery('.wa-dashboard-list-orders').html('<h6> Getting Orders...</h6>');
  var _get_orders = jQuery.ajax({
      type: "POST",
      url: ajaxurl,
      data: {
        action: 'wa_refresh_ready_orders',
        redirect: _redirect,
        page: _page,
        doing_ajax: 1
      },
      async: false
  });
  _get_orders.done(function( msg ) {
    //console.log(msg);
    jQuery('.wa-dashboard-list-orders').html(msg);
  });
}
function _get_done_orders_ajax() {
  jQuery('.wa-dashboard-list-orders').html('<h6> Getting Orders...</h6>');
  var _get_orders = jQuery.ajax({
      type: "POST",
      url: ajaxurl,
      data: {
        action: 'wa_refresh_done_orders',
        redirect: _redirect,
        page: _page,
        doing_ajax: 1
      },
      async: false
  });
  _get_orders.done(function( msg ) {
    //console.log(msg);
    jQuery('.wa-dashboard-list-orders').html(msg);
  });
}
jQuery( window ).load(function() {
  console.log('dashboard/index');
  console.log(_page);
  // Enable pusher logging - don't include this in production
  //Pusher.logToConsole = true;
  var pusher = new Pusher('c3196416bf9c13613678', {
    cluster: 'eu'
  });
  var channel = pusher.subscribe('warehouse');
  if ( _page == 'app-dashboard' ) {
    channel.bind('order', function(data) {
      if ( data.order == 'notify' ) {
        _get_orders_ajax();
      }
    });
  } else if ( _page == 'orders-ready' ) {
    channel.bind('order', function(data) {
      if ( data.order == 'notify' ) {
        _get_ready_orders_ajax();
      }
    });
  } else if ( _page == 'orders-done' ) {
    channel.bind('order', function(data) {
      if ( data.order == 'notify' ) {
        _get_done_orders_ajax();
      }
    });
  }
  //per client has its own channel
  //subscribe: warehouse
});
</script>

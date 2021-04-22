<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function wa_woo_delivery_get_delivery_type($order_id) {
	//delivery_type
	return get_post_meta($order_id, 'delivery_type', true);
}

function wa_woo_delivery_get_pickup_date($order_id) {
	//pickup_date
	return get_post_meta($order_id, 'pickup_date', true);
}

function wa_woo_delivery_get_pickup_time($order_id) {
	//pickup_time
	return get_post_meta($order_id, 'pickup_time', true);
}

function wa_redirect_no_access() {
	if ( wa_is_local_pickup() && ! wa_has_access('dashboard') ) {
		wa_redirect_local();
	}
}

function wa_has_access( $nav = '' ) {
	switch( $nav ) {
		case 'complete':
			if ( wa_store_office_access() || wa_is_local_pickup() ) {
				return true;
			}
			break;
		case 'search':
			if ( wa_is_warehouse() || wa_store_office_access() ) {
				return true;
			}
			break;
		case 'done':
			if ( wa_store_office_access() || wa_is_local_pickup()  ) {
				return true;
			}
			break;
		case 'ready':
			if ( wa_is_warehouse() || wa_store_office_access() ) {
				return true;
			}
			break;
		case 'local':
			if ( wa_is_warehouse() || wa_is_local_pickup() || wa_store_office_access() ) {
				return true;
			}
			break;
		case 'dashboard' :
		default:
			if ( wa_is_warehouse() || wa_store_office_access() ) {
				return true;
			}
			break;
	}
	return false;
}

function wa_page_complete() {
	if( isset($_GET['page']) && $_GET['page'] == 'orders-complete' ) {
		return true;
	}
	return false;
}

function wa_current_nav( $link = 'app-dashboard') {
	$current_page = isset($_GET['page']) ? $_GET['page'] : 'app-dashboard';
	$class = '';
	if ( $current_page == $link ) {
		$class = 'active';
	}
	return $class;
}

function wa_status( $status = 0 ) {
	$arr = [
		'new' => 'New',
		'released'	=> 'Released',
		'ready'	=> 'Ready',
		'done'	=> 'Done',
		'complete'	=> 'Complete',
	];
	if ( $status == 0 ){
		return $arr;
	}else{
		return $arr[$status];
	}
}

function wa_order_date($date_str) {
	return \Carbon\Carbon::parse($date_str)->format('Y-m-d');
}

function wa_get_colli( $order_id ) {
	$res = WA_Orders_Meta::get_instance()->colli([
		'post_id' => $order_id,
		'single' => true
	]);
	return $res;
}

function wa_get_placement( $order_id ) {
	$res = WA_Orders_Meta::get_instance()->placement([
		'post_id' => $order_id,
		'single' => true
	]);
	if ( $res ) {
		$placement = wa_placement($res);
		return $placement;
	}
	return '';
}

function wa_placement( $val = 0 ) {
	$arr = [
		5 => 'Ny hal',
		1 => 'Kold hal',
		2	=> 'Varm hal',
		3 => 'Reol',
		4 => 'Reol ved bæk',
		6 => 'Ny plads',
		7 => 'Ved bækken',
	];
	if ( $val == 0 ){
		return $arr;
	}else{
		return $arr[$val];
	}
}
function wa_is_local_pickup() {
	if ( WA_User_Role::get_instance()->is_local_pickup() ) {
		return true;
	}
	return false;
}
function wa_is_warehouse() {
	if ( WA_User_Role::get_instance()->is_warehouse() ) {
		return true;
	}
	return false;
}
function wa_is_office() {
	if ( WA_User_Role::get_instance()->is_office() ) {
		return true;
	}
	return false;
}
function wa_is_store_owner() {
	if ( WA_User_Role::get_instance()->is_store_owner() ) {
		return true;
	}
	return false;
}
function wa_is_admin() {
	if ( WA_User_Role::get_instance()->is_admin() ) {
		return true;
	}
	return false;
}
function wa_store_office_access() {
	if (
		WA_User_Role::get_instance()->is_store_owner()
		|| WA_User_Role::get_instance()->is_shop_manager()
		|| WA_User_Role::get_instance()->is_admin()
		|| WA_User_Role::get_instance()->is_office()
	) {
		return true;
	}
	return false;
}
function wa_remove_cap_shop_manager() {
	$shop_manager = get_role( 'shop_manager' );
	// A list of capabilities to remove from editors.
  $caps = array(
    'update_themes',
    'install_themes',
    'update_core',
    'edit_theme_options',
    'delete_themes',
    'moderate_comments',
    'import',
    'export',
  );

  foreach ( $caps as $cap ) {
    // Remove the capability.
    $shop_manager->remove_cap( $cap );
  }
}
function wa_redirect_to($url) {
	?>
	<script type="text/javascript">
		window.location = '<?php echo $url; ?>';
	</script>
	<?php
	die();
}
function wa_important_icon($order_id) {
	$important = WA_Orders_Meta::get_instance()->important([
		'post_id' => $order_id,
		'action' => 'r',
		'single' => true
	]);

	if ( $important && $important == 1 ) {
		echo '<i class="fas fa-star fa-2x" title="Important"></i>';
	}
}

function wa_get_shipping_methods($shipping_obj) {
	$shipping_arr = [];
	foreach( $shipping_obj->get_items( 'shipping' ) as $item_id => $shipping_item_obj ){
			$shipping_arr = [
				'order_item_name'             => $shipping_item_obj->get_name(),
		    'order_item_type'            	=> $shipping_item_obj->get_type(),
		    'shipping_method_title'       => $shipping_item_obj->get_method_title(),
		    'shipping_method_id'          => $shipping_item_obj->get_method_id(),
		    'shipping_method_instance_id' => $shipping_item_obj->get_instance_id(),
		    'shipping_method_total'       => $shipping_item_obj->get_total(),
		    'shipping_method_total_tax'   => $shipping_item_obj->get_total_tax(),
		    'shipping_method_taxes'       => $shipping_item_obj->get_taxes()
			];
	}
	return $shipping_arr;
}

function wa_shipping_icon($shipping_obj) {
	$ship_method_id = wa_get_shipping_methods($shipping_obj);

	if ( isset($ship_method_id['shipping_method_id']) && $ship_method_id ) {
		switch($ship_method_id['shipping_method_id']) {
			case 'local_pickup':
				echo '<i class="fas fa-warehouse fa-2x" title="Local pickup"></i>';
				break;
			case 'flat_rate':
			case 'free_shipping':
				echo '<i class="fas fa-truck fa-2x" title="Delivery"></i>';
				break;
		}
	}
}

function wa_shipping_text($shipping_obj) {
	$ship_method_id = wa_get_shipping_methods($shipping_obj);
	if ( isset($ship_method_id['shipping_method_id']) && $ship_method_id ) {
    return $ship_method_id['shipping_method_title'];
	}
}

function _dd($arr = [], $exit = false) {
  echo '<pre>';
  print_r($arr);
  echo '</pre>';
  if ( $exit ) {
    exit();
  }
}

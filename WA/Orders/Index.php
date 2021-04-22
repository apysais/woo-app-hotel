<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Template
 * */
class WA_Orders_Index {
  /**
	 * instance of this class
	 *
	 * @since 0.0.1
	 * @access protected
	 * @var	null
	 * */
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @since     0.0.1
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function __construct() {
    //add_action('wa-top-orders-full-width', [$this, 'init'], 99);
  }

	public function loop_order_item($args = []) {
		WA_View::get_instance()->admin_partials( 'orders/part-order-loop-item.php', $args );
	}

	public function order_details() {
		$data = [];
		if ( isset( $_GET['order-id'] ) ) {
			$order_id = sanitize_text_field( $_GET['order-id'] );
		}
		$status = WA_Orders_WareHouseStatus::get_instance()->order_status([
			'post_id' => $order_id,
			'single' => true
		]);
		$data = [
			'order_id' => $order_id,
			'status' => $status ? $status : 'new'
		];
		$user_id = 1;
		$customer_meta = get_user_meta( $user_id );

    WA_View::get_instance()->admin_partials( 'orders/details.php', $data );
	}

	public function edit_order() {
		$data = [];
		if ( isset( $_GET['order-id'] ) ) {
			$order_id = sanitize_text_field( $_GET['order-id'] );
		}
		$status = WA_Orders_WareHouseStatus::get_instance()->order_status([
			'post_id' => $order_id,
			'single' => true
		]);
		$data = [
			'order_id' => $order_id,
			'status' => $status
		];
    WA_View::get_instance()->admin_partials( 'orders/edit-order.php', $data );
	}

	public function complete_orders( $args = [] ) {
		$res = WA_Orders_Get::get_instance()->completedOrders();
		$data = [
			'orders' => $res['orders'],
			'class' => 'col-sm-12 col-md-12'
		];
		WA_View::get_instance()->admin_partials( 'orders/complete.php', $data );
	}

	public function ready_orders() {
		$data = [];
		$orders = new WA_Orders_Get;
		$ready_orders = $orders->readyOrders();

		$page = isset( $args['page'] ) ? $args['page'] : sanitize_text_field( $_GET['page'] );
		if ( isset( $args['page'] ) ) {
			$page =  $args['page'];
		} elseif ( isset( $_GET['page'] ) ) {
			$page = $_GET['page'];
		} elseif ( isset( $_POST['page'] ) ) {
			$page = $_POST['page'];
		} else {
			$page = 'orders-pickup';
		}

		$redirect = $page;
		if ( $page == 'orders-pickup' ) {
			$page = 'orders';
			$redirect = 'orders-pickup';
		}
		if ( isset( $args['redirect'] ) ) {
			$redirect =  $args['redirect'];
		} elseif ( isset( $_GET['redirect'] ) ) {
			$redirect = $_GET['redirect'];
		} elseif ( isset( $_POST['redirect'] ) ) {
			$redirect = $_POST['redirect'];
		}

		//$redirect = isset( $_GET['redirect'] ) ? sanitize_text_field( $_GET['redirect'] ) : $redirect;

		$data = [
			'new_orders' => false,
			'released_orders' => false,
			'working_orders' => false,
			'ready_orders' => $ready_orders['orders'],
			'complete_orders' => false,
			'class' => 'col-sm-12 col-md-12',
			'admin_page' => $page,
			'redirect' => $redirect
		];
		WA_View::get_instance()->admin_partials( 'orders/loop-list.php', $data );
	}

}//

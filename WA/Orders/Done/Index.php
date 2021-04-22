<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Template
 * */
class WA_Orders_Done_Index {
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
  }


	public function done_orders($args=[]) {
		$data = [];
		$orders = new WA_Orders_Get;
		$done_orders = $orders->doneOrders();
		$page = isset( $args['page'] ) ? $args['page'] : sanitize_text_field( $_GET['page'] );
		if ( isset( $args['page'] ) ) {
			$page =  $args['page'];
		} elseif ( isset( $_GET['page'] ) ) {
			$page = $_GET['page'];
		} elseif ( isset( $_POST['page'] ) ) {
			$page = $_POST['page'];
		} else {
			$page = 'orders-done';
		}

		$redirect = $page;
		if ( $page == 'orders-done' ) {
			$page = 'orders';
			$redirect = 'orders-done';
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
			'ready_orders' => false,
			'done_orders' => $done_orders['orders'],
			'complete_orders' => false,
			'class' => 'col-sm-12 col-md-12',
			'admin_page' => $page,
			'redirect' => $redirect,
			'status' => 'done'
		];

		if ( isset($_POST['doing_ajax']) && $_POST['doing_ajax'] == 1 ) {
			WA_View::get_instance()->admin_partials( 'orders/ajax-loop-list.php', $data );
		}else{
			WA_View::get_instance()->admin_partials( 'orders/loop-list.php', $data );
		}
	}

}//

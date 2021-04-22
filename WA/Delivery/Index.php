<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Template
 * */
class WA_Delivery_Index {
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

  public function init( $args = [] ) {
    $data = [];
    $orders = new WA_Orders_Get;
		$delivery = $orders->readyOrders();

		$page = isset( $args['page'] ) ? $args['page'] : sanitize_text_field( $_GET['page'] );
		if ( isset( $args['page'] ) ) {
			$page =  $args['page'];
		} elseif ( isset( $_GET['page'] ) ) {
			$page = $_GET['page'];
		} elseif ( isset( $_POST['page'] ) ) {
			$page = $_POST['page'];
		} else {
			$page = 'app-dashboard';
		}
		$redirect = $page;
		if ( isset( $args['redirect'] ) ) {
			$redirect =  $args['redirect'];
		} elseif ( isset( $_GET['redirect'] ) ) {
			$redirect = $_GET['redirect'];
		} elseif ( isset( $_POST['redirect'] ) ) {
			$redirect = $_POST['redirect'];
		}

    $data = [
      'delivery' => $delivery,
      'local_pickup' => false,
      'class' => 'col-md-12 col-sm-12',
      'admin_page' => $page,
      'redirect' => $redirect,
    ];
    WA_View::get_instance()->admin_partials( 'orders/deliver-loop-list.php', $data );
  }

}//

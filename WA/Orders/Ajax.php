<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Ajax
 * @since 0.0.1
 * */
class WA_Orders_Ajax {
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
    add_action( 'wp_ajax_wa_refresh_orders', [$this, 'getOrders'] );
    add_action( 'wp_ajax_wa_refresh_done_orders', [$this, 'getDoneOrders'] );
    add_action( 'wp_ajax_wa_refresh_local_orders', [$this, 'getLocalOrders'] );
    add_action( 'wp_ajax_wa_refresh_ready_orders', [$this, 'getReadyOrders'] );
  }

  public function getReadyOrders() {
		WA_Orders_Ready_Index::get_instance()->ready_orders(['redirect' => 'orders-ready', 'page' => 'orders']);
    wp_die();
  }

  public function getDoneOrders() {
		WA_Orders_Done_Index::get_instance()->done_orders(['redirect' => 'orders-done', 'page' => 'orders']);
    wp_die();
  }

  public function getOrders() {
		WA_Orders_List::get_instance()->get_orders();
    wp_die();
  }

  public function getLocalOrders() {
		WA_Pickup_Index::get_instance()->init(['redirect' => 'orders-pickup', 'page' => 'orders']);
    wp_die();
  }


}//

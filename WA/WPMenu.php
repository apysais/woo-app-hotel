<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * WP menu
 * */
class WA_WPMenu {
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
    add_action( 'admin_menu', [$this, 'init'] );
  }

  public function init() {
    add_menu_page(
        __( 'WOO APP Dashboard'),
        'WOO APP',
        'delete_posts',
        'app-dashboard',
        [WA_Dashboard_Controller::get_instance() , 'controller'],
        'dashicons-welcome-widgets-menus',
        6
    );
    // add_submenu_page(
    //     'app-dashboard',
    //     __( 'Warehouse Dashboard'),
    //     __( 'Warehouse'),
    //     'delete_posts',
    //     'warehouse',
    //     [WA_Warehouse_Controller::get_instance() , 'controller']
    // );
    add_submenu_page(
        '',
        __( 'Orders'),
        __( 'Orders'),
        'delete_posts',
        'orders',
        [WA_Orders_Controller::get_instance() , 'controller']
    );
    add_submenu_page(
        '',
        __( 'Search Orders'),
        __( 'Search Orders'),
        'delete_posts',
        'search-orders',
        [WA_Orders_Search_Controller::get_instance() , 'controller']
    );
    add_submenu_page(
        '',
        __( 'Pickup'),
        __( 'Pickup'),
        'delete_posts',
        'orders-pickup',
        [WA_Pickup_Controller::get_instance() , 'controller']
    );
    add_submenu_page(
        '',
        __( 'Orders Ready'),
        __( 'Orders Ready'),
        'delete_posts',
        'orders-ready',
        [WA_Orders_Ready_Controller::get_instance() , 'controller']
    );
    add_submenu_page(
        '',
        __( 'Orders Done'),
        __( 'Orders Done'),
        'delete_posts',
        'orders-done',
        [WA_Orders_Done_Controller::get_instance() , 'controller']
    );
    add_submenu_page(
        '',
        __( 'Orders Complete'),
        __( 'Orders Complete'),
        'delete_posts',
        'orders-complete',
        [WA_Orders_Complete_Controller::get_instance() , 'controller']
    );
  }

}//

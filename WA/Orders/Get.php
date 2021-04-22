<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 *
 * @since 0.0.1
 * */
class WA_Orders_Get {
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

  public function __construct() { }

	/**
   * Search Results.
   */
	public function search( $args = [] ) {
		$search_str = $args['search'];

		$search_obj = new WC_Order_Data_Store_CPT;
		$search = $search_obj->search_orders( $search_str );

		$query_args = array(
			'post__in' => $search,
			'limit' => -1,
		);

		$orders = wc_get_orders( $query_args );

    $data = [
      'title' => 'Search Orders',
			'orders' => $orders,
			'app' => 'index',
			'order_status' => 'search'
    ];

		return $data;
  }

  /**
   * Get new orders, this is for officers only.
   */
	public function newOrders() {
		$query_args = [
				'limit' => -1,
				'status' => ['processing', 'on-hold'],
		    'orderby' => 'modified',
		    'order' => 'DESC',
				'meta_key' => 'wh_order_status',
				'meta_compare' => 'NOT EXISTS'
		];
		$orders = wc_get_orders( $query_args );
    $data = [
      'title' => 'New Orders',
			'orders' => $orders,
			'app' => 'index',
			'order_status' => 'new'
    ];

		return $data;
  }

  /**
   * Get released orders, this is for officers only.
   */
	public function releasedOrders() {
		$query_args = [
				'limit' => -1,
				'status' => ['processing', 'on-hold'],
		    'orderby' => 'modified',
		    'order' => 'DESC',
				'meta_key' => 'wh_order_status',
				'meta_value' => 'released'
		];
		$orders = wc_get_orders( $query_args );

    $data = [
      'title' => 'Released Orders',
			'orders' => $orders,
			'app' => 'index',
			'order_status' => 'released'
    ];

		return $data;
  }

  /**
   * Get working orders, this is for officers only.
   */
	public function workingOrders() {
		$query_args = [
				'limit' => -1,
				'status' => ['processing', 'on-hold'],
		    'orderby' => 'modified',
		    'order' => 'DESC',
				'meta_key' => 'wh_order_status',
				'meta_value' => 'working'
		];
		$orders = wc_get_orders( $query_args );

    $data = [
      'title' => 'Working Orders',
			'orders' => $orders,
			'app' => 'index',
			'order_status' => 'working'
    ];

		return $data;
  }

  /**
   * Get ready orders, this is for officers only.
   */
	public function readyOrders() {
		$query_args = [
				'limit' => -1,
				'status' => ['processing', 'on-hold'],
		    'orderby' => 'modified',
		    'order' => 'DESC',
				'meta_key' => 'wh_order_status',
				'meta_value' => 'ready'
		];
		$orders = wc_get_orders( $query_args );

    $data = [
      'title' => 'Ready Orders',
			'orders' => $orders,
			'app' => 'index',
			'order_status' => 'ready'
    ];

		return $data;
  }

  /**
   * Get done orders, this is for officers only.
   */
	public function doneOrders() {
		$query_args = [
				'limit' => -1,
				'status' => ['processing', 'on-hold'],
		    'orderby' => 'modified',
		    'order' => 'DESC',
				'meta_key' => 'wh_order_status',
				'meta_value' => 'done'
		];
		$orders = wc_get_orders( $query_args );

    $data = [
      'title' => 'Done Orders',
			'orders' => $orders,
			'app' => 'index',
			'order_status' => 'done'
    ];

		return $data;
  }

	/**
	 * get all orders.
	 **/
	public function completedOrders() {
		//$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		//'processing', 'on-hold'
		//'status' => ['completed'],
		$paged = isset($_GET['paged']) ? $_GET['paged'] : 1;
		$query_args = [
				'paged' => $paged,
				'status' => ['completed'],
		    'orderby' => 'modified',
		    'order' => 'DESC',
				'paginate' => true
				// 'meta_key' => 'wh_order_status',
				// 'meta_value' => 'complete'
		];

		$orders = wc_get_orders( $query_args );

		$data = [
      'title' => 'Completed Orders',
			'orders' => $orders,
			'app' => 'index',
			'order_status' => 'done'
    ];

		return $data;
	}

	/**
	 * get all woo complete orders.
	 **/
	public function woo_completed_orders() {
		//$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		$paged = isset($_GET['paged']) ? $_GET['paged'] : 1;

		$query_args = [
	    'paginate' => true,
			'paged' => $paged,
			'status' => ['completed'],
	    'orderby' => 'date',
	    'order' => 'DESC',
		];

		$orders = wc_get_orders( $query_args );

    $data = [
      'title' => 'Orders',
			'orders' => $orders
    ];

		return $data;
	}

	/**
	 * get all orders.
	 **/
	public function all() {
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		$query_args = [
	    'paginate' => true,
			'paged' => $paged,
	    'orderby' => 'date',
	    'order' => 'DESC',
		];
		$orders = wc_get_orders( $query_args );

    $data = [
      'title' => 'Orders',
			'orders' => $orders
    ];
		return $data;
	}


}//

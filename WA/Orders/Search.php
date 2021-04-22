<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Search by order related.
 * https://github.com/woocommerce/woocommerce/wiki/wc_get_orders-and-WC_Order_Query#customer
 * @since 0.0.1
 * */
class WA_Orders_Search {
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
    add_action('wa-loop-list-after-nav', [$this, 'show']);
  }

  public function search( $args = [] ) {

  }

	public function results() {

		$search = '';
		if ( isset( $_POST['search-orders'] ) ) {
			$search = sanitize_text_field( $_POST['search-orders'] );
			$search_obj = new WC_Order_Data_Store_CPT;
	    $search = $search_obj->search_orders( $search );

	    $args = array(
	      'post__in' => $search,
				'limit' => -1,
	    );
	    $orders = wc_get_orders( $args );

			$data = [
				'title' => 'Search Results',
				'orders' => $orders,
				'app' => 'search',
				'order_status' => 'search-results'
			];

			//WWH_View::get_instance()->public_partials( 'orders/office/list.php', $data );
		}
	}

  public function show() {
    $data = [];
		$search = '';
		if ( isset($_GET['search']) ) {
				$search = sanitize_text_field( $_GET['search'] );
		}
		$data = [
			'search_orders' => $search
		];

    WA_View::get_instance()->admin_partials( 'orders/search.php', $data );
  }

}//

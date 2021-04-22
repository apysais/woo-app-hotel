<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Data base related.
 * @since 0.0.1
 * */
class WA_Warehouse_Notes {
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

	public function getOrderNote( $arg = [] ) {
		$order_id = isset($arg['order_id']) ? $arg['order_id'] : false;
    if ( $order_id ) {

			$comment_args = [
				'post_id' => $order_id,
				'type' => 'woo_warehouse_order',
			];
			return get_comments($comment_args);
		}
		return false;
	}

	public function warehouseComment( $arg = [] ) {
		$order_id = isset($arg['order_id']) ? $arg['order_id'] : false;
    if ( $order_id ) {
      $note = isset($arg['note']) ? $arg['note'] : false;
      //set status
      //add order note, internally
      if ( $note ) {
        wp_insert_comment([
					'comment_post_ID' => $order_id,
					'comment_author' => 'woo warehouse',
					'comment_agent' => 'woo warehouse',
					'comment_content' => $note,
					'comment_type' => 'woo_warehouse_order'
				]);
      }
    }
	}

}//

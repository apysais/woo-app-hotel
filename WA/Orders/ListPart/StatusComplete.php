<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Notes related.
 * @since 0.0.1
 * */
class WA_Orders_ListPart_StatusComplete {
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

  public function show( $args = [] ) {
		$page = isset( $args['page'] ) ? $args['page'] : sanitize_text_field( $_GET['page'] );
		if ( isset( $args['redirect'] ) ) {
			$redirect = $args['redirect'];
		} elseif ( isset($_GET['redirect']) ) {
			$redirect = sanitize_text_field( $_GET['redirect'] );
		} else {
			$redirect = $page;
		}
    $data = [
      'order_id' => $args['order_id'],
      'order' => $args['order'],
			'admin_page' => $page,
			'redirect' => $redirect,
    ];
    WA_View::get_instance()->admin_partials( 'orders/loop-parts/status-complete.php', $data );
  }

}//

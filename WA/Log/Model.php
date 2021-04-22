<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
use Carbon\Carbon;
/**
 * WA_Log_Model
 * */
class WA_Log_Model {
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

  public function log() {

  }

  public function log_per_page_meta( $post_id, $value ) {

  }

	public function get_logs($post_id) {
		global $wpdb;

		$query = "SELECT * FROM ".$wpdb->prefix."postmeta WHERE post_id = ".$post_id." AND meta_key LIKE 'wh_log_action_time%'";
		$sql = $wpdb->get_results($query);

		return $sql;
	}

	public function show_log_status( $args = [] ) {

		$get_data = [];
		$status = isset( $args['status'] ) ? esc_html( $args['status'] ) : false;
	  $post_id = isset( $args['post_id'] ) ? esc_html( $args['post_id'] ) : false;

		$get_logs = $this->get_logs($post_id);

		if ( $get_logs ) {
			foreach( $get_logs as $meta_key => $meta_val ) {
				$get_meta_val = unserialize($meta_val->meta_value);

				$get_meta_val['user_info'] = '';

				if ( isset( $get_meta_val['user_id'] ) ) {
					$user_info = get_userdata($get_meta_val['user_id']);
					$get_meta_val['user_info'] = $user_info;
				}

				$get_meta_key = $meta_val->meta_key;
				$get_meta_val['key'] = $get_meta_key;

				$get_data[] = $get_meta_val;
			}
		}
		$data = ['content' => $get_data];
		WA_View::get_instance()->admin_partials( 'log/status.php', $data );
	}

}//

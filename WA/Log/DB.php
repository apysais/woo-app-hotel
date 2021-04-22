<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Carbon\Carbon;

/**
 * WA_Log_DB
 * */
class WA_Log_DB {
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

	public function __construct() {}

	/**
	* Use to log the change of status
	* [{timestamp}, {user_id}]
	**/
  public function log_action_time( $args = [] ) {
    $prefix = 'wh_log_action_time_';
		$status = isset( $args['status'] ) ? $args['status'] : false;

    if ( isset ( $args['post_id'] ) && $status ) {

      $defaults = array(
        'single'  => false,
        'action'  => 'r',
        'value'   => '',
        'prefix'  => $prefix . $status
      );

      $args = wp_parse_args( $args, $defaults );

      switch ( $args['action'] ) {
        case 'c':
          add_post_meta( $args['post_id'], $args['prefix'], $args['value'] );
          break;
        case 'd':
          delete_post_meta( $args['post_id'], $args['prefix'], $args['value'] );
          break;
        case 'u':
          update_post_meta( $args['post_id'], $args['prefix'], $args['value'] );
          break;
        case 'r':
          return get_post_meta( $args['post_id'], $args['prefix'], $args['single'] );
          break;
      }//switch
    }//if isset
  }//log

  public function log_action_user( $args = [] ) {
    $prefix = 'wh_log_action_user_';
		$status = isset( $args['status'] ) ? $args['status'] : false;
		$user_id = isset( $args['user_id'] ) ? $args['user_id'] : false;
    if ( isset ( $args['post_id'] ) && $status ) {

      $defaults = array(
        'single'  => false,
        'action'  => 'r',
        'value'   => '',
        'prefix'  => $prefix . '_' . $status . '_' . $user_id
      );

      $args = wp_parse_args( $args, $defaults );

      switch ( $args['action'] ) {
        case 'd':
          delete_post_meta( $args['post_id'], $args['prefix'], $args['value'] );
          break;
        case 'u':
          update_post_meta( $args['post_id'], $args['prefix'], $args['value'] );
          break;
        case 'r':
          return get_post_meta( $args['post_id'], $args['prefix'], $args['single'] );
          break;
      }//switch
    }//if isset
  }//log

}//

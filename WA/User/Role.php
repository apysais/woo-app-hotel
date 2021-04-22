<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * User.
 * @since 0.0.1
 * */
class WA_User_Role {
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

  public function add() {
		add_role( 'warehouse_role', 'Kitchen', get_role( 'author' )->capabilities );
		//add_role( 'delivery_role', 'Delivery', get_role( 'author' )->capabilities );
		add_role( 'local_pickup_role', 'Reception', get_role( 'author' )->capabilities );
		//add_role( 'production_role', 'Production', get_role( 'author' )->capabilities );

		$shop_manager_role = get_role( 'shop_manager' )->capabilities;
		add_role( 'store_owner_role', 'Office', $shop_manager_role );
	}

	public function remove() {
		remove_role( 'warehouse_role' );
		remove_role( 'local_pickup_role' );
		//remove_role( 'delivery_role' );
		//remove_role( 'production_role' );
		remove_role( 'store_owner_role' );
	}

  public function user_role() {
    $user = wp_get_current_user();

    return $user->roles;
  }

  public function is_logged_in() {
    return is_user_logged_in();
  }

  public function is_admin() {
    if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
      return true;
    }
  }

  public function is_store_owner() {
    if ( is_user_logged_in() && in_array( 'store_owner_role', (array) $this->user_role() ) ) {
      return true;
    }
  }

  public function is_warehouse() {
    if ( is_user_logged_in() && in_array( 'warehouse_role', (array) $this->user_role() ) ) {
      return true;
    }
  }

  public function is_local_pickup() {
    if ( is_user_logged_in() && in_array( 'local_pickup_role', (array) $this->user_role() ) ) {
      return true;
    }
  }

  public function is_office() {
    if ( is_user_logged_in() && in_array( 'shop_manager', (array) $this->user_role() ) ) {
      return true;
    }
  }

  public function is_shop_manager() {
    if ( is_user_logged_in() && (current_user_can('manage_woocommerce') || current_user_can('editor')) ) {
      return true;
    }
  }


}//

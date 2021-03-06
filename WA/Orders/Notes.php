<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Notes related.
 * @since 0.0.1
 * */
class WA_Orders_Notes {
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
   * get notes.
   * type : internal, customer or blank
   */
  public function get( $args = [] ) {
    $order_id = isset($args['order_id']) ? $args['order_id'] : false;
    // use 'internal' for admin and system notes, empty for all
    $type = isset($args['type']) ? $args['type'] : 'internal';

    if ( $order_id ) {
      $arg_notes = [
        'order_id' => $order_id,
        'type'     => $type,
      ];
      $notes = wc_get_order_notes( $arg_notes );

      return $notes;
    }
    return false;
  }

  /**
   * display note.
   */
  public function showInternal( $order_id, $customer_note = '' ) {
    $notes = $this->get([
      'order_id' => $order_id,
      'type' => 'internal'
    ]);
    $notes_customer = $this->get([
      'order_id' => $order_id,
      'type' => 'customer'
    ]);
    $data = [
      'notes' => $notes,
      'notes_customer' => $notes_customer,
			'customer_note' => $customer_note
    ];

		return $data;
  }

  /**
   * display note.
   */
  public function showCustomer( $order_id ) {
    $notes = $this->get([
      'order_id' => $order_id,
      'type' => 'customer'
    ]);
    $data = [
      'notes' => $notes
    ];

		return $data;
  }

  /**
   * display note.
   */
  public function showWarehouse( $order_id ) {
    $notes = $this->get([
      'order_id' => $order_id,
      'type' => 'internal'
    ]);
    $data = [
      'notes' => $notes
    ];

		return $data;
  }

}//

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Orders Controller
 * */
class WA_Orders_Controller extends WA_Base {
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

	public function cancel_order() {
		if ( isset($_POST['order_id']) ) {
			$order_id = sanitize_text_field($_POST['order_id']);
			$order = new WC_Order($order_id);
			//Possible values: processing, on-hold, cancelled, completed
			$order->update_status( 'cancelled' );
		}
		$redirect = isset($_POST['redirect']) ? sanitize_text_field($_POST['redirect']) : 'orders';
		wa_redirect_to( admin_url('admin.php?page='.$redirect) );
	}

	public function view_order() {
		$data = [];
		add_action('wa-top-dashboard-full-width', [WA_Orders_Index::get_instance(), 'order_details'] );
		WA_Dashboard_Index::get_instance()->show_dashboard(['data'=>$data]);
	}

	public function edit_order() {
		$data = [];
		add_action('wa-top-dashboard-full-width', [WA_Orders_Index::get_instance(), 'edit_order'] );
		WA_Dashboard_Index::get_instance()->show_dashboard(['data'=>$data]);
	}

	public function search_orders() {
		$data = [];
		add_action('wa-top-dashboard-full-width', [WA_Orders_Index::get_instance(), 'search_orders'] );
		WA_Dashboard_Index::get_instance()->show_dashboard(['data'=>$data]);
	}

	public function complete_orders() {
		$data = [];
		add_action('wa-top-dashboard-full-width', [WA_Orders_Index::get_instance(), 'complete_orders'] );
		WA_Dashboard_Index::get_instance()->show_dashboard(['data'=>$data]);
	}

	public function update_order() {
		$order_id = false;
		if ( isset($_POST['order_id'] ) ) {
			$order_id = sanitize_text_field($_POST['order_id']);
		}
		if ( $order_id ) {

			if ( isset($_POST['status']) ) {
				$status = sanitize_text_field($_POST['status']);
				if ( $status == 'new' ) {
					WA_Orders_WareHouseStatus::get_instance()->order_status([
						'post_id' => $order_id,
						'action'  => 'd'
					]);
				} else {
					WA_Orders_WareHouseStatus::get_instance()->order_status([
						'post_id' => $order_id,
						'action'  => 'u',
			      'value'   => $status
					]);
				}

			}

			if ( isset($_POST['colli']) ) {
				$colli = sanitize_text_field($_POST['colli']);
				WA_Orders_Meta::get_instance()->colli([
					'post_id' => $order_id,
					'action'  => 'u',
		      'value'   => $colli
				]);
			}

			if ( isset($_POST['placement']) ) {
				$placement = sanitize_text_field($_POST['placement']);
				WA_Orders_Meta::get_instance()->placement([
					'post_id' => $order_id,
					'action'  => 'u',
		      'value'   => $placement
				]);
			}

			if ( isset($_POST['warehouse_comment_id']) && isset($_POST['warehouse_note']) ) {
				$warehouse_comment_id = sanitize_text_field($_POST['warehouse_comment_id']);
				$warehouse_note = sanitize_text_field($_POST['warehouse_note']);
				$commentarr = [
					'comment_ID' => $warehouse_comment_id,
					'comment_content' => $warehouse_note
				];
				wp_update_comment( $commentarr );
			}

			if ( isset($_POST['customer_note']) ) {
				$customer_note = sanitize_text_field($_POST['customer_note']);
				$order_post = array(
					 'ID'           => $order_id,
					 'post_excerpt' => $customer_note,
				 );
				// Update the post into the database
				wp_update_post( $order_post );
			}

			if ( isset($_POST['bill_firstname']) ) {
				$bill_firstname = sanitize_text_field($_POST['bill_firstname']);
				update_post_meta( $order_id, '_billing_first_name', $bill_firstname );
			}

			if ( isset($_POST['bill_lastname']) ) {
				$bill_lastname = sanitize_text_field($_POST['bill_lastname']);
				update_post_meta( $order_id, '_billing_last_name', $bill_lastname );
			}

			if ( isset($_POST['bill_company']) ) {
				$bill_company = sanitize_text_field($_POST['bill_company']);
				update_post_meta( $order_id, '_billing_company', $bill_company );
			}

			if ( isset($_POST['bill_address1']) ) {
				$bill_address1 = sanitize_text_field($_POST['bill_address1']);
				update_post_meta( $order_id, '_billing_address_1', $bill_address1 );
			}

			if ( isset($_POST['bill_address2']) ) {
				$bill_address2 = sanitize_text_field($_POST['bill_address2']);
				update_post_meta( $order_id, '_billing_address_2', $bill_address2 );
			}

			if ( isset($_POST['bill_city']) ) {
				$bill_city = sanitize_text_field($_POST['bill_city']);
				update_post_meta( $order_id, '_billing_city', $bill_city );
			}

			if ( isset($_POST['bill_postcode']) ) {
				$bill_postcode = sanitize_text_field($_POST['bill_postcode']);
				update_post_meta( $order_id, '_billing_postcode', $bill_postcode );
			}

			if ( isset($_POST['bill_email']) ) {
				$bill_email = sanitize_text_field($_POST['bill_email']);
				update_post_meta( $order_id, '_billing_email', $bill_email );
			}

			if ( isset($_POST['bill_telefon']) ) {
				$bill_telefon = sanitize_text_field($_POST['bill_telefon']);
				update_post_meta( $order_id, '_billing_phone', $bill_telefon );
			}
			//shipping
			if ( isset($_POST['ship_firstname']) ) {
				$ship_firstname = sanitize_text_field($_POST['ship_firstname']);
				update_post_meta( $order_id, '_shipping_first_name', $ship_firstname );
			}

			if ( isset($_POST['ship_lastname']) ) {
				$ship_lastname = sanitize_text_field($_POST['ship_lastname']);
				update_post_meta( $order_id, '_shipping_last_name', $ship_lastname );
			}

			if ( isset($_POST['ship_company']) ) {
				$ship_company = sanitize_text_field($_POST['ship_company']);
				update_post_meta( $order_id, '_shipping_company', $ship_company );
			}

			if ( isset($_POST['ship_address1']) ) {
				$ship_address1 = sanitize_text_field($_POST['ship_address1']);
				update_post_meta( $order_id, '_shipping_address_1', $ship_address1 );
			}

			if ( isset($_POST['ship_address2']) ) {
				$ship_address2 = sanitize_text_field($_POST['ship_address2']);
				update_post_meta( $order_id, '_shipping_address_2', $ship_address2 );
			}

			if ( isset($_POST['ship_city']) ) {
				$ship_city = sanitize_text_field($_POST['ship_city']);
				update_post_meta( $order_id, '_shipping_city', $ship_city );
			}

			if ( isset($_POST['ship_postcode']) ) {
				$ship_postcode = sanitize_text_field($_POST['ship_postcode']);
				update_post_meta( $order_id, '_shipping_postcode', $ship_postcode );
			}

		}
		wa_redirect_to( admin_url('admin.php?page=orders&_method=edit-order&order-id='.$order_id) );
	}

	public function complete() {
		$order_id = false;
		if ( isset($_POST['order_id']) ) {
			$order_id = sanitize_text_field( $_POST['order_id'] );
			$order = wc_get_order( $order_id );
	    $order->update_status( 'completed' );
			WA_Orders_WareHouseStatus::get_instance()->setToCompleted($order_id);
			WA_Pusher_Push::get_instance()->notifyWareHouse();
		}
		$redirect = isset($_POST['redirect']) ? sanitize_text_field($_POST['redirect']) : 'app-dashboard';
		wa_redirect_to( admin_url('admin.php?page='.$redirect) );
	}

	public function ready() {
		if ( isset($_POST['order_id']) ) {
			$order_id = sanitize_text_field( $_POST['order_id'] );
			WA_Orders_WareHouseStatus::get_instance()->setToReady($order_id);

			$colli = isset($_POST['colli']) ? sanitize_text_field( $_POST['colli'] ) : '';
			$placement = isset($_POST['placement']) ? sanitize_text_field( $_POST['placement'] ) : '';
			WA_Orders_Meta::get_instance()->colli([
				'post_id' => $order_id,
				'action' => 'u',
				'value' => $colli
			]);
			WA_Orders_Meta::get_instance()->placement([
				'post_id' => $order_id,
				'action' => 'u',
				'value' => $placement
			]);

			wa_db_log_status([
				'previous_status' => wa_get_release_status(),
				'status' => wa_get_ready_status(),
				'post_id' => $order_id
			]);

			WA_Pusher_Push::get_instance()->notifyWareHouse();
		}
		$redirect = isset($_POST['redirect']) ? sanitize_text_field($_POST['redirect']) : 'app-dashboard';
		wa_redirect_to( admin_url('admin.php?page='.$redirect) );
	}

	public function done() {
		if ( isset($_POST['order_id']) ) {
			$order_id = sanitize_text_field( $_POST['order_id'] );
			WA_Orders_WareHouseStatus::get_instance()->setToDone($order_id);

			wa_db_log_status([
				'previous_status' => wa_get_ready_status(),
				'status' => wa_get_done_status(),
				'post_id' => $order_id
			]);

			WA_Pusher_Push::get_instance()->notifyWareHouse();
		}
		$redirect = isset($_POST['redirect']) ? sanitize_text_field($_POST['redirect']) : 'app-dashboard';
		wa_redirect_to( admin_url('admin.php?page='.$redirect) );
	}

	public function working() {
		if ( isset($_POST['order_id']) ) {
			$order_id = sanitize_text_field( $_POST['order_id'] );
			WA_Orders_WareHouseStatus::get_instance()->setToWorking($order_id);

			WA_Pusher_Push::get_instance()->notifyWareHouse();
		}
		$redirect = isset($_POST['redirect']) ? sanitize_text_field($_POST['redirect']) : 'app-dashboard';
		wa_redirect_to( admin_url('admin.php?page='.$redirect) );
	}

	public function set_release()	{

		if ( isset( $_POST['order_id'] ) ) {
			$order_id = sanitize_text_field( $_POST['order_id'] );

			$note = '';
			if ( isset( $_POST['commentWarehouse'] ) ) {
				$note = sanitize_text_field( $_POST['commentWarehouse'] );
			}

			WA_Orders_DB::get_instance()->setNewOrder([
				'order_id' => $order_id,
				'note' => $note,
			]);

			wa_db_log_status([
				'previous_status' => wa_get_new_status(),
				'status' => wa_get_release_status(),
				'post_id' => $order_id
			]);

			if ( isset( $_POST['importantOrder'] ) ) {
				WA_Orders_Meta::get_instance()->important([
					'post_id' => $order_id,
					'action' => 'u',
					'value' => 1
				]);
			}

			WA_Pusher_Push::get_instance()->notifyWareHouse();
		}
		$redirect = isset($_POST['redirect']) ? sanitize_text_field($_POST['redirect']) : 'app-dashboard';
		wa_redirect_to( admin_url('admin.php?page='.$redirect) );
	}

	/**
	 * Controller
	 *
	 * @param	$action		string | empty
	 * @parem	$arg		array
	 * 						optional, pass data for controller
	 * @return mix
	 * */
	public function controller($action = '', $arg = array()){
		$this->call_method($this, $action);
	}

	public function __construct(){}

}

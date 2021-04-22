<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function wa_db_log( $args = [] ) {
	WA_Log_DB::get_instance()->log_action_time( $args );
}

function wa_show_db_log_timeline( $args = [] ) {
	$status = isset($args['status']) ? esc_html($args['status']) : '';
	$order_id = isset($args['post_id']) ? esc_html($args['post_id']) : '';

	WA_Log_Model::get_instance()->show_log_status([
		'status' => $status,
		'post_id' => $order_id,
	]);
}

function wa_db_log_status( $args = [] ) {
  $current_user = wp_get_current_user();
  $timestamp = isset( $args['timestamp'] ) ? esc_html( $args['timestamp'] ) : current_time( 'timestamp' );
  $previous_status = isset( $args['previous_status'] ) ? esc_html( $args['previous_status'] ) : '';
  $status = isset( $args['status'] ) ? esc_html( $args['status'] ) : false;
  $user_id = isset( $args['user_id'] ) ? esc_html( $args['user_id'] ) : esc_html( $current_user->ID );
  $post_id = isset( $args['post_id'] ) ? esc_html( $args['post_id'] ) : false;

  if ( $status && $user_id && $post_id ) {
    WA_Log_DB::get_instance()->log_action_time([
      'post_id' => $post_id,
      'status' => $status,
      'action' => 'c',
      'value' => ['time' => $timestamp, 'user_id' => $user_id, 'status' => $status, 'previous_status' => $previous_status]
    ]);
  }

}

function wa_db_log_get_status( $args = [] ) {
  $status = isset( $args['isset'] ) ? esc_html( $args['status'] ) : false;
  $post_id = isset( $args['post_id'] ) ? esc_html( $args['post_id'] ) : false;
  if ( $status && $post_id ) {
    WA_Log_DB::get_instance()->log_action_time([
      'post_id' => $post_id,
      'status' => $status,
      'action' => 'r',
    ]);
  }
}

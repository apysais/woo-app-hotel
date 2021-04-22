<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function wa_route_dashboard() {
  return admin_url('admin.php?page=app-dashboard');
}
function wa_route_local() {
  return admin_url('admin.php?page=orders-pickup');
}
function wa_route_ready() {
  return admin_url('admin.php?page=orders-ready');
}
function wa_route_done() {
  return admin_url('admin.php?page=orders-done');
}
function wa_route_complete() {
  return admin_url('admin.php?page=orders-complete');
}

function wa_redirect_dashboard() {
  wa_redirect_to( wa_route_dashboard() );
}
function wa_redirect_local() {
  wa_redirect_to( wa_route_local() );
}
function wa_redirect_done() {
  wa_redirect_to( wa_route_done() );
}
function wa_redirect_complete() {
  wa_redirect_to( wa_route_complete() );
}

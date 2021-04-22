<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function wa_get_release_status() {
  return WA_Orders_WareHouseStatus::get_instance()->get_status('released');
}
function wa_get_new_status() {
  return WA_Orders_WareHouseStatus::get_instance()->get_status('new');
}
function wa_get_working_status() {
  return WA_Orders_WareHouseStatus::get_instance()->get_status('working');
}
function wa_get_ready_status() {
  return WA_Orders_WareHouseStatus::get_instance()->get_status('ready');
}
function wa_get_done_status() {
  return WA_Orders_WareHouseStatus::get_instance()->get_status('done');
}
function wa_get_complete_status() {
  return WA_Orders_WareHouseStatus::get_instance()->get_status('complete');
}

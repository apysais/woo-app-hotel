<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'admin_bar_menu', 'remove_links_toolbar', 999 );
function remove_links_toolbar($wp_admin_bar)
{
 global $wp_admin_bar;

 if ( wa_is_warehouse() || wa_is_office() || wa_is_store_owner() || wa_is_local_pickup() ) {
   $wp_admin_bar->remove_menu('theme-dashboard');
   $wp_admin_bar->remove_menu('wpseo-kwresearch');
   $wp_admin_bar->remove_menu('wp-logo');
   $wp_admin_bar->remove_menu('about');
   $wp_admin_bar->remove_menu('wporg');
   $wp_admin_bar->remove_menu('documentation');
   $wp_admin_bar->remove_menu('new-content');
   $wp_admin_bar->remove_menu('new-post');
   $wp_admin_bar->remove_menu('new-media');
   $wp_admin_bar->remove_menu('comments');
   $wp_admin_bar->remove_menu('updates');
   $wp_admin_bar->remove_menu('logo');
 }

}
function wptutsplus_change_post_menu_label() {
    global $menu;
    global $submenu;
    if ( wa_is_warehouse() || wa_is_local_pickup() ) {
			foreach($menu as $k => $v) {
				unset($menu[$k]);
			}
    } elseif ( wa_is_office() || wa_is_store_owner() ) {
			foreach($menu as $k => $v) {
				if ( $k != '55.5' && $k != '26' ) {
					unset($menu[$k]);
				}
			}
		}
}
add_action( 'admin_menu', 'wptutsplus_change_post_menu_label' );

function redirect_warehouse( $redirect_to, $request, $user ){
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        if ( in_array( 'warehouse_role', $user->roles )
							|| in_array( 'store_owner_role', $user->roles )
							|| in_array( 'local_pickup_role', $user->roles )  
				) {
            $redirect_to = admin_url('admin.php?page=app-dashboard'); // Your redirect URL
        }
    }
    return $redirect_to;
}
add_filter( 'login_redirect', 'redirect_warehouse', 10, 3 );

// customize admin bar css
function override_admin_bar_css() {
   if ( wa_is_office() || wa_is_store_owner() ) { ?>
      <style type="text/css">
         /* add your style here */
				 #toplevel_page_wc-admin-path--analytics-revenue{
					 display: none !important;
				 }
      </style>
   <?php }
}
// on backend area
add_action( 'admin_head', 'override_admin_bar_css' );

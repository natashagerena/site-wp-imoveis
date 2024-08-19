<?php


// -----------------------------------------------------------------------------
// Custom admin scripts
// -----------------------------------------------------------------------------
function vex_admin_scripts() {
	wp_enqueue_style( 'vex-inc-admin', get_template_directory_uri() . '/core/assets/css/custom-admin.css' );
}

add_action( 'admin_enqueue_scripts', 'vex_admin_scripts' );
add_action( 'login_enqueue_scripts', 'vex_admin_scripts' );


// -----------------------------------------------------------------------------
// Remove logo from admin bar
// -----------------------------------------------------------------------------
function vex_admin_adminbar_remove_logo() {
	global $wp_admin_bar;

	$wp_admin_bar->remove_menu( 'wp-logo' );
}

add_action( 'wp_before_admin_bar_render', 'vex_admin_adminbar_remove_logo' );


// -----------------------------------------------------------------------------
// Custom Footer
// -----------------------------------------------------------------------------
function vex_admin_footer() {
	echo '<a target="_blank" href="http://www.natashagerena.com.br">Desenvolvido por natashagerena</a>';
}

add_filter( 'admin_footer_text', 'vex_admin_footer' );


// -----------------------------------------------------------------------------
// Custom logo URL
// -----------------------------------------------------------------------------
function vex_admin_logo_url() {
	return home_url();
}

add_filter( 'login_headerurl', 'vex_admin_logo_url' );


// -----------------------------------------------------------------------------
// Custom logo title
// -----------------------------------------------------------------------------
function vex_admin_logo_title() {
	return get_bloginfo( 'name' );
}

add_filter( 'login_headertitle', 'vex_admin_logo_title' );


// -----------------------------------------------------------------------------
// Remove widgets dashboard
// -----------------------------------------------------------------------------
function vex_admin_remove_dashboard_widgets() {
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
}

add_action( 'wp_dashboard_setup', 'vex_admin_remove_dashboard_widgets' );


// -----------------------------------------------------------------------------
// Remove Welcome Panel
// -----------------------------------------------------------------------------
remove_action( 'welcome_panel', 'wp_welcome_panel' );


// -----------------------------------------------------------------------------
// Remove Tabs panel
// -----------------------------------------------------------------------------
function mytheme_remove_help_tabs($old_help, $screen_id, $screen){
    $screen->remove_help_tabs();
    return $old_help;
}
add_filter( 'contextual_help', 'mytheme_remove_help_tabs', 999, 3 );
add_filter('screen_options_show_screen', '__return_false');


// -----------------------------------------------------------------------------
// Remove Page Parent
// -----------------------------------------------------------------------------
function hide_meta_box_attributes( $hidden, $screen) {

    $hidden[] = 'pageparentdiv';
    return $hidden;

} 
add_filter('hidden_meta_boxes', 'hide_meta_box_attributes', 10, 2);
<?php

/**
 Plugin Name: sradiobfm
 Plugin URI: http://www.samwordpressplugin.com
 Version: 0.6
 Description: SAM Broadcaster Plugin for Wordpress
 Author: King Singh
 Author URI: http://www.samwordpressplugin.com
 License: Commercial. For personal use only. Not to give away or resell
*/

function sradiobfm_admin() {
    include('sradiobfm_admin_settings.php');
}
function sradiobfm_admin_actions(){
    add_options_page("RadioDatabaseOptions","RadioDatabaseOptions", 1, "RadioDatabaseOptions", "sradiobfm_admin");
}
add_action('admin_menu','sradiobfm_admin_actions');
require_once( dirname( __FILE__ ) . '/includes/functions.php' );
require_once( dirname( __FILE__ ) . '/includes/nowplaying.php' );

//require_once('/home/bollywood/public_html/wp-config.php');

wp_enqueue_style( 'sradiobfm-css', plugins_url( '/css/sradio.css', __FILE__ ) );
wp_enqueue_style( 'sradiobfm-css2', plugins_url( '/css/allstyle.css', __FILE__ ) );
?>

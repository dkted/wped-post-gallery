<?php
/*
Plugin Name: WPED Post Gallery
Plugin URI: http://ed.orgel.xyz/wp/wped-post-gallery
Description: WPED Post Gallery
Version: 1.0.0
Author: Ed
Author URI: https://ed.orgel.xyz
License: GPLv2 or later
Text Domain: wped-post-gallery
*/

defined('ABSPATH') or die("You're in invalid URL");

if (file_exists(dirname(__FILE__).'/vendor/autoload.php')) {
	require_once dirname(__FILE__).'/vendor/autoload.php';
}

define('WPEDPG', 'wpedpg');
define('WPEDPG_PATH', plugin_dir_path(__FILE__));
define('WPEDPG_URL', plugin_dir_url(__FILE__));
define('WPEDPG_BASENAME', plugin_basename(__FILE__));
define('WPEDPG_NAME', 'wpedpg_plugin');

function wpedpg_activate() { WPED\Base\Activate::activate(); }
register_activation_hook( __FILE__, 'wpedpg_activate' );

function wpedpg_deactivate() { WPED\Base\Deactivate::deactivate(); }
register_activation_hook( __FILE__, 'wpedpg_deactivate' );

if (class_exists('WPED\\Init')) {
	WPED\Init::register_services();
}
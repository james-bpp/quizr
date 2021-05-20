<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://ja.mes
 * @since             1.0.0
 * @package           Quizr
 *
 * @wordpress-plugin
 * Plugin Name:       Quizr
 * Plugin URI:        http://wordpress.org/quizr
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            James
 * Author URI:        http://ja.mes
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       quizr
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'QUIZR_VERSION', '1.4.5' );

define( 'QUIZR_DB_VERSION', '1.0.3' );

define( 'QUIZR_BASE_NAME', plugin_basename( __FILE__ ) );
define( 'QUIZR_BASE_PATH', plugin_dir_path( __DIR__ ) . 'quizr' );
define( 'QUIZR_ADMIN_PATH', plugin_dir_path( __DIR__ ) . 'quizr/admin' );
define( 'QUIZR_PUBLIC_PATH', plugin_dir_path( __DIR__ ) . 'quizr/public' );
define( 'QUIZR_LOG_PATH', plugin_dir_path( __DIR__ ) . 'quizr/logs/debug.log' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-quizr-activator.php
 */
function activate_quizr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quizr-activator.php';
	Quizr_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-quizr-deactivator.php
 */
function deactivate_quizr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quizr-deactivator.php';
	Quizr_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_quizr' );
register_deactivation_hook( __FILE__, 'deactivate_quizr' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-quizr.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_quizr() {

	$plugin = new Quizr();
	$plugin->run();

}
run_quizr();

<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.0
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       UitDB plugin
 * Description:       This is a plugin to import events from the UitDB.
 * Version:           1.0.0
 * Author:            Mark Kusters
 * Text Domain:       uitdb-plugin
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
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_uitdb_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-uitdb-plugin-activator.php';
	UitdbPlugin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_uitdb_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-uitdb-plugin-deactivator.php';
	UitdbPlugin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_uitdb_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_uitdb_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-uitdb-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_uitdb_plugin() {

	$plugin = new UitdbPlugin();
	$plugin->run();

}
run_uitdb_plugin();
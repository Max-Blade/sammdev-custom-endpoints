<?php

/**
 * @wordpress-plugin
 * Plugin Name:       SammDev Custom Endpoints
 * Plugin URI:        https://github.com/Max-Blade/sammdev-custom-endpoints/
 * Description:       This pulgins allows the user to add new endpoits to the api of wordpress.
 * Version:           1.0.0
 * Author:            Samuel Ramos
 * Author URI:        https://github.com/Max-Blade/
 * Author Mail:		  samm.blackmail@gmail.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sammdev-custom-endpoints
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('SD_CE_DIR_PATH', plugin_dir_path( __FILE__ ));

require_once SD_CE_DIR_PATH . 'options.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sammdev-custom-endpoints-activator.php
 */
function activate_sd_ce() {
	require_once SD_CE_INCLUDES . 'class-sammdev-custom-endpoints-activator.php';
	SammDev_Custom_Endpoints_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sammdev-custom-endpoints-deactivator.php
 */
function deactivate_sd_ce() {
	require_once SD_CE_INCLUDES . 'class-sammdev-custom-endpoints-deactivator.php';
	SammDev_Custom_Endpoints_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sd_ce' );
register_deactivation_hook( __FILE__, 'deactivate_sd_ce' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require SD_CE_INCLUDES . 'class-sammdev-custom-endpoints.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sd_ce() {

	$plugin = new SammDev_Custom_Endpoints();
	$plugin->run();

}
run_sd_ce();

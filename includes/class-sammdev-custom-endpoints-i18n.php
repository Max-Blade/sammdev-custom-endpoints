<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    SammDev_Custom_Endpoints
 * @subpackage SammDev_Custom_Endpoints/includes
 */
class SammDev_Custom_Endpoints_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'sammdev-custom-endpoints',
			false,
			SD_CE_LANGUAGE_DIR
		);

	}



}

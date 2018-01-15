<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class UitdbPlugin_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        self::dropTables();
	}

	public function dropTables()
    {
        global $wpdb;

        $uitdb_events_table_name = $wpdb->prefix . 'uitdb_events';
        $uitdb_key_secret_table_name = $wpdb->prefix . 'uitdb_key_secret';
        $uitdb_options_table_name = $wpdb->prefix . 'uitdb_options';

        $sql = "DROP TABLE " . $uitdb_events_table_name ."," . $uitdb_key_secret_table_name . "," . $uitdb_options_table_name . ";";

        $wpdb->query($sql);
    }

}

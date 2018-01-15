<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    UitdbPlugin
 * @subpackage UitdbPlugin/includes
 * @author     Your Name <email@example.com>
 */
class UitdbPlugin_Activator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate() {
        self::createTables();
    }

    public function createTables()
    {
        global $wpdb;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        $uitdb_events_table_name = $wpdb->prefix . 'uitdb_events';
        $uitdb_key_secret_table_name = $wpdb->prefix . 'uitdb_key_secret';
        $uitdb_options_table_name = $wpdb->prefix . 'uitdb_options';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS " . $uitdb_events_table_name . "(
                cdb_id VARCHAR(50) NOT NULL,
                available_from DATETIME NOT NULL,
                available_to DATETIME NOT NULL,
                event_type VARCHAR(40) NOT NULL,
                latitude NUMERIC(11, 8) NOT NULL,
                longitude NUMERIC(11, 8) NOT NULL,
                address_no VARCHAR(10) NOT NULL,
                address VARCHAR(150) NOT NULL,
                zip_code VARCHAR(10) NOT NULL,
                city VARCHAR(150) NOT NULL,
                email VARCHAR(200) NOT NULL,
                long_description LONGTEXT NOT NULL,
                price DOUBLE PRECISION DEFAULT NULL,
                price_description VARCHAR(200) DEFAULT NULL,
                title VARCHAR(200) NOT NULL,
                media_link VARCHAR(300) DEFAULT NULL,
                UNIQUE INDEX UNIQ_3BAE0AA75B3F2E70 (cdb_id),
                PRIMARY KEY  (cdb_id)
        )". $charset_collate . ";";

        dbDelta($sql);

        $sql1 = "CREATE TABLE IF NOT EXISTS " . $uitdb_key_secret_table_name . "(
                id INTEGER(10) NOT NULL AUTO_INCREMENT,
                uitdb_key VARCHAR(150) NOT NULL,
                uitdb_secret VARCHAR(150) NOT NULL,
                PRIMARY KEY  (id)
        )". $charset_collate .";";

        dbDelta($sql1);

        $sql2 = "CREATE TABLE IF NOT EXISTS " . $uitdb_options_table_name . "(
                id INTEGER(10) NOT NULL AUTO_INCREMENT,
                uitdb_option_name VARCHAR(250) NOT NULL,
                uitdb_option_value LONGTEXT NOT NULL,
                PRIMARY KEY  (id)
        )". $charset_collate .";";

        dbDelta($sql2);
    }
}


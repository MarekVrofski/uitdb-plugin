<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */

switch ($_POST['type']){
    case 'keySecret':
        $ec = new UitdbPlugin_Admin();
        $store = $ec->ksCombo($_POST['key'], $_POST['secret']);
        break;
}

class UitdbPlugin_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $uitdb_plugin    The ID of this plugin.
	 */
	private $uitdb_plugin;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $uitdb_plugin       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $uitdb_plugin, $version ) {

		$this->uitdb_plugin = $uitdb_plugin;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->uitdb_plugin, plugin_dir_url( __FILE__ ) . 'css/uitdb-plugin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->uitdb_plugin, plugin_dir_url( __FILE__ ) . 'js/uitdb-plugin-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function admin_interface()
    {
        /**
         * add_menu_page( page_title, menu_title, capability, menu_slug, function )
         * add_submenu_page( parent_slug, page_title, menu_title, capability, menu_slug, function )
         */

        add_menu_page('UITDB Options', 'UITDB', 'manage_options', 'uitdb-beheer', 'uitdb_options');
        add_submenu_page( 'uitdb-beheer', 'Importeer', 'Importeer','manage_options','uitdb-import', 'uitdb_import');
        add_submenu_page( 'uitdb-beheer', 'Nieuw evenement handmatig', 'Nieuw evenement','manage_options','uitdb-new', 'uitdb_new');
        add_submenu_page( 'uitdb-beheer', 'Options', 'Options','manage_options','uitdb-options', 'uitdb_options_page');

        function uitdb_options()
        {
            require_once ( dirname(__FILE__) . '/partials/uitdb-plugin-admin-display.php');
        }

        function uitdb_import()
        {
            require_once ( dirname(__FILE__) . '/partials/uitdb-plugin-import-display.php');
        }

        function uitdb_new()
        {
            require_once ( dirname(__FILE__) . '/partials/uitdb-plugin-new-event-display.php');
        }

        function uitdb_options_page()
        {
            require_once ( dirname(__FILE__) . '/partials/uitdb-plugin-options-page-display.php');
        }
    }

    public function ksCombo($key, $secret)
    {
        global $wpdb;
        $tName = $wpdb->prefix . 'uitdb_key_secret';

        $q = "SELECT * FROM '$tName' WHERE uitdb_key = '$key' AND uitdb_secret = '$secret'";
        $indb = $wpdb->get_row($q, ARRAY_A);

        if($indb > 0){
            echo "<strong>Key: " . $key . " & Secret: " . $secret . " already exist</strong>";
        } else {
            $wpdb->insert(
                $tName,
                array(
                    'uitdb_key' => $key,
                    'uitdb_secret' => $secret
                ),
                array(
                    '%s',
                    '%s'
                )
            );

            if($wpdb == false){
                echo "<strong>Key & Secret niet opgeslagen</strong>";
            }elseif($wpdb == true){
                echo "<strong>Key & Secret opgeslagen</strong>";
            }
        }

        return;
    }

}

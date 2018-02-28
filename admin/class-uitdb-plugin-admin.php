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

/**
 * Include the autoload file
 */

require_once plugin_dir_path( dirname( __FILE__)) . 'vendor/autoload.php';
require_once plugin_dir_path( dirname( __FILE__)) . 'includes/uitdbMessage.php';

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use GuzzleHttp\Psr7;

switch ($_POST['type']){
    case 'keySecret':
        $ec = new UitdbPlugin_Admin( $uitdb_plugin, $version );
        $store = $ec->ksCombo($_POST['key'], $_POST['secret'], $_POST['id']);
        break;
    case 'importEvents':
        $ec = new UitdbPlugin_Admin( $uitdb_plugin, $version );
        $store = $ec->importEvents();
        break;
    case 'loadEventsAuto':
        $ec = new UitdbPlugin_Admin( $uitdb_plugin, $version );
        $store = $ec->loadEventsAuto($_POST['autoloadYes'], $_POST['autoloadNo'], $_POST['timespan']);
        break;
    case 'updateEvent':
        $ec = new UitdbPlugin_Admin( $uitdb_plugin, $version );
        $store = $ec->updateEvent($_POST['cdbid'], $_POST['available_from'], $_POST['available_to'], $_POST['event_type'], $_POST['latitude'], $_POST['longitude'], $_POST['address_no'], $_POST['address'], $_POST['zip_code'], $_POST['city'], $_POST['email'], $_POST['long_description'], $_POST['price'], $_POST['price_description'], $_POST['title'], $_POST['media_link']);
        break;
    case 'deleteEvent':
        $ec = new UitdbPlugin_Admin( $uitdb_plugin, $version );
        $delete = $ec->deleteEvent($_POST['cdb_id'], $_POST['deleteEventChoice']);
        break;
    case 'keywords':
        $ec = new UitdbPlugin_Admin( $uitdb_plugin, $version);
        $store = $ec->storeKeywords($_POST['id'], $_POST['keyword']);
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

    public function storeKeywords($id, $keywords)
    {
        global $wpdb;
        $tName = $wpdb->prefix . 'uitdb_options';
        $oName = 'keyword';

        $indb = $wpdb->get_results("SELECT * FROM $tName WHERE uitdb_option_name = '$oName'");

        if( isset($id) && !empty($id) ) {
            $wpdb->query( $wpdb->prepare(
                "UPDATE $tName SET uitdb_option_value = '%s' WHERE id = '%s'",
                array(
                    $keywords,
                    $id
                )
            ));
        } else if ( empty($id) && empty($indb) ) {
            $wpdb->insert(
                $tName,
                array(
                    'uitdb_option_name' => $oName,
                    'uitdb_option_value' => $keywords
                ),
                array(
                    '%s',
                    '%s'
                )
            );
        }
        return;

    }

    public function showKeywords()
    {
        global $wpdb;
        $tName = $wpdb->prefix . 'uitdb_options';
        $oName = 'keyword';
        $vName = 'uitdb_option_value';

        $q = "SELECT id, $vName FROM $tName WHERE uitdb_option_name = '$oName'";
        $result = $wpdb->get_row($q, ARRAY_A);

        return $result;
    }

    public function ksCombo($key, $secret, $id)
    {
        global $wpdb;
        $tName = $wpdb->prefix . 'uitdb_key_secret';

        if( isset($id) && !empty($id) ) {
            $wpdb->query( $wpdb->prepare(
                "UPDATE $tName SET uitdb_key = '%s', uitdb_secret = '%s' WHERE id = '%s'",
                array(
                    $key,
                    $secret,
                    $id
                )
            ));
        } else if ( empty($id) ) {
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
        }
        return;
    }

    public function showKsCombo()
    {
        global $wpdb;
        $tName = $wpdb->prefix . 'uitdb_key_secret';

        $q = "SELECT * FROM $tName";
        $result = $wpdb->get_row($q, ARRAY_A);

        return $result;
    }

    public function importEvents()
    {
        $countError = 0;
        $countGood = 0;

        global $wpdb;
        $tName = $wpdb->prefix . 'uitdb_events';
        $ksCombo = $this->showKsCombo();

        $key = $ksCombo['uitdb_key'];
        $secret = $ksCombo['uitdb_secret'];
        $base_url = 'https://www.uitid.be/';

        $stack = HandlerStack::create();
        $middleware = new Oauth1([
            'consumer_key' => $key,
            'consumer_secret' => $secret,
            'token' => '',
            'token_secret' => ''
        ]);
        $stack->push($middleware);

        $client = new Client([
            'base_uri' => $base_url,
            'handler' => $stack,
            'auth' => 'oauth'
        ]);

        try {

            $keyword = $this->showKeywords();
            $keyword = $keyword['uitdb_option_value'];

            if( !empty($keyword) ) {
                $response = $client->get('uitid/rest/searchv2/search', ['query' => [
                    'q' => '*:* keywords:$keyword',
                    'start' => 0,
                    'rows' => 300,
                    'sort' => 'startdate asc'
                ]]);
            } else if( empty($keyword) ) {
                $response = $client->get('uitid/rest/searchv2/search', ['query' => [
                    'q' => '*:*',
                    'start' => 0,
                    'rows' => 300,
                    'sort' => 'startdate asc'
                ]]);
            }

            $response = (string)$response->getBody();
            $prefix = 'cdb';
            $xml = simplexml_load_string($response, 'SimpleXMLElement', 0, $prefix, true);

            foreach($xml->event as $xmlEvent) {
                $cdbid = $xmlEvent->attributes()->cdbid->__toString();

                $q = "SELECT * FROM $tName WHERE cdb_id = '$cdbid'";
                $indb = $wpdb->get_row($q, ARRAY_A);

                if($indb > 0) {
                    $countError++;
                } else {
                    /**
                     * cdbid            ->  continue                            ---
                     * availablefrom    ->  now                                 ---
                     * availableto      ->  1 month from now                    ---
                     * eventtype        ->  default eventtype                   ---
                     * xcoordinate      ->  0                                   ---
                     * ycoordinate      ->  0                                   ---
                     * housenr          ->  empty                               --- handled by db
                     * street           ->  not provided or empty               --- handled by db
                     * zipcode          ->  not provided or empty               --- handled by db
                     * city             ->  not provided or empty               --- handled by db
                     * mail             ->  not provided or empty               --- handled by db
                     * longdescription  ->  no description provided or empty    --- handled by db
                     * price            ->  0                                   ---
                     * priceDesc        ->  not provided or empty               ---
                     * title            ->  continue                            ---
                     * media            ->  default image or not available      ---
                     */

                    if(empty($xmlEvent->attributes()->cdbid->__toString())) {
                        continue;
                    }

                    if(empty($xmlEvent->eventdetails->eventdetail->title->__toString())) {
                        continue;
                    }

                    if(empty($xmlEvent->attributes()->availablefrom->__toString())) {
                        $availableFrom = date('Y-m-d');
                    } else {
                        $availableFrom = date('Y-m-d', strtotime($xmlEvent->attributes()->availablefrom->__toString()));
                    }

                    if(empty($xmlEvent->attributes()->availableto->__toString())) {
                        $availableTo = date('Y-m-d', strtotime('+1 month'));
                    } else {
                        $availableTo = date('Y-m-d', strtotime($xmlEvent->attributes()->availableto->__toString()));
                    }

                    if(empty($xmlEvent->categories->category->attributes()->type->__toString())) {
                        $eventType = "event";
                    } else {
                        $eventType = $xmlEvent->categories->category->attributes()->type->__toString();
                    }

                    if(empty($xmlEvent->contactinfo->address->physical->gis->xcoordinate->__toString())) {
                        $xAxis = 0;
                    } else {
                        $xAxis = $xmlEvent->contactinfo->address->physical->gis->xcoordinate->__toString();
                    }

                    if(empty($xmlEvent->contactinfo->address->physical->gis->ycoordinate->__toString())) {
                        $yAxis = 0;
                    } else {
                        $yAxis = $xmlEvent->contactinfo->address->physical->gis->ycoordinate->__toString();
                    }

                    /**
                     * @todo rewrite this to add default image instead of not available
                     */
                    if ($xmlEvent->eventdetails->eventdetail->media->file == null){
                        $media = "not available";
                    } else {
                        $media = $xmlEvent->eventdetails->eventdetail->media->file->hlink->__toString();
                    }

                    /**
                     *
                        if($xmlEvent->eventdetails->eventdetail->price->pricevalue == null){
                            $price = "0";
                        } else {
                            $price = $xmlEvent->eventdetails->eventdetail->price->pricevalue;
                        }

                        if ($xmlEvent->eventdetails->eventdetail->price->pricedescription == null) {
                            $priceDesc = "not available";
                        } else {
                            $priceDesc = $xmlEvent->eventdetails->eventdetail->price->pricedescription->__toString();
                        }
                     */

                    $wpdb->query( $wpdb->prepare(
                        "INSERT INTO $tName (cdb_id, available_from, available_to, event_type, latitude, longitude, address_no, address, zip_code, city, email, long_description, price, price_description, title, media_link) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
                        array(
                            $xmlEvent->attributes()->cdbid->__toString(),
                            $availableFrom,
                            $availableTo,
                            $eventType,
                            $xAxis,
                            $yAxis,
                            $xmlEvent->contactinfo->address->physical->housenr->__toString(),
                            $xmlEvent->contactinfo->address->physical->street->__toString(),
                            $xmlEvent->contactinfo->address->physical->zipcode->__toString(),
                            $xmlEvent->contactinfo->address->physical->city->__toString(),
                            $xmlEvent->contactinfo->mail->__toString(),
                            $xmlEvent->eventdetails->eventdetail->longdescription->__toString(),
                            $xmlEvent->eventdetails->eventdetail->price->pricevalue,
                            $xmlEvent->eventdetails->eventdetail->price->pricedescription->__toString(),
                            $xmlEvent->eventdetails->eventdetail->title->__toString(),
                            $media
                        )
                    ));

                    if($wpdb == false){

                    }elseif($wpdb == true){
                        $countGood++;
                    }
                }
            }
            new uitdbMessage("$countGood are imported", "success");
            new uitdbMessage("$countError aren't imported because they exist", "error");
        }

        catch (\GuzzleHttp\Exception\RequestException $e) {
            echo Psr7\str($e->getRequest());
            if($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }

        return;
    }

    public function eventsOverview($limit, $offset)
    {
        global $wpdb;
        $tName = $wpdb->prefix . 'uitdb_events';

        $events = $wpdb->get_results("SELECT * FROM $tName ORDER BY available_to ASC LIMIT $offset, $limit");

        return $events;
    }

    public function requestAllEvents()
    {
        global $wpdb;
        $tName = $wpdb->prefix . 'uitdb_events';

        $events = $wpdb->get_results("SELECT * FROM $tName");

        return $events;
    }

    public function editEvent($cdbid)
    {
        global $wpdb;
        $tName = $wpdb->prefix . 'uitdb_events';

        $eventResult = $wpdb->get_row("SELECT * FROM $tName WHERE cdb_id = '$cdbid'");

        return $eventResult;
    }

    public function updateEvent($cdbid, $available_from, $available_to, $event_type, $latitude, $longitude, $address_no, $address, $zipcode, $city, $email, $long_description, $price, $price_description, $title, $media_link)
    {
        global $wpdb;
        $tName = $wpdb->prefix . 'uitdb_events';

        $wpdb->update(
            $tName,
            array(
                'title' => $title,
                'available_from' => $available_from,
                'available_to' => $available_to,
                'event_type' => $event_type,
                'address_no' => $address_no,
                'address' => $address,
                'zip_code' => $zipcode,
                'city' => $city,
                'email' => $email,
                'long_description' => $long_description,
                'price' => $price,
                'price_description' => $price_description,
                'longitude' => $longitude,
                'latitude' => $latitude,
                'media_link' => $media_link,
            ),
            array(
                'cdb_id' => $cdbid,
            )
        );

        return;
    }

    public function deleteEvent($cdbid, $choice)
    {
        if($choice === 'yes'){
            global $wpdb;
            $tName = $wpdb->prefix . 'uitdb_events';

            $q = "SELECT * FROM $tName WHERE cdb_id = '$cdbid'";
            $indb = $wpdb->get_row($q, ARRAY_A);

            if($indb > 0) {
                $qdelete = "DELETE FROM $tName WHERE cdb_id = '$cdbid'";
                $wpdb->query($qdelete);
                echo "<strong>event with: " . $cdbid . " Deleted</strong>";

                $url = get_site_url() . '/wp-admin/admin.php?page=uitdb-beheer';

                header("Location: " . $url );

            } else {
                Echo "<strong>Could not delete, record does not exist</strong>";

                $url = get_site_url() . '/wp-admin/admin.php?page=uitdb-beheer';

                header("Location: " . $url );
            }
        }
    }

    public function loadEventsAuto($autoloadYes, $autoloadNo, $timespan)
    {
        global $wpdb;
        $tName = $wpdb->prefix . 'uitdb_options';
        $oName = "autoload";

        $selectQ = "SELECT * FROM $tName WHERE uitdb_option_name = '$oName'";

        $indb = $wpdb->get_row($selectQ, ARRAY_A);

        if ($indb > 0) {
            if (strtolower($indb['uitdb_option_value']) === 'yes' || strtolower($autoloadNo) === 'no') {
                $wpdb->query( $wpdb->prepare(
                    "UPDATE $tName SET uitdb_option_value = '%s' WHERE uitdb_option_name = '%s'",
                    array(
                        $autoloadNo,
                        $oName
                    )
                ));

                wp_clear_scheduled_hook('cliv_recurring_cron_job');

            } else if (strtolower($indb['uidb_option_value']) === 'no' || strtolower($autoloadYes) === 'yes') {
                $autoloadTypeTimespan = "{type:" . strtolower($autoloadYes) . ", timespan:" . $timespan . "}";

                $wpdb->query( $wpdb->prepare(
                    "UPDATE $tName SET uitdb_option_value = '%s' WHERE uitdb_option_name = '%s'",
                    array(
                        $autoloadTypeTimespan,
                        $oName
                    )
                ));

                wp_clear_scheduled_hook('cliv_recurring_cron_job');

                $this->actualAutoload();
            }
            return;
        } else {
            if ( !isset($autoloadYes) && strtolower($autoloadNo) === 'no') {
                $result = $wpdb->get_row($selectQ, ARRAY_A);

                if ($result < 1) {
                    $wpdb->query( $wpdb->prepare(
                        "INSERT INTO $tName (uitdb_option_name, uitdb_option_value) VALUES ( %s, %s)",
                        array(
                            $oName,
                            $autoloadNo
                        )
                    ));

                    if ($wpdb === false) {
                        echo "Niet opgeslagen";
                    } else if ($wpdb === true) {
                        echo "Opgeslagen";
                    }
                }
                return;
            } else if (strtolower($autoloadYes) === 'yes' && !isset($autoloadNo)) {
                $autoloadTypeTimespan = "{type:" . strtolower($autoloadYes) . ", timespan:" . $timespan . "}";
                $result = $wpdb->get_row($selectQ, ARRAY_A);

                if ($result < 1) {
                    $wpdb->query( $wpdb->prepare(
                        "INSERT INTO $tName (uitdb_option_name, uitdb_option_value) VALUES ( %s, %s)",
                        array(
                            $oName,
                            $autoloadTypeTimespan
                        )
                    ));

                    $this->actualAutoload();

                    if ($wpdb === false) {
                        echo "Niet opgeslagen";
                    } else if ($wpdb === true) {
                        echo "Opgeslagen";
                    }
                }
                return;
            }
        }
    }

    public function showAutoload()
    {
        global $wpdb;
        $tName = $wpdb->prefix . 'uitdb_options';
        $oName = "autoload";

        $q = "SELECT * FROM $tName WHERE uitdb_option_name = '$oName'";
        $result = $wpdb->get_row($q, ARRAY_A);

        return $result;
    }

    public function actualAutoload() {
        // Call function for cron
        add_action('init', array( $this, 'send_emails_to_users') );
    }

    public function send_emails_to_users() {
        if(!wp_next_scheduled('cliv_recurring_cron_job')) {
            // Add "cliv_recurring_cron_job" action so it fire every hour
            wp_schedule_event(time(), $_POST['timespan'], 'cliv_recurring_cron_job');
        }
    }
}

function do_not_send_a_email() {
    $testEC = new UitdbPlugin_Admin();
    $testEC->importEvents();
}

add_action('cliv_recurring_cron_job', 'do_not_send_a_email' );
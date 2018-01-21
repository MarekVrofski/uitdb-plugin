<?php
/**
 * Created by PhpStorm.
 * User: markprive
 * Date: 21/01/2018
 * Time: 11:54
 */

switch ($_POST['type']){
    case 'keySecret':
        $ec = new uitdbController();
        $store = $ec->ksCombo($_POST['key'], $_POST['secret']);
        break;
}

class uitdbController
{
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
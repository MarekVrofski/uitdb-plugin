<?php
/**
 * Created by PhpStorm.
 * User: markprive
 * Date: 21/01/2018
 * Time: 11:17
 */

require_once (__FILE__);

$ec = new UitdbPlugin_Admin( $uitdb_plugin, $version );
$ksCombo = $ec->showKsCombo();
$aLoad = $ec->showAutoload();

/**
 * todo: update this so it is a form where you can delete/update the key/secret
 */

?>
<h1>Options</h1>

<div class="wrap">
    <form action="<?php __FILE__ ?>" method="post">
        <input type="hidden" name="type" value="keySecret">
        <table class="table table-striped table-wrap">
            <thead>
            <tr>
                <th colspan="4">Key & Secret</th>
            </tr>
            </thead>
            <tr>
                <td><label for="key">Key:</label></td>
                <td><input class="table-wrap-ks" type="text" name="key" placeholder="<?php echo isset($ksCombo) ? $ksCombo['uitdb_key'] : 'Key'; ?>" value="<?php echo isset($ksCombo) ? $ksCombo['uitdb_key'] : 'Key'; ?>"/></td>
                <td></td>
            </tr>
            <tr>
                <td><label for="secret">Secret:</label></td>
                <td><input class="table-wrap-ks" type="text" name="secret" placeholder="<?php echo isset($ksCombo) ? $ksCombo['uitdb_secret'] : 'Secret'; ?>" value="<?php echo isset($ksCombo) ? $ksCombo['uitdb_secret'] : 'Secret'; ?>"/></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit">Key & Secret gebruiken</button></td>
                <td><button type="submit">Key & Secret updaten</button></td>
            </tr>
        </table>
    </form>

    <hr/>

    <form action="<?php __FILE__ ?>" method="post">
        <input type="hidden" name="type" value="loadEventsAuto">
        <table class="table table-striped table-wrap">
            <thead>
            <tr>
                <th colspan="2">Extra options</th>
            </tr>
            </thead>
            <tr>
                <td><label for="autoload">Autoload (daily):</label></td>
                <td></td>
            </tr>
            <tr>
                <fieldset id="autoload">
                    <td colspan="2">
                        <label>Yes:</label>
                        <input type="radio" value="Yes" name="autoloadYes">
                        <label>No:</label>
                        <input type="radio" value="No" name="autoloadNo">
                    </td>
                </fieldset>
            </tr>
            <tr>
                <fieldset id="autoloadDuration">
                    <td colspan="2">
                        <label>Hourly:</label>
                        <input type="radio" value="hourly" name="hourly">
                        <label>Twicedaily:</label>
                        <input type="radio" value="twicedaily" name="twicedaily">
                        <label>Daily:</label>
                        <input type="radio" value="daily" name="daily">
                    </td>
                </fieldset>
            </tr>
            <tr>
                <td>Currently set:</td>
                <td><?php echo $aLoad['uitdb_option_value']; ?></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit">Save options</button></td>
            </tr>
        </table>
    </form>
</div>
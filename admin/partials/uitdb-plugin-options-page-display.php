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
        <table>
            <tr>
                <th>Key & Secret</th>
                <th></th>
            </tr>
            <tr>
                <td><label for="key">Key:</label></td>
                <td><input type="text" name="key" placeholder="<?php echo isset($ksCombo) ? $ksCombo['uitdb_key'] : 'Key'; ?>"/></td>
            </tr>
            <tr>
                <td><label for="secret">Secret:</label></td>
                <td><input type="text" name="secret" placeholder="<?php echo isset($ksCombo) ? $ksCombo['uitdb_secret'] : 'Secret'; ?>"/></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit">Key & Secret gebruiken</button></td>
            </tr>
        </table>
    </form>

    <hr/>

    <form action="<?php __FILE__ ?>" method="post">
        <input type="hidden" name="type" value="loadEventsAuto">
        <table>
            <tr>
                <th>Extra options</th>
                <th></th>
            </tr>
            <tr>
                <td><label for="autoload">Autoload (daily):</label></td>
                <td></td>
            </tr>
            <tr>
                <fieldset id="autoload">
                    <td>
                        <label>Yes:</label>
                        <input type="radio" value="Yes" name="autoloadYes">
                        <label>No:</label>
                        <input type="radio" value="No" name="autoloadNo">
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
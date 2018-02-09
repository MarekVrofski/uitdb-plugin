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
$keyword = $ec->showKeywords();

?>
<h1>Options</h1>

<div class="wrap">
    <form action="<?php __FILE__ ?>" method="post">
        <input type="hidden" name="type" value="keySecret">
        <input type="hidden" name="id" value="<?php echo isset($ksCombo['id']) ? $ksCombo['id']:''; ?>">
        <table class="table table-striped table-wrap">
            <thead>
            <tr>
                <th colspan="4">Key & Secret</th>
            </tr>
            </thead>
            <tr>
                <td><label for="key">Key:</label></td>
                <td><input class="table-wrap-ks" type="text" name="key" placeholder="<?php echo isset($ksCombo) ? $ksCombo['uitdb_key'] : 'Key'; ?>" value="<?php echo isset($ksCombo) ? $ksCombo['uitdb_key'] : 'Key'; ?>"/></td>
            </tr>
            <tr>
                <td><label for="secret">Secret:</label></td>
                <td><input class="table-wrap-ks" type="text" name="secret" placeholder="<?php echo isset($ksCombo) ? $ksCombo['uitdb_secret'] : 'Secret'; ?>" value="<?php echo isset($ksCombo) ? $ksCombo['uitdb_secret'] : 'Secret'; ?>"/></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit">Key & Secret <?php echo isset($ksCombo) ? 'updaten' : 'gebruiken'; ?></button></td>
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
                    <td>
                        <label>Timespan:</label>
                    </td>
                    <td>
                        <select name="timespan">
                            <option value="hourly">Hourly</option>
                            <option value="twicedaily">Twice daily</option>
                            <option value="daily">Daily</option>
                        </select>
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

    <hr/>

    <form action="<?php __FILE__ ?>" method="post">
        <input type="hidden" name="type" value="keywords">
        <input type="hidden" name="id" value="<?php echo isset($keyword['id']) ? $keyword['id']:''; ?>">
        <table class="table table-striped table-wrap">
            <thead>
            <tr>
                <th colspan="2">Keyword:</th>
            </tr>
            </thead>
            <tr>
                <td><label for="keyword">Keyword:</label></td>
                <td><input class="table-wrap-ks" type="text" name="keyword" placeholder="<?php echo isset($keyword) ? $keyword['uitdb_option_value'] : 'Keyword'; ?>" value="<?php echo isset($keyword) ? $keyword['uitdb_option_value'] : ''; ?>"/></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit">Save Keyword</button>
                </td>
            </tr>
        </table>
    </form>

    <hr/>
</div>
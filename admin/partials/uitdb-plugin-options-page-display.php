<?php
/**
 * Created by PhpStorm.
 * User: markprive
 * Date: 21/01/2018
 * Time: 11:17
 */

require_once (__FILE__);

$ec = new UitdbPlugin_Admin( $uitdb_plugin, $version );
$result = $ec->showKsCombo();

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
                <td><input type="text" name="key" placeholder="<?php echo isset($result) ? $result['uitdb_key'] : 'Key'; ?>"/></td>
            </tr>
            <tr>
                <td><label for="secret">Secret:</label></td>
                <td><input type="text" name="secret" placeholder="<?php echo isset($result) ? $result['uitdb_secret'] : 'Secret'; ?>"/></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit">Key & Secret gebruiken</button></td>
            </tr>
        </table>
    </form>
</div>
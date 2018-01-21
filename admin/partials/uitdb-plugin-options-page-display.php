<?php
/**
 * Created by PhpStorm.
 * User: markprive
 * Date: 21/01/2018
 * Time: 11:17
 */

require_once (__DIR__) . '/../controller/uitdbController.php';

?>
<h1>Options</h1>

<div class="wrap">
    <form action="<?php __DIR__ . '/../controller/uitdbController.php' ?>" method="post">
        <input type="hidden" name="type" value="keySecret">
        <table>
            <tr>
                <th>Key & Secret</th>
                <th></th>
            </tr>
            <tr>
                <td><label for="key">Key:</label></td>
                <td><input type="text" name="key" placeholder="<?php echo $result['uitdb_key']; ?>"/></td>
            </tr>
            <tr>
                <td><label for="secret">Secret:</label></td>
                <td><input type="text" name="secret" placeholder="<?php echo $result['uitdb_secret']; ?>"/></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit">Key & Secret gebruiken</button></td>
            </tr>
        </table>
    </form>
</div>
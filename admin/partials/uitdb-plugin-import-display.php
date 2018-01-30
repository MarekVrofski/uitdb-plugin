<?php
/**
 * Created by PhpStorm.
 * User: markprive
 * Date: 17/01/2018
 * Time: 13:26
 */

require_once (__FILE__);

?>
<h1>Import</h1>
<div class="wrap">
    <form action="<?php __FILE__ ?>" method="post">
        <input type="hidden" name="type" value="importEvents">
        <button type="submit">Importeer evenementen</button>
    </form>
</div>
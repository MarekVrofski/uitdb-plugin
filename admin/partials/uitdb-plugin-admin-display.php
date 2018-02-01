<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin/partials
 */

require_once (__FILE__);

$ec = new UitdbPlugin_Admin( $uitdb_plugin, $version );
$events = $ec->eventsOverview();

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h1>Beheer</h1>
<div class="wrap table-wrap">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Titel</th>
            <th>Beschikbaar van</th>
            <th>Beschikbaar tot</th>
            <th colspan="2">Beheer</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($events as $event) {

            $afdate = strtotime($event->available_from);
            $atdate = strtotime($event->available_to);

            $afdatefin = date("d/m/Y", $afdate);
            $atdatefin = date("d/m/Y", $atdate);

            ?>
            <tr class="<?php echo strtotime($event->available_to) < time() ? 'text-danger' : 'text-success'; ?>">
                <td><?php echo $event->title; ?></td>
                <td><?php echo $afdatefin; ?></td>
                <td><?php echo $atdatefin; ?></td>
                <td>Pennetje</td>
                <td>Kruisje</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
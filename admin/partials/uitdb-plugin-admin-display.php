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

if(!empty($_GET['cdbid'] && $_GET['t'])){
    $cdbId = $_GET['cdbid'];
    $updateType = $_GET['t'];
}

if(empty($cdbId)){
    $allEvents = new UitdbPlugin_admin( $uitdb_plugin, $version );
    $allEvents = $allEvents->requestAllEvents();

    $limit = 10;
    $offset = 0;

    $totalEvents = count($allEvents);
    $totalPages = ceil($totalEvents/$limit);

    $currentPage = isset($_GET['paged']) ? $_GET['paged'] : 1;

    $nextPage = $currentPage + 1;

    if( $currentPage != 0 ){
        $prevPage = $currentPage -1;
    }

    isset($_GET['paged']) || $_GET['paged'] == 1 ? $offset = ($_GET['paged']-1) * $limit : $offset = 0 ;

    $ec = new UitdbPlugin_Admin( $uitdb_plugin, $version );
    $events = $ec->eventsOverview($limit, $offset);

    ?>

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
                    <td>
                        <a class="btn btn-sm btn-info" href="<?php echo admin_url('admin.php?page=uitdb-beheer&cdbid=' . $event->cdb_id . '&t=update') ?>">Update</a>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-danger" href="<?php echo admin_url('admin.php?page=uitdb-beheer&cdbid=' . $event->cdb_id . '&t=delete') ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td>
                    <?php echo $totalPages; ?>
                    <?php echo $currentPage; ?>
                    <?php echo $nextPage; ?>
                    <?php echo $offset; ?>
                </td>
                <td>
                    <?php echo $prevPage != 0 ? '<a class="btn btn-primary" href=' . admin_url("admin.php?page=uitdb-beheer&paged=" . $prevPage ) . '> &#60; Previous Page</a>' :''; ?>
                </td>
                <td>
                    <?php echo $_GET['paged'] == $totalPages ? '' : '<a class="btn btn-primary" href=' . admin_url('admin.php?page=uitdb-beheer&paged=' . $nextPage) . '>Next page &#62; </a>'; ?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <?php
} else if(!empty($cdbId) && $updateType === 'update') {
    $ec = new UitdbPlugin_Admin( $uitdb_plugin, $version );
    $singleEvent = $ec->editEvent($cdbId);

    $afdate = strtotime($singleEvent->available_from);
    $atdate = strtotime($singleEvent->available_to);

    $afdatefin = date("Y-m-d, H:m", $afdate);
    $atdatefin = date("Y-m-d, H:m", $atdate);

    $afdatefin = str_replace(", ", "T", $afdatefin);
    $atdatefin = str_replace(", ", "T", $atdatefin);

    ?>
    <h1>Bewerk</h1>
    <div class="wrap table-wrap">
        <form action="<?php __FILE__ ?>" method="post">
            <input type="hidden" name="cdbid" value="<?= $singleEvent->cdb_id; ?>"/>
            <input type="hidden" name="longitude" value="<?= $singleEvent->longitude; ?>"/>
            <input type="hidden" name="latitude" value="<?= $singleEvent->latitude; ?>"/>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th colspan="3"><?= $singleEvent->title; ?></th>
                </tr>
                </thead>
                <tr>
                    <th>Title</th>
                    <td colspan="2"><input style="width: 100%;" type="text" name="title" value="<?= $singleEvent->title; ?>"/></td>
                </tr>
                <tr>
                    <th>Available from</th>
                    <td>Currently set: <?= $singleEvent->available_from; ?></td>
                    <td><input style="width: 100%;" type="datetime-local" name="available_from" value="<?= $afdatefin; ?>"/></td>
                </tr>
                <tr>
                    <th>Available to</th>
                    <td>Currently set: <?= $singleEvent->available_to; ?></td>
                    <td><input style="width: 100%;" type="datetime-local" name="available_to" value="<?= $atdatefin; ?>"/></td>
                </tr>
                <tr>
                    <th>Event type</th>
                    <td colspan="2"><input style="width: 100%;" type="text" name="event_type" value="<?= $singleEvent->event_type; ?>"/></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td colspan="2"><input style="width: 100%;" type="text" name="address" value="<?= $singleEvent->address; ?>"/></td>
                </tr>
                <tr>
                    <th>Address No</th>
                    <td colspan="2"><input style="width: 100%;" type="text" name="address_no" value="<?= $singleEvent->address_no; ?>"/></td>
                </tr>
                <tr>
                    <th>Zipcode</th>
                    <td colspan="2"><input style="width: 100%;" type="text" name="zip_code" value="<?= $singleEvent->zip_code; ?>"/></td>
                </tr>
                <tr>
                    <th>City</th>
                    <td colspan="2"><input style="width: 100%;" type="text" name="city" value="<?= $singleEvent->city; ?>"/></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td colspan="2"><input style="width: 100%;" type="text" name="email" value="<?= $singleEvent->email; ?>"/></td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td colspan="2"><textarea style="width: 100%;" rows="5" name="long_description"><?= $singleEvent->long_description; ?></textarea></td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td colspan="2"><input style="width: 100%;" type="text" name="price" value="<?= $singleEvent->price; ?>"/></td>
                </tr>
                <tr>
                    <th>Price description</th>
                    <td colspan="2"><input style="width: 100%;" type="text" name="price_description" value="<?= $singleEvent->price_description; ?>"/></td>
                </tr>
                <tr>
                    <th>Media link</th>
                    <td colspan="2"><input style="width: 100%;" type="text" name="media_link" value="<?= $singleEvent->media_link; ?>"/></td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="hidden" name="type" value="updateEvent">
                        <button class="btn btn-sm btn-success" type="submit">Update</button>
                        <a href="<?php echo admin_url('admin.php?page=uitdb-beheer'); ?>" class="btn btn-sm btn-danger">Go back</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <?php
} else if(!empty($cdbId) && $updateType === 'delete') {
    $ec = new UitdbPlugin_Admin( $uitdb_plugin, $version );
    $singleEvent = $ec->editEvent($cdbId);
    ?>
    <h1>Delete</h1>
    <div class="wrap table-wrap">
        <form action="<?php __FILE__ ?>" method="post">
            <input type="hidden" value="deleteEvent" name="type"/>
            <input type="hidden" value="<?= $singleEvent->cdb_id; ?>" name="cdb_id"/>
            <p>Are you sure you want to delete event named <?= $singleEvent->title; ?>?</p>
            <button class="btn btn-sm btn-success" type="submit" name="deleteEventChoice" value="yes">Yes</button>
            <a href="<?php echo admin_url('admin.php?page=uitdb-beheer'); ?>" class="btn btn-sm btn-danger">No</a>
        </form>
    </div>
    <?php
}
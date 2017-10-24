<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\services\DirectionsWayPoint;
use dosamigos\google\maps\services\TravelMode;
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\services\DirectionsRequest;

use backend\assets\AdminLtePluginAsset;
AdminLtePluginAsset::register($this);

$coord = new LatLng(['lat' => $campus->campusLocation->latitude, 'lng' => $campus->campusLocation->longtitude]);
$map = new Map([
    'width' => '100%',
    'center' => $coord,
    'zoom' => 14,
]);

// Lets add a marker now
$marker = new Marker([
    'position' => $coord,
    'title' => $campus->name,
]);

// Provide a shared InfoWindow to the marker
$marker->attachInfoWindow(
    new InfoWindow([
        'content' => 
            '<b>' . $campus->name . '</b>' .
            '<p>' . $campus->campusLocation->street_address . '</p>' .
            '<p>' . $campus->campusLocation->postal_code . '</p>' . 
            '<p>' . $campus->campusLocation->city . ', ' . $campus->campusLocation->state_province . '</p>'
    ])
);

$map->addOverlay($marker);

$this->title = 'Campus';
?>
<div class="campus-view">

    
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Campus Detail</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <h2><?= $campus->name ?></h2>
                    <p>Website: <a href="http://<?= $campus->web ?>"><?= $campus->web ?></a></p>
                    <p>Location: </p>
                    <p><?= $campus->campusLocation->street_address ?></p>
                    <p><?= $campus->campusLocation->postal_code ?></p>
                    <p><?= $campus->campusLocation->city ?>, <?= $campus->campusLocation->state_province ?></p>
                    <?= $map->display() ?>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

</div>
<!-- /.campus-view -->
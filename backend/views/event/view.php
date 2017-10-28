<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

use yii\web\View;

use backend\assets\GmapsAsset;

GmapsAsset::register($this);

$this->registerJs(
    "
        function initMap() {
            var myLatLng = {
                lat: " . $event->eventLocation->latitude .",
                lng: " . $event->eventLocation->longtitude . "
            };
        
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: myLatLng
            });
        
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: '" . $event->name . "'
            });
        }
        google.maps.event.addDomListener(window, 'load', initMap);
    ",
    View::POS_READY,
    'load_map'
);

$this->title = 'Event';
$this->params['breadcrumbs'] = [
    ['label' => 'Event', 'url' => ['index']],
    ['label' => 'View', 'url' => ['view', 'id' => $event->event_id]]
];
?>
<div class="event-view">

    
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Event Detail</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4 col-xs-12 pull-right">
                            <?= Html::img('@web/img/events/' . $event->photo, ['alt'=>'Poster', 'class'=>'img-responsive img-thumbnail pull-right', 'width' => '300px']);?>
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <h2><?= $event->name ?></h2>
                            <p>Category: <?= $event->category->name ?></p>
                            <p>Campus: <?= $event->campus->name ?></p>
                            <p>Date: <?= $event->event_date ?></p>
                            <p>Description: </p>
                            <p><?= $event->description ?></p>
                            <p>Location: </p>
                            <p><?= $event->eventLocation->street_address ?></p>
                            <p><?= $event->eventLocation->postal_code ?></p>
                            <p><?= $event->eventLocation->city ?>, <?= $event->eventLocation->state_province ?></p>
                        </div>
                    </div>
                    <div id="map"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

</div>
<!-- /.event-view -->
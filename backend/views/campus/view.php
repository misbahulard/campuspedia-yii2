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
                lat: " . $campus->campusLocation->latitude .",
                lng: " . $campus->campusLocation->longtitude . "
            };
        
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: myLatLng
            });
        
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: '" . $campus->name . "'
            });
        }
        google.maps.event.addDomListener(window, 'load', initMap);
    ",
    View::POS_READY,
    'load_map'
);

$this->title = 'Campus';
$this->params['breadcrumbs'] = [
    ['label' => 'Campus', 'url' => ['index']],
    ['label' => 'View', 'url' => ['view', 'id' => $campus->campus_id]]
];
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
<!-- /.campus-view -->
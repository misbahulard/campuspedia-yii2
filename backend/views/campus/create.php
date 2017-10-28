<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\web\View;

use backend\assets\GmapsAsset;

GmapsAsset::register($this);

$this->registerJs(
    "
        function initMap() {
            var lat = parseFloat(document.getElementById('campuslocation-latitude').value);
            var lng = parseFloat(document.getElementById('campuslocation-longtitude').value);
            if (!isNaN(lat) && !isNaN(lng)) {
                var myLatLng = {lat: lat, lng: lng};
            } else {
                console.log('im here');
                var myLatLng = {lat: -7.258502, lng: 112.751810};
            }
        
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: myLatLng
            });
        
            var marker = new google.maps.Marker({
                draggable: true,
                position: myLatLng,
                map: map,
            });

            google.maps.event.addListener(marker, 'dragend', function (event) {
                document.getElementById('campuslocation-latitude').value = event.latLng.lat();
                document.getElementById('campuslocation-longtitude').value = event.latLng.lng();
            });

            google.maps.event.addListener(map, 'click', function (event) {
                document.getElementById('campuslocation-latitude').value = event.latLng.lat();
                document.getElementById('campuslocation-longtitude').value = event.latLng.lng();
                marker.setPosition(event.latLng);
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
    ['label' => 'Add', 'url' => ['create']]
];
?>
<div class="campus-view">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Add New Campus</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="row">
                        <div class="col-xs-12">
                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'add-campus-form',
                            ]) ?>
                                <?= $form->field($campus, 'name') ?>
                                <?= $form->field($campus, 'web') ?>
                                <?= $form->field($campus, 'imageFile')->fileInput() ?>
                                <?= $form->field($campusLocation, 'street_address') ?>
                                <?= $form->field($campusLocation, 'postal_code') ?>
                                <?= $form->field($campusLocation, 'city') ?>
                                <?php
                                    echo $form->field($campusLocation, 'state_province')->dropdownList(
                                        $provinces,
                                        ['prompt'=>'Select Province']
                                    );
                                ?>
                                <?= $form->field($campusLocation, 'latitude')->textInput(['readonly' => true]) ?>
                                <?= $form->field($campusLocation, 'longtitude')->textInput(['readonly' => true]) ?>

                                <div id="map"></div>
                            
                                <div class="form-group">
                                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                                </div>
                            <?php ActiveForm::end() ?>
                        </div>
                    </div>

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
 
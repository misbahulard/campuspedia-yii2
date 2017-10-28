<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\web\View;

use dosamigos\tinymce\TinyMce;
use kartik\date\DatePicker;

use backend\assets\GmapsAsset;

GmapsAsset::register($this);

$this->registerJs(
    "
        function initMap() {
            var lat = parseFloat(document.getElementById('eventlocation-latitude').value);
            var lng = parseFloat(document.getElementById('eventlocation-longtitude').value);
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
                document.getElementById('eventlocation-latitude').value = event.latLng.lat();
                document.getElementById('eventlocation-longtitude').value = event.latLng.lng();
            });

            google.maps.event.addListener(map, 'click', function (event) {
                document.getElementById('eventlocation-latitude').value = event.latLng.lat();
                document.getElementById('eventlocation-longtitude').value = event.latLng.lng();
                marker.setPosition(event.latLng);
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
    ['label' => 'Add', 'url' => ['create']]
];
?>
<div class="event-view">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Add New Event</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="row">
                        <div class="col-xs-12">
                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'add-event-form',
                            ]) ?>
                                <?= $form->field($event, 'name') ?>
                                <?php
                                    echo $form->field($event, 'campus_id')->dropdownList(
                                        $campuses,
                                        ['prompt'=>'Select Campus']
                                    )->label('Campus');
                                ?>
                                <?php
                                    echo $form->field($event, 'category_id')->dropdownList(
                                        $categories,
                                        ['prompt'=>'Select Category']
                                    )->label('Category');
                                ?>
                                <?php
                                    echo $form->field($event, 'event_date')->widget(DatePicker::classname(), [
                                        'options' => ['placeholder' => 'Event Date'],
                                        'pluginOptions' => [
                                            'format' => 'yyyy-mm-dd',
                                            'todayHighlight' => true,
                                            'autoclose'=>true
                                        ]
                                    ]);
                                ?>
                                <?= $form->field($event, 'imageFile')->fileInput() ?>
                                <?= $form->field($event, 'description')->widget(TinyMce::className(), [
                                    'options' => ['rows' => 16],
                                    'language' => 'en',
                                    'clientOptions' => [
                                        'plugins' => [
                                            "advlist autolink lists link charmap print preview anchor",
                                            "searchreplace visualblocks code fullscreen",
                                            "insertdatetime media table contextmenu paste"
                                        ],
                                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                                    ]
                                ]);?>
                                <?= $form->field($eventLocation, 'street_address') ?>
                                <?= $form->field($eventLocation, 'postal_code') ?>
                                <?= $form->field($eventLocation, 'city') ?>
                                <?php
                                    echo $form->field($eventLocation, 'state_province')->dropdownList(
                                        $provinces,
                                        ['prompt'=>'Select Province']
                                    );
                                ?>
                                <?= $form->field($eventLocation, 'latitude')->textInput(['readonly' => true]) ?>
                                <?= $form->field($eventLocation, 'longtitude')->textInput(['readonly' => true]) ?>
                                <?= $form->field($event, 'status')->hiddenInput(['value' => 1])->label(false) ?>

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
<!-- /.event-view -->
 
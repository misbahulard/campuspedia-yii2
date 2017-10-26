<?php

namespace backend\assets;

use yii\web\AssetBundle;

class GmapsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/map.css'
    ];
    public $js = [
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyCtqb2S0R5L-jBWGyuwhhgF51fMu2q1mlk'
    ];
    public $depends = [

    ];
}

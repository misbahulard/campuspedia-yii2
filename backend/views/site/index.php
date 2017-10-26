<?php

/* @var $this yii\web\View */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome <?= Yii::$app->user->identity->name ?></h1>

        <p class="lead">Have a nice day!</p>

    </div>

</div>

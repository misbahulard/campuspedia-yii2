<?php

use backend\assets\AdminLtePluginAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

AdminLtePluginAsset::register($this);

$this->title = 'Event';
$this->params['breadcrumbs'][] = ['label' => 'Event', 'url' => ['index']];
?>

<div class="event-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Event</h3>
                    <?= Html::a('Add new event', ['event/create'], ['class' => 'btn btn-success pull-right']) ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Campus</th>
                            <th>City</th>
                            <th>Poster</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($events as $event): ?>
                            <tr>
                                <td><?= $event->event_id ?></td>
                                <td><?= $event->name ?></td>
                                <td><?= $event->category->name ?></td>
                                <td><?= $event->campus->name ?></td>
                                <td><?= $event->eventLocation->city ?></td>
                                <td><?= Html::img(Yii::$app->urlManagerFrontend->createUrl('img/events/' . $event->photo), ['alt' => 'Poster', 'class' => 'img-responsive img-thumbnail', 'width' => '60']); ?></td>
                                <td>
                                    <a href="<?= Url::to(Url::base() . '/event/view?id=' . $event->event_id) ?>"
                                       class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                    <a href="<?= Url::to(Url::base() . '/event/edit?id=' . $event->event_id) ?>"
                                       class="btn btn-success"><i class="fa fa-edit"></i></a>
                                    <a href="<?= Url::to(Url::base() . '/event/delete?id=' . $event->event_id) ?>"
                                       class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Campus</th>
                            <th>City</th>
                            <th>Poster</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                    <?= LinkPager::widget(['pagination' => $pagination]) ?>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

</div>
<!-- /.event-index -->
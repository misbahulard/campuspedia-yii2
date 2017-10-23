<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use backend\assets\AdminLtePluginAsset;
AdminLtePluginAsset::register($this);

$this->title = 'Campus';
?>
<div class="campus-index">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Campus</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Web</th>
                            <th>City</th>
                            <th>Logo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($campuses as $campus): ?>
                        <tr>
                            <td><?= $campus->campus_id ?></td>
                            <td><?= $campus->name ?></td>
                            <td><?= $campus->web ?></td>
                            <td><?= $campus->campusLocation->city ?></td>
                            <td><?= Html::img('@web/img/campuses/' . $campus->logo, ['alt'=>'Logo', 'class'=>'img-responsive img-thumbnail', 'width' => '60']);?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Web</th>
                        <th>City</th>
                        <th>Logo</th>
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
<!-- /.campus-index -->
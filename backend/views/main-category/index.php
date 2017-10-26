<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\assets\AdminLtePluginAsset;
AdminLtePluginAsset::register($this);

$this->title = 'Campus';
$this->params['breadcrumbs'][] = ['label' => 'Campus', 'url' => ['index']];
?>

<div class="campus-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Main Category</h3>
                    <?= Html::a('Add new campus', ['campus/create'], ['class' => 'btn btn-success pull-right']) ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= $category->main_category_id ?></td>
                            <td><?= $category->name ?></td>
                            <td>
                                <a href="<?= Url::to(Url::base() . '/campus/view?id=' . $category->main_category_id) ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                <a href="<?= Url::to(Url::base() . '/campus/edit?id=' . $category->main_category_id) ?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                <a href="<?= Url::to(Url::base() . '/campus/delete?id=' . $category->main_category_id) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
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
<!-- /.campus-index -->
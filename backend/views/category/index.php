<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\assets\AdminLtePluginAsset;
AdminLtePluginAsset::register($this);

$this->title = 'Category';
$this->params['breadcrumbs'][] = ['label' => 'Category', 'url' => ['index']];
?>

<div class="campus-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Category</h3>
                    <?= Html::a('Add new category', ['category/create'], ['class' => 'btn btn-success pull-right']) ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Main Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= $category->category_id ?></td>
                            <td><?= $category->name ?></td>
                            <td><?= $category->mainCategory->name ?></td>
                            <td>
                                <a href="<?= Url::to(Url::base() . '/category/edit?id=' . $category->category_id) ?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                <a href="<?= Url::to(Url::base() . '/category/delete?id=' . $category->category_id) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Main Category';
$this->params['breadcrumbs'] = [
    ['label' => 'Main Category', 'url' => ['index']],
    ['label' => 'Add', 'url' => ['create']]
];
?>
<div class="main-category-view">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Add New Main Category</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="row">
                        <div class="col-xs-12">
                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'add-main-category-form',
                            ]) ?>
                                <?= $form->field($category, 'name') ?>
                            
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
 
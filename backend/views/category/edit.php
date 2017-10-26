<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Category';
$this->params['breadcrumbs'] = [
    ['label' => 'Category', 'url' => ['index']],
    ['label' => 'Edit', 'url' => ['edit']]
];
?>
<div class="main-category-view">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Edit Category</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="row">
                        <div class="col-xs-12">
                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'edit-main-category-form',
                            ]) ?>
                                <?= $form->field($category, 'name') ?>
                                <?php
                                    echo $form->field($category, 'main_category_id')->dropdownList(
                                        $mainCategories,
                                        ['prompt'=>'Select Main Category']
                                    );
                                ?>
                            
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
 
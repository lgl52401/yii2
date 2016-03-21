<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Route */
/* @var $form ActiveForm */
?>
<div class="aasdasdasd">

    <?php $form = ActiveForm::begin(); ?>
    <?= dosamigos\fileupload\FileUploadUI:: widget([
        $model=>'route_image_s',
    'attribute' => 'image',
    'load'=>'asdsd',
    'url' => ['home/imagesupload' ], // your url, this is just for demo purposes,
    'options' => ['accept' => 'image/*','multiple'=>"",],
    'clientOptions' => [
        'maxFileSize' => 2000000
    ],
    'clientEvents' => [
 'fileuploaddone' => 'function(e, data) {
                                console.log(e);
                             $("input[name=#route-duration]").val("Assad");
                                console.log( data.result.files[0].url);

                            }',
        'fileuploadfail' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
    ],
]);?>
        <?= $form->field($model, 'vendor_id') ?>
        <?= $form->field($model, 'duration') ?>
        <?= $form->field($model, 'advance') ?>
        <?= $form->field($model, 'status') ?>
        <?= $form->field($model, 'sort_order') ?>
        <?= $form->field($model, 'dep_id') ?>
        <?= $form->field($model, 'check_inventory') ?>
        <?= $form->field($model, 'date_start') ?>
        <?= $form->field($model, 'date_end') ?>
        <?= $form->field($model, 'created') ?>
        <?= $form->field($model, 'route_code') ?>
        
        <?= $form->field($model, 'timezone') ?>
  
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- aasdasdasd -->

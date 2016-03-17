<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Route */
/* @var $form ActiveForm */
?>
<div class="aasdasdasd">

    <?php $form = ActiveForm::begin(); ?>
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
        <?= $form->field($model, 'route_image') ?>
        <?= $form->field($model, 'timezone') ?>
       <input   type="hidden" value="<?php echo $model->route_id;?>" name="route_id">
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- aasdasdasd -->

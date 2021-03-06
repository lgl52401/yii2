<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin([
	'id'=>'account-form',
	'action' => Url::to(['main/account'],true),
	'enableAjaxValidation' => false,
	'validateOnSubmit'=>true,
	'enableClientScript'=>true,
	'fieldConfig'=>[
				'options'  => ['tag' => 'div','class' => 'form-group relative'],
				'template' => '<div class="field-flex">{label}<div class="col-sm-10">{input}{error}</div></div>',
				'labelOptions' => ['class' => 'control-label'],  
				]
	]); ?>
	<div class="modal-body">
		<div class="formMsg"></div>
		<?= $form->field($model,'username')->textInput(['placeholder'=>Yii::t('form_verify', 'form_validation_alpha_dash'),'disabled'=>'disabled']) ?>
		<?= $form->field($model,'password_old')->passwordInput(['placeholder'=>Yii::t('form_label', 'Please input').Yii::t('form_label', 'Password old')])?>
		<?= $form->field($model,'password')->passwordInput(['placeholder'=>Yii::t('form_label', 'Please input').Yii::t('form_label', 'Password new')])?>
		<?= $form->field($model,'password_rep')->passwordInput(['placeholder'=>Yii::t('form_label', 'Please input').Yii::t('form_label', 'Password rep')])?>
	</div>
	<div class="modal-footer">
		<button class="btn btn-danger btn-sm pull-right _closeModel" type="button" ><?php echo Yii::t('backend_html','Close');?> <i class="fa fa-close"></i></button>
		<?= Html::submitButton(Yii::t('backend_html', 'Save').' <i class="fa fa-save"></i>', ['class'=>'btn btn-primary btn-sm pull-right _save','data-option'=>'account-form','data-close'=>'1']) ?>
	</div>
<?php ActiveForm::end(); ?>
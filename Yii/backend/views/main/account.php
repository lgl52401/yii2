<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
?>

<?php $form = ActiveForm::begin([
	'id'=>'account-form',
	'action' => Url::to(['/account'],true),
	'enableAjaxValidation' => false,
	'validateOnSubmit'=>true,
	'enableClientScript'=>true,
	'fieldConfig'=>[
				'options'  => ['tag' => 'div','class' => 'form-group relative'],
				'template' => '<div class="field-flex">{label}{input}<div class="help-block">{error}</div></div>',
				]
	]); ?>
	<div class="modal-body">
		<?= $form->field($model,'username',['template' => '<i class="glyphicon glyphicon-user input-icons"></i>{input}<div class="help-block">{error}</div>'])->textInput(['placeholder'=>Yii::t('form_verify', 'form_validation_alpha_dash')]) ?>
		<?= $form->field($model,'password',['template' => '<i class="glyphicon glyphicon-lock input-icons"></i>{input}<div class="help-block">{error}</div>'])->passwordInput(['placeholder'=>Yii::t('form_label', 'Please input').Yii::t('form_label', 'Password')])?>
	</div>
	<div class="modal-footer">
		<button class="btn btn-danger btn-sm pull-right _closeModel" type="button" ><?php echo Yii::t('backend_html','Close');?> <i class="fa fa-close"></i></button>
		<?= Html::submitButton(Yii::t('backend_html', 'Save').' <i class="fa fa-save"></i>', ['class'=>'btn btn-primary btn-sm pull-right _save','data-option'=>'login-form','data-refresh'=>'1']) ?>
	</div>

<?php ActiveForm::end(); ?>

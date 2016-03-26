<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha; 
?>

<?php $form = ActiveForm::begin([
	'id'=>'login-form',
	'action' => Url::to(['/login'],true),
	'enableClientValidation' => true,
	'enableAjaxValidation' => false,
	'validateOnSubmit'=>true,
	'fieldConfig'=>[
				'options'  => ['tag' => 'div','class' => 'form-group relative'],
				'template' => '<div class="field-flex">{label}{input}{error}</div>',
				]
	]); ?>

	<div class="formMsg">
		<div class="alert alert-success">
			<i class="fa fa-check-circle"></i>
			<span></span>
			<button class="close" data-dismiss="alert" type="button">×</button>
		</div>
		<div class="alert alert-danger">
			<i class="fa fa-exclamation-circle"></i>
			<span></span>
			<button class="close" data-dismiss="alert" type="button">×</button>
		</div>
	</div>
	<?= $form->field($model,'username',['template' => '<i class="glyphicon glyphicon-user input-icons"></i>{input}<div class="help-block">{error}</div>'])->textInput(['placeholder'=>Yii::t('form_verify', 'form_validation_alpha_dash')])
	?>
	<?= $form->field($model,'password',['template' => '<i class="glyphicon glyphicon-lock input-icons"></i>{input}<div class="help-block">{error}</div>'])->passwordInput(['placeholder'=>Yii::t('form_label', 'Please input').Yii::t('form_label', 'Password')])?>
	<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
	'captchaAction'=>'tool/captcha',
	'options'=>['placeholder'=>'','class' => 'form-control'],
	'template' => '{input}{image}',
	'imageOptions'=>['class'=>'verifycode','alt'=>Yii::t('form_label', 'ClickMap'),'title'=>Yii::t('form_label', 'ClickMap'), 'style'=>'cursor:pointer']
	]) 
	?>
	<div class="form-group">
	<?= Html::submitButton(Yii::t('form_label', 'Sign in').'&nbsp;&nbsp;<i class="fa fa-key"></i>', ['class'=>'btn btn-primary pull-right btn-block _save','data-option'=>'login-form','data-refresh'=>'1']) ?>
	</div>
<!-- <section class="log-in">
	<?= Html::a('首页',null,['href'=>Url::toRoute('default/index'),'class'=>'btn btn-slategray']) ?>
</section> -->
<?php ActiveForm::end(); ?>

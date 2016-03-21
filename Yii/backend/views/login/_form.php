<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha; 
?>
<?php $form = ActiveForm::begin([
	'id'=>'form-signin',
	'fieldConfig'=>[
					'options'  => ['tag' => 'div','class' => 'form-group relative'],
					'template' => '<div class="field-flex">{label}{input}</div><div class="help-block">{error}</div>',
					]
	]); ?>
<section>
	<?= $form->field($model,'username',['template' => '<i class="glyphicon glyphicon-user input-icons"></i>{input}<div class="help-block">{error}</div>'])->textInput(['placeholder'=>Yii::t('form_verify', 'form_validation_alpha_dash')])
	?>
	<?= $form->field($model,'password',['template' => '<i class="glyphicon glyphicon-lock input-icons"></i>{input}<div class="help-block">{error}</div>'])->passwordInput(['placeholder'=>Yii::t('form_label', 'Please input').Yii::t('form_label', 'Password')])?>
	<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
	'captchaAction'=>'captcha',
	'options'=>['placeholder'=>'','class' => 'form-control'],
	'template' => '{input}{image}',
	'imageOptions'=>['alt'=>Yii::t('form_label', 'ClickMap'),'title'=>Yii::t('form_label', 'ClickMap'), 'style'=>'cursor:pointer']
	]) 
	?>
	<div class="form-group">
	<?= Html::submitButton(Yii::t('form_label', 'Sign in'), ['class'=>'btn btn-danger pull-right btn-block','name' =>'submit-button']) ?>
	</div>
</section>

<section class="log-in">
<?php // Html::a('首页',null,['href'=>Url::toRoute('default/index'),'class'=>'btn btn-slategray']) ?>
</section>
<?php ActiveForm::end(); ?>
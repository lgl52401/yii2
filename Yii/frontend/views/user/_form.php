<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha; 
?>

<?php $form = ActiveForm::begin([
'id' => 'form-signin',
]); ?>
<!--<form id="form-signin" class="form-signin">-->
<section>
<?php
echo  $form->field($model,'username')->textInput(['placeholder'=>'只能由汉字/数字/下划线组成，不能包含空格'])->label('账号')
?>
<?= $form->field($model,'password')->passwordInput(['placeholder'=>'密码'])->label('密码')?>
<?= $form->field($model,'password_rep')->passwordInput(['placeholder'=>'确认密码'])->label('确认密码')?>
<?= $form->field($model,'email')->textInput(['placeholder'=>'邮箱'])->label('邮箱')?>
<?php /*$form->field($model, 'verifyCode')->label('验证码')->widget(Captcha::className(), [
'captchaAction'=>'tool/captcha',
'options'=>['placeholder'=>'验证码'],
'imageOptions'=>['alt'=>'点击换图','title'=>'点击换图', 'style'=>'cursor:pointer']

]) */
?>

<!--<div class="input-group">
<input type="password" class="form-control" name="password" placeholder="密码">
<div class="input-group-addon"><i class="fa fa-key"></i></div>
</div>-->
</section>
<section class="controls">
<div class="checkbox check-transparent">
<!--<input type="checkbox" value="1" id="remember" checked>
<label for="remember">记住我</label>-->
</div>
<a href="#">忘记密码?</a>
</section>
<section class="log-in">
<?= Html::submitButton('注册', ['class' => 'btn btn-greensea']) ?>
<!--<button class="btn btn-greensea">登录</button>-->
<span>或</span>
<?= Html::a('登录',null,['href'=>Url::toRoute('default/index'),'class'=>'btn btn-slategray']) ?>
<!--<button class="btn btn-slategray">创建一个新账号</button>-->
</section>
<!--</form>-->
<?php ActiveForm::end(); ?>
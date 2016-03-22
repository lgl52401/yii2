<div id="login" class="col-sm-4 col-sm-offset-4">
	<h1 class="logo">
		<a href=""></a>
	</h1>
	<div class="box-login">
		<h3><?= Yii::t('form_label', 'Sign in your account')?></h3>
		<p> <?= Yii::t('form_label', 'Enter username and password')?> </p>
		<?= $this->render('_form', ['model' => $model]) ?>
	</div>
</div>
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

<?php $this->beginBlock('footer'); ?>
<footer class="footer">
    <div class="container">
        <p class="pull-left">Copyright © <?= date('Y') ?> 天宝旅游 All rights reserved.  </p>

        <p class="pull-right"></p>
    </div>
</footer>
<?php $this->endBlock(); ?>
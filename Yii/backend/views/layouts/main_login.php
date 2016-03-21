<?php
use app\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php echo Html::csrfMetaTags() ?>
<title><?php echo Html::encode($this->title) ?></title>
<?php $this->head() ?>
</head>
<body class="<?php if(isset($this->context->layout_data['cls']))echo $this->context->layout_data['cls'];?>">
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container">
        <?php echo $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?php echo Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

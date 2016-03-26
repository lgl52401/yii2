<?php
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php echo Html::csrfMetaTags() ?>
<title><?php echo Html::encode(($this->title ? $this->title . ' - ' : '') . Yii::$app->name); ?></title>
<meta name="description" content="<?php echo isset($this->metaTags['description']) ? $this->metaTags['description'] : ''; ?>" />
<meta name="keywords" content="<?php echo isset($this->metaTags['keywords']) ? $this->metaTags['keywords'] : ''; ?>" />
<link type="image/x-icon" href="<?php echo staticDir;?>/icon/favicon.ico" rel="shortcut icon">
<?php $this->head() ?>
<?php if (isset($this->blocks['css'])): ?>
    <?= $this->blocks['css'] ?>
<?php endif; ?>
</head>
<body class="<?php if(isset($this->context->layout_data['cls']))echo $this->context->layout_data['cls'];?>">
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container">
        <?php echo $content;?>
    </div>
</div>

<?php if (isset($this->blocks['footer'])){ ?>
    <?= $this->blocks['footer'] ?>
<?php } ?>

<div class="js-container">
<script type="text/javascript"  src="<?php echo Url::to(['/tool/lang'],true);?>"></script>
<?php $this->endBody() ?>
<?php if (isset($this->blocks['js'])): ?>
    <?= $this->blocks['js'] ?>
<?php endif; ?>
</div>
</body>
</html>
<?php $this->endPage() ?>

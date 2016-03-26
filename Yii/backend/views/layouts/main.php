<?php
use app\assets\TableAsset;
use yii\helpers\Html;
use yii\helpers\Url;

TableAsset::register($this);
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
<?php if (isset($this->blocks['css'])): ?>
    <?= $this->blocks['css'] ?>
<?php endif; ?>
</head>
<body class="lgl-content <?php if(isset($this->context->layout_data['cls']))echo $this->context->layout_data['cls'];?>">
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container">
        <?php echo $content ?>
    </div>
</div>
<script type="text/javascript"  src="<?php echo Url::to(['/tool/lang'],true);?>"></script>
<?php $this->endBody() ?>
<?php if (isset($this->blocks['js'])): ?>
    <?= $this->blocks['js'] ?>
<?php endif; ?>
</body>
</html>
<?php $this->endPage() ?>

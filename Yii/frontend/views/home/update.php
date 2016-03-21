<?php
use yii\helpers\url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
 
/* @var $this yii\web\View */
/* @var $model app\models\Route */
/* @var $form ActiveForm */
?>
<div class="aasdasdasd">

   <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
   



   <?= $form->field($model, 'timezone')->label('角色描述')->widget('pjkui\kindeditor\KindEditor', [
    'clientOptions' => [
        'width' => '100%',
        'flashUrl' =>'swfupload.swf',
         'allowFileManager'=>'true',
                                'allowUpload'=>'true',
        'height' => '100px',
        'themeType' => 'simple'
    ],'editorType'=>'textEditor'
]) ?>
<?php  //echo $form->field($model, 'route_code')->fileInput(); ?> 
 <?= $form->field($model, 'route_image') ?> 

 <img src="<?= Url::to(['tool/qrcode'],true)?>" />
<?php echo dosamigos\fileupload\FileUploadUI:: widget([
   'name'    =>'Filedata',
   'gallery' =>true,
   'load'    =>json_encode(images_all('upload/20160320/2016032012382696.jpg|upload/20160320/2016032012382696.jpg')),
    'url'    =>['tool/imagecreate', 'size' => '800_800','ThumbSize'=>'220_220|480_480'],
    'options'=>['accept' => 'image/*','multiple'=>"",],
    'clientOptions'=>[
                    'maxFileSize' => 2000000
                    ],
    'clientEvents' => dosamigos\fileupload\FileUploadUI::get_text('Route[route_image]'),
]);?>

 
<?php echo dosamigos\fileupload\FileUpload:: widget([
    'name'   =>'Filedata',
    'plus'   =>true,
    'url'    =>['tool/imagecreate', 'size' => '800_800','ThumbSize'=>'220_220|480_480'],
    'options'=>['accept' => 'image/*',],
    'clientOptions'=>[
                    'maxFileSize' => 2000000,
                    ],
    'clientEvents' =>dosamigos\fileupload\FileUpload::get_text('Route[duration]'),
]);?>
       
    <!-- The container for the uploaded files -->
     
        <?= $form->field($model, 'duration') ?>
        <?= $form->field($model, 'advance') ?>
        <?= $form->field($model, 'status') ?>
        <?= $form->field($model, 'sort_order') ?>
        <?= $form->field($model, 'dep_id') ?>
        <?= $form->field($model, 'check_inventory') ?>
        <?= $form->field($model, 'date_start') ?>
        <?= $form->field($model, 'date_end') ?>
        <?= $form->field($model, 'created') ?>
         
        <?php //= $form->field($model, 'route_image') ?>
        
       <input   type="hidden" value="<?php echo $model->route_id;?>" name="route_id">
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- aasdasdasd -->

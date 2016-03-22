<?php
namespace backend\controllers;

use Yii;
use app\components\BaseController;
use libs\base\BCaptchaAction;
use dosamigos\qrcode\QrCode;
use yii\web\Response;
use libs\libraries\Upfile;
use yii\helpers\url;
use pjkui\kindeditor\KindEditorAction;

/**
 * Tool controller
 */
class ToolController extends BaseController
{
	public function actions()
    {
        return [
            'captcha' => Yii::$app->params['captcha']
        ];
    }
    
    public function init()
    {
        parent::init();
    }

    /*
        编辑器上传图片
    */
    public function actionKupload()
    {
        $editor = new KindEditorAction('','');
        $editor->init();
        $editor->UploadJosnAction();
    }

    /*
        编辑器查看图片服务器
    */
    public function actionKmanager()
    {
        $editor = new KindEditorAction('','');
        $editor->init();
        $editor->fileManagerJsonAction();
    }

    /*
        生成图片
    */
	public function actionImagecreate()
	{
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result          = $this->outResult('上传失败');
        $result['files'] = [];
        $Upfile          = new Upfile();
        $Upfile->upFileType   = '';
        $rootPath             = $Upfile->annexFolder.'/';
        $Upfile->annexFolder .= '/upload'; 
        $Upfile->create_dir($Upfile->annexFolder);
        $size      = Yii::$app->request->get('size');//原始图片大小
        $iswater   = Yii::$app->request->get('iswater');//水印
        $ThumbSize = Yii::$app->request->get('ThumbSize');//生成缩略图大小
        $thumbnailUrl = '';//输出的缩略图
        if($size)
        {
            $pream    = explode('_', $size);
            $pream[0] = intval($pream[0]);
            $pream[1] = intval($pream[1]);
            if($pream[0]>0 && $pream[1]>0)
            {
                $Upfile->maxWidth = $pream[0];
                $Upfile->maxHeight= $pream[1];
            }
        }
        $photo = $Upfile->upload('Filedata');
        if($photo[0])
        {
            $result['success'] = true;
            if($iswater)
            {
                $Upfile->imageWaterMark($photo[1]);
            }

            if($ThumbSize)
            {
                $parame  = explode('|', $ThumbSize);
                foreach ($parame as $key => $val)
                {
                    $temp = $Upfile->smallImg($photo[1],$val);
                    if(empty($thumbnailUrl))
                    {
                        $thumbnailUrl = $temp;
                    }
                }//@unlink($photo[1]);
            }
            $thumbnailUrl = $thumbnailUrl ? $thumbnailUrl : $photo[1];
            $images_url   = str_replace($rootPath, '', $photo[1]);
            $thumbnailUrl = str_replace($rootPath, '', $thumbnailUrl);
            $result['files'][] = [
                                'name'         =>basename($photo[1]),
                                'size'         =>'',//filesize($photo[1]),
                                'url'          =>getImg($images_url,''),
                                'urls'         =>$images_url,
                                'thumbnailUrl' =>getImg($thumbnailUrl,''),
                                'deleteUrl'    =>Url::to(['tool/imagedelete','imagesPath'=>$images_url],true),
                                'deleteType'   =>'POST'
                                ];
        }
        return $result;
	}

    /*
        删除图片
    */
    public function actionImagedelete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [];
        /*$imagesPath = Yii::$app->request->get('imagesPath');//图片地址
        $imagesPath = str_replace(array('../',"./"), '', $imagesPath);
        $imagesPath = preg_replace("/[\/]+/", '/', $imagesPath);
        $imagesPath = preg_replace("/[\\\]+/", "\\", $imagesPath);
        $imagesPath = trim($imagesPath,'.');
        $rootPath   = Yii::getAlias('@uploadFile');
        $arr        = getConfig('img_size');
        foreach ($arr as $key_s => $val_s)
        {
            $temp = $rootPath . '/' .getImg($imagesPath,$val_s,2);
            if(is_file($temp))@unlink($temp);
        }
        exit(json_encode([]));*/
    }

    /*
        二维码
    */
    public function actionQrcode()
    {
        return QrCode::png('test');
    }
}

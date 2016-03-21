<?php
namespace libs\base;
use Yii;
use yii\captcha\CaptchaAction;
use yii\web\Response;
use yii\helpers\Url;

class BCaptchaAction extends CaptchaAction
{
	public $type = 3;
	public function run()
	{
		if (Yii::$app->request->getQueryParam(self::REFRESH_GET_VAR) !== null) {
            // AJAX request for regenerating code
            $code = $this->getVerifyCode(true);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'hash1' => $this->generateValidationHash($code),
                'hash2' => $this->generateValidationHash(strtolower($code)),
                // we add a random 'v' parameter so that FireFox can refresh the image
                // when src attribute of image tag is changed
                'url' => Url::to([$this->id, 'v' => uniqid()]),
            ];
        } else {
            $this->setHttpHeaders();
            Yii::$app->response->format = Response::FORMAT_RAW;
            return $this->renderImage($this->getVerifyCode());
        }
	}

	public function getVerifyCode($regenerate = false)
    {
        if ($this->fixedVerifyCode !== null) {
            return $this->fixedVerifyCode;
        }

        $session = Yii::$app->getSession();
        $session->open();
        $name = $this->getSessionKey();
        if ($session[$name] === null || $regenerate) {
            $session[$name] = $this->generateVerifyCode();
            $session[$name . 'count'] = 1;
        }

        return $session[$name];
    }

	protected function generateVerifyCode()
	{
		$length = 0;
		$type  	= $this->type;
		if($type == 1)//数字
		{
			$length = mt_rand((int)$this->minLength,(int)$this->maxLength);
		}
		elseif($type == 2)//数字加减
		{
			$length = mt_rand(pow(10,(int)$this->minLength-1),pow(10,(int)$this->maxLength)-1);
		}
		elseif($type == 3 || $type == 4)//拼音|中文
		{
			if ($this->minLength > $this->maxLength)
			{
				$this->maxLength = $this->minLength;
			}
			if ($this->minLength < 3)
			{
				$this->minLength = 3;
			}
			if ($this->maxLength > 20) 
			{
				$this->maxLength = 20;
			}
			$num 	= mt_rand($this->minLength, $this->maxLength);
			$length = $this->makecode($num,$type);
		}
		return $this->getText($length);
	}
	
	private function makecode($length,$mode=0) //验证码组合类型
	{
		$result = '';
		$str1 = '123456789';
		$str2 = 'abcdefghijklmnopqrstuvwxyz';
		$str3 = 'ABCDEFGHIJKLMNPQRSTUVWXYZ';
		$str4 = '';
		switch ($mode)
		{
			case 0://数字
				$str = $str1;
				break;
			case 3://拼音
				$str = $str2.$str3;
				break;
			case 4:
				$str = $str4;
				break;
			case 5:
				$str = $str1.$str2.$str3;
				break;
			default :
				$str = $str1;
				break;
		}
		
		if($mode==4)
		{   
			$encode_length = 3;#根据编码截取中文字符长度
			$tmp1 		   = $length;
			$tmp 		   = strlen($str)/$encode_length;
			for ($i = 0 ;$i < $tmp1 ;$i++)
			{
				$start	 = mt_rand(0,$tmp-1)*$encode_length;
				$result .= substr($str,$start,$encode_length);
			}
		}
		else
		{
			for ($i = 0 ; $i < $length ; $i++)
			{
				$result .= $str[mt_rand(0 , strlen($str) - 1)];
			}
		}
		return $result;
	}
	
	protected function getText($code)
	{
		if($this->type == 1)
		{
			$code = (int)$code;
			$rand = mt_rand(1,$code-1);
			$op   = mt_rand(0,1);
			if($op)
			{
				return $code-$rand. '+' . $rand;
			}
			else
			{
				return $code+$rand. '-' . $rand;
			}
		}
		else
		{
			return (string)$code;
		}	
	}
}

?>

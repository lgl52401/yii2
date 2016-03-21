<?php
namespace libs\libraries;
use Yii;

/**
* @author wesley
* @version 1.0
* @date 2015-05-26
* @desc 图片上传
*/ 
class Upfile
{ 
	public $annexFolder = '';//文件上传目录
	public $smallFolder = '';//缩略图存放路径 注:必须是放在 $annexFolder下的子目录
	public $markFolder  = '';//水印图片存放处 
	public $upFileType  = 'jpg gif png rar zip pdf bmp jpeg doc docx xls xlsx';//上传的类型，默认为：jpg gif png rar zip 
	public $upFileMax   = 4024;//上传大小限制，单位是“KB”，默认为：1024KB 
	public $fontType;		//字体 ;
	public $result 	= array();
	public $maxWidth 	= 1500; //图片最大宽度 
	public $maxHeight 	= 2500; //图片最大高度 
	function __construct()
	{
		$this->annexFolder = Yii::getAlias('@uploadFile');
		$this->markFolder  = GLOBALDIR."/Watermark/waterMark.png";
		$this->fontType    = GLOBALDIR."/fonts/simhei.ttf";
	}

	/*
		上传文件
	*/
	public function upLoad($inputName) 
	{
		$rnd 		= rand(10,99);
		$time 	 	= SYS_TIME;
		$dateDir 		= date('Ymd',$time);
		$imageName 	= date('YmdHis',$time).$rnd;
		if(@empty($_FILES[$inputName]['name']))
		{ 
			$result[0] = 0;
			$result[1] = '没有上传图片信息，请确认！';
			return $result;
		}; 

		$temps 	= $this->fileName($_FILES[$inputName]['name']);
		$imgType  = $temps[1];
		if(!empty($this->upFileType) && strpos($this->upFileType,$imgType)===false) 
		{
			$result[0] = 0;
			$result[1] = '上传图片失败,上传文件类型仅支持！'.$this->upFileType.'格式，不支持 '.$imgType;
			return $result;
		}

		$imgSize = $_FILES[$inputName]['size'];
		$kSize   = round($imgSize/1024);
		if($kSize > $this->upFileMax)
		{
			$result[0] = 0;
			$result[1] = '上传文件超过 '.$this->upFileMax.'KB'.'上传失败！';
			return $result; 
		}
		$photo 		= $imageName.'.'.$imgType;//写入数据库的文件名 
		$this->create_dir($this->annexFolder.'/'.$dateDir);
		$uploadFile 	= str_replace('//','/', $this->annexFolder.'/'.$dateDir.'/'.$photo);//上传后的文件名称 
		$upFileok 	= str_replace ("\\\\","\\",$_FILES[$inputName]['tmp_name']);
		$upFileok 	= move_uploaded_file($upFileok,$uploadFile); //开始上传文件
		if(!$upFileok)
		{ 
			$result[0] = 0;
			$result[1] = '上传图片失败,请确认你的上传目录可写或文件过大上传时间超时';
			return $result; 
		}

		if($this->is_images($_FILES[$inputName]['name']))#如果是图片
		{
			$this->yuantuImg($uploadFile);
			$result[0] = 1;
			$result[1] = $uploadFile;
			return $result;
		}
		else#如果不是图片
		{
			$result[0] = 2;
			$result[1] = $uploadFile;
			return $result;
		}
	} 

	/*
		生成缩略图
	*/
	public function smallImg($photo,$size='300_300') 
	{ 
		$imgInfo = $this->getInfo($photo);
		if($imgInfo['type'] == 1) 
		{ 
			$img = imagecreatefromgif($photo); //从 GIF 文件或 URL 新建一图像
		}
		elseif($imgInfo['type'] == 2) 
		{ 
			$img = imagecreatefromjpeg($photo); 
		}
		elseif($imgInfo['type'] == 3)
		{ 
			$img = imagecreatefrompng($photo); 
		} 
		else 
		{ 
			$img = '';
		}
		if(empty($img)) return False; 
		$suoluetu = getImg($photo,$size,2);
		$temp   = explode('_', $size);
		$width  = $temp[0];
		$height = $temp[1];
		
		$srcW   = $imgInfo['width'];
		$srcH   = $imgInfo['height'];
		$scale  = min($width/$srcW,$height/$srcH);
		if ($scale < 1) 
		{
			$new_width  = floor($scale*$srcW);
			$new_height = floor($scale*$srcH);
			$tmp_img 	  = @imagecreatetruecolor($new_width, $new_height);
			@imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height,$srcW,$srcH);
			@imagejpeg($tmp_img,$suoluetu,100);
			@imagedestroy($tmp_img); 
		}
		else
		{
			@copy($photo,$suoluetu);
		}
		return $suoluetu; 
	}

	/*
		原图片压缩
	*/
	public function yuantuImg($photo) 
	{ 
		$width 	= $this->maxWidth;
		$height 	= $this->maxHeight;
		$imgInfo 	= $this->getInfo($photo); 
	    $suoluetu 	= $photo;
		if($imgInfo['type'] == 1) 
		{ 
			$img = imagecreatefromgif($photo); 
		}
		elseif($imgInfo['type'] == 2) 
		{ 
			$img = imagecreatefromjpeg($photo); 
		} 
		elseif($imgInfo['type'] == 3) 
		{ 
			$img = imagecreatefrompng($photo); 
		}
		else
		{ 
			$img = ''; 
		} 
		if(empty($img)) return False; 
		$srcW 	= $imgInfo['width'];
		$srcH 	= $imgInfo['height'];
		$scale  = min($width/$srcW,$height/$srcH);
		if($scale < 1) 
		{
			$new_width  = floor($scale * $srcW);
			$new_height = floor($scale * $srcH);
			$tmp_img 	  = @imagecreatetruecolor($new_width, $new_height);
			@imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height,$srcW,$srcH);
			@imagejpeg($tmp_img,$suoluetu,100);
			@imagedestroy($tmp_img); 
		}
		else
		{
			@copy($photo,$suoluetu);
		}
		return $suoluetu; 
	}
 	
	private function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $opacity)
	{
		$cut = imagecreatetruecolor($src_w, $src_h);
		imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
		imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
		imagecopymerge($dst_im, $cut, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $opacity);
	}  
  
	#1图片地址，2水印位置，3水图片
	public function imageWaterMark($groundImage,$waterPos=9,$pct=100)
	{
		$result[0] 	= 0;
		$isWaterImage  = false;
		$result[1]	= '暂不支持该文件格式，请用图片处理软件将图片转换为GIF|JPG|PNG格式。';
		$waterImage 	= $this->markFolder;
		//读取水印文件
		if(!empty($waterImage) && file_exists($waterImage))
		{
			$isWaterImage 	= true;
			$water_info 	= getimagesize($waterImage);
			$water_w     	= $water_info[0];//取得水印图片的宽
			$water_h     	= $water_info[1];//取得水印图片的高
			switch($water_info[2])//取得水印图片的格式
			{
				case 1:$water_im = imagecreatefromgif($waterImage);break;
				case 2:$water_im = imagecreatefromjpeg($waterImage);break;
				case 3:$water_im = imagecreatefrompng($waterImage);break;
				default:return $result;
			}
		}

		//读取背景图片
		if(!empty($groundImage) && file_exists($groundImage))
		{
			$ground_info = getimagesize($groundImage);
			$ground_w    = $ground_info[0];//取得背景图片的宽
			$ground_h    = $ground_info[1];//取得背景图片的高
			switch($ground_info[2])//取得背景图片的格式
			{
				case 1:$ground_im = imagecreatefromgif($groundImage);break;
				case 2:$ground_im = imagecreatefromjpeg($groundImage);break;
				case 3:$ground_im = imagecreatefrompng($groundImage);break;
				default:return $result;
			}
		}
		else
		{
			$result[1] = '需要加水印的图片不存在!';
			return $result;
		}
		//水印位置
		if($isWaterImage)//图片水印
		{
			$w 		= $water_w;
			$h 		= $water_h;
			$label 	= '图片区域';
			if( ($ground_w<$w) || ($ground_h<$h) )
			{
				$result[1] = '需要加水印的图片的长度或宽度比水印'.$label.'还小，无法生成水印!';
				return $result;
			}
		}

		switch($waterPos)
		{
			case 0://随机
				$posX = rand(0,($ground_w - $w));
				$posY = rand(0,($ground_h - $h));
				break;
			case 1://1为顶端居左
				$posX = 0;
				$posY = 0;
				break;
			case 2://2为顶端居中
				$posX = ($ground_w - $w) / 2;
				$posY = 0;
				break;
			case 3://3为顶端居右
				$posX = $ground_w - $w;
				$posY = 0;
				break;
			case 4://4为中部居左
				$posX = 0;
				$posY = ($ground_h - $h) / 2;
				break;
			case 5://5为中部居中
				$posX = ($ground_w - $w) / 2;
				$posY = ($ground_h - $h) / 2;
				break;
			case 6://6为中部居右
				$posX = $ground_w - $w;
				$posY = ($ground_h - $h) / 2;
				break;
			case 7://7为底端居左
				$posX = 0;
				$posY = $ground_h - $h;
				break;
			case 8://8为底端居中
				$posX = ($ground_w - $w) / 2;
				$posY = $ground_h - $h;
				break;
			case 9://9为底端居右
				$posX = $ground_w - $w;
				$posY = $ground_h - $h;
				break;
			default://随机
				$posX = rand(0,($ground_w - $w));
				$posY = rand(0,($ground_h - $h));
				break;     
		}
		//设定图像的混色模式
		imagealphablending($ground_im, true);
		if($isWaterImage)//图片水印
		{
			$this-> imagecopymerge_alpha($ground_im, $water_im, $posX, $posY, 0, 0, $water_w,$water_h,$pct); 
			//imagecopymerge($ground_im, $water_im, $posX, $posY, 0, 0, $water_w,$water_h,$pct);//拷贝水印到目标文件      
		}
	    
		switch($ground_info[2])//取得背景图片的格式
		{
			case 1:imagegif($ground_im,$groundImage);break;
			case 2:imagejpeg($ground_im,$groundImage);break;
			case 3:imagepng($ground_im,$groundImage,100);break;
			default:die($errorMsg);
		}

		//释放内存
		if(isset($water_info)) unset($water_info);
		if(isset($water_im)) imagedestroy($water_im);
		unset($ground_info);
		imagedestroy($ground_im);
	}

	/*
		获取图片信息
	*/
	private function getInfo($photo) 
	{ 
		$photo 			= $photo;
		$imageInfo  		= @getimagesize($photo); 
		$imgInfo['width'] 	= $imageInfo[0]; 
		$imgInfo['height'] 	= $imageInfo[1]; 
		$imgInfo['type'] 	= $imageInfo[2]; 
		$imgInfo['name'] 	= basename($photo); 
		return $imgInfo; 
	}

	/*
		获取文件 0-名称，1-类型，2-路径
	*/
	private function fileName($url)
	{
		if(strpos($url, '.')===false)return $url;
		$path   = dirname($url);
		$info 	= basename($url);
		$row 	= explode('.',$info);
		$length = count($row);
		if($length<=2)
		{
			$row[1] = strtolower($row[1]);
			$row[2] = $path;
			return $row;
		}
		$num  =	$length-1; 
		$type = strtolower($row[$num]);
		unset($row[$num]);
		$name = implode('.',$row);
		return array($name,$type,$path);
	}

	/*
		判断文件是否为图片格式
	*/
	private function is_images($filename)
	{
		$types = array('gif','jpeg','png','bmp','jpg');//定义检查的图片类型
		$split = explode('.',$filename);
		if(in_array(strtolower($split[count($split)-1]),$types))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/*
		创建无限极目录
	*/
	public function create_dir($dir)
	{
		return is_dir($dir) or ($this->create_dir(dirname($dir)) and @mkdir($dir,0777));
	}
}

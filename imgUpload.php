<?php 
class SaveImg{
	private $path;
	private $str_json_saveImgFileName;
	private $domainName;
	public function __construct(){
			$this->path="";
			$this->str_json_saveImgFileName="";
			$this->domainName="";
	}
	
	public function doThings(){
		$this->toNose();
		// 需要先传参配置.第一个参数表示储存的文件路径，第二个表示域名入口
		$this->config('img.json','localhost');
		$this->saveImg($this->str_json_saveImgFileName,$this->callback_arr_message());
	}
	protected function callback_arr_message(){
		return [
			'short_path'=>$this->path,
			'link'=>$this->domainName.'/'.explode("/",$_SERVER['PHP_SELF'])[1].'/'.$this->path
		];
	}
	public function toNose(){
		$this->path='img/'.ceil(microtime(true)).mt_rand().'.jpg';
		copy($_FILES['file']['tmp_name'],$this->path);
		echo $this->path;
	}
	public function saveImg($savePath,$saveContent){
		// 若文件不存在，以写的方式打开
		if(file_exists($savePath)==""){
			fopen($savePath,'w');
		}
		// 以json格式储存文件
		$savePathContent=file_get_contents($savePath);
		$receiveArr=json_decode($savePathContent,true);
		$receiveArr[]=$saveContent;
		file_put_contents($savePath, json_encode($receiveArr));
	}
	public function config($str_json_saveImgFileName,$domainName){
		$this->str_json_saveImgFileName=$str_json_saveImgFileName;
		$this->domainName=$domainName;
		return true;
	}
	public function test(){
		echo $_SERVER['PHP_SELF'];
	}
}
$saveImg=new SaveImg();
$saveImg->doThings();
// $saveImg->test();
 
 ?>
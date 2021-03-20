<?php


namespace tinyshop;

use mysql_xdevapi\Exception;

require_once './sdk/AipImageClassify.php';

class Ocr
{
    private $client;
    // 你的 APPID AK SK
    const APP_ID = '23828958';
    const API_KEY = '0rIS2RuZTLRGWgsBFkHjd3KF';
    const SECRET_KEY = 'kvASiuUSxDF97g28qdKGyoxRNI1Dd03y';

    public function __construct()
    {

        $this->client = new \AipImageClassify(self::APP_ID, self::API_KEY, self::SECRET_KEY);

    }

    public function index()
    {
// 如果有可选参数
        $options = array();
        $options["baike_num"] = 5;
        $options["top_num"] = 3;
        $options["filter_threshold"] = "0.7";
        $img = file_get_contents('./f.jpg');
       // $result = $this->client->advancedGeneral($img, $options);
        $result = $this->client->objectDetect($img, $options);
        print_r($result);
        $result=$result['result'];
        try {
            $this->actionCutByPoint($result['top'],$result['left'],$result['width'],$result['height']);

        }catch (Exception $e){
            echo $e->getMessage();
        }


    }
    /**
     * 按坐标裁图
     * 参数：起始坐标，裁剪长宽,图片
     * 坐标（$h,$w）
     * 长宽（$height,$weight）
     */
    public function actionCutByPoint($top,$left,$width,$height)
    {
        $filename ='./f.jpg';
        $x = $top; //客户端选择区域左上角x轴坐标
        $y = $left; //客户端选择区域左上角y轴坐标
        $w = $width; //客户端选择区 的宽
        $h = $height; //客户端选择区 的高
    //    $filename = "c:/myimg" ; //图片的路径
        $im = imagecreatefromjpeg( $filename ); // 读取需要处理的图片
        $newim = imagecreatetruecolor($width, $height); //产生新图片 100 100 为新图片的宽和高

        imagecopyresampled($newim , $im , 0, 0, $x , $y , 100, 100, $w , $h );
//参数[1] [2] [3][4] [5] [6] [7] [8] [9] [10]
//[5] 客户端选择区域左上角x轴坐标
//[6] 客户端选择区域左上角y轴坐标
//[7] 生成新图片的宽
//[8] 生成新图片的高
//[9] 客户端选择区 的宽
//[10] 客户端选择区 的高
        imagejpeg($newim , 'test.jpg' );
        imagedestroy($im );
        imagedestroy($newim );

    }

}

$obj = new Ocr();
$obj->index();
<?php

use app\common\lib\excel\ExcelSdk;

echo 1;
include_once "/Users/luoxiaoquan/data/web/php/tinyshop/vendor/autoload.php";
include_once "./SplitSheet.php";
$obj=new \tinyshop\excel\SplitSheet();
$file='/Users/luoxiaoquan/data/test.xlsx';
$obj->run('Xlsx',$file);
public function ex()
{
    $file = "D:\code_action_log1w-2nd.xls";
    $obj = new ExcelSdk();
    $data = $obj->chunkRead($file, 1, "\\app\\tests\\controller\\Excel", "test");
    print_r($data);
}

static function test($data)
{
    print_r($data);die();
}
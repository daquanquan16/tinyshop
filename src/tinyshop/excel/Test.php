<?php
echo 1;
include_once "/Users/luoxiaoquan/data/web/php/tinyshop/vendor/autoload.php";
include_once "./SplitSheet.php";
$obj=new \tinyshop\excel\SplitSheet();
$file='/Users/luoxiaoquan/data/test.xlsx';
$obj->run('Xlsx',$file);
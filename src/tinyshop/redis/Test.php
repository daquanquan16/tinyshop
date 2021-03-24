<?php


namespace tinyshop\redis;
use tinyshop\redis\Config;

class Test
{
    public function index()
    {
       $obj =\tinyshop\redis\Sdk::getInstance();
   return     $redis=$obj->getRedis();
    }

}
include_once ('./Config.php');
include_once ('./Sdk.php');
$obj=new Test();
$redis=$obj->index();
print_r($redis->set("tests",11));
print_r($redis->get("tests"));
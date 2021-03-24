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
$order="orderkey";
$result=$redis->ZADD($order,time(),2);
$result=$redis->ZADD($order,time(),3);
$result=$redis->ZRANGE($order,0,time(),'WITHSCORES');
print_r($result);
/*print_r($redis->set("tests",11));
print_r($redis->get("tests"));*/
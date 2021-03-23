<?php


namespace tinyshop\redis;


class Test
{
    public function index()
    {
        $redis = Sdk::getInstance()->getRedis();
        print_r($redis);
    }

}
$obj=new Test();
$obj->index();
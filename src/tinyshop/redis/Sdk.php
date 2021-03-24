<?php


namespace tinyshop\redis;


class Sdk
{

    private static $object = null;
    private $redis = null;

    //初始化化类，防止被实例化
    public function __construct()
    {
        $this->connect();
    }

    //防止类重复实例化
    public static function getInstance()
    {
        if (empty(self::$object)||self::$object instanceof self) {
            self::$object = new self();
       }
        return self::$object;
    }

    //连接redis
    private function connect()
    {
        if (!empty($this->redis)) {
            return $this->redis;
        }
        $this->redis = new \Redis();
        $this->redis->connect(Config::HOST, Config::POST);

        if (!empty(Config::PASSWORD)) {
            $this->redis->auth(Config::PASSWORD);
        }
        $this->redis->select(Config::SELECT);
        return $this->redis;
    }
    public function getRedis()
    {
        return $this->redis;
    }
    public function select($db)
    {
        $this->redis->select($db);
        return $this;
    }

    //防止类被克隆
    private function __clone()
    {
    }
}
/*
$obj = Sdk::getInstance();
  $redis=$obj  ->getRedis();
print_r($redis);*/
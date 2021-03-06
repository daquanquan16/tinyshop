<?php


namespace tinyshop;


class Particle
{
    /*基于Twitter的SnowFlake算法的实现，这个算法的好处很简单可以在每秒产生约400W个不同的16位数字ID(10进制)。

原理很简单

ID由64bit组成

其中 第一个bit空缺

41bit用于存放毫秒级时间戳

10bit用于存放机器id

12bit用于存放自增ID

除了最高位bit标记为不可用以外，其余三组bit占位均可浮动，看具体的业务需求而定。默认情况下41bit的时间戳可以支持该算法使用到2082年，10bit的工作机器id可以支持1023台机器，序列号支持1毫秒产生4095个自增序列id。*/
    const EPOCH = 1479533469598;
    const max12bit = 4095;
    const max41bit = 1099511627775;

    static $machineId = null;

    public static function machineId($mId)
    {
        self::$machineId = $mId;
    }

    public static function generateParticle()
    {
        /*
        * Time - 42 bits
        */
        $time = floor(microtime(true) * 1000);

        /*
        * Substract custom epoch from current time
        */
        $time -= self::EPOCH;

        /*
        * Create a base and add time to it
        */
        $base = decbin(self::max41bit + $time);

        /*
        * Configured machine id - 10 bits - up to 1024 machines
        */
        $machineid = str_pad(decbin(self::$machineId), 10, "0", STR_PAD_LEFT);

        /*
        * sequence number - 12 bits - up to 4096 random numbers per machine
        */
        $random = str_pad(decbin(mt_rand(0, self::max12bit)), 12, "0", STR_PAD_LEFT);

        /*
        * Pack
        */
        $base = $base . $machineid . $random;

        /*
        * Return unique time id no
        */
        return bindec($base);
    }

    public static function timeFromParticle($particle)
    {
        /*
        * Return time
        */
        return bindec(substr(decbin($particle), 0, 41)) - self::max41bit + self::EPOCH;
    }
}

//$machineID = 0; // Machine ID (aka Server ID no.)
//Particle::generateParticle($machineID);
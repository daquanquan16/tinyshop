<?php


namespace tinyshop\swoole;


class TcpClient
{

    public function __construct()
    {
        $client = new swoole_client(SWOOLE_SOCK_TCP);
        if (!$client->connect('0.0.0.0', 9501, -1))
        {
            exit("connect failed. Error: {$client->errCode}\n");
        }
        $data=['uid'=>1,'order_type'=>'orderinstall','msg'=>'测试消息'];

        $client->send(json_encode($data)) or die("数据发送失败");//客户端发送数据给服务端
        $Respone_data=$client->recv();//接收服务端传回来的
        print_r($Respone_data);
        $client->close();
    }
}
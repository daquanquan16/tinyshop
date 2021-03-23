<?php


namespace tinyshop\swoole;


class TcpServer
{
    public $server = null;

    public function __construct($host = null, $post = null)
    {
        $host = empty($host) ? "0.0.0.0" : $host;
        $post = empty($post) ? 9501 : $post;
        $this->server = new swoole_server($host, $post);
        $this->server->on('connect', [$this, 'onConnect']);
        $this->server->on('receive', [$this, 'onReceive']);
        $this->server->on('close', [$this, 'onClose']);
//启动服务器
        $this->server->start();
//监听连接进入事件
        /*  $serv->on('connect', function ($serv, $fd) {
              echo "Client: 建立连接Connect.\n";
          });*/

//监听数据接收事件
        /*$serv:服务器信息
        $fd:客户端信息
        $from_id:客户端id
        $data: 客户端发送的数据
         * */
        /*      $serv->on('receive', function ($serv, $fd, $from_id, $data) {
                  $serv->send($fd, "Server inster table " . $data . 'from_id_' . $from_id);
                  swoole_timer_after(1000, function () {
                      $msg = "5 订单失效 后执行111 \n";
                      echo $msg . "server;";
                  });
                  $data = json_decode($data, true);
                  //print_r($data);
                  if (!empty($data) && $data['order_type'] == 'orderinstall') {
                      //单次执行 多少秒后执行
                      $ss = "test function";
                      swoole_timer_after(5, function () {
                          //  print_r("gloab+".$GLOBALS['ss']);
                          $file = file_get_contents('./tcp_clien.php');
                          print_r('file' . $file);
                          $msg = "5 订单失效 后执行 \n";
                          echo $msg . "server;end";
                          //$serv->send($fd, "Server inster msg ".$msg.'from_id_'.$from_id);
                      });

                  }


              });*/

//监听连接关闭事件
        /*       $serv->on('close', function ($serv, $fd) {//$fd 客户端信息
                   echo "Client: 连接关闭 Close.\n";
               });*/


    }

    public function onClose($serv, $fd)
    {
        echo "Client: 连接关闭 Close.\n";
    }

//监听连接进入事件
    public function onConnect($serv, $fd)
    {
        echo "Client: 建立连接Connect.\n";
    }
//监听数据接收事件
    /*$serv:服务器信息
    $fd:客户端信息
    $from_id:客户端id
    $data: 客户端发送的数据
     * */
    public function onReceive($serv, $fd, $from_id, $data)
    {
        $this->server->send($fd, "Server inster table " . $data . 'from_id_' . $from_id);
        swoole_timer_after(1000, function () {
            $msg = "5 订单失效 后执行111 \n";
            echo $msg . "server;";
        });
        $data = json_decode($data, true);
        //print_r($data);
        if (!empty($data) && $data['order_type'] == 'orderinstall') {
            //单次执行 多少秒后执行
            $ss = "test function";
            swoole_timer_after(5, function () {
                //  print_r("gloab+".$GLOBALS['ss']);
                $file = file_get_contents('./tcp_clien.php');
                print_r('file' . $file);
                $msg = "5 订单失效 后执行 \n";
                echo $msg . "server;end";
                //$serv->send($fd, "Server inster msg ".$msg.'from_id_'.$from_id);
            });

        }
    }
}
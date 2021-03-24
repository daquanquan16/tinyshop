<?php


namespace tinyshop\redis;


class DelayQueue
{
    protected $prefix = 'delay_queue:';
    protected $redis = null;
    protected $key = '';

    public function __construct($queue, $config = [])
    {
        $this->key = $this->prefix . $queue;
        $this->redis = Sdk::getInstance()->getRedis();
    }

    public function setQueue($queue)
    {
        $this->key = $this->prefix . $queue;
        return $this;
    }

    public function delTask($value)
    {
        return $this->redis->zRem($this->key, $value);
    }

    public function getTask()
    {
        //获取任务，以0和当前时间为区间，返回一条记录
        return $this->redis->zRangeByScore($this->key, 0, time(), ['limit' => [0, 1]]);
    }

    public function addTask($name, $time, $data)
    {
        //添加任务，以时间作为score，对任务队列按时间从小到大排序
        $data = is_array($data) ? json_encode($data, JSON_UNESCAPED_UNICODE) : $data;
        return $this->redis->zAdd($this->key, $time, $data);
        /*return $this->redis->zAdd(
            $this->key,
            $time,
            json_encode([
                'task_name' => $name,
                'task_time' => $time,
                'task_params' => $data,
            ], JSON_UNESCAPED_UNICODE)
        );*/
    }

    public function run()
    {
        //每次只取一条任务
        $task = $this->getTask();
        if (empty($task)) {
            return false;
        }
        $task = $task[0];
        //有并发的可能，这里通过zrem返回值判断谁抢到该任务
        if ($this->delTask($task)) {
            $task = json_decode($task, true);
            //处理任务
            echo '任务：' . $task['task_name'] . ' 运行时间：' . date('Y-m-d H:i:s') . PHP_EOL;

            return true;
        }

        return false;
    }

}

/*set_time_limit(0);

$dq = new DelayQueue('close_order', [
    'host' => '127.0.0.1',
    'port' => 6379,
    'auth' => '',
    'timeout' => 60,
]);

while (true) {
    $dq->run();
    usleep(100000);
}*/
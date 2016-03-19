<?php
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


final class Mqsender
{
    private $mq_host; 
    private $mq_port;
    private $mq_user;
    private $mq_password;
    
    private $mq_queue;
    private $con; //connection
    private $cha; //channel
    
    
    public function init($mq_host,$mq_port,$mq_user,$mq_password,$mq_queue)
    {
        $this->mq_host = $mq_host;
        $this->mq_port = $mq_port;
        $this->mq_user = $mq_user;
        $this->mq_password = $mq_password;
        $this->mq_queue = $mq_queue;
        $this->connect();
    }
    
    public function __destruct()
    {
        if($this->con)
        {
            $this->cha->close();
            $this->con->close();
        }
    }
    
    
    public function connect()
    {
        $this->con = new AMQPStreamConnection($this->mq_host,$this->mq_port,$this->mq_user,$this->mq_password);
        $this->cha = $this->con->channel();
        
        $this->cha->queue_declare($this->mq_queue, false, true, false, false);
        
    }
    
    public function send($run_id,$problem_id,$language,$time_limit,$memory_limit,$special_judge = 0)
    {
        $arr = array('run_id' => $run_id,'problem_id'=>$problem_id, 'language'=>$language,'time_limit'=>$time_limit,'memory_limit'=>$memory_limit,'special_judge'=>$special_judge);
    
        $data = json_encode($arr);
        $msg = new AMQPMessage($data,array('delivery_mode' => 2));// make       message persistent
      
        $this->cha->basic_publish($msg, '', $this->mq_queue);
    }
    
}

?>
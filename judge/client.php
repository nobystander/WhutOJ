<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
require_once './config.php';
require_once './checkfile.php';
require_once './socket.php';



final class Worker
{
    private  $_config;
    
    private $mq_con;
    private $mq_cha;
    
    private $sender;
    
    
    public function __destruct()
    {
        if($this->mq_cha)
            $this->mq_cha->close();
        if($this->mq_con)
            $this->mq_con->close();
    }
    
    public  function start()
    {
        while(count($this->mq_cha->callbacks)) 
        {
            $this->mq_cha->wait();
        }
    }
    
    public  function run($config)
    {
        $this->_config = $config;
        $this->sender = new Socket();
        $this->sender->init($this->_config['socket']['socket_host'],$this->_config['socket']['socket_port'],$this->_config['socket']['secret_key']);
        $this->init();
        self::start();
        
    }
    
    public function ensureData($problem_id)
    {
       // umask(0);
        $data_dir = $this->_config['common']['problemdata_path'] . '/' .$problem_id;
        if(!file_exists($data_dir))
            mkdir($data_dir);
        if(!file_exists($data_dir.'/'.'input'))
            mkdir($data_dir.'/'.'input');
        if(!file_exists($data_dir.'/'.'output'))
            mkdir($data_dir.'/'.'output');
        $hash = generateHashData($data_dir);
        $result = $this->sender->sendAndReceive(array('type'=>'check','problem_id'=>$problem_id,'hash'=>$hash));
        $need = array();
        foreach($result as $kind=>$arr)
            foreach($arr as $key=>$value)
            {
                if($value == 'remove')
                {
                    $file_path = $data_dir.'/' .$kind .'/' .$kind.$key;
                   // echo 'delete' . $file_path ."\n";
                    if(!unlink($file_path))
                    {
                        exit("Error delete " . $file_path );
                    }
                }
                else
                {
                    if(!isset($need[$kind]))
                            $need[$kind] = array();
                    array_push($need[$kind],$key);
                    
                }
            }
        if(count($need))
        {
            
          /*  $file = $this->sender->sendAndReceive(array('type'=>'getfile','problem_id'=>$problem_id,'need'=>$need));
           // echo count($file);
            foreach($file as $kind=>$arr)
                foreach($arr as $key=>$value)
                {
                   // echo $kind . '  ' . $key . '  ' . $value . "\n";
                    $file_path = $data_dir .'/'. $kind . '/' .$kind.$key;
                    file_put_contents($file_path,$value);

                }  */
           // print_r($need);
            //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            // 由于socket发送大文件问题，这里暂时直接读取
            $connection = ssh2_connect($this->_config['ssh']['ssh_host'], 22);
            ssh2_auth_password($connection, $this->_config['ssh']['ssh_user'],$this->_config['ssh']['ssh_password']);
            foreach($need as $kind=>$arr)
                foreach($arr as $value)
                {
                    $server_path = $this->_config['ssh']['ssh_server_problemdata_dir'] .'/' .$problem_id . '/' . $kind .'/'. $kind . $value;
                    $client_path = $data_dir .'/'. $kind . '/' .$kind.$value;
                    ssh2_scp_recv($connection, $server_path ,$client_path);
                }
            unset($connection);
        }
    }
    
    public function ensureCode($run_id,$language)
    {
        $code_dir = $this->_config['common']['code_path'] . '/' .$run_id;
        if(!file_exists($code_dir))
        {
            mkdir($code_dir);
        }
        //$code = $this->sender->sendAndReceive(array('type'=>'getcode','run_id'=>$run_id));
        
        $connection = ssh2_connect($this->_config['ssh']['ssh_host'], 22);
        ssh2_auth_password($connection, $this->_config['ssh']['ssh_user'],$this->_config['ssh']['ssh_password']);
        
        $server_path = $this->_config['ssh']['ssh_server_submitdata_dir'] .'/' .$run_id . '/code';
        $client_path = $this->_config['common']['code_path'] . '/' .$run_id . '/' . $this->_config['language_filename'][$language];
        ssh2_scp_recv($connection, $server_path ,$client_path);
        
        unset($connection);
        //file_put_contents($code_path,$code['code']);

    }
    
    public function handledata($arr)
    {
        $run_id = $arr['run_id'];
        $problem_id = $arr['problem_id'];
        $language = $arr['language'];
        $time_limit = $arr['time_limit'];
        $memory_limit = $arr['memory_limit'];
        $this->ensureData($problem_id);
        $this->ensureCode($run_id,$language);
        $this->sender->sendAndReceive(array('type'=>'init','run_id'=>$run_id));
        echo "File done\n";                                                                        
        
        
        $judge_status = $this->_config['judge_status']['JUDGE_RJ'];
        $used_time = 0;
        $used_memory = 0;
        $result = exec("./compile " . $this->_config['common']['code_path'] .'/'.$run_id . '  ' .$language);
        if($result == 'NO')
        {
            $judge_status = $this->_config['judge_status']['JUDGE_CE'];
        }
        else
        {
            $t = exec('./judge_main '.$run_id .' '.$problem_id.' '.$language.' '.$time_limit.
                     ' '.$memory_limit);
            $t_arr = array();
            preg_match('/^(\d+)\s*(\d+)\s*(\d+)$/',$t,$t_arr);
            $judge_status = $t_arr[1];
            $used_time = $t_arr[2];
            $used_memory = $t_arr[3];
        }
        
        
    
        $this->sender->sendAndReceive(array('type'=>'return','run_id'=>$run_id,'judge_status'=>$judge_status,
                                           'used_time'=>$used_time,'used_memory'=>$used_memory));
        
    }
    
    public  function init()
    {
        $this->mq_con = new AMQPStreamConnection($this->_config['mq']['mq_host'],$this->_config['mq']['mq_port'],$this->_config['mq']['mq_user'],$this->_config['mq']['mq_password']);
       
        $this->mq_cha = $this->mq_con->channel();
        $this->mq_cha->basic_qos(null, $this->_config['mq']['mq_qos'], null);
        
        $callback = function($msg)
        {
            $arr = (array)json_decode($msg->body);
            $this->handledata($arr);
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };
        $this->mq_cha->basic_consume($this->_config['mq']['mq_queue'], '', false, false, false, false, $callback); 
    }
    
}
    $S = new Worker();
    $S->run($CONFIG);
?>
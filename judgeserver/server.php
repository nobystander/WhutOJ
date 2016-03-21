<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../config/config.php';
    use Workerman\Worker;

    $server_config = $CONFIG['judge']['server'];

    function send_post($url, $post_data) 
    {
  
        $postdata = http_build_query($post_data);
        $options = array(
          'http' => array(
          'method' => 'POST',//or GET
          'header' => 'Content-type:application/x-www-form-urlencoded',
          'content' => $postdata,
          'timeout' => 15 * 60 // 超时时间（单位:s）
        ));
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
     }


    function getFileId($filename)
    {
        $len = strlen($filename);
        $s = substr($filename,-3);
        if(is_numeric($s))
            return $s;
        else return '';
    }

    function generateHashDir($filedir)
    {
        $arr = array();
        $filenames = scandir($filedir);
        foreach($filenames as $key)
        {
            $t = getFileId($key);
            if($t)
                $arr[$t] = md5_file($filedir . '/' . $key);
        }
        return $arr;
    }

    function generateHashData($data_dir)
    {
        $input_hash = generateHashDir($data_dir . '/input');
        $output_hash = generateHashDir($data_dir . '/output');
        
        return array('input'=>$input_hash,'output'=>$output_hash);
        
    }

    function fileCompare($client_hash,$server_hash)
    {
        $need = array();
        foreach($client_hash as $kind => $arr)
        {
            $need[$kind] = array();
            $client_hash[$kind] = (array)$client_hash[$kind];
            foreach($arr as $key=>$value)
            {
                if(!isset($server_hash[$kind]) || !isset($server_hash[$kind][$key]))
                {
                    $need[$kind][$key] = 'remove';
                }
            }
        }
        
        foreach($server_hash as $kind => $arr)
        {
            if(!isset($need[$kind]))
                $need[$kind] = array();
            foreach($arr as $key=>$value)
            {
                if(!isset($client_hash[$kind]) || !isset($client_hash[$kind][$key]) ||
                    $client_hash[$kind][$key] != $server_hash[$kind][$key])
                {
                    $need[$kind][$key] = 'update';
                }
            }
        }
        
        
        return $need;
    }

    function fileRead($problem_id,$need)
    {
        global $server_config;
        $file = array();
        foreach($need as $kind => $arr)
        {
            $file[$kind] = array();
            foreach($arr as $value)
            {
                        
                $file_path = $server_config['problemdata_dir'] . '/' .$problem_id . '/' . $kind .'/'. $kind . $value;
                
                $file[$kind][$value] = file_get_contents($file_path);
               // echo $kind .  '  ' . $value . '  '. $file_path . '  ' .$file[$kind][$value] ."\n";
            }
        } 
        return $file;
    }

    function handledata($arr)
    {
        global $server_config;
        
        if(!isset($arr['secret_key']) || $arr['secret_key'] != $server_config['secret_key'])
        {
            echo "Wrong socket\n";
            return;
        }
        $type = $arr['type'];
        switch($type)
        {
            case 'init':
                $run_id = $arr['run_id'];
                $post_data = array(  
                    'run_id' => $run_id,  
                    'judge_status' => 1,
                    'used_time' => 0,
                    'used_memory'   => 0,
                    'secret_key'    => $server_config['secret_key']
                );  
                send_post('http://localhost/index.php?controller=server&action=judgeReturn', $post_data); 
                return array();
            case 'check':
                $client_hash = (array)$arr['hash'];
                $problem_id = $arr['problem_id'];
                $server_hash= generateHashData($server_config['problemdata_dir'] .'/'.$problem_id);
              //  echo $server_config['problemdata_dir'] .'/'.$problem_id. "\n";
                $need = fileCompare($client_hash,$server_hash);
                
                
                return $need;
            case 'getfile':
                $need = (array)$arr['need'];
                
                
//                foreach($need as $kind => $arr)
//                {
//                    foreach($arr as $key=>$value)
//                    {
//                        echo $kind . '   ' . $key . '  ' . $value . "\n";
//                    }
//                }  
                
                $problem_id = $arr['problem_id'];
                $file = fileRead($problem_id,$need);
              //  echo count($file);
                return $file;
            case 'getcode':
                $run_id = $arr['run_id'];
                $code_path = $server_config['code_dir'] . '/' .$run_id . '/code';
                $code = file_get_contents($code_path);
               // echo 'xxx' . $code . "\n";
                return array('code' => $code);
            case 'return':
                $run_id = $arr['run_id'];
                $judge_status = $arr['judge_status'];
                $used_time = $arr['used_time'];
                $used_memory = $arr['used_memory'];
                $log = (array)$arr['log'];
                echo $judge_status . '  ' . $used_time . '  ' . $used_memory ."\n";
                
                
                mkdir($server_config['log_dir'] .'/'.$run_id);
                foreach($log as $key=>$value)
                {
                    $log_dir = $server_config['log_dir'] .'/'.$run_id.'/'.$key;
                    file_put_contents($log_dir,$value);
                }
                
                $post_data = array(  
                    'run_id' => $run_id,  
                    'judge_status' => $judge_status,
                    'used_time' => $used_time,
                    'used_memory'   => $used_memory,
                    'secret_key'    => $server_config['secret_key']
                );  
                send_post('http://localhost/index.php?controller=server&action=judgeReturn', $post_data); 
                
                return array();
            default:
                return array();
                
        } 
     /*   foreach($arr as $key=>$value)
            echo $key . 'xxx' . $arr.$key . "\n";  */
        
        return $arr;
    }





    // #### create socket and listen 2333 port ####
    $tcp_worker = new Worker('tcp://'. $server_config['listen_host'] . ':' . $server_config['listen_port']);

    // 4 processes
    $tcp_worker->count = 1;

    // Emitted when new connection come
    $tcp_worker->onConnect = function($connection)
    {
        echo "New Connection\n";
    };

    // Emitted when data received
    $tcp_worker->onMessage = function($connection, $data)
    {
        $arr = (array)json_decode($data);
        // send data to client
        $connection->send(json_encode(handledata($arr)));
    };

    // Emitted when new connection come
    $tcp_worker->onClose = function($connection)
    {
        echo "Connection closed\n";
    };

    Worker::runAll();
    


?>
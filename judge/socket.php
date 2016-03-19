<?php  
    
    class Socket
    {
        private $host;
        private $port;
        private $socket_key;
        
        private $socket;
        
        
        public function __destruct()
        {
            $this->close();
        }
        
        public function init($host,$port,$socket_key)
        {
            $this->host = $host;
            $this->port = $port;
            $this->socket_key = $socket_key;
            $this->connect();
        }
        
        public function close()
        {
            if($this->socket)
            {
                socket_close($this->socket);
                $this->socket = null;
            }
        }
        
        public function connect()
        {
            $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);  
            if($this->socket < 0)
                exit("socket创建失败原因: " . socket_strerror($this->socket) . "\n");
            $result = socket_connect($this->socket,$this->host,$this->port);
            if($result < 0)
                exit("SOCKET连接失败原因: ($result) " . socket_strerror($result) . "\n");
            
        }
        
        
        public function sendAndReceive($arr)
        {
            $arr['secret_key'] = $this->socket_key;
            $data = json_encode($arr);
            socket_write($this->socket,$data,strlen($data));
            while ($out = socket_read($this->socket, $this->port))   
                return (array)json_decode($out);  
        }
        
        
    }
?>  
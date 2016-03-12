<?php

class submitModel extends Model
{
    private $mq;
    public function __construct() 
    {
        parent::__construct();
        $this->mq = $this->load('mqsender');
        $config_mq = $this->config('mq');
        $this->mq->init(
            $config_mq['mq_host'],
            $config_mq['mq_port'],
            $config_mq['mq_user'],
            $config_mq['mq_password'],
            $config_mq['mq_queue']
        );
    }
    
    
    public function hello()
    {
        
        $this->mq->send(100,100,0);
    }
    
    

}

?>
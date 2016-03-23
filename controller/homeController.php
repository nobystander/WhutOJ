<?php
class homeController extends Controller 
{
        
        public function __construct() 
        {
            parent::__construct(__CLASS__);
        }

        public function index($arr) 
        {
            
            
            $data['page_title'] = 'index';
            $data['user_name'] = 'asd';
            
            $this->showTemplate('header',$data);
            $this->showTemplate('footer',array());
        }

    
}


?>
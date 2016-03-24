<?php
class homeController extends Controller 
{
        
        public function __construct() 
        {
            parent::__construct(__CLASS__);
        }

        public function index($arr) 
        {
            
            $data = array();
            $data['page_title'] = 'Index';
            $data['css'] = $this->convertCss(array('animate','home'));
            $this->showTemplate('home',$data);
            
        }

    
}


?>
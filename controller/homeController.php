<?php
class homeController extends Controller 
{
        
        public function __construct() 
        {
            parent::__construct(__CLASS__);
        }

        public function index($arr) 
        {
            $data['page_title'] = 'WHUTOJ';
            #$data['user_name'] = 'asd';
            
            $this->showTemplate('header',$data);
            $this->showTemplate('footer',array());
        }

        public function hello()
        {
            $t = array('sd'=>'asd');
            $f = array();
            array_push($f,$t);
            echo $f[0]['sd'];
        }
}

?>

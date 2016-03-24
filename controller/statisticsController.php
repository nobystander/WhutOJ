<?php
class statisticsController extends Controller 
{
    public function __construct() 
    {
        parent::__construct(__CLASS__);
    }

    
    public function index($arr)
    {
        $data = array('page_title'=>'Statistics');
        $this->showTemplate('statistics',$data);
    }
    
    
    
}

?>
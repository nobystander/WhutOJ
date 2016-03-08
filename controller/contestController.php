<?php
class contestController extends Controller 
{
    
    public function __construct() 
    {
        parent::__construct(__CLASS__);
    }
    
    
    public function index($arr)
    {
        $script = $this->convertScript(array('contest'));
        $data = array('page_title'=>'Contest','script'=>$script);
        $this->showTemplate('contest',$data);
    }
    
    
}
?>
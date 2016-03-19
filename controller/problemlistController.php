<?php
class problemlistController extends Controller 
{
    
    public function __construct() 
    {
        parent::__construct(__CLASS__);
    }
        
    
    public function index($arr)
    {
        $script = $this->convertScript(array('problemlist'));
        $data = array('page_title'=>'ProblemList','script'=>$script);
        $this->showTemplate('problemlist',$data);
        
    }
    
    
}
?>
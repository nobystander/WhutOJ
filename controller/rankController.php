<?php
class rankController extends Controller 
{
    public function __construct() 
    {
        parent::__construct(__CLASS__);
    }

    
    public function index()
    {
        $script = $this->convertScript(array('rank'));
        $data = array('page_title'=>'Ranklist','script'=>$script);
        $this->showTemplate('rank',$data);
    }

    
}

?>
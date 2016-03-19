<?php
class statusController extends Controller 
{
    public function __construct() 
    {
        parent::__construct(__CLASS__);
    }

    
    public function index()
    {
        $script = $this->convertScript(array('status'));
        $data = array('page_title'=>'Status','script'=>$script);
        $this->showTemplate('status',$data);
    }
}

?>
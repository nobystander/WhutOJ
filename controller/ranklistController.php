<?php
class ranklistController extends Controller 
{
    public function __construct() 
    {
        parent::__construct(__CLASS__);
    }

    
    public function index()
    {
        $script = $this->convertScript(array('ranklist'));
        $data = array('page_title'=>'Ranklist','script'=>$script);
        $this->showTemplate('ranklist',$data);
    }
}

?>

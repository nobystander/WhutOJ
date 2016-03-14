<?php
class showcodeController extends Controller 
{
    public function __construct() 
    {
        parent::__construct(__CLASS__);
    }

    public function index($arr)
    {
		$run_id = $arr['run_id'];
		$lang = $this->M->getLanguage($run_id);
		$code = $this->M->getCode($run_id);
        $script = $this->convertScript(array('showcode'));
		$data = array('page_title'=>'showcode','script'=>$script,'lang'=>$lang,'code'=>$code);
        $this->showTemplate('showcode',$data);
    }
}

?>

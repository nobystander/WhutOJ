<?php
class problemlistController extends Controller 
{
    
    public function __construct() 
    {
        parent::__construct(__CLASS__);
    }
        
    
    public function index($arr)
    {
        /*
        $string = "asdasd";
        $safeString = filter_var(
            $string,
            FILTER_SANITIZE_STRING,
            FILTER_FLAG_STRIP_LOW | FILTER_FLAG_ENCODE_HIGH
        ); */
        $script = $this->convertScript(array('problemlist'));
        $data = array('page_title'=>'Problemlist','script'=>$script);
        $this->showTemplate('problemlist',$data);
        
    }
    
}
?>

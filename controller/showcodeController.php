<?php
class showcodeController extends Controller 
{
    public function __construct() 
    {
        parent::__construct(__CLASS__);
    }

    
    public function index($arr)
    {
        $this->checkParam($arr,array('run_id'=>1));
        $run_id = intval($arr['run_id']);
        $user_id = $this->M->getSubmitUserId($run_id);
        if(!$this->M->isAdmin())
        {
            $this->checkLogin($user_id);
        }
        $language_id = intval($this->M->getSubmitLanguageId($run_id));
        $language = $this->M->getLanguageName($language_id);
        $result = $this->M->getSubmitResult($run_id);
        $compile_error = '';
        if($result == 2)
            $compile_error = $this->M->getSubmitCompileError($run_id);
        
        $code = $this->M->getSubmitCode($run_id);
        $script = $this->convertScript(array('highlight.min'));
        $css = $this->convertCss(array('default.min'));
        $data = array('page_title'=>'ShowCode:'.$run_id,'css'=>$css,'script'=>$script,'language'=>$language,
                     'code'=>$code,'compile_error'=>$compile_error);
        $this->showTemplate('showcode',$data);
    }
    
    
    
}

?>
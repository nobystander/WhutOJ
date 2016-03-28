<?php
class discussController extends Controller 
{
    public function __construct() 
    {
        parent::__construct(__CLASS__);
    }

    
    public function index($arr)
    {
        $this->checkParam($arr,array('problem_id'=>1));
        $problem_id = intval($arr['problem_id']);
        $this->M->checkProblemId($problem_id);
        
        $data = array();
        $data['page_title'] = 'Discuss';
        $data['data'] = $this->M->getDiscuss($problem_id,0,1);
        $data['problem_id'] = $problem_id;
        $data['title'] = $this->M->getProblemTitle($problem_id);
        
        
        $script = $this->convertScript(array('jquery.validate.min','discuss'));
        $data['script'] = $script;
        $data['enable_mathjax'] = 1;
        $this->showTemplate('discuss',$data);
    }
    
    
}

?>
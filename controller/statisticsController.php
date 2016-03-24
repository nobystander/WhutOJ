<?php
class statisticsController extends Controller 
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
        $data['page_title'] = 'Statistics';
        
        $data['problem_rank'] = $this->M->getProblemRank($problem_id);
       
        
        $this->showTemplate('statistics',$data);
    }
    

    
}

?>
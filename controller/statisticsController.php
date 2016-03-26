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
       
        
        $data['CE_num'] =  $this->M->getProblemSubmitResultNum($problem_id,2);
        $data['AC_num'] =  $this->M->getProblemSubmitResultNum($problem_id,3);
        $data['RE_num'] = $this->M->getProblemSubmitResultNum($problem_id,4);
        $data['WA_num'] = $this->M->getProblemSubmitResultNum($problem_id,5);
        
        $data['Other_num'] = 0;
        for($i = 6;$i <= 9;$i++)
            $data['Other_num'] += $this->M->getProblemSubmitResultNum($problem_id,$i);
            
        $script = $this->convertScript(array('chart.min','statistics'));
        $data['script'] = $script;
        
        $this->showTemplate('statistics',$data);
    }
    

    
}

?>
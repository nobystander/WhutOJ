<?php

class statisticsModel extends Model
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function checkProblemId($problem_id)
    {
        $sql = "SELECT * FROM oj_problem WHERE problem_id=:problem_id AND visible=1";
        $data = $this->db->query($sql,array('problem_id'=>$problem_id));
        if(!count($data))
        {
            echo '<div class="row">';
            echo '<div class="alert alert-danger" style="text-align:center" role="alert">';
            echo 'Wrong Param';
            echo '</div>';
            exit();
        }
        
    }
    
    public function getProblemRank($problem_id)
    {
        $sql = "SELECT B.username,A.submit_time,MIN(A.time) AS time,A.memory FROM oj_submit AS A LEFT JOIN oj_user AS B ON(A.user_id = B.user_id) WHERE problem_id=:problem_id  AND A.result=3  GROUP BY A.user_id LIMIT 0,20";
        $data = $this->db->query($sql,array('problem_id'=>$problem_id));
        for($i = 0;$i < count($data);$i++)
        {
            $time = $data[$i]['submit_time'];
            $data[$i]['submit_time'] = $this->load('standard')->convertDate($time);
            
        }
        return $data;
    }
    
    public function getProblemSubmitResultNum($problem_id,$result)
    {
        $sql = "SELECT count(run_id) AS cnt FROM oj_submit WHERE problem_id=:problem_id AND result=:result";
        return $this->db->getNum($sql,array('problem_id'=>$problem_id,'result'=>$result));
    
    }
    
    
}

?>
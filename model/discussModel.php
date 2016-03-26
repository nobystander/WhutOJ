<?php

class discussModel extends Model
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function getProblemTitle($problem_id)
    {   
        $sql = "SELECT title FROM oj_problem WHERE problem_id=:problem_id";
        $data = $this->db->query($sql,array('problem_id'=>$problem_id));
        
        if(isset($data[0]['title']))
            return $data[0]['title'];
        else return '';
    }
    
    public function getUserName($id)
    {   
        $sql = "SELECT username FROM oj_user WHERE user_id=:user_id";
        $data = $this->db->query($sql,array('user_id'=>$id));
        
        if(isset($data[0]['username']))
            return $data[0]['username'];
        else return '';
    }
    
    
    public function getDiscuss($problem_id,$father,$deep)
    {
        
        $sql = "SELECT * FROM oj_discuss_:problem_id WHERE father=:father ORDER BY time";
        $data = $this->db->query($sql,array('problem_id'=>$problem_id,'father'=>$father));
        
        for($i = 0;$i < count($data);$i++)
        {
            $user_id = $data[$i]['user_id'];
            unset($data[$i]['user_id']);
            $data[$i]['username'] = $this->getUserName($user_id);
            $data[$i]['time'] = $this->load('standard')->convertDate($data[$i]['time']);
            $data[$i]['children'] = $this->getDiscuss($problem_id,$data[$i]['discuss_id'],$deep+1);
        }
        return $data;
        
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

}

?>
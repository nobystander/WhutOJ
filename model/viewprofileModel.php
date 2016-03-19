<?php


class viewprofileModel extends Model
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function getUserId($name)
    {
        $sql = "SELECT user_id FROM oj_user WHERE username=:username";
        $data = $this->db->query($sql,array('username'=>$name));
        if(isset($data[0]['user_id']))
            return $data[0]['user_id'];
        else return '';
    }
    

    
    public function getUserSchool($id)
    {
        $sql = "SELECT school FROM oj_user WHERE user_id=:user_id";
        $data = $this->db->query($sql,array('user_id'=>$id));
        if(isset($data[0]['school']))
            return $data[0]['school'];
        else return '';
    }
    
    public function getUserEmail($id)
    {
        $sql = "SELECT email FROM oj_user WHERE user_id=:user_id";
        $data = $this->db->query($sql,array('user_id'=>$id));
        if(isset($data[0]['email']))
            return $data[0]['email'];
        else return '';
    }
    
    public function getUserDescription($id)
    {
        $sql = "SELECT description FROM oj_user WHERE user_id=:user_id";
        $data = $this->db->query($sql,array('user_id'=>$id));
        if(isset($data[0]['description']))
            return $data[0]['description'];
        else return '';
    }

    public function getUserSolved($id)
    {
        $sql = "SELECT DISTINCT problem_id FROM oj_submit WHERE user_id=:user_id AND result = 3 ORDER BY problem_id";
        $data = $this->db->query($sql,array('user_id'=>$id));
        $result = array();
        for($i = 0; $i < count($data); $i++)
            array_push($result,$data[$i]['problem_id']);
        return $result;
    }
    
    public function getUserTry($id)
    {
        $sql = "SELECT DISTINCT problem_id FROM oj_submit WHERE user_id=:user_id AND  problem_id NOT IN  ( SELECT DISTINCT problem_id FROM oj_submit WHERE user_id=:user_id AND result = 3 ) ORDER BY problem_id";
        $data = $this->db->query($sql,array('user_id'=>$id));
        $result = array();
        for($i = 0; $i < count($data); $i++)
            array_push($result,$data[$i]['problem_id']);
        return $result;
    }
    
    public function getUserSubmitResultNum($id,$result)
    {
        $sql = "SELECT count(problem_id) AS cnt FROM oj_submit WHERE user_id=:user_id AND result=:result";
        return $this->db->getNum($sql,array('user_id'=>$id,'result'=>$result));
    }
    
    
    
}


?>
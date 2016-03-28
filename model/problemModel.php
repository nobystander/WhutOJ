<?php

class problemModel extends Model
{
    
    public function __construct() 
    {
        parent::__construct();
    }

    private function readFile($problem_id,$file)
    {
        $path = PROBLEM_PATH . '/' . $problem_id . '/'.$file .'.txt';
        
//        $myfile = fopen($path,'rb') or die('打开文件'. $path .'失败');
//        $data = fread($myfile,filesize($path));
//        fclose($myfile);
        $data = @file_get_contents($path);
        return $data;
    }
    
    public function getDescription($problem_id)
    {
        return $this->readFile($problem_id,'description');   
    }
    public function getInput($problem_id)
    {
        return $this->readFile($problem_id,'input');
    }
    public function getOutput($problem_id)
    {
        return $this->readFile($problem_id,'output');
    }
    public function getSampleInput($problem_id)
    {
        return $this->readFile($problem_id,'sample_input');
    }
    public function getSampleOutput($problem_id)
    {
        return $this->readFile($problem_id,'sample_output');
    }
    public function getHint($problem_id)
    {
        return $this->readFile($problem_id,'hint');
    }
    public function getTimeLimit($problem_id)
    {
        $data = $this->db->query('SELECT * FROM oj_problem WHERE problem_id=:problem_id', array('problem_id'=>$problem_id));
        return $data[0]['time_limit'];
    }
    public function getMemoryLimit($problem_id)
    {
        $data = $this->db->query('SELECT * FROM oj_problem WHERE problem_id=:problem_id', array('problem_id'=>$problem_id));
        return $data[0]['memory_limit'];
    }
    public function getSource($problem_id)
    {
        $data = $this->db->query('SELECT * FROM oj_problem WHERE problem_id=:problem_id', array('problem_id'=>$problem_id));
        return $data[0]['source'];
    }
    public function getTitle($problem_id)
    {
        $data = $this->db->query('SELECT * FROM oj_problem WHERE problem_id=:problem_id', array('problem_id'=>$problem_id));
        $data = $this->db->query('SELECT * FROM oj_problem WHERE problem_id=:problem_id', array('problem_id'=>$problem_id));
        return $data[0]['title'];
    }
    
    
    
    public function isAdmin()
    {
        if(!isset($_SESSION['user_id'])) return false;
        $user_id = intval($_SESSION['user_id']);
        
        $sql = "SELECT role FROM oj_user WHERE user_id=:user_id";
        $data = $this->db->query($sql,array('user_id'=>$user_id));
        return count($data) && $data[0]['role'] == 1;
        
    }
    
    public function checkProblemId($problem_id)
    {
        $sql = "SELECT * FROM oj_problem WHERE problem_id=:problem_id";
        $data = $this->db->query($sql,array('problem_id'=>$problem_id));
        if(!count($data))
        {
            echo '<div class="row">';
            echo '<div class="alert alert-danger" style="text-align:center" role="alert">';
            echo 'Wrong Param';
            echo '</div>';
            exit();
        }
        
        if($this->isAdmin()) return;
        
        $sql = "SELECT * FROM oj_problem WHERE problem_id=:problem_id AND visible=1";
        $data = $this->db->query($sql,array('problem_id'=>$problem_id));
        if(!count($data))
        {
            echo '<div class="row">';
            echo '<div class="alert alert-danger" style="text-align:center" role="alert">';
            echo 'Do not have the access';
            echo '</div>';
            exit();
        }
        
    }
}

?>
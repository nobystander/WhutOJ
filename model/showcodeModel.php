<?php
class showcodeModel extends Model
{
    public function __construct() 
    {
        parent::__construct();

    }
    
    public function getSubmitUserId($run_id)
    {   
        $sql = "SELECT user_id FROM oj_submit WHERE run_id=:run_id";
        $data = $this->db->query($sql,array('run_id'=>$run_id));
        
        if(isset($data[0]['user_id']))
            return $data[0]['user_id'];
        else return '';
    }
    
    public function getSubmitLanguageId($run_id)
    {   
        $sql = "SELECT language FROM oj_submit WHERE run_id=:run_id";
        $data = $this->db->query($sql,array('run_id'=>$run_id));
        
        if(isset($data[0]['language']))
            return $data[0]['language'];
        else return '';
    }
    
    public function getLanguageName($id)
    {   
        $sql = "SELECT language FROM oj_language WHERE language_id=:language_id";
        $data = $this->db->query($sql,array('language_id'=>$id));
        
        if(isset($data[0]['language']))
            return $data[0]['language'];
        else return '';
    }
    

    public function getSubmitCode($run_id)
    {   
        $submit_dir = $this->config('common')['submit_dir'];
        $code_dir = $submit_dir .'/'.$run_id;
        if(!file_exists($code_dir))
            return '';
        $code_path = $code_dir .'/code';
        return htmlspecialchars(file_get_contents($code_path));
            
    }
    
    
}
    
    
    
?>
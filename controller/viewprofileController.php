<?php

class viewprofileController extends Controller 
{
    public function __construct() 
    {
        parent::__construct(__CLASS__);
    }

    
    public function index($arr)
    {
        $this->checkParam($arr,array('username'=>0));
        
        $user_id = intval($this->M->getUserId($arr['username']));
        
        if(!$user_id)
        {
            echo 'Do not have this user';
            exit(1);
        }
        
        
        $data = array();
        $data['page_title'] = 'ViewProfile';
        $data['username'] = $arr['username'];
        $data['school']  = $this->M->getUserSchool($user_id);
        $data['email']   = $this->M->getUserEmail($user_id);
        $data['description'] = $this->M->getUserDescription($user_id);
        
        $data['solved'] = $this->M->getUserSolved($user_id);
        $data['try'] = $this->M->getUserTry($user_id);
        
        $data['CE_num'] =  $this->M->getUserSubmitResultNum($user_id,2);
        $data['AC_num'] =  $this->M->getUserSubmitResultNum($user_id,3);
        $data['RE_num'] = $this->M->getUserSubmitResultNum($user_id,4);
        $data['WA_num'] = $this->M->getUserSubmitResultNum($user_id,5);
        
        $data['Other_num'] = 0;
        for($i = 6;$i <= 9;$i++)
            $data['Other_num'] += $this->M->getUserSubmitResultNum($user_id,$i);
        
        if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user_id)
            $data['is_self'] = 1;
        else
            $data['is_self'] = 0;
        
        $script = $this->convertScript(array('chart.min','viewprofile'));
        $data['script'] = $script;
        
        $this->showTemplate('viewprofile',$data);
    }
    
}

?>
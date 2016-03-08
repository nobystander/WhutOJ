<?php
class serverController extends Controller 
{
        private $num_var = array('skip','num','user_id','problem_id');
            
            
            
        public function __construct() 
        {
            parent::__construct(__CLASS__);
        }

        public function logIn()
        {
            $this->M->logIn();
        }
        
        public function signUp()
        {
            $this->M->signUp();
        }
    
        private function isNum($name)
        {
            return in_array($name,$this->num_var);
        }
    
        private function checkRealParam($arr)
        {
            $list = array();
            for($i = 0;$i < count($arr); $i++)
            {
                if(isset($_POST[$arr[$i]]))
                    $list[$arr[$i]] = $_POST[$arr[$i]];
            }
            return $list;
        }
    
        private function ConvertParam($arr)
        {
            if(isset($arr['username']))
            {
                $user_id = $this->M->getUserId($arr['username']);
                unset($arr['username']);
                $arr['user_id'] = $user_id;
            }
            
            foreach($arr as $key=>$value)
            {
                if($this->isNum($key))
                {
                    if(is_numeric($value))
                    {
                        $arr[$key] = intval($value);
                    }
                }
            }
            return $arr;
        }
    
       public function getTotalProblemNum()
        {
            if(!isset($_POST['addition']))
                $this->M->getTotalProblemNum();
            else
                $this->M->getTotalProblemNum($_POST['addition']);
        }
    
        public function getTotalSubmitNum()
        {
            $arr = array('username','problem_id');
            $arr = $this->checkRealParam($arr);
            $arr = $this->ConvertParam($arr);
            $this->M->getTotalSubmitNum($arr);
        }
    
    
        public function getProblem()
        {
            $skip = intval($_POST['skip']);
            $num = intval($_POST['num']);
            if(!isset($_POST['addition']))
                $this->M->getProblem($skip,$num);
            else
            {
                $this->M->getProblem($skip,$num,$_POST['addition']);
            }
               
        }
    
        public function getSubmit()
        {
            $skip = intval($_POST['skip']);
            $num = intval($_POST['num']);
            $arr = array('username','problem_id');
            $arr = $this->checkRealParam($arr);
            $arr = $this->ConvertParam($arr);
        
            $this->M->getSubmit($skip,$num,$arr);
            
        }
      
        public function getNowTime()
        {
            echo time();
        }
    
        public function getContest()
        {
            
        }
        
}

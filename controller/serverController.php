<?php
class serverController extends Controller 
{
        private $num_var = array('skip','num','user_id','problem_id','run_id',
                                'judge_status','used_time','used_limit','language_id');
            
            
            
        public function __construct() 
        {
            parent::__construct(__CLASS__);
        }

        public function logIn()
        {
            $this->checkParam($_POST,array('username'=>0,'password'=>0));
            $this->M->logIn($_POST);
        }
        
        public function signUp()
        {
            $this->checkParam($_POST,array('username'=>0,'password'=>0,'email'=>0,'school'=>0));
            $this->M->signUp($_POST);
        }
    
        public function editProfile()
        {
            $this->checkParam($_POST,array('username'=>0,'school'=>0,'email'=>0));
            if(!isset($_POST['description']))
                $_POST['description'] = '';
            $user_id = $this->M->getUserId($_POST['username']);
            $this->checkLogin($user_id);
            $this->M->editProfile($_POST);
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
            
            if(isset($arr['language']))
            {
                $language_id = $this->M->getLanguageId($arr['language']);
                unset($arr['language']);
                $arr['language_id'] = $language_id;
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
                echo $this->M->getTotalProblemNum();
            else
                echo $this->M->getTotalProblemNum($_POST['addition']);
        }
    
        public function getTotalSubmitNum()
        {
            $arr = array('username','problem_id');
            $arr = $this->checkRealParam($arr);
            $arr = $this->ConvertParam($arr);
            echo $this->M->getTotalSubmitNum($arr);
        }
    
        public function getTotalUserNum()
        {
            $arr = array('username');
            $arr = $this->checkRealParam($arr);
            echo $this->M->getTotalUserNum($arr);
            
        }
        
    
    
    
        public function getProblem()
        {
            $this->checkParam($_POST,array('skip'=>1,'num'=>1));
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
            $this->checkParam($_POST,array('skip'=>1,'num'=>1));
            $skip = intval($_POST['skip']);
            $num = intval($_POST['num']);
            $arr = array('username','problem_id');
            $arr = $this->checkRealParam($arr);
            $arr = $this->ConvertParam($arr);
        
            $this->M->getSubmit($skip,$num,$arr);
            
        }
    
        public function getRank()
        {
            $this->checkParam($_POST,array('skip'=>1,'num'=>1));
            $skip = intval($_POST['skip']);
            $num = intval($_POST['num']);
            $arr = array('username');
            $arr = $this->checkRealParam($arr);
            
            $this->M->getRank($skip,$num,$arr);
            
        }
      
        public function getNowTime()
        {
            echo time();
        }
    
        public function getContest()
        {
            
        }
    
    
        
    
        public function submit()
        {
           // return;
            if(!isset($_SESSION['user_id']))
            {
                 echo json_encode(array('flag'=>false));
                return;
            }
            $arr = array('language','problem_id','sourcecode');
            $arr = $this->checkRealParam($arr);
            $arr['user_id'] = $_SESSION['user_id'];
            $arr = $this->ConvertParam($arr); 
            if(!$arr['language_id'])
            {
                 echo json_encode(array('flag'=>false));
                return;
            }
//            echo json_encode(array('flag'=>$arr['sourcecode']));
//                return;
            $this->M->submit($arr);
            // $language_id = $this->M->getLanguageId($arr['language'])
            
        }
    
    
        public function judgeReturn()
        {
            $arr = array('run_id','judge_status','used_time','used_memory','secret_key');
            $arr = $this->checkRealParam($arr);
            $arr = $this->ConvertParam($arr);
            if(!$this->M->judgeReturnCheck($arr))
                exit("No access to this function");
            
            unset($arr['secret_key']);
            $this->M->judgeReturnUpdate($arr);
            
            echo "OK";
        }
        
}

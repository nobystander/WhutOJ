<?php
class backendController extends Controller 
{
        private $num_var = array('time_limit','memory_limit','visible','problem_id');    
    
    
        public function __construct() 
        {
            parent::__construct(__CLASS__);
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
    
        private function convertParam($arr)
        {
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
            
        public function subParam($arr,$need)
        {
            $list = array();
            for($i = 0;$i < count($need);$i++)
            {
                $key = $need[$i];
                if(isset($arr[$key]))
                    $list[$key] = $arr[$key];
                else
                    $list[$key] = '';
            }
            return $list;
        }
    
    
        public function index($arr) 
        {
            $data['page_title'] = 'Backend';
            $data['script'] = $this->convertScript(array('jquery.validate.min','backend'));
            $this->showTemplate('backend',$data);
        }

        
        
    
    
        public function addProblem()
        {
            if(empty($_FILES['data']) || $_FILES['data']['type'] != 'application/x-tar')
            {
                $list = array();
                $list['flag'] = false;
                $list['info'] = 'Data格式错误';
                echo json_encode($list);
                return;
            }
            $arr = $this->checkRealParam(array('title','time_limit','memory_limit','description',
                        'input','output','sample_input','sample_output','hint','source','visible'));
            if(!isset($arr['visible']))
                $arr['visible'] = 0;
            $arr = $this->convertParam($arr);
    
            $arr1 = $this->subParam($arr,array('title','time_limit','memory_limit','source','visible'));
            $problem_id = $this->M->addProblem($arr1);
            $arr2 = $this->subParam($arr,array('description','input','output','sample_input',
                            'sample_output','hint'));
            $this->M->moveProblemData($problem_id,$arr2,$_FILES['data']);
            
        }
    
        public function editProblem()
        {
            if( is_uploaded_file($_FILES['data']['tmp_name']) && $_FILES['data']['type'] != 'application/x-tar')
            {
                $list = array();
                $list['flag'] = false;
                $list['info'] = 'Data格式错误';
                echo json_encode($list);
                return;
            }
            $arr = $this->checkRealParam(array('problem_id','title','time_limit','memory_limit','description',
                        'input','output','sample_input','sample_output','hint','source','visible'));
            if(!isset($arr['visible']))
                $arr['visible'] = 0;
            
            
            $arr = $this->convertParam($arr);
            $arr1 = $this->subParam($arr,array('problem_id','title','time_limit','memory_limit','source','visible'));
            $this->M->editProblem($arr1);
            $problem_id = $arr['problem_id'];
            $arr2 = $this->subParam($arr,array('description','input','output','sample_input',
                            'sample_output','hint'));
            $this->M->moveProblemData($problem_id,$arr2,$_FILES['data']);

        }
    
        public function loadProblem()
        {
            $this->checkParam($_POST,array('problem_id'=>1));
            
            $arr = $this->checkRealParam(array('problem_id'));
            $arr = $this->convertParam($arr);
            
            $is_ok = $this->M->checkProblemId($arr);
            if(!$is_ok)
            {
                $list = array();
                $list['flag'] = false;
                $list['info'] = 'Problem ID 不存在';
                echo json_encode($list);
                return;
            }
            
            $this->M->loadProblem($arr);
            
        }
    
    
        public function getTotalProblemNum()
        {
            if(!isset($_POST['addition']))
                echo $this->M->getTotalProblemNum();
            else
                echo $this->M->getTotalProblemNum($_POST['addition']);
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
        
        public function changeProblemVisible()
        {
            $this->checkParam($_POST,array('problem_id'=>1,'visible'=>1));
            $arr = $this->checkRealParam(array('problem_id','visible'));
            $arr = $this->convertParam($arr);
            $this->M->changeProblemVisible($arr);
        }
    
        public function getRunLog()
        {
//            $list = array();
//        $list['flag'] = true;
//        echo json_encode($list);
//        return;
            
            $this->checkParam($_POST,array('run_id'=>1));
            $arr = $this->checkRealParam(array('run_id'));
            $arr = $this->convertParam($arr);
            $this->M->getRunLog($arr);
        }
    
}


?>
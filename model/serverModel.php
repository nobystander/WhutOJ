<?php

class serverModel extends Model
{
    
    private $standard;
    public function __construct() 
    {
        parent::__construct();
        $this->standard = $this->load('standard');
    }
    
    /**
     * 获得用户名对应的ID
     */
    public function getIp()
    {
        return $this->db->getIp();
    }
    
    public function judgeReturnCheck($arr)
    {
        if($this->db->getIp() != '127.0.0.1') return false;
        if(!isset($arr['secret_key'])) return false;
        if($arr['secret_key'] != $this->config('common')['secret_key']) return false;
        return true;
    }
    
    public function judgeReturnUpdate($arr)
    {
        $sql = "UPDATE oj_submit SET result=:judge_status,time=:used_time,memory=:used_memory WHERE run_id=:run_id";
        $this->db->execute($sql,$arr);
    }
    
    public function getUserId($name)
    {
        $sql = "SELECT user_id FROM oj_user WHERE username=:username";
        $data = $this->db->query($sql,array('username'=>$name));
        if(isset($data[0]['user_id']))
            return $data[0]['user_id'];
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
    public function getResultName($id)
    {
        
        $sql = "SELECT result FROM oj_result WHERE result_id=:result_id";
        $data = $this->db->query($sql,array('result_id'=>$id));
        
        if(isset($data[0]['result']))
            return $data[0]['result'];
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
    
    public function getLanguageId($language)
    {
        $sql = "SELECT language_id FROM oj_language WHERE language=:language";
        $data = $this->db->query($sql,array('language'=>$language));
        
        if(isset($data[0]['language_id']))
            return $data[0]['language_id'];
        else return '';
    } 
    public function getProblemTimeLimit($problem_id)
    {
        $sql = "SELECT time_limit FROM oj_problem WHERE problem_id=:problem_id";
        $data = $this->db->query($sql,array('problem_id'=>$problem_id));
        
        if(isset($data[0]['time_limit']))
            return $data[0]['time_limit'];
        else return '';
    }
    public function getProblemMemoryLimit($problem_id)
    {
        $sql = "SELECT memory_limit FROM oj_problem WHERE problem_id=:problem_id";
        $data = $this->db->query($sql,array('problem_id'=>$problem_id));
        
        if(isset($data[0]['memory_limit']))
            return $data[0]['memory_limit'];
        else return '';
    }
    
    
    private function makeupQuery($arr)
    {
        $query = '';
        $first = true;
        foreach($arr as $key => $value)
        {
            if($first)
            {
                $query .= " WHERE $key=:$key ";
                $first = false;
            }
            else
            {
                $query .= " AND $key=:$key ";
            }
        }
        return $query;
    }
    
    /**
     * 获得problem总数
     */
    public function getTotalProblemNum($addition='')
    {
        $result = 0;
        if($addition == '')
            $result = $this->db->getNum('SELECT count(*) AS cnt FROM oj_problem',array());
        else
        {
            if(is_numeric($addition))
            {
                $result = $this->db->getNum("SELECT count(*) AS cnt FROM oj_problem WHERE problem_id=:problem_id OR title like :liketitle OR source like :likesource",
                    array('problem_id'=>$addition,'liketitle'=>'%'.$addition.'%',
                         'likesource'=>'%'.$addition.'%'));
                
            }
            else
            {
                $result = $this->db->getNum("SELECT count(*) AS cnt FROM oj_problem WHERE title like :liketitle OR source like :likesource",
                    array('liketitle'=>'%'.$addition.'%',
                         'likesource'=>'%'.$addition.'%'));
            }
        }
        //echo $result;
        return $result;
    }

    /**
     * 获得status总数
     */
    public function getTotalSubmitNum($arr = array())
    {
        $query = "SELECT count(*) AS cnt FROM oj_submit" . $this->makeupQuery($arr);
        $result = $this->db->getNum($query,$arr);
        //echo $result;
        return $result;
    }
    
    public function getTotalUserNum($arr = array())
    {
        $query = "SELECT count(*) AS cnt FROM oj_user" . $this->makeupQuery($arr);
        $result = $this->db->getNum($query,$arr);
      //  echo $result;
        return $result;
    }
    
    /**
     * 获得problem信息
     * @access      public
     * @param       $skip   int 跳过数量
     * @param       $num    int 当前获取数量
     */
    public function getProblem($skip,$num,$addition='')
    {
        if($addition == '')
            $data = $this->db->query("SELECT * FROM oj_problem LIMIT :skip,:num",
                                array('skip'=>$skip,'num'=>$num));
        else
        {
            if(is_numeric($addition))
            {
                $data = $this->db->query("SELECT * FROM oj_problem WHERE problem_id=:problem_id OR title like :liketitle OR source like :likesource LIMIT :skip,:num",
                    array('problem_id'=>$addition,'liketitle'=>'%'.$addition.'%',
                         'likesource'=>'%'.$addition.'%','skip'=>$skip,'num'=>$num));
            }
            else
            {
            
                $data = $this->db->query("SELECT * FROM oj_problem WHERE title like :liketitle OR source like :likesource LIMIT :skip,:num",
                    array('liketitle'=>'%'.$addition.'%',
                         'likesource'=>'%'.$addition.'%','skip'=>$skip,'num'=>$num));
            
            }
                
        }
        
        for($i = 0;$i < count($data);$i++)
        {
            $problem_id = intval($data[$i]['problem_id']);
            $sql = "SELECT count(*) AS cnt FROM oj_submit WHERE problem_id=:problem_id";
            $data[$i]['total_num'] = $this->db->getNum($sql,array('problem_id'=>$problem_id));
            $sql = "SELECT count(*) AS cnt FROM oj_submit WHERE problem_id=:problem_id AND result = 3";
            $data[$i]['ac_num'] = $this->db->getNum($sql,array('problem_id'=>$problem_id));
            
            if(isset($_SESSION['user_id']))
            {
                $user_id = intval($_SESSION['user_id']);
                $sql = "SELECT count(*) AS cnt FROM oj_submit WHERE problem_id=:problem_id AND result = 3 AND user_id=:user_id";
                $num = $this->db->getNum($sql,array('problem_id'=>$problem_id,'user_id'=>$user_id));
                if($num)
                    $data[$i]['flag'] = 1;
                else
                    $data[$i]['flag'] = 0;
            }
            else
                $data[$i]['flag'] = 0;
        }
        
        
        echo json_encode($data);
    } 
   
    
    public function getSubmit($skip,$num,$arr = array())
    {        
        $sql = "SELECT * FROM oj_submit". $this->makeupQuery($arr) ." ORDER BY run_id DESC LIMIT :skip,:num";
        $nowarr = array_merge(array('skip'=>$skip,'num'=>$num),$arr);
        $data = $this->db->query($sql,$nowarr);
        for($i = 0;$i < count($data);$i++)
        {
            $user_id = $data[$i]['user_id'];
            $result_id  = $data[$i]['result'];
            $language_id = $data[$i]['language'];
            
            unset($data[$i]['user_id']);
            $data[$i]['username'] = $this->getUserName($user_id);
            $data[$i]['result'] = $this->getResultName($result_id);
            $data[$i]['language'] = $this->getLanguageName($language_id);
        } 
         echo json_encode($data);
    }
    
    public function getRank($skip,$num,$arr = array())
    {
        $sql = 'SELECT A.username,A.description, count(DISTINCT B.problem_id) AS  cnt  FROM oj_user as A LEFT JOIN oj_submit as B ON (A.user_id = B.user_id) AND B.result = 3 GROUP BY A.username ORDER BY cnt DESC';
        $data = $this->db->query($sql,array());
        for($i = 0;$i < count($data);$i++)
        {
            $data[$i]['rank'] = $i+1;
            $user_id = intval($this->getUserId($data[$i]['username']));
            $data[$i]['submitted'] = $this->getTotalSubmitNum(array('user_id'=>$user_id));
        }
        
        if(!isset($arr['username']))
        {
            echo json_encode($data);
        }
        else
        {
            $now = array();
            $username = $arr['username'];
            for($i = 0;$i < count($data);$i++)
            {
                if($data[$i]['username'] == $username)
                {
                    $now[0] = $data[$i];
                    break;
                }
            }
            echo json_encode($now);
        }
        
    }
    
    public function submit($arr)
    {
        
        $sql = " INSERT INTO oj_submit(user_id,problem_id,language,length,submit_time) VALUES(:user_id,:problem_id,:language_id,:length,:submit_time)"; //need now time
        $sourcecode = $arr['sourcecode'];
        unset($arr['sourcecode']);
        $arr['length'] = intval(strlen($sourcecode));
        $arr['submit_time'] = time();
        $this->db->execute($sql,$arr);
        $run_id = $this->db->getNum("SELECT count(*) AS cnt FROM oj_submit",array());
        $submit_dir = $this->config('common')['submit_dir'] . '/'. $run_id;
        mkdir($submit_dir);
        file_put_contents($submit_dir.'/code',$sourcecode);
        
        $time_limit = $this->getProblemTimeLimit(intval($arr['problem_id']));
        $memory_limit = $this->getProblemMemoryLimit(intval($arr['problem_id']));
        
        //  echo json_encode(array('flag'=>$run_id));
        
        //$this->mq->send(24,1000,2,1,64);
        echo json_encode(array('flag'=>true));
        $this->mq->send(intval($run_id),intval($arr['problem_id']),intval($arr['language_id']),intval($time_limit),intval($memory_limit));
        
    }
    
   
    
    
    /**
     * ajax登录函数
     * @access      public 
     */
    public function logIn($arr)
    {
        $username = $arr['username'];
        $password = $arr['password'];
        if(!$this->standard->checkUsername($username))
        {
            $list = array('flag'=>'false','info'=>'用户名或密码错误');
            echo json_encode($list);
            return;
        }
        if(!$this->standard->checkPassword($password))
        {
            $list = array('flag'=>'false','info'=>'用户名或密码错误');
            echo json_encode($list);
            return;
        }  
        $username = $this->standard->filterText($username);
        $password = sha1($password);


        $data = $this->db->query("SELECT * FROM oj_user WHERE username=:username AND 
            password=:password",array('username'=>$username,'password'=>$password) );

        if(count($data) == 0)
        {
            $list = array('flag'=>'false','info'=>'用户名或密码错误');
            echo json_encode($list);
            return;
        }


        $config_cookie = $this->config('cookie');

        $_SESSION['user_id'] = $data[0]['user_id'];
        $_SESSION['username'] = $data[0]['username'];
        setcookie('hashstr',$data[0]['hashstr'],time()+$config_cookie['time']);
        $list = array('flag'=>'true');
        echo json_encode($list); 


    } 

    /**
     * ajax注册函数
     * @access      public
     */
    public function signUp($arr)
    {
        $username = $arr['username'];
        $password = $arr['password'];
        $email = trim($arr['email']);
        $school = trim($arr['school']);
        $hashstr = sha1($username);
        
        if(!$this->standard->checkUsername($username))
        {
            $list = array('flag'=>'false','info'=>'用户名格式错误');
            echo json_encode($list);
            return;
        }
        if(!$this->standard->checkPassword($password))
        {
            $list = array('flag'=>'false','info'=>'密码格式错误');
            echo json_encode($list);
            return;
        }  
        if(!$this->standard->checkEmail($email))
        {
            $list = array('flag'=>'false','info'=>'邮箱格式错误');
            echo json_encode($list);
            return;
        }
        if(!$this->standard->checkSchool($school))
        {
            $list = array('flag'=>'false','info'=>'学校输入包含非法字符');
            echo json_encode($list);
            return;
        }  
        
        $username = $this->standard->filterText($username);
        $school = $this->standard->filterText($school);
        $email = $this->standard->filterText($email);
        
        $password = sha1($password);
    
        $data = $this->db->query("SELECT * FROM oj_user WHERE username=:username",
                                array('username'=>$username));

        
        if(count($data) != 0)
        {
            $list = array('flag'=>'false','info'=>'用户名已存在');
            echo json_encode($list);
            return;
        }


        $this->db->execute("INSERT INTO oj_user(username,password,email,school,hashstr) VALUES(:username,:password,:email,:school,:hashstr)",
                          array('username'=>$username,'password'=>$password,
                          'email'=>$email,'school'=>$school,'hashstr'=>$hashstr));
       
         $this->logIn(array('username'=>$arr['username'],'password'=>$arr['password']));
     }
    
    public function editProfile($arr)
    {
        $school = trim($arr['school']);
        $email = trim($arr['email']);
        $description = $arr['description'];
        
        if(!$this->standard->checkSchool($school))
        {
            $list = array('flag'=>'false','info'=>'学校输入包含非法字符');
            echo json_encode($list);
            return;
        }  
        if(!$this->standard->checkEmail($email))
        {
            $list = array('flag'=>'false','info'=>'邮箱格式错误');
            echo json_encode($list);
            return;
        }
        
        $school = $this->standard->filterText($school);
        $email = $this->standard->filterText($email);
        $user_id = intval($_SESSION['user_id']);
        
        
        $sql = "UPDATE oj_user SET school=:school,email=:email,description=:description WHERE user_id=:user_id";
        

        $this->db->execute($sql,array('school'=>$school,'email'=>$email,'description'=>$description,'user_id'=>$user_id));
        
        $list = array('flag'=>'true');
        echo json_encode($list);
    }
   
}

?>
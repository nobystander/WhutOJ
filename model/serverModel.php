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
         if($addition == '')
            echo $this->db->getNum('SELECT * FROM oj_problem',array());
        else
        {
            if(is_numeric($addition))
            {
                echo $this->db->getNum("SELECT * FROM oj_problem WHERE problem_id=:problem_id OR title like :liketitle OR source like :likesource",
                    array('problem_id'=>$addition,'liketitle'=>'%'.$addition.'%',
                         'likesource'=>'%'.$addition.'%'));
                
            }
            else
            {
                echo $this->db->getNum("SELECT * FROM oj_problem WHERE title like :liketitle OR source like :likesource",
                    array('liketitle'=>'%'.$addition.'%',
                         'likesource'=>'%'.$addition.'%'));
            }
        }
    }

    /**
     * 获得status总数
     */
    public function getTotalSubmitNum($arr = array())
    {
        $query = "SELECT * FROM oj_submit" . $this->makeupQuery($arr);
        echo $this->db->getNum($query,$arr);
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
        echo json_encode($data);
    } 
   
    
    public function getSubmit($skip,$num,$arr = array())
    {        
        $sql = "SELECT * FROM oj_submit". $this->makeupQuery($arr) ." LIMIT :skip,:num";
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
    
    /**
     * ajax登录函数
     * @access      public 
     */
    public function logIn()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

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
    public function signUp()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = trim($_POST['email']);
        $school = $_POST['school'];
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
        $school = $this->standard->filterText($username);
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
       
         $this->logIn();
     }

     /**
      * ajax更新函数
      * @access      public 
      */

	 public function changeProfile()	
	 {
	  	$username = 'nobystander';
	  	$password = '123321gyh';
	  	$school='whut';
	  	$email=trim('i@gyh.me');
      	$hashstr = sha1($username);
		 
//		$username = $_POST['username'];
//        $password = $_POST['password'];
//        $email = trim($_POST['email']);
//        $school = $_POST['school'];
//        $hashstr = sha1($username);
//
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
        $school = $this->standard->filterText($username);
        $email = $this->standard->filterText($email);
        
        $password = sha1($password);

        $this->db->execute("UPDATE oj_user(password,email,school,hashstr) VALUES(:password,:email,:school,:hashstr) WHERE username=:username",
                          array('password'=>$password,
                          'email'=>$email,'school'=>$school,'hashstr'=>$hashstr,'username'=>$username));

        $list = array('flag'=>'true');
		echo json_encode($list);
	 }
}

?>

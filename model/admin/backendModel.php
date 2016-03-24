<?php

class backendModel extends Model
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function checkProblemId($arr)
    {
        $this->checkAdminLogin();
        $sql = "SELECT * FROM oj_problem WHERE problem_id=:problem_id";
        $data = $this->db->query($sql,$arr);
        return count($data);
    }
    
    public function loadProblem($arr)
    {
        $this->checkAdminLogin();
        $sql = "SELECT title,source,time_limit,memory_limit,visible FROM oj_problem WHERE problem_id=:problem_id";
        $data = $this->db->query($sql,$arr);
        $data = $data[0];
        $problem_id = $arr['problem_id'];
        
        $content_dir = PROBLEM_PATH . '/' . $problem_id;
        $need = array('description','hint','input','output','sample_input','sample_output');
        for($i = 0; $i < count($need);$i++)
        {
            $key = $need[$i];
            $path = $content_dir . '/' . $key .'.txt';
            $data[$key] = @file_get_contents($path);
        }
        $data['problem_id'] = $problem_id;
        
       $list = array();
        $list['flag'] = true;
        $list['info'] = $data;
        echo json_encode($list);
        return;
    }
    
    public function addProblem($arr)
    {
        $this->checkAdminLogin();
        $sql = "INSERT INTO oj_problem(title,source,add_time,time_limit,memory_limit,visible) VALUES(:title,:source,NOW(),:time_limit,:memory_limit,:visible)";
        $this->db->execute($sql,$arr); 
        $problem_id = $this->db->getLastId();
        return $problem_id;
    }
    
    public function editProblem($arr)
    {
        $this->checkAdminLogin();
        $sql = "UPDATE oj_problem SET title=:title,source=:source,time_limit=:time_limit,memory_limit=:memory_limit,visible=:visible WHERE problem_id=:problem_id";
        $this->db->execute($sql,$arr);
    }
    
    public function moveProblemData($problem_id,$content,$data)
    {
        
        $this->checkAdminLogin();
        
        $content_dir = PROBLEM_PATH . '/' . $problem_id;
        if(file_exists($content_dir))
        {
            array_map('unlink', glob("$content_dir/*.*")); //delete all exists content            
        }
        else
            mkdir($content_dir);
        
        foreach($content as $key=>$value)
        {
            $t = $content_dir . '/' . $key . '.txt';
            @file_put_contents($t,$value);
        }
        
        
        
        if(is_uploaded_file($data['tmp_name']))
        {
            
            $data_dir = $this->config('common')['problemdata_dir'] . '/'. $problem_id;
            if(file_exists($data_dir))
            {
                if(file_exists("$data_dir/input"))
                {
                    array_map('unlink', glob("$data_dir/input/*")); //delete all exists content
                    rmdir("$data_dir/input");
                }
                if(file_exists("$data_dir/output"))
                {
                    array_map('unlink', glob("$data_dir/output/*")); //delete all exists content
                    rmdir("$data_dir/output");    
                }
                
            }
            else
                mkdir($data_dir);
            move_uploaded_file($data['tmp_name'],$data_dir .'/tmp.tar');

            try 
            {
                $phar = new PharData($data_dir .'/tmp.tar');
                $phar->extractTo($data_dir); // extract all files
            } catch (Exception $e) {
                $list = array();
                $list['flag'] = false;
                $list['info'] = 'Data 解压失败,请检查后EditProblem修改,切勿再次提交';
                echo json_encode($list);
                return;
            }

            if(!file_exists($data_dir.'/input') || !file_exists($data_dir.'/output'))
            {
                $list = array();
                $list['flag'] = false;
                $list['info'] = 'Data 数据错误,请检查后EditProblem修改,切勿再次提交';
                echo json_encode($list);
                return;
            }
            unlink($data_dir .'/tmp.tar');
        }
        $list = array();
        $list['flag'] = true;
        echo json_encode($list);
    }
    
    
    public function getTotalProblemNum($addition='')
    {
        $this->checkAdminLogin();
        $result = 0;
        if($addition == '')
            $result = $this->db->getNum('SELECT count(*) AS cnt FROM oj_problem ',array());
        else
        {
            if(is_numeric($addition))
            {
                $result = $this->db->getNum("SELECT count(*) AS cnt FROM oj_problem WHERE problem_id=:problem_id OR title like :liketitle OR source like :likesource ",
                    array('problem_id'=>$addition,'liketitle'=>'%'.$addition.'%',
                         'likesource'=>'%'.$addition.'%'));
                
            }
            else
            {
                $result = $this->db->getNum("SELECT count(*) AS cnt FROM oj_problem WHERE title like :liketitle OR source like :likesource ",
                    array('liketitle'=>'%'.$addition.'%',
                         'likesource'=>'%'.$addition.'%'));
            }
        }
        //echo $result;
        return $result;
    }
    
    
    public function getProblem($skip,$num,$addition='')
    {
        $this->checkAdminLogin();
        if($addition == '')
            $data = $this->db->query("SELECT * FROM oj_problem  LIMIT :skip,:num",
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
            
                $data = $this->db->query("SELECT * FROM oj_problem WHERE title like :liketitle OR source like :likesource  LIMIT :skip,:num",
                    array('liketitle'=>'%'.$addition.'%',
                         'likesource'=>'%'.$addition.'%','skip'=>$skip,'num'=>$num));
            
            }
                
        }
        echo json_encode($data);
    } 
    
    public function changeProblemVisible($arr)
    {
        $this->checkAdminLogin();
        $sql = "UPDATE oj_problem SET visible=:visible WHERE problem_id=:problem_id";
        $this->db->execute($sql,$arr);
        $list = array();
        $list['flag'] = true;
        echo json_encode($list);
    }
    
    public function getRunLog($arr)
    {
        $this->checkAdminLogin();
        $run_id = $arr['run_id'];
        $log_dir = $this->config('common')['runlog_dir'] . '/' . $run_id;
        $data = array();
        
        $need = array('compile_error','compile_log','run_error','run_log');
        for($i = 0;$i < count($need);$i++)
        {
            $key = $need[$i];
            $data[$key] = $this->load('standard')->encodehtml(@file_get_contents($log_dir .'/'.$key));
        }
        echo json_encode($data);
    }
    
    public function checkAdminLogin($arr)
    {
        $sql = "SELECT role FROM oj_user WHERE user_id=:user_id";
        $data = $this->db->query($sql,$arr);
        if(!count($data))
            return false;
        $role = $data[0]['role'];
        return $role == 1;
    }
    
    
}

?>
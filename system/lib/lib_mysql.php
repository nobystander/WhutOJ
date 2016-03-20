<?php
/**
 * Mysql 操作类
 * @copyright    Copyright(c) 2015
 * @author       Wumpus
 * @version      1.0
 */


final class Mysql
{
    private $db_host;  //数据库主机
    private $db_user;   //数据库用户名
    private $db_password;   //数据库用户名
    private $db_database;   //数据库名
    private $coding;    //数据库编码 GBK UTF8  gb2312
    private $dbc;  //数据库连接量
    
    private $record_error = true;   //是否开启错误记录
    private $show_error = true; //测试节点，显示所有错误，具有安全隐患，默认关闭
    private $end_error = false; //发现错误就终止,默认true 简易不起用，否则用户无法看见
    
    
    /**
        初始化
    */
    public function init($db_host,$db_user,$db_password,$db_database,$coding='utf8')//$conn,$coding)
    {
        
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_password = $db_password;
        $this->db_database = $db_database;
        $this->coding = $coding;
        $this->connect();
    }
    
    
    public function __destruct()
    {
        if($this->dbc)
        {
            $this->dbc = null;
        }
    }
    
    /**
     数据库连接
     */
    public function connect()
    {
        
        try
        {
            $this->dbc = new PDO(
                "mysql:host=$this->db_host;dbname=$this->db_database;port=3306;charset=$this->coding",
                $this->db_user,
                $this->db_password,
                array(PDO::ATTR_PERSISTENT => true)
            );
        }
        catch(PDOException $e)
        {
            $this->showError('数据库不可用:',$this->db_database);   
        }
    //    $this->execute('SET NAMES UTF8',array());
    }
    
    
    private function filterText($str)
    {
        $safeString = filter_var(
            $str,
            FILTER_SANITIZE_STRING,
            FILTER_FLAG_STRIP_LOW|FILTER_FLAG_ENCODE_HIGH
        );
        return $safeString;
    }
    
    private function bindValue($statement,$arr)
    {
        foreach($arr as $key => $value)
        {
            $key = ':' . $key;
            if(is_numeric($value) && $value === intval($value))
            {
                $statement->bindValue($key,$value,PDO::PARAM_INT);
            }
            else
            {
           //     $value = $this->filterText($value);
                $statement->bindValue($key,$value);
            }
        }
        return $statement;
    }
    
    /**
     * 数据库查询
     * @access      public
     * @param       string  $sql    数据库查询语句
     * @return      array(array())  全部结果数组
     */
    public function query($sql,$arr)
    {
        if($sql == '')
        {
            $this->showError('SQL语句错误: ','SQL查询语句为空');
        }
        
        
        $statement = $this->dbc->prepare($sql);
        $statement = $this->bindValue($statement,$arr);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    /**
     * 数据库执行
     */
    public function execute($sql,$arr)
    {
        if($sql == '')
        {
            $this->showError('SQL语句错误: ','SQL查询语句为空');
        }
        $statement = $this->dbc->prepare($sql);
        $statement = $this->bindValue($statement,$arr);
        $statement->execute();
    }
    
    /**
     * 数据库获取查询个数
     */
    public function getNum($sql,$arr)
    {
        if($sql == '')
        {
            $this->showError('SQL语句错误: ','SQL查询语句为空');
        }
        $statement = $this->dbc->prepare($sql);
        $statement = $this->bindValue($statement,$arr);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return intval($result[0]['cnt']);
        
    }
    
    
    /**
     * 获取用户IP
     */
    public function getIp()
    {
        if(getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown"))
        {
            $ip = getenv("HTTP_CLIENT_IP");
        }
        else
        {
            if(getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown"))
            {
                $ip = getenv("HTTP_CLIENT_IP");
            }
            else
            {
                if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
                {
					$ip = getenv("REMOTE_ADDR");
				} 
                else
					if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
                    {
						$ip = $_SERVER['REMOTE_ADDR'];
					} 
                    else 
                    {
						$ip = "unknown";
					}
                
            }
        }
        return $ip;
    }

    
    
    /**
     * 返回result中行数
     * @access      public
     * @return      int
     */
    
    
    
    
    public function showError($message='',$sql='')
    {
        if(!$this->show_error) return;
        
        if(!$sql)
        {
            echo '<p style="color:red">' . $message . '</p>';
            echo '<br />';
        }
        else
        {   
            echo '<p style="color:red">错误原因' . mysqli_error() . '</p>';
            echo '<p style="color:red">错误原因' . $message .'  ' . $sql . '</p>';

            if($this->record_error)
            {
                $time = date('Y-m-d H:i:s');
                $message = $message . "\r\n$this->sql" . "\r\n客户IP: $ip" . "\r\n时间: $time" . "\r\n\r\n";
                
                $server_date = date("Y-m-d");
                $filename = $server_date . "_SQL.txt";
                $file_path = ROOT_PATH . "/error/" . $filename;
                $error_content = $message;
                $file = ROOT_PATH . "/error";
                
                if(!file_exists($file))
                {
                    if(!mkdir($file,0777))
                    {
                        die("创建日志目录失败!");
                    }
                }
                
                if(!file_exists($file_path)) //日志文件不存在 
                {
                    fopen($file_path."w+"); //建立日期文件
                }
                    
                if(is_writable($file_path)) //确认文件可写
                {
                    if(!$handle = fopen($file_path,'a'))
                    {
                        die("不能打开文件 : $filename");
                    }
                    if(!fwrite($handle,$error_content))
                    {
                        die("不能写入文件 : $filename");

                    }
                    fclose($handle);
                }
                else 
                {
                    die("文件$filename不可写");
                }
                
            }
            
            if($this->end_error)
            {
                exit();
            }
        }
    }
    
}
<?php
/**
 * 核心模型类
 * @copyright    Copyright(c) 2015
 * @author       Wumpus
 * @version      1.0
 */

class Model
{
    protected $db = null;
    
    public function __construct()
    {
        header('Content-type:text/html;charset=utf-8');
        $this->db = $this->load('mysql');
        $config_db = $this->config('db');
        $this->db->init(
            $config_db['db_host'],
            $config_db['db_user'],
            $config_db['db_password'],
            $config_db['db_database'],
           // $config_db['db_conn'],
            $config_db['db_charset']
        );
    }
    
    /**
     * 加载类库
     * @access      final   protected
     * @param       string  $lib    类库名称
     * @return      object
     */
    
    /**
     * 开始会话，读入COOKIE
     * @access     final protected
     */
    final public function startSession()
    {
        session_start();
        if(!isset($_SESSION['user_id']))
        {
            if(isset($_COOKIE['hashstr']))
            {
                $hashstr = $_COOKIE['hashstr'];
                $data = $this->db->query("SELECT * FROM oj_user
                    WHERE hashstr='$hashstr'");
                if(count($data))
                {
                    $_SESSION['user_id'] = $data[0]['user_id'];
                    $_SESSION['username'] = $data[0]['username'];
            
                }
            }
        }    
    }
    
    
    /**
     * 登出
     × @access      final public
     */
    final public function logOut()
    {
        if(isset($_SESSION['user_id']) || isset($_SESSION['username']))
        {
            
            $_SESSION = array();
            if(isset($_COOKIE[session_name()]))
                setcookie(session_name(),'',time()-3600);
            session_destroy();
        }
        
        setcookie('hashstr','a',time()-3600);
        $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/index.php';
        header('Location: '. $home_url);
    }
    
    final protected function load($lib)
    {
        if(empty($lib))
        {
            trigger_error('加载类库名不能为空');
        }
        else if(array_key_exists($lib,Application::$_lib))
        {
            return Application::$_lib[$lib];
        }
        else
        {
            return Application::newLib($lib);
        }
    }
    
    /**
     * 加载系统配置, 默认为$CONFIG['system'][$config]
     * @access      final   protected
     * @param       string  $config 配置名
     */
    final protected function config($config)
    {
        return Application::$_config[$config];
    }
    
    
    /**
     * 组合表前缀获得表名
     * @access      final   protected
     * @param       string  $table_name 表名
     */
    final protected function table($table_name)
    {
        $config_db = $this->config('db');
        return $config_db['db_table_prefix'].$table_name;
    }
    
    
}
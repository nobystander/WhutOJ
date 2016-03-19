<?php
/**
 * 核心控制器
 * @copyright    Copyright(c) 2015
 * @author       Wumpus
 * @version      1.0
 */

class Controller
{
    protected $M = null;
    public function __construct($name = 'Controller')
    {
        
        if(substr($name,0,-10) != '')
               $this->M = $this->model(substr($name,0,-10));
        $this->M->startSession();
    }
    
    /**
     * 实例化模型
     * @access      final   protected
     * @param       string  $model  模型名称
     */
    final protected function model($model)
    {
        if(empty($model))
        {
            trigger_error('不能实例化空模型');
        }
        $model_name = $model . 'Model';
        return new $model_name;
    }
    
    /**
     * 加载类库
     * @access      final   protected
     * @param       string  $lib    类库名称
     * @return      object
     */
    final protected function load($lib)
    {
        if(empty($lib))
        {
            trigger_error('加载类库名不能为空');
        }
        elseif(array_key_exists($lib,Application::$_lib))
        {
            return Application::$_lib[$lib];
        }
        else
        {
            return Application::newLib($lib);
        }
    }
    
    final public function logOut()
    {
        $this->M->logOut();
    }
    
    
    
    /**
     * 未登录权限控制
     */
    final protected function needLogin()
    {
        if(!isset($_SESSION['user_id']))
        {
            echo '<div class="row">';
            echo '<div class="alert alert-danger" style="text-align:center" role="alert">';
            echo 'Please log in to access this page';
            echo '</div>';
            exit();
        }
    }
    
    final protected function checkLogin($user_id)
    {
        if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $user_id  )
        {
            echo '<div class="row">';
            echo '<div class="alert alert-danger" style="text-align:center" role="alert">';
            echo 'Do not have access to access this page';
            echo '</div>';
            exit();
        }
    }
    
    /**
     * 检查route传入controller的参数
     * @access      final   protected
     * @param       array   $arr    
                    array   $need   如果need['a'] = 1表示$arr['a']为整数
     */
    final protected function checkParam($arr,$need)
    {
        $flag = true;
        foreach($need as $key=>$value)
        {
            if(!isset($arr[$key]))
            {
                $flag = false;
                break;
            }
            if($need[$key] && !is_numeric($arr[$key]))
            {
                $flag = false;
                break;
            }
        }
        if(!$flag)
        {
            echo '<div class="row">';
            echo '<div class="alert alert-danger" style="text-align:center" role="alert">';
            echo 'Wrong Param';
            echo '</div>';
            exit();
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
     * 加载模板文件
     * @access      final   protected
     * @param       string  $path   模板路径
     * @param       array   $data   模板参数
     */
    final protected function showTemplate($path,$data = array())
    {
        $template = $this->load('template');
        $template->init($path,$data);
        $template->outPut();
    }
    
    /**
     * @access      final   protected
     * @param       array   $arr    js文件名
     */
    final protected function convertScript($arr)
    {
        $str = '';
        for($i = 0;$i < count($arr);$i++)
        {
            $str .= '<script type="text/javascript" src="view/js/'. $arr[$i] . '.js?random='.rand() . '"></script>';
            if($i)
                $str .= '\n';
        }
        return $str;
    }
    
    final protected function convertCss($arr)
    {
        
        $str = '';
        for($i = 0;$i < count($arr);$i++)
        {
            $str .= '<link type="text/css" rel="stylesheet" href="view/css/'. $arr[$i] . '.css?random='.rand() . '"/>';
            if($i)
                $str .= '\n';
        }
        return $str;
    }
    

}

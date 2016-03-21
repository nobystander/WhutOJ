<?php
/**
 * 应用驱动类
 * @copyright    Copyright(c) 2015
 * @author       Wumpus
 * @version      1.0
 */

define('SYSTEM_PATH',dirname(__FILE__));
define('ROOT_PATH',substr(SYSTEM_PATH,0,-7));
define('SYS_LIB_PATH',SYSTEM_PATH.'/lib');
define('APP_LIB_PATH',ROOT_PATH.'/lib');
define('SYS_CORE_PATH',SYSTEM_PATH.'/core');
define('CONTROLLER_PATH',ROOT_PATH.'/controller');
define('MODEL_PATH',ROOT_PATH.'/model');
define('VIEW_PATH',ROOT_PATH.'/view');
define('LOG_PATH',ROOT_PATH.'/error');
define('PROBLEM_PATH',ROOT_PATH.'/problem');
define('RUN_LOG_PATH',ROOT_PATH.'/runlog');


final class Application
{
    public static $_lib = null;
    public static $_config = null;
    
    
    /**
     * 创建应用
     * @access      public
     * @param       array   $config
     */
    public static function run($config)
    {
        self::$_config = $config['system'];
        self::init();
        self::loadDefaultLibs();
        self::initDefaultLibs();
        self::$_lib['route']->setUrlType(self::$_config['route']['url_type']);
        $url_array = self::$_lib['route']->getUrlArray();
        self::routeToCm($url_array);
    }
    
        
    /**
     * 初始化
     * @access      public
     */
    public static function init()
    {
        self::setDefaultLibs();
        require SYS_CORE_PATH.'/model.php';
        require SYS_CORE_PATH.'/controller.php';
    }
    
    /**
     * 引入默认类库
     * @access      public
     */
    public static function setDefaultLibs()
    {
        self::$_lib = array(
            'route'     =>      SYS_LIB_PATH.'/lib_route.php',
            'mysql'     =>      SYS_LIB_PATH.'/lib_mysql.php',
            'template'     =>      SYS_LIB_PATH.'/lib_template.php',
            'standard'     =>      SYS_LIB_PATH.'/lib_standard.php',
            'mqsender'      =>      SYS_LIB_PATH.'/lib_mqsender.php',
            //'cache'     =>      SYS_LIB_PATH.'/lib_cache.php',
            //'thumbnail'     =>      SYS_LIB_PATH.'/lib_thumbnail.php',
        );
    }
    
    /**
     * 加载默认类库
     * @access      public
     */
    public static function loadDefaultLibs()
    {
        foreach(self::$_lib as $key => $value)
        {
            require (self::$_lib[$key]);
            $lib_class = ucfirst($key);
            self::$_lib[$key] = new $lib_class;
        }
    }
    
    
    public static function initDefaultLibs()
    {
    }
    
    
    /**
     * 加载类库
     * @access      public
     * @param       string $class_name 类库名称
     * @return      object
     */
    public static function newLib($class_name)
    {
        $app_lib = $sys_lib = '';
        $app_lib = APP_LIB_PATH.'/'.self::$_config['lib']['prefix'].'_'.$class_name.'.php';
        $sys_lib = SYS_LIB_PATH.'/lib_'.$class_name.'.php';
        if(file_exists($app_lib))
        {
            require($app_lib);
            $class_name = ucfirst(self::$_config['lib']['prefix']).ucfirst($class_name);
            return new $class_name;
        }
        else if(file_exists($sys_lib))
        {
            require($sys_lib);
            return self::$_lib['$class_name'] = new $class_name;
        }
        else
        {
            trigger_error('加载'.$class_name.'类库不存在');
        }
    }
    
    /**
     * 根据URL分发到Cotroller和Model
     * @access      public
     * @param       array $url_array
     */
    public static function routeToCm($url_array = array())
    {
        $app = '';
        $controller = '';
        $action = '';
        $model = '';
        $params = '';
        
        if(isset($url_array['app']))
        {
            $app = $url_array['app'];
        }
        if(isset($url_array['controller']))
        {
            $controller = $model = $url_array['controller'];
            if($app)
            {
                $controller_file = CONTROLLER_PATH.'/'.$app.'/'.$controller.'Controller.php';
                $model_file = MODEL_PATH.'/'.$app.'/'.$model.'Model.php';
            }
            else
            {
                $controller_file = CONTROLLER_PATH.'/'.$controller.'Controller.php';
                $model_file = MODEL_PATH.'/'.$model.'Model.php';
            }
        }
        else
        {
            
            $controller = $model = self::$_config['route']['default_controller'];
            if($app)
            {
                $controller_file = CONTROLLER_PATH.'/'.$app.'/'.self::$_config['route']['default_controller'].'Controller.php';
                $model_file = MODEL_PATH.'/'.$app.'/'.self::$_config['route']['default_controller'].'Model.php';
            }
            else
            {
                $controller_file = CONTROLLER_PATH.'/'.self::$_config['route']['default_controller'].'Controller.php';
                $model_file = MODEL_PATH.'/'.self::$_config['route']['default_controller'].'Model.php';
            }
        }
                
        if(isset($url_array['action']))
        {
            $action = $url_array['action'];
        }
        else
        {
            $action = self::$_config['route']['default_action'];
        }
            
        if(isset($url_array['params']))
        {
            $params = $url_array['params'];
        }
        
        if(file_exists($controller_file))
        {
            if(file_exists($model_file))
            {
                require($model_file);
            }
            require $controller_file;
            $controller = $controller.'Controller';
            $controller = new $controller;
            if($action)
            {
                if(method_exists($controller,$action))
                {
                    isset($params)? $controller->$action($params): $controller->$action();
                }
                else
                {
                    die('控制器方法不存在');
                }
            }
            else
            {
                die('控制器方法不存在');
            }
            
        }
        else
        {
            die('控制器不存在');
        }
        
    }
    
}
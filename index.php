<?php
/**
 * 单入口文件
 * @copyright    Copyright(c) 2015
 * @author       Wumpus
 * @version      1.0
 */
require 'vendor/autoload.php';

require dirname(__FILE__). '/system/app.php';
require dirname(__FILE__). '/config/config.php';
Application::run($CONFIG); 

?>
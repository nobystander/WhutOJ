<?php
/**
 * Mysql 操作类
 * @copyright    Copyright(c) 2015
 * @author       Wumpus
 * @version      1.0
 */
define('ENCODE_KEY','bxqwmhfzjiygelngyvizphstadfwbnrqkxluvomc');//key必须包含全部26个字母
define('ENCODE_MAX_LEN',40);

use Respect\Validation\Validator as v;



final class Standard
{
    // warning!! If you change here , u need to change in header.js too
    private $setMinUserName = 8;
    private $setMaxUserName = 16;
    private $setMinPassword = 8;
    
    public function checkUsername($str)
    {
        $usernameValidator = v::alnum()->noWhitespace()->length($this->setMinUserName, $this->setMaxUserName);
        return $usernameValidator->validate($str); 
    }
    
    public function checkPassword($str)
    {
        $passwordValidator = v::length($this->setMinPassword);
        return $passwordValidator->validate($str);
    }
    
    public function checkEmail($str)
    {
        $emailValidator = v::email()->length(1,64);
        return $emailValidator->validate($str);
    }
    
    public function checkSchool($str)
    {
        $schoolValidator = v::alpha()->length(1,64);
        return $schoolValidator->validate($str);
    } 
    
    
    public function filterEmail($str)
    {
        $safeString = filter_var(
            $str,
            FILTER_SANITIZE_EMAIL
        );
        return $safeString;
        
    }
    public function filterText($str)
    {
        $safeString = filter_var(
            $str,
            FILTER_SANITIZE_STRING,
            FILTER_FLAG_STRIP_LOW|FILTER_FLAG_ENCODE_HIGH
        );
        return $safeString;
    }
    
    public function encodehtml($str)
    {
        $str =  htmlspecialchars($str);
        $str = str_replace(array("\r\n", "\n", "\r"), '<br/>', $str);
        return $str;
    }
    
    /**
     * 字符串加密(len <= 40)
     * *a*b[(a-'a')*10 + (b-'a')为加密数字]
     * 总加密为: 加密数字(len) . 加密数字(str[i]第一次在key中出现的下标)
     */
    final public function encode($str)
    {
        $len = strlen($str);
        $res = $this->calEncode($len);
        
                                                
        $buf = ENCODE_KEY;
        for($i = 0;$i < $len;$i++)
        {
            $res .= $this->calEncode($this->getIndexInStr($str[$i],$buf));
        }
        for($i = $len*4; $i < ENCODE_MAX_LEN;$i++)
            $res .= chr(rand(0,25) + ord('a'));

        return $res;
    }
    
    final public function decode($str)
    {
        $len = $this->calDecode(0,$str);
        $res = '';
        $buf = ENCODE_KEY;
        for($i = 1;$i <= $len;$i++)
        {
            $idx = $this->calDecode($i,$str);
            $res .= $buf[$idx];
        }
        return $res;
    }
    
    final private function calEncode($num) 
    {
        $a = floor($num / 10);
        $b = $num % 10;
        return chr(rand(0,7)*3+rand(1,2)+ord('a')).chr($a*3+ord('a')).chr(rand(0,7)*3+rand(1,2) +ord('a')).chr($b*3+ord('a'));
    }
    
    final private function getIndexInStr($c,$buf)
    {
        $t = strpos($buf,$c);
        return $t;
    }
    
    final private function calDecode($idx,$str)
    {
        $a = $str[$idx*4+1];
        $b = $str[$idx*4+3];
        return ((ord($a)-ord('a'))/3)*10 + ((ord($b)-ord('a')) /3);
    }
    
}


?>
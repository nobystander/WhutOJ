<?php

    function getFileId($filename)
    {
        $len = strlen($filename);
        $s = substr($filename,-3);
        if(is_numeric($s))
            return $s;
        else return '';
    }

    function generateHashDir($filedir)
    {
        $arr = array();
        $filenames = scandir($filedir);
       
        foreach($filenames as $key)
        {
            $t = getFileId($key);
            if($t)
                $arr[$t] = md5_file($filedir . '/' . $key);
        }
        return $arr;
    }

    function generateHashData($data_dir)
    {
        $input_hash = generateHashDir($data_dir . '/input');
        $output_hash = generateHashDir($data_dir . '/output');
        
        return array('input'=>$input_hash,'output'=>$output_hash);
        
    }
?>
<?php

class showcodeModel extends Model
{
    private $standard;
    public function __construct() 
    {
        parent::__construct();
        $this->standard = $this->load('standard');
	}
 

    private function readFile($run_id,$lang)
    {
        $path = CODE_PATH . '/' . $run_id . '.' . $lang;
        $myfile = fopen($path,'rb') or die('打开文件'. $path .'失败');
        $data = fread($myfile,filesize($path));
        fclose($myfile);
        return $data;
    }

	public function getLanguage($run_id)
	{
		return 'cpp';
	}

	public function getCode($run_id)
	{
		$lang = $this->getLanguage($run_id);
		$data = $this->readFile($run_id,$lang);
		return htmlspecialchars($data);
	}
}

?>

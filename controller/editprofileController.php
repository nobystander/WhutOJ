<?php
class editprofileController extends Controller 
{
        
        public function __construct() 
        {
            parent::__construct(__CLASS__);
        }

        public function index($arr) 
		{
			$data['page_title'] = $data['user_name'] = '1';
			$data['user_school'] = '1';
			$data['user_mail'] = '1';

			$this->showTemplate('editprofile',$data);
		}
}

?>

<?php
class viewprofileController extends Controller 
{
        
        public function __construct() 
        {
            parent::__construct(__CLASS__);
        }

        public function index($arr) 
		{
			$data['page_title'] = $data['username'] = $_SESSION['username'];
			$data['school'] = $this->M->getUserSchool($_SESSION['user_id']);
			$data['email'] = $this->M->getUserEmail($_SESSION['user_id']);
       	    $data['script'] = $this->convertScript(array('viewprofile'));
			$data['description']  = '22222222222222222222222222222222222222222222222222222222222222222222222222222222';
			$this->showTemplate('viewprofile',$data);
		}
}

?>


<?php

class viewprofileModel extends Model
{
    public function __construct() 
    {
        parent::__construct();
    }

	public function getUserSchool($id)
	{

        $data = $this->db->query('SELECT * FROM oj_user WHERE user_id=:user_id', array('user_id'=>$id));
        if(isset($data[0]['school']))
            return $data[0]['school'];
        else return '';
	}

	public function getUserEmail($id)
	{

        $data = $this->db->query('SELECT * FROM oj_user WHERE user_id=:user_id', array('user_id'=>$id));
        if(isset($data[0]['email']))
            return $data[0]['email'];
        else return '';
	}
}

?>

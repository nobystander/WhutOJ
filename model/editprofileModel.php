<?php

class editprofileModel extends Model
{
    public function __construct() 
    {
        parent::__construct();
    }

	public function getUserSchool($user_id)
	{

        $data = $this->db->query('SELECT * FROM oj_user WHERE user_id=:user_id', array('user_id'=>$user_id));
		return $data[0]['school'];
	}

	public function getUserEmail($user_id)
	{
        $data = $this->db->query('SELECT * FROM oj_user WHERE user_id=:user_id', array('user_id'=>$user_id));
		return $data[0]['email'];
	}
}

?>

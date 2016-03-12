<?php
class submitController extends Controller 
{
    public function __construct() 
    {
        parent::__construct(__CLASS__);
    }

    
    public function index()
    {
        echo $this->M->hello();
    }
}

?>
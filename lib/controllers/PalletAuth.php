<?php
class PalletAuth
{
    private $myPdo;
    private $data;

    public function __construct()
    {
        $this->myPdo = MyPdo::getInstance();
        $this->data = DataCont::getInstance();
    }

    public function index()
    {

    }
    public function adduser()
    {

    }
}
?>
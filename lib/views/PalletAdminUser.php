<?php
class PalletAdminUser implements iPallet
{
    private $myPdo;
    private $data;

    public function __construct()
    {
        $this->myPdo = MyPdo::getInstance();
        $this->data = DataCont::getInstance();
    }

    function index()
    {

    }
}
?>
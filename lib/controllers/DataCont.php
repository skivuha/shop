<?php
class DataCont
{
    private static $_instance;
    private $page;
    private $data;
    private $mArray;
    private $flag;
    private $param;
    private $user;


    public static function getInstance()
    {
        if(!(self::$_instance instanceof self))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct()
    {
        $this->mArray = array();
    }

    public function setPage($set_page)
    {
        $this->page = $set_page;
    }

    public function setData($set_data)
    {
        $this->data = $set_data;
    }

    public function setmArray($key, $val)
    {
        $this->mArray[$key] = $val;
    }

    public function setUser($val)
    {
        $this->user = $val;
    }

    public function setFlag($val)
    {
        $this->flag = $val;
    }

    public function setParam($val)
    {
        $this->param = $val;
    }

    public function getPage(){
        return $this->page;
    }

    public function getFlag(){
        return $this->flag;
    }

    public function getData(){
        return $this->data;
    }

    public function getmArray(){
        return $this->mArray;
    }

    public function getParam(){
        return $this->param;
    }

    public function getUser(){
        return $this->user;
    }
}
?>
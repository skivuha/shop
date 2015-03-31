<?php
class DataCont
{
    private static $_instance;
    private $page;
    private $data;
    private $mArray;


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

    public function getPage(){
        return $this->page;
    }

    public function getData(){
        return $this->data;
    }

    public function getmArray(){
        return $this->mArray;
    }
}
?>
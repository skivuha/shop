<?php
class Session
{
    static $_instance;
    private $error;

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct()
    {
        session_start();
        $this->error='';
    }

    public function setSession($key, $val)
    {
            $_SESSION[$key]=$val;
    }

    public function getSession($key)
    {
        if(isset($_SESSION[$key]))
        {
            return $_SESSION[$key];
        }
        else
        {
            return false;
        }
    }

    public function removeSession($key)
    {
        unset($_SESSION[$key]);
    }
}
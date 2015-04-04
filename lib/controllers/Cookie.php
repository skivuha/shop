<?php
class Cookie
{
    public function add($key, $val)
    {
        setcookie($key, $val, time()+3600*24*7, '/');
    }

    public function read($key)
    {
        return $_COOKIE[$key];
    }

    public function remove($key)
    {
        setcookie($key, '', -1,'/');
    }
}
?>
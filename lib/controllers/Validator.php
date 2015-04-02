<?php
class Validator
{
    private $value;

    public function __construct()
    {
    }

    public function clearData($data)
    {
        $data = trim(strip_tags($data));
        return $data;
    }

    public function clearDataArr(array $arr)
    {
        foreach($arr as $key=>$value)
        {
            $data[$key] = $this->clearData($value);
        }
        return $data;
    }

    public function checkForm($val)
    {
        $this->value = '';
        $val = $this->clearData($val);
        if(!preg_match("/^[a-zA-Z0-9]*$/", $val))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function checkPass($val)
    {
        $this->value = '';
        $val = $this->clearData($val);
        if(!preg_match("/^[a-z0-9_-]{6,18}$/", $val))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function checkEmail($val)
    {
        $this->value = '';
        $val = $this->clearData($val);
        if(!filter_var($val, FILTER_VALIDATE_EMAIL))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function getValue(){
        return $this->value;
    }

}
?>
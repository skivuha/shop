<?php
class RegestrationCntr
{
    private $fc;
    private $data;
    private $check;

    public function __construct()
    {
        $this->fc = FrontCntr::getInstance();
        $this->data = DataCont::getInstance();
        $this->check = new Validator();
        $this->data->setFlag($this->fc->getAction());
    }

    function indexAction()
    {
        $this->data->setPage('lib/views/regestration.html');
    }

    function adduserAction()
    {
        if(isset($_POST))
        {
            $data_post = $this->check->clearDataArr($_POST);
            if('' === $data_post['password'])
            {
                $this->data->setmArray('ERROR_PASS', 'Field is empty');
                $pass = false;
            }
            else
            {
                if( false === $this->check->checkPass($data_post['password']))
                {
                    $this->data->setmArray('ERROR_PASS', 'Wrong data');
                    $pass = false;
                }
                else
                {
                    $pass = $data_post['password'];
                }
            }
            if('' === $data_post['username'])
            {
                $this->data->setmArray('ERROR_NAME', 'Field is empty');
                $name = false;
            }
            else
            {
                if( false === $this->check->checkForm($data_post['username']))
                {
                    $this->data->setmArray('ERROR_NAME', 'Wrong data');
                    $name = false;
                }
                else
                {
                    $name = $data_post['username'];
                }
            }
        }
        $this->data->setPage('lib/views/regestration.html');
        if (false !== $name && false !== $pass)
        {
            //запрос в базу на проверку есть ли такой логин


        }
    }



    public function indexAction1()
    {
        $data = DataCont::getInstance();
        $check = new Validator();
        //$check->checkForm($_POST['user']);
        $data_post = $check->clearDataArr($_POST);
        if('' === $data_post['password'])
        {
            $data->setmArray('ERROR_PASS', 'Field is empty');
            $pass = false;
        }
        else
        {
            if( false === $check->checkPass($data_post['password']))
            {
                $data->setmArray('ERROR_PASS', 'Wrong data');
                $pass = false;
            }
            else
            {
                $pass = $data_post['password'];
            }
        }

        if('' === $data_post['user'])
        {
            $data->setmArray('ERROR_NAME', 'Field is empty');
            $name = false;
        }
        else
        {
            if( false === $check->checkForm($data_post['user']))
            {
                $data->setmArray('ERROR_NAME', 'Wrong data');
                $name = false;
            }
            else
            {
                $name = $data_post['user'];
            }
        }


        //$data->setmArray('error_name', $check->getErrors());
        //$name = $check->getValue();
        //$check->checkPass($_POST['password']);
        //$data->setmArray('error_pass', $check->getErrors());
        //$pass = $check->getValue();
        $data->setmArray('TITLE', 'Booker');
        $data->setPage('lib/views/main.html');
        if (false !== $name && false !== $pass)
        {
            //$link = new MyPdo();
            //$name = $link->checkUser($name);
            if (false === $name)
            {
                $data->setmArray('ERROR_FORM', 'Wrong name or password');
            }
            else
            {
                $pass=md5($name['key_user'].$pass);
                if ( $name['passwd_user'] == $pass)
                {
                    $_SESSION['user_id'] = $name['id_user'];
                    $_SESSION['login_user'] = $name['login_user'];
                    /*             if (isset($save_me)) and 'yes' == $save_me)
                                 {
                                     $cookie_code = generateCode;

                                 }*/
                    //    $sess = Session::getInstance();
                    //     $b = $sess->setSession($name, md5('lalala'));
                    //    $a = $sess->getSession($name);
                    //var_dump($_SESSION);
                    $data->setPage('lib/views/calendar.html');
                }
                else
                {
                    $data->setmArray('%ERROR_FORM%', 'Wrong name or password');
                }
            }
        }
    }
}
?>
<?php
class RegestrationCntr
{
    private $fc;
    private $data;
    private $check;
    private $myPdo;
    private $encode;

    public function __construct()
    {
        $this->fc = FrontCntr::getInstance();
        $this->myPdo = MyPdo::getInstance();
        $this->data = DataCont::getInstance();
        $this->encode = new Encode();
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

            if('' === $data_post['email'])
            {
                $this->data->setmArray('ERROR_EMAIL', 'Field is empty');
                $email = false;
            }
            else
            {
                if( false === $this->check->checkEmail($data_post['email']))
                {
                    $this->data->setmArray('ERROR_EMAIL', 'Wrong data');
                    $email = false;
                }
                else
                {
                    $email = $data_post['email'];
                }
            }
            $this->data->setPage('lib/views/regestration.html');
        if (false !== $name && false !== $pass && false !== $email)
        {
            $arr = $this->myPdo->select('login_user')
                ->table('shop_users')
                ->where(array('mail_user'=>$email))
                ->query()
                ->commit();
            if(!empty($arr))
            {
                $this->data->setmArray('ERROR_NAME', 'E-mail already exists');
                return false;
            }
            else
            {
                $key_user = $this->encode->generateCode($name);
                $pass = md5($key_user.$pass.SALT);
                $arr = $this->myPdo->insert()
                    ->table("shop_users SET login_user = '$name', password_user = '$pass', mail_user = '$email', key_user = '$key_user'")
                    ->query()
                    ->commit();
               if($arr)
               {
                   header("Location: /");
                   return true;
               }
                else
                {
                    $this->data->setmArray('STATUS', 'An error occurred while registering a new user. Contact the Administration.');
                    return false;
                }
            }
        }
        }

    }

/*        if (false !== $name && false !== $pass)
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
              /*      $data->setPage('lib/views/calendar.html');
                }
                else
                {
                    $data->setmArray('%ERROR_FORM%', 'Wrong name or password');
                }
            }
        }
    }*/
}
?>
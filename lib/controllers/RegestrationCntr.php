<?php
class RegestrationCntr implements iController
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
        $this->session = Session::getInstance();
        $this->cookie = new Cookie();
    }

    function indexAction()
    {
        $this->data->setPage('templates/regestration.html');
    }

    function logoutAction()
    {
        session_destroy();
        $this->data->setUser(false);
        $this->cookie->remove('code_user');
        header("Location: /~user2/PHP/shop/");
    }

    function logonAction()
    {
        $this->data->setUser(false);
        $this->data->setPage('templates/regestration.html');
        if (isset($_POST['signin'])) {
            $data_post = $this->check->clearDataArr($_POST);
            if ('' === $data_post['password']) {
                $this->data->setmArray('ERRORLOGIN', 'Field is empty');
                $pass = false;
            } else {
                if (false === $this->check->checkPass($data_post['password'])) {
                    $this->data->setmArray('ERRORLOGIN', 'Wrong data');
                    $pass = false;
                } else {
                    $pass = $data_post['password'];
                }
            }

            if ('' === $data_post['email']) {
                $this->data->setmArray('ERRORLOGIN', 'Field is empty');
                $email = false;
            } else {
                if (false === $this->check->checkEmail($data_post['email'])) {
                    $this->data->setmArray('ERRORLOGIN', 'Wrong data');
                    $email = false;
                } else {
                    $email = $data_post['email'];
                }
            }

            if (false !== $pass && false !== $email) {
                $arr = $this->myPdo->select('id_user, mail_user, password_user, key_user, login_user')->table('shop_users')->where(array('mail_user' => $email))->query()->commit();
                if (empty($arr)) {
                    $this->data->setmArray('ERRORLOGIN', 'Wrong e-mail or password');
                    //return false;
                }
                else
                {
                    $password = md5($arr[0]['key_user'].$pass.SALT);
                    if($arr[0]['password_user'] === $password)
                    {
                        $this->session->setSession('id_user',$arr[0]['id_user']);
                        $this->session->setSession('mail_user',$arr[0]['mail_user']);
                        $this->session->setSession('login_user',$arr[0]['login_user']);

                        if(isset($data_post['remember']) && 'on' === $data_post['remember'])
                        {
                            $encode = new Encode();
                            $code_user = $encode->generateCode($arr[0]['mail_user']);
                            $this->myPdo->update()
                                ->table("shop_users SET code_user = '$code_user' where mail_user = '$email'")
                                ->query()
                                ->commit();
                            $this->cookie->add('code_user', $code_user);
                        }
                        $this->data->setUser(true);
                        header('Location: /~user2/PHP/shop/');
                    }
                    else
                    {
                        $this->data->setmArray('ERRORLOGIN', 'Wrong e-mail or password');
                        //return false;
                    }
                }
            }
        }
    }

    function adduserAction()
    {

        if(isset($_POST['regNew']))
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
            $this->data->setPage('templates/regestration.html');
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
                   header("Location: /~user2/PHP/shop/Regestration/logon/");
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
        $this->data->setPage('templates/regestration.html');
    }
}
?>

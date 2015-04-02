<?php
class HomeCntr
{
    private $fc;
    private $data;
    private $check;
    private $myPdo;
    private $session;
    private $cookie;

    public function __construct()
    {
            $this->fc = FrontCntr::getInstance();
            $this->data = DataCont::getInstance();
            $this->data->setFlag($this->fc->getAction());
            $this->check = new Validator();
            $this->myPdo = MyPdo::getInstance();
            $this->session = Session::getInstance();
            $this->cookie = new Cookie();
    }

    function indexAction()
    {
        if($_POST)
        {
            $this->logon();
        }
        else
        {
        $params = $this->fc->getParams();
        $this->data->setParam($params);
        $this->data->setPage('lib/views/main.html');
        }
    }

    function sortAction()
    {
        $params = $this->fc->getParams();
        $this->data->setParam($params);
        $this->data->setPage('lib/views/main.html');
    }

    function authorsAction()
    {
        $this->data->setPage('lib/views/main.html');
    }

    function genresAction()
    {
        $this->data->setPage('lib/views/main.html');
    }

    function detailsAction()
    {
        $params = $this->fc->getParams();
        $book_id = abs((int)$params['id']); //validator
        $this->data->setPage('lib/views/main.html');
        $this->data->setParam($book_id);
    }

    function logoutAction()
    {
        $this->session->removeSession('id_user');
        $this->session->removeSession('mail_user');
        $this->session->removeSession('login_user');
        //setcookie("code_user", '', time()-3600);
        $this->cookie->remove('code_user');
        $params = $this->fc->getParams();
        $this->data->setParam($params);
        $this->data->setPage('lib/views/main.html');
    }

    function logon()
    {
        $this->data->setUser(false);
        $this->data->setPage('lib/views/main.html');
        if (isset($_POST)) {
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
                        $this->data->setPage('lib/views/main.html');
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
}
?>

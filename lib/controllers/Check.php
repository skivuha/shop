<?php
class Check
{
    private $data;
    //private $fc;
    private $valid;
    private $cookie;
    private $session;
    private $myPdo;

    public function __construct()
    {
        //$this->fc = FrontCntr::getInstance();
        $this->data = DataCont::getInstance();
        $this->valid = new Validator();
        $this->cookie = new Cookie();
        $this->session = Session::getInstance();
        $this->myPdo = MyPdo::getInstance();
        $this->check();
    }

    private function check()
    {

        if (isset($_SESSION['id_user']) && isset($_SESSION['login_user']) && isset($_SESSION['mail_user']))
        {
            $this->data->setUser(true);
        }
        else
        {
            if (isset($_COOKIE['code_user']))
            {
                $code_user=$this->valid->clearData($_COOKIE['code_user']);
                $arr = $this->myPdo->select('id_user, mail_user, password_user, key_user, login_user')->table('shop_users')->where(array('code_user' => $code_user))->query()->commit();
                if(!empty($arr))
                {
                    $this->session->setSession('id_user',$arr[0]['id_user']);
                    $this->session->setSession('mail_user',$arr[0]['mail_user']);
                    $this->session->setSession('login_user',$arr[0]['login_user']);
                    $this->cookie->add("code_user", $code_user);
                    $this->data->setUser(true);
                }
                else
                {
                    $this->data->setUser(false);
                    $this->cookie->remove('code_user');
                }
            }
            else
            {
                $this->data->setUser(false);
                $this->cookie->remove('code_user');
            }
        }
    }
}
?>
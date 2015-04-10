<?php
class PalletLogon implements iPallet
{
    private $data;
    private $check;
    private $encode;
    private $query;
    private $error;
    private $subs;


    public function __construct()
    {
        $this->data = DataCont::getInstance();
        $this->check = new Validator();
        $this->encode = new Encode();
        $this->cookie = new Cookie();
        $this->session = Session::getInstance();
        $this->query = new QueryToDb();
        $this->subs = new Substitution();
    }

    public function index()
    {
    }

    public function logon()
    {
        if (true === $this->data->getPost()) {
            $data_post = $this->check->clearDataArr($_POST);
            if ('' === $data_post['password']) {
                $this->error['ERRORLOGIN'] = 'Field is empty';
                $pass = false;
            }
            else {
                if (false === $this->check->checkPass($data_post['password'])) {
                    $this->error['ERRORLOGIN'] = 'Wrong data';
                    $pass = false;
                }
                else {
                    $pass = $data_post['password'];
                }
            }

            if ('' === $data_post['email']) {
                $this->error['ERRORLOGIN'] = 'Field is empty';
                $email = false;
            }
            else {
                if (false === $this->check->checkEmail($data_post['email'])) {
                    $this->error['ERRORLOGIN'] = 'Wrong data';
                    $email = false;
                }
                else {
                    $email = $data_post['email'];
                }
            }

            if (false !== $pass && false !== $email) {
                $arr = $this->query->getUser($email);
                if (empty($arr)) {
                    $this->error['ERRORLOGIN'] = 'Wrong e-mail or password';
                }
                else {
                    $password = md5($arr[0]['key_user'] . $pass . SALT);
                    if ($arr[0]['password_user'] === $password) {
                        $this->session->setSession('id_user', $arr[0]['id_user']);
                        $this->session->setSession('mail_user', $arr[0]['mail_user']);
                        $this->session->setSession('login_user', $arr[0]['login_user']);

                        if (isset($data_post['remember']) && 'on' === $data_post['remember']) {
                            $encode = new Encode();
                            $code_user = $encode->generateCode($arr[0]['mail_user']);
                            $this->query->setUser($code_user, $email);
                            $this->cookie->add('code_user', $code_user);
                        }
                        $this->data->setUser(true);
                        header('Location: /~user2/PHP/shop/');
                    }
                    else {
                        $this->error['ERRORLOGIN'] = 'Wrong e-mail or password';
                    }
                }
            }
        }
        if (empty($this->error)) {
            $this->error = array();
        }
        $data = $this->subs->templateRender('templates/logon.html', $this->error);

        return $data;
    }
}
?>

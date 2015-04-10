<?php
class PalletAdduser implements iPallet
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
    {}
    
    public function adduser()
    {
        if (true === $this->data->getPost()) {
            $data_post = $this->check->clearDataArr($_POST);
            if('' === $data_post['password'])
            {
                $this->error['ERROR_PASS'] = 'Field is empty';
                $pass = false;
            }
            else
            {
                if( false === $this->check->checkPass($data_post['password']))
                {
                    $this->error['ERROR_PASS'] = 'Wrong data';
                    $pass = false;
                }
                else
                {
                    $pass = $data_post['password'];
                }
            }

            if('' === $data_post['username'])
            {
                $this->error['ERROR_NAME'] = 'Field is empty';
                $name = false;
            }
            else
            {
                if( false === $this->check->checkForm($data_post['username']))
                {
                    $this->error['ERROR_NAME'] =  'Wrong data';
                    $name = false;
                }
                else
                {
                    $name = $data_post['username'];
                }
            }

            if('' === $data_post['email'])
            {
                $this->error['ERROR_EMAIL'] = 'Field is empty';
                $email = false;
            }
            else
            {
                if( false === $this->check->checkEmail($data_post['email']))
                {
                    $this->error['ERROR_EMAIL'] = 'Wrong data';
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
                $arr = $this->query->getLoginUser($email);
                if(!empty($arr))
                {
                    $this->error['ERROR_NAME'] = 'E-mail already exists';
                }
                else
                {
                    $key_user = $this->encode->generateCode($name);
                    $pass = md5($key_user.$pass.SALT);
                    $arr = $this->query->setUserToDb($name, $pass, $email, $key_user);
                    if($arr)
                    {
                        header('Location: '.PATH.'Regestration/logon/');
                    }
                    else
                    {
                        $this->error['STATUS'] = 'An error occurred while registering a new user. Contact the Administration.';
                    }
                }
            }
        }


if(empty($this->error)){
    $this->error=array();
}
        $data = $this->subs->templateRender('templates/adduser.html',$this->error);
        return $data;
    }

    function logout(){}

}
?>

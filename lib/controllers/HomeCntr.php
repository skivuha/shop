<?php
class HomeCntr
{
    private $fc;
    private $data;
    private $check;
    private $myPdo;

    public function __construct()
    {
            $this->fc = FrontCntr::getInstance();
            $this->data = DataCont::getInstance();
            $this->data->setFlag($this->fc->getAction());
            $this->check = new Validator();
            $this->myPdo = MyPdo::getInstance();
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
        $this->data->setUser(false);
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

    function logon()
    {
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
            $this->data->setPage('lib/views/main.html');
            $this->data->setUser(false);

            if (false !== $pass && false !== $email) {
                $arr = $this->myPdo->select('mail_user')->table('shop_users')->where(array('mail_user' => $email))->query()->commit();
                if (!empty($arr)) {
                    var_dump($arr);
                    $this->data->setmArray('ERRORLOGIN', 'Wrong name or password');
                    return false;
                }
            }
        }
    }
}
?>

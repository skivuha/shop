<?php
class RegestrationCntr implements iController
{
    private $fc;
    private $data;
    private $cookie;

    public function __construct()
    {
        $this->fc = FrontCntr::getInstance();
        $this->data = DataCont::getInstance();
        $this->data->setFlag($this->fc->getAction());
        $this->cookie = new Cookie();
    }

    function indexAction()
    {
        $this->data->setPage('templates/logon.html');
    }

    function logoutAction()
    {
        session_destroy();
        $this->data->setUser(false);
        $this->cookie->remove('code_user');
        header('Location: '.PATH.'');
    }

    function logonAction()
    {
        $this->data->setUser(false);
        $this->data->setPage('templates/logon.html');
        if (isset($_POST['signin'])) {
            $this->data->setPost(true);
        }
        else
        {
            $this->data->setPost(false);
        }
    }

    function adduserAction()
    {
        $this->data->setPage('templates/adduser.html');
        if (isset($_POST['regNew']))
        {
            $this->data->setPost(true);
        }
        else
        {
            $this->data->setPost(false);
        }
    }
}
?>

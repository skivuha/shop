<?php
class HomeCntr implements iController
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
        $params = $this->fc->getParams();
        $this->data->setParam($params);
        $this->data->setPage('lib/views/main.html');
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

    function addAction()
    {

        if(true === $this->data->getUser())
        {
            $params = $this->fc->getParams();
            $id = abs((int)($params['id']));
            $id_user = abs((int)($_SESSION['id_user']));
            $this->data->setIdUser($id_user);
            $this->data->setVal($id);
            $this->data->setPage('lib/views/main.html');
            header("Location: /");
        }
        else
        {
            header("Location: /Regestration/logon/");
        }

    }
}
?>

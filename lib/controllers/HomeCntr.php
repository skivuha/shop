<?php
class HomeCntr implements iController
{
    private $fc;
    private $data;
    private $check;
    private $session;

    public function __construct()
    {
            $this->fc = FrontCntr::getInstance();
            $this->data = DataCont::getInstance();
            $this->data->setFlag($this->fc->getAction());
            $this->check = new Validator();
            $this->session = Session::getInstance();
    }

    function indexAction()
    {
        $params = $this->fc->getParams();
        $this->data->setParam($params);
        $this->data->setPage('templates/main.html');
    }

    function sortAction()
    {
        $params = $this->fc->getParams();
        $this->data->setParam($params);
        $this->data->setPage('templates/main.html');
    }

    function authorsAction()
    {
        $this->data->setPage('templates/main.html');
    }

    function genresAction()
    {
        $this->data->setPage('templates/main.html');
    }

    function detailsAction()
    {
        $params = $this->fc->getParams();
        $book_id = abs((int)$params['id']); //validator
        $this->data->setPage('templates/main.html');
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
            $this->data->setPage('templates/main.html');
            header('Location: '.PATH.'');
        }
        else
        {
            header('Location: '.PATH.'Regestration/logon/');
        }
    }
}
?>

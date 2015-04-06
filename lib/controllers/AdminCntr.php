<?php
class AdminCntr implements iController
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
        $this->data->setPage('templates/admin/mainAdmin.html');
    }

    function detailsAction()
    {
        $params = $this->fc->getParams();
        $book_id = abs((int)$params['id']); //validator
        $this->data->setPage('templates/admin/mainAdmin.html');
        $this->data->setParam($book_id);
    }

    function deleteAction()
    {
        $params = $this->fc->getParams();
        $book_id = abs((int)$params['id']);
        $this->data->setPage('templates/admin/mainAdmin.html');
        $this->data->setParam($book_id);
    }

    function editgenreAction()
    {
        if(isset($_POST['name_genre']))
        {
            $clear_genre = $this->check->clearData($_POST['name_genre']);
            if(empty($clear_genre))
            {
                header('Location: /Admin/editgenre/');
            }
            else
            {
                $this->data->setParam($clear_genre);
            }
        }
        $this->data->setPage('templates/admin/mainAdmin.html');
    }

    function editauthorAction()
    {
        if(isset($_POST['name_author']))
        {
            $clear_author = $this->check->clearData($_POST['name_author']);
            if(empty($clear_author))
            {
                header('Location: /Admin/editauthor/');
            }
            else
            {
                $this->data->setParam($clear_author);
            }
        }
        $this->data->setPage('templates/admin/mainAdmin.html');
    }

    function genreDeleteAction()
    {
        $params = $this->fc->getParams();
        $genre_id = abs((int)$params['id']);
        $this->data->setPage('templates/admin/mainAdmin.html');
        $this->data->setParam($genre_id);
    }

    function authorDeleteAction()
    {
        $params = $this->fc->getParams();
        $id_author = abs((int)$params['id']);
        $this->data->setPage('templates/admin/mainAdmin.html');
        $this->data->setParam($id_author);
    }

    function genreEditAction()
    {
        $params = $this->fc->getParams();
        $book_id = abs((int)$params['id']);
        $this->data->setPage('templates/admin/mainAdmin.html');
        $this->data->setParam($book_id);
    }

    function authorEditAction()
    {
        $params = $this->fc->getParams();
        $book_id = abs((int)$params['id']);
        $this->data->setPage('templates/admin/mainAdmin.html');
        $this->data->setParam($book_id);
    }




}
?>
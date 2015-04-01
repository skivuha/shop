<?php
class HomeCntr
{
    private $fc;
    private $data;

    public function __construct()
    {
        $this->fc = FrontCntr::getInstance();
        $this->data = DataCont::getInstance();
        $this->data->setFlag($this->fc->getAction());
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
}
?>

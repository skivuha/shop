<?php
class AjaxCntr implements iController
{
    public function __construct()
    {
        $this->fc = FrontCntr::getInstance();
        $this->data = DataCont::getInstance();
        $this->data->setFlag($this->fc->getAction());
        $this->data->setCntr($this->fc->getCntr());
        $this->check = new Validator();
        $this->query = new QueryToDb();
        $this->session = Session::getInstance();
    }

    function addQuantityAction()
    {
        $params = $this->fc->getParams();
        $book_id = $this->check->numCheck($params['id']);
        $quantity = $this->check->numCheck($params['quantity']);
        $id_user = ($_SESSION['id_user']);
        $this->query->setQuantity($quantity, $id_user, $book_id);
    }

    function deleteAction()
    {
        $params = $this->fc->getParams();
        $id = $this->check->numCheck($params['id']);
        $this->query->deleteBookFromCart($id);
    }
    function indexAction()
    {
    }
}
?>
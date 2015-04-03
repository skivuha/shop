<?php
class CartCntr
{
    private $fc;
    private $data;

    public function __construct()
    {
        $this->fc = FrontCntr::getInstance();
        $this->data = DataCont::getInstance();
        $this->data->setFlag($this->fc->getAction());
        $this->valid();

    }

    function indexAction()
    {
        $params = abs((int)($_SESSION['id_user']));
        $this->data->setVal($params);
        $this->data->setPage('lib/views/cart.html');
    }

    function deleteAction()
    {
        $params = $this->fc->getParams();
        $id = abs((int)($params['id']));
        $this->data->setVal($id);
        $this->data->setPage('lib/views/cart.html');
        header("Location: /Cart/index/");
    }

    function valid()
    {
        if(false == $this->data->getUser())
        {
            header("Location: /");
        }
    }


}
?>
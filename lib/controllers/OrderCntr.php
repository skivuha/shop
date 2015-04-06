<?php
class OrderCntr implements iController
{
    public function __construct()
    {
        $this->fc = FrontCntr::getInstance();
        $this->data = DataCont::getInstance();
        $this->data->setFlag($this->fc->getAction());
        $this->myPdo = MyPdo::getInstance();
        $this->valid();
    }

    function indexAction()
    {
        $params = abs((int)($_SESSION['id_user']));
        $this->data->setVal($params);
        $this->data->setPage('lib/views/order.html');
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
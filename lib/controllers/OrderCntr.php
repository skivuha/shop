<?php
class OrderCntr implements iController
{
    public function __construct()
    {
        $this->data = DataCont::getInstance();
        $this->valid();
        $this->fc = FrontCntr::getInstance();
        $this->data->setFlag($this->fc->getAction());
    }

    function indexAction()
    {
        $params = abs((int)($_SESSION['id_user']));
        $this->data->setVal($params);
        $this->data->setPage('templates/order.html');
    }

    function valid()
    {
        if(false == $this->data->getUser())
        {
            header('Location: '.PATH.'Regestration/logon/');
        }
    }
}
?>

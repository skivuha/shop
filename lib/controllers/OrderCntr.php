<?php
class OrderCntr
{
    public function __construct()
    {
        $this->fc = FrontCntr::getInstance();
        $this->data = DataCont::getInstance();
        $this->data->setFlag($this->fc->getAction());
        $this->myPdo = MyPdo::getInstance();
    }

    function indexAction()
    {
        $this->data->setPage('lib/views/order.html');
    }
}
?>
<?php
class CheckoutCntr
{
    public function __construct()
    {
        $this->fc = FrontCntr::getInstance();
        $this->myPdo = MyPdo::getInstance();
        $this->data = DataCont::getInstance();
        $this->data->setFlag($this->fc->getAction());
    }

    function indexAction()
    {
        $params = abs((int)($_SESSION['id_user']));
        $this->data->setVal($params);
        $this->data->setPage('lib/views/checkout.html');
    }
}
?>
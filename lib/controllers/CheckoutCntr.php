<?php
class CheckoutCntr implements iController
{
    private $fc;
    private $myPdo;
    private $data;
    private $validator;

    public function __construct()
    {
        $this->fc = FrontCntr::getInstance();
        $this->myPdo = MyPdo::getInstance();
        $this->data = DataCont::getInstance();
        $this->data->setFlag($this->fc->getAction());
        $this->validator = new Validator();
    }

    function indexAction()
    {
        $params = abs((int)($_SESSION['id_user']));
        $this->data->setVal($params);
        $this->data->setPage('lib/views/checkout.html');
    }

    function confirmAction()
    {
        $radio = abs((int)($_POST['radio']));
        $params = abs((int)($_SESSION['id_user']));
        $this->data->setVal($params);
        $this->data->setPost($radio);
        if(0 === $radio)
        {
            $this->data->setmArray('ERROR', 'Choise payment method');
            $this->data->setPage('lib/views/checkout.html');
            $this->data->setFlag('indexAction');
            $this->data->setVal($params);
        }
        else
        {
            $params = abs((int)($_SESSION['id_user']));
            $this->data->setVal($params);
            $this->data->setPost($radio);
            $this->data->setPage('lib/views/checkout.html');
        }
    }
}
?>
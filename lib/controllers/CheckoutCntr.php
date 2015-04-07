<?php
class CheckoutCntr implements iController
{
    private $fc;
    private $myPdo;
    private $data;
    private $validator;

    public function __construct()
    {
        $this->data = DataCont::getInstance();
        $this->checkUser();
        $this->fc = FrontCntr::getInstance();
        $this->myPdo = MyPdo::getInstance();
        $this->data->setFlag($this->fc->getAction());
        $this->validator = new Validator();
    }

    function indexAction()
    {
        $params = abs((int)($_SESSION['id_user']));
        $this->data->setVal($params);
        $this->data->setPage('templates/checkout.html');
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
            $this->data->setPage('templates/checkout.html');
            $this->data->setFlag('indexAction');
            $this->data->setVal($params);
        }
        else
        {
            $params = abs((int)($_SESSION['id_user']));
            $this->data->setVal($params);
            $this->data->setPost($radio);
            $this->data->setPage('templates/checkout.html');
        }
    }

    private function checkUser()
    {
        if(false === $this->data->getUser())
        {
            header("Location: /~user2/PHP/shop/Regestration/logon/");
        }
    }
}
?>

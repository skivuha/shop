<?php
class CartCntr implements iController
{
    private $fc;
    private $data;
    private $myPdo;

    public function __construct()
    {
        $this->data = DataCont::getInstance();
        $this->checkUser();
        $this->fc = FrontCntr::getInstance();
        $this->data->setFlag($this->fc->getAction());
        $this->myPdo = MyPdo::getInstance();

    }

    function indexAction()
    {
        $params = abs((int)($_SESSION['id_user']));
        $this->data->setVal($params);
        $this->data->setPage('templates/cart.html');
    }

    function deleteAction()
    {
        $params = $this->fc->getParams();
        $id = abs((int)($params['id']));
        $this->data->setVal($id);
        $this->data->setPage('templates/cart.html');
        header('Location: '.PATH.'Cart/index/');
    }

    function buyAction()
    {
        $this->data->setPage('templates/cart.html');
    }


    function ajax()
    {
        $arr = $this->myPdo->select('book_id, book_name, img, price, visible')->table('shop_books')->where(array('visible' => 1))->limit(0, 1)->query()->commit();
        echo json_encode($arr);
    }

    private function checkUser()
    {
        if(false === $this->data->getUser())
        {
            header('Location: '.PATH.'Regestration/logon/');
        }
    }
}
?>

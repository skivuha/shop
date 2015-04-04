<?php
class CartCntr
{
    private $fc;
    private $data;
    private $myPdo;

    public function __construct()
    {
        $this->fc = FrontCntr::getInstance();
        $this->data = DataCont::getInstance();
        $this->data->setFlag($this->fc->getAction());
        $this->myPdo = MyPdo::getInstance();
        //$this->valid();

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

    function buyAction()
    {
        $this->data->setPage('lib/views/cart.html');
    }


    function ajax()
    {
        $arr = $this->myPdo->select('book_id, book_name, img, price, visible')->table('shop_books')->where(array('visible' => 1))->limit(0, 1)->query()->commit();
        echo json_encode($arr);
    }

}
?>
<?php
class AjaxCntr
{
    public function __construct()
    {
        $this->fc = FrontCntr::getInstance();
        $this->data = DataCont::getInstance();
        $this->data->setFlag($this->fc->getAction());
        $this->data->setCntr($this->fc->getCntr());
        $this->check = new Validator();
        $this->myPdo = MyPdo::getInstance();
        $this->session = Session::getInstance();
        $this->cookie = new Cookie();
    }

/*    function indexAction()
    {
        $arr = $this->myPdo->select('book_id, book_name, img, price, visible')->table('shop_books')->where(array('visible' => 1))->limit(0, 6)->query()->commit();

# JSON-encode the response
        $json_response = json_encode($arr);
        echo json_decode($json_response);
    }
*/
    function addQuantityAction()
    {
        $params = $this->fc->getParams();
        $book_id = abs((int)($params['id']));
        $quantity = abs((int)($params['quantity']));
        $id_user = abs((int)($_SESSION['id_user']));

        $this->myPdo->update()
            ->table("shop_cart SET quantity = '$quantity' where user_id = '$id_user' and book_id = '$book_id'")
            ->query()
            ->commit();
    }

    function deleteAction()
    {
        $params = $this->fc->getParams();
        $id = abs((int)($params['id']));
        $this->myPdo->delete()
            ->table("shop_cart where cart_id = '$id'")
            ->query()
            ->commit();
    }
}
?>
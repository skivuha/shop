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

    function indexAction()
    {
        $arr = $this->myPdo->select('book_id, book_name, img, price, visible')->table('shop_books')->where(array('visible' => 1))->limit(0, 6)->query()->commit();

# JSON-encode the response
        $json_response = json_encode($arr);
        echo json_decode($json_response);
    }

    function addQuantityAction()
    {
        $arr = $this->myPdo->update()
            ->table("shop_cart SET quantity = quantity + 1 where user_id = '15'")
            ->query()
            ->commit();
# JSON-encode the response
        $json_response = json_encode($arr);
        echo json_decode($json_response);
    }
}
?>
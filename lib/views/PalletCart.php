<?php
class PalletCart implements iPallet
{
    private $query;
    private $data;
    public $nav;
    private $session;
    private $cookie;
    private $cartarr;

    public function __construct()
    {
        $this->query = new QueryToDb();
        $this->data = DataCont::getInstance();
        $this->session = Session::getInstance();
        $this->cookie = new Cookie();
        $this->subs = new Substitution();
    }

    function index()
    {
        $id_user = $this->data->getVal();
        $arr = $this->query->getListBookForCart($id_user);
        $data = '';
            $cnt = 0;
            $total = 0;
            foreach ($arr as $key => $val) {
                $cnt ++;
                $total += $val['price'] * $val['quantity'];
                $this->cartarr['CNT'] = $cnt;
                $this->cartarr['BOOK_ID'] = $val['book_id'];
                $this->cartarr['BOOK_NAME'] = $val['book_name'];
                $this->cartarr['QUANTITY'] = $val['quantity'];
                $this->cartarr['CARD_ID'] = $val['cart_id'];
                $this->cartarr['PRICE'] = $val['price'] * $val['quantity'];
                $this->cartarr['LISTCHOISEBOOK'].= $this->subs->templateRender('templates/subtemplates/cartzakaz.html',$this->cartarr);
            }
                $this->cartarr['PRICE'] = $total;
            if (0 === $cnt) {
                $this->cartarr['DISABLE'] = 'disabled';
            } else {
                $this->cartarr['DISABLE'] = '';
            }

        $data = $this->subs->templateRender('templates/cart.html',$this->cartarr);
    return $data;
    }

    function delete()
    {
        $id_user = $this->data->getVal();
        $this->query->deleteFromCart($id_user);
    }
}
?>

<?php
class PalletCart implements iPallet
{
    private $query;
    private $data;
    public $nav;
    private $session;
    private $cookie;

    public function __construct()
    {
        $this->query = new QueryToDb();
        $this->data = DataCont::getInstance();
        $this->session = Session::getInstance();
        $this->cookie = new Cookie();
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
                $data .= '<tr><td>' . $cnt . '</td><td class="book_id" name="' . $val['book_id'] . '">' . $val['book_name'] . '</td><td><span class="down glyphicon glyphicon-menu-left"></span><span class="quantity">' . $val['quantity'] . '</span><span class="up glyphicon glyphicon-menu-right"></span></td><td class="price">' . $val['price'] * $val['quantity'] . '</td><td><span class="deleteFromCart" name="' . $val['cart_id'] . '">X</span></td></tr>';
            }
            $data .= '</table><hr><p id="totalPrice"><span>Total: <span  class="totalSum">' . $total . '</span> $</span><a href="'.PATH.'Checkout/index/">';
            if (0 === $cnt) {
                $data .= '<input type="submit" class="btn btn-default btn-xs" value="Buy" name="buyTooOrder" disabled />';
            } else {
                $data .= '<input type="submit" class="btn btn-default btn-xs" value="Buy" name="buyTooOrder" />';
            }
        $data.='</a></p>';
    return $data;
    }

    function delete()
    {
        $id_user = $this->data->getVal();
        $this->query->deleteFromCart($id_user);
    }
}
?>

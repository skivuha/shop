<?php
class PalletCart implements iPallet
{
    private $myPdo;
    private $data;
    public $nav;
    private $session;
    private $cookie;

    public function __construct()
    {
        $this->myPdo = MyPdo::getInstance();
        $this->data = DataCont::getInstance();
        $this->session = Session::getInstance();
        $this->cookie = new Cookie();
    }

    function index()
    {
        $id_user = $this->data->getVal();
        $valid = $this->data->getUser();
        $arr = array();
        if(false === $valid)
        {
            $cart_cookie = $this->cookie->read('cart');
            if(null != $cart_cookie)
            {
                $arr = unserialize($cart_cookie);

                $this->cookie->add('json', json_encode($arr));
            }
        }
        else
        {
            $arr = $this->myPdo->select('cart_id, quantity, book_name, price, shop_books.book_id')->table("shop_users, shop_books INNER JOIN shop_cart WHERE id_user = '$id_user' AND shop_books.book_id = shop_cart.book_id and shop_users.id_user = shop_cart.user_id and status = '0'")//->table("shop_users, shop_books INNER JOIN shop_cart")
                //->where(array("`shop_users.id_user`" => "`shop_cart.user_id`", "`shop_books.book_id`" => "`shop_cart.book_id`", 'user_id'=>$id_user))
                ->query()->commit();
//        SELECT * FROM `shop_users`, `shop_books` INNER JOIN `shop_cart` WHERE `id_user` = 15
//    AND shop_books.book_id = shop_cart.book_id and shop_users.id_user = shop_cart.user_id
        }
        $data = '<table class="table table-striped">
            <tr>
                <th>#</th>
                <th>Book name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Delete</th>
            </tr>';
            $cnt = 0;
            $total = 0;
            foreach ($arr as $key => $val) {
                $cnt ++;
                $total += $val['price'] * $val['quantity'];
                $data .= '<tr><td>' . $cnt . '</td><td class="book_id" name="' . $val['book_id'] . '">' . $val['book_name'] . '</td><td><span class="down glyphicon glyphicon-menu-left"></span><span class="quantity">' . $val['quantity'] . '</span><span class="up glyphicon glyphicon-menu-right"></span></td><td class="price">' . $val['price'] * $val['quantity'] . '</td><td><span class="deleteFromCart" name="' . $val['cart_id'] . '">X</span></td></tr>';
            }
            $data .= '</table><hr><p id="totalPrice"><span>Total: <span  class="totalSum">' . $total . '</span> $</span><a href="/~user2/PHP/shop/Checkout/index/">';
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
        $arr=$this->myPdo->delete()
        ->table("shop_cart where cart_id = '$id_user'")
        ->query()
        ->commit();
    }
}
?>

<?php
class PalletCheck
{
    private $myPdo;
    private $data;

    public function __construct()
    {
        $this->myPdo = MyPdo::getInstance();
        $this->data = DataCont::getInstance();
    }
        function index()
        {
            $id_user = $this->data->getVal();
            $arr = $this->myPdo->select('cart_id, quantity, book_name, price, shop_books.book_id, discount_user')
                ->table("shop_users, shop_books INNER JOIN shop_cart WHERE id_user = '$id_user' AND shop_books.book_id = shop_cart.book_id and shop_users.id_user = shop_cart.user_id and status = '0'")
                ->query()
                ->commit();

            $payment = $this->myPdo->select('payment_name, payment_id')
                ->table("shop_payment")
                ->query()
                ->commit();

            $data = '<table class="table table-striped">
            <tr>
                <th>#</th>
                <th>Book name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>';
            $cnt = 0;
            $total=0;
            $quantity = 0;
            foreach($arr as $key=>$val)
            {
                $cnt++;
                $total += $val['price']*$val['quantity'];
                $quantity += $val['quantity'];
                $data.='<tr><td>'.$cnt.'</td><td class="book_id" name="'.$val['book_id'].'">'.$val['book_name'].'</td><td><span class="quantity">'.$val['quantity'].'</span></td><td class="price">'.$val['price']*$val['quantity'].'</td></tr>';
            }
            $discount = ($total*$val['discount_user'])/(100);
            $your_price = $total-$discount;
            $data.='</table><hr><p id="totalPrice"><span> Quantity: '.$quantity.' </span><span>Total: <span  class="totalSum">'.$total.'</span> $ </span></p>
            <p>Taking into your discount: '.round($your_price).' $</p>';
            if( 0 === $cnt)
            {
                return false;
            }

                $data.=' <p> <select class="form-control">';
                     foreach($payment as $val)
                     {
                        $data.='<option>'.$val['payment_name'].'</option>';
                     }
                $data.='</select><a href="/Checkout/index/"><input type="submit" class="btn btn-default btn-xs" value="Confirm order" name="buyTooOrder" /></p></a>';


            return $data;
        }
}
?>
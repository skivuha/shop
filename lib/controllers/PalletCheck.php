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
            if(0 !== $val['discount_user'])
            {
                $discount = ($total * $val['discount_user']) / (100);
            }
            else
            {
                $discount = 0;
            }
            $your_price = $total-$discount;
            $data.='</table><hr><p id="totalPrice"><span> Quantity: '.$quantity.' </span><span>Total: <span  class="totalSum">'.$total.'</span> $ </span></p>
            <p>Taking into your discount: '.round($your_price).' $</p><p>%#%ERROR%#%</p>';
            if( 0 === $cnt)
            {
                return false;
            }
                $data.=' <form method="post" action="/Checkout/confirm/"><p>';
                     foreach($payment as $val)
                     {
                        $data.='<input type="radio" name="radio" required value="'.$val['payment_id'].'" />'.$val['payment_name'].'<br>';
                     }
                $data.='<input type="submit" class="btn btn-default btn-xs" value="Confirm order" name="buyTooOrder" /></p></form>';
            return $data;
        }
    function confirm()
    {
        $id_user = $this->data->getVal();
        $radio = $this->data->getPost();
        $arr = $this->myPdo->select('quantity, price, shop_books.book_id, discount_user')
            ->table("shop_users, shop_books INNER JOIN shop_cart WHERE id_user = '$id_user' AND shop_books.book_id = shop_cart.book_id and shop_users.id_user = shop_cart.user_id and status = '0'")
            ->query()
            ->commit();

        $count_payment = $this->myPdo->select('count(*)')
            ->table("shop_payment")
            ->query()
            ->commit();

        $total = 0;

        foreach($arr as $key=>$val)
        {
            $total += $val['price']*$val['quantity'];
        }

        if(0 >= $radio && $count_payment[0]['count(*)'] <= $radio)
        {
            $radio = 1;
        }

        if(0 !== $val['discount_user'])
        {
            $discount = ($total * $val['discount_user']) / (100);
        }
        else
        {
            $discount = 0;
        }
        $your_price = round($total-$discount);

        $this->myPdo->insert()
        ->table("shop_orders SET data_st = CURDATE(), id_user = '$id_user', total_price = '$your_price', id_payment = $radio")
        ->query()
        ->commit();

        $id_order = $this->myPdo->lastId;
        if(0 !== $id_order)
        {
            foreach($arr as $key=>$val)
            {
                $this->myPdo->insert()
                    ->table("shop_book_order SET id_book = '$val[book_id]', id_order = $id_order, quantity = '$val[quantity]'")
                    ->query()
                    ->commit();
            }
            $this->myPdo->update()
                ->table("shop_cart SET status = '1' where user_id = '$id_user'")
                ->query()
                ->commit();
            $data ='<div class="container well col-sm-4 col-sm-offset-4">';
            $data .='<p>Your order # '.$id_order.'</p>';
            $data .='<p>Total sum: '.$your_price.' $</p>';
            $data .='<p>Thank you for buying</p>';
            $data .='<br><a href="'.PATH.'/" class="btn btn-default">to main</a></div>';
            return $data;
        }
    }
}
?>
<?php
class PalletCheck implements iPallet
{
    private $query;
    private $data;

    public function __construct()
    {
        $this->query = new QueryToDb();
        $this->data = DataCont::getInstance();
    }
        function index()
        {
            $id_user = $this->data->getVal();
            $arr = $this->query->getListBookForCart($id_user);
            $payment = $this->query->getListPaymentForCheckout();
            $cnt = 0;
            $total=0;
            $quantity = 0;
            $data='';
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
                $data.=' <form method="post" action="'.PATH.'Checkout/confirm/"><p>';
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
        $arr = $this->query->getListBookForCart($id_user);
        $count_payment = $this->query->getCountBuyingBook();

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

        $this->query->setBuyingBook($id_user, $your_price, $radio);

        $id_order = $this->query->getLastId();

        if(0 !== $id_order)
        {
            foreach($arr as $key=>$val)
            {
                $id_book = $val['book_id'];
                $quantity = $val['quantity'];
                $this->query->setOrder($id_book, $quantity, $id_order);
            }

            $this->query->setStatusBookInCart($id_user);
            $data['IDORDER'] =  $id_order;
            return $data; 
        }
    }
}
?>

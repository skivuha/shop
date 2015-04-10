<?php
class PalletCheck implements iPallet
{
    private $query;
    private $data;
    private $subs;
    private $cartarr;

    public function __construct()
    {
        $this->query = new QueryToDb();
        $this->subs = new Substitution();
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
                $cnt ++;
                $total += $val['price'] * $val['quantity'];
                $quantity += $val['quantity'];
                $this->cartarr['CNT'] = $cnt;
                $this->cartarr['BOOK_ID'] = $val['book_id'];
                $this->cartarr['BOOK_NAME'] = $val['book_name'];
                $this->cartarr['QUANTITY'] = $val['quantity'];
                $this->cartarr['PRICE'] = $val['price'] * $val['quantity'];
                $this->cartarr['TABLE'] .= $this->subs->templateRender('templates/subtemplates/checktable.html', $this->cartarr);
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

            $this->cartarr['ALLQUANTITY'] = $quantity;
            $this->cartarr['TOTAL'] = $total;
            $this->cartarr['YOUPRICE'] = round($your_price);
            $this->cartarr['FUTER'] = $this->subs->templateRender('templates/subtemplates/checktotal.html', $this->cartarr);
            if( 0 === $cnt)
            {
                return false;
            }

                     foreach($payment as $val)
                     {
                         $this->cartarr['PAYMENTID'] = $val['payment_id'];
                         $this->cartarr['PAYMENTNAME'] = $val['payment_name'];
                         $this->cartarr['PAYMENT'] .= $this->subs->templateRender('templates/subtemplates/checkpayment.html', $this->cartarr);
                     }

            $data = $this->subs->templateRender('templates/checkout.html', $this->cartarr);
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
            $this->cartarr['IDORDER'] = $id_order;
            $this->cartarr['PRICE'] = $your_price;
            $data = $this->subs->templateRender('templates/confirm.html', $this->cartarr);
            return $data;
        }
    }
}
?>

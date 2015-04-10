<?php
class PalletConfirm implements iPallet
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
        return $this->confirm();
    }

    function confirm()
    {
        $id_user = $this->data->getVal();
        $radio = $this->data->getPost();
        $arr = $this->query->getListBookForCart($id_user);
        $count_payment = $this->query->getCountBuyingBook();

        $total = 0;

        foreach ($arr as $key => $val) {
            $total += $val['price'] * $val['quantity'];
        }

        if (0 >= $radio && $count_payment[0]['count(*)'] <= $radio) {
            $radio = 1;
        }

        if (0 !== $val['discount_user']) {
            $discount = ($total * $val['discount_user']) / (100);
        }
        else {
            $discount = 0;
        }
        $your_price = round($total - $discount);

        $this->query->setBuyingBook($id_user, $your_price, $radio);

        $id_order = $this->query->getLastId();

        if (0 !== $id_order) {
            foreach ($arr as $key => $val) {
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
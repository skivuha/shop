<?php
class PalletOrder implements iPallet
{
    private $data;
    private $query;
    private $orderarr;
    private $subs;

    public function __construct()
    {
        $this->data = DataCont::getInstance();
        $this->query = new QueryToDb();
        $this->subs = new Substitution();
    }

    function index()
    {
        $id_user = $this->data->getVal();
        $arr = $this->query->getListHeaderOrderForUser($id_user);
        $cnt=1;
        foreach($arr as $key=>$val) {
            $cnt_book = 1;
            $this->orderarr['CNT'] = $cnt;
            $this->orderarr['DATAST'] = $val['data_st'];
            $this->orderarr['TOTALPRICE'] = $val['total_price'];
            $this->orderarr['STATUS'] = $val['name_status'];

            $id_order = $val['id_order'];
            $book = $this->query->getListBodyOrderForUser($id_order);
            foreach($book as $value)
            {
                $this->orderarr['CNTBOOK'] = $cnt_book;
                $this->orderarr['BOOKNAME'] = $value['book_name'];
                $this->orderarr['QUANTITY'] = $value['quantity'];
                $this->orderarr['PRICE'] = $value['price']*$value['quantity'];
                $this->orderarr['ORDERBODY'] .= $this->subs->templateRender('templates/subtemplates/orderb.html',$this->orderarr);
                $cnt_book++;
            }
            $this->orderarr['ORDERLIST'] .= $this->subs->templateRender('templates/subtemplates/orderhead.html',$this->orderarr);
            $cnt ++;
        }
        $data = $this->subs->templateRender('templates/order.html',$this->orderarr);
        return $data;
    }
}
?>
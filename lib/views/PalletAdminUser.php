<?php
class PalletAdminUser implements iPallet
{
    private $query;
    private $data;
    private $bookarr;
    private $subs;

    public function __construct()
    {
        $this->query = new QueryToDb();
        $this->data = DataCont::getInstance();
        $this->subs = new Substitution();
    }

    function order()
    {
        if(true === $this->data->getPost())
        {
            $id_chenge_status = $this->data->getVal();
            foreach($id_chenge_status as $key=>$val)
            {
                if('save' == $val)
                {
                    $id = $key;
                }
            }
            $id_status = $id_chenge_status['sel'];
            if( isset($id_status) && isset($id) )
            {
                $this->query->setNewStatusOrder($id_status, $id);
            }
        }

        $arr = $this->query->getAllOrders();

        $cnt=1;

        $status = $this->query->getAllStatus();

            foreach($status as $stat)
            {
                $this->bookarr['STATUSID'] = $stat['id_status'];
                $this->bookarr['STATUSNAME'] = $stat['name_status'];
                $this->bookarr['STATUS'].=$this->subs->templateRender('templates/admin/orderstatus.html',$this->bookarr);
            }

            foreach($arr as $key=>$val) {
                $order = $val['id_order'];
                $cnt_book = 1;
                $this->bookarr['CNT'] = $cnt;
                $this->bookarr['DATAST'] = $val['data_st'];
                $this->bookarr['TOTALPRICE'] = $val['total_price'];
                $this->bookarr['MAIL'] = $val['mail_user'];
                $this->bookarr['STATUSNAME'] = $val['name_status'];
                $this->bookarr['ORDER'] = $order;
            $id_order = $val['id_order'];
            $book = $this->query->getListBodyOrderForUser($id_order);
            foreach($book as $key=>$val)
            {
                $this->bookarr['CNTBOOK'] = $cnt_book;
                $this->bookarr['BOOKNAME'] = $val['book_name'];
                $this->bookarr['QUANTITY'] = $val['quantity'];
                $this->bookarr['PRICE'] = $val['price']*$val['quantity'];
                $this->bookarr['BODY'].=$this->subs->templateRender('templates/admin/body.html',$this->bookarr);
                $cnt_book++;
            }
                $this->bookarr['USERANDORDER'].=$this->subs->templateRender('templates/admin/head.html',$this->bookarr);
            $cnt ++;
        };
        $data = $this->subs->templateRender('templates/admin/fixAdmin.html',$this->bookarr);
        return $data;
    }

    function index()
    {

    }
}
?>

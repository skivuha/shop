<?php
class PalletOrder
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
        $arr = $this->myPdo->select('data_st, total_price, shop_status.name_status, id_order')
            ->table("shop_orders INNER JOIN shop_status ON shop_status.id_status = shop_orders.id_status WHERE id_user = '$id_user' order by id_order DESC ")
            ->query()
            ->commit();
        $cnt=1;
        $data= '<table class="table table-striped">
                    <tr>
                        <th>Date</th>
                        <th>Total sum</th>
                        <th>Status</th>
                    </tr>
                    </table>';

        foreach($arr as $key=>$val) {
            $cnt_book = 1;
            $data .= '<div class="panel panel-default">
                    <div class="panel-heading orderHead">

                        <h4 class="panel-title">
                         <a href="#collapse-' . $cnt . '" data-parent="#accordion" data-toggle="collapse"><span>' . $val['data_st'] . '</span>
                         <span id="sum">' . $val['total_price'] . ' $</span><span id="status">' . $val['name_status'] . '</span></a>
                                </h4>
                            </div>
                            <div id="collapse-' . $cnt . '" class="panel-collapse collapse">
                                <div class="panel-body">';

        $book = $this->myPdo->select('book_name, price, shop_book_order.quantity')
            ->table("shop_book_order INNER JOIN shop_books ON shop_book_order.id_book = shop_books.book_id WHERE id_order = '$val[id_order]' ")
            ->query()
            ->commit();
            $data.= '<table class="table table-striped"><th>#</th><th>Book name</th><th>Quantity</th><th>Price</th>';
            foreach($book as $key=>$val)
            {
                $data.= '<tr><td>'.$cnt_book.'</td><td>'.$val['book_name'].'</td><td>'.$val['quantity'].'</td><td>'.$val['price']*$val['quantity'].'</td></tr>';
                $cnt_book++;
            }
             $data.='</table></div></div></div>';
            $cnt ++;
        };
        return $data;
    }
}
?>
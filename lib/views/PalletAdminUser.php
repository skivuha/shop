<?php
class PalletAdminUser implements iPallet
{
    private $myPdo;
    private $data;

    public function __construct()
    {
        $this->myPdo = MyPdo::getInstance();
        $this->data = DataCont::getInstance();
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

           $this->myPdo->update()->table('shop_orders SET id_status = '.$id_chenge_status['sel'].' where id_order = '.$id.'')->query()->commit();
        }

        $arr = $this->myPdo->select('DISTINCT data_st, total_price, shop_status.name_status, id_order, mail_user')
            ->table("shop_status, shop_users, shop_orders WHERE shop_status.id_status = shop_orders.id_status and
             shop_users.id_user=shop_orders.id_user order by id_order DESC ")
            ->query()
            ->commit();

        $cnt=1;
        $data= '<table class="table table-striped">
                    <tr>
                        <th>Date</th>
                        <th>Total sum</th>
                        <th>User</th>
                        <th>Status</th>
                    </tr>
                    </table>';

        $status = $this->myPdo->select('DISTINCT id_status, name_status')
            ->table('shop_status')
            ->query()
            ->commit();
        $status_ord = '';
        $status_ord = '<select name="sel"><option value="1"></option> ';

            foreach($status as $stat)
            {
                $status_ord.='<option value="'.$stat['id_status'].'">'.$stat['name_status'].'</option> ';
            }
            $status_ord .= '</select>';
            foreach($arr as $key=>$val) {
                $order = $val['id_order'];
                $cnt_book = 1;
                $data .= '<div class="panel panel-default">
                    <div class="panel-heading orderHead">

                        <h4 class="panel-title">
                         <a href="#collapse-' . $cnt . '" data-parent="#accordion" data-toggle="collapse"><span>' . $val['data_st'] . '</span>
                         <span id="sum">' . $val['total_price'] . ' $</span><span id="mail">'.$val['mail_user'].'</span></a>
                         <span id="status">' . $val['name_status'] . '</span><span><form method="post" action="">'.$status_ord.'</span><span><input type="submit" name="'.$order.'" value="save"/></form></span>

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

    function index()
    {

    }
}
?>

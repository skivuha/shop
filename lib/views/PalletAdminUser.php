<?php
class PalletAdminUser implements iPallet
{
    private $query;
    private $data;

    public function __construct()
    {
        $this->query = new QueryToDb();
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
            $id_status = $id_chenge_status['sel'];
            if( isset($id_status) && isset($id) )
            {
                $this->query->setNewStatusOrder($id_status, $id);
            }
        }

        $arr = $this->query->getAllOrders();

        $cnt=1;
        $data= '<table class="table table-striped">
                    <tr>
                        <th>Date</th>
                        <th>Total sum</th>
                        <th>User</th>
                        <th>Status</th>
                    </tr>
                    </table>';

        $status = $this->query->getAllStatus();

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
            $id_order = $val['id_order'];
            $book = $this->query->getListBodyOrderForUser($id_order);
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

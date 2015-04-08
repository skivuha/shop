<?php
class PalletOrder implements iPallet
{
    private $data;
    private $query;

    public function __construct()
    {
        $this->data = DataCont::getInstance();
        $this->query = new QueryToDb();
    }

    function index()
    {
        $id_user = $this->data->getVal();
        $arr = $this->query->getListHeaderOrderForUser($id_user);
        $cnt=1;
        $data='';
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

            $id_order = $val['id_order'];
            $book = $this->query->getListBodyOrderForUser($id_order);
            $data.= '<table class="table table-striped"><th>#</th><th>Book name</th><th>Quantity</th><th>Price</th>';
            foreach($book as $value)
            {
                $data.= '<tr><td>'.$cnt_book.'</td><td>'.$value['book_name'].'</td><td>'.$value['quantity'].'</td><td>'.$value['price']*$value['quantity'].'</td></tr>';
                $cnt_book++;
            }
             $data.='</table></div></div></div>';
            $cnt ++;
        };
        return $data;
    }
}
?>
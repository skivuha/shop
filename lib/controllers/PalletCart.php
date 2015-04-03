<?php
class PalletCart
{
    private $myPdo;
    private $data;
    public $nav;
    private $session;

    public function __construct()
    {
        $this->myPdo = MyPdo::getInstance();
        $this->data = DataCont::getInstance();
        $this->session = Session::getInstance();
    }

    function index()
    {
        $id_user = $this->data->getVal();
        $arr = $this->myPdo->select('cart_id, quantity, book_name, price')
            ->table("shop_users, shop_books INNER JOIN shop_cart WHERE id_user = '$id_user' AND shop_books.book_id = shop_cart.book_id and shop_users.id_user = shop_cart.user_id and visible = '1'")
           //->table("shop_users, shop_books INNER JOIN shop_cart")
            //->where(array("`shop_users.id_user`" => "`shop_cart.user_id`", "`shop_books.book_id`" => "`shop_cart.book_id`", 'user_id'=>$id_user))
            ->query()
            ->commit();
//        SELECT * FROM `shop_users`, `shop_books` INNER JOIN `shop_cart` WHERE `id_user` = 15
//    AND shop_books.book_id = shop_cart.book_id and shop_users.id_user = shop_cart.user_id
        $data = '<table class="table table-striped">
            <tr>
                <th>#</th>
                <th>Book name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Delete</th>
            </tr>';
        foreach($arr as $key=>$val)
            {
                $data.='<tr><td>'.$val['cart_id'].'</td><td>'.$val['book_name'].'</td><td><a href="#"> < </a>'.$val['quantity'].'<a href="#"> > </a></td><td>'.$val['price'].'</td><td><a href="/Cart/delete/id/'.$val['cart_id'].'">X</a></td></tr>';
            }
        $data.='</table>';
    return $data;
    }

    function delete()
    {
        $id_user = $this->data->getVal();
        $arr=$this->myPdo->delete()
        ->table("shop_cart where cart_id = '$id_user'")
        ->query()
        ->commit();
    }
}
?>
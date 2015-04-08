<?php
class QueryToDb
{
    private $myPdo;

    public function __construct()
    {
        $this->myPdo = MyPdo::getInstance();
    }

    public function getBookForOneMainPage($start_pos, $perpage)
    {
        $rez_arr = $this->myPdo->select('book_id, book_name, img, price, visible')
            ->table('shop_books')->where(array('visible' => 1))
            ->limit($start_pos, $perpage)
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function getBookIdInCartForCurentUser($id_user)
    {
        $rez_arr = $this->myPdo->select('book_id')
            ->table("shop_cart WHERE user_id = '$id_user' and status = '0'")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function getChechBookInCartForThisUser($id_user, $id_book)
    {
        $rez_arr = $this->myPdo->select('cart_id')
            ->table("shop_cart WHERE user_id = '$id_user' AND  book_id = '$id_book' AND status = '0'")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function setBookToCartForThisUser($id_user, $id_book)
    {
        $this->myPdo->insert()
            ->table("shop_cart SET user_id = '$id_user', book_id = '$id_book', status = '0'")
            ->query()
            ->commit();
        return true;
    }

    public function getBookForAuthor($author)
    {
        $rez_arr = $this->myPdo->select('book_id, book_name, img, price, visible')
            ->table("shop_books, shop_authors, shop_book_a WHERE shop_books.book_id = shop_book_a.b_id
            and shop_authors.authors_id = shop_book_a.a_id and visible='1' and authors_id='$author'")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function getBookForGenre($genre)
    {
        $rez_arr = $this->myPdo->select('book_id, book_name, img, price, visible')
            ->table("shop_books, shop_genre INNER JOIN shop_book_g WHERE shop_books.book_id = shop_book_g.b_id
             and shop_genre.genre_id = shop_book_g.g_id and visible='1' and genre_id=$genre")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function getAuthors()
    {
        $rez_arr = $this->myPdo->select('DISTINCT authors_name, authors_id')
            ->table("shop_books, shop_authors INNER JOIN shop_book_a WHERE shop_books.book_id = shop_book_a.b_id
             and shop_authors.authors_id = shop_book_a.a_id and visible='1' ORDER BY authors_name")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function getGenre()
    {
        $rez_arr = $this->myPdo->select('DISTINCT genre_name, genre_id')
            ->table("shop_books, shop_genre, shop_book_g WHERE shop_books.book_id = shop_book_g.b_id
             and shop_genre.genre_id = shop_book_g.g_id and visible='1'")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function getDetailsBook($book_id)
    {
        $rez_arr = $this->myPdo->select('DISTINCT book_id, price, book_name, img, content,
        GROUP_CONCAT(DISTINCT authors_name) as authors_name, GROUP_CONCAT(DISTINCT genre_name) as genre_name')
            ->table("shop_books, shop_authors, shop_genre INNER JOIN shop_book_a, shop_book_g WHERE
             shop_books.book_id = shop_book_a.b_id and shop_authors.authors_id = shop_book_a.a_id and
             shop_books.book_id = shop_book_g.b_id and shop_genre.genre_id = shop_book_g.g_id and
              book_id = $book_id and visible='1' GROUP BY book_name")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function getCountRow()
    {
        $rez_arr =  $this->myPdo->select('COUNT(book_id) as count_rows')
            ->table('shop_books')
            ->where(array('visible'=>1))
            ->query()
            ->commit();
        return $rez_arr[0]['count_rows'];
    }

    public function getListBookForCart($id_user)
    {
        $rez_arr =$this->myPdo->select('cart_id, quantity, book_name, price, shop_books.book_id, discount_user')
            ->table("shop_users, shop_books INNER JOIN shop_cart WHERE id_user = '$id_user'
            AND shop_books.book_id = shop_cart.book_id and shop_users.id_user = shop_cart.user_id and status = '0'")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function deleteFromCart($id_user)
    {
        $this->myPdo->delete()
            ->table("shop_cart where cart_id = '$id_user'")
            ->query()
            ->commit();
        return true;
    }

    public function getListPaymentForCheckout()
    {
        $rez_arr = $this->myPdo->select('payment_name, payment_id')
            ->table("shop_payment")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function getCountBuyingBook()
    {
        $rez_arr = $this->myPdo->select('count(*)')
            ->table("shop_payment")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function setBuyingBook($id_user, $your_price, $radio)
    {
        $this->myPdo->insert()
            ->table("shop_orders SET data_st = CURDATE(), id_user = '$id_user', total_price = '$your_price', id_payment = $radio")
            ->query()
            ->commit();
        return true;
    }

    public function getLastId()
    {
        return $this->myPdo->lastId;
    }

    public function setOrder($id_book, $quantity, $id_order)
    {
        $this->myPdo->insert()
            ->table("shop_book_order SET id_book = '$id_book', id_order = $id_order, quantity = '$quantity'")
            ->query()
            ->commit();
        return true;
    }

    public function setStatusBookInCart($id_user)
    {
        $this->myPdo->update()
            ->table("shop_cart SET status = '1' where user_id = '$id_user'")
            ->query()
            ->commit();
        return true;
    }

    public function getListHeaderOrderForUser($id_user)
    {
        $rez_arr = $this->myPdo->select('data_st, total_price, shop_status.name_status, id_order')
            ->table("shop_orders INNER JOIN shop_status ON shop_status.id_status = shop_orders.id_status
            WHERE id_user = '$id_user' order by id_order DESC ")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function getListBodyOrderForUser($id_order)
    {
        $rez_arr = $this->myPdo->select('book_name, price, shop_book_order.quantity')
            ->table("shop_book_order INNER JOIN shop_books ON
            shop_book_order.id_book = shop_books.book_id WHERE id_order = '$id_order'")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function setNewStatusOrder($id_status, $id)
    {
        $this->myPdo->update()
            ->table('shop_orders SET id_status = '.$id_status.' where id_order = '.$id.'')
            ->query()
            ->commit();
        return true;
    }

    public function getAllOrders()
    {
        $rez_arr = $this->myPdo->select('DISTINCT data_st, total_price, shop_status.name_status, id_order, mail_user')
            ->table("shop_status, shop_users, shop_orders WHERE shop_status.id_status = shop_orders.id_status and
             shop_users.id_user=shop_orders.id_user order by id_order DESC ")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function getAllStatus()
    {
        $rez_arr = $this->myPdo->select('DISTINCT id_status, name_status')
            ->table('shop_status')
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function deleteBook($id_book)
    {
        $this->myPdo->delete()
            ->table("shop_books where book_id = '$id_book'")
            ->query()
            ->commit();
        return true;
    }

    public function deleteGenre($id_genre)
    {
        $this->myPdo->delete()
            ->table("shop_genre where genre_id = '$id_genre'")
            ->query()
            ->commit();
        return true;
    }

    public function deleteAuthor($id_author)
    {
        $this->myPdo->delete()
            ->table("shop_authors where authors_id = '$id_author'")
            ->query()
            ->commit();
        return true;
    }

    public function getAuthorName($id_author)
    {
        $rez_arr = $this->myPdo->select('authors_name, authors_id')
            ->table("shop_authors where authors_id = '$id_author'")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function setAuthorNewName($new_author, $id_author)
    {
        $this->myPdo->update()
            ->table("shop_authors SET authors_name = '$new_author' where authors_id = '$id_author'")
            ->query()
            ->commit();
        return true;
    }

    public function setAuthorNew($new_author)
    {
        $this->myPdo->insert()
            ->table("shop_authors SET authors_name = '$new_author'")
            ->query()
            ->commit();
        return true;
    }

    public function getAuthorsName()
    {
        $rez_arr = $this->myPdo->select('DISTINCT authors_name, authors_id')
            ->table("shop_authors")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function getGenreName($id_genre)
    {
        $rez_arr = $this->myPdo->select('genre_name, genre_id')
            ->table("shop_genre where genre_id = '$id_genre'")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function setGenreNewName($new_genre, $id_genre)
    {
        $this->myPdo->update()
            ->table("shop_genre SET genre_name = '$new_genre' where genre_id = '$id_genre'")
            ->query()
            ->commit();
        return true;
    }

    public function setGenreNew($new_genre)
    {
        $this->myPdo->insert()
            ->table("shop_genre SET genre_name = '$new_genre'")
            ->query()
            ->commit();
        return true;
    }

    public function getGenresName()
    {

        $rez_arr = $this->myPdo->select('DISTINCT genre_name, genre_id')
            ->table("shop_genre")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function setBookNew($name,$price,$content, $visible)
    {
        $this->myPdo->insert()
            ->table("shop_books SET book_name = '$name', price = '$price', content = '$content', visible = '$visible'")
            ->query()
            ->commit();
        return true;
    }

    public function setImgNew($baseimgName, $id)
    {
        $this->myPdo->update()
            ->table("shop_books SET img = '$baseimgName' where book_id = '$id'")
            ->query()
            ->commit();
        return true;
    }

    public function getAuthorsList($authors_name)
    {
        $rez_arr = $this->myPdo->select('authors_id')
            ->table("shop_authors WHERE authors_name='$authors_name'")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function setAuthorToBook($id_a, $id)
    {
        $this->myPdo->insert()
            ->table("shop_book_a SET a_id = '$id_a', b_id = '$id'")
            ->query()
            ->commit();
        return true;
    }

    public function getGenresList($genre_name)
    {
        $this->myPdo->select('genre_id')
            ->table("shop_genre WHERE genre_name='$genre_name'")
            ->query()
            ->commit();
        return true;
    }

    public function setGenreToBook($id_g, $id)
    {
        $this->myPdo->insert()
            ->table("shop_book_g SET g_id = '$id_g', b_id = '$id'")
            ->query()
            ->commit();
        return true;
    }

    public function getAllDataBook($id_book)
    {
        $rez_arr = $this->myPdo->select("DISTINCT book_id, price, book_name, img, content, visible,
        GROUP_CONCAT(DISTINCT authors_name) as authors_name, GROUP_CONCAT(DISTINCT genre_name) as genre_name")
            ->table("shop_books, shop_authors, shop_genre INNER JOIN shop_book_a, shop_book_g
            WHERE shop_books.book_id = shop_book_a.b_id and shop_authors.authors_id = shop_book_a.a_id and
             shop_books.book_id = shop_book_g.b_id and shop_genre.genre_id = shop_book_g.g_id and
              book_id = $id_book GROUP BY book_name")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function setNoImg($id_book)
    {
        $this->myPdo->update()
            ->table("shop_books SET img = 'no_image.png' where book_id = '$id_book'")
            ->query()
            ->commit();
        return true;
    }

    public function getBookAuthor($alist)
    {
        $rez_arr = $this->myPdo->select('authors_id')
            ->table("shop_authors WHERE authors_name='$alist'")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function deleteBookAuthor($id_book, $id_authtor)
    {
        $this->myPdo->delete()
            ->table("shop_book_a where b_id = '$id_book' and a_id = '$id_authtor'")
            ->query()
            ->commit();
        return true;
    }

    public function getBookGenre($glist)
    {
        $rez_arr = $this->myPdo->select('genre_id')
            ->table("shop_genre WHERE genre_name='$glist'")
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function deleteBookGenre($id_book, $id_genre)
    {
        $this->myPdo->delete()
            ->table("shop_book_g where b_id = '$id_book' and g_id = '$id_genre'")
            ->query()
            ->commit();
        return true;
    }

    public function setNewDataToBook($book_name, $price, $content, $id_book)
    {
        $this->myPdo->update()
            ->table("shop_books SET book_name = '$book_name', price = '$price', content = '$content'
            where book_id = '$id_book'")
            ->query()
            ->commit();
        return true;
    }

    public function getUser($email)
    {
        $rez_arr = $this->myPdo->select('id_user, mail_user, password_user, key_user, login_user')
            ->table('shop_users')->where(array('mail_user' => $email))
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function setUser($code_user, $email)
    {
        $this->myPdo->update()
            ->table("shop_users SET code_user = '$code_user' where mail_user = '$email'")
            ->query()
            ->commit();
    }

    public function getLoginUser($email)
    {
        $rez_arr = $this->myPdo->select('login_user')
            ->table('shop_users')
            ->where(array('mail_user'=>$email))
            ->query()
            ->commit();
        return $rez_arr;
    }

    public function setUserToDb($name, $pass, $email, $key_user)
    {
        $this->myPdo->insert()
            ->table("shop_users SET login_user = '$name', password_user = '$pass', mail_user = '$email', key_user = '$key_user'")
            ->query()
            ->commit();
        return true;
    }

    public function setQuantity($quantity, $id_user, $book_id)
    {
        $this->myPdo->update()
            ->table("shop_cart SET quantity = '$quantity' where user_id = '$id_user' and book_id = '$book_id'")
            ->query()
            ->commit();
        return true;
    }

    public function deleteBookFromCart($id)
    {
        $this->myPdo->delete()
            ->table("shop_cart where cart_id = '$id'")
            ->query()
            ->commit();
        return true;
    }
}
?>
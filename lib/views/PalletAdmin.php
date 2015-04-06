<?php
class PalletAdmin implements iPallet
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
        $params = $this->data->getParam();
        $nav = new PaletteNav($params);
        $start_pos = $nav->getStartPage();
        $perpage = $nav->getPerPage();
        $page = $nav->getPageNav();
        $page_count = $nav->getPageCount();
        $uri = $nav->getUriPageNav();
        $this->navBar($uri, $page, $page_count);

        $arr = $this->myPdo->select('book_id, book_name, img, price, visible')
            ->table('shop_books')
            ->where(array('visible'=>1))
            ->limit($start_pos, $perpage)
            ->query()
            ->commit();
        return $this->bookCreate($arr);
    }

    function bookCreate($arr)
    {
        $data = '';
        foreach ($arr as $books) {
            $data .= '<div align="center" id="contentIndex">';
            $data .= '<div id=contenrInfo>';
            $data .= '<p><a href="/Admin/details/id/' . $books['book_id'] . '" class="nameBook">' . $books['book_name'] . '</a></p>';
            $data .= '<a href="/Admin/details/id/' . $books['book_id'] . '" class="nameBook"><img src="' . SRC_IMG . $books['img'] . '"></a>';
            $data .= '<p><span id="priceBook">' . $books['price'] . ' $</span></p>';
            $data .= '<p><a href="/Admin/details/id/' . $books['book_id'] . '" id="addBook">Details</a></p>
                      <p><a href="/Admin/update/id/' . $books['book_id'] . '" id="updateBook">Update</a></p>
<p><a href="/Admin/delete/id/' . $books['book_id'] . '" onclick="return confirmDelete();" id="delBook">Delete</a></p>';
            $data .= '</div></div>';
        }
        return $data;
    }
    public function getNav()
    {
        return $this->nav;
    }



    function sort()
    {
        $params = $this->data->getParam();
        if(isset($params[author]))
        {
            $author = abs((int)$params[author]);
            $arr = $this->myPdo->select('book_id, book_name, img, price, visible')
                //$sortPage = $this->myPdo->select('book_id, book_name, img, price, visible')
                ->table("shop_books, shop_authors INNER JOIN shop_book_a WHERE shop_books.book_id = shop_book_a.b_id and shop_authors.authors_id = shop_book_a.a_id and visible='1' and authors_id='$author'")
                //->table("shop_books, shop_authors")
                //  ->join('shop_book_a')
                //->where(array('shop_books.book_id' => 'shop_book_a.b_id' , 'shop_authors.authors_id' => 'shop_book_a.a_id', 'visible'=>'1', 'authors_id'=>$author))
                //->limit($start_pos, $perpage)
                ->query()
                ->commit();
        }
        elseif(isset($params[genre]))
        {
            $genre = abs((int)$params[genre]);
            $arr = $this->myPdo->select('book_id, book_name, img, price, visible')
                ->table("shop_books, shop_genre INNER JOIN shop_book_g WHERE shop_books.book_id = shop_book_g.b_id and shop_genre.genre_id = shop_book_g.g_id and visible='1' and genre_id=$genre")
                ->query()
                ->commit();
        }
        return $this->bookCreate($arr);

    }

    function delete()
    {
        $id_book = $this->data->getParam();
        $this->myPdo->delete()
            ->table("shop_books where book_id = '$id_book'")
            ->query()
            ->commit();

        header('Location: /Admin/index/');
    }

    function genreDelete()
    {
        $id_genre = $this->data->getParam();
        $this->myPdo->delete()
            ->table("shop_genre where genre_id = '$id_genre'")
            ->query()
            ->commit();

        header('Location: /Admin/editgenre/');
    }

    function authorDelete()
    {
        $id_author = $this->data->getParam();
        $this->myPdo->delete()
            ->table("shop_authors where authors_id = '$id_author'")
            ->query()
            ->commit();

        header('Location: /Admin/editauthor/');
    }



    function editauthor()
    {
        if(isset($_POST['name_author']))
        {
            $new_author = $this->data->getParam();
            $this->myPdo->insert()
                ->table("shop_authors SET authors_name = '$new_author'")
                ->query()
                ->commit();
            header('Location: /Admin/editauthor/');
        }
        else
        {
        $arr = $this->myPdo->select('DISTINCT authors_name, authors_id')
            ->table("shop_authors")
            ->query()
            ->commit();
        $cnt=1;
        $data = '';
        $data.= '<div id="genre"> ';
        $data.='<h2>Authors</h2>';
        $data.= '<form action="" method="post">
   <p> Author: <input type="text" name="name_author">
    <input type="submit" name="submit" value="Save"></p>
</form>';
        $data.='<table class="table table-striped"><tr><th>#</th><th>Name</th><th>Delete</th><th>Edit</th></tr>';
        foreach($arr as $authors)
        {
            $data.='<tr><td>'.$cnt.'</td><td>'.$authors['authors_name'].'</td><td><a href="/Admin/authorDelete/id/'.$authors['authors_id'].'">X</a>
            </td><td><a href="/Admin/authorEdit/id/'.$authors['authors_id'].'">Edit</a></td></tr>';
            $cnt++;
        }
        $data.='</table></div>';}
        return $data;
    }

    function editgenre()
    {
        if(isset($_POST['name_genre']))
        {
            $new_genre = $this->data->getParam();
            $this->myPdo->insert()
                ->table("shop_genre SET genre_name = '$new_genre'")
                ->query()
                ->commit();
            header('Location: /Admin/editgenre/');
        }
        else
        {
        $arr = $this->myPdo->select('DISTINCT genre_name, genre_id')
            ->table("shop_genre")
            ->query()
            ->commit();
        $cnt=1;
        $data = '';
        $data.= '<div id="genre"> ';
        $data.='<h2>Genre</h2>';
        $data.= '<form action="" method="post">
   <p> Genre: <input type="text" name="name_genre">
    <input type="submit" name="submit" value="Save"></p>
</form>';
        $data.='<table class="table table-striped"><tr><th>#</th><th>Name</th><th>Delete</th><th>Edit</th></tr>';
        foreach($arr as $genres)
        {
            $data.='<tr><td>'.$cnt.'</td><td>'.$genres['genre_name'].'</td><td><a href="/Admin/genreDelete/id/'.$genres['genre_id'].'">X</a>
            </td><td><a href="/Admin/genreEdit/id/'.$genres['genre_id'].'">Edit</a></td></tr>';
            $cnt++;
        }
        $data.='</table></div>';
        }
        return $data;
    }

    function details($book_id)
    {
        $arr = $this->myPdo->select('DISTINCT book_id, price, book_name, img, content, GROUP_CONCAT(DISTINCT authors_name) as authors_name, GROUP_CONCAT(DISTINCT genre_name) as genre_name')
            ->table("shop_books, shop_authors, shop_genre INNER JOIN shop_book_a, shop_book_g WHERE shop_books.book_id = shop_book_a.b_id and shop_authors.authors_id = shop_book_a.a_id and shop_books.book_id = shop_book_g.b_id and shop_genre.genre_id = shop_book_g.g_id and book_id = $book_id and visible='1' GROUP BY book_name")
            //->where('visible', '1')
            ->query()
            ->commit();

        $arr = $arr[0];

        $data = '';
        $data.='<div id="bookDetails">';
        $data.='<h1>'.$arr['book_name'].'</h1>';
        $data.='<div class="productDetails">';
        $data.='<img src="'.SRC_IMG.$arr['img'].'"></div>';
        $data.='<div id="detailsText">';
        $data.='<h2>Product Details</h2>';
        $data.='<p class="detailsfirst"><b>Author: </b>'.$arr['authors_name'].'</p>';
        $data.='<p><b>Genre: </b>'.$arr['genre_name'].'</p>';
        $data.=$arr['content'].'</div></div>';
        return $data;
    }

    function formExit()
    {

        $data = '
<div id="exit">
<form action="" method="post"><input type="submit" value="en" name="leng"><span></span><span><input type="submit" value="ru" name="leng"></span></form>
<form action="/Regestration/logout/" method="post">
        <span>Hello <span id="nameSession">'.$this->session->getSession('login_user').'</span></span>
        <input type="submit" class="btn btn-default btn-xs" value="Exit" name="exit"></div></form>
        <a href="/Cart/index"><span class="glyphicon glyphicon-shopping-cart"> My cart</span></a><br>
        <a href="/Order/index/"><span class="glyphicon glyphicon-home"> My cabinet</span></a>';
        return $data;
    }



    function formLogin()
    {
        $data = '<span><a href="/Admin/index">For admin!</a></span>
<div id="exit"><form action="" method="post"><input type="submit" value="en" name="leng"><span></span><span><input type="submit" value="ru" name="leng"></span></form>
        <span>Hello, <span id="nameSession">guest!</span></span></div>
        <a href="/Cart/index"><span class="glyphicon glyphicon-shopping-cart"> My cart</span></a><br>
        <a href="/Regestration/logon/"><span class="glyphicon glyphicon-home"> My cabinet</span></a>';
        return $data;
    }

    function navBar($uri, $page, $page_count)
    {
        // crating of links
        $back = '';
        $forward = '';
        $startpage = '';
        $endpage = '';
        $page2left = '';
        $page1left = '';
        $page2right = '';
        $page1right = '';

        if($page > 1)
        {
            $back = "<a href='".PATH."/$uri/page/" .($page-1). "'>&lt;</a>";
        }
        if($this->page < $this->page_count)
        {
            $forward = "<a href='".PATH."/$uri/page/" .($page+1). "'>&gt;</a>";
        }
        if($page > 3)
        {
            $startpage = "<a href='".PATH."/$uri/page/1'>&laquo;</a>";
        }
        if($page < $page_count-2)
        {
            $endpage = "<a href='".PATH."/$uri/page/{$page_count}'>&raquo;</a>";
        }
        if($page - 2 > 0)
        {
            $page2left = "<a href='".PATH."/$uri/page/" .($page-2). "'>" .($page-2). "</a>";
        }
        if($page - 1 > 0)
        {
            $page1left = "<a href='".PATH."/$uri/page/" .($page-1). "'>" .($page-1). "</a>";
        }
        if($page + 2 <= $page_count)
        {
            $page2right = "<a href='".PATH."/$uri/page/" .($page+2). "'>" .($page+2). "</a>";
        }
        if($page + 1 <= $page_count)
        {
            $page1right = "<a href='".PATH."/$uri/page/" .($page+1). "'>" .($page+1). "</a>";
        }

        $this->nav = $startpage.$back.$page2left.$page1left.'<a class="navActive">'.$page.'</a>'.$page1right.$page2right.$forward.$endpage;
        return $this->nav;
    }

}
?>
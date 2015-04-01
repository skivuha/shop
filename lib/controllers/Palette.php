<?php
class Palette
{
    private $myPdo;
    private $data;
    public function __construct()
    {
        $this->myPdo = MyPdo::getInstance();
        $this->data = DataCont::getInstance();
    }

    function sort()
    {
        $params = $this->data->getParam();
        $this->data->setmArray('TITLE', 'Books');
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

    $data = '';
        foreach($arr as $books)
        {
            $data.='<div align="center" id="contentIndex">';
            $data.='<div id=contenrInfo>';
            $data.='<p><a href="'.PATH.'/Home/details/id/'.$books['book_id'].'" class="nameBook">'.$books['book_name'].'</a></p>';
            $data.='<a href="'.PATH.'/Home/details/id/'.$books['book_id'].'" class="nameBook"><img src="'.PATH.'/lib/views/user_files/img/'.$books['img'].'"></a>';
            $data.='<p><br><span id="priceBook">'.$books['price'].' $</span></p>';
            $data.='<br><p><a href="'.PATH.'/Home/details/id/'.$books['book_id'].'" id="detailsBook">Details</a></p>';
            $data.='</div></div>';
        }
        return $data;
    }

    function authors()
    {
        $this->data->setmArray('TITLE', 'Authors');
        $arr = $this->myPdo->select('DISTINCT authors_name, authors_id')
            ->table("shop_books, shop_authors INNER JOIN shop_book_a WHERE shop_books.book_id = shop_book_a.b_id and shop_authors.authors_id = shop_book_a.a_id and visible='1' ORDER BY authors_name")
            //->where('visible', '1')
            ->query()
            ->commit();

        $data = '';
        $data.= '<div id="authors">';
        $data.='<h2>Authors</h2>';
        $data.='<ul class="authorsCol">';
        foreach($arr as $authors)
        {
            $data.='<li><a href="'.PATH.'/Home/sort/author/'.$authors['authors_id'].'">'.$authors['authors_name'].'</a></li>';
        }
        $data.='</ul></div>';
        return $data;
    }

    function genres()
    {
        $this->data->setmArray('TITLE', 'Genres');
        $arr = $this->myPdo->select('DISTINCT genre_name, genre_id')
            ->table("shop_books, shop_genre INNER JOIN shop_book_g WHERE shop_books.book_id = shop_book_g.b_id and shop_genre.genre_id = shop_book_g.g_id and visible='1'")
            //->where('visible', '1')
            ->query()
            ->commit();
        $data = '';
        $data.= '<div id="genre"> ';
        $data.='<h2>Genre</h2>';
        $data.='<ul class="genreCol">';
        foreach($arr as $genres)
        {
            $data.='<li><a href="'.PATH.'/Home/sort/genre/'.$genres['genre_id'].'">'.$genres['genre_name'].'</a></li>';
        }
        $data.='</ul></div>';
        return $data;
    }

    function details($book_id)
    {
        $this->data->setmArray('TITLE', 'Details');
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
        $data.='<img src="'.PATH.'/lib/views/user_files/img/'.$arr['img'].'"></div>';
        $data.='<div id="detailsText">';
        $data.='<h2>Product Details</h2>';
        $data.='<p class="detailsfirst"><b>Author: </b>'.$arr['authors_name'].'</p>';
        $data.='<p><b>Genre: </b>'.$arr['genre_name'].'</p>';
        $data.=$arr['content'].'</div></div>';
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

        $nav = $startpage.$back.$page2left.$page1left.'<a class="navActive">'.$page.'</a>'.$page1right.$page2right.$forward.$endpage;
        return $nav;
    }
}
?>
<?php
class PaletteMain implements iPallet
{
    private $data;
    public $nav;
    private $session;
    private $query;

    public function __construct()
    {
        $this->data = DataCont::getInstance();
        $this->session = Session::getInstance();
        $this->query = new QueryToDb();
    }

    function bookCreate($arr)
    {
        $buy = array();
        $id_user = abs((int)($this->session->getSession('id_user')));
        if(0 === $id_user)
        {

        }
        else {
            $buy = $this->query->getBookIdInCartForCurentUser($id_user);
        }
        $data = '';
        foreach($arr as $books)
        {
            $cnt = 0;
            $data.='<div align="center" id="contentIndex">';
            $data.='<div id=contenrInfo>';
            $data.='<p><a href="'.PATH.'Home/details/id/'.$books['book_id'].'" class="nameBook">'.$books['book_name'].'</a></p>';
            $data.='<a href="'.PATH.'Home/details/id/'.$books['book_id'].'" class="nameBook"><img src="'.SRC_IMG.$books['img'].'"></a>';
            $data.='<p><span id="priceBook">'.$books['price'].' $</span></p>';
            foreach($buy as $val)
            {
                if($val['book_id'] === $books['book_id'])
                {
                    $cnt++;
                }
            }
            if(false == $cnt)
            {
                $data .= '<p><a href="'.PATH.'Home/add/id/' . $books['book_id'] . '" id="buyBook">Buy</a></p>';
            }
            else
            {
                $data .= '<p><a href="'.PATH.'Cart/index/" id="toCart">To cart</a></p>';
            }
            $data.='<p><a href="'.PATH.'Home/details/id/'.$books['book_id'].'" id="detailsBook">Details</a></p>';
            $data.='</div></div>';
        }
        return $data;
    }

    public function getNav()
    {
        return $this->nav;
    }

    function add()
    {
        $id_user = $this->data->getIdUser();
        $id_book = $this->data->getVal();
            $check = $this->query->getChechBookInCartForThisUser($id_user, $id_book);
            if (0 === count($check))
            {
                $this->query->setBookToCartForThisUser($id_user, $id_book);
            }
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
        $arr = $this->query->getBookForOneMainPage($start_pos, $perpage);
        return $this->bookCreate($arr);
    }

    function sort()
    {
      $params = $this->data->getParam();
        if(isset($params['author']))
        {
            $author = abs((int)$params['author']);
            $arr = $this->query->getBookForAuthor($author);
        }
        elseif(isset($params['genre']))
        {
            $genre = abs((int)$params['genre']);
            $arr = $this->query->getBookForGenre($genre);
        }
        return $this->bookCreate($arr);
    }

    function authors()
    {
        $arr = $this->query->getAuthors();

        $data = '';
        $data.= '<div id="authors">';
        $data.='<h2>Authors</h2>';
        $data.='<ul class="authorsCol">';
        foreach($arr as $authors)
        {
            $data.='<li><a href="'.PATH.'Home/sort/author/'.$authors['authors_id'].'">'.$authors['authors_name'].'</a></li>';
        }
        $data.='</ul></div>';
        return $data;
    }

    function genres()
    {
        $arr = $this->query->getGenre();
        $data = '';
        $data.= '<div id="genre"> ';
        $data.='<h2>Genre</h2>';
        $data.='<ul class="genreCol">';
        foreach($arr as $genres)
        {
            $data.='<li><a href="'.PATH.'Home/sort/genre/'.$genres['genre_id'].'">'.$genres['genre_name'].'</a></li>';
        }
        $data.='</ul></div>';
        return $data;
    }

    function details($book_id)
    {
        $arr = $this->query->getDetailsBook($book_id);

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
        $name = $this->session->getSession('login_user');
        return $name;
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
            $back = '<a href="'.PATH.$uri.'/page/' .($page-1). '">&lt;</a>';
        }
        if($this->page < $this->page_count)
        {
            $forward = '<a href="'.PATH.$uri.'/page/' .($page+1). '">&gt;</a>';
        }
        if($page > 3)
        {
            $startpage = '<a href="'.PATH.$uri.'/page/1">&laquo;</a>';
        }
        if($page < $page_count-2)
        {
            $endpage = '<a href="'.PATH.$uri.'/page/'.$page_count.'">&raquo;</a>';
        }
        if($page - 2 > 0)
        {
            $page2left = '<a href="'.PATH.$uri.'/page/' .($page-2). '">' .($page-2). '</a>';
        }
        if($page - 1 > 0)
        {
            $page1left = '<a href="'.PATH.$uri.'/page/' .($page-1). '">' .($page-1). '</a>';
        }
        if($page + 2 <= $page_count)
        {
            $page2right = '<a href="'.PATH.$uri.'/page/' .($page+2). '">' .($page+2). '</a>';
        }
        if($page + 1 <= $page_count)
        {
            $page1right = '<a href="'.PATH.$uri.'/page/' .($page+1). '">' .($page+1). '</a>';
        }

        $this->nav = $startpage.$back.$page2left.$page1left.'<a class="navActive">'.$page.'</a>'.$page1right.$page2right.$forward.$endpage;
        return $this->nav;
    }
}
?>

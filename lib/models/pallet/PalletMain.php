<?php
class PalletMain implements iPallet
{
    private $data;
    public $navig;
    private $session;
    private $query;
    private $bookarr;
    private $subs;

    public function __construct()
    {
        $this->data = DataCont::getInstance();
        $this->session = Session::getInstance();
        $this->subs = new Substitution();
        $this->query = new QueryToDb();
    }

    function bookCreate($arr)
    {

        $buy = array();
        $id_user = abs((int)($this->session->getSession('id_user')));
        if(0 === $id_user)
        {}
        else {
            $buy = $this->query->getBookIdInCartForCurentUser($id_user);
        }
        $data = '';
        foreach($arr as $books)
        {
            $cnt = 0;
            $this->bookarr['BOOK_ID'] = $books['book_id'];
            $this->bookarr['BOOK_NAME'] = $books['book_name'];
            $this->bookarr['BOOK_IMG'] = $books['img'];
            $this->bookarr['BOOK_PRICE'] = $books['price'];

            foreach($buy as $val)
            {
                if($val['book_id'] === $books['book_id'])
                {
                    $cnt++;
                }
            }
            if(false == $cnt)
            {
                $this->bookarr['BOOK_PATH'] = '/~user2/PHP/shop/Home/add/id/'.$books['book_id'].'" id="buyBook"';
                $this->bookarr['BUYORCART'] = 'Buy';
            }
            else
            {
                $this->bookarr['BOOK_PATH'] = '/~user2/PHP/shop/Cart/index/" id="toCart"';
                $this->bookarr['BUYORCART'] = 'To cart';
            }
            $data.= $this->subs->templateRender('templates/subtemplates/book.html',$this->bookarr);
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

    public function index()
    {
        $params = $this->data->getParam();
        $nav = new PalleteNav($params);
        $start_pos = $nav->getStartPage();
        $perpage = $nav->getPerPage();
        $page = $nav->getPageNav();
        $page_count = $nav->getPageCount();
        $uri = $nav->getUriPageNav();
        $this->nav = $this->navBar($uri, $page, $page_count);
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
        foreach($arr as $authors)
        {
            $this->bookarr['AUTHOR_NAME'] = $authors['authors_name'];
            $this->bookarr['AUTHOR_ID'] = $authors['authors_id'];
            $this->bookarr['AUTHORSALL'].= $this->subs->templateRender('templates/subtemplates/authorsall.html',$this->bookarr);
        }
        $data = $this->subs->templateRender('templates/subtemplates/authors.html',$this->bookarr);
        return $data;
    }

    function genres()
    {
        $arr = $this->query->getGenre();
        foreach($arr as $genres)
        {
            $this->bookarr['GENRE_NAME'] = $genres['genre_name'];
            $this->bookarr['GENRE_ID'] = $genres['genre_id'];
            $this->bookarr['GENREALL'].= $this->subs->templateRender('templates/subtemplates/genreall.html',$this->bookarr);
        }
        $data = $this->subs->templateRender('templates/subtemplates/genre.html',$this->bookarr);
        return $data;
    }

    function details($book_id)
    {
        $arr = $this->query->getDetailsBook($book_id);
        $arr = $arr[0];
        $this->bookarr['BOOKNAME'] = $arr['book_name'];
        $this->bookarr['BOOKIMG'] = $arr['img'];
        $this->bookarr['AUTHORSNAME'] = $arr['authors_name'];
        $this->bookarr['GENRENAME'] = $arr['genre_name'];
        $this->bookarr['CONTENT'] = $arr['content'];
        $data = $this->subs->templateRender('templates/subtemplates/detailsbook.html',$this->bookarr);
        return $data;
    }

    function formExit()
    {
        $name = $this->session->getSession('login_user');
        return $name;
    }

    public function navBar($uri, $page, $page_count)
    {
        $this->bookarr['URI'] = $uri;
        $this->bookarr['PAGE'] = $page;
        if($page > 1)
        {
            $this->bookarr['BACK'] = $page-1;
        }
        if($page < $page_count)
        {
            $this->bookarr['FORWARD'] = $page+1;
        }
        if($page > 3)
        {
            $this->bookarr['START'] = '1';
        }
        if($page < $page_count-2)
        {
            $this->bookarr['END'] = $page_count;
        }
        if($page - 2 > 0)
        {
            $this->bookarr['PAGE2L'] = $page-2;
        }
        if($page - 1 > 0)
        {
            $this->bookarr['PAGE1L'] = $page-1;
        }
        if($page + 2 <= $page_count)
        {
            $this->bookarr['PAGE2R'] = $page+2;
        }
        if($page + 1 <= $page_count)
        {
            $this->bookarr['PAGE1R'] = $page+1;
        }

        $this->nav = $this->subs->templateRender('templates/subtemplates/nav.html',$this->bookarr);
        return $this->navig;
    }
}
?>

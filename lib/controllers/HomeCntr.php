<?php
class HomeCntr
{
    private $fc;
    private $myPdo;
    private $data;
    private $dataPalette;
    private $dataPaletteNav;

    public function __construct()
    {
        $this->fc = FrontCntr::getInstance();
        $this->myPdo = MyPdo::getInstance();
        $this->data = DataCont::getInstance();
        $this->dataPalette = new Palette();
    }

    function indexAction()
    {
        $params = $this->fc->getParams();
        $nav = new PaletteNav($params);
        $start_pos = $nav->getStartPage();
        $perpage = $nav->getPerPage();
        $page = $nav->getPageNav();
        $page_count = $nav->getPageCount();
        $uri = $nav->getUriPageNav();

        $mainPage = $this->myPdo->select('book_id, book_name, img, price, visible')
            ->table('books')
            ->where('visible','1')
            ->limit($start_pos, $perpage)
            ->query()
            ->commit();

        $dataMainPage = $this->dataPalette->mainPage($mainPage);
        $dataNavPage = $this->dataPalette->navBar($uri, $page, $page_count);

        $this->data->setmArray('TITLE', 'Books');
        $this->data->setmArray('BOOKLIST', $dataMainPage);
        $this->data->setmArray('PAGENAV', $dataNavPage);
        $this->data->setPage('lib/views/main.html');
        $this->data->setData($params);
    }

    function sortAction()
    {
        $params = $this->fc->getParams();
        if(isset($params[author]))
        {
            $author = abs((int)$params[author]);
            $sortPage = $this->myPdo->select('book_id, book_name, img, price, visible')
                ->table("books, authors INNER JOIN book_a WHERE books.book_id = book_a.b_id and authors.authors_id = book_a.a_id and visible='1' and authors_id='$author'")
                //->where('visible','1')
                //->limit($start_pos, $perpage)
                ->query()
                ->commit();
        }
        elseif(isset($params[genre]))
        {
            $genre = abs((int)$params[genre]);
            $sortPage = $this->myPdo->select('book_id, book_name, img, price, visible')
                ->table("books, genre INNER JOIN book_g WHERE books.book_id = book_g.b_id and genre.genre_id = book_g.g_id and visible='1' and genre_id=$genre")
                //->where('visible','1')
                //->limit($start_pos, $perpage)
                ->query()
                ->commit();
        }

        $dataSortPage = ($this->dataPalette->mainPage($sortPage));

        $this->data->setmArray('TITLE', 'Books');
        $this->data->setmArray('BOOKLIST', $dataSortPage);
        $this->data->setPage('lib/views/main.html');
        $this->data->setData($params);
    }

    function authorsAction()
    {
        $params = $this->fc->getParams();

        $authorsPage = $this->myPdo->select('DISTINCT authors_name, authors_id')
            ->table("books, authors INNER JOIN book_a WHERE books.book_id = book_a.b_id and authors.authors_id = book_a.a_id and visible='1' ORDER BY authors_name")
            //->where('visible', '1')
            ->query()
            ->commit();

        $authorsPage = ($this->dataPalette->authorsPage($authorsPage));

        $this->data->setmArray('TITLE', 'Authors');
        $this->data->setmArray('BOOKLIST', $authorsPage);
        $this->data->setPage('lib/views/main.html');
        $this->data->setData($params);

    }

    function genresAction()
    {
        $params = $this->fc->getParams();
        $genresPage = $this->myPdo->select('DISTINCT genre_name, genre_id')
            ->table("books, genre INNER JOIN book_g WHERE books.book_id = book_g.b_id and genre.genre_id = book_g.g_id and visible='1'")
            //->where('visible', '1')
            ->query()
            ->commit();

        $genresPage = ($this->dataPalette->genresPage($genresPage));

        $this->data->setmArray('TITLE', 'Genres');
        $this->data->setmArray('BOOKLIST', $genresPage);
        $this->data->setPage('lib/views/main.html');
        $this->data->setData($params);

    }

    function detailsAction()
    {
        $params = $this->fc->getParams();
        $book_id = abs((int)$params[id]);
        if($book_id)
        {
            $detailsPage = $this->myPdo->select('DISTINCT book_id, price, book_name, img, content, GROUP_CONCAT(DISTINCT authors_name) as authors_name, GROUP_CONCAT(DISTINCT genre_name) as genre_name')
                ->table("books, authors, genre INNER JOIN book_a, book_g WHERE books.book_id = book_a.b_id and authors.authors_id = book_a.a_id and books.book_id = book_g.b_id and genre.genre_id = book_g.g_id and book_id = $book_id and visible='1' GROUP BY book_name")
                //->where('visible', '1')
                ->query()
                ->commit();
        }

        $detailsPage = ($this->dataPalette->detailsPage($detailsPage[0]));

        $this->data->setmArray('TITLE', 'Details');
        $this->data->setmArray('BOOKLIST', $detailsPage);
        $this->data->setPage('lib/views/main.html');
        $this->data->setData($params);
    }

    function formAction()
    {
        $data = DataCont::getInstance();
        $check = new Validator();
        //$check->checkForm($_POST['user']);
        $data_post = $check->clearDataArr($_POST);
        if('' === $data_post['password'])
        {
            $data->setmArray('ERROR_PASS', 'Field is empty');
            $pass = false;
        }
        else
        {
            if( false === $check->checkPass($data_post['password']))
            {
                $data->setmArray('ERROR_PASS', 'Wrong data');
                $pass = false;
            }
            else
            {
                $pass = $data_post['password'];
            }
        }

        if('' === $data_post['user'])
        {
            $data->setmArray('ERROR_NAME', 'Field is empty');
            $name = false;
        }
        else
        {
            if( false === $check->checkForm($data_post['user']))
            {
                $data->setmArray('ERROR_NAME', 'Wrong data');
                $name = false;
            }
            else
            {
                $name = $data_post['user'];
            }
        }


        //$data->setmArray('error_name', $check->getErrors());
        //$name = $check->getValue();
        //$check->checkPass($_POST['password']);
        //$data->setmArray('error_pass', $check->getErrors());
        //$pass = $check->getValue();
        $data->setmArray('TITLE', 'Booker');
        $data->setPage('lib/views/main.html');
        if (false !== $name && false !== $pass)
        {
            //$link = new MyPdo();
            //$name = $link->checkUser($name);
            if (false === $name)
            {
                $data->setmArray('ERROR_FORM', 'Wrong name or password');
            }
            else
            {
                $pass=md5($name['key_user'].$pass);
                if ( $name['passwd_user'] == $pass)
                {
                    $_SESSION['user_id'] = $name['id_user'];
                    $_SESSION['login_user'] = $name['login_user'];
       /*             if (isset($save_me)) and 'yes' == $save_me)
                    {
                        $cookie_code = generateCode;

                    }*/
                //    $sess = Session::getInstance();
               //     $b = $sess->setSession($name, md5('lalala'));
                //    $a = $sess->getSession($name);
                    //var_dump($_SESSION);
                    $data->setPage('lib/views/calendar.html');
                }
                else
                {
                    $data->setmArray('%ERROR_FORM%', 'Wrong name or password');
                }
            }
        }

    }
}

?>
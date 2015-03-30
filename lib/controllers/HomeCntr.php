<?php
class HomeCntr{
    function indexAction(){

        $fc = FrontCntr::getInstance();
        $params = $fc->getParams();
        if(isset($params[page]))
        {
            $page = (int)$params[page];
            if($page < 1) $page = 1;
        }else{
            $page = 1;
        }
        $perpage = 6;
        //var_dump($params);
        $myPdo = MyPdo::getInstance();



        $count = $myPdo->select('COUNT(book_id) as count_rows')
            ->table('books')
            ->where('visible', '1')
            ->query()
            ->commit();

        $count_rows = $count[0][count_rows];
        $page_count = ceil($count_rows / $perpage);
        if(!$page_count) $page_count = 1;
        if($page > $page_count) {$page = $page_count;}
        $start_pos = ($page - 1) * $perpage;
        $mainPage = $myPdo->select('book_id, book_name, img, price, visible')
            ->table('books')
            ->where('visible','1')
            ->limit($start_pos, $perpage)
            ->query()
            ->commit();

        $dataPalette = new Palette();
        $dataMainPage = ($dataPalette->mainPage($mainPage));




        $dataNavPage = ($dataPalette->pageNav($page, $page_count));

        $data = DataCont::getInstance();
        $data->setmArray('TITLE', 'Books');
        $data->setmArray('BOOKLIST', $dataMainPage);
        $data->setmArray('PAGENAV', $dataNavPage);
        $data->setPage('lib/views/main.html');
        $data->setData($params);
//        $arr = array(1=>'mimi',2=>'bl');
 //       $data->setData($arr);
//../views/main.html
//        $view = new View();
//       $view->name = $params['name'];
//        $result = $view->render('../views/main.html');
//        $fc->setBody($result);
    }

    function authorsAction()
    {
        $fc = FrontCntr::getInstance();
        $params = $fc->getParams();
        $data = DataCont::getInstance();
        $myPdo = MyPdo::getInstance();

        $authorsPage = $myPdo->select('DISTINCT authors_name, authors_id')
            ->table("books, authors INNER JOIN book_a WHERE books.book_id = book_a.b_id and authors.authors_id = book_a.a_id and visible='1' ORDER BY authors_name")
            //->where('visible', '1')
            ->query()
            ->commit();

        $dataPalette = new Palette();
        $authorsPage = ($dataPalette->authorsPage($authorsPage));

        $data->setmArray('TITLE', 'Authors');
        $data->setmArray('BOOKLIST', $authorsPage);
        $data->setPage('lib/views/main.html');
        $data->setData($params);

    }

    function genresAction()
    {
        $fc = FrontCntr::getInstance();
        $params = $fc->getParams();
        $data = DataCont::getInstance();
        $myPdo = MyPdo::getInstance();

        $genresPage = $myPdo->select('DISTINCT genre_name, genre_id')
            ->table("books, genre INNER JOIN book_g WHERE books.book_id = book_g.b_id and genre.genre_id = book_g.g_id and visible='1'")
            //->where('visible', '1')
            ->query()
            ->commit();

        $dataPalette = new Palette();
        $genresPage = ($dataPalette->genresPage($genresPage));

        $data->setmArray('TITLE', 'Genres');
        $data->setmArray('BOOKLIST', $genresPage);
        $data->setPage('lib/views/main.html');
        $data->setData($params);

    }

    function detailsAction()
    {
        $fc = FrontCntr::getInstance();
        $params = $fc->getParams();
        $book_id = abs((int)$params[id]);
        $data = DataCont::getInstance();
        $myPdo = MyPdo::getInstance();
        if($book_id)
        {
            $detailsPage = $myPdo->select('DISTINCT book_id, price, book_name, img, content, GROUP_CONCAT(DISTINCT authors_name) as authors_name, GROUP_CONCAT(DISTINCT genre_name) as genre_name')
                ->table("books, authors, genre INNER JOIN book_a, book_g WHERE books.book_id = book_a.b_id and authors.authors_id = book_a.a_id and books.book_id = book_g.b_id and genre.genre_id = book_g.g_id and book_id = $book_id and visible='1' GROUP BY book_name")
                //->where('visible', '1')
                ->query()
                ->commit();
        }

        $dataPalette = new Palette();
        $detailsPage = ($dataPalette->detailsPage($detailsPage[0]));

        $data->setmArray('TITLE', 'Details');
        $data->setmArray('BOOKLIST', $detailsPage);
        $data->setPage('lib/views/main.html');
        $data->setData($params);

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
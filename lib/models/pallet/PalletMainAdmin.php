<?php
class PalletMainAdmin implements iPallet
{
    private $query;
    private $data;
    public $nav;
    private $session;
    private $arrayPlace;
    private $bookarr;
    private $subs;

    public function __construct()
    {
        $this->query = new QueryToDb();
        $this->data = DataCont::getInstance();
        $this->session = Session::getInstance();
        $this->subs = new Substitution();
    }

    function index()
    {
        $params = $this->data->getParam();
        $nav = new PalleteNav($params);
        $start_pos = $nav->getStartPage();
        $perpage = $nav->getPerPage();
        $page = $nav->getPageNav();
        $page_count = $nav->getPageCount();
        $uri = $nav->getUriPageNav();
        $this->navBar($uri, $page, $page_count);

        $arr = $this->query->getBookForOneMainPage($start_pos, $perpage);
        return $this->bookCreate($arr);
    }



    function bookCreate($arr)
    {
        $data = '';
        foreach ($arr as $books) {
            $this->bookarr['BOOK_ID'] = $books['book_id'];
            $this->bookarr['BOOK_NAME'] = $books['book_name'];
            $this->bookarr['BOOK_IMG'] = $books['img'];
            $this->bookarr['BOOK_PRICE'] = $books['price'];
            $data.= $this->subs->templateRender('templates/admin/book.html',$this->bookarr);
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
        if(!isset($arr))
        {
            return false;
        }
        return $this->bookCreate($arr);

    }

    function delete()
    {
        $id_book = $this->data->getParam();
        $this->query->deleteBook($id_book);
        header('Location: /Admin/index/');
    }

    function genreDelete()
    {
        $id_genre = $this->data->getParam();
        $this->query->deleteGenre($id_genre);
        header('Location: /Admin/editgenre/');
    }

    function authorDelete()
    {
        $id_author = $this->data->getParam();
        $this->query->deleteAuthor($id_author);
        header('Location: /Admin/editauthor/');
    }



    function editauthor()
    {
        $id_author = $this->data->getVal();
        if(0 !== $id_author)
        {
            $arr_edit = $this->query->getAuthorName($id_author);
        }

        if(isset($_POST['name_author']))
        {
            $new_author = $this->data->getParam();
            if (0 !== $id_author)
            {
                $this->query->setAuthorNewName($new_author, $id_author);
            }
            else
            {
                $this->query->setAuthorNew($new_author);
            }
            header('Location: /Admin/editauthor/');
        }
        else
        {
        $arr = $this->query->getAuthorsName();
        $cnt=1;
            $this->bookarr['AUTHEDIT'] = $arr_edit[0]['authors_name'];
        foreach($arr as $authors)
        {
            $this->bookarr['CNT'] = $cnt;
            $this->bookarr['AUTHNAME'] = $authors['authors_name'];
            $this->bookarr['AUTHID'] = $authors['authors_id'];
            $this->bookarr['LISTAUTHORS'].= $this->subs->templateRender('templates/admin/authorlist.html',$this->bookarr);
            $cnt++;
        }
            $data = $this->subs->templateRender('templates/admin/authoredit.html',$this->bookarr);
        }
        return $data;
    }

    function editgenre()
    {
        $id_genre = $this->data->getVal();
        if(0 !== $id_genre)
        {
            $arr_edit = $this->query->getGenreName($id_genre);
        }

        if(isset($_POST['name_genre']))
        {
            $new_genre = $this->data->getParam();
            if(0 !== $id_genre)
            {
                $this->query->setGenreNewName($new_genre, $id_genre);
            }
            else
            {
                $this->query->setGenreNew($new_genre);
            }
            header('Location: /Admin/editgenre/');
        }
        else
        {
        $arr = $this->query->getGenresName();
        $cnt=1;
            $this->bookarr['GENREEDIT'] = $arr_edit[0]['genre_name'];


        foreach($arr as $genres)
        {
            $this->bookarr['CNT'] = $cnt;
            $this->bookarr['GENRENAME'] = $genres['genre_name'];
            $this->bookarr['GENREID'] = $genres['genre_id'];
            $this->bookarr['GENRELIST'].= $this->subs->templateRender('templates/admin/genrelist.html',$this->bookarr);
            $cnt++;
        }
        $data = $this->subs->templateRender('templates/admin/genreedit.html',$this->bookarr);;
        }
        return $data;
    }

    function listAuthors()
    {
        $authors = $this->query->getAuthorsName();
        $data = '';
         foreach($authors as $val)
         {
            $data.='<option>'.$val['authors_name'].'</option>';
         }
        return $data;
    }

    function listGenre()
    {
        $authors = $this->query->getGenresName();
        $data = '';
        foreach($authors as $val)
        {
            $data.='<option>'.$val['genre_name'].'</option>';
        }
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
        $data.='<img src="'.SRC_IMG_ADM.$arr['img'].'"></div>';
        $data.='<div id="detailsText">';
        $data.='<h2>Product Details</h2>';
        $data.='<p class="detailsfirst"><b>Author: </b>'.$arr['authors_name'].'</p>';
        $data.='<p><b>Genre: </b>'.$arr['genre_name'].'</p>';
        $data.=$arr['content'].'</div></div>';
        return $data;
    }

    function navBar($uri, $page, $page_count)
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
        return $this->nav;
    }

}
?>

<?php
class PalletEditAdmin implements iPallet
{
    private $query;
    private $data;
    public $nav;
    private $bookarr;
    private $subs;

    public function __construct()
    {
        $this->fc = FrontCntr::getInstance();
        $this->data = DataCont::getInstance();
        $this->data->setFlag($this->fc->getAction());
        $this->check = new Validator();
        $this->myPdo = MyPdo::getInstance();
        $this->session = Session::getInstance();
        $this->cookie = new Cookie();
        $this->query = new QueryToDb();
        $this->subs = new Substitution();
    }

    public function index()
    {

    }

    public function update()
    {
        $post = $this->data->getPost();
        $list_param = $this->data->getParam();
        $id_book = $this->data->getVal();
        //info
        if(false === $post) {
            $arr = $this->query->getAllDataBook($id_book);

            $this->bookarr['BOOKNAME'] = $arr[0]['book_name'];
            $this->bookarr['PRICE'] = $arr[0]['price'];
            $this->bookarr['CONTENT'] = $arr[0]['content'];
            $this->bookarr['IMG'] = $arr[0]['img'];

            $auth = explode(",", $arr[0]['authors_name']);
            $authorlist='';
            foreach ($auth as $alist) {
                $authorlist .= "<p><input type='checkbox' name='alist[]' value='$alist'>$alist</p>";
            }
            $this->bookarr['AUTHORLIST'] = $authorlist;

            $genr = explode(",", $arr[0]['genre_name']);
            $genlist='';
            foreach ($genr as $glist) {
                $genlist .= "<p><input type='checkbox' name='glist[]' value='$glist'>$glist</p>";
            }
            $this->bookarr['GENRELIST'] = $genlist;
            $this->bookarr['LISTAUTHORS'] = $this->listAuthors();
            $this->bookarr['LISTGANRE'] = $this->listGenre();

        }
        else {

            if (1 == $list_param['delbaseimg']) {
                $this->query->setNoImg($id_book);
            }

            if ( ! empty($list_param['alist'])) {
                $authlist = $list_param['alist'];
                foreach ($authlist as $alist) {
                    $rez = $this->query->getBookAuthor($alist);
                    $id_authtor = $rez[0]['authors_id'];
                    $this->query->deleteBookAuthor($id_book, $id_authtor);
                }
            }

            if ( ! empty($list_param['glist'])) {
                $genlist = $list_param['glist'];
                foreach ($genlist as $glist) {

                    $rez = $this->query->getBookGenre($glist);
                    $id_genre = $rez[0]['genre_id'];
                    $this->query->deleteBookGenre($id_book, $id_genre);
                }
            }

            //обновление данныйх в книге
            $book_name = $list_param['book_name'];
            $price = round(floatval(preg_replace("#,#", ".", $list_param['price'])), 2);
            $content = $list_param['content'];
            $this->query->setNewDataToBook($book_name, $price, $content, $id_book);

//Add authors (edit book)
            if ( ! empty($list_param['authors_name'])) {
                $author_name = $list_param['authors_name'];
                foreach ($author_name as $authors_name) {
                    $rez = $this->query->getAuthorsList($authors_name);
                    $id_auth= $rez[0]['authors_id'];
                    $this->query->setAuthorToBook($id_auth, $id_book);
                }
            }
//Add genre (edit book)

            if ( ! empty($list_param['genre_name'])) {
                $genr_name = $list_param['genre_name'];
                foreach ($genr_name as $genre_name) {
                    $rez = $this->query->getGenresList($genre_name);
                    $id_genre = $rez[0]['genre_id'];
                    $this->query->setGenreToBook($id_genre, $id_book);
                }
            }
            header('Location: '.PATH.'Admin/index/');
        }

        $data= $this->subs->templateRender('templates/admin/editAdmin.html',$this->bookarr);

        return $data;
    }
    private function listAuthors()
    {
        $authors = $this->query->getAuthorsName();
        $data = '';
        foreach($authors as $val)
        {
            $data.='<option>'.$val['authors_name'].'</option>';
        }
        return $data;
    }

    private function listGenre()
    {
        $authors = $this->query->getGenresName();
        $data = '';
        foreach($authors as $val)
        {
            $data.='<option>'.$val['genre_name'].'</option>';
        }
        return $data;
    }
}
?>
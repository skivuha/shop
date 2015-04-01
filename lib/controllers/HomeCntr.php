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
            ->table('shop_books')
            ->where(array('visible'=>1))
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
        $this->data->setParam($params);
        $this->data->setPage('lib/views/main.html');
        $this->data->setFlag($this->fc->getAction());

//        $dataSortPage = ($this->dataPalette->mainPage($sortPage));


//        $this->data->setmArray('BOOKLIST', $dataSortPage);

//        $this->data->setData($params);
    }

    function authorsAction()
    {
        $this->data->setPage('lib/views/main.html');
        $this->data->setFlag($this->fc->getAction());
    }

    function genresAction()
    {
        $this->data->setPage('lib/views/main.html');
        $this->data->setFlag($this->fc->getAction());
    }

    function detailsAction()
    {
        $params = $this->fc->getParams();
        $book_id = abs((int)$params[id]); //validator
        $this->data->setPage('lib/views/main.html');
        $this->data->setFlag($this->fc->getAction());
        $this->data->setParam($book_id);
    }
}

?>

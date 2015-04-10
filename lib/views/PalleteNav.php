<?php
class PalleteNav implements iPallet
{
    private $perpage = PERPAGE;
    private $myPdo;
    private $page_count;
    private $page;
    private $start_pos;
    private $fc;
    private $uri;
    private $query;

    public function __construct($params)
    {
        $this->fc = FrontCntr::getInstance();
        $this->myPdo = MyPdo::getInstance();
        $this->pageFromParams($params);
        $this->query = new QueryToDb();
        $this->startPage();
        $this->pageNav();
    }

    public function index()
    {}
    
    function pageFromParams($params)
    {
        if(isset($params['page']))
        {
            $page = abs((int)$params['page']);
            if($page < 1) $page = 1;
        }
        else
        {
            $page = 1;
        }
        return $this->page = $page;
    }

    private function startPage()
    {
        $this->page_count = ceil($this->query->getCountRow() / $this->perpage);
        if(!$this->page_count) $this->page_count = 1;
        if($this->page > $this->page_count)
        {
            $this->page = $this->page_count;
        }
        $this->start_pos = ($this->page - 1) * $this->perpage;
        return $this->start_pos;
    }

    public function getStartPage()
    {
        return $this->start_pos;
    }

    public function getPerPage()
    {
        return $this->perpage;
    }
    public function getUriPageNav()
    {
        return $this->uri;
    }
    public function getPageNav()
    {
        return $this->page;
    }
    public function getPageCount()
    {
        return $this->page_count;
    }

    function pageNav()
    {
        $request = $_SERVER['REQUEST_URI'];
        $splits = explode('/', trim($request, '/'));
        $controller = !empty($splits[CONTROLLER]) ? ucfirst($splits[CONTROLLER]) . 'Cntr' : 'Home';
        $action = !empty($splits[ACTION]) ? $splits[ACTION] . 'Action' : 'index';
        $params = $this->fc->getParams();
        if(!is_array($params)){
            $params = array();
        }
        if(!$splits[CONTROLLER] || !$splits[ACTION])
        {
            $this->uri = '';
            $this->uri.="$controller/$action";
        }
        else
        {
            $nameController = $splits[CONTROLLER];
            $nameAction = $splits[ACTION];
            $this->uri = '';
            $this->uri.="$nameController/$nameAction";
            foreach($params as $key => $value)
            {
                if($key != 'page' ) $this->uri .= "/$key/$value";
            }
        }
        return $this->uri;
    }
}

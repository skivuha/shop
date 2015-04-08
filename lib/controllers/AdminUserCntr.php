<?php
class AdminUserCntr implements iController
{
    private $fc;
    private $data;
    private $check;
    private $myPdo;
    private $session;
    private $cookie;

    public function __construct()
    {
        $this->fc = FrontCntr::getInstance();
        $this->data = DataCont::getInstance();
        $this->data->setFlag($this->fc->getAction());
        $this->check = new Validator();
        $this->myPdo = MyPdo::getInstance();
        $this->session = Session::getInstance();
        $this->cookie = new Cookie();
    }

    function indexAction()
    {
        $this->data->setPage('templates/admin/fixAdmin.html');
    }

    function orderAction()
    {
        if (isset($_POST['sel']))
        {
            $this->data->setPost(true);
            $this->data->setVal($_POST);
        }
        $params = $this->fc->getParams();
        $this->data->setParam($params);
        $this->data->setPage('templates/admin/fixAdmin.html');
    }
}
?>
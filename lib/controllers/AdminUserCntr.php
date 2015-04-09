<?php
class AdminUserCntr implements iController
{
    private $fc;
    private $data;
    private $check;

    public function __construct()
    {
        $this->fc = FrontCntr::getInstance();
        $this->data = DataCont::getInstance();
        $this->data->setFlag($this->fc->getAction());
        $this->check = new Validator();
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
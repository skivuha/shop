<?php
class CartCntr
{
    private $fc;
    private $data;

    public function __construct()
    {
        $this->fc = FrontCntr::getInstance();
        $this->data = DataCont::getInstance();
        $this->data->setFlag($this->fc->getAction());
        $this->valid();

    }

    function indexAction()
    {
        $this->data->setPage('lib/views/cart.html');
    }

    function valid()
    {
        if(false == $this->data->getUser())
        {
            header("Location: /");
        }
    }
}
?>
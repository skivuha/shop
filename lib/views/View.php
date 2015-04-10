<?php
class View
{
    private $file;
    private $substitution;
    private $data;
    private $flag;
    private $lang;

    public function __construct()
    {
        $this->substitution = new Substitution();
        $this->data = DataCont::getInstance();
        $this->file = $this->data->getPage();
        $this->flag = $this->data->getFlag();
        $this->lang = $this->data->getLang();

    }

    /**
     * drowPage 
     * 
     */
    public function drowPage()
    {
            $this->substitution->choisePalett($this->file, $this->flag);
            header("Content-Type: text/html; charset = UTF-8");
            echo $this->substitution->drowPage();
    }
}
?>

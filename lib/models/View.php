<?php
class View
{
    private $file;
    private $mArray;
    private $substitution;
    private $data;

    function __construct()
    {
        $this->substitution = new Substitution();
        $this->file = DataCont::getInstance()->getPage();
        $this->mArray = DataCont::getInstance()->getmArray();
    }

    function choisePalett()
    {
        //$this->file
    }

    function drowPage()
    {
        $this->data = $this->substitution->setFileTemplate($this->file);
        $this->substitution->addToReplace($this->mArray);
        $this->substitution->templateRender();
        echo $this->file;
    }
}
?>
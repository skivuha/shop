<?php
class View
{
    private $file;
    private $mArray;
    private $substitution;
    private $data;
    private $flag;
    private $pallet;
    private $param;

    function __construct()
    {
        $this->substitution = new Substitution();
        $this->pallet = new Palette();
        $this->data = DataCont::getInstance();
        $this->file = $this->data->getPage();
        $this->flag = $this->data->getFlag();
        $this->param = $this->data->getParam();
    }

    function choisePalett()
    {
        if('main' === $this->flag)
        {
            $this->mArray['PAGENAV'] = $this->pallet->$flag($this->param);
        }
        $this->flag = str_replace('Action','', $this->flag);
        $flag = str_replace('"','',$this->flag);
        $this->mArray['BOOKLIST'] = $this->pallet->$flag($this->param);

    }




    function drowPage()
    {
        $this->data = $this->substitution->setFileTemplate($this->file);
        $this->choisePalett();
        $this->substitution->addToReplace($this->mArray);
        $this->substitution->templateRender();

    }
}
?>
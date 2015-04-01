<?php
class View
{
    private $file;
    private $mArray;
    private $substitution;
    private $data;
    private $flag;
    private $palletMain;
    private $param;

    function __construct()
    {
        $this->substitution = new Substitution();
        $this->palletMain = new PaletteMain();
        $this->palletAuth = new PalletAuth();
        $this->data = DataCont::getInstance();
        $this->file = $this->data->getPage();
        $this->flag = $this->data->getFlag();
        $this->param = $this->data->getParam();
        $this->mArray = $this->data->getmArray();
    }

    function choisePalett()
    {
        $file = basename($this->file, '.html');
        $this->flag = str_replace('Action','', $this->flag);
        $flag = str_replace('"','',$this->flag);
        if('main' === $file)
        {
            $this->mArray['BOOKLIST'] = $this->palletMain->$flag($this->param);
            $this->mArray['TITLE'] = ucfirst($flag);
        }
        elseif('regestration' === $file)
        {
            $this->mArray['BOOKLIST'] = $this->palletAuth->$flag($this->param);
            $this->mArray['TITLE'] = ucfirst($flag);
        }
        if ('index' === $this->flag && 'main' === $file)
        {
            $this->mArray['PAGENAV'] = $this->palletMain->getNav();
        }


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
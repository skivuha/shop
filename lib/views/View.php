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
    private $user;
    private $palletCart;
    private $cntr;
    private $palletOrder;
    private $palletCheck;
    private $lang;
    private $langArr;
    private $palletAdmin;
    private $post;

    function __construct()
    {
        $this->substitution = new Substitution();
        $this->palletMain = new PaletteMain();
        $this->palletAuth = new PalletAuth();
        $this->palletAdmin = new PalletAdmin();
        $this->palletCheck = new PalletCheck();
        $this->palletCart = new PalletCart();
        $this->palletOrder = new PalletOrder();
        $this->data = DataCont::getInstance();
        $this->file = $this->data->getPage();
        $this->cntr = $this->data->getCntr();
        $this->flag = $this->data->getFlag();
        $this->param = $this->data->getParam();
        $this->mArray = $this->data->getmArray();
        $this->user = $this->data->getUser();
        $this->lang = $this->data->getLang();
        $this->post = $this->data->getPost();
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
            if(false === $this->user)
            {
                $this->mArray['LOGINFORM'] = $this->palletMain->formLogin();
            }
            else
            {
                $this->mArray['LOGINFORM'] = $this->palletMain->formExit();
            }

        }
        elseif('regestration' === $file)
        {
            if(false === $this->user)
            {
                $this->mArray['LOGINFORM'] = $this->palletMain->formLogin();
            }
            else
            {
                $this->mArray['LOGINFORM'] = $this->palletMain->formExit();
            }
            $this->mArray['AUTH'] = $this->palletAuth->$flag($this->param);
            $this->mArray['TITLE'] = ucfirst($flag);
        }
        elseif('cart' === $file)
        {
            if(false === $this->user)
            {
                $this->mArray['LOGINFORM'] = $this->palletMain->formLogin();
            }
            else
            {
                $this->mArray['LOGINFORM'] = $this->palletMain->formExit();
            }
            $this->mArray['LISTCHOISEBOOK'] = $this->palletCart->$flag($this->param);
            $this->mArray['TITLE'] = ucfirst($flag);
        }
        elseif('checkout' === $file)
        {
            if(false === $this->user)
            {
                $this->mArray['LOGINFORM'] = $this->palletMain->formLogin();
            }
            else
            {
                $this->mArray['LOGINFORM'] = $this->palletMain->formExit();
            }
            $this->mArray['CHECKOUT'] = $this->palletCheck->$flag($this->param);
            $this->mArray['TITLE'] = ucfirst($flag);
        }
        elseif('order' === $file)
        {
            $this->mArray['ORDERLIST'] = $this->palletOrder->$flag($this->param);
            $this->mArray['LOGINFORM'] = $this->palletMain->formExit();
            $this->mArray['TITLE'] = ucfirst($flag);
        }
        elseif('mainAdmin' === $file)
        {
            $this->mArray['BOOKLIST'] = $this->palletAdmin->$flag($this->param);
            $this->mArray['TITLE'] = ucfirst($flag);
            if(false === $this->user)
            {
                $this->mArray['LOGINFORM'] = $this->palletAdmin->formLogin();
            }
            else
            {
                $this->mArray['LOGINFORM'] = $this->palletAdmin->formExit();
            }
            $this->mArray['PAGENAV'] = $this->palletAdmin->getNav();
        }
        elseif('addAdmin' === $file)
        {
            $this->mArray['LISTAUTHORS'] = $this->palletAdmin->listAuthors();
            $this->mArray['LISTGANRE'] = $this->palletAdmin->listGenre();
            if(true === $this->post)
            {
                $this->palletAdmin->addbook();
                header('Location: '.PATH.'Admin/index/');
            }
        }
        elseif('fixAdmin' === $file)
        {
            $this->mArray['USERANDORDER'] = $this->palletOrder->$flag($this->param);
            $this->mArray['TITLE'] = ucfirst($flag);
        }

        elseif('editAdmin' === $file)
        {
            $this->mArray['LISTAUTHORS'] = $this->palletAdmin->listAuthors();
            $this->mArray['LISTGANRE'] = $this->palletAdmin->listGenre();
            $arr = $this->palletAdmin->update();
            if($arr) {
                foreach ($arr as $key => $val) {
                    $this->mArray[$key] = $val;
                }
            }else{
                header('Location: '.PATH.'Admin/index/');
            }
            if(true === $this->post)
            {
                $this->palletAdmin->update();
                header('Location: '.PATH.'Admin/index/');
            }
        }

        if (('index' === $this->flag || 'logon' === $this->flag) && 'main' === $file )
        {
            $this->mArray['PAGENAV'] = $this->palletMain->getNav();
        }
        $langObj = new Lang($this->lang);
        $this->langArr = $langObj->getLangArr();
    }

    function drowPage()
    {
            $this->data = $this->substitution->setFileTemplate($this->file);
            $this->choisePalett();
            $this->substitution->addToReplace($this->mArray);
            $this->substitution->addToReplace($this->langArr);
            $this->substitution->templateRender();
    }
}
?>

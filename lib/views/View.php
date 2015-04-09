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
    private $palletAdminUser;

    function __construct()
    {
        $this->substitution = new Substitution();
        $this->palletMain = new PaletteMain();
        $this->palletAuth = new PalletAuth();
        $this->palletAdmin = new PalletAdmin();
        $this->palletCheck = new PalletCheck();
        $this->palletCart = new PalletCart();
        $this->palletOrder = new PalletOrder();
        $this->palletAdminUser = new PalletAdminUser();
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
            if(false === $this->user)
            {
                $this->substitution->setFileTemplate('templates/formlogin.html');
                $this->substitution->addToReplace($this->mArray);
                $this->mArray['LOGINFORM'] = $this->substitution->templateRender();
            }
            else
            {
                $this->mArray['LOGINMENU'] = $this->palletMain->formExit();
                $this->substitution->setFileTemplate('templates/formexit.html');
                $this->substitution->addToReplace($this->mArray);
                $this->mArray['LOGINFORM'] = $this->substitution->templateRender();
            }

            $this->mArray['BOOKLIST'] = $this->palletMain->$flag($this->param);
            $this->mArray['TITLE'] = ucfirst($flag);

        }
        elseif('logon' === $file || 'adduser' === $file)
        {
            if(false === $this->user)
            {
                $this->substitution->setFileTemplate('templates/formlogin.html');
                $this->substitution->addToReplace($this->mArray);
                $this->mArray['LOGINFORM'] = $this->substitution->templateRender();
            }
            else
            {
                $this->mArray['LOGINMENU'] = $this->palletMain->formExit();
                $this->substitution->setFileTemplate('templates/formexit.html');
                $this->substitution->addToReplace($this->mArray);
                $this->mArray['LOGINFORM'] = $this->substitution->templateRender();
            }
            $this->mArray['AUTH'] = $this->palletAuth->$flag($this->param);
            $this->mArray['TITLE'] = ucfirst($flag);

            $this->substitution->setFileTemplate($this->file);
            $this->substitution->addToReplace($this->mArray);
            $this->mArray['BOOKLIST'] = $this->substitution->templateRender();
        }
        elseif('cart' === $file)
        {
            if(false === $this->user)
            {
                $this->substitution->setFileTemplate('templates/formlogin.html');
                $this->substitution->addToReplace($this->mArray);
                $this->mArray['LOGINFORM'] = $this->substitution->templateRender();
            }
            else
            {
                $this->mArray['LOGINMENU'] = $this->palletMain->formExit();
                $this->substitution->setFileTemplate('templates/formexit.html');
                $this->substitution->addToReplace($this->mArray);
                $this->mArray['LOGINFORM'] = $this->substitution->templateRender();
            }
            $this->mArray['LISTCHOISEBOOK'] = $this->palletCart->$flag($this->param);
            $this->mArray['TITLE'] = ucfirst($flag);
            $this->substitution->setFileTemplate($this->file);
            $this->substitution->addToReplace($this->mArray);
            $this->mArray['BOOKLIST'] = $this->substitution->templateRender();
        }
        elseif('checkout' === $file || 'confirm' === $file)
        {
            if(false === $this->user)
            {
                $this->substitution->setFileTemplate('templates/formlogin.html');
                $this->substitution->addToReplace($this->mArray);
                $this->mArray['LOGINFORM'] = $this->substitution->templateRender();
            }
            else
            {
                $this->mArray['LOGINMENU'] = $this->palletMain->formExit();
                $this->substitution->setFileTemplate('templates/formexit.html');
                $this->substitution->addToReplace($this->mArray);
                $this->mArray['LOGINFORM'] = $this->substitution->templateRender();
            }
            $this->mArray['CHECKOUT'] = $this->palletCheck->$flag($this->param);
            $this->mArray['TITLE'] = ucfirst($flag);
            $this->substitution->setFileTemplate($this->file);
            $this->substitution->addToReplace($this->mArray);
            $this->mArray['BOOKLIST'] = $this->substitution->templateRender();
        }
        elseif('order' === $file)
        {
            if(false === $this->user)
            {
                $this->substitution->setFileTemplate('templates/formlogin.html');
                $this->substitution->addToReplace($this->mArray);
                $this->mArray['LOGINFORM'] = $this->substitution->templateRender();
            }
            else
            {
                $this->mArray['LOGINMENU'] = $this->palletMain->formExit();
                $this->substitution->setFileTemplate('templates/formexit.html');
                $this->substitution->addToReplace($this->mArray);
                $this->mArray['LOGINFORM'] = $this->substitution->templateRender();
            }
            $this->mArray['ORDERLIST'] = $this->palletOrder->$flag($this->param);
            $this->mArray['TITLE'] = ucfirst($flag);
            $this->substitution->setFileTemplate($this->file);
            $this->substitution->addToReplace($this->mArray);
            $this->mArray['BOOKLIST'] = $this->substitution->templateRender();
        }
        elseif('mainAdmin' === $file)
        {
            $this->mArray['BOOKLIST'] = $this->palletAdmin->$flag($this->param);
            $this->mArray['TITLE'] = ucfirst($flag);
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
            $this->mArray['USERANDORDER'] = $this->palletAdminUser->$flag($this->param);
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
            $this->choisePalett();
            $this->substitution->setFileTemplate('templates/main.html');
            $this->substitution->addToReplace($this->mArray);
            $this->substitution->addToReplace($this->langArr);
            $this->substitution->drowPage();
    }
}
?>

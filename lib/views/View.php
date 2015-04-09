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
        $this->fc = FrontCntr::getInstance();
        $this->file = $this->data->getPage();
        $this->cntr = $this->fc->getCntr();
        $this->flag = $this->data->getFlag();
        $this->param = $this->data->getParam();
        $this->mArray = $this->data->getmArray();
        $this->user = $this->data->getUser();
        $this->lang = $this->data->getLang();
        $this->post = $this->data->getPost();

    }
private function headAuth()
{
    if (false === $this->user) {
        $this->mArray['LOGINFORM'] = $this->substitution->templateRender('templates/formlogin.html', $this->mArray);
    }
    else {
        $this->mArray['LOGINMENU'] = $this->palletMain->formExit();
        $this->mArray['LOGINFORM'] = $this->substitution->templateRender('templates/formexit.html', $this->mArray);
    }
}

    function choisePalett()
    {
        $file = basename($this->file, '.html');
        $this->flag = str_replace('Action','', $this->flag);
        $flag = str_replace('"','',$this->flag);

        if('main' === $file)
        {
            $this->headAuth();
            $this->mArray['BOOKLIST'] = $this->palletMain->$flag($this->param);
            $this->mArray['TITLE'] = ucfirst($flag);
        }
        elseif('logon' === $file || 'adduser' === $file)
        {
            $this->headAuth();
            if(true !== $this->palletAuth->$flag($this->param))
            {
              $this->mArray = $this->palletAuth->$flag($this->param);
            }
            $this->mArray['TITLE'] = ucfirst($flag);
            $this->mArray['BOOKLIST'] = $this->substitution->templateRender($this->file, $this->mArray);
        }
        elseif('cart' === $file)
        {
            $this->headAuth();
            $this->mArray['LISTCHOISEBOOK'] = $this->palletCart->$flag($this->param);
            $this->mArray['TITLE'] = ucfirst($flag);
            $this->mArray['BOOKLIST'] = $this->substitution->templateRender($this->file, $this->mArray);
        }
        elseif('confirm' === $file || 'checkout' === $file)
        {
            //var_dump($flag);
            $this->headAuth();
            if('confirm' === $file)
            {
                $this->mArray = $this->palletCheck->$flag($this->param);
            }
            else {
                $this->mArray['CHECKOUT'] = $this->palletCheck->$flag($this->param);
            }
            $this->mArray['TITLE'] = ucfirst($flag);
            $this->mArray['BOOKLIST'] = $this->substitution->templateRender($this->file, $this->mArray);
        }

        elseif('order' === $file)
        {
            $this->headAuth();
            $this->mArray['ORDERLIST'] = $this->palletOrder->$flag($this->param);
            $this->mArray['TITLE'] = ucfirst($flag);
            $this->mArray['BOOKLIST'] = $this->substitution->templateRender($this->file, $this->mArray);
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
        if( 'AdminCntr' === $this->cntr || 'AdminUserCntr' === $this->cntr )
        {
            $this->substitution->setFileTemplate('templates/admin/mainAdmin.html');
        }
        else
        {
            $this->substitution->setFileTemplate('templates/main.html');
        }
            $this->substitution->addToReplace($this->mArray);
            $this->substitution->addToReplace($this->langArr);
            $this->substitution->drowPage();
    }
}
?>

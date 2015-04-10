<?php
class Substitution
{
    private $forRender;
    private $file;
    private $mArray;
    private $langArr;

    private function setFileTemplate($template)
{
    if(is_file($template))
    {
        $this->file = file_get_contents($template);
    }
    else
    {
        throw new Exception('No template file');
    }
}
    private function addToReplace($mArray)
{
    foreach($mArray as $key=>$val)
    {
        $this->forRender[$key] = $val;
    }
}

    private function headAuth()
    {
        $data = DataCont::getInstance();
        $user = $data->getUser();
        if (false === $user) {
            $this->mArray['LOGINFORM'] = $this->templateRender('templates/formlogin.html', $this->mArray);
        }
        else {
            $palletMain = new PalletMain();
            $this->mArray['LOGINMENU'] = $palletMain->formExit();
            $this->mArray['LOGINFORM'] = $this->templateRender('templates/formexit.html', $this->mArray);
        }
    }

    public function choisePalett($file, $flag)
    {
        $data = DataCont::getInstance();
        $fc = FrontCntr::getInstance();
        $lang = $data->getLang();
        $param = $data->getParam();
        $file = basename($file, '.html');
        $flag = str_replace('Action','', $flag);
        $flag = str_replace('"','',$flag);
        $file = 'pallet'.ucfirst($file);
        $file = ucfirst($file);
        $file = str_replace('"','',$file);
        $pallet = new $file();
        $this->mArray['TITLE'] = ucfirst($flag);
        $this->mArray['BOOKLIST'] = $pallet->$flag($param);
        //$this->mArray['PAGENAV'] = $this->palletMain->navig;
        $langObj = new Lang($lang);
        $this->langArr = $langObj->getLangArr();

        $cntr = $fc->getCntr();
        $this->headAuth();
        if( 'AdminCntr' === $cntr || 'AdminUserCntr' === $cntr )
        {
            $this->setFileTemplate('templates/admin/mainAdmin.html');
        }
        else
        {
            $this->setFileTemplate('templates/main.html');
        }
        $this->addToReplace($this->mArray);
        $this->addToReplace($this->langArr);
    }

    public function templateRender($file, $arr)
    {
        $this->setFileTemplate($file);
        $this->addToReplace($arr);
      if(isset($this->forRender)) {
          foreach ($this->forRender as $key => $val) {
                $this->file = preg_replace('/%#%' . $key . '%#%/i', $val, $this->file);
            }
        }else{
            $default = '';
            $this->file = preg_replace('/%#%(.*)%#%/Uis', $default, $this->file);
        }
        return $this->file;
    }

    public function drowPage()
    {
        foreach($this->forRender as $key=>$val)
        {
            $this->file = preg_replace('/%#%' .$key. '%#%/i', $val, $this->file);
        }
        foreach($this->forRender as $key=>$val)
        {
            $this->file = preg_replace('/###LANG_' .$key. '###/i', $val, $this->file);
        }
        $default = '';
        $this->file = preg_replace('/%#%(.*)%#%/Uis', $default, $this->file);
        return $this->file;
    }
}
?>

<?php
class View{

    private $forRender;
    private $file;
    private $data;
    private $mArray;

    function __construct(){
        $this->file = DataCont::getInstance()->getPage();
        $this->mArray = DataCont::getInstance()->getmArray();
        $this->data = $this->setFileTemplate($this->file);
        $this->addToReplace($this->mArray);
        $this->templateRender();
    }

    public function setFileTemplate($template)
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
    public function addToReplace($mArray)
{
    foreach($mArray as $key=>$val)
    {
        $this->forRender[$key] = $val;
    }
}

    public function setReplace($key, $val)
    {
        $this->forRender[$key] = $val;
        return true;
    }

    public function templateRender()
    {
        //echo '<pre>';
        //var_dump($this->forRender);
        foreach($this->forRender as $key=>$val)
        {
            $this->file = preg_replace('/%#%' .$key. '%#%/i', $val, $this->file);
        }
        $default = '';
        $this->file = preg_replace('/%#%(.*)%#%/Uis', $default, $this->file);
        echo $this->file;
    }
/*    public function templateRender()
    {
        foreach($this->forRender as $key=>$val)
        {
            $this->file = str_replace($key, $val, $this->file);
        }
        echo $this->file;
    }*/

/*    function render(){
        //ob_start();
        include(__DIR__.'/'.$this->file);
        //var_dump($this->file.'this view');
        //return ob_get_clean();
    }*/
}
?>
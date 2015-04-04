<?php
class Substitution
{
    private $forRender;
    private $file;

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
        foreach($this->forRender as $key=>$val)
        {
            $this->file = preg_replace('/%#%' .$key. '%#%/i', $val, $this->file);
        }
        foreach($this->forRender as $key=>$val)
        {
            $this->file = preg_replace('/%#%' .$key. '%#%/i', $val, $this->file);
        }
        $default = '';
        $this->file = preg_replace('/%#%(.*)%#%/Uis', $default, $this->file);
        echo $this->file;
    }
}
?>
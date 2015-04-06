<?php
class Lang
{
    private $file;
    private $data;

    public function __construct($lang)
    {
        $this->file = simplexml_load_file('templates/lang/' . $lang . '.strings');
        $this->loadData();
    }

    private function loadData()
    {
        $lang_key = $lang_value = array();
        foreach ($this->file as $key => $val) {
            foreach((array)$val as $key=>$val) {
                if('KEY' == $key){
                    $lang_key[] = $val;
                }
                else
                {
                    $lang_value[] = $val;
                }
            }
        }
        $this->data = array_combine($lang_key, $lang_value);
        var_dump($this->data);
    }

    public function getLang($key)
    {
        foreach ($this->data as $key => $val) {
            foreach ($val as $key => $val) {

            }
        }
    }
}
?>

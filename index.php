<?php
require_once 'config.php';
require_once 'lib/function.php';
set_include_path(get_include_path()
    .PATH_SEPARATOR.'lib/controllers'
    .PATH_SEPARATOR.'lib/models'
    .PATH_SEPARATOR.'lib/views');
function __autoload($class)
{
    if(isset_file($class.'.php'))
    require_once($class.'.php');
}
    
$front = FrontCntr::getInstance();
$front->route();

?>
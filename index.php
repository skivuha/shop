<?php
require_once 'config.php';
set_include_path(get_include_path()
    .PATH_SEPARATOR.'lib/controllers'
    .PATH_SEPARATOR.'lib/models'
    .PATH_SEPARATOR.'lib/views');
function __autoload($class){
    require_once $class.'.php';
}
$front = FrontCntr::getInstance();
$front->route();

//echo $front->getBody();

/*include_once 'config.php';
include_once 'templates/view.php';
include 'lib/Controller.php';*/
?>
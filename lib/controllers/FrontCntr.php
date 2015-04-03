<?php

class FrontCntr
{
    protected $_controller, $_action, $_params, $_body;
    private $session;
    static $_instance;

    //синглтон
    public static function getInstance()
    {
        if (!(self::$_instance instanceof self))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    //конструктор
    private function __construct()
    {
        //стартуем сессию
        $this->session = Session::getInstance();
        $request = $_SERVER['REQUEST_URI'];
        //var_dump($_SERVER['REQUEST_URI']);
        //сприлим по /
        $splits = explode('/', trim($request, '/'));
        //выбор контроллера
        $this->_controller = !empty($splits[CONTROLLER]) ? ucfirst($splits[CONTROLLER]) . 'Cntr' : 'HomeCntr';
        //выбор экшена
        $this->_action = !empty($splits[ACTION]) ? $splits[ACTION] . 'Action' : 'indexAction';
   /*     if (!empty($splits[ACTION]))
        {
            $this->_action = $splits[ACTION].'Action';
        }
        else
        {
            if(!empty($_POST['login']))
            {
                $this->_action = 'formAction';
            }
            else
            {
                $this->_action = 'indexAction';
            }
        }*/
        //если есть параметры и значения
        if (!empty($splits[PARAM])) {
            $keys = $values = array();
            for ($i = PARAM, $cnt = count($splits); $i < $cnt; $i++) {
                if (0 == $i % 2) {
                    //четное параметр
                    $keys[] = $splits[$i];
                } else {
                    //не четное значение параметра
                    $values[] = $splits[$i];
                }
            }
            $this->_params = array_combine($keys, $values);
        }
    }

    //роутер
    public function route()
    {
        new Check();
        //проверяем контроллер на существование данного класса
        if (class_exists($this->getCntr())) {
            //делаем экземпляр класса рефлекшн класс
            $rc = new ReflectionClass($this->getCntr());
            // наш ли это контроллер
            //if($rc->implementsInterface('iController')){
            //проверяем на наличие нужного метода
            if ($rc->hasMethod($this->getAction()))
                $controller = $rc->newInstance();
            //получаем метод этого объекта
            $method = $rc->getMethod($this->getAction());
            // передаем управление конктретному контроллеру
            $method->invoke($controller);
            //}

            $view = new View();
            $view->drowPage();

        }
    }

    public function getParams()
    {
        return $this->_params;
    }

    public function getCntr()
    {
        return $this->_controller;
    }

    public function getAction()
    {
        return $this->_action;
    }

}
?>

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
        $this->_controller = !empty($splits[0]) ? ucfirst($splits[0]) . 'Cntr' : 'HomeCntr';
        //выбор экшена
       // $this->_action = !empty($splits[1]) ? $splits[1] . 'Action' : 'indexAction';
        if (!empty($splits[1]))
        {
            $this->_action = $splits[1].'Action';
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
        }
        //если есть параметры и значения
        if (!empty($splits[2])) {
            $keys = $values = array();
            for ($i = 2, $cnt = count($splits); $i < $cnt; $i++) {
                if ($i % 2 == 0) {
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

    public function getBody()
    {
        return $this->_body;
    }

    public function setBody($body)
    {
        $this->_body = $body;
    }
}
?>
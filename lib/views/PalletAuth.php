<?php
class PalletAuth implements iPallet
{
    private $myPdo;
    private $data;

    public function __construct()
    {
        $this->myPdo = MyPdo::getInstance();
        $this->data = DataCont::getInstance();
    }

    public function index()
    {}
    
    public function adduser()
    {
        $data = '
%#%STATUS%#%
                        <form class="simple-form" name="frm" id="formVal" method="POST">
                            <div class="row">
                                <div>
                                    <label>Name: <span>%#%ERROR_NAME%#%</span></label>
                                    <input type="text" class="form-control" required name="username" />
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div>
                                    <label>Password: <span>%#%ERROR_PASS%#%</span></label>
                                    <input type="password" class="form-control" required name="password" />
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div>
                                    <label>E-mail: <span>%#%ERROR_EMAIL%#%</span></label>
                                    <input type="email" class="form-control" required id="email" name="email" />
                                </div>
                            </div>
                            <br />
                            <br />
                            <div class="row col-sm-offset-3">
                                <div>
                                    <button class="btn btn-default" type="reset">Reset</button>
                                    <input type="submit" name="regNew" class="btn btn-default" value="Send" />
                                </div>
                            </div>
                        </form>
        ';
        return $data;

    }
    function logout(){}
    public function logon()
    {
        $data ='

<form class="simple-form" name="auth" id="formVal" method="POST">
                            <div class="row">
                            <a href="./Regestration/adduser/">Regestration</a>
                            </div>
                            <br />
                            <div class="row">
                                <div>
                                    <label>E-mail:</label>
                                    <input type="email" class="form-control" placeholder="Enter email" id="email" name="email" />
                                </div>
                            </div>
                            <div class="row">
                                <div>
                                    <label>Password:</label>
                                    <input type="password" placeholder="Password" class="form-control" name="password" />
                                </div>
                            </div>
                            <span>%#%ERRORLOGIN%#%&nbsp</span>
                            <br />
                            <br />
                            <div class="row col-sm-offset-3">
                                <div>
                                    <a href="./" class="btn btn-default">Back</a>
                                    <button class="btn btn-default" name="signin">Log in</button>
                                </div>
                            </div>

                            <div class="row">
                                <div id="rememberMe">
                                    <div class="checkbox"><label><input type="checkbox" name="remember"> Remember me</label></div>
                                </div>
                            </div>
                        </form>
            ';
            return $data;
    }



}
?>

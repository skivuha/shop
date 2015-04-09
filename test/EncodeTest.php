<?php
include("lib/models/Encode.php");
class EncodeTest extends PHPUnit_Framework_TestCase {
    function setUp()
    {
        $this->encode =new Encode();
        $this->string = 'mimimi';
        $this->number = 4;
        $this->array = array();
    }

    function tearDown()
    {
        $this->encode = null;
    }

}
 
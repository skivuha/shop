<?php
include("lib/models/Validator.php");
class ValidatorTest extends PHPunit_Framework_TestCase

{
  protected $validator;
  protected $string;
  protected $number;
  protected $array;

  function setUp()
  {
    $this->validator =new Validator();
    $this->string = 'mimimi';
    $this->number = 4;
    $this->array = array();

  }

  function tearDown()
  {
    $this->calc=NULL;
//    $this->sub=NULL;
//    $this->sum=NULL;
//    $this->div=NULL;
//    $this->mul=NULL;
  }

//  public function testSumConditionEquals()
//  {
//    $this->assertEquals($this->sum, $this->calc->sum());
//  }

  public function testClearDataTrueString()
  {
    $this->assertTrue(is_string($this->validator->clearData($this->string)));
  }

  public function testClearDataFalseNumber()
  {
    $this->assertTrue(is_string($this->validator->clearData($this->number)));
  }
  public function testClearDataFalseArray()
  {
    $this->assertFalse(is_string($this->validator->clearData($this->array)));
  }
  /*
  public function testSumConditionFalse()
  {
    $this->assertFalse($this->sum != $this->calc->sum());
  }

  public function testSubConditionEquals()
  {
    $this->assertEquals($this->sub, $this->calc->sub());
  }
  
  public function testSubConditionTrue()
  {
    $this->assertTrue($this->sub == $this->calc->sub());
  }

  public function testSubConditionFalse()
  {
    $this->assertFalse($this->sub != $this->calc->sub());
  }

  public function testMulConditionEquals()
  {
    $this->assertEquals($this->mul, $this->calc->mul());
  }

  public function testMulConditionEqualsTrue()
  {
    $this->assertTrue($this->mul == $this->calc->mul());
  }
  public function testMulConditionEqualsFalse()
  {
    $this->assertFalse($this->mul != $this->calc->mul());
  }
  
  public function testSetAnotEmpty()
  {
    $this->calc->setA('');
    $this->assertFalse($this->calc->getA());
  
    $this->calc->setA(5);
    $this->assertTrue(null !== $this->calc->getA());
  }  
 
  public function testSetAnotArray()
  {
    $this->calc->setA(array(5));
    $this->assertFalse($this->calc->getA());
  }

  public function testSetBnotEmpty()
  {
    $this->calc->setB('');
    $this->assertFalse($this->calc->getB());
  
    $this->calc->setB(5);
    $this->assertTrue(null !== $this->calc->getB());
  }  
 
  public function testSetBnotArray()
  {
    $this->calc->setB(array(5));
    $this->assertFalse($this->calc->getB());
  }
  
  public function testSetBnotString()
  {
    $this->calc->setB('mimimi');
    $this->assertFalse($this->calc->getB());
  }


  public function testSetAnotString()
  {
    $this->calc->setA('mimimi');
    $this->assertFalse($this->calc->getA());
  }

  public function testDivConditionDivByZero()
  {
    
    $this->calc->setA(1);
    $this->calc->setB(0);
    $this->assertFalse($this->calc->div());
  }*/
}
?>

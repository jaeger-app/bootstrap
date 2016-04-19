<?php
/**
 * Jaeger
 *
 * @copyright	Copyright (c) 2015-2016, mithra62
 * @link		http://jaeger-app.com
 * @version		1.0
 * @filesource 	./tests/BootstrapTest.php
 */
namespace JaegerApp\tests;

use JaegerApp\Bootstrap; 

/**
 * Jaeger - Bootstrap object Unit Tests
 *
 * Contains all the unit tests for the \mithra62\Bootstrap object
 *
 * @package Jaeger\Tests
 * @author Eric Lamb <eric@mithra62.com>
 */
class BootstrapTest extends \PHPUnit_Framework_TestCase
{   
    public function testSetLangPathReturnInstance()
    {
        $bootstrap = new Bootstrap();
        $this->assertInstanceOf('\JaegerApp\Bootstrap', $bootstrap->setLangPath(__DIR__));
    }
    
    public function testLangPathDefaultValue()
    {
        $bootstrap = new Bootstrap();
        $this->assertTrue(is_array($bootstrap->getLangPath()));
        $this->assertCount(1, $bootstrap->getLangPath());
    }
    
    public function testSetLangPathValues()
    {
        $bootstrap = new Bootstrap();
        $this->assertCount(3, $bootstrap->setLangPath(__DIR__)->setLangPath('fdsafdsafdsa')->getLangPath());
    }
    
    public function testDefaultDbConfigProperty()
    {
        $bootstrap = new Bootstrap();
        $this->assertTrue(is_array($bootstrap->getDbConfig()));
        $this->assertCount(0, $bootstrap->getDbConfig());
    }
    
    public function testSetDbConfigReturnInstance()
    {
        $bootstrap = new Bootstrap();
        $this->assertInstanceOf('\JaegerApp\Bootstrap', $bootstrap->setDbConfig(array()));
    }
    
    public function testSetDbConfigValue()
    {
        $bootstrap = new Bootstrap();
        $config = array('db' => 'test', 'host' => 'myhost.com');
        $this->assertEquals($config, $bootstrap->setDbConfig($config)->getDbConfig());
    }
}
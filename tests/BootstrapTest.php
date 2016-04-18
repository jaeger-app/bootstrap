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
    
    public function testContainerPropertyInstance()
    {
        $this->assertClassHasAttribute('container', '\JaegerApp\Bootstrap');
        
        $m62 = new Bootstrap();
        $this->assertInstanceOf('\Pimple\Container', $m62->getContainer());
    }
    
    public function testSetContainerReturnInstance()
    {
        $bootstrap = new Bootstrap();
        $this->assertInstanceOf('\JaegerApp\Bootstrap', $bootstrap->setContainer(new \Pimple\Container));
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
    
    public function testSetServiceReturnInstance()
    {
        $bootstrap = new Bootstrap();
        $callable = function() {
            return 'foo to the who';
        };
        $this->assertInstanceOf('\JaegerApp\Bootstrap', $bootstrap->setService('test_service', $callable));
    }
    
    public function testSetServiceCallable()
    {
        $bootstrap = new Bootstrap();
        $callable = function() {
            return 'foo to the who';
        };
        
        $bootstrap->setService('test_service', $callable);
        $services = $bootstrap->getServices();
        $this->assertArrayHasKey('test_service', $services);
        $this->assertEquals('foo to the who', $services['test_service']);
        $this->assertEquals('foo to the who', $bootstrap->getService('test_service'));
    }
    
    public function testServices()
    {
        $m62 = new Bootstrap();
        $services = $m62->getServices();
        $m62->setDbConfig(array());
        $this->assertArrayHasKey('db', $services);
        $this->assertArrayHasKey('encrypt', $services);
        $this->assertArrayHasKey('lang', $services);
        $this->assertArrayHasKey('validate', $services);
        $this->assertArrayHasKey('files', $services);
        $this->assertArrayHasKey('errors', $services);
        $this->assertArrayHasKey('license', $services);
        $this->assertArrayHasKey('email', $services);
        $this->assertArrayHasKey('view', $services);
        
        $this->assertInstanceOf('\JaegerApp\Shell', $services['shell']);
        $this->assertInstanceOf('\JaegerApp\Regex', $services['regex']);
        $this->assertInstanceOf('\JaegerApp\Db', $services['db']);
        $this->assertInstanceOf('\JaegerApp\Language', $services['lang']);
        $this->assertInstanceOf('\JaegerApp\Validate', $services['validate']);
        $this->assertInstanceOf('\JaegerApp\Files', $services['files']);
    }

    public function testDbConfig()
    {
        $m62 = new Bootstrap();
        $this->assertTrue(is_array($m62->getDbConfig()));
        $this->assertCount(0, $m62->getDbConfig());
    }
}
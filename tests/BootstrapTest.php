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

    /**
     * Ensures the Bootstrap object has all the proper attributes available
     */
    public function testBootstrapAttributes()
    {
        $this->assertClassHasAttribute('container', '\JaegerApp\Bootstrap');
        $this->assertClassHasAttribute('lang_file', '\JaegerApp\Bootstrap');
        $this->assertClassHasAttribute('lang_paths', '\JaegerApp\Bootstrap');
        $this->assertClassHasAttribute('config', '\JaegerApp\Bootstrap');
        
        $m62 = new Bootstrap();
        $this->assertObjectHasAttribute('container', $m62);
        $this->assertObjectHasAttribute('lang_file', $m62);
        $this->assertObjectHasAttribute('lang_paths', $m62);
        $this->assertObjectHasAttribute('config', $m62);
    }

    public function testPimpleInstance()
    {
        $m62 = new Bootstrap();
        $this->assertInstanceOf('\Pimple\Container', $m62->getContainer());
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
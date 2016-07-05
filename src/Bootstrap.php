<?php
/**
 * Jaeger
 *
 * @author		Eric Lamb <eric@mithra62.com>
 * @copyright	Copyright (c) 2015-2016, mithra62, Eric Lamb
 * @link		http://jaeger-app.com
 * @version		1.0
 * @filesource 	./Bootstrap.php
 */
namespace JaegerApp;

use JaegerApp\Di;
use JaegerApp\Encrypt;
use JaegerApp\Db;
use JaegerApp\Language;
use JaegerApp\Validate;
use JaegerApp\Files;
use JaegerApp\Errors;
use JaegerApp\License;
use JaegerApp\Email;
use JaegerApp\View;
use JaegerApp\Regex;
use JaegerApp\Shell;
use JaegerApp\Console; 

/**
 * Jaeger - Bootstrap Object
 *
 * Sets up the environment and needed objects
 *
 * @package Bootstrap
 */
class Bootstrap extends Di
{
    /**
     * The language file to load
     * 
     * @var array
     */
    protected $lang_file = null;

    /**
     * The paths to look for language files at
     * 
     * @var array
     */
    protected $lang_paths = array();

    /**
     * The environment config details
     * 
     * @var array
     */
    protected $config = array(
        'db' => array()
    );

    /**
     *
     * @ignore
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setLangPath(realpath(dirname(__FILE__) . '/language'));
    }

    /**
     * Sets a language paths to use
     * 
     * @param string $path            
     */
    public function setLangPath($path)
    {
        $this->lang_paths[base64_encode($path)] = $path;
        return $this;
    }

    /**
     * Returns the set language paths
     * 
     * @return \mithra62\array
     */
    public function getLangPath()
    {
        return $this->lang_paths;
    }

    /**
     * Sets the database connection details
     * 
     * @param array $config            
     */
    public function setDbConfig(array $config)
    {
        $this->config['db'] = $config;
        return $this;
    }

    /**
     * Returns the database configuration details
     * 
     * @return array
     */
    public function getDbConfig()
    {
        return $this->config['db'];
    }

    /**
     * Sets up and returns all the objects we'll use
     * 
     * @return \Pimple\Container
     */
    public function getServices()
    {
        $this->container = parent::getServices();
        $this->container['db'] = function ($c) {
            $db = new Db();
            $db->setCredentials($this->getDbConfig());
            $type = 'mysqli';
            if(class_exists('Pdo')) {
                $type = 'pdo';
            }
            
            $db->setAccessType($type);
            return $db;
        };
        
        $this->container['encrypt'] = function ($c) {
            $encrypt = new Encrypt();
            $new_key = $c['platform']->getEncryptionKey();
            $encrypt->setKey($new_key);
            return $encrypt;
        };
        
        $this->container['lang'] = function ($c) {
            $lang = new Language();
            if (is_array($this->getLangPath())) {
                foreach ($this->getLangPath() as $path) {
                    $lang->init($path);
                }
            } elseif ($this->getLangPath() != '') {
                $lang->init($this->getLangPath());
            }
            return $lang;
        };
        
        $this->container['validate'] = function ($c) {
            $validate = new Validate();
            $validate->setRegex($this->container['regex']);
            return $validate;
        };
        
        $this->container['files'] = function ($c) {
            $file = new Files();
            return $file;
        };
        
        $this->container['errors'] = function ($c) {
            $errors = new Errors();
            $errors->setValidation($c['validate']);
            return $errors;
        };
        
        $this->container['license'] = function ($c) {
            $license = new License();
            return $license;
        };
        
        $this->container['email'] = function ($c) {
            
            $email = new Email();
            $email->setView($c['view']);
            $email->setLang($c['lang']);
            return $email;
        };
        
        $this->container['view'] = function ($c) {
            $view = new View();
            $helpers = array(
                'file_size' => function ($text) {
                    return $this->container['view_helpers']->m62FileSize($text, false);
                },
                'lang' => function ($text) {
                    return $this->container['view_helpers']->m62Lang($text);
                },
                'date_time' => function ($text, $html = true) {
                    return $this->container['view_helpers']->m62DateTime($text, false);
                },
                'relative_time' => function ($date) {
                    return $this->container['view_helpers']->m62RelativeDateTime($date);
                },
                'encode' => function ($text) {
                    return $this->container['view_helpers']->m62Encode($text);
                },
                'decode' => function ($text) {
                    return $this->container['view_helpers']->m62Decode($text);
                }
            );
            
            $view->addHelper('m62', $helpers);
            return $view;
        };
        
        $this->container['regex'] = function ($c) {
            $regex = new Regex();
            return $regex;
        };
        
        $this->container['shell'] = function ($c) {
            $shell = new Shell();
            return $shell;
        };
        
        $this->container['console'] = function ($c) {
            $console = new Console();
            $console->setLang($c['lang']);
            return $console;
        };
        
        return $this->container;
    }
}
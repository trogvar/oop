<?php
/**
 * User: d.plechystyy
 * Date: 9/26/13 2:48 PM
 */

namespace woo\controller;

class Controller
{
    private $applicationHelper;

    private function __construct()
    {
    }

    static function run()
    {
        $instance = new Controller();
        $instance->init();
        $instance->handleRequest();
    }

    function init()
    {
        $this->applicationHelper = ApplicationHelper::instance();
        $this->applicationHelper->init();
    }

    function handleRequest()
    {
        $request = new \woo\controller\Request();
        $resolver = new \woo\command\CommandResolver();
        $cmd = $resolver->getCommand($request);
        $cmd->execute($request);
    }
}

class ApplicationHelper
{
    private static $instance;
    private $config = "data/woo_options.xml";

    private function __construct()
    {
    }

    static function instance()
    {
        if (!self::$instance)
            self::$instance = new self();

        return self::$instance;
    }

    function init()
    {
        $dsn = \woo\base\ApplicationRegistry::getDSN();
        if (!is_null($dsn))
            return;

        $this->getOptions();
    }

    private function getOptions()
    {
        $this->ensure(file_exists($this->config), "Could not find options file");
        $options = simplexml_load_file($this->config);
        print get_class($options);
        $dsn = (string)$options->dsn;
        $this->ensure($dsn, "No DSN found");
        \woo\base\ApplicationRegistry::setDSN($dsn);
        //set other values
    }

    private function ensure($expr, $message)
    {
        if (!$expr)
            throw new \woo\base\AppException($message);
    }

}


class Request
{
    private $properties;
    private $feedback = array();

    function __construct()
    {
        $this->init();
        \woo\base\RequestRegistry::setRequest($this);
    }

    function init()
    {
        if (isset($_SERVER["REQUEST_METHOD"])) {
            $this->properties = $_REQUEST;
            return;
        }

        foreach ($_SERVER["argv"] as $arg) {
            if (strpos($arg, '=')) {
                list($key, $val) = explode("=", $arg);
                $this->setProperty($key, $val);
            }
        }
    }

    function setProperty($key, $val)
    {
        $this->properties[$key] = $val;
    }

    function getProperty($key)
    {
        if (isset($this->properties[$key]))
            return $this->properties[$key];
    }

    function addFeedback($msg)
    {
        array_push($this->feedback, $msg);
    }

    function getFeedback()
    {
        return $this->feedback;
    }

    function getFeedbackString($separator = "\n")
    {
        return implode($separator, $this->feedback);
    }
}
<?php
/**
 * User: d.plechystyy
 * Date: 9/25/13 3:44 PM
 */

namespace woo\base;

abstract class Registry
{
    abstract protected function get($key);

    abstract protected function set($key, $value);
}


class RequestRegistry extends Registry
{
    private $values = array();
    private static $instance;

    private function __construct()
    {
    }

    static function instance()
    {
        if (!isset(self::$instance))
            self::$instance = new self();

        return self::$instance;
    }

    protected function get($key)
    {
        return isset($this->values[$key])
            ? $this->values[$key]
            : null;
    }

    protected function set($key, $value)
    {
        $this->values[$key] = $value;
    }

    static function getRequest()
    {
        return self::instance()->get('request');
    }

    static function setRequest(\woo\controller\Request $request)
    {
        return self::instance()->set('request', $request);
    }
}

class SessionRegistry extends Registry
{
    private static $instance;

    private function __construct()
    {
        session_start();
    }

    static function instance()
    {
        if (!isset(self::$instance))
            self::$instance = new self();

        return self::$instance;
    }

    protected function get($key)
    {
        return isset($_SESSION[__CLASS__][$key])
            ? $_SESSION[__CLASS__][$key]
            : null;
    }

    protected function set($key, $value)
    {
        $_SESSION[__CLASS__][$key] = $value;
    }

    function setComplex(Complex $complex)
    {
        self::instance()->set('complex', $complex);
    }

    function getComplex()
    {
        return self::instance()->get('complex');
    }
}

class ApplicationRegistry extends Registry
{
    private static $instance;
    private $freezedir = "data";
    private $values = array();
    private $mtimes = array();

    private function __construct()
    {
    }

    static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function get($key)
    {
        $path = $this->freezedir . DIRECTORY_SEPARATOR . $key;
        if (file_exists($path)) {
            clearstatcache();
            $mtime = filemtime($path);
            if (!isset($this->mtimes[$key])) {
                $this->mtimes[$key] = 0;
            }
            if ($mtime > $this->mtimes[$key]) {
                $data = file_get_contents($path);
                $this->mtimes[$key] = $mtime;
                return ($this->values[$key] = unserialize($data));
            }
        }
        return isset($this->values[$key])
            ? $this->values[$key]
            : null;
    }

    protected function set($key, $value)
    {
        $this->values[$key] = $value;
        $path = $this->freezedir . DIRECTORY_SEPARATOR . $key;
        file_put_contents($path, serialize($value));
        $this->mtimes[$key] = time();
    }

    static function getDSN()
    {
        return self::instance()->get('dsn');
    }

    static function setDSN($dsn)
    {
        return self::instance()->set('dsn', $dsn);
    }

}
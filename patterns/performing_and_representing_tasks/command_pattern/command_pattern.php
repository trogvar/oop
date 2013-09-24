<?php
/**
 * User: d.plechystyy
 * Date: 9/23/13 3:21 PM
 */

class CommandContext
{
    private $params;
    private $error = "";

    function __construct()
    {
        $this->params = $_REQUEST;
    }

    function get($key)
    {
        return isset($this->params[$key]) ? $this->params[$key] : null;
    }

    function set($key, $value)
    {
        $this->params[$key] = $value;
    }

    function setError($error)
    {
        $this->error = $error;
    }

    function getError()
    {
        return $this->error;
    }
}

class User
{
}

class AccessManager
{
    function login($user, $password)
    {
        if (rand(1, 2) == 1)
            return new User();
        else
            return null;
    }

    function getError()
    {
        return "some omfg happened";
    }
}

class MessageSystem
{
    function send($address, $message, $topic)
    {
        return rand(1, 2) == 1 ? true : null;
    }

    function getError()
    {
        return "some message sending error happened";
    }
}

class Registry
{
    private static $am = null;
    private static $ms = null;

    public static function getAccessManager()
    {
        if (!self::$am)
            self::$am = new AccessManager();

        return self::$am;
    }

    public static function getMessageSystem()
    {
        if (!self::$ms)
            self::$ms = new MessageSystem();

        return self::$ms;
    }
}


class CommandNotFoundException extends Exception
{
}

class CommandFactory
{
    private static $dir = 'commands';

    static function getCommand($action = 'default')
    {
        if (preg_match('/\W/', $action))
            throw new Exception("Illegal characters in action");

        $class = ucfirst(strtolower($action)) . "Command";
        $file = self::$dir . DIRECTORY_SEPARATOR . "$class.php";
        if (!file_exists($file))
            throw new CommandNotFoundException("could not find file '$file'");

        require_once(self::$dir . DIRECTORY_SEPARATOR . "command.php");
        require_once($file);
        if (!class_exists($class))
            throw new CommandNotFoundException("no '$class' class located");

        $cmd = new $class();
        return $cmd;
    }
}

class Controller
{
    private $context;

    function __construct()
    {
        $this->context = new CommandContext();
    }

    function getContext()
    {
        return $this->context;
    }

    function process()
    {
        $cmd = CommandFactory::getCommand($this->context->get('action'));
        if (!$cmd->execute($this->context)) {
            //handle failure
            echo get_class($cmd) . " executed FAIL\n";
        } else {
            //success
            //dispatch view now...
            echo get_class($cmd) . " executed OK\n";
        }
    }
}

$controller = new Controller();
//fake user request
$context = $controller->getContext();
$context->set("action", "login");
$context->set("username", "bob");
$context->set("password", "111");
$controller->process();

$context->set("action", "feedback");
$context->set("msg", "Hi Bob, I'm angry mob");
$context->set("topic", "Spam title");
$controller->process();
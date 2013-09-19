<?php
/**
 * User: d.plechystyy
 * Date: 9/19/13 10:07 AM
 */


interface Observer
{
    function update(Observable $obj);
}

interface Observable
{
    function attach(Observer $observer);

    function detach(Observer $observer);

    function notify();
}

class Login implements Observable
{
    const LOGIN_USER_UNKNOWN = 1;
    const LOGIN_WRONG_PASS = 2;
    const LOGIN_ACCESS = 3;

    private $status = array();
    private $observers;

    function __construct()
    {
        $this->observers = array();
    }

    function handleLogin($user, $pass, $ip)
    {
        switch (rand(1, 3)) {
            case 1:
                $this->setStatus(self::LOGIN_ACCESS, $user, $ip);
                $ret = true;
                break;
            case 2:
                $this->setStatus(self::LOGIN_WRONG_PASS, $user, $ip);
                $ret = false;
                break;
            case 3:
            default:
                $this->setStatus(self::LOGIN_USER_UNKNOWN, $user, $ip);
                $ret = false;
                break;

        }
        $this->notify();
    }

    function attach(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    function detach(Observer $observer)
    {
        $comparer = function ($o1, $o2) {
            return $o1 === $o2 ? 0 : 1;
        };
        $this->observers = array_udiff($this->observers, array($observer), $comparer);
    }

    function notify()
    {
        foreach ($this->observers as $o)
            $o->update($this);
    }

    function setStatus($status, $user, $ip)
    {
        $this->status = array($status, $user, $ip);
    }

    function getStatus()
    {
        return $this->status;
    }
}

abstract class LoginObserver implements Observer
{
    private $login;

    function __construct(Login $login)
    {
        $this->login = $login;
        $login->attach($this);
    }


    function update(Observable $obj)
    {
        if ($obj == $this->login)
            $this->doUpdate($obj);
    }

    abstract function doUpdate(Login $login);
}

class SecurityMonitor extends LoginObserver
{
    function doUpdate(Login $login)
    {
        $status = $login->getStatus();
        if ($status[0] == Login::LOGIN_WRONG_PASS) {
            //send mail to sysadmin
            print __CLASS__ . ":\tsending mail to sysadmin\n";
        }
    }
}

class GeneralLogger extends LoginObserver
{
    function doUpdate(Login $login)
    {
        $status = $login->getStatus();
        print __CLASS__ . ":\tadd login data to log\n";
    }
}

class PartnershipTool extends LoginObserver
{
    function doUpdate(Login $login)
    {
        $status = $login->getStatus();
        // check IP address
        // set cookie if it matches a list
        print __CLASS__ . ":\tset cookie if IP matches a list\n";
    }
}

$login = new Login();
new SecurityMonitor($login);
new GeneralLogger($login);
new PartnershipTool($login);

$login->handleLogin("1", "2", "10.0.0.1");
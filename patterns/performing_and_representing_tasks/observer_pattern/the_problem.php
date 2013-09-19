<?php
/**
 * User: d.plechystyy
 * Date: 9/19/13 10:09 AM
 */

class Login
{
    const LOGIN_USER_UNKNOWN = 1;
    const LOGIN_WRONG_PASS = 2;
    const LOGIN_ACCESS = 3;
    private $status = array();

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

        // Here comes the various things which tie the Login class tightly into specific system
        // for example

        // request from martketing to log the ip addresses
        // Logger::logIP($this->getStatus());

        // request from sys-admins to log failed login attempts
        // if (!$ret) Notifier::mailWarning($this->getStatus());

        // etc


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
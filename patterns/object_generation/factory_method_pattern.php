<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 9/11/13
 * Time: 5:41 PM
 * To change this template use File | Settings | File Templates.
 */

abstract class ApptEncoder
{
    abstract function encode();
}

class BloggsApptEncoder extends ApptEncoder
{
    function encode()
    {
        return "Appointment data encode in BloggsCal format\n";
    }
}

class MegaApptEncoder extends ApptEncoder
{
    function encode()
    {
        return "Appointment data encode in MegaCal format\n";
    }
}

class CommsManager
{
    const BLOGGS = 1;
    const MEGA = 2;
    private $mode;

    function __construct($mode)
    {
        $this->mode = $mode;
    }

    function getHeaderText()
    {
        switch($this->mode)
        {
            case self::MEGA:
                return "MegaCal header\n";
            default:
                return "BloggsCal header\n";
        }

    }

    function getApptEncoder()
    {
        switch($this->mode)
        {
            case self::MEGA:
                return new MegaApptEncoder();
            default:
                return new BloggsApptEncoder();
        }
    }
}

$comms = new CommsManager(CommsManager::MEGA);
$encoder = $comms->getApptEncoder();
print $encoder->encode();
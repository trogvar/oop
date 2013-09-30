<?php
/**
 * User: d.plechystyy
 * Date: 9/26/13 4:23 PM
 */

namespace woo\command;

abstract class Command
{
    final function  __construct()
    {
    }

    function execute(\woo\controller\Request $request)
    {
        $this->doExecute($request);
    }

    abstract function doExecute(\woo\controller\Request $request);
}
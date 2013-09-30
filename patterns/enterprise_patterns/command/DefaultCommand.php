<?php
/**
 * User: d.plechystyy
 * Date: 9/26/13 5:15 PM
 */

namespace woo\command;


class DefaultCommand extends Command
{
    function doExecute(\woo\controller\Request $request)
    {
        $request->addFeedback("Wecome to WOO");
        include("view/main.php");
    }

}
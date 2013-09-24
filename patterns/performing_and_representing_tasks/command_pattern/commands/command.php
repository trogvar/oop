<?php
/**
 * User: d.plechystyy
 * Date: 9/23/13 4:44 PM
 */

abstract class Command
{
    abstract function execute(CommandContext $context);
}
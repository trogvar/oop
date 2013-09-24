<?php
/**
 * User: d.plechystyy
 * Date: 9/23/13 4:51 PM
 */
class LoginCommand extends Command
{
    function execute(CommandContext $context)
    {
        $manager = Registry::getAccessManager();
        $username = $context->get("username");
        $password = $context->get("password");
        $user = $manager->login($username, $password);

        if (is_null($user)) {
            $context->setError($manager->getError());
            return false;
        }
        $context->set("user", $user);
        return true;
    }
}
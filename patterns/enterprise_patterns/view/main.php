<?php
/**
 * User: d.plechystyy
 * Date: 9/26/13 5:35 PM
 */
$message = "default message";
if ($tmp = \woo\base\RequestRegistry::getRequest()->getFeedbackString())
    $message = $tmp;

?>
<html>
<head>
    <title>Woo! It's Woo</title>
</head>
<body>
<div><?= $message ?></div>
</body>
</html>

<?php

$isHttps = !empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS']);
$CALLBACK_URL = 'http' . $isHttps ? 's' : "" . '://' . $_SERVER['HTTP_HOST'] . '/callback.php';
$CALLBACK_URL = 'http://exsitecom.000webhostapp.com/callback.php';

require_once __DIR__ . '/_init.php';

$helper = $fb->getRedirectLoginHelper();

if (isset($_GET['state'])) {
    $helper->getPersistentDataHandler()->set('state', $_GET['state']);
}

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl($CALLBACK_URL, $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';

?>
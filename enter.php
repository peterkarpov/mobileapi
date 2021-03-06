<?php

require_once __DIR__ . '/_init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $api = new \MobileApi\api();

    $postData = file_get_contents('php://input');
    $data = $api->ConvertJsonToObject($postData);
    $token = isset($data["token"]) ? $data["token"] : null;

    $user = $api->getUserData($token);
    $userId = $user->getId();
    $userEmail = $user->getEmail();

    $api->Login($userId, $userEmail, $token);

} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $token = isset($_GET['token']) ? $_GET['token'] : null;

    //$token = "EAAYz18GRxXABAAuO5lI8MWZCt4v8ObibqRjOAZA7kvCZCIWfZByxHO6wihWoPmMtx51T4qA10x5Rdv8USqNRTA72YyopnJcHeDbn7QYf3bTC5k8rRDVa2tN0CDz9ngifhL8OV9DEVszZB9zVxCkBiW6k3GUjpVA38jWXxbFURAwZDZD";

    $api = new \MobileApi\api();

    $user = $api->getUserData($token);
    $userId = $user->getId();
    $userEmail = $user->getEmail();

    $api->Login($userId, $userEmail, $token);

    echo "<pre style='text-align: left'>";
    var_dump($_SESSION);
    echo "</pre>";

} else {

    $api = new \MobileApi\api();

    http_response_code(400);

    return $api->returnError(400, "not a post");

}


?>
<?php

require_once __DIR__ . '/_init.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $api = new \MobileApi\api();

    echo "<pre style='text-align: left'>";
    var_dump($_SESSION);
    echo "</pre>";

    $token = isset($_SESSION['identity']) ? $_SESSION['identity'] : null;

    //$token = "EAAYz18GRxXABAAuO5lI8MWZCt4v8ObibqRjOAZA7kvCZCIWfZByxHO6wihWoPmMtx51T4qA10x5Rdv8USqNRTA72YyopnJcHeDbn7QYf3bTC5k8rRDVa2tN0CDz9ngifhL8OV9DEVszZB9zVxCkBiW6k3GUjpVA38jWXxbFURAwZDZD";

    $user = $api->getUserData($token);

    $jObjectUser = [
        'Id' => $user->getId(),
        'Email' => $user->getEmail(),

        'FirstName' => $user->getFirstName(),
        'LastName' => $user->getLastName(),

        'Hometown' => $user->getLocation() != null ? json_decode($user->getLocation())->name : null,
        'Picture' => $user->getPicture() != null ? json_decode($user->getPicture())->url : null,
    ];

//echo "<pre style='text-align: left'>";
//var_dump($jObjectUser);
//echo "</pre>";

    echo $api->ConvertObjectToJson($jObjectUser);

} else {

    $api = new \MobileApi\api();

    http_response_code(400);

    return $api->returnError(400, "not a get");

}

?>

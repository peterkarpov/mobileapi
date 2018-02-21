<?php

namespace MobileApi {

    session_start();

    require_once __DIR__ . '/src/Facebook/autoload.php';

    use Facebook\Exceptions\FacebookResponseException;
    use Facebook\Exceptions\FacebookSDKException;
    use Facebook\Facebook;

    class api
    {
        public $APP_ID = '1745851618805104';
        public $APP_SECRET = '9b95b14a3730352db8397967936a9d26';


        function initFb()
        {
            $fb = new Facebook([
                'app_id' => $this->APP_ID, // Replace {app-id} with your app id
                'app_secret' => $this->APP_SECRET,
                'default_graph_version' => 'v2.2',
            ]);

            return $fb;
        }

        function getUserData($token)
        {
            $fb = $this->initFb();

            try {
                // Returns a `FacebookResponse` object
                $response = $fb->get('/me?fields=id,name,first_name,last_name,picture.type(large),hometown,location,email', $token);
            } catch (FacebookResponseException $e) {

                http_response_code(400);

                echo 'Graph returned an error: ' . $e->getMessage();
                exit;

            } catch (FacebookSDKException $e) {

                http_response_code(400);

                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }

            $user = $response->getGraphUser();
            return $user;

        }

        function ConvertJsonToObject($jString)
        {
            // $postData = file_get_contents('php://input');
            // $postData = trim($postData, " ");
            // $postData = trim($postData, "'");

            //$jString = "{ \"token\": \"EAAYz18GRxXABAAuO5lI8MWZCt4v8ObibqRjOAZA7kvCZCIWfZByxHO6wihWoPmMtx51T4qA10x5Rdv8USqNRTA72YyopnJcHeDbn7QYf3bTC5k8rRDVa2tN0CDz9ngifhL8OV9DEVszZB9zVxCkBiW6k3GUjpVA38jWXxbFURAwZDZD\"}";

            $jObject = null;
            try {
                $jObject = json_decode($jString, true);

            } catch (\Exception $e) {

                http_response_code(400);

                switch (json_last_error()) {
                    case JSON_ERROR_NONE:
                        echo ' - No errors';
                        break;
                    case JSON_ERROR_DEPTH:
                        echo ' - Maximum stack depth exceeded';
                        break;
                    case JSON_ERROR_STATE_MISMATCH:
                        echo ' - Underflow or the modes mismatch';
                        break;
                    case JSON_ERROR_CTRL_CHAR:
                        echo ' - Unexpected control character found';
                        break;
                    case JSON_ERROR_SYNTAX:
                        echo ' - Syntax error, malformed JSON';
                        break;
                    case JSON_ERROR_UTF8:
                        echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                        break;
                    default:
                        echo ' - Unknown error';
                        break;
                }
            }
            return $jObject;
        }

        function Registration($userId, $userEmail)
        {
            $temp = isset($_SESSION['repository']) ? $_SESSION['repository'] : [];
            $temp[$userId] = [

                'Email' => $userEmail,
            ];
            $_SESSION['repository'] = $temp;
        }

        function Login($userId, $userEmail, $token)
        {
            if (!isset($_SESSION['repository'])) {
                $this->Registration($userId,$userEmail);
            }

            $repository = $_SESSION['repository'];

            if (isset($repository[$userId])) {

                if ($repository[$userId]['Email'] == $userEmail) {

                    $_SESSION['identity'] = $token;
                };
            }

        }

        function Logout()
        {
            if (isset($_SESSION['identity'])) {
                $_SESSION['identity'] = null;
            }
        }

        function ConvertObjectToJson($jData)
        {
            $jString = null;
            try {
                $jString = json_encode($jData, true);

            } catch (\Exception $e) {

                http_response_code(400);

                switch (json_last_error()) {
                    case JSON_ERROR_NONE:
                        echo ' - No errors';
                        break;
                    case JSON_ERROR_DEPTH:
                        echo ' - Maximum stack depth exceeded';
                        break;
                    case JSON_ERROR_STATE_MISMATCH:
                        echo ' - Underflow or the modes mismatch';
                        break;
                    case JSON_ERROR_CTRL_CHAR:
                        echo ' - Unexpected control character found';
                        break;
                    case JSON_ERROR_SYNTAX:
                        echo ' - Syntax error, malformed JSON';
                        break;
                    case JSON_ERROR_UTF8:
                        echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                        break;
                    default:
                        echo ' - Unknown error';
                        break;
                }
            }
            return $jString;
        }

        function returnError($code, $message)
        {
            http_response_code($code);

            $error = [
                $error = $message
            ];

            return json_encode($error);
        }
    }
}
?>
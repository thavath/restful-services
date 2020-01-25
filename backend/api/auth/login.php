
<?php
// required headers http://127.0.0.1:5501/client/pages/index.html
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Origin: http://127.0.0.1:5501/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// database connection will be here
// files needed to connect to database
include_once '../../databases/database.php';
include_once '../../models/user.php';
// generate json web token
include_once '../../config/core.php';
include_once '../../lib/jwt/src/BeforeValidException.php';
include_once '../../lib/jwt/src/ExpiredException.php';
include_once '../../lib/jwt/src/SignatureInvalidException.php';
include_once '../../lib/jwt/src/JWT.php';

use \Firebase\JWT\JWT;

// generate jwt will be here
// get database connection
$database = new Database();
$db = $database->getConnection();

// instantiate user object
$user = new User($db);

// check email existence here
// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values
$user->email = $data->email;
$email_exists = $user->emailExists();

// files for jwt will be here
// check if email exists and if password is correct
if ($email_exists && password_verify($data->password, $user->password)) {
    $token = array(
        "iss" => $iss,
        "aud" => $aud,
        "iat" => $iat,
        "nbf" => $nbf,
        "data" => array(
            "id" => $user->id,
            "username" => $user->username,
            "email" => $user->email, 
            "country_code"=>$user->country_code,
            "phone_number"=>$user->phone_number 
        )
    );

    // set response code
    http_response_code(200);

    // generate jwt
    $access_token = JWT::encode($token, $key);
    echo json_encode(
        array(
            "message" => "Successful login.",
            "access_token" => $access_token
        )
    );
}

// login failed will be here
// login failed
else {

    // set response code
    http_response_code(401);

    // tell the user login failed
    echo json_encode(array("message" => "Login failed."));
}
?>
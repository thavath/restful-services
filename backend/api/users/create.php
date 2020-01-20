<?php
    // files needed to connect to database
    include_once '../../databases/database.php';
    include_once '../../models/user.php';
    // required headers
    header("Access-Control-Allow-Origin: http://php.thavath.com:8080/");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // database connection will be here
    // get database connection
    $database = new Database();
    $db = $database->getConnection(); 
    // instantiate product object
    $user = new User($db); 
    // submitted data will be here
    // get posted data
    $data = json_decode(file_get_contents("php://input")); 
    // set product property values
    $user->username = $data->username;
    $user->email = $data->email;
    $user->password = $data->password;
    $user->phone_number = $data->phone_number;
    $user->country_code = $data->country_code;
    
    // use the create() method here
    // create the user
    if( !empty($user->username) &&
        !empty($user->email) &&
        !empty($user->password) &&
        $user->create()
    ){ 
        // set response code
        http_response_code(200); 
        // display message: user was created
        echo json_encode(array("message" => "User was created."));
    } 
    // message if unable to create user
    else{ 
        // set response code
        http_response_code(400); 
        // display message: unable to create user
        echo json_encode(array("message" => "Unable to create user."));
    }
?>
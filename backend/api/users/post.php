<?php 
require_once "../../databases/database.php"; 
require_once "../../models/user.php"; 
if($conn) { 
    //header("Access-Control-Allow-Origin: http://php.thavath.com:8080");
    header("Access-Control-Allow-Origin: http://php.thavath.com:8080");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {   
        if(!empty($_POST["username"]) and !empty($_POST["password"]) and !empty($_POST['email'])){ 
            $username = isset($_POST['username']) ? $_POST['username'] : null;
            $password = isset($_POST['password']) ? $_POST['password'] : null;
            $email = isset($_POST['email']) ? $_POST['email'] : null;
            $country_code = isset($_POST['country_code']) ? $_POST['country_code'] : null;
            $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : null;
            // prepare sql query.
            $stmt = $conn->prepare("INSERT INTO users (username, password, email,phone_number,country_code)
            VALUES (:username, :password, :email, :phone_number, :country_code)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone_number', $phone_number);
            $stmt->bindParam(':country_code', $country_code); 
           if($stmt->execute()){
                $json = json_encode(["message" => "User Created Successfully...!"]);  
                http_response_code(200); 
                echo $json;   
           }else{
                http_response_code(503);
                $json = json_encode(["message"=>"Unable to create the user."]);  
                echo $json; 
           }
        } else{
            http_response_code(400);
            $json = json_encode(["status"=>"Bad Request", "message" =>
                [
                    "username"=>"username is requeried",
                    "password"=>"password is requeried",
                    "email"=>"email is requeried"
                ]
            ]);  
            echo $json;
        }
   }else{ 
        http_response_code(400);
        $json = json_encode(["message"=>"Bad Request"]);  
        echo $json; 
   } 
}else{
    echo "Database Connection Failed.";
}
?>
<?php 
include_once "../../databases/database.php"; 
require_once "../../models/user.php";  
$database = new Database();
$conn = $database->getConnection(); 
if($conn) { 
    //header("Access-Control-Allow-Origin: http://php.thavath.com:8080");
    header("Access-Control-Allow-Origin: http://php.thavath.com:8080");
    header("Access-Control-Allow-Methods: GET");
    header("Content-Type: application/json; charset=UTF-8");
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {  
        if(isset($_GET["id"])){
            $id = $_GET["id"];
            $stmt = $conn->prepare('SELECT t.id, t.username, t.password, t.email, CONCAT(t.country_code,SUBSTRING(t.phone_number, 2, LENGTH(t.phone_number))) AS phone_number,DATE_FORMAT(t.created_at, "%d-%b-%Y %l:%i %p") created_at FROM users t WHERE t.id=:id');
            $stmt->bindParam(':id', $id); 
            $stmt->execute(); 
            // set the resulting array to associative
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $results = $stmt->fetchAll();
            // echo gettype($results);
           if(count($results) > 0){
                $json = json_encode($results[0]);  
                http_response_code(200); 
                echo $json;   
           }else{
                http_response_code(404);
                $json = json_encode(["message"=>"User Not Found in Database."]);  
                echo $json; 
           }
        }else{ 
            $stmt = $conn->prepare('SELECT t.id, t.username, t.password, t.email, CONCAT(t.country_code,SUBSTRING(t.phone_number, 2, LENGTH(t.phone_number))) AS phone_number,DATE_FORMAT(t.created_at, "%d-%b-%Y %l:%i %p") created_at FROM users t');
            $stmt->execute(); 
            // set the resulting array to associative
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $results = $stmt->fetchAll();
            if(count($results) > 0){
                $json = json_encode($results);  
                http_response_code(200); 
                echo $json;   
           }else{
                http_response_code(404);
                $json = json_encode(["message"=>"User Not Found in Database."]);  
                echo $json; 
           }  
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
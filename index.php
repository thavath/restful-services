
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Lesson</title>
</head>
<body>
    <?php
        echo "<h4>Hi from vhosts php.thavath.com</h4>";
        $tody = "16-January";
        class Me {
           public function birthday(){
               return "16-January";
           }
        }
        $me = new Me();
        if($me->birthday() == $tody){
            echo "<h4>Happy birthday to me.</h4>";
        }else{
            echo "<h4>Today is not your birthday</h4>";
        } 
    ?>
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "thavath";
        // $username = "thavath";
        // $password = "5555"; 
        // Create connection
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<h3>Connected successfully<h3>"; 
            $dt = new DateTime("now", new DateTimeZone('Asia/Phnom_Penh'));
            echo $dt->format('d-M-Y H:i:s A') . "</br>";
            $current_time = date("d-M-Y")." ".date("H:i A") . "</br>";
            echo "Current Date Time : ". $current_time; 
            // sql to create table
            // $sql = "CREATE TABLE users (
            //         id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            //         username VARCHAR(30) NOT NULL,
            //         password VARCHAR(30) NOT NULL,
            //         email VARCHAR(50),
            //         phone_number VARCHAR(10),
            //         country_code VARCHAR(5),
            //         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            //         updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            //         )"; 
            // // use exec() because no results are returned
            // $conn->exec($sql);
            // $stmt = $conn->prepare("INSERT INTO users (username, password, email,phone_number,country_code)
            // VALUES (:username, :password, :email, :phone_number, :country_code)");
            // $stmt->bindParam(':username', $username);
            // $stmt->bindParam(':password', $password);
            // $stmt->bindParam(':email', $email);
            // $stmt->bindParam(':phone_number', $phone_number);
            // $stmt->bindParam(':country_code', $country_code);

            // // insert a row
            // $username = "thavath";
            // $password = "thavath5555";
            // $email = "thavath@example.com";
            // $phone_number = "085362090";
            // $country_code = "+855";
            // $stmt->execute();

            // // insert another row
            // $username = "vath";
            // $password = "vath5555";
            // $email = "vath@example.com";
            // $phone_number = "098328746";
            // $country_code = "+855";
            // $stmt->execute();

            // // insert another row
            // $username = "dara";
            // $password = "dara5555";
            // $email = "dara@example.com";
            // $phone_number = "0975352534";
            // $country_code = "+855";
            // $stmt->execute();

            // echo "<h3>3 Row Inserted successfully</h3><br>";

            // if you are doing ajax with application-json headers

        }        // if (empty($_POST)) {
        //     $_POST = json_decode(file_get_contents("php://input"), true) ? : [];
        // }
        // // usage
        // echo json_response(200, 'working'); // {"status":true,"message":"working"}
        // // array usage
        // echo json_response(200, array(
        //   'data' => array(1,2,3)
        //   ));
        // // {"status":true,"message":{"data":[1,2,3]}}
        // // usage with error
        // echo json_response(500, 'Server Error! Please Try Again!'); 
        // // {"status":false,"message":"Server Error! Please Try Again!"}
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
    ?>
</body>
</html>
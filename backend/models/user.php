 
<?php
// 'user' object
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "users"; 
    // object properties
    public $id;
    public $username;
    public $email;
    public $password;
    public $phone_number;
    public $country_code;
    public $created_at;
    public $updated_at; 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
    // create() method will be here
    // create new user record
    function create(){ 
        // insert query
        $query = "INSERT INTO " . $this->table_name . " 
                    SET username = :username, 
                        password = :password,
                        email = :email, 
                        phone_number = :phone_number,
                        country_code = :country_code
                    "; 
        // prepare the query
        $stmt = $this->conn->prepare($query); 
        // $stmt = $this->conn->prepare("INSERT INTO users (username, password, email, phone_number, country_code)
        // VALUES (:username, :password, :email, :phone_number, :country_code)");
        // sanitize
        $this->username=htmlspecialchars(strip_tags($this->username)); 
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password)); 
        $this->phone_number=htmlspecialchars(strip_tags($this->phone_number)); 
        $this->country_code=htmlspecialchars(strip_tags($this->country_code)); 
        // bind the values
        $stmt->bindParam(':username', $this->username); 
        $stmt->bindParam(':email', $this->email);  
        $stmt->bindParam(':phone_number', $this->phone_number);
        $stmt->bindParam(':country_code', $this->country_code); 
        // hash the password before saving to database
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash); 
        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        } 
        return false;
    }
 
// emailExists() method will be here
}
?>
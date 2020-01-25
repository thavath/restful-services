 
<?php
// 'user' object
class User
{

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
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // create() method will be here
    // create new user record
    function create()
    {
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
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        $this->country_code = htmlspecialchars(strip_tags($this->country_code));
        // bind the values
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone_number', $this->phone_number);
        $stmt->bindParam(':country_code', $this->country_code);
        // hash the password before saving to database
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
        // execute the query, also check if query was successful
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    function verifyPassword($id, $comfirm_password){ 
         $query = "SELECT *
         FROM " . $this->table_name . "
         WHERE id = ?
         LIMIT 0,1"; 
        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        // $password = htmlspecialchars(strip_tags($password));

        // bind given email value
        $stmt->bindParam(1, $id);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if email exists, assign values to object properties for easy access and use for php sessions
        if ($num > 0) { 
            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // return true because password is match in the database
            $comfirm_password = htmlspecialchars(strip_tags($comfirm_password));
            $result = password_verify($comfirm_password, $row['password']);
            return $result;
        }
        return false;
    }
    // emailExists() method will be here
    // check if given email exist in the database
    function emailExists()
    {

        // query to check if email exists
        $query = "SELECT id, username, password, phone_number, country_code, email
                FROM " . $this->table_name . "
                WHERE email = ?
                LIMIT 0,1"; 
        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->email = htmlspecialchars(strip_tags($this->email));

        // bind given email value
        $stmt->bindParam(1, $this->email);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if email exists, assign values to object properties for easy access and use for php sessions
        if ($num > 0) {

            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // assign values to object properties
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->password = $row['password'];
            $this->phone_number = $row['phone_number'];
            $this->country_code = $row['country_code'];

            // return true because email exists in the database
            return true;
        }

        // return false if email does not exist in the database
        return false;
    }

    // update() method will be here
    // update a user record
    public function update()
    {

        // if password needs to be updated
        $password_set = !empty($this->password) ? ", password = :password" : "";

        // if no posted password, do not update the password
        $query = "UPDATE " . $this->table_name . "
            SET
                username = :username,
                email = :email
                {$password_set},
                phone_number = :phone_number,
                country_code = :country_code
            WHERE id = :id";
        // prepare the query
        $stmt = $this->conn->prepare($query); 
        // sanitize
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        $this->country_code = htmlspecialchars(strip_tags($this->country_code));
        $this->email = htmlspecialchars(strip_tags($this->email));

        // bind the values from the form
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':phone_number', $this->phone_number);
        $stmt->bindParam(':country_code', $this->country_code);
        $stmt->bindParam(':email', $this->email);

        // hash the password before saving to database
        if (!empty($this->password)) {
            $this->password = htmlspecialchars(strip_tags($this->password));
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password_hash);
        }

        // unique ID of record to be edited
        $stmt->bindParam(':id', $this->id);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
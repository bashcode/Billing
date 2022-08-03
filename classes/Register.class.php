<?php

class Register extends Database {    
    private $email;
    private $password;
    private $confirm;
    private $created;
    private $sql;
    private $row;
    private $hashed;
    private $ip;

    function __construct() {
        if(isset($_POST['submit'])){
            parent::__construct();
            $this->email = filter_var(strtolower($_POST['email']),FILTER_SANITIZE_EMAIL);
            $this->password = strip_tags($_POST['password']);
            $this->confirm = strip_tags($_POST['confirm']);
            $this->created = new DateTime();
            $this->created = $this->created->format('Y-m-d H:i:s');
            $this->ip = $_SERVER['REMOTE_ADDR'];
            if(empty($this->email) || empty($this->password || empty($this->confirm))){
                // Insert Error Later
                echo "Please submit the entire form";
            } else if ($this->password != $this->confirm){
                // Insert Error Later
                echo "Your password is incorrect.";
            } else {
                try {
                    $this->sql = $this->connection->prepare("SELECT email FROM users WHERE email = :email");
                    $this->sql->execute([':email' => $this->email]); 
                    $this->row = $this->sql->fetch(PDO::FETCH_ASSOC);
                    if(isset($this->row['email'])){
                        // Insert Error Later
                        echo "User already exists";
                    } else {
                        $this->hashed = password_Hash($this->password, PASSWORD_DEFAULT);
                        $this->sql = $this->connection->prepare("INSERT INTO USERS (email, password, createdAt, ip_address) VALUES (:email, :password, :createdAt, :ip_address)");
                        $this->sql->execute([
                            ':email' => $this->email,
                            ':password' => $this->hashed,
                            ':createdAt' => $this->created,
                            ':ip_address' => $this->ip
                        ]);
                        header('location: login.php');
                    }
                } catch(PDOException $err){
                    echo $err;
                }
            }
        }
    }
}

?>
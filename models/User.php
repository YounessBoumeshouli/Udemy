<?php

abstract class user {
    protected $db;
    protected $id;
    protected $username;
    protected $email;
    protected $role;

    public function __construct($db, $userData = null) {
        $this->db = $db;
        if ($userData) {
            $this->id = $userData['id'];
            $this->username = $userData['username'];
            $this->email = $userData['email'];
        }
    }
    public function create($data){
        echo "<pre>";
        var_dump($data);
        var_dump($this->db);
        echo "</pre>";
        echo $this->status;
        $sql = "INSERT INTO public.users(
	     username, email, password, role, status)
	    VALUES (:username, :email, :password, :role,:status)";
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $data['role']);
        echo $password;
        try {
            $stmt->execute();
            echo "executed";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }   
    }
}
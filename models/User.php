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
}
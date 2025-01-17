<?php
require_once 'CrudInterface.php';

class Category implements CrudInterface {
    private $db;
    private $id;
    private $name;

    public function __construct($db ,$id , $name) {
        $this->db = $db;
        $this->id = $id;
        $this->name = $name;
    }

    public function create($data) {
        $sql = "INSERT INTO categories (name_categorie) VALUES (:name)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        return $stmt->execute();
    }

    public function read($id_category) {
        $sql = "SELECT * FROM categories WHERE id_category = :id_category";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_category', $id_category);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id_category, $data) {
        $sql = "UPDATE categories SET name_categorie = :name WHERE id_category = :id_category";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':id_category', $id_category);
        return $stmt->execute();
    }

    public function delete($id_category) {
        $sql = "DELETE FROM categories WHERE id_category = :id_category";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_category', $id_category);
        return $stmt->execute();
    }

    public function getAll() {
        $sql = "SELECT * FROM categories";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function setName($name){
        $this->name = $name;
    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
}


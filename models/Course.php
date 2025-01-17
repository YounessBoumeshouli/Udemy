<?php
require_once 'CrudInterface.php';
abstract class Course implements CrudInterface, DisplayableInterface {
    protected $db;
    protected $id;
    protected $title;
    protected $description;
    protected $teacher_id;
    protected $category_id;
    protected $status;

    public function __construct($db) {
        $this->db = $db;
    }
    public function create($data) {
        $sql = "INSERT INTO courses (title, description, teacher_id, category_id,type,document_url) VALUES (:title, :description, :teacher_id, :category_id,:type,:document_url)  returning    id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':teacher_id', $data['teacher_id']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':type', $data['content_type']);
        $stmt->bindParam(':document_url', $data['document_url']);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function read($id) {
        $sql = "SELECT * FROM courses WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function update($id, $data) 
    {
        $sql = "UPDATE courses SET title = :title, description = :description, category_id = :category_id WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function delete($id) 
    {
        $sql = "DELETE FROM courses WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getAll($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM courses LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
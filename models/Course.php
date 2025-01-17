<?php
require_once 'CrudInterface.php';
require_once 'DisplayableInterface.php';

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
    public function activate($id) 
    {
        $sql = "UPDATE courses SET course_status = 'accepted' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function suspend($id) 
    {
        $sql = "UPDATE courses SET course_status = 'ban' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
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
// methode by course
    public function search($keyword) {
        $sql = "SELECT * FROM courses WHERE title LIKE :keyword OR description LIKE :keyword";
        $stmt = $this->db->prepare($sql);
        $keyword = "%$keyword%";
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    abstract public function display();
    // Imlemnts methods 
    public function enroll($student_id) {
        $sql = "INSERT INTO enrollments (student_id, course_id) VALUES (:student_id, :course_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':course_id', $this->id);
        return $stmt->execute();
    }
    public function checkCourse($idUser,$id) {
        $sql = "SELECT * FROM enrollments WHERE student_id = :id and course_id =:course_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $idUser);
        $stmt->bindParam(':course_id', $id);
        $stmt->execute();
        $courseData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($courseData) {
            return true;
        }
        return false;
    }
    public function getEnrollments() {
        $sql = "SELECT users.* FROM users JOIN enrollments ON users.id = enrollments.student_id WHERE enrollments.course_id = :course_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':course_id', $this->id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getId(){
        return $this->id;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getStatus(){
        return $this->status;
    }
    public function getCategory(){
        return $this->category_id;
    }
    public function getTeacherId(){
        return $this->teacherId;
    }
    public function setTitle($title){
        $this->title = $title;
    }
    public function setDescription($description){
        $this->description = $description;
    }
    public function setStatus($status){
     $this->status = $status;
    }
    public function setCategory($category_id){
        $this->category_id = $category_id;
    }
    public function setTeacherId($teacherId){
        $this->teacherId = $teacherId;
    }
}


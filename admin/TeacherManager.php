<?php
require_once 'models/UserFactory.php';
require_once 'models/CourseFactory.php';
require_once 'models/Tags.php';
require_once 'models/Categories.php';
require_once 'models/Statistics.php';

class TeacherManager {
    private $db;
    private $courseFactory;
    private $userFactory;
    private $tags;
    private $category;
    private $statistics;

    public function __construct($db) {
        $this->db = $db;
        $this->courseFactory = new CourseFactory($db);
        $this->userFactory = new UserFactory($db);
        $this->tags = new Tags($db,null,null);
        $this->category = new Category($db,null,null);
        $this->statistics = new Statistics($db);
    }

    public function manageCourse($id, $action) {
        try {
            $courseData = $this->courseFactory->getCourse($id);
            if (!$courseData) {
                return false;
            }
            
            switch ($action) {
                case 'editCourse':
                    return $this->courseFactory->updateCourse($courseData);
                case 'deleteCourse':
                    return $this->courseFactory->deleteCourse($id);
                default:
                    return false;
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function InsertTag($data) {
        return $this->tags->create($data);
    }

    public function InsertCategory($data) {
        return $this->category->create($data);
    }

    public function getGlobalStatistics($id) {
        
        return [
            'totalCourses' => $this->statistics->getTotalCoursesbyTeacher($id),
            'mostPopularCourse' => $this->statistics->getMostPopularCoursebyTeacher($id),
            'students' => $this->statistics->getStudents($id)
        ];
    }
    public function getCourseMembersByCourseId($courseId) {
        $query = "SELECT u.id_user, u.username, u.email 
                  FROM users u 
                  JOIN enrollments ce ON u.id_user = ce.student_id 
                  WHERE ce.course_id = :id ORDER BY id ASC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id',$courseId);
        $stmt->execute();
        $data =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        $listMemebres = [];
        $i = 0;
        foreach ($data as $userData) {

        $listMemebres[$i] = $this->userFactory->createUser('student', $userData);
        $i++;
        }
        return $listMemebres;
    }
    public function getAllUsers() {
        return $this->userFactory->getAllUsers();
    }

    public function getAllTeachers() {
        return $this->userFactory->getAllTeachers();
    }

    public function getAllCourses() {
        return $this->courseFactory->getAllCourses();
    }

    public function getAllTags() {
        return $this->tags->getAll();
    }
}

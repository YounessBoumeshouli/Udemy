<?php
require_once 'models/UserFactory.php';
require_once 'models/CourseFactory.php';
require_once 'models/Tags.php';
require_once 'models/Categories.php';
require_once 'models/Statistics.php';

class AdminManager {
    private $db;
    private $userFactory;
    private $courseFactory;
    private $tags;
    private $category;
    private $statistics;

    public function __construct($db) {
        $this->db = $db;
        $this->userFactory = new UserFactory($db);
        $this->courseFactory = new CourseFactory($db);
        $this->tags = new Tags($db,null,null);
        $this->tagManager = new TagsManager();
        $this->category = new Category($db,null,null);
        $this->statistics = new Statistics($db);
    }

    public function validateTeacher($teacherId) {
        $teacher = $this->userFactory->createUser('teacher', ['id' => $teacherId]);
        return $teacher->activate();
    }


    public function manageUser($userId, $action) {
        echo $action;
        $user = $this->userFactory->getUser($userId);
        if (!$user) {
            echo "no  user";
            return false;
        }
        switch ($action) {
            case 'accept':
                return $user->activate($userId);
            case 'suspend':
                return $user->suspend($userId);
            case 'delete':
                return $user->delete($userId);
            default:
                echo 'no user here';
        }
    }
    public function manageCourse($id, $action) {
        $course = $this->courseFactory->getCourse($id);
        if (!$course) {
            echo "no Course ";
            return false;
        }
        switch ($action) {
            case 'acceptCourse':
                return $course->activate($course->getId());
            case 'banCourse':
                return $course->suspend($course->getId());
            default:
                echo 'no course';
        }
    }
    public function deleteTag($id) 
    {
        $tagObj = $this->tagManager->getTag($id);
        var_dump($tagObj);
        if (!$tagObj) {
            echo $id;
            return false;
        }
        return $this->tags->delete($tagObj->getId());

       
    }

    public function InsertTag($data) {
        return $this->tags->create($data);
    }
    public function InsertCategory($data) {
        return $this->category->create($data);
    }

    public function getGlobalStatistics() {
        return [
            'totalCourses' => $this->statistics->getTotalCourses(),
            'coursesByCategory' => $this->statistics->getCoursesByCategory(),
            'mostPopularCourse' => $this->statistics->getMostPopularCourse(),
            'topTeachers' => $this->statistics->getTopTeachers()
        ];
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
    public function getPendingCourses() {
        return $this->courseFactory->getCourseByStatus('pending');
    }

    public function getAllTags() {
        return $this->tags->getAll();
    }
}


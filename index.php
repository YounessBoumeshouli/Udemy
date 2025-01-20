<?php
require_once 'config/Database.php';
require_once 'models/UserFactory.php';
require_once 'models/Course_Tags.php';
require_once 'admin/AdminManager.php';
require_once 'admin/teacherManager.php';
require_once 'admin/CategoriesManager.php';
require_once 'admin/TagsManager.php';

session_start();
$db = Database::getInstance()->getConnection();
$userFactory = new UserFactory($db);
$courseFactory = new CourseFactory($db);
$adminManager = new AdminManager($db);
$teacherManager = new TeacherManager($db);
$categoryManager =  new CategoriesManager($db);
$tagManager =  new TagsManager($db);
$action = $_GET['action'] ?? 'home';
$course_tag = new TagsCourse($db);
// if ($action = "deleteCourse") {
//     # code...
//     if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'teacher') {
//         $courseId = $_GET["id"];
//         $teacherManager->manageCourse($courseId, $action);
//         header('Location: index.php?action=teacher_courses');
//         exit();
//     } else {
//         header('Location: index.php?action=login');
//         exit();
//     }

// }
switch ($action) {
    case "deleteCourse":
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'teacher') {
            $courseId = $_GET["id"];
            $teacherManager->manageCourse($courseId, $action);
            header('Location: index.php?action=teacher_courses');
            exit();
        } else {
            header('Location: index.php?action=login');
            exit();
        }
        break;
        case "edite_course":
            if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'teacher') {
                $courseId = $_POST["id"];
                $course = $courseFactory->getCourse($courseId);
                $course->setTitle($_POST["title"]);
                $course->setDescription($_POST["description"]);
                $course->setCategory($_POST["category_id"]);
                $courseFactory->updateCourse($course);   
                exit();
            } else {
                echo 'error';
                header('Location: index.php?action=login');
                exit();
            }
            break;
    case "get_course":
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'teacher') {
            $courseId = $_GET["id"];
            $course = $courseFactory->getCourse($courseId);
            $tags = $tagManager->getTags($courseId);
            $i = 0;
            $tagsArray = [];
            foreach ($tags as $tag) {
                $tagsArray[] = [
                    'tagId'=>$tag->getId(),
                    'tagName'=>$tag->getTitle()
                ];
            }
            
            $courseData = [
                'id' => $course->getId(),
                'title' => $course->getTitle(),
                'description' => $course->getDescription(),
                'status' => $course->getStatus(),
                'category' => $course->getCategory(),
                'tags'=>$tagsArray
            ];
            header('Content-Type: application/json');
            echo json_encode($courseData);
            exit();
        } else {
            header('Location: index.php?action=login');
            exit();
        }
        break;
    case "deleteTag":
        echo 'delete Tag';
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
            $tagId = $_GET['id'];
            $adminManager->deleteTag($tagId);
            header("index.php?action=admin_dashboard");
        } else {
            header('Location: index.php?action=login');
        }
        break;
    case 'home':
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $tag = $_GET['tag'] ?? false;

        if ($tag) {
          $courses = $courseFactory->getAllCoursesWithTag($tag);
        }else{
            $courses = $courseFactory->getAllCourses($page);

        }
        $categories = $categoryManager->listcategory();
        $tags = $tagManager->listTags();
        require 'views/home.php';
        break;
    case 'search':
        $keyword = $_GET['keyword'] ?? '';
        $results = $courseFactory->searchCourses($keyword);
        require 'views/search_results.php';
        break;
       
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {

                $user = $userFactory->createUser($_POST['role']);
                
                $user->create($_POST);
                echo "<pre>";
                var_dump($_POST);
                echo "</pre>" ;

                header('Location: index.php?action=login');
            } catch (Exception $e) {
                echo "error";
                $error = $e->getMessage();
                require 'views/register.php';
            }
        } else {
            require 'views/register.php';
        }
        break ;


    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $user = $userFactory->authenticate($_POST['username'], $_POST['password']);
            echo "authenticate";
            if ($user) {
                echo "there is a user";
                $_SESSION['user'] = [
                    'id_user' => $user->getId(),
                    'username' => $user->getUsername(),
                    'email' => $user->getEmail(),
                    'role' => $user->getRole(),
                    'status' => $user->getStatus()
                ];
                echo "session created";
                header('Location: index.php');
            } else {
                $error = "Invalid credentials";
                echo "else";
                require 'views/login.php';
            }
        } else {
            require 'views/login.php';
        }
        break;
    case 'logout':
        session_destroy();
        header('Location: index.php');
        break;
    case 'course':
        $courseId = $_GET['id'] ?? null;
        if ($courseId) {
            $course = $courseFactory->getCourse($courseId);
            
            if ($course) {
                var_dump($_SESSION["user"]['id_user']);
                require 'views/course_details.php';
            } else {
                header('Location: index.php');
            }
        } else {
            header('Location: index.php');
        }
        break;
    case 'enroll':
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') {
            $student = $userFactory->createUser('student', $_SESSION['user']);
            $courseId = $_GET['id'] ?? null;
            if ($courseId) {
                $course = $courseFactory->getCourse($courseId);
                if ($course){
                    $course->enroll($student->getId());
                    header('Location: index.php?action=course&id=' . $courseId);
                } else {
                    header('Location: index.php');
                }
            } else {
                header('Location: index.php');
            }
        } else {
            header('Location: index.php?action=login');
        }
        break;
    case 'my_courses':

        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') {
            $student = $userFactory->createUser('student', $_SESSION['user']);
            $enrolledCourses = $student->getSpecificData();
            require 'views/student/my_courses.php';
        } else {
            header('Location: index.php?action=login');
        }
        break;
    case 'add_course':
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'teacher') {
            $teacher = $userFactory->createUser('teacher', $_SESSION['user']);
            $categories = $categoryManager->listcategory();
            $tags = $tagManager->listTags();
            echo '<pre>';
            foreach ($categories as $cat) {
                var_dump($cat->getId());
                # code...
            }
            echo '</pre>';
            echo $_SESSION['user']['status'];
            if($_SESSION['user']['status']!='ACCEPTED'){
                require_once("views/teacher/waiting.php");
            }elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $course = $courseFactory->createCourse($_POST['content_type'],$_POST);
               $id_course = $course->create($_POST);
               
               $tags = $_POST["selected_tags"];
               $tags = explode(',', $tags); 
               foreach ($tags as $id_tag ) {
                    $course_tag->create($id_course["id"],$id_tag);
                }
                header('Location: index.php?action=teacher_dashboard');
            } else {
                    require 'views/teacher/add_course.php';
            }
        } else {
            header('Location: index.php?action=login');
        }
        break;
    case 'teacher_courses':
        echo "hhh";
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'teacher') {
            $teacher = $userFactory->createUser('teacher', $_SESSION['user']);
           $courses =  $teacher->getSpecificData();
           $categories = $categoryManager->listcategory();
           $tags = $tagManager->listTags();
            require_once('views/teacher/teacher_courses.php');
        } else {
            header('Location: index.php?action=login');
        }
        break;
    case 'add_category':
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
            $teacher = $userFactory->createUser('teacher', $_SESSION['user']);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'];
                $categoryManager->addCategory($name);
                header('Location: index.php?action=teacher_dashboard');
            } else {
                require 'views/teacher/add_categorie.php';
            }
        } else {
            header('Location: index.php?action=login');
        }
        break;
    case 'add_tag':
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
            $teacher = $userFactory->createUser('teacher', $_SESSION['user']);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'];
                $tagManager->addTag($name);
                header('Location: index.php?action=teacher_dashboard');
            } else {
                require 'views/add_tag.php';
            }
        } else {
            header('Location: index.php?action=login');
        }
        break;
    case 'teacher_dashboard':
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'teacher') {
            $teacher = $userFactory->createUser('teacher', $_SESSION['user']);
            $teacherCourses = $teacher->getSpecificData();
            $statistics = $teacherManager->getGlobalStatistics($teacher->getId());
            $enrolledUsers = $statistics['students'] ;
            $course = $statistics['mostPopularCourse'] ;
            echo "<br>";
            var_dump($course->getCategory());
            $obj = $courseFactory->getCourse($id);
            require 'views/teacher/teacher_dashboard.php';
        } else {
            header('Location: index.php?action=login');
        }
        break;
        case 'get_course_members':
            if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'teacher') {
                $course_id = $_GET["course_id"];
                $members = $teacherManager->getCourseMembersByCourseId($course_id); // Fixed variable name
                $membresArray = [];
                foreach ($members as $membre) {
                    $membresArray[] = [
                        count($membresArray) => [ // Use array count instead of separate counter
                            'id' => $membre->getId(),
                            'name' => $membre->getUsername(),
                            'email' => $membre->getEmail()
                        ]
                    ];
                }
                
                $courseData = [
                    'Membres' => $membresArray
                ];
                
                header('Content-Type: application/json');
                echo json_encode($courseData);
                exit();
            } else {
                header('Location: index.php?action=login');
                exit(); // Added exit after redirect

        }
        break;
    case 'admin_dashboard':
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
            $admin = $userFactory->createUser('admin', $_SESSION['user']);
            $statistics = $admin->getSpecificData();
            $categories = $categoryManager->listcategory();
            $tags = $tagManager->listTags();
            $listUsers = $admin->getAll();
            $pendinCourses = $adminManager->getPendingCourses();
            $globalStatistics = $adminManager->getGlobalStatistics();
            $listTeachers = $userFactory->getAllTeachers();
            require 'views/admin/admin_dashboard.php';
        } else {
            header('Location: index.php?action=login');
        }
        break;
    case 'courses':
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
            $admin = $userFactory->createUser('admin', $_SESSION['user']);
           
            require 'views/courses.php';
        } else {
            header('Location: index.php?action=login');
        }
        break;
    case 'listUsers':
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
            $admin = $userFactory->createUser('admin', $_SESSION['user']);
            $listUsers = $admin->getAll();
            require 'views/admin/listUsers.php';
        } else {
            header('Location: index.php?action=login');
        }
        break;
        
            case "delete":
                case "acceptCourse":
                case "banCourse":
            if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
                $courseId = $_GET['id'];
                $adminManager->manageCourse($courseId,$action);
                header("index.php?action=admin_dashboard");
            } else {
                header('Location: index.php?action=login');
            }
            break;
            case "delete":
                case "accept":
                case "suspend":
            if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
                $userId = $_GET['id_user'];
                $adminManager->manageUser($userId,$action);
                header("index.php?action=admin_dashboard");
            } else {
                header('Location: index.php?action=login');
            }
            break;
            
        
    
  
    default:
        require 'views/404.php';
        break;
}

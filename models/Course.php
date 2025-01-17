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
}
<?php
require_once 'models/categories.php';
require_once 'config/Database.php';

class CategoriesManager {
    private $category;
    private $db;
    public function __construct() {
        $db = Database::getInstance()->getConnection();
        $this->category = new category($db,null,null);
    }

    public function listcategory() {
        $data =  $this->category->getAll();
        $listCategories = [];
        $i = 0;
        foreach ($data as $category) {
        $listCategories[$i] = new Category($this->db,$category['id_categorie'],$category['name_categorie']);
        $i ++;
        }
        return $listCategories;
    }
    public function addCategory($name) {
        return $this->category->create(['name' => $name]);
    }
}


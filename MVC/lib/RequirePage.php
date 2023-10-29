<?php

class RequirePage {
    static public function model($page) {
        return require_once 'model/' . $page . '.php';
    }
    
    static public function library($page) {
        return require_once 'lib/' . $page . '.php';
    }
    
    static public function redirect($page) {
        header("location:" . ROOT . $page);
    }
}
?>
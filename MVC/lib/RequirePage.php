<?php

class RequirePage {
    static public function model($page) {
        return require_once 'model/' . $page . '.php';
    }

    static public function getter($page) {
        return require_once 'getter/' . $page . '.php';
    }
    
    static public function library($page) {
        return require_once 'lib/' . $page . '.php';
    }
    
    static public function redirect($page) {
        header("location:" . ROOT . $page);
    }

    static public function jsScript($script) {
        ?>
        <script type="module" src="<?= ROOT ?>assets/script/class/<?= $script ?>.js"></script>
        <?php
    }
}
?>
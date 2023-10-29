<?php
RequirePage::model("Stamp");
RequirePage::model("User");
RequirePage::model("Customer");
RequirePage::model("Aspect");
RequirePage::model("Category");
RequirePage::model("StampCategory");
RequirePage::model("StampArchive");


class ControllerStamp implements Controller {

    /**
     * afficher l'index
     */
    public function index() {
        $stamp = new Stamp;
        $data["stamps"] = $stamp->read();

        Twig::render("stamp/index.php", $data);
    }

    /**
     * afficher le formulaire créer
     */
    public function create() {
        checkSession::sessionAuth();

        $aspect = new Aspect;
        $data["aspects"] = $aspect->read();

        $category = new Category;
        $data["categories"] = $category->read();

        $customer = new Customer;
        $data["customers"] = $customer->read();

        Twig::render("stamp/create.php", $data);
    }

    /**
     * supprimer les entrées de la table stamp_category associé à la clé($stamp_id) et supprimer l'entrée
     */
    public function delete() {
        if($_SERVER["REQUEST_METHOD"] != "POST") {
            requirePage::redirect("error");
            exit();
        } 

        $stamp_id = $_POST["id"];

        $stampCategories = new StampCategory;
        $stampCategories->deleteStampCat($stamp_id);

        $stamp = new Stamp;
        $deletedStamp = $stamp->readId($stamp_id);

        $stampArchive = new StampArchive;
        $stampArchive->create($deletedStamp);

        $stamp->delete($stamp_id);

        RequirePage::redirect("customer/profile");
    }

    /**
     * afficher le formulaire mettre à jour
     */
    public function edit() {
        if(isset($_SESSION["fingerPrint"])) $data["session_user"] = $_SESSION;

        if(!$_POST){
            RequirePage::redirect("error");
            exit();
        }
        $id = $_POST["id"];
        $stamp = new stamp; 

        $aspect = new Aspect;
        $data["aspects"] = $aspect->read();

        $category = new Category;
        $data["categories"] = $category->read();

        $customer = new Customer;
        $data["customers"] = $customer->read();

        $data["stamp"] = $stamp->readId($id);
        $stampCategories = new StampCategory;
        if($stampCategories->readStampCat($data["stamp"]["id"])) {
            $readStampCategories = $stampCategories->readStampCat($data["stamp"]["id"]);

            foreach($readStampCategories as $stampCategory) {
                $category = new Category;
                $data["stamp_categories"][] = $category->readId($stampCategory["category_id"]);
            }

            /* boucler sur les categories correspondantes et les "check" */
            foreach ($data["categories"] as &$category) {
                foreach ($data["stamp_categories"] as $stamp_category) {
                    if($stamp_category["category"] == $category["category"]) $category["checked"] = true;
                }
            }
        }
        /* boucler sur les aspects et "selected" le correspondant */
        foreach ($data["aspects"] as &$aspect) {
            if($data["stamp"]["aspect_id"] == $aspect["id"]) $aspect["selected"] = true;
        }
        Twig::render("stamp/edit.php", $data);
    }

    /**
     * afficher un timbre
     */
    public function show($id) {
        $categories = [];
        $stamp = new Stamp;
        $readStamp = $stamp->readId($id);
        $data["stamp"] = $readStamp;


        if(isset($readStamp["aspect_id"])){
            $aspect = new Aspect;
            $data["aspect"] = $aspect->readId($readStamp["aspect_id"]);
        }
        
        $stampCategories = new StampCategory;
        if($stampCategories->readStampCat($readStamp["id"])) {
            $readStampCategories = $stampCategories->readStampCat($readStamp["id"]);
            foreach($readStampCategories as $stampCategory) {
                $category = new Category;
                $data["categories"][] = $category->readId($stampCategory["category_id"]);
            }
        }
        Twig::render("stamp/show.php", $data);
    }

    /**
     * enregistrer une entrée dans la DB
     */
    public function store() {
        if($_SERVER["REQUEST_METHOD"] != "POST") requirePage::redirect("error");

        RequirePage::library("Validation");
        $val = new Validation;

        //image validation
        if(!empty($_FILES["image_link"]["name"])) {
            if($_FILES["image_link"]["error"] == 1) $val->errors["image_link"] = "L'image est trop grande, svp vous limitez à 2MB";
            elseif($_FILES["image_link"]["size"] == 0) $val->errors["image_link"] = "L'image n'est pas valide";
            elseif(strlen($_FILES["image_link"]["name"]) > 200) $val->errors["image_link"] = "Le nom est trop grand";
            else {
                $target_dir = "assets/image/";
                $target_file = $target_dir . basename($_FILES["image_link"]["name"]);
                move_uploaded_file($_FILES["image_link"]["tmp_name"], $target_file);
                $_POST["image_link"] = $_FILES["image_link"]["name"];
            }
        }

        //all other fields validation

        $result = $this->validate();

        if($result->isSuccess()) {
            $stamp = new Stamp;
            $stamp_id = $stamp->create($_POST);
    
            /*enregistrer les entrées liées à la table category et stamp_category */
            if(isset($_POST["new_categories"])) {
                foreach($_POST["new_categories"] as $new_category) {
                    if($new_category != "") {
                        $data["category"] = $new_category;
    
                        $category = new Category;
                        $category_id = $category->create($data);
    
                        /*conversion de la valeur en clé, poussé dans le $_POST, utile car les autres champs recueillis sont booléens, voir plus bas */
                        $_POST["category_id"][$category_id] = 1;
                    }
                }
            }
            if(isset($_POST["category_id"])) {
                foreach($_POST["category_id"] as $category_id => $category) {
                    $stampCategory = new StampCategory;
                    $stampCategory->create([ "stamp_id" => $stamp_id, "category_id" => $category_id]);
                }
            }
            RequirePage::redirect('stamp/show/'. $stamp_id);

        } else {
            $aspect = new Aspect;
            $data["aspects"] = $aspect->read();
    
            $category = new Category;
            $data["categories"] = $category->read();
    
            $customer = new Customer;
            $data["customers"] = $customer->read();

            $data["stamp"] = $_POST;
            $data["errors"] = $result->getErrors();

            Twig::render("stamp/create.php", $data);
        } 
    }

    /**
     * mettre à jour les entrées
     */
    public function update() {
        if(!$_POST){
            RequirePage::redirect("error");
            exit();
        }
        $result = $this->validate();

        if($result->isSuccess()) {
            $stamp_id = $_POST["id"];
            $stampCategories = new StampCategory;
            $stampCategories->deleteStampCat($stamp_id);
    
    
            /*enregistrer les entrées liées à la table category et stamp_category */
            if(isset($_POST["new_categories"])) {
                foreach($_POST["new_categories"] as $category) {
                    if($category != "") {
                        $data["category"] = $category;
    
                        $category = new Category;
                        $category_id = $category->create($data);
    
                        $_POST["category_id"][$category_id] = 1;
                    }
                }
            }
            if(isset($_POST["category_id"])){
                foreach($_POST["category_id"] as $category_id => $category){
                    $stampCategory = new StampCategory;
                    $stampCategory->create([ "stamp_id" => $stamp_id, "category_id" => $category_id]);
                }
            }
            $stamp = new stamp;
            $_POST["year"] = intval($_POST["year"]);
            $updatedId = $stamp->update($_POST);
            RequirePage::redirect("stamp/show/$updatedId");
        } else {
            $aspect = new Aspect;
            $data["aspects"] = $aspect->read();
    
            $category = new Category;
            $data["categories"] = $category->read();
    
            $customer = new Customer;
            $data["customers"] = $customer->read();

            $data["stamp"] = $_POST;
            $data["errors"] = $result->getErrors();

            Twig::render("stamp/edit.php", $data);
        } 
    }

    /**
     * valider les entrées
     */
    private function validate() {
        RequirePage::library("Validation");
        $val = new Validation;

        $_POST["year"] = intval($_POST["year"]);
        $currentYear = date("Y");

        extract($_POST);
        $val->name("name")->value($name)->min(4)->max(45)->required();
        $val->name("description")->value($description)->max(300);
        $val->name("origin")->value($origin)->max(45)->pattern("alpha");
        if($year != 0) $val->name("year")->value($year)->pattern("year")->min(1840)->max($currentYear);
        foreach($new_categories as $index => $new_category) {
           $val->name("categories_$index")->value($new_category)->max(45);
           $category = new Category;
           $where["target"] = "category";
           $where["value"] = $new_category;
           $exist = $category->ReadWhere($where);
           if($exist) $val->errors["categories_$index"] = "category already exists";
        }
        return $val;
    }

}
<?php
RequirePage::model("Enchere");
RequirePage::model("Mise");
RequirePage::model("Timbre");
RequirePage::model("Image");



class ControllerEnchere implements Controller {

    public function index() {
        $enchere = new Enchere;
        $data["encheres"] = $enchere->read();

        if($data["encheres"]) {
            foreach($data["encheres"] as &$enchere) {
                $model = new Enchere;
                $model->getAll($enchere);
            }
        }
        Twig::render("enchere/index.html", $data);
    }

    public function show() {
        if($_SERVER["REQUEST_METHOD"] != "GET"){
            requirePage::redirect("error");
            exit();
        } 
        $id = $_GET["id"];
        $enchere = new Enchere;
        $data["enchere"] = $enchere->readId($id);
        $enchere->getAll($data["enchere"]);

        $data["suggere"] = array_slice($enchere->read(), 0, 4);
        foreach($data["suggere"] as &$enchere) {
            $model = new Enchere;
            $model->getAll($enchere);
        }
        Twig::render("enchere/show.html", $data);
    }

    public function create() {
        $condition = new Condition;
        $data["conditions"] = $condition->read();
        $data["time"] = date("h:i");
        
        Twig::render("enchere/create.html", $data);
    }

    public function modify() {
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            requirePage::redirect("error");
            exit();
        } 
        $condition = new Condition;
        $data["conditions"] = $condition->read();

        $id = $_POST["enchere_id"];
        $enchere = new Enchere;
        $data["enchere"] = $enchere->readId($id);
        $enchere->getAll($data["enchere"]);
        $data["enchere"]["timbre"]["date_creation"] = $data["enchere"]["timbre"][2];
        Twig::render("enchere/modify.html", $data);
    }

    public function update() {
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            requirePage::redirect("error");
            exit();
        } 
        $_POST["enchere"]["membre_id"] = $_POST["membre_id"];
        $_POST["timbre"]["membre_id"] = $_POST["membre_id"];

        $result = $this->validate();

        if($result->isSuccess()) {

            $where["target"] = "timbre_id";
            $where["value"] = $_POST["timbre_id"];
            $image = new Image;
            $images = $image->readWhere($where);
            if($images) {
                foreach($images as $item) { 
                    $dataIm["principale"] = 0;
                    $dataIm["id"] = $item["id"];
                    $image = new Image;
                    $image->update($dataIm);
                }
                $image = new Image;
                $data["principale"] = 1;
                $data["id"] = $_POST["image_princ"];
                $image->update($data);
            }
            RequirePage::redirect("membre/profil");

        } else {
            $condition = new Condition;
            $data["conditions"] = $condition->read();
            $data["timbre"] = $_POST["timbre"];
            $data["enchere"] = $_POST["enchere"];
            $data["errors"] = $result->getErrors();
            Twig::render("enchere/create.html", $data);
        }
    }

    /**
     * enregistrer une entrée dans la DB
     */
    public function store() {
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            requirePage::redirect("error");
            exit();
        } 

        $_POST["enchere"]["membre_id"] = $_POST["membre_id"];
        $_POST["timbre"]["membre_id"] = $_POST["membre_id"];

        $result = $this->validate();

        if($result->isSuccess()) {
            
            //créer enchère
            $enchere = new Enchere;
            $enchereId = $enchere->create($_POST["enchere"]);

            //créer timbre -> can loop thru later in project
            $timbre = new Timbre;
            $_POST["timbre"]["enchere_id"] = $enchereId;

            $timbreId = $timbre->create($_POST["timbre"]);

            foreach($_FILES["images"]["name"] as $index => $name) {
                if($name) {
                    if($index == 0) $data["principale"] = 1;
                    else $data["principale"] = 0;
                    $data["timbre_id"] = $timbreId;
                    $data["image_link"] = $name;
                    $image = new Image;
                    $image->create($data);
                }
            }
            for ($i=0; $i < count($_FILES["images"]["name"]); $i++) { 
                $target_dir = "assets/img/public/";
                $target_file = $target_dir . basename($_FILES["images"]["name"][$i]);
                move_uploaded_file($_FILES["images"]["tmp_name"][$i], $target_file);
            }
            RequirePage::redirect("membre/profil");

        } else {
            $condition = new Condition;
            $data["conditions"] = $condition->read();
            $data["timbre"] = $_POST["timbre"];
            $data["enchere"] = $_POST["enchere"];
            $data["errors"] = $result->getErrors();
            Twig::render("enchere/create.html", $data);
        }
    }

    public function delete() {
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            requirePage::redirect("error");
            exit();
        } 
        $enchereId = $_POST["enchere_id"];
        $where["target"] = "enchere_id";
        $where["value"] = $enchereId;

        $timbre = new Timbre;
        $timbres = $timbre->readWhere($where);
        foreach($timbres as $item) {
            $whereT["target"] = "timbre_id";
            $whereT["value"] = $item["id"];
            $image = new Image;
            $image->deleteWhere($whereT);
        }
        $timbre->deleteWhere($where);

        $mise = new Mise;
        $mise->deleteWhere($where);

        $enchere = new Enchere;
        $enchere->delete($enchereId);

        RequirePage::redirect("membre/profil");
    }

    /**
     * valider les entrées
     */
    private function validate() {
        RequirePage::library("Validation");
        $val = new Validation;

        extract($_POST);

        if($_FILES) {
            foreach($_FILES["images"]["error"] as $error) {
                if($error == 1) $val->errors["images"] = "une de vos photos est trop large, max 2MB";
            } 
        }

        if($enchere["nom_enchere"]) $val->name("nom_enchere")->value($enchere["nom_enchere"])
            ->min(4)->max(45);

        $val->name("date_debut")->value($enchere["date_debut"])
            ->datePast(date("Y-m-d"))->required();

        $val->name("date_fin")->value($enchere["date_fin"])
            ->datePast($enchere["date_debut"])->required();

        $val->name("prix_plancher")->value(floatval($enchere["prix_plancher"]))
            ->min(10)->required();
        
        $val->name("nom_timbre")->value($timbre["nom_timbre"])
            ->min(4)->max(45)->required();

        $val->name("date_creation")->value($timbre["date_creation"])
            ->datePast("1840-01-01")->dateFuture(date("Y-m-d"))->required();

        $val->name("pays_origine")->value($timbre["pays_origine"])
            ->min(3)->required();

        if($timbre["tirage"]) $val->name("tirage")->value($timbre["tirage"])
            ->min(3)->max(45);

        if($timbre["dimensions"]) $val->name("dimensions")->value($timbre["dimensions"])
            ->min(5)->max(45);

        return $val;
    }

}
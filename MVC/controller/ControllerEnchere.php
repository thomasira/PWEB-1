<?php
RequirePage::model("Enchere");
RequirePage::model("Mise");
RequirePage::model("Timbre");
RequirePage::model("Image");
RequirePage::model("Condition");
RequirePage::library("DataFiller");

class ControllerEnchere implements Controller {

    public function index() {
        $data = [];
        if(isset($_SESSION["id"])) $membreId = $_SESSION["id"];
        else $membreId = false;
        $enchere = new Enchere;

        /* Définir l'ordre d'affichages des enchères->défaut par date */

        $order = "date_fin";
        $data["order"] = "date";
        
        if(isset($_GET["status"]) && $_GET["status"] == "a_venir") {
            $order = "date_debut";
        } 

        $data["encheres"] = $enchere->read($order);

        if($data["encheres"]) {
            $enchereFiltered = [];
            foreach($data["encheres"] as &$enchere) {
                if($enchere["membre_id"] != $membreId) {
                    DataFiller::getDataEnchere($enchere);
                    DataFiller::dateSimplify($enchere["timbre"]["date_creation"]); 
                    if(isset($_SESSION["id"])) {
                        DataFiller::checkFavori($enchere);
                        DataFiller::checkMeneur($enchere);
                    }
                    $enchereFiltered[] = $enchere;
                }
            }

            /* Définir le premier filtrage-> filtrer par status temporel */
            function testFunc($enchere) {
                if(isset($_GET["status"])) {
                    if($_GET["status"] == "tous") return $enchere;
                    else $status = $_GET["status"];
                } else $status = "en_cours";
                if($enchere["status"] == $status) return $enchere; 
            }
            if($enchereFiltered) {
                $enchereFiltered = array_filter($enchereFiltered, "testFunc");
            }
            

        }
        if(isset($_GET["status"])) $data["status"] = $_GET["status"];
        else $data["status"] = "en_cours";



        /* Définir filtrage par ordre */
        if(isset($_GET["order"])) {
            usort($enchereFiltered, function($a, $b) {
                $order = $_GET["order"];
                if ($a[$order] > $b[$order]) {
                    return -1;
                } elseif ($a[$order] < $b[$order]) {
                    return 1; 
                }
                return 0;
            });
            $data["order"] = $_GET["order"];
        }

        $data["encheres"] = $enchereFiltered;



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
        DataFiller::getDataEnchere($data["enchere"]);
        DataFiller::dateSimplify($data["enchere"]["timbre"]["date_creation"]);
        
        $data["suggere"] = array_slice($enchere->read(), 0, 4);
        foreach($data["suggere"] as &$enchere) {
            DataFiller::getDataEnchere($enchere);
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
        $id = $_POST["enchere_id"];
        $enchere = new Enchere;
        $data["enchere"] = $enchere->readId($id);
        $condition = new Condition;
        $data["conditions"] = $condition->read();
        DataFiller::getDataEnchere($data["enchere"]);
        Twig::render("enchere/modify.html", $data);
    }

    public function update() {
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            requirePage::redirect("error");
            exit();
        } 
        $_POST["enchere"]["membre_id"] = $_POST["membre_id"];
        $_POST["timbre"]["membre_id"] = $_POST["membre_id"];

        if($_POST["enchere"]["status"] == "a_venir") $aVenir = true;
        else $aVenir = false;

        $result = $this->validate($aVenir);

        if($result->isSuccess()) {

            $where["target"] = "timbre_id";
            $where["value"] = $_POST["timbre"]["id"];
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
            $timbre = new Timbre;
            $timbre->update($_POST["timbre"]);
            $enchere = new Enchere;
            $enchere->update($_POST["enchere"]);
            RequirePage::redirect("membre/profil");
        } else {
            $condition = new Condition;
            $data["conditions"] = $condition->read();
            $data["enchere"] = $_POST["enchere"];
            $data["enchere"]["timbre"] = $_POST["timbre"];
            DataFiller::getImages($data["enchere"]);
            $data["errors"] = $result->getErrors();
            Twig::render("enchere/modify.html", $data);
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
    private function validate($aVenir = true) {
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

        if($aVenir) $val->name("date_debut")->value($enchere["date_debut"])
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
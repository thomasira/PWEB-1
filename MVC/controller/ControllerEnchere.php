<?php
RequirePage::model("Enchere");
RequirePage::model("Timbre");
RequirePage::model("Image");
RequirePage::model("Mise");
RequirePage::model("Condition");

class ControllerEnchere implements Controller {

    /**
     * rediriger vers l'index de customer
     */
    public function index() {
        $enchere = new Enchere;
        $data["encheres"] = $enchere->read();

        if($data["encheres"]) {
            foreach($data["encheres"] as &$enchere) {

                /* chercher la derniere mise et le nbr de mises*/
                $mise = new Mise;
                $where["target"] = "enchere_id";
                $where["value"] = $enchere["id"];
                $what = "montant";
                $maxMise = $mise->readMax($what, $where);
                $nbrMises = $mise->readCount($what, $where);

                $enchere["nbr_mise"] = $nbrMises[0];
                if(empty($maxMise[0])) $enchere["max_mise"] = $enchere["prix_plancher"];
                else $enchere["max_mise"] = $maxMise[0];
                    
                /* chercher le/les timbres */
                $timbre = new Timbre;
                $where["target"] = "enchere_id";
                $where["value"] = $enchere["id"];
                $encheresTimbres = $timbre->readWhere($where);
                $enchere["timbre"] = $encheresTimbres[0];
                $enchere["timbre"]["date_creation"] = explode('-', $enchere["timbre"]["date_creation"])[0];

                $condition = new Condition;
                $enchere["timbre"]["condition"] = $condition->readId($enchere["timbre"]["condition_id"]);
                    
                /* chercher la premiere image associée du premier timbre */
                $image = new Image;
                $enchere["image"] = $image->readId($enchere["timbre"]["id"]);
            }
        }
        Twig::render("enchere/index.html", $data);
    }

    public function show() {
        $enchere = new Enchere;
        $data["encheres"] = $enchere->read();

    }

    public function create() {
        $condition = new Condition;
        $data["conditions"] = $condition->read();
        
        Twig::render("enchere/create.html", $data);
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

            foreach($_FILES["images"]["name"] as $name) {
                $data["timbre_id"] = $timbreId;
                $data["image_link"] = $name;
                $image = new Image;
                $image->create($data);
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


    /**
     * valider les entrées
     */
    private function validate() {
        RequirePage::library("Validation");
        $val = new Validation;

        extract($_POST);

        foreach($_FILES["images"]["error"] as $error) {
            if($error == 1) $val->errors["images"] = "une de vos photos est trop large, max 2MB";
        } 

        $val->name("nom_enchere")->value($enchere["nom_enchere"])
            ->min(4)->max(45)->required();

        $val->name("date_debut")->value($enchere["date_debut"])
            ->datePast(date("Y-m-d"))->required();

        $val->name("date_fin")->value($enchere["date_fin"])
            ->datePast($enchere["date_debut"])->required();

        $val->name("prix_plancher")->value(floatval($enchere["prix_plancher"]))
            ->min(10)->required();
        

        $val->name("nom_timbre")->value($timbre["nom_timbre"])
            ->min(4)->max(45)->required();

        $val->name("date_creation")->value($timbre["date_creation"])
            ->datePast("1840-01-01")->required();

        $val->name("pays_origine")->value($timbre["pays_origine"])
            ->min(3)->required();

        if($timbre["tirage"]) $val->name("tirage")->value($timbre["tirage"])
            ->min(3)->max(45);

        if($timbre["dimensions"]) $val->name("dimensions")->value($timbre["dimensions"])
            ->min(5)->max(45);

        return $val;
    }

}
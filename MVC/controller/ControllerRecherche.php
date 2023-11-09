<?php
RequirePage::model("Enchere");
RequirePage::model("Membre");
RequirePage::model("Timbre");
RequirePage::library("DataFiller");

class ControllerRecherche {

    public function index() {

        if(!isset($_GET["recherche"])){
            RequirePage::redirect("error");
            die();
        } 
        if($_GET["recherche"] == "") header("location:". $_SERVER["HTTP_REFERER"]);

        $data["item_recherche"] = $_GET["recherche"];

        $enchere = new Enchere;
        $where["target"] = "nom_enchere";
        $where["value"] = $data["item_recherche"];

        $data["encheres_noms"] = $enchere->readWhere($where);
        if($data["encheres_noms"]) {
            foreach($data["encheres_noms"] as &$enchereN) {
                DataFiller::getDataEnchere($enchereN);
            }
        }

        $where["target"] = "id";
        $where["value"] = $data["item_recherche"];
        $data["encheres_ids"] = $enchere->readWhere($where);

        if($data["encheres_ids"]) {
            foreach($data["encheres_ids"] as &$enchereI) {
                DataFiller::getDataEnchere($enchereI);
            }
        }

        $timbre = new Timbre;
        $where["target"] = "nom_timbre";
        $where["value"] = $data["item_recherche"];
        $timbres = $timbre->readWhere($where);
        if($timbres) {
            foreach($timbres as $timbre) {
                $enchere = new Enchere;
                $enchere = $enchere->readId($timbre["enchere_id"]);
                DataFiller::getDataEnchere($enchere);
                $data["encheres_timbres_noms"][] = $enchere;
            }
        }
        $membre = new Membre;
        $where["target"] = "nom_membre";
        $where["value"] = $data["item_recherche"];
        $data["membres_noms"] = $membre->readWhere($where);

        if(empty($data["membres_noms"]) && empty($data["encheres_noms"]) 
        && empty($data["encheres_ids"]) && empty($data["encheres_timbres_noms"])) $data["empty"] = true;
        Twig::render("recherche/index.html", $data);
    }
}

?>
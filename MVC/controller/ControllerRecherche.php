<?php
RequirePage::model("Enchere");
RequirePage::model("Membre");
RequirePage::model("Timbre");

class ControllerRecherche {

    public function index() {
        $data["item_recherche"] = $_POST["recherche"];


        $enchere = new Enchere;
        $where["target"] = "nom_enchere";
        $where["value"] = $data["item_recherche"];
        $data["encheres_noms"] = $enchere->readWhere($where);
        $where["target"] = "id";
        $where["value"] = $data["item_recherche"];
        $data["encheres_ids"] = $enchere->readWhere($where);

        $timbre = new Timbre;
        $where["target"] = "nom_timbre";
        $where["value"] = $data["item_recherche"];
        $data["timbres_noms"] = $timbre->readWhere($where);
        $where["target"] = "id";
        $where["value"] = $data["item_recherche"];
        $data["timbres_ids"] = $timbre->readWhere($where);

        $membre = new Membre;
        $where["target"] = "nom_membre";
        $where["value"] = $data["item_recherche"];
        $data["membre_noms"] = $membre->readWhere($where);

        print_r($data);
        Twig::render("recherche/index.html", $data);
    }
}

?>
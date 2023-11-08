<?php
RequirePage::model("Favori");

class ControllerFavori {

    public function index() {
        RequirePage::redirect("home");
    }

    public function addFavorite() {
        $favori = new Favori;
        $data["enchere_id"] = $_GET["enchereId"];
        $data["membre_id"] = $_SESSION["id"];
        $favori->create($data);
        RequirePage::redirect("enchere");
    }

    public function deleteFavorite() {
        $favori = new Favori;
        $data["enchere_id"] = $_GET["enchereId"];
        $data["membre_id"] = $_SESSION["id"];
        $favori->delete($data);
        RequirePage::redirect("enchere");
    }
}
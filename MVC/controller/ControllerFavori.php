<?php
RequirePage::model("Favori");

class ControllerFavori {

    public function index() {
        RequirePage::redirect("home");
    }

    public function addFavorite() {
        CheckSession::sessionAuth();
        $favori = new Favori;
        $data["enchere_id"] = $_GET["enchereId"];
        $data["membre_id"] = $_SESSION["id"];
        $favori->create($data);
        header("location:". $_SERVER["HTTP_REFERER"]);
    }

    public function deleteFavorite() {
        CheckSession::sessionAuth();

        $favori = new Favori;
        $data["enchere_id"] = $_GET["enchereId"];
        $data["membre_id"] = $_SESSION["id"];
        $favori->delete($data);
        header("location:". $_SERVER["HTTP_REFERER"]);
    }
}
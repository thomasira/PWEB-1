<?php
RequirePage::model("Mise");
RequirePage::model("Enchere");
RequirePage::model("Membre");

class ControllerMise {

    public function index() {
        CheckSession::sessionAuth();
        RequirePage::jsScript("Miser");
    }

    public function create() {
        CheckSession::sessionAuth();
        Twig::render("home.html");
        RequirePage::jsScript("Miser");
    }
}

?>
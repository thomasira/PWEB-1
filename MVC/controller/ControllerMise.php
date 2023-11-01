<?php
RequirePage::model("Mise");
RequirePage::model("Enchere");
RequirePage::model("Membre");

class ControllerMise {

    public function create() {
        CheckSession::sessionAuth();
        Twig::render("mise/create.html");
    }
}

?>
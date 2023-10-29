<?php
RequirePage::model("Stamp");

class ControllerHome implements Controller {

    /**
     * afficher l'index
     */
    public function index() {
        $stamp = new Stamp;
        $data["stamps"] = $stamp->read();
        Twig::render("home.html", $data);
    }

    /**
     * afficher page erreur
     */
    public function error() {
        Twig::render("error.php");
    }
}
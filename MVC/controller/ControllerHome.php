<?php

class ControllerHome implements Controller {

    /**
     * afficher l'index
     */
    public function index() {
        Twig::render("home.html");
    }

    /**
     * afficher page erreur
     */
    public function error() {
        Twig::render("error.php");
    }
}
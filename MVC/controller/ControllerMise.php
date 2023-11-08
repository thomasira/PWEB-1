<?php
RequirePage::model("Mise");

class ControllerMise {

    public function index() {
        RequirePage::redirect("home");
    }

    public function auth() {
        if($_SERVER["REQUEST_METHOD"] != "POST") requirePage::redirect("error");
        if($_SESSION["id"] == $_POST["enchere_membre_id"]) {
            requirePage::redirect("error");
            exit();
        }
        CheckSession::sessionAuth();
        $result = $this->validate();

        if($result->isSuccess()) {
            $_POST["membre_id"] = $_SESSION["id"];
            $_POST["date_mise"] = date("Y-m-d h:i:s");
            $mise = new Mise;
            $mise->create($_POST);
        }
        header("location:". $_SERVER['HTTP_REFERER']);
    }

    private function validate() {
        RequirePage::library("Validation");
        $val = new Validation;

        extract($_POST);
        $val->name("montant")->value(floatval($montant))->min(floatval($montant_min))->required();
        return $val;
    }

}

?>
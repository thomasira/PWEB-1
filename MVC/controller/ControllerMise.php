<?php
RequirePage::model("Mise");

class ControllerMise {

    public function index() {
        RequirePage::redirect("home");
    }

    public function auth() {
        if($_SERVER["REQUEST_METHOD"] != "POST") requirePage::redirect("error");
        CheckSession::sessionAuth();

        $result = $this->validate();

        if($result->isSuccess()) {
            $_POST["membre_id"] = $_SESSION["id"];
            $_POST["date_mise"] = date("Y-m-d h:i:s");
            $mise = new Mise;

            print_r($_POST);
            $mise->create($_POST);
        }

        RequirePage::redirect("enchere");
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
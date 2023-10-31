<?php
RequirePage::model("Membre");
RequirePage::model("Enchere");
RequirePage::model("Timbre");
RequirePage::model("Image");


class ControllerMembre implements Controller {

    /**
     * rediriger vers l'index de customer
     */
    public function index() {
        RequirePage::redirect("customer");
    }

    public function create() {
        Twig::render("membre/create.html");
    }

    public function profil() {
        if(CheckSession::sessionAuth()) {
            $id = $_SESSION["id"];
            $membre = new Membre;
            $data["membre"] = $membre->readId($id);

            $enchere = new Enchere;
            $where["target"] = "membre_id";
            $where["value"] = $data["membre"]["id"];
            $data["encheres"] = $enchere->readWhere($where);

            if($data["encheres"]) {
                foreach($data["encheres"] as &$enchere) {
                    $timbre = new Timbre;
                    $where["target"] = "enchere_id";
                    $where["value"] = $enchere["id"];
                    $timbreData = $timbre->readWhere($where);
                     
                    $image = new Image;
                    $enchere["image"] = $image->readId($timbreData[0]["id"]);
                }
            }
            Twig::render("membre/profil.html", $data);
        };
    }

    /**
     * enregistrer une entrée dans la DB
     */
    public function store() {
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            requirePage::redirect("error");
            exit();
        } 

        $result = $this->validate();

        if($result->isSuccess()) {
            //vérifier si email existe dans la DB
            $membre = new Membre;
            $where["target"] = "email";
            $where["value"] = $_POST["email"];
            $exist = $membre->ReadWhere($where);
            if($exist) {
                $data["error"] = "ce email est déjà associé à un compte";
                if(isset($_SESSION["fingerprint"])) Twig::render("membre/create.html", $data);
                else Twig::render("membre/create.html", $data);
                exit();
            }
            
            //créer membre
            $Membre = new Membre;
            $salt = "7dh#9fj0K";
            $_POST["password"] = password_hash($_POST["password"] . $salt, PASSWORD_BCRYPT);
            $Membre->create($_POST);

            //message custom ou panel si la requête est faite à l'interne(employé seulement)
            $data["success"] = "YEAH! votre compte est créé. Connectez-vous pour continuer";
            Twig::render("login/index.html", $data);

        } else {
            $data["errors"] = $result->getErrors();
            $data["membre"] = $_POST;
            Twig::render("membre/create.html", $data);
        }
    }

    /**
     * valider les entrées
     */
    private function validate() {
        RequirePage::library("Validation");
        $val = new Validation;

        extract($_POST);
        $val->name("nom_membre")->value($nom_membre)->min(4)->max(45)->required();
        $val->name("email")->value($email)->pattern("email")->max(45)->required();
        $val->name("password")->value($password)->min(8)->max(20)->pattern("no_space")->required();

        return $val;
    }
}
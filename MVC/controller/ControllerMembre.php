<?php
RequirePage::model("Membre");


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
     * afficher le formulaire mettre à jour
     */
    public function edit() {
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            requirePage::redirect("error");
            exit();
        } 
        checkSession::sessionAuth();

        if($_SESSION["privilege_id"] < 2) $id = $_POST["id"];
        else $id = $_SESSION["id"];

        $user = new User;
        $data["user"] = $user->readId($id);
        Twig::render("user/edit.php", $data);
    }

    /**
     * mettre à jour une entrée dans la DB
     */
    public function update() {
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            requirePage::redirect("error");
            exit();
        } 
        $result = $this->validate();

        if($result->isSuccess()) {
            $user = new User;
            $updatedId = $user->update($_POST);
            if($updatedId) RequirePage::redirect("customer/profile");
            else print_r($updatedId);
        } else {
            $data["errors"] = $result->getErrors();
            $data["user"] = $_POST;

            Twig::render("user/edit.php", $data);
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
        if(isset($email)) $val->name("email")->value($email)->pattern("email")->max(45)->required();
        if(isset($password)) $val->name("password")->value($password)->min(8)->max(20)->pattern("no_space")->required();

        return $val;
    }

}
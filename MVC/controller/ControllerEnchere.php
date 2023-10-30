<?php
RequirePage::model("Enchere");
RequirePage::model("Timbre");
RequirePage::model("Condition");



class ControllerEnchere implements Controller {

    /**
     * rediriger vers l'index de customer
     */
    public function index() {
        RequirePage::redirect("customer");
    }

    public function create() {
        $condition = new Condition;
        $data["conditions"] = $condition->read();
        
        Twig::render("enchere/create.html", $data);
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

/*         echo '<pre>';
        print_r($_POST);
        die(); */
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

        if($_POST["enchere"]["date_debut"] > date("Y-m-d")) {
            print_r('okay');
        } else print_r("notokay");
        print_r($_POST["enchere"]["date_debut"]);
        print_r(date("Y-m-d"));
        die();
        extract($_POST);
        $val->name("nom_enchere")->value($enchere["nom_enchere"])->min(4)->max(45)->required();
        $val->name("date_debut")->value($enchere["date_debut"])->min(4)->max(45)->required();
        return $val;
    }

}
<?php
RequirePage::model("Membre");

class ControllerLogin implements Controller {

    /**
     * afficher l'index
     */
    public function index() {
        if(!isset($_SESSION["fingerprint"])) Twig::render("login/index.html");
        else RequirePage::redirect("membre/profil");
    }
 
    /**
     * authentifier la connexion
     */
    public function auth() {
        $membre = new Membre;
        $where["target"] = "email";
        $where["value"] = $_POST["email"];
        $readMembre = $membre->readWhere($where);

        if(!$readMembre) {
            $data["error"] = "ce compte n'existe pas";
            Twig::render("login/index.html", $data);
            exit();
        }
        $readMembre = $readMembre[0];
        $password = $_POST["password"];
        $dbPassword = $readMembre["password"];
        $salt = "7dh#9fj0K";

        if(password_verify($password.$salt, $dbPassword)) {
            session_regenerate_id();
            $_SESSION["id"] = $readMembre["id"];
            $_SESSION["name"] = $readMembre["name"];
            $_SESSION["fingerprint"] = md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']);
            $_SESSION["privilege_id"] = $readMembre["privilege_id"];
        } else {
            $data["error"] = "mot de pass incorrect";
            Twig::render("login/index.html", $data);
            exit();
        }
        RequirePage::redirect("membre/profil");
    }

    /**
     * détruire la session
     */
    public function logout() {
        session_destroy();
        RequirePage::redirect("");
    }
}

?>
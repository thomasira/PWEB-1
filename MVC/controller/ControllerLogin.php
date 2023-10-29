<?php
RequirePage::model("User");

class ControllerLogin implements Controller {

    /**
     * afficher l'index
     */
    public function index() {
        if(!isset($_SESSION["fingerprint"])) Twig::render("login/index.php");
        else RequirePage::redirect("error");
    }

    /**
     * authentifier la connexion
     */
    public function auth() {
        $user = new User;
        $where["target"] = "email";
        $where["value"] = $_POST["email"];
        $readUser = $user->readWhere($where);

        if(!$readUser) {
            $data["error"] = "no such account";
            Twig::render("login/index.php", $data);
            exit();
        }
        $readUser = $readUser[0];
        $password = $_POST["password"];
        $dbPassword = $readUser["password"];
        $salt = "7dh#9fj0K";

        if(password_verify($password.$salt, $dbPassword)) {
            session_regenerate_id();
            $_SESSION["id"] = $readUser["id"];
            $_SESSION["name"] = $readUser["name"];
            $_SESSION["fingerprint"] = md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']);
            $_SESSION["privilege_id"] = $readUser["privilege_id"];
        } else {
            $data["error"] = "password not correct";
            Twig::render("login/index.php", $data);
            exit();
        }
        if($_SESSION["privilege_id"] < 3) RequirePage::redirect("panel");
        else RequirePage::redirect("customer/profile");
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
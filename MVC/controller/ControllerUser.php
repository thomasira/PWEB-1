<?php
RequirePage::model("User");
RequirePage::model("Privilege");
RequirePage::model("Staff");
RequirePage::model("Stamp");
RequirePage::model("Customer");
RequirePage::model("StampCategory");
RequirePage::library("Mailer");

class ControllerUser implements Controller {

    /**
     * rediriger vers l'index de customer
     */
    public function index() {
        RequirePage::redirect("customer");
    }

    /**
     * enregistrer une entrée dans la DB
     */
    public function store() {
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            requirePage::redirect("error");
            exit();
        } 

        if($_POST["privilege_id"] < 3) $data["staff"] = true;
        else $data["customer"] = true;

        $result = $this->validate();

        if($result->isSuccess()) {
            //vérifier si email existe dans la DB
            $user = new User;
            $where["target"] = "email";
            $where["value"] = $_POST["email"];
            $exist = $user->ReadWhere($where);
            if($exist) {
                $data["error"] = "email already exists";
                if(isset($_SESSION["fingerprint"])) Twig::render("user/create.php", $data);
                else Twig::render("login/index.php", $data);
                exit();
            }
            
            // envoyer un email de bienvenue
            $mail = new Mailer;
            $welcome = $this->getMessage($_POST["name"]);
            $mail->sendMail($_POST["email"], $welcome);

            //créer utilisateur
            $user = new User;
            $salt = "7dh#9fj0K";
            $_POST["password"] = password_hash($_POST["password"] . $salt, PASSWORD_BCRYPT);
            $userId = $user->create($_POST);

            //créer employé
            if($_POST["privilege_id"] < 3) {
                $staff = new Staff;
                $_POST["user_id"] = $userId;
                $staff->create($_POST);
            }
            //créer customer
            if($_POST["privilege_id"] == 3) {
                $customer = new Customer;
                $_POST["user_id"] = $userId;
                $customer->create($_POST);
            }

            //message custom ou panel si la requête est faite à l'interne(employé seulement)
            $data["success"] = "account created, please log in";
            if(isset($_SESSION["fingerprint"])) RequirePage::redirect("panel");
            else Twig::render("login/index.php", $data);

        } else {
            $data["errors"] = $result->getErrors();
            $data["user"] = $_POST;

            if(isset($_SESSION["fingerprint"])) Twig::render("user/create.php", $data);
            else {
                Twig::render("login/index.php", $data);
            }
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
        $val->name("name")->value($name)->min(4)->max(45)->required();
        if(isset($email)) $val->name("email")->value($email)->pattern("email")->max(45)->required();
        if(isset($password)) $val->name("password")->value($password)->min(8)->max(20)->pattern("no_space")->required();
        $val->name("address")->value($address)->max(100);
        if(isset($nas)) $val->name("nas")->value($nas)->max(45)->required();

        return $val;
    }

    /**
     * message de bienvenue
     */
    private function getMessage($name) {
        return '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Welcome to Stamps.com</title>
        </head>
        <body>
            <header>
                <h1>Welcome '.$name.' to Stamps catalog</h1>
            </header>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae fuga veritatis quia, corporis eveniet accusantium, officia totam deleniti enim omnis est eaque necessitatibus et optio adipisci minus accusamus quasi quis.</p>
        </body>
        </html>
        ';
    }
}
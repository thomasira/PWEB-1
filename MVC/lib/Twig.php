<?php

class Twig {
    static public function render($template, $data = []) {
        $loader = new \Twig\Loader\FilesystemLoader("view");
        $twig = new \Twig\Environment($loader, array("auto_reload" => true/* , "cache" => false */)); /* uncomment on prod */

        if(isset($_SESSION["fingerprint"]) && 
        $_SESSION["fingerprint"] == md5($_SERVER["HTTP_USER_AGENT"] . $_SERVER["REMOTE_ADDR"])) {
            $guest = false;
        }
        else $guest = true;
        
        $twig->addGlobal("path", ROOT);
        $twig->addGlobal("session", $_SESSION);
        $twig->addGlobal("guest", $guest);
        $twig->addGlobal("date", date("Y-m-d"));


        $url = isset($_SERVER["PATH_INFO"]) ? explode("/", ltrim($_SERVER["PATH_INFO"], "/")) : "/";
        if ($url != "/") $head["title"] = $url[0];
        else $head["title"] = "home";
        if (isset($url[1])) $head["title"] .= " | ". $url[1];

        $header = $twig->load("templates/header.php");
        $footer = $twig->load("templates/footer.php");

        echo $twig->render($header, $head);
        echo $twig->render($template, $data);
        echo $twig->render($footer);
    }
}